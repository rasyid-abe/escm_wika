<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Paket_pengadaan extends Telescoope_Controller
{

    var $data;

    public function __construct()
    {

        parent::__construct();

        $this->load->helper('cookie');

        $this->load->model(array("Procedure2_m", "Procedure3_m", "Contract_m", "Procrfq_m", "Administration_m", "Comment_m", "Administration_m", "Workflow_m", "Addendum_m", "Procplan_m", "Procpr_m", "Procurement_m", "Procedure_m", "Commodity_m", "Vendor_m"));

        $this->data['date_format'] = "h:i A | d M Y";

        $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

        $this->data['data'] = array();

        $this->data['post'] = $this->input->post();

        $userdata = $this->Administration_m->getLogin();

        $this->data['dir'] = 'perencanaan_pengadaan';

        $this->data['controller_name'] = $this->uri->segment(1);

        $dir = './uploads/' . $this->data['dir'];

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

        $this->session->set_userdata("module", $this->data['dir']);

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $config['allowed_types'] = '*';
        $config['overwrite'] = false;
        $config['max_size'] = 3064;
        $config['upload_path'] = $dir;
        $this->load->library('upload', $config);
        $this->load->model("Global_m");
        $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();
        $this->data['doc_category'] = $this->Procurement_m->getKategoriDokumen()->result_array();

        $selection = array(
            "selection_milestone"
        );
        foreach ($selection as $key => $value) {
            $this->data[$value] = $this->session->userdata($value);
        }

        if (empty($userdata)) {
            redirect(site_url('log/in'));
        }
    }

    public function sync()
    {

        $ch_login = curl_init(CRM_WIKA_LOGIN);

        $data = array(
            'UserName' => 'ES941692@wika',
            'UserPassword' => 'ES941692@wika'
        );

        $payload = json_encode($data);

        $fullPath = dir(getcwd());

        $cookie_jar = $fullPath->path . '\assets\crmtmp.tmp';

        curl_setopt($ch_login, CURLOPT_COOKIEJAR, $cookie_jar);
        curl_setopt($ch_login, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_login, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch_login, CURLOPT_HEADER, 1);
        curl_setopt($ch_login, CURLOPT_VERBOSE, 1);
        curl_setopt($ch_login, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch_login, CURLOPT_POST, true);
        curl_setopt($ch_login, CURLOPT_POSTFIELDS, $payload);
        curl_setopt(
            $ch_login,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json'
            )
        );

        $result = curl_exec($ch_login);

        $header_size = curl_getinfo($ch_login, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        preg_match_all('/^set-cookie:\s*([^;]*)/mi', $header, $matches);
        $cookies = array();
        foreach ($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        setcookie('BPMCSRF', $cookies['BPMCSRF']);
        setcookie('BPMLOADER', $cookies['BPMLOADER']);
        setcookie('_ASPXAUTH', $cookies['_ASPXAUTH']);
        setcookie('UserName', $cookies['UserName']);

        $this->session->set_userdata('BPMCSRF', $cookies['BPMCSRF']);

        curl_close($ch_login);

        redirect(site_url('perencanaan_pengadaan/pr_proyek_non_pmcs'));
    }

    public function pr_proyek_pmcs($param1 = "")
    {

        switch ($param1) {

            case 'pembuatan_drup':
                include("perencanaan/pembuatan_drup.php");
                break;

            default:
                include("perencanaan/daftar_perencanaan_pmcs.php");
                break;
        }
    }

    public function paket_proyek_pmcs($param1 = "")
    {
        switch ($param1) {
            case 'lihat':
                include("pemaketan/pmcs/lihat_pengadaan_pmcs.php");
                break;
            case 'data_perencanaan_pmcs_picker':
                include("pemaketan/pmcs/data_perencanaan_pmcs_picker.php");
                break;
            case 'picker_perencanaan_pengadaan':
                include("pemaketan/pmcs/picker_perencanaan_pengadaan.php");
                break;
            case 'pembuatan_permintaan_pengadaan':
                include("pemaketan/pmcs/pembuatan_permintaan_pengadaan.php");
                break;
            case 'submit_pmcs':
                include("pemaketan/pmcs/submit_pembuatan_pmcs.php");
                break;
            default:
                include("pemaketan/pmcs/daftar_perencanaan_pmcs.php");
                break;
        }
    }

    public function paket_proyek_non_pmcs($param1 = "")
    {
        switch ($param1) {
            case 'lihat':
                include("pemaketan/non_pmcs/lihat_pengadaan_non_pmcs.php");
                break;
            case 'data_perencanaan_non_pmcs_picker':
                include("pemaketan/non_pmcs/data_perencanaan_non_pmcs_picker.php");
                break;
            case 'picker_perencanaan_pengadaan':
                include("pemaketan/non_pmcs/picker_perencanaan_pengadaan.php");
                break;
            case 'pembuatan_permintaan_pengadaan':
                include("pemaketan/non_pmcs/pembuatan_permintaan_pengadaan.php");
                break;
            default:
                include("pemaketan/non_pmcs/daftar_pemaketan_non_pmcs.php");
                break;
        }
    }

    public function paket_non_proyek_drup($param1 = "")
    {

        switch ($param1) {

            case 'submit_drup':
                include("pemaketan/drup/submit_pembuatan_drup.php");
                break;

            case 'data_pengadaan_drup':
                include("pemaketan/drup/data_pengadaan_drup.php");
                break;

            case 'lihat':
                include("pemaketan/drup/lihat_pengadaan_drup.php");
                break;

            case 'pembuatan_drup':
                include("pemaketan/drup/pembuatan_drup.php");
                break;

            default:
                include("pemaketan/drup/daftar_pengadaan_drup.php");
                break;
        }
    }

    public function paket_non_proyek($param1 = "")
    {

        switch ($param1) {

            case 'submit_non_proyek':
                include("pemaketan/non_proyek/submit_pembuatan_non_proyek.php");
                break;

            case 'data_pengadaan_non_proyek':
                include("pemaketan/non_proyek/data_pengadaan_non_proyek.php");
                break;

            case 'lihat':
                include("pemaketan/non_proyek/lihat_pengadaan_non_proyek.php");
                break;

            case 'pembuatan_permintaan_pengadaan':
                include("pemaketan/non_proyek/pembuatan_permintaan_pengadaan.php");
                break;

            default:
                include("pemaketan/non_proyek/daftar_pengadaan_non_proyek.php");
                break;
        }
    }

    public function paket_matgis($param1 = "")
    {

        switch ($param1) {
            case 'submit_matgis':
                include("pemaketan/matgis/submit_pembuatan_matgis.php");
                break;

            case 'pembuatan_matgis':
                include("pemaketan/matgis/pembuatan_perencanaan_matgis.php");
                break;

            case 'data_perencanaan_matgis':
                include("pemaketan/matgis/data_perencanaan_matgis.php");
                break;

            case 'lihat':
                include("pemaketan/matgis/lihat_perencanaan_matgis.php");
                break;

            default:
                include("pemaketan/matgis/daftar_perencanaan_matgis.php");
                break;
        }
    }

    public function paket_sap($param1 = "")
    {
        switch ($param1) {
            case 'lihat':
                include("pemaketan/sap/lihat_pengadaan_sap.php");
                break;
            case 'data_perencanaan_pmcs_picker':
                include("pemaketan/sap/data_perencanaan_sap_picker.php");
                break;
            case 'picker_perencanaan_pengadaan':
                include("pemaketan/sap/picker_perencanaan_pengadaan.php");
                break;
            case 'pembuatan_permintaan_pengadaan':
                include("pemaketan/sap/pembuatan_permintaan_pengadaan.php");
                break;
            case 'submit_sap':
                include("pemaketan/sap/submit_pembuatan_sap.php");
                break;
            case 'submit_single_sap':
                include("pemaketan/sap/submit_pembuatan_single_sap.php");
                break;
            case 'submit_ubah_permintaan':
                include("pemaketan/sap/submit_ubah_permintaan.php");
                break;
            default:
                include("pemaketan/sap/daftar_perencanaan_sap.php");
                break;
        }
    }

    public function paket_sap_oa($param1 = "")
    {
        switch ($param1) {
            case 'lihat':
                include("pemaketan/sap_oa/lihat_pengadaan_sap.php");
                break;
            case 'data_perencanaan_pmcs_picker':
                include("pemaketan/sap_oa/data_perencanaan_sap_picker.php");
                break;
            case 'picker_perencanaan_pengadaan':
                include("pemaketan/sap_oa/picker_perencanaan_pengadaan.php");
                break;
            case 'pembuatan_permintaan_pengadaan':
                include("pemaketan/sap_oa/pembuatan_permintaan_pengadaan.php");
                break;
            case 'pembuatan_permintaan_pengadaan_merge':
                include("pemaketan/sap_oa/pembuatan_permintaan_pengadaan_merge.php");
                break;
            case 'submit_sap':
                include("pemaketan/sap_oa/submit_pembuatan_sap.php");
                break;
            case 'submit_single_sap':
                include("pemaketan/sap_oa/submit_pembuatan_single_sap.php");
                break;
            case 'submit_ubah_permintaan':
                include("pemaketan/sap_oa/submit_ubah_permintaan.php");
                break;
            default:
                include("pemaketan/sap_oa/daftar_perencanaan_sap.php");
                break;
        }
    }

    public function submit_pembuatan_permintaan_pengadaan()
    {
        include("pemaketan/non_pmcs/submit_pembuatan_permintaan_pengadaan.php");
    }

    public function data_permintaan_pengadaan_non_pmcs()
    {
        include("pemaketan/proses_pengadaan/data_permintaan_pengadaan_non_pmcs.php");
    }

    public function submit_proses_drup()
    {
        include("perencanaan/submit_proses_drup.php");
    }

    public function hapus($id)
    {
        include("perencanaan/delete_daftar_drup.php");
    }

    public function get_comment_permintaan_pengadaan()
    {
        include("pemaketan/proses_pengadaan/get_comment_permintaan_pengadaan.php");
    }

    public function save_comment_permintaan_pengadaan()
    {
        include("pemaketan/proses_pengadaan/save_comment_permintaan_pengadaan.php");
    }

    public function edit_comment_permintaan_pengadaan()
    {
        include("pemaketan/proses_pengadaan/edit_comment_permintaan_pengadaan.php");
    }

    public function delete_comment_permintaan_pengadaan()
    {
        include("pemaketan/proses_pengadaan/delete_comment_permintaan_pengadaan.php");
    }

    public function get_list_risiko($id)
    {
        include("pemaketan/proses_pengadaan/get_list_risiko_pengadaan.php");
    }

    public function save_list_risiko()
    {
        include("pemaketan/proses_pengadaan/save_list_risiko_pengadaan.php");
    }

    public function edit_list_risiko()
    {
        include("pemaketan/proses_pengadaan/edit_list_risiko_pengadaan.php");
    }

    public function delete_list_risiko()
    {
        include("pemaketan/proses_pengadaan/delete_list_risiko_pengadaan.php");
    }

    public function get_catalog_pengadaan()
    {
        include("pemaketan/proses_pengadaan/get_catalog_pengadaan.php");
    }

    public function get_picker_sumberdaya()
    {
        include("pemaketan/proses_pengadaan/picker_sumberdaya.php");
    }

    public function picker_sumberdaya_non_pmcs()
    {
        include("pemaketan/proses_pengadaan/picker_sumberdaya_non_pmcs.php");
    }

    public function get_picker_sumberdaya_drup()
    {
        include("pemaketan/proses_pengadaan/picker_sumberdaya_drup.php");
    }

    public function get_item_perencanaan()
    {
        include("pemaketan/proses_pengadaan/data_item_perencanaan_matgis.php");
    }

    public function get_item_perencanaan_drup()
    {
        include("pemaketan/proses_pengadaan/data_item_perencanaan_drup.php");
    }

    public function get_volume()
    {
        include("procurement/perencanaan_pengadaan/get_volume.php");
    }

    public function periode_pengadaan_picker()
    {
        include("procurement/perencanaan_pengadaan/periode_pengadaan_picker.php");
    }
}
