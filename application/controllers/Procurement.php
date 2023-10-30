<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procurement extends Telescoope_Controller {

    var $data;

    public function __construct(){

        parent::__construct();

        $this->load->model(array("Workflow_m","Procurement_m","Procpagu_m","Procrfq_m","Procpr_m","Procplan_m","Procevaltemp_m","Administration_m","Comment_m","Administration_m","Procedure_m","Commodity_m"));

        $this->data['date_format'] = "h:i A | d M Y";

        $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

        $this->data['data'] = array();

        $this->data['post'] = $this->input->post();

        $userdata = $this->Administration_m->getLogin();

        //print_r($userdata);

        $this->data['dir'] = 'procurement';

        $this->data['controller_name'] = $this->uri->segment(1);

        $this->session->set_userdata("module",$this->data['dir']);
        // haqim
        switch ($this->uri->segment(2)) {
            case 'submit_chat_pr':
            $dir = './uploads/'.PROCUREMENT_PERENCANAAN_CHAT_SPPBJ_FOLDER;
            break;
            case 'submit_chat_rfq':
            $dir = './uploads/'.PROCUREMENT_PERENCANAAN_CHAT_RFQ_FOLDER;
            break;

            default:
            $dir = './uploads/'.$this->data['dir'];
            break;
        }
        // end

        if (!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $config['allowed_types'] = '*';
        $config['overwrite'] = false;
        $config['max_size'] = 3064;
        $config['upload_path'] = $dir;
        $this->load->library('upload', $config);

        $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

        $this->data['doc_category'] = $this->Procurement_m->getKategoriDokumen()->result_array();

        $selection = array(
            "selection_mata_anggaran",
            "selection_perencanaan_pengadaan",
            "selection_permintaan_pengadaan",
            "selection_template_evaluasi",
            "selection_vendor_tender",
            "selection_vendor_tender_hadir",
            "selection_vendor_tender_hadir_2",
            "selection_panitia",
            "selection_klasifikasi",
            "selection_district",
            "selection_pr",
            "selection_group"
        );
        foreach ($selection as $key => $value) {
            $this->data[$value] = $this->session->userdata($value);
        }

        $this->data['workflow_list'] = array(3=>"Ditolak",2=>"Disetujui");

        if(empty($userdata)){
            redirect(site_url('log/in'));
        }

    }

    public function privyupload($rfid, $nama_file) {

        $getDataUskep = $this->Procrfq_m->getUskepData($rfid)->row_array();
        //print_r($getDataUskep);
        //exit;

        $data_recipient = "";
        if (!$getDataUskep) {
            echo json_encode(array("Message" => "Data Uskep Tidak Tersedia"));
            exit;
        } else {
            $data_recipient = $getDataUskep['bakp_kpd_name'];
        }

        $signer = array();
        if ($data_recipient != "") {

            $data_recipient_array = explode(";", $data_recipient);
            foreach ($data_recipient_array as $val) {
                $data_signer_array = explode(" [", $val);
                if (count($data_signer_array) > 1) {

                    $signer_id = str_replace("]","",$data_signer_array[1]);
                    if ($signer_id != "") {
                        array_push($signer, $signer_id);
                    }
                }
            }

        }

        //print_r($signer);
        $signer_array_1 = array();
        $signer_ecode = "";
        $owner_ecode = "";
        $index = 0; $privyidOwner = "";
        foreach($signer as $vals) {

            if ($index == 0) {
                $privyidOwner = $vals;
            }

            $index += 1;

            $signer_array_1[] = array(
                "privyId" => $vals,
                "type" => "Signer",
                "enterpriseToken" => "41bc84b42c8543daf448d893c255be1dbdcc722e"

            );
        }

        $owner_ecode = json_encode(array(
            "privyId" =>  $privyidOwner,
            "enterpriseToken" => "41bc84b42c8543daf448d893c255be1dbdcc722e"
        ));
        $signer_ecode = json_encode($signer_array_1);

        //echo $signer_ecode;

        $payloadName = array(
            'documentTitle' => $rfid,
            'docType' => 'Serial',
            'document'=> new CURLFILE('uploads/'.$nama_file),
            'recipients' => $signer_ecode,
            'owner' => $owner_ecode
        );

        //print_r($payloadName);

        $host = "https://api-sandbox.privy.id/v3/merchant/document/upload";

        $username = "wika_sandbox";
        $password = "w9g7mmqcmrt3i400s4dy";

        /*

        $ch = curl_init($host);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: multipart/form-data', "Merchant-Key: 5mynfcqtfb8oss1pye25"));
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadName);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($ch);
        curl_close($ch);

        echo $return;
        */


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-sandbox.privy.id/v3/merchant/document/upload',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERPWD => $username . ":" . $password,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payloadName,
            CURLOPT_HTTPHEADER => array(
                'Merchant-Key: 5mynfcqtfb8oss1pye25'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    public function callback() {

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            $data = file_get_contents("php://input");
            $getjson = json_decode($data);
            print_r($getjson);

        } else {
            print_r("Cannot ".$_SERVER["REQUEST_METHOD"]." ".$_SERVER["SCRIPT_NAME"]);
        }

    }

    public function panduan($params1 = ""){
        // show_404(); //sementara ini karena blm ada file guide manualnya
        switch ($params1) {
            case 'manual_guide_eproc':
            redirect(base_url("guide/user_guide.zip"));
            break;

            default:
            show_404();
            break;
        }

    }

    public function mata_anggaran($param1 = "" ,$param2 = ""){

        switch ($param1) {

            case 'picker':
            $this->mata_anggaran_picker();
            break;

            default:
            $this->mata_anggaran();
            break;

        }

    }

    public function list_po(){
        include("procurement/tender_po/tender_po.php");
    }

    public function list_daftar_rfq_po(){
        include("procurement/tender_po/tender_po_rfq.php");
    }


    public function perencanaan_pengadaan($param1 = "" ,$param2 = ""){

        switch ($param1) {

            case 'pembuatan_perencanaan_pengadaan':
            $this->pembuatan_perencanaan_pengadaan();
            break;

            case 'pembuatan_perencanaan_matgis':
            $this->pembuatan_perencanaan_matgis();
            break;

            case 'perencanaan_pmcs':
            $this->perencanaan_pmcs();
            break;

            case 'perencanaan_non_pmcs':
            $this->perencanaan_non_pmcs();
            break;

            case 'tambah_perencanaan_non_pmcs':
            $this->tambah_perencanaan_non_pmcs();
            break;

            case 'submit_data_perencanaan_non_pmcs':
            $this->submit_data_perencanaan_non_pmcs();
            break;

            case 'drup':
            $this->drup();
            break;

            case 'perencanaan_matgis':
            $this->perencanaan_matgis();
            break;

            case 'daftar_perencanaan_pengadaan':

            switch ($param2) {

                case 'lihat':
                $this->lihat_perencanaan_pengadaan();
                break;

                default:
                $this->daftar_perencanaan_pengadaan();
                break;

            }

            break;

            case 'pembuatan_history_pengadaan_car':
            $this->pembuatan_history_pengadaan_car();
            break;

            case 'daftar_history_car':

            switch ($param2) {

                case 'lihat':
                $this->lihat_history_car();
                break;

                case 'ubah':
                $this->ubah_history_car();
                break;

                default:
                $this->daftar_history_car();
                break;

            }

            break;

            case 'update_daftar_perencanaan':

            switch ($param2) {

                case 'ubah':
                $this->ubah_perencanaan_pengadaan();
                break;

                default:
                $this->update_daftar_perencanaan();
                break;

            }

            break;

            case 'rekapitulasi_perencanaan_pengadaan':

            switch ($param2) {

                case 'approval':
                $this->approval_perencanaan_pengadaan();
                break;

                default:
                $this->daftar_rekapitulasi_perencanaan_pengadaan();
                break;

            }

            break;

            case 'picker':
            $this->perencanaan_pengadaan_picker();
            break;

            case 'sap_picker':
            $this->perencanaan_pengadaan_sap_picker();
            break;

            case 'sap_picker_zpw1':
            $this->perencanaan_pengadaan_sap_picker_zpw1();
            break;

            case 'get_project_cost':
            $this->get_project_cost();
            break;

            case 'history_volume':
            $this->history_volume();
            break;

            default:
            $this->daftar_perencanaan_pengadaan();
            break;

        }

    }

    public function history_volume(){
        include("procurement/perencanaan_pengadaan/data_history_volume.php");
    }

    public function get_project_cost(){
        include("procurement/perencanaan_pengadaan/get_project_cost.php");
    }

    public function privy($param1 = "",$param2 = ""){
        switch ($param1) {
            case 'request_sign_penilaian':
            include("procurement/privy_penilaian/get_sign_request.php");
            break;

            case 'request_sign_bakp':
            include("procurement/privy_penilaian/get_sign_request_bakp.php");
            break;

            case 'request_sign_depkn':
            include("procurement/privy_penilaian/get_sign_request_depkn.php");
            break;
        }
    }

    public function proses_pengadaan($param1 = "" ,$param2 = ""){

        switch ($param1) {

            case 'pembuatan_permintaan_pengadaan':
            $this->pembuatan_permintaan_pengadaan();
            break;

            case 'get_comment_permintaan_pengadaan':
            $this->get_comment_permintaan_pengadaan();
            break;

            case 'save_comment_permintaan_pengadaan':
            $this->save_comment_permintaan_pengadaan();
            break;

            case 'edit_comment_permintaan_pengadaan':
            $this->edit_comment_permintaan_pengadaan();
            break;

            case 'delete_comment_permintaan_pengadaan':
            $this->delete_comment_permintaan_pengadaan();
            break;

            case 'get_list_risiko':
            $this->get_list_risiko_pengadaan();
            break;

            case 'save_list_risiko':
            $this->save_list_risiko_pengadaan();
            break;

            case 'edit_list_risiko':
            $this->edit_list_risiko_pengadaan();
            break;

            case 'delete_list_risiko':
            $this->delete_list_risiko_pengadaan();
            break;

            case 'get_ecatalog':
            $this->get_catalog_pengadaan();
            break;

            //haqim
            case 'data_employee_chat':
            $this->data_employee_chat();
            break;
            //end

            case 'daftar_permintaan_pengadaan':

            switch ($param2) {

                case 'lihat':
                $this->lihat_permintaan_pengadaan();
                break;

                default:
                $this->daftar_permintaan_pengadaan();
                break;

                case 'daftar_pembatalan_permintaan_pengadaan':

                switch ($param2) {

                    case 'batal':
                    $this->lihat_pembatalan_permintaan_pengadaan();
                    break;

                    default:
                    $this->daftar_pembatalan_permintaan_pengadaan();
                    break;
                }
            }
            break;

            default:
            $this->daftar_permintaan_pengadaan();
            break;

        }

    }

    public function procurement_tools($param1 = "" ,$param2 = "", $param3 = ""){

        switch ($param1) {

            case 'monitor_anggaran':
            $this->monitor_anggaran();
            break;

            case 'aanwijzing_online':
            $this->view_aanwijzing_online();
            break;

            case 'pembuatan_template_evaluasi_pengadaan':
            $this->template_evaluasi('buat');
            break;

            case 'daftar_template_evaluasi_pengadaan':
            $this->template_evaluasi();
            break;

            case 'update_lampiran_dokumen_pengadaan':
            $this->update_procurement("ubah_lampiran","Update Lampiran Dokumen Pengadaan");
            break;

            case 'pembatalan_pengadaan':
            $this->update_procurement("pembatalan_pengadaan","Pembatalan Pengadaan");
            break;

            case 'pembatalan_permintaan_pengadaan':
            $this->update_procurement("pembatalan_permintaan_pengadaan","Pembatalan Permintaan Pengadaan");
            break;

            case 'update_lampiran_dokumen_pengadaan':
            $this->update_procurement("ubah_lampiran","Update Lampiran Dokumen Pengadaan");
            break;

            case 'update_data_hps':
            $this->update_procurement("ubah_hps","Update Data HPS");
            break;

            case 'update_tanggal_pembukaan_penawaran':
            $this->update_procurement("ubah_tanggal","Update Tanggal Pembukaan Penawaran");
            break;

            case 'ubah_template_evaluasi':
            $this->template_evaluasi('ubah');
            break;

            case 'lihat_template_evaluasi':
            $this->template_evaluasi('lihat');
            break;

            case 'lihat_template_evaluasi_score':
            $this->lihat_template_evaluasi_score('lihat_score');
            break;

            case 'hapus_template_evaluasi':
            $this->template_evaluasi('hapus');
            break;

            case 'daftar_template_kewenangan':
            $this->daftar_kewenangan();
            break;

            case 'detail_template_kewnangan':
            $this->detail_template_kewenangan();
            break;

            case 'panitia_pengadaan':

            switch ($param2) {

                case 'add_panitia_pengadaan':
                $this->add_panitia_pengadaan();
                break;

                case 'ubah':
                $this->edit_panitia_pengadaan($param3);
                break;

                case 'hapus':
                $this->delete_panitia_pengadaan($param3);
                break;

                case 'add_panitia_detail':
                $this->add_panitia_detail($param3);
                break;

                case 'hapus_panitia_detail':
                $this->delete_panitia_detail($param3);
                break;

                case 'picker':
                $this->picker_panitia_pengadaan();
                break;

                default:
                $this->panitia_pengadaan();
                break;

            }

            break;

            case 'mata_anggaran':

            switch ($param2) {

                case 'add_mata_anggaran':
                $this->add_mata_anggaran();
                break;

                case 'add_master_mata_anggaran':
                $this->add_master_mata_anggaran();
                break;

                case 'ubah':
                $this->edit_mata_anggaran($param3);
                break;

                case 'ubah_master_anggaran':
                $this->edit_master_mata_anggaran($param3);
                break;

                case 'hapus':
                $this->delete_mata_anggaran($param3);
                break;


                default:
                $this->list_mata_anggaran();
                break;

            }

            break;

            case 'monitor_pengadaan':

            switch ($param2) {

                case 'lihat':
                $this->lihat_tender_pengadaan();
                break;

                case 'lihat_permintaan':
                $this->lihat_pr();
                break;

                default:
                $this->monitor_pengadaan();
                break;

            }

            break;

            case 'e_auction':

            switch ($param2) {

                case 'proses':
                $this->process_eauction($param3);
                break;

                case 'hapus':
                $this->delete_eauction($param3);
                break;

                default:
                $this->list_eauction();
                break;

            }

            break;

            case 'pembatalan_paket':

            switch ($param2) {

                case 'proses':
                include("procurement/procurement_tools/proses_pembatalan_paket.php");
                break;

                default:
                include("procurement/procurement_tools/pembatalan_paket.php");
                break;

            }

            break;

            default:
            $this->monitor_pengadaan();
            break;


        }

    }

    public function template_evaluasi($param1 = "",$param2 = ""){

        switch ($param1) {
            case 'buat':
            $this->pembuatan_template_evaluasi();
            break;

            case 'lihat':
            $this->lihat_template_evaluasi();
            break;

            case 'lihat_score':
            $this->lihat_template_evaluasi();
            break;


            case 'ubah':
            $this->ubah_template_evaluasi();
            break;

            case 'hapus':
            $this->hapus_template_evaluasi();
            break;

            case 'picker':
            $this->picker_template_evaluasi();
            break;

            default:
            $this->daftar_template_evaluasi();
            break;

        }

    }

    public function daftar_pekerjaan($param1 = "" ,$param2 = ""){

        switch ($param1) {

            case 'proses':
            $this->ubah_permintaan_pengadaan();
            break;

            case 'proses_tender':
            $this->ubah_tender_pengadaan();
            break;

            default:
            include("procurement/daftar_pekerjaan/daftar_pekerjaan.php");
            break;

        }

    }

    public function data_riwayat_eauction(){
        include("procurement/eauction/data_riwayat.php");
    }

    public function data_peringkat_vendor_eauction(){
        include("procurement/eauction/data_peringkat_vendor.php");
    }

    public function vendor_eacution_history(){
        include("procurement/eauction/vendor_eacution_history.php");
    }

    public function data_vendor_eacution_history(){
        include("procurement/eauction/data_vendor_eacution_history.php");
    }

    public function data_vendor_eauction(){
        include("procurement/eauction/data_vendor_eauction.php");
    }
    //y
    public function monitor_anggaran(){
        include("procurement/procurement_tools/monitor_anggaran.php");
    }

    public function data_monitor_anggaran(){
        include("procurement/procurement_tools/data_monitor_anggaran.php");
    }
    //end

    public function data_chat(){
        include("procurement/proses_pengadaan/data_chat.php");
    }

    public function picker_item_proc(){
        include("procurement/procurement_tools/picker_item_proc.php");
    }

    public function data_item_proc(){
        include("procurement/procurement_tools/data_item_proc.php");
    }

    public function data_penawaran(){
        include("procurement/proses_pengadaan/data_penawaran.php");
    }

    public function data_message(){
        include("procurement/proses_pengadaan/data_message.php");
    }

    public function lihat_penawaran($id){
        include("procurement/proses_pengadaan/lihat_penawaran.php");
    }

    public function lihat_penawaran_hist($id){
        include("procurement/proses_pengadaan/lihat_penawaran_hist.php");
    }

    public function data_panitia_pengadaan(){
        include("procurement/panitia_pengadaan/data_panitia_pengadaan.php");
    }

    public function data_vendor_tender(){
        include("procurement/proses_pengadaan/data_vendor_tender.php");
    }

    public function data_vendor_pr(){
        include("procurement/proses_pengadaan/data_vendor_pr.php");
    }

    public function sendaanwijzing(){
        include("procurement/aanwijzing_online/sendaanwijzing.php");
    }


    public function save_vadm(){
        include("procurement/proses_pengadaan/save_vadm.php");
    }

    public function lihat_sanggahan(){
        include("procurement/sanggahan/lihat_sanggahan.php");
    }

    public function save_sanggahan(){
        include("procurement/sanggahan/save_sanggahan.php");
    }

    public function data_anggota_panitia_pengadaan(){
        include("procurement/panitia_pengadaan/data_anggota_panitia_pengadaan.php");
    }

    public function save_eval_com(){
        include("procurement/proses_pengadaan/save_eval_com.php");
    }

    public function verifikasi_vendor(){
        include("procurement/proses_pengadaan/verifikasi_vendor.php");
    }

    public function data_vendor_tender_view(){
        include("procurement/proses_pengadaan/data_vendor_tender_view.php");
    }

    public function data_vendor_pr_view(){
        include("procurement/proses_pengadaan/data_vendor_pr_view.php");
    }

    public function picker_sanggahan(){
        include("procurement/sanggahan/picker_sanggahan.php");
    }

    public function data_sanggahan(){
        include("procurement/sanggahan/data_sanggahan.php");
    }

    public function picker_panitia_pengadaan(){
        include("procurement/panitia_pengadaan/picker_panitia_pengadaan.php");
    }

    public function ubah_tanggal(){
        include("procurement/proses_pengadaan/ubah_tanggal.php");
    }
    public function submit_ubah_tanggal(){
        include("procurement/proses_pengadaan/submit_ubah_tanggal.php");
    }

    public function ubah_lampiran(){
        include("procurement/proses_pengadaan/ubah_lampiran.php");
    }
    public function submit_ubah_lampiran(){
        include("procurement/proses_pengadaan/submit_ubah_lampiran.php");
    }

    public function ubah_hps(){
        include("procurement/proses_pengadaan/ubah_hps.php");
    }
    public function submit_ubah_hps(){
        include("procurement/proses_pengadaan/submit_ubah_hps.php");
    }

    // slv
    public function pembatalan_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/pembatalan_permintaan_pengadaan.php");
    }

    public function submit_pembatalan_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/submit_pembatalan_permintaan_pengadaan.php");
    }
    //

    public function pembatalan_pengadaan(){
        include("procurement/proses_pengadaan/pembatalan_pengadaan.php");
    }

    public function submit_pembatalan_pengadaan(){
        include("procurement/proses_pengadaan/submit_pembatalan_pengadaan.php");
    }

    public function submit_reject_pengadaan($rfq = ""){
        include("procurement/proses_pengadaan/submit_reject_pengadaan.php");
    }

    public function submit_drup(){
        include("procurement/proses_pengadaan/submit_drup.php");
    }

    public function delete_drup($id){
        include("procurement/proses_pengadaan/delete_drup.php");
    }

    public function proses_pembatalan_paket(){
        include("procurement/proses_pengadaan/proses_pembatalan_paket.php");
    }

    public function data_pr_rfq_kontrak(){
        include("procurement/procurement_tools/data_pr_rfq_kontrak.php");
    }

    public function submit_pembatalan_paket(){
        include("procurement/proses_pengadaan/submit_pembatalan_paket.php");
    }


    public function submit_pembuatan_template_evaluasi(){
        include("procurement/template_evaluasi/submit_pembuatan_template_evaluasi.php");
    }

    public function submit_pembuatan_template_evaluasi2(){
        include("procurement/template_evaluasi/submit_pembuatan_template_evaluasi.php");
    }

    public function submit_ubah_template_evaluasi(){
        include("procurement/template_evaluasi/submit_ubah_template_evaluasi.php");
    }

    public function hapus_template_evaluasi(){
        include("procurement/template_evaluasi/hapus_template_evaluasi.php");
    }

    public function daftar_kewenangan(){
        include("procurement/template_kewenangan/daftar_template_kewenangan.php");
    }

    public function detail_template_kewenangan(){
        include("procurement/template_kewenangan/detail_template_kewenangan.php");
    }

    public function data_monitor_pengadaan(){
        include("procurement/procurement_tools/data_monitor_pengadaan.php");
    }

    public function data_monitor_pengadaan_manual(){
        include("procurement/procurement_tools/data_monitor_pengadaan_manual.php");
    }

    public function monitor_pengadaan(){
        include("procurement/procurement_tools/monitor_pengadaan.php");
    }

    public function electronic_tender(){
        include("procurement/procurement_tools/monitor_pengadaan.php");
    }

    public function manual_tender(){
        include("procurement/procurement_tools/monitor_pengadaan_manual.php");
    }

    public function data_monitor_pr(){
        include("procurement/procurement_tools/data_monitor_pr.php");
    }

    public function monitor_pr(){
        include("procurement/procurement_tools/monitor_pr.php");
    }

    public function data_top_5_efisiensi(){
        include("procurement/daftar_pekerjaan/data_top_5_efisiensi.php");
    }

    public function data_efisiensi(){
        include("procurement/daftar_pekerjaan/data_efisiensi.php");
    }

    public function data_pekerjaan_pr(){
        include("procurement/daftar_pekerjaan/data_pekerjaan_pr.php");
    }

    public function data_pekerjaan_rfq(){
        include("procurement/daftar_pekerjaan/data_pekerjaan_rfq.php");
    }

    public function data_pekerjaan_rfq_sap(){
        include("procurement/daftar_pekerjaan/data_pekerjaan_rfq_sap.php");
    }

    public function data_pekerjaan_rfq_sap_po(){
        include("procurement/daftar_pekerjaan/data_pekerjaan_rfq_sap_po.php");
    }


    public function ubah_template_evaluasi(){
        include("procurement/template_evaluasi/ubah_template_evaluasi.php");
    }

    public function lihat_template_evaluasi(){
        include("procurement/template_evaluasi/lihat_template_evaluasi.php");
    }

    public function lihat_template_evaluasi_score(){
        include("procurement/template_evaluasi/template_score.php");
    }

    public function data_template_evaluasi(){
        include("procurement/template_evaluasi/data_template_evaluasi.php");
    }

    public function perencanaan_pengadaan_picker(){
        include("procurement/perencanaan_pengadaan/picker_perencanaan_pengadaan.php");
    }

    public function perencanaan_pengadaan_sap_picker(){
        include("procurement/perencanaan_pengadaan/picker_perencanaan_pengadaan_sap.php");
    }

    public function perencanaan_pengadaan_sap_picker_zpw1(){
        include("procurement/perencanaan_pengadaan/picker_perencanaan_pengadaan_sap_zpw1.php");
    }

    public function picker_template_evaluasi(){
        include("procurement/template_evaluasi/picker_template_evaluasi.php");
    }


    public function data_mata_anggaran(){
        include("procurement/mata_anggaran/data_mata_anggaran.php");
    }

    public function pembuatan_perencanaan_matgis(){
        include("procurement/perencanaan_pengadaan/pembuatan_perencanaan_matgis.php");
    }

    public function perencanaan_pmcs(){
        include("procurement/perencanaan_pengadaan/perencanaan_pmcs.php");
    }

    public function perencanaan_non_pmcs(){
        include("procurement/perencanaan_pengadaan/perencanaan_non_pmcs.php");
    }

    public function tambah_perencanaan_non_pmcs(){
        include("procurement/perencanaan_pengadaan/tambah_perencanaan_non_pmcs.php");
    }

    public function submit_data_perencanaan_non_pmcs(){
        include("procurement/perencanaan_pengadaan/submit_data_perencanaan_non_pmcs.php");
    }

    public function drup(){
        include("procurement/perencanaan_pengadaan/drup.php");
    }

    public function perencanaan_matgis(){
        include("procurement/perencanaan_pengadaan/perencanaan_matgis.php");
    }

    public function pembuatan_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/pembuatan_perencanaan_pengadaan.php");
    }

    public function ubah_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/ubah_perencanaan_pengadaan.php");
    }

    public function ubah_history_car(){
        include("procurement/perencanaan_pengadaan/ubah_history_car.php");
    }

    public function pembuatan_history_pengadaan_car(){
        include("procurement/perencanaan_pengadaan/pembuatan_history_pengadaan_car.php");
    }

    public function submit_pembuatan_perencanaan_pengadaan(){

        include("procurement/perencanaan_pengadaan/submit_pembuatan_perencanaan_pengadaan.php");
    }

    public function submit_ubah_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/submit_ubah_perencanaan_pengadaan.php");
    }

    public function submit_pembuatan_history_car(){

        include("procurement/perencanaan_pengadaan/submit_pembuatan_history_car.php");
    }

    public function submit_ubah_history_car(){

        include("procurement/perencanaan_pengadaan/submit_ubah_history_car.php");
    }

    public function daftar_rekapitulasi_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/daftar_rekapitulasi_perencanaan_pengadaan.php");
    }

    public function submit_approval_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/submit_approval_perencanaan_pengadaan.php");
    }

    public function daftar_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/daftar_perencanaan_pengadaan.php");
    }

    public function daftar_history_car(){
        include("procurement/perencanaan_pengadaan/daftar_history_car.php");
    }

    public function update_daftar_perencanaan(){
        include("procurement/perencanaan_pengadaan/update_daftar_perencanaan.php");
    }

    public function daftar_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/daftar_permintaan_pengadaan.php");
    }
    //slv
    public function daftar_pembatalan_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/daftar_pembatalan_permintaan_pengadaan.php");
    }
    //
    public function approval_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/approval_perencanaan_pengadaan.php");
    }

    public function data_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/data_perencanaan_pengadaan.php");
    }

    public function data_perencanaan_pmcs(){
        include("procurement/perencanaan_pengadaan/data_perencanaan_pmcs.php");
    }

    public function data_perencanaan_non_pmcs(){
        include("procurement/perencanaan_pengadaan/data_perencanaan_non_pmcs.php");
    }

    public function data_drup(){
        include("procurement/perencanaan_pengadaan/data_drup.php");
    }

    public function data_perencanaan_matgis(){
        include("procurement/perencanaan_pengadaan/data_perencanaan_non_pmcs.php");
    }

    public function data_history_car(){
        include("procurement/perencanaan_pengadaan/data_history_car.php");
    }

    public function data_perencanaan_pengadaan_pmcs(){
        include("procurement/perencanaan_pengadaan/data_perencanaan_pengadaan_pmcs.php");
    }

    public function daftar_paket_pengadaan(){
        include("procurement/perencanaan_pengadaan/daftar_paket_pengadaan.php");
    }

    public function data_rencana_pengadaan(){
        include("procurement/proses_pengadaan/data_rencana_pengadaan.php");
    }

    public function data_rencana_pengadaan_matgis(){
        include("procurement/proses_pengadaan/data_rencana_pengadaan_matgis.php");
    }

    public function detail_rencana_pengadaan($kode_smbd){
        include("procurement/proses_pengadaan/detail_rencana_pengadaan.php");
    }

    public function detail_rencana_pengadaan_matgis($kode_smbd){
        include("procurement/proses_pengadaan/detail_rencana_pengadaan_matgis.php");
    }

    public function data_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/data_permintaan_pengadaan.php");
    }

    public function data_permintaan_pengadaan_sap(){
        include("procurement/proses_pengadaan/data_permintaan_pengadaan_sap.php");
    }

    public function data_permintaan_pengadaan_join_sap(){
        include("procurement/proses_pengadaan/data_permintaan_pengadaan_join_sap.php");
    }

    public function data_permintaan_pengadaan_non_proyek(){
        include("procurement/proses_pengadaan/data_permintaan_pengadaan_non_proyek.php");
    }

    public function data_permintaan_pengadaan_sap_matgis(){
        include("procurement/proses_pengadaan/data_permintaan_pengadaan_sap_matgis.php");
    }
    //slv
    public function data_pembatalan_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/data_pembatalan_permintaan_pengadaan.php");
    }
    //
    public function lihat_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/lihat_perencanaan_pengadaan.php");
    }

    public function lihat_history_car(){
        include("procurement/perencanaan_pengadaan/lihat_history_car.php");
    }

    public function lihat_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/lihat_permintaan_pengadaan.php");
    }
    public function get_comment_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/get_comment_permintaan_pengadaan.php");
    }
    public function save_comment_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/save_comment_permintaan_pengadaan.php");
    }
    public function edit_comment_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/edit_comment_permintaan_pengadaan.php");
    }
    public function delete_comment_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/delete_comment_permintaan_pengadaan.php");
    }
    public function get_list_risiko_pengadaan($id){
        include("procurement/proses_pengadaan/get_list_risiko_pengadaan.php");
    }
    public function save_list_risiko_pengadaan(){
        include("procurement/proses_pengadaan/save_list_risiko_pengadaan.php");
    }
    public function edit_list_risiko_pengadaan(){
        include("procurement/proses_pengadaan/edit_list_risiko_pengadaan.php");
    }
    public function delete_list_risiko_pengadaan(){
        include("procurement/proses_pengadaan/delete_list_risiko_pengadaan.php");
    }
    public function get_catalog_pengadaan(){
        include("procurement/proses_pengadaan/get_catalog_pengadaan.php");
    }
    //slv
    public function lihat_pembatalan_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/lihat_pembatalan_permintaan_pengadaan.php");
    }
    //

    public function view_aanwijzing_online(){
        include("procurement/aanwijzing_online/view_aanwijzing_online.php");
    }

    public function lihat_tender_pengadaan(){
        include("procurement/procurement_tools/lihat_tender_pengadaan.php");
    }

    public function lihat_pr(){
        include("procurement/procurement_tools/lihat_pr.php");
    }

    public function alias_perencanaan_pengadaan(){
        include("procurement/perencanaan_pengadaan/alias_perencanaan_pengadaan.php");
    }

    public function alias_sanggahan(){
        include("procurement/sanggahan/alias_sanggahan.php");
    }

    public function alias_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/alias_permintaan_pengadaan.php");
    }

    public function pembuatan_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/pembuatan_permintaan_pengadaan.php");
    }
    public function submit_ubah_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/submit_ubah_permintaan_pengadaan.php");
    }

    public function ubah_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/ubah_permintaan_pengadaan.php");
    }

    public function submit_ubah_tender_pengadaan(){
        include("procurement/proses_pengadaan/submit_ubah_tender_pengadaan.php");
    }

    public function ubah_tender_pengadaan(){
        include("procurement/proses_pengadaan/ubah_tender_pengadaan.php");
    }

    public function submit_pembuatan_permintaan_pengadaan(){
        include("procurement/proses_pengadaan/submit_pembuatan_permintaan_pengadaan.php");
    }

    public function daftar_template_evaluasi(){
        include("procurement/template_evaluasi/daftar_template_evaluasi.php");
    }

    public function pembuatan_template_evaluasi(){
        include("procurement/template_evaluasi/pembuatan_template_evaluasi.php");
    }

    public function submit_item_evaluasi_template(){
        include("procurement/template_evaluasi/submit_item_evaluasi_template.php");
    }

    public function get_evaluasi_detail(){
        include("procurement/template_evaluasi/get_evaluasi_detail.php");
    }

    public function update_detail_valuasi_template(){
        include("procurement/template_evaluasi/update_detail_valuasi_template.php");
    }

    public function update_item_valuasi_template(){
        include("procurement/template_evaluasi/update_item_valuasi_template.php");
    }

    public function delete_item_evaluasi_template(){
        include("procurement/template_evaluasi/delete_item_evaluasi_template.php");
    }

    public function pembuatan_template_evaluasi_123(){
        include("procurement/template_evaluasi/pembuatan_template_evaluasi.php");
    }

    public function update_procurement($function_name = "",$title = ""){
        include("procurement/procurement_tools/update_procurement.php");
    }

    public function evaluasi_teknis(){
        include("procurement/proses_pengadaan/evaluasi_teknis.php");
    }

    public function evaluasi_harga(){
        include("procurement/proses_pengadaan/evaluasi_harga.php");
    }

    public function data_eval_com(){
        include("procurement/proses_pengadaan/data_eval_com.php");
    }

    public function calculate_eauction(){
        include("procurement/proses_pengadaan/calculate_eauction.php");
    }


    public function calculate_eval_tech(){
        include("procurement/proses_pengadaan/calculate_eval_tech.php");
    }

    public function calculate_eval_price(){
        include("procurement/proses_pengadaan/calculate_eval_price.php");
    }

    public function load_evaluation(){
        include("procurement/proses_pengadaan/load_evaluation.php");
    }

    public function pdf_load_evaluation_teknis_and_harga(){
        include("procurement/proses_pengadaan/pdf_load_evaluation.php");
    }

    public function pdf_layout_teknis_and_harga($data){
        $this->load->view('procurement/proses_pengadaan/view/load_evaluation_v', $data);
    }

    public function pdf_bakp($id = ""){
        include("procurement/doc_cetak/pdf_bakp.php");
    }

    public function report_po($id = ""){
        include("procurement/doc_cetak/pdf_report_po.php");
    }

    public function surat_pengumuman_pemenang($id = ""){
        include("procurement/doc_cetak/pdf_pengumuman_pemenang.php");
    }

    public function surat_penunjuk_penyedia($id = ""){
        include("procurement/doc_cetak/pdf_penunjuk_penyedia.php");
    }

    public function pdf_bakp_print($id = ""){
        include("procurement/doc_cetak/pdf_bakp_print.php");
    }

    public function pdf_penawaran_harga_print($id = ""){
        include("procurement/doc_cetak/pdf_penawaran_harga_print.php");
    }

    public function pdf_penawaran_harga($id = ""){
        include("procurement/doc_cetak/pdf_penawaran_harga.php");

    }

    public function pdf_penilaian_print($id = ""){
        include("procurement/doc_cetak/pdf_penilaian_print.php");
    }

    public function pdf_penilaian($id = ""){
        include("procurement/doc_cetak/pdf_penilaian.php");

    }

    public function list_mata_anggaran(){
        include("procurement/mata_anggaran/mata_anggaran.php");
    }

    //y start code
    public function data_join_paket(){
        include("procurement/daftar_pekerjaan/data_join_paket.php");
    }

    public function data_pr(){
        include("procurement/proses_pengadaan/data_pr.php");
    }
    public function lihat_data_pr(){
        include("procurement/proses_pengadaan/lihat_data_pr.php");
    }

    public function detail_join($id){
        include("procurement/proses_pengadaan/detail_join.php");
    }

    public function reject_join($id){
        include("procurement/proses_pengadaan/reject_join.php");
    }

    public function submit_join_pengadaan(){
        include("procurement/proses_pengadaan/submit_join_pengadaan.php");
    }

    public function submit_ubah_jadwal_akhir(){
        include("procurement/eauction/submit_ubah_jadwal_akhir.php");
    }

    //y end

    /*
    public function data_mata_anggaran(){
    include ("procurement/mata_anggaran/data_mata_anggaran.php");
}
*/

public function alias_mata_anggaran(){
    include ("procurement/mata_anggaran/alias_mata_anggaran.php");
}

public function add_mata_anggaran(){
    include ("procurement/mata_anggaran/add_mata_anggaran.php");
}

public function submit_add_mata_anggaran(){
    include ("procurement/mata_anggaran/submit_add_mata_anggaran.php");
}

public function edit_mata_anggaran($id){
    include ("procurement/mata_anggaran/edit_mata_anggaran.php");
}

public function submit_edit_mata_anggaran(){
    include ("procurement/mata_anggaran/submit_edit_mata_anggaran.php");
}

public function delete_mata_anggaran($id){
    include ("procurement/mata_anggaran/delete_mata_anggaran.php");
}


public function panitia_pengadaan(){
    include("procurement/panitia_pengadaan/panitia_pengadaan.php");
}

public function add_panitia_pengadaan(){
    include ("procurement/panitia_pengadaan/add_panitia_pengadaan.php");
}
public function edit_panitia_pengadaan($id){
    include ("procurement/panitia_pengadaan/edit_panitia_pengadaan.php");
}

public function submit_add_panitia_pengadaan(){
    include ("procurement/panitia_pengadaan/submit_add_panitia_pengadaan.php");
}

public function submit_edit_panitia_pengadaan(){
    include ("procurement/panitia_pengadaan/submit_edit_panitia_pengadaan.php");
}

public function delete_panitia_pengadaan($id){
    include ("procurement/panitia_pengadaan/delete_panitia_pengadaan.php");
}

public function add_panitia_detail($id){
    include ("procurement/panitia_pengadaan/add_panitia_detail.php");
}

public function submit_panitia_detail(){
    include ("procurement/panitia_pengadaan/submit_panitia_detail.php");
}

public function data_panitia_detail(){
    include ("procurement/panitia_pengadaan/data_panitia_detail.php");
}

public function delete_panitia_detail($id){
    include ("procurement/panitia_pengadaan/delete_panitia_detail.php");
}

public function list_eauction(){
    include ("procurement/eauction/list.php");
}

public function process_eauction($id){
    include ("procurement/eauction/form.php");
}

public function delete_eauction($id){
    include ("procurement/eauction/delete.php");
}

public function picker_eauction(){
    include ("procurement/eauction/picker.php");
}

public function submit_eauction(){
    include ("procurement/eauction/submit.php");
}

public function data_eauction(){
    include ("procurement/eauction/data.php");
}

public function remove_vendor(){
    include ("procurement/procurement_tools/remove_vendor.php");
}

public function eauction_list(){
    include ("procurement/eauction/list_all.php");
}

public function data_aanwijzing_online(){
    include ("procurement/aanwijzing_online/data_aanwijzing_online.php");
}

public function proses_aanwijzing_online($id = ""){
    include ("procurement/aanwijzing_online/proses_aanwijzing_online.php");
}

//haqim
public function data_employee_chat(){
    include("procurement/proses_pengadaan/data_employee_chat.php");
}

public function submit_chat_pr(){
    include("procurement/proses_pengadaan/submit_chat_pr.php");
}

public function chat_pr(){
    include("procurement/proses_pengadaan/chat_pr.php");
}

public function chat_rfq(){
    include("procurement/proses_pengadaan/chat_rfq.php");
}

public function submit_chat_rfq(){
    include("procurement/proses_pengadaan/submit_chat_rfq.php");
}

public function submit_uploadcsv_perencanaan(){
    include("procurement/perencanaan_pengadaan/submit_uploadcsv.php");
}

public function submit_uploadcsv_perencanaan_simdiv(){
    include("procurement/perencanaan_pengadaan/submit_uploadcsv_simdiv.php");
}

public function generate_perencanaan(){
    include("procurement/perencanaan_pengadaan/generate_perencanaan.php");
}

public function picker_matgis(){
    include("procurement/perencanaan_pengadaan/picker_matgis.php");
}

public function get_item_matgis(){
    include("procurement/perencanaan_pengadaan/data_item_matgis.php");
}

public function get_picker_sumberdaya(){
    include("procurement/perencanaan_pengadaan/picker_sumberdaya.php");
}

public function get_picker_sumberdaya_sap(){
    include("procurement/perencanaan_pengadaan/picker_sumberdaya_sap.php");
}

public function get_picker_sumberdaya_sap_new(){
    include("procurement/perencanaan_pengadaan/picker_sumberdaya_sap_new.php");
}

public function get_item_perencanaan(){
    include("procurement/perencanaan_pengadaan/data_item_perencanaan.php");
}

public function get_item_perencanaan_sap(){
    include("procurement/perencanaan_pengadaan/data_item_perencanaan_sap.php");
}

public function get_volume(){
    include("procurement/perencanaan_pengadaan/get_volume.php");
}

public function periode_pengadaan_picker(){
    include("procurement/perencanaan_pengadaan/periode_pengadaan_picker.php");
}



//end

//======K=======Berita Acara Aanwijzing

public function getBeritaAcaraAanwijzing($ptmNumber){


    $beritaAcara = $this->Procurement_m->getAanwijzingChat('1-'.$ptmNumber)->result_array();

    foreach ($beritaAcara as $key => $value) {

        $isVendor = $this->Procurement_m->getVendorByName($value['name_ac'])->num_rows();

        if($isVendor > 0){

            $beritaAcara[$key]['position'] = 'Vendor';

        }else{

            $beritaAcara[$key]['position'] = 'User';

        }

    }

    return $beritaAcara;

}

public function getEvaluasi($ptmNumber){
    $this->db->join('prc_tender_prep','vw_prc_quotation_item.ptm_number=prc_tender_prep.ptm_number','left');
    $this->db->join('vnd_header','vnd_header.vendor_id=vw_prc_quotation_item.vendor_id','left');
    $itemPemenang = $this->Procrfq_m->getViewVendorQuoComRFQ('','',$ptmNumber)->result_array();
    $itemNego = $this->db->where('ptm_number',$ptmNumber)->get('vw_penawaran_dari_quo')->result_array();
    $itemInternal = $this->Procrfq_m->getItemRFQ('',$ptmNumber)->result_array();
    $rawActivity = $this->db->select('ptc_activity')->where('ptm_number',$ptmNumber)->get('prc_tender_comment')->result_array();
    $activity = array_map(function($value){
        return $value['ptc_activity'];
    } , $rawActivity);
    $ifNego = in_array('1140',$activity);

    $data = array();

    foreach($itemInternal as $k => $v){
        $data['internal'][$k]['uom'] = $v['tit_unit'];
        $data['internal'][$k]['qty'] = $v['tit_quantity'];
        $data['internal'][$k]['item_code'] = $v['tit_code'];
        $data['internal'][$k]['item_name'] = $v['tit_description'];
        $data['internal'][$k]['satuan'] = inttomoney($v['tit_price']);
        $data['internal'][$k]['total'] = inttomoney(($v['tit_price'] * $v['tit_quantity']) + (($v['tit_price'] * $v['tit_quantity']) * $v['tit_ppn'] / 100) + (($v['tit_price'] * $v['tit_quantity']) * $v['tit_pph'] / 100));
    }

    foreach($itemPemenang as $k => $v){
        $data['header'][$v['vendor_id']]['vendor_name'] = $v['vendor_name'];
        $data['header'][$v['vendor_id']]['contact_person'] = $v['contact_name'];
        $data['header'][$v['vendor_id']]['phone'] = $v['address_phone_no'];
        $data['header'][$v['vendor_id']]['address'] = $v['address_street'];
        $data['header'][$v['vendor_id']]['penawaran'] = $v['ptm_number'].'/'.$v['ptp_quot_opening_date'];
    }

    foreach ($itemPemenang as $k => $v) {
        $data['item'][$v['tit_code']][$v['vendor_id']]['satuan'] = inttomoney($v['pqi_price']);
        $data['item'][$v['tit_code']][$v['vendor_id']]['total'] = inttomoney(($v['pqi_price'] * $v['pqi_quantity']) + (($v['pqi_price'] * $v['pqi_quantity']) * $v['pqi_ppn'] / 100) + (($v['pqi_price'] * $v['pqi_quantity']) * $v['pqi_pph'] / 100));
        $data['footer'][$v['vendor_id']]['deliverable'] = $v['pqi_deliverable'].' '.$v['pqi_deliverable_type'];
    }

    if(!empty($ifNego) && $ifNego == true){
        foreach ($itemNego as $k => $v) {
            $data['nego'][$v['tit_code']][$v['vendor_id']]['satuan'] = inttomoney($v['pqi_price']);
            $data['nego'][$v['tit_code']][$v['vendor_id']]['total'] = inttomoney($v['total']);
        }
    }else{
        $data['nego'] = $data['item'];
    }

    // echo '<pre>';
    // print_r($data);
    // die();

    return $data;

}
public function GenerateBeritaAcaraAanwijzing($ptmNumber){

    $userdata = $this->Administration_m->getLogin();

    $dataPengadaan = $this->Procrfq_m->getRFQ($ptmNumber)->row_array();

    $dataPrepPengadaan = $this->Procrfq_m->getPrepRFQ($ptmNumber)->row_array();

    $beritaAcara = $this->getBeritaAcaraAanwijzing($ptmNumber);

    $pesertaHadir = $this->Procurement_m->getOnlineAanwijzingParticipant('0-'.$ptmNumber)->result_array();


    $data['data'] = '<p align="center"><h3><b>BERITA ACARA AANWIJZING</b></h3></p><p align="center"><h3><b>'.$dataPengadaan['ptm_subject_of_work'].'</b></h3></p>';

    $data['data'] .= '<hr />';

    $data['data'] .= '<br />';
    $data['data'] .= '<br />';
    $data['data'] .= '<br />';

    $data['data'] .= '<p>Pada hari ini, '.date("d-m-Y", strtotime($dataPrepPengadaan['ptp_prebid_date'])).', telah dilaksanakan acara Rapat aanwijzing '.$dataPengadaan['ptm_subject_of_work'].' secara online melalui aplikasi ESCM. </p>';

    $data['data'] .= '<p>Rapat aanwijzing ini dihadiri oleh pihak undangan selaku peserta pengadaan, terdiri dari :  </p>';

    $n = 1;

    foreach ($pesertaHadir as $key => $value) {

        $isVendor = $this->Procurement_m->getVendorByName($value['name_ac'])->num_rows();

        if($isVendor > 0){

            $data['data'] .= '<p>'.$n.'.   '.$value['name_ac'].'</p>';

            $n++;

        }

    }

    $data['data'] .= '<p>Rapat Penjelasan Teknis berjalan sebagai berikut : </p>';

    $data['data'] .= '<table border="1px"><thead><tr><th style="width: 25%;">Nama</th><th style="width: 10%;">Posisi</th><th style="width: 40%;">Pesan</th><th style="width: 25%;">Tanggal</th></tr></thead><tbody>';

    foreach ($beritaAcara as $key => $value) {

        $isVendor = $this->Procurement_m->getVendorByName($value['name_ac'])->num_rows();

        $data['data'] .= '<tr><td style="width: 25%;">'.$value['name_ac'].'</td><td style="width: 10%;">'.$value['position'].'</td><td style="width: 40%;">'.$value['message_ac'].'</td><td style="width: 25%;">'.$value['datetime_ac'].'</td></tr>';

    }

    $data['data'] .= '</tbody></table>';

    $data['data'] .= '<p>Demikian Berita Acara Rapat Penjelasan ini dibuat dan ditandatangani di generate  by system (oleh '.$userdata['pos_name'].') pada '.date("d-m-Y").' dan memiliki kekuatan hukum yang sama.</p>';

    $data['namePDF'] = 'BeritaAcaraAanwijzing.pdf';

    $this->generatePDF($data);
}

public function GenerateEvaluasi($ptmNumber){

    $userdata = $this->Administration_m->getLogin();

    $dataPengadaan = $this->Procrfq_m->getRFQ($ptmNumber)->row_array();

    $dataPrepPengadaan = $this->Procrfq_m->getPrepRFQ($ptmNumber)->row_array();

    $evaluasi = $this->getEvaluasi($ptmNumber);
    // echo '<pre>';
    // print_r($evaluasi['internal']);
    // print_r(count($evaluasi['header']));
    // die();
    $colspan = count($evaluasi['header']) * 2;

    $vendorName = '';
    $vendorAddress = '';
    $vendorCp ='';
    $vendorTelp ='';
    $vendorPenawaran='';
    $vendorNego='';

    foreach ($evaluasi['header'] as $key => $value) {
        $vendorName .= '<td colspan="2">'.$value['vendor_name'].'</td>';
        $vendorAddress .= '<td colspan="2">'.$value['address'].'</td>';
        $vendorCp .= '<td colspan="2">'.$value['contact_person'].'</td>';
        $vendorTelp .= '<td colspan="2">'.$value['phone'].'</td>';
        $vendorPenawaran .= '<td colspan="2">'.$value['penawaran'].'</td>';
        $vendorNego .= '<td colspan="2"></td>';
    }


    foreach ($evaluasi['internal'] as $key => $value) {
        # code...
    }


    $data['data'] = '<p align="center"><h3><b>Evaluasi Keputusan Pemilihan Pemasok / Peyedia Jasa </b></h3></p><p align="center"></p>';

    $data['data'] .= '<hr />';

    $data['data'] .= '<br />';
    $data['data'] .= '<br />';
    $data['data'] .= '<br />';

    $data['data'] .= '<table border="1">';

    $data['data'] .= '
    <tr>
    <td colspan="5">Keterangan Harga Yang ditawarkan</td>
    <td colspan="3">RABP</td>
    <td colspan="'.$colspan.'">Vendor Usulan</td>
    </tr>';
    $data['data'] .= '
    <tr>
    <td colspan="5">1</td>
    <td colspan="3" rowspan="3">Rencana Anggaran Biaya Pelaksana</td>
    <td colspan="'.$colspan.'" rowspan="3"></td>
    </tr>
    <tr>
    <td colspan="5">2</td>
    </tr>
    <tr>
    <td colspan="5">3</td>
    </tr>
    <tr>
    <td>1</td>
    <td colspan="4">Data Penyedia</td>
    <td colspan="3"></td>
    <td colspan="'.$colspan.'"></td>
    </tr>';

    $data['data'] .= '
    <tr>
    <td>1.1</td>
    <td colspan="4">Vendor Name</td>
    <td colspan="3" rowspan="6"></td>
    '.$vendorName.'
    </tr>';
    $data['data'] .= '
    <tr>
    <td>1.2</td>
    <td colspan="4">Alamat</td>
    '.$vendorAddress.'
    </tr>';
    $data['data'] .= '
    <tr>
    <td>1.3</td>
    <td colspan="4">Contact Person</td>
    '.$vendorCp.'
    </tr>';
    $data['data'] .= '
    <tr>
    <td>1.4</td>
    <td colspan="4">No. Telpon/Fax</td>
    '.$vendorTelp.'
    </tr>';
    $data['data'] .= '
    <tr>
    <td>1.5</td>
    <td colspan="4">Penawaran No./Tgl</td>
    '.$vendorPenawaran.'
    </tr>';
    $data['data'] .='
    <tr>
    <td>1.6</td>
    <td colspan="4">BA Klarifikasi dan Negosiasi Tgl.</td>
    '.$vendorNego.'
    </tr>';

    $data['data'] .= '
    <tr>
    <td>2</td>
    <td colspan="4">Data Pekerjaan / Spesifikasi</td>
    <td colspan="3"></td>
    <td colspan="'.$colspan.'"></td>
    </tr>';

    $data['data'] .= '
    <tr>
    <td></td>
    <td colspan="2"></td>
    <td colspan="1">SAT</td>
    <td colspan="1">Volume</td>
    <td colspan="1">H. IDR</td>
    <td colspan="2">Harga IDR</td>';
    $i = 0;
    while($i < ($colspan / 2)){
        $data['data'] .= '
        <td colspan="1">H. Satuan IDR</td>
        <td colspan="1">Harga IDR</td>';
        $i++;
    }
    $data['data'] .= '</tr>';

    $data['data'] .= '
    <tr>
    <td>A)</td>
    <td colspan="2">Penawaran</td>
    <td colspan="1"></td>
    <td colspan="1"></td>
    <td colspan="3"></td>
    <td colspan="'.$colspan.'"></td>
    </tr>';
    $n = 1;
    foreach ($evaluasi['internal'] as $k => $v) {
        $data['data'] .= '
        <tr>
        <td>'.$n.'</td>
        <td colspan="2">'.$v['item_name'].'</td>
        <td colspan="1">'.$v['uom'].'</td>
        <td colspan="1">'.$v['qty'].'</td>
        <td colspan="1">'.$v['satuan'].'</td>
        <td colspan="2">'.$v['total'].'</td>';
        foreach ($evaluasi['item'][$v['item_code']] as $key => $val) {
            $data['data'] .= '
            <td colspan="1">'.$val['satuan'].'</td>
            <td colspan="1">'.$val['total'].'</td>';
        }
        $data['data'] .= '</tr>';
        $n++;
    }

    $data['data'] .= '
    <tr>
    <td>B)</td>
    <td colspan="2">Negosiasi</td>
    <td colspan="1"></td>
    <td colspan="1"></td>
    <td colspan="3"></td>
    <td colspan="'.$colspan.'"></td>
    </tr>';

    $x = 1;
    foreach ($evaluasi['internal'] as $k => $v) {
        $data['data'] .= '
        <tr>
        <td>'.$x.'</td>
        <td colspan="2">'.$v['item_name'].'</td>
        <td colspan="1">'.$v['uom'].'</td>
        <td colspan="1">'.$v['qty'].'</td>
        <td colspan="1">'.$v['satuan'].'</td>
        <td colspan="2">'.$v['total'].'</td>';
        foreach ($evaluasi['nego'][$v['item_code']] as $key => $val) {
            $data['data'] .= '
            <td colspan="1">'.$val['satuan'].'</td>
            <td colspan="1">'.$val['total'].'</td>';
        }
        $data['data'] .= '</tr>';
        $x++;
    }

    $data['data'] .= '</table>';
    $data['nameExcel'] = 'test.xlsx';
    // print_r($data);
    // die();
    $this->generateExcel($data);

    $data['data'] .= '
    <tr>
    <td>3</td>
    <td colspan="4">Lain-Lain</td>
    <td colspan="3"></td>
    <td colspan="'.$colspan.'"></td>
    </tr>';

    $data['data'] .= '
    <tr>
    <td>3.1</td>
    <td colspan="4">Jangka Waktu Pelaksanaan</td>
    <td colspan="3" rowspan="6"></td>
    '.$vendorName.'
    </tr>';
    $data['data'] .= '
    <tr>
    <td>3.2</td>
    <td colspan="4">Lingkup Pelaksanaan</td>
    '.$vendorAddress.'
    </tr>';
    $data['data'] .= '
    <tr>
    <td>3.2</td>
    <td colspan="4">Masa Berlaku Harga</td>
    '.$vendorCp.'
    </tr>';
    $data['data'] .= '
    <tr>
    <td>3.3</td>
    <td colspan="4">Cara Pembayaran</td>
    '.$vendorCp.'
    </tr>';
    $data['data'] .= '
    <tr>
    <td>3.4</td>
    <td colspan="4">Jaminan-jaminan</td>
    '.$vendorTelp.'
    </tr>';
    $data['data'] .= '
    <tr>
    <td>3.5</td>
    <td colspan="4">Denda dan Sangsi</td>
    '.$vendorPenawaran.'
    </tr>';

    $data['data'] .= '</table>';

    print_r($data);
    die();
    $data['data'] .= '<p>Rapat aanwijzing ini dihadiri oleh pihak undangan selaku peserta pengadaan, terdiri dari :  </p>';

    $n = 1;

    foreach ($pesertaHadir as $key => $value) {

        $isVendor = $this->Procurement_m->getVendorByName($value['name_ac'])->num_rows();

        if($isVendor > 0){

            $data['data'] .= '<p>'.$n.'.   '.$value['name_ac'].'</p>';

            $n++;

        }

    }

    $data['data'] .= '<p>Rapat Penjelasan Teknis berjalan sebagai berikut : </p>';

    $data['data'] .= '<table border="1px"><thead><tr><th style="width: 25%;">Nama</th><th style="width: 10%;">Posisi</th><th style="width: 40%;">Pesan</th><th style="width: 25%;">Tanggal</th></tr></thead><tbody>';

    foreach ($beritaAcara as $key => $value) {

        $isVendor = $this->Procurement_m->getVendorByName($value['name_ac'])->num_rows();

        $data['data'] .= '<tr><td style="width: 25%;">'.$value['name_ac'].'</td><td style="width: 10%;">'.$value['position'].'</td><td style="width: 40%;">'.$value['message_ac'].'</td><td style="width: 25%;">'.$value['datetime_ac'].'</td></tr>';

    }

    $data['data'] .= '</tbody></table>';

    $data['data'] .= '<p>Demikian Berita Acara Rapat Penjelasan ini dibuat dan ditandatangani di generate  by system (oleh '.$userdata['pos_name'].') pada '.date("d-m-Y").' dan memiliki kekuatan hukum yang sama.</p>';

    $data['namePDF'] = 'BeritaAcaraAanwijzing.pdf';

    $this->generatePDF($data);
}
//==============

}
