<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Perencanaan_pengadaan extends Telescoope_Controller {

    var $data;

    public function __construct(){

        parent::__construct();

        // $this->load->library('excel');
        $this->load->helper('cookie');
        $this->load->helper(array('url','html','form'));

        $this->load->model(array("Procedure2_m","Procedure3_m","Contract_m","Procrfq_m","Administration_m","Comment_m","Administration_m","Workflow_m","Addendum_m","Procplan_m","Procpr_m","Procurement_m", "Procedure_m", "Commodity_m"));
        // $this->load->model(array("Workflow_m","Procurement_m","Procpagu_m","Procrfq_m","Procpr_m","Procplan_m","Procevaltemp_m","Administration_m","Comment_m","Administration_m","Procedure_m","Commodity_m"));


        $this->data['date_format'] = "h:i A | d M Y";

        $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

        $this->data['data'] = array();

        $this->data['post'] = $this->input->post();

        $userdata = $this->Administration_m->getLogin();

        $this->data['dir'] = 'perencanaan_pengadaan';

        $this->data['controller_name'] = $this->uri->segment(1);

        $dir = './uploads/'.$this->data['dir'];

        $this->session->set_userdata("module",$this->data['dir']);

        if (!file_exists($dir)){
            mkdir($dir, 0777, true);
        }

        $config['allowed_types'] = '*';
        $config['overwrite'] = false;
        $config['max_size'] = 3064;
        $config['upload_path'] = $dir;
        $this->load->library('upload', $config);
        $this->load->model("Global_m");
        $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

        $selection = array(
            "selection_milestone"
        );
        foreach ($selection as $key => $value) {
            $this->data[$value] = $this->session->userdata($value);
        }

        if(empty($userdata)){
            redirect(site_url('log/in'));
        }

    }

    public function iimport_json()
    {
        $s = file_get_contents(base_url('uploads/item.json'));
        $a = json_decode($s);

        echo "<pre>";
        $ppm = array();
        $no = 0;
        foreach ($a as $k => $v) {
            $ppm['ppm_subject_of_work'] = $v->nama_proyek;
            $ppm['ppm_scope_of_work'] = $v->nama_proyek;
            $ppm['ppm_planner'] = $v->nama_user;
            $ppm['ppm_mata_anggaran'] = $v->kode_departemen;
            $ppm['ppm_nama_mata_anggaran'] = $v->nama_departemen;
            $ppm['ppm_currency'] = $v->mata_uang;
            $ppm['ppm_project_id'] = $v->spk_code;

            $loc = $v->periode_locking;
            $ddd = explode('/', $loc);

            $data = $v->data;
            $ppi = array();
            foreach ($data as $ka => $va) {
                $aaa = array();
                foreach ($va->detail as $key => $val) {
                    $pen = explode('/', $val->periode_pengadaan);

                    $aaa['spk_code'] = $v->spk_code;
                    $aaa['project_name'] = $v->nama_proyek;
                    $aaa['dept_code'] = $v->kode_departemen;
                    $aaa['dept_name'] = $v->nama_departemen;
                    $aaa['group_smbd_code'] = $va->kode_master_sumberdaya;
                    $aaa['group_smbd_name'] = $va->nama_master_sumberdaya;
                    $aaa['smbd_type'] = $va->kelompok_sumberdaya;
                    $aaa['smbd_code'] = $va->kode_sumberdaya;
                    $aaa['smbd_name'] = $va->nama_sumberdaya;
                    $aaa['unit'] = $va->satuan;
                    $aaa['smbd_quantity'] = $val->volume_sumberdaya;
                    $aaa['periode_pengadaan'] = $pen[2].'-'.$pen[1].'-'.$pen[0];
                    $aaa['price'] = $va->harga_satuan;
                    $aaa['total'] = $val->total_nilai;
                    $aaa['coa_code'] = $va->kode_coa;
                    $aaa['coa_name'] = $va->nama_coa;
                    $aaa['currency'] = $v->mata_uang;
                    $aaa['user_id'] = $v->user_id;
                    $aaa['user_name'] = $v->nama_user;
                    $aaa['periode_locking'] = $ddd[2].'-'.$ddd[1].'-'.$ddd[0];
                    $aaa['is_matgis'] = 'f';

                    $ppi[] = $aaa;
                }


            }
            // print_r($ppi);
            // echo "<br>";
            // print_r($no++);
            // echo "<br>";
            $this->db->insert_batch('prc_plan_integrasi', $ppi);
            $this->db->insert('prc_plan_main', $ppm);
        }
        print_r('done!!!');

        die;
    }

    public function sync() {

        $ch_login = curl_init( CRM_WIKA_LOGIN );

        $data = array(
            'UserName' => 'ES941692@wika',
            'UserPassword' => 'ES941692@wika'
        );

        $payload = json_encode( $data );

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
        curl_setopt($ch_login, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
        );

        $result = curl_exec($ch_login);

        $header_size = curl_getinfo($ch_login, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        preg_match_all('/^set-cookie:\s*([^;]*)/mi', $header, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

        setcookie('BPMCSRF', $cookies['BPMCSRF']);
        setcookie('BPMLOADER', $cookies['BPMLOADER']);
        setcookie('_ASPXAUTH', $cookies['_ASPXAUTH']);
        setcookie('UserName', $cookies['UserName']);

        $this->session->set_userdata('BPMCSRF', $cookies['BPMCSRF']);

        curl_close($ch_login);

        redirect(site_url('administration/master_data/data_crm'));

    }

    ## START NEW SAP ##

    public function get_pr_grid($id='')
    {
        $data = array();

        $userdata = $this->Administration_m->getLogin();

        $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

        $query_emp_id = $this->db->where('employee_id', $userdata['employee_id'])->get('adm_employee_proyek')->result_array();

        foreach ($query_emp_id as $key => $r) {
            $allppm[] = $r['ppm_id'];
        }

        $job_title = array("GENERAL MANAJER", "MANAJER USER", "KEPALA DIVISI", "PELAKSANA PENGADAAN");

        if (!in_array($userdata['job_title'], $job_title)) {        
            $this->db->where_in("ppm_id", $allppm);
        }

        // echo "<pre>";
        // print_r($userdata);
        // die;

        $fil = $this->input->post();
        if (count($fil) > 0) {
            if ($fil['pg'] != '') {
                $this->db->where('vw_prc_pr_sap.ppm_dept_id', $fil['pg']);
            }
            if ($fil['project'] != '') {
                $this->db->where('vw_prc_pr_sap.ppm_project_id', $fil['project']);
            }
            if ($fil['prtype'] != '') {
                $this->db->where('vw_prc_pr_sap.ppis_pr_type', $fil['prtype']);
            }
        }

        $this->db->order_by('vw_prc_pr_sap.ppm_id', 'desc');

        if (in_array($userdata['job_title'], $job_title)) {
            if (( (count($fil) > 0) && ($fil['pg'] != '') ) || ( (count($fil) > 0) && ($fil['project'] != '') )) {
                $res = $this->db->get('vw_prc_pr_sap')->result_array();
                $data['data'] = $res;
            } else {
                $data['data'] = [];
            }
        } else {
            $res = $this->db->get('vw_prc_pr_sap')->result_array();
            $data['data'] = $res;
        }

        echo json_encode($data);
    }

    public function prn_sap_list()
    {
        include("perencanaan/list_data_sap_new.php");
    }

    public function view_data_sap_new($param='')
    {
        include("perencanaan/getdata_sap_new.php");
    }

    public function sqln_data_sap($filter, $limit, $offset)
    {
        $userdata = $this->data['userdata'];

        $allppm = array();

        $page = '';
        if ($limit != '') {
            $page = 'LIMIT '.$limit.' OFFSET '.$offset;
        }

        $query_emp_id = $this->db->where('employee_id', $userdata['employee_id'])->get('adm_employee_proyek')->result_array();

        $where = '';
        if (isset($filter['pg'])) {
            $where .= "prc_plan_main.ppm_dept_id = ".(int)$filter['pg']." AND ";
        }
        if (isset($filter['project'])) {
            $where .= "prc_plan_main.ppm_project_id = '".$filter['project']."' AND ";
        }
        if (isset($filter['drup'])) {
            $where .= "prc_plan_item.ppis_pr_type in ".$filter['drup']." AND ";
        }

        $order = "ORDER BY prc_plan_main.ppm_id DESC";
        if (isset($filter['orby'])) {
            $order = "order by prc_plan_main." . $filter['orby'] . " " . $filter['orty'];
        }

        if (!in_array($userdata['job_title'], $job_title)) {
            foreach ($query_emp_id as $key => $r) {
                $allppm[$key] = $r['ppm_id'];
            }
            $where .= "prc_plan_main.ppm_id IN (". implode(",",$allppm) .") AND ";
        }

        $sql = "
            SELECT distinct
            prc_plan_main.*,
            adm_dept.*,
            prc_plan_item.ppis_pr_type
            FROM prc_plan_mainn
            JOIN prc_plan_item ON prc_plan_item.ppm_id = prc_plan_main.ppm_id
            LEFT JOIN adm_dept ON adm_dept.dept_id = prc_plan_main.ppm_dept_id
            WHERE $where ppm_is_sap = 1
            $order
            $page
        ";

        return $this->db->query($sql);
    }

    public function sapn_draw($filter, $ppm_id)
    {
        $where = '';
        $like = '';
        if (isset($filter['prtype'])) {
            $where .= "ppi.ppis_pr_type = '".$filter['prtype']."' AND ";
        }
        if (isset($filter['pr'])) {
            $where .= "ppi.ppis_pr_number = ".$filter['pr']." AND ";
        }
        if (isset($filter['altex'])) {
            $like .= "ppi.ppis_acc_assig like '%".$filter['altex']."%' OR ";
            $like .= "ppi.ppis_pr_item like '%".$filter['altex']."%' OR ";
            $like .= "ppi.ppi_code like '%".$filter['altex']."%' OR ";
            $like .= "ppi.ppi_item_desc like '%".$filter['altex']."%' OR ";
            $like .= "ppi.ppi_satuan like '%".$filter['altex']."%'";
        }

        $strlike = '';
        if ($like != '') {
            $strlike = "(".$like.") AND";
        }

        $sql = "
        select
	        ppi.*,
        	ppi.ppis_pr_number,
        	p.ptm_status,
        	p.tit_pr_number
        from
        	prc_plan_item ppi
        left join (
        	select
        		pti.tit_pr_number,
        		max(ptm.ptm_status) ptm_status
        	from
        		prc_plan_item ppi
        	left join prc_tender_item pti on
        		ppi.ppis_pr_number = pti.tit_pr_number::int
        	left join prc_tender_main ptm on
        		ptm.ptm_number = pti.ptm_number
        	where
        		ppi_is_sap = 1 and
        		ppm_id = $ppm_id
        	group by pti.tit_pr_number
        ) p on ppi.ppis_pr_number = p.tit_pr_number::int
        where
        	ppi_is_sap = 1 AND $strlike $where
        	ppm_id = $ppm_id
        ";

        return $this->db->query($sql)->result_array();
    }

    ## END NEW SAP ##

    public function pr_sap_list()
    {
        include("perencanaan/list_data_sap.php");
    }

    public function pr_sap_non_proyek()
    {
        include("perencanaan/list_data_sap_non_proyek.php");
    }

    public function pr_sap_matgis()
    {
        include("perencanaan/list_data_sap_matgis.php");
    }

    public function pr_sap_import_ftp()
    {
        include("perencanaan/import_data_ftp.php");
    }

    public function pr_sap_import()
    {
        include("perencanaan/import_data.php");
    }

    public function submit_sap(){
        include("perencanaan/submit_sap.php");
    }

    private function scan_dir($dir) {
        $ignored = array('.', '..', '.svn', '.htaccess');
        print_r(array_diff(scandir($dir), array('.', '..')));
        die;
        $files = array();
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($dir . '/' . $file);
        }

        arsort($files);
        $files = array_keys($files);

        return ($files) ? $files : false;
    }

    public function submit_tgl_sap()
    {
        $d = $this->input->post();
        $i = array();
        if ($d['tgl_tender'] != '') {
            $i['ppms_tgl_tender'] = $d['tgl_tender'];
        }
        if ($d['tgl_po'] != '') {
            $i['ppms_tgl_po'] = $d['tgl_po'];
        }
        if ($d['tgl_target'] != '') {
            $i['ppms_target_kedatangan'] = $d['tgl_target'];
        }

        $this->db->where('ppm_id', $d['ppm_id']);
        $upd = $this->db->update('prc_plan_main', $i);

        if ($upd) {
            echo json_encode(true);
        } else {
            echo json_encode(false);
        }
    }

    public function get_tgl_sap()
    {
        $data = $this->db->get_where('prc_plan_main', ['ppm_id' => $this->input->post('ppm_id')]);
        echo json_encode($data->row_array());
    }

    public function upload_config($path) {
		if (!is_dir($path))
			mkdir($path, 0777, TRUE);
		$config['upload_path'] 		= './'.$path;
		$config['allowed_types'] 	= 'txt';
		// $config['allowed_types'] 	= 'csv|CSV|xlsx|XLSX|xls|XLS';
		$config['max_filename']	 	= '255';
		$config['encrypt_name'] 	= TRUE;
		$config['max_size'] 		= 4096;

        $fname = $_FILES['file']['name'];
        $name = str_replace(' ', '_', $fname);
        if(file_exists($config['upload_path'].$name)) {
            unlink($config['upload_path'].$name);
        }

		$this->load->library('upload', $config);
	}

    public function pr_proyek_pmcs($param1 = ""){

        switch ($param1) {

            case 'pembuatan_drup':
            include("perencanaan/pembuatan_drup.php");
            break;

            default:
            include("perencanaan/daftar_perencanaan_pmcs.php");
            break;

        }

    }

    public function pr_matgis($param1 = ""){

        switch ($param1) {

            case 'submit_matgis':
            include("perencanaan/matgis/submit_pembuatan_matgis.php");
            break;

            case 'pembuatan_matgis':
            include("perencanaan/pembuatan_perencanaan_matgis.php");
            break;

            case 'data_perencanaan_matgis':
            include("perencanaan/matgis/data_perencanaan_matgis.php");
            break;

            case 'lihat':
            include("perencanaan/matgis/lihat_perencanaan_matgis.php");
            break;

            default:
            include("perencanaan/daftar_perencanaan_matgis.php");
            break;

        }

    }

    public function pr_non_proyek_drup($param1 = ""){

        switch ($param1) {

            case 'pembuatan_drup':
            include("perencanaan/pembuatan_drup.php");
            break;

            default:
            include("perencanaan/list_drup.php");
            // include("perencanaan/daftar_drup.php");
            break;

        }

    }

    public function pr_proyek_non_pmcs($param1 = ""){

        switch ($param1) {

            case 'pembuatan_proyek_non_pmcs':
            include("perencanaan/pembuatan_proyek_non_pmcs.php");
            break;

            default:
            include("perencanaan/daftar_proyek_non_pmcs.php");
            break;

        }

    }

    public function submit_proses_drup(){
        include("perencanaan/submit_proses_drup.php");
    }

    public function hapus($id){
        include("perencanaan/delete_daftar_drup.php");
    }

    public function submit_pembuatan_perencanaan_pengadaan()
    {
        include("perencanaan/submit_pembuatan_perencanaan_pengadaan.php");
    }

    public function submit_pembuatan_proyek_non_pmcs()
    {
        include("perencanaan/submit_pembuatan_proyek_non_pmcs.php");
    }

    public function get_list_volume()
    {
        $post = $this->input->post();
        $page = $post['page'];
        $kode_smbd = $post['smbd_code'];
        $search = $post['search'];
        $limit = $post['rows'];

        if ($page < 1) {
            $offset = 0;
        } elseif ($page > 0) {
            $offset = $limit * $page;
        }

        $s_sql = "
            select
                prc_plan_integrasi.smbd_code,
                prc_plan_integrasi.smbd_name,
                prc_plan_integrasi.unit,
                SUM (prc_plan_integrasi.smbd_quantity)::float as smbd_quantity,
                SUM (prc_plan_integrasi.price)::float as price,
                SUM (prc_plan_integrasi.smbd_quantity)::float * SUM (prc_plan_integrasi.price)::float as total,
                prc_plan_integrasi.updated_date
            from prc_plan_integrasi
            where
                prc_plan_integrasi.smbd_code = '".$kode_smbd."'
            group by
                prc_plan_integrasi.smbd_code,
                prc_plan_integrasi.smbd_name,
                prc_plan_integrasi.unit,
                prc_plan_integrasi.updated_date
        ";


        $smbd = $this->db->query($s_sql)->row_array();
        $data['head'] = $smbd;

        $this->db->select("
            EXTRACT ( YEAR FROM MIN ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ) as min,
            EXTRACT ( YEAR FROM MAX ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ) as max
        ");
        $year = $this->db->get_where('prc_plan_integrasi', ['smbd_code' => $kode_smbd])->row_array();
        $data['year'] = $year;

        ## clone
        $month = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        for ($i=$year['min']; $i <= $year['max']; $i++) {
            $this->db->select("
                id,
                smbd_quantity,
                EXTRACT ( MONTH FROM TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) as month
            ");
            $this->db->from('prc_plan_integrasi');
            $this->db->where("EXTRACT ( YEAR FROM TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) =". $i);
            $this->db->where('smbd_code', $kode_smbd);
            $this->db->order_by("EXTRACT ( MONTH FROM TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ");

            $clone = $this->db->get()->result_array();
            foreach ($clone as $k => $v) {
                if ($v['smbd_quantity'] > 0) {
                    $cc = $this->db->get_where('prc_plan_change_period', ['id_ppi' => $clone[$k]['id']])->num_rows();
                    if ($cc < 1) {
                        $inn = [
                            'id_ppi' => $clone[$k]['id'],
                            'volume' => $clone[$k]['smbd_quantity'],
                            'period' => $i.'-'.$month[$clone[$k]['month']-1].'-01',
                            'createdate' => date("Y-m-d H:i:s"),
                            'smbd' => $kode_smbd,
                        ];

                        $this->db->insert('prc_plan_change_period', $inn);
                    }
                }
            }
        }

        $vol = [];
        for ($i=$year['min']; $i <= $year['max']; $i++) {
            $vl = [0,0,0,0,0,0,0,0,0,0,0,0];
            $ids = [0,0,0,0,0,0,0,0,0,0,0,0];
            $ch = array();

            $ch['year'] = $i;
            $ch['unit'] = $smbd['unit'];

            $sqll = "
                SELECT *,
                EXTRACT ( MONTH FROM TO_DATE( period, 'YYYY-MM-DD' ) ) as month,
                EXTRACT ( YEAR FROM TO_DATE( period, 'YYYY-MM-DD' ) ) as year
                FROM prc_plan_change_period
                WHERE smbd = '$kode_smbd' AND EXTRACT ( YEAR FROM TO_DATE( period, 'YYYY-MM-DD' ) ) = '$i'
            ";
            $sv = $this->db->query($sqll)->result_array();

            if (count($sv) > 0) {
                foreach ($sv as $k => $v) {
                    $vl[$v['month']-1] = $vl[$v['month']-1] + $v['volume'];
                    $ids[$v['month']-1] = $v['id'];
                }
                $ch['vol'] = $vl;
                $ch['ids'] = $ids;
            } else {
                $ch['vol'] = $vl;
                $ch['ids'] = $ids;
            }


            $vol[] = $ch;
        }

        $data['volume'] = $vol;
        $data['kode_smbd'] = $kode_smbd;

        $data['limit'] = $limit;
        $data['offset'] = $offset;
        $data['page'] = (int)$page + 1;
        $data['shows'] = $limit;
        $data['num_rows'] = count($vol);

        echo json_encode($data);
    }

    public function change_period()
    {
        $post = $this->input->post();
        $month = ['01','02','03','04','05','06','07','08','09','10','11','12'];
        $bulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"];
        $period = $post['y'].'-'.$month[$post['m']].'-01';
        $prev = $this->db->get_where('prc_plan_integrasi', ['id' => $post['i']])->row_array();

        $upd = [
            'period' => $period,
            'createdate' => date("Y-m-d H:i:s"),
        ];
        $this->db->where('id', $post['i']);
        $insert = $this->db->update('prc_plan_change_period', $upd);

        $hist = $this->Procpr_m->get_prcplanintegrasismbd($post['s'])->row_array();

        $arr_hist = [
            'kode_spk' => $hist['spk_code'],
            'nama_spk' => $hist['project_name'],
            'desc' => "Mengubah periode pengadaan ke ". $bulan[$post['m']]. ' ' .$post['y'],
            'kasie_pengadaan' => $hist['user_name'],
            'lokasi' => $hist['lokasi'],
            'sisa_volume' => $hist['ppv_remain'],
            'updatedate' => date("Y-m-d H:i:s"),
            'smbd' => $post['s'],
        ];

        $this->db->insert('prc_plan_history', $arr_hist);

        $res = $insert ? true : false;
        echo json_encode($res);
    }

    public function data_rencana_pengadaan()
    {
        $post = $this->input->post();
        $page = $post['page'];
        $limit = $post['rows'];

        $filter = [];
        if (isset($post['fil'])) {
            $filter = [
                'fil' => $post['fil'],
                'divisi' => $post['divisi'],
                'b_date' => $post['b_date'],
                'period' => $post['period'],
                'free_text' => $post['free_text'],
            ];
        }

        if ($page < 1) {
            $offset = 0;
        } elseif ($page > 0) {
            $offset = $limit * $page;
        }

        $data = array();
        $data['limit'] = $limit;
        $data['offset'] = $offset;
        $data['page'] = (int)$page + 1;
        $data['shows'] = $limit;
        $data['num_rows'] = $this->Procpr_m->get_prcplanintegrasi($filter,'','')->num_rows();
        $data['result'] = $this->Procpr_m->get_prcplanintegrasi($filter, $limit, $offset)->result_array();

        echo json_encode($data);
    }

    public function export_pmcs(){
        $post = $this->input->post();

        $filter = [
            'divisi' => $post['se_divisi'] != '' ? $post['se_divisi'] : '',
            'b_date' => $post['datetimes'] != '' ? $post['datetimes'] : '',
            'period' => $post['datepicker'] != '' ? $post['datepicker'] : '',
            'free_text' => $post['cari_text'] != '' ? $post['cari_text'] : '',
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $sheet->setCellValue('A1', "RENCANA PENGADAAN PMCS"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B3', "KODE SUMBER DAYA"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C3', "NAMA SUMBER DAYA"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D3', "NAMA PROYEK"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E3', "DIVISI"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('F3', "SATUAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G3', "VOLUME"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H3', "HARGA SATUAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('I3', "TOTAL HARGA"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('J3', "SISA VOLUME"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('K3', "LOKASI"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('L3', "KASIE PENGADAAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('M3', "TANGGAL SINGKRON"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('N3', "PERIODE"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);
        $sheet->getStyle('M3')->applyFromArray($style_col);
        $sheet->getStyle('N3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $pmcs = $this->Procpr_m->get_prcplanintegrasi($filter,'','')->result();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($pmcs as $data){ // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A'.$numrow, $no);
            $sheet->setCellValue('B'.$numrow, $data->smbd_code);
            $sheet->setCellValue('C'.$numrow, $data->smbd_name);
            $sheet->setCellValue('D'.$numrow, $data->project_name);
            $sheet->setCellValue('E'.$numrow, $data->divisiname);
            $sheet->setCellValue('F'.$numrow, $data->unit);
            $sheet->setCellValue('G'.$numrow, $data->smbd_quantity);
            $sheet->setCellValue('H'.$numrow, $data->price);
            $sheet->setCellValue('I'.$numrow, $data->total);
            $sheet->setCellValue('J'.$numrow, $data->ppv_remain);
            $sheet->setCellValue('K'.$numrow, $data->lokasi);
            $sheet->setCellValue('L'.$numrow, $data->user_name);
            $sheet->setCellValue('M'.$numrow, $data->updated_date);
            $sheet->setCellValue('N'.$numrow, $data->periode_pengadaan);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('J'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('L'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('M'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('N'.$numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(10); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('J')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('K')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('L')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('M')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('N')->setWidth(20); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Data PMCS");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data PMCS.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

    }

    public function export_matgis(){
        $post = $this->input->post();

        $filter = [
            'divisi' => $post['se_divisi'] != '' ? $post['se_divisi'] : '',
            'b_date' => $post['datetimes'] != '' ? $post['datetimes'] : '',
            'period' => $post['datepicker'] != '' ? $post['datepicker'] : '',
            'free_text' => $post['cari_text'] != '' ? $post['cari_text'] : '',
        ];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $sheet->setCellValue('A1', "RENCANA PENGADAAN MATGIS"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B3', "KODE SUMBER DAYA"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C3', "NAMA SUMBER DAYA"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D3', "NAMA PROYEK"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E3', "DIVISI"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('F3', "SATUAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G3', "VOLUME"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H3', "HARGA SATUAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('I3', "TOTAL HARGA"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('J3', "SISA VOLUME"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('K3', "LOKASI"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('L3', "KASIE PENGADAAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('M3', "TANGGAL SINGKRON"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('N3', "PERIODE"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);
        $sheet->getStyle('M3')->applyFromArray($style_col);
        $sheet->getStyle('N3')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $pmcs = $this->Procpr_m->get_prcplanintegrasi_matgis($filter,'','')->result();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($pmcs as $data){ // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A'.$numrow, $no);
            $sheet->setCellValue('B'.$numrow, $data->smbd_code);
            $sheet->setCellValue('C'.$numrow, $data->smbd_name);
            $sheet->setCellValue('D'.$numrow, $data->project_name);
            $sheet->setCellValue('E'.$numrow, $data->divisiname);
            $sheet->setCellValue('F'.$numrow, $data->unit);
            $sheet->setCellValue('G'.$numrow, $data->smbd_quantity);
            $sheet->setCellValue('H'.$numrow, $data->price);
            $sheet->setCellValue('I'.$numrow, $data->total);
            $sheet->setCellValue('J'.$numrow, $data->ppv_remain);
            $sheet->setCellValue('K'.$numrow, $data->lokasi);
            $sheet->setCellValue('L'.$numrow, $data->user_name);
            $sheet->setCellValue('M'.$numrow, $data->updated_date);
            $sheet->setCellValue('N'.$numrow, $data->periode_pengadaan);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('J'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('L'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('M'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('N'.$numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(10); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('J')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('K')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('L')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('M')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('N')->setWidth(20); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Data MATGIS");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data MATGIS.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

    }

    public function export_sap(){
        $post = $this->input->post();

        $filter = array();
        $filter['free_text'] = $post['cari_text'];
        $filter['tgl_pemakaian'] = $post['tgl_pemakaian'];
        $filter['tipe'] = $post['tipe'];

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $sheet->setCellValue('A1', "RENCANA PENGADAAN MATGIS"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->mergeCells('A3:A4'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->setCellValue('B3', "PROFIT CENTER"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->mergeCells('B3:B4'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->setCellValue('C3', "PROJECT DEFINISI"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D3', "DIVISI"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E3', "HARGA"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->mergeCells('E3:E4'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->setCellValue('F3', "STORAGE LOCATION"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G3', "PURCHASE GROUP"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H3', "START PROJECT"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('I3', "FINISH PROJECT"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('J3', "NUMBER PR"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->mergeCells('J3:J4'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->setCellValue('K3', "WBS ELEMENT"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->mergeCells('K3:K4'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->setCellValue('L3', "NETWORK"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->mergeCells('L3:L4'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->setCellValue('M3', "REMARK"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->mergeCells('M3:M4'); // Set Merge Cell pada kolom A1 sampai E1

        $sheet->setCellValue('C4', "MATERIAL DESC"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->mergeCells('C4:D4'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->setCellValue('F4', "VOLUME"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('G4', "HARGA SATUAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->setCellValue('H4', "TANGGAL PEMAKAIAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        $sheet->mergeCells('H4:I4'); // Set Merge Cell pada kolom A1 sampai E1

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A3')->applyFromArray($style_col);
        $sheet->getStyle('B3')->applyFromArray($style_col);
        $sheet->getStyle('C3')->applyFromArray($style_col);
        $sheet->getStyle('D3')->applyFromArray($style_col);
        $sheet->getStyle('E3')->applyFromArray($style_col);
        $sheet->getStyle('F3')->applyFromArray($style_col);
        $sheet->getStyle('G3')->applyFromArray($style_col);
        $sheet->getStyle('H3')->applyFromArray($style_col);
        $sheet->getStyle('I3')->applyFromArray($style_col);
        $sheet->getStyle('J3')->applyFromArray($style_col);
        $sheet->getStyle('K3')->applyFromArray($style_col);
        $sheet->getStyle('L3')->applyFromArray($style_col);
        $sheet->getStyle('M3')->applyFromArray($style_col);

        $sheet->getStyle('A4')->applyFromArray($style_col);
        $sheet->getStyle('B4')->applyFromArray($style_col);
        $sheet->getStyle('C4')->applyFromArray($style_col);
        $sheet->getStyle('D4')->applyFromArray($style_col);
        $sheet->getStyle('E4')->applyFromArray($style_col);
        $sheet->getStyle('F4')->applyFromArray($style_col);
        $sheet->getStyle('G4')->applyFromArray($style_col);
        $sheet->getStyle('H4')->applyFromArray($style_col);
        $sheet->getStyle('I4')->applyFromArray($style_col);
        $sheet->getStyle('J4')->applyFromArray($style_col);
        $sheet->getStyle('K4')->applyFromArray($style_col);
        $sheet->getStyle('L4')->applyFromArray($style_col);
        $sheet->getStyle('M4')->applyFromArray($style_col);

        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $sap = $this->sql_data_sap($filter,'','')->result();

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 5; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($sap as $data){ // Lakukan looping pada variabel siswa

            $pname = $data->$data->ppm_project_name;
            $issap = $data->ppm_is_sap < 1 ? 'PMCS' : 'SAP';
            $sheet->setCellValue('A'.$numrow, $no);
            $sheet->setCellValue('B'.$numrow, $data->ppm_project_id);
            $sheet->setCellValue('C'.$numrow, $pname);
            $sheet->setCellValue('D'.$numrow, $data->ppm_project_name);
            $sheet->setCellValue('F'.$numrow, $data->ppms_storage_loc);
            $sheet->setCellValue('G'.$numrow, $data->ppm_dept_name);
            $sheet->setCellValue('H'.$numrow, $data->ppms_start_date);
            $sheet->setCellValue('I'.$numrow, $data->ppms_finish_date);
            $sheet->setCellValue('M'.$numrow, $issap);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('B'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('C'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('D'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('E'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('F'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('G'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('H'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('I'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('J'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('K'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('L'.$numrow)->applyFromArray($style_row);
            $sheet->getStyle('M'.$numrow)->applyFromArray($style_row);

            $ld = $this->sap_draw($filter, $data->ppm_id);
            foreach ($ld as $val) {
                $sheet->setCellValue('A'.($numrow+1), '-');
                $sheet->setCellValue('B'.($numrow+1), $val['ppi_code']);
                $sheet->setCellValue('C'.($numrow+1), $val['ppi_item_desc']);
                $sheet->mergeCells('C'.($numrow+1).':D'.($numrow+1));
                $sheet->setCellValue('E'.($numrow+1), $val['ppi_harga']);
                $sheet->setCellValue('F'.($numrow+1), $val['ppi_jumlah']);
                $sheet->setCellValue('G'.($numrow+1), $val['ppi_satuan']);
                $sheet->setCellValue('H'.($numrow+1), $val['ppis_used_date']);
                $sheet->mergeCells('H'.($numrow+1).':I'.($numrow+1));
                $sheet->setCellValue('J'.($numrow+1), $val['ppis_pr_number']);
                $sheet->setCellValue('K'.($numrow+1), $val['ppis_wbs_element_desc']);
                $sheet->setCellValue('L'.($numrow+1), $val['ppis_network_desc']);
                $sheet->setCellValue('M'.($numrow+1), $val['ppis_remark']);

                $sheet->getStyle('A'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('B'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('C'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('D'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('E'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('F'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('G'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('H'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('I'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('J'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('K'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('L'.($numrow+1))->applyFromArray($style_row);
                $sheet->getStyle('M'.($numrow+1))->applyFromArray($style_row);

                $numrow++; // Tambah 1 setiap kali looping
            }

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('F')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('G')->setWidth(20); // Set width kolom E
        $sheet->getColumnDimension('H')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('I')->setWidth(15); // Set width kolom E
        $sheet->getColumnDimension('J')->setWidth(25); // Set width kolom E
        $sheet->getColumnDimension('K')->setWidth(25); // Set width kolom E
        $sheet->getColumnDimension('L')->setWidth(25); // Set width kolom E
        $sheet->getColumnDimension('M')->setWidth(25); // Set width kolom E


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Data SAP");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data SAP.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

    }

    public function view_data_sap($fa = '')
    {
        $post = $this->input->post();
        $page = $post['page'];
        $limit = $post['rows'];
        // echo "<pre>";
        // print_r($post);
        // die;

        $filter = array();
        if (isset($post['fil'])) {
            $filter['fil'] = $post['fil'];
            // $filter['divisi'] = $post['divisi'];
            // $filter['project'] = $post['project'];
            $filter['tipe'] = $post['tipe'];
            $filter['nopr'] = $post['nopr'];
            if ($fa == 'proyek') {
                $filter['ppis_pr_type'] = 'proyek';
            } else if ($fa == 'matgis') {
                $filter['ppis_pr_type'] = 'matgis';
            } else {
                $filter['ppis_pr_type'] = 'non_proyek';
            }
        }

        if ($page < 1) {
            $offset = 0;
        } elseif ($page > 0) {
            $offset = $limit * $page;
        }

        $data = array();
        $data['limit'] = $limit;
        $data['offset'] = $offset;
        $data['page'] = (int)$page + 1;
        $data['shows'] = $limit;
        $data['num_rows'] = $this->sql_data_sap($filter,'','')->num_rows();

        $raw = $this->sql_data_sap($filter, $limit, $offset)->result_array();
        $list = [];

        for ($i=0; $i < count($raw); $i++) {
            $ld = $this->sap_draw($filter, $raw[$i]['ppm_id']);
            if (count($ld) > 0) {
                $head = $raw[$i];
                $body = ['item' => $ld];
                $list[] = array_merge($head, $body);
            }
        }

        $data['result'] = $list;
        echo json_encode($data);
    }

    public function sql_data_sap($filter, $limit, $offset)
    {
        $page = '';
        if ($limit != '') {
            $page = 'LIMIT '.$limit.' OFFSET '.$offset;
        }

        $where = $join = '';
        if (count($filter) > 0) {
            if ($filter['tipe'] != '') {
                $where .= "ppm_is_sap = '".$filter['tipe']."' AND ";
            }
            // if ($filter['divisi'] != '') {
            //     if ($filter['tipe'] == 1) {
            //         $where .= "ppms_planner_pos_code = '".$filter['divisi']."' AND ";
            //     } else {
            //         $where .= "ppm_planner_pos_code = '".$filter['divisi']."' AND ";
            //     }
            // }
            // if ($filter['project'] != '') {
            //     $where .= "ppm_id = '".$filter['project']."' AND ";
            // }
            if (($filter['nopr'] != '') && ($filter['nopr'] != 0)) {
                $where .= "ppis_pr_number = ".(int)$filter['nopr']." AND ";
            }

            if (isset($filter['ppis_pr_type'])) {
                if ($filter['ppis_pr_type'] == 'matgis') {
                    $join .= "JOIN adm_dept ON adm_dept.dept_id = prc_plan_main.ppm_dept_id";
                    $where .= "adm_dept.dept_id = 13 AND ";
                } elseif ($filter['ppis_pr_type'] == 'proyek') {
                    $join .= "JOIN prc_plan_item ON prc_plan_item.ppm_id = prc_plan_main.ppm_id";
                    $where .= "ppis_pr_type IN ('ZPW2','ZPW3', 'ZPW4') AND ";
                } else {
                    $join .= "JOIN prc_plan_item ON prc_plan_item.ppm_id = prc_plan_main.ppm_id";
                    $where .= "ppis_pr_type IN ('ZPW1') AND ";
                }
            }
        }

        $sql = "
        SELECT distinct(prc_plan_main.*) FROM prc_plan_main
        $join
        WHERE $where 1=1
        ORDER BY prc_plan_main.ppm_id DESC
        $page
        ";

        return $this->db->query($sql);
    }

    public function sap_draw($filter, $ppm_id)
    {
        $where = '';
        if (count($filter) > 0) {

            if (isset($filter['ppis_pr_type'])) {
                if ($filter['ppis_pr_type'] == 'proyek') {
                    $where .= "AND ppis_pr_type IN ('ZPW2','ZPW3', 'ZPW4')";
                } else if($filter['ppis_pr_type'] == 'non_proyek') {
                    $where .= "AND ppis_pr_type = 'ZPW1'";
                } else {
                    $where .= "AND ppis_pr_type IN ('ZPW2')";
                }
            }
        //
        //     if ($filter['free_text'] != "") {
        //         $where .= "(
        //             ppi_code LIKE '%".$filter['free_text']."%' OR
        //             ppi_item_desc LIKE '%".$filter['free_text']."%' OR
        //             ppi_jumlah LIKE '%".$filter['free_text']."%' OR
        //             ppi_satuan LIKE '%".$filter['free_text']."%' OR
        //             ppi_harga LIKE '%".$filter['free_text']."%' OR
        //             ppis_wbs_element_desc LIKE '%".$filter['free_text']."%' OR
        //             ppis_network_desc LIKE '%".$filter['free_text']."%' OR
        //             ppis_remark LIKE '%".$filter['free_text']."%' OR
        //             ppis_pr_number LIKE '%".$filter['free_text']."%') AND ";
        //     }
            if ($filter['nopr'] != '') {
                $where .= " AND ppis_pr_number = ".(int)$filter['nopr'];
            }
        }

        $sql = "
        SELECT * FROM prc_plan_item ppd
        WHERE ppm_id ='".$ppm_id." ' $where
        ";
        // $sql = "
        // SELECT * FROM prc_plan_item ppd
        // WHERE $where ppm_id ='".$ppm_id." '
        // ";

        return $this->db->query($sql)->result_array();
    }

    public function data_drup()
    {
        $post = $this->input->post();
        $page = $post['page'];
        $limit = $post['rows'];

        $filter = array();
        if (isset($post['fil'])) {
            $filter['fil'] = $post['fil'];
            $filter['free_text'] = $post['free_text'];
            $filter['swakelola'] = $post['swakelola'];
            $filter['penyedia'] = $post['penyedia'];
            $filter['se_tgl'] = $post['se_tgl'];
            $filter['sdate'] = $post['sdate'];
            $filter['edate'] = $post['edate'];
            $filter['order'] = $post['order'];
            $filter['sort'] = $post['sort'];
        }

        if ($page < 1) {
            $offset = 0;
        } elseif ($page > 0) {
            $offset = $limit * $page;
        }

        $data = array();
        $data['limit'] = $limit;
        $data['offset'] = $offset;
        $data['page'] = (int)$page + 1;
        $data['shows'] = $limit;
        $data['num_rows'] = $this->sql_drup($filter,'','')->num_rows();

        $raw = $this->sql_drup($filter, $limit, $offset)->result_array();
        $list = [];
        $dd = [];
        foreach ($raw as $i => $v) {
            $ld = $this->drup_draw($filter, $v['coa_id']);
            if (count($ld) > 0) {
                $dd['coa_id'] = $v['coa_id'];
                $dd['kode_perkiraan'] = $v['kode_perkiraan'];
                $dd['nama_perkiraan'] = $v['nama_perkiraan'];
                $dd['detail'] = count($ld) < 1 ? [] : $ld;
                $list[] = $dd;
            }
        }

        $data['result'] = $list;
        echo json_encode($data);
    }

    public function drup_draw($filter, $coa_id)
    {
        $where = $orderby = '';
        if (count($filter) > 0) {

            if ($filter['free_text'] != "") {
                $where .= "(
                    kode_sumber_daya LIKE '%".$filter['free_text']."%' OR
                    nama_program LIKE '%".$filter['free_text']."%' OR
                    satuan LIKE '%".$filter['free_text']."%' OR
                    pemilik_program LIKE '%".$filter['free_text']."%' OR
                    pengelola_anggaran LIKE '%".$filter['free_text']."%' OR
                    catatan LIKE '%".$filter['free_text']."%') AND ";
            }
            if ($filter['swakelola'] != '') {
                $where .= "
                    swakelola = '".$filter['swakelola']."' AND ";
            }
            if ($filter['penyedia'] != '') {
                $where .= "
                    penyedia = '".$filter['penyedia']."' AND ";
            }
            if ($filter['se_tgl'] != '') {
                if ($filter['se_tgl'] == 'Pengadaan') {
                    if ($filter['sdate'] != '') {
                        $where .= "
                            tgl_mulai_pengadaan = '".$filter['sdate']."' AND ";
                    }
                    if ($filter['edate'] != '') {
                        $where .= "
                            tgl_akhir_pengadaan = '".$filter['edate']."' AND ";
                    }
                } else {
                    if ($filter['sdate'] != '') {
                        $where .= "
                            tgl_mulai_pekerjaan = '".$filter['sdate']."' AND ";
                    }
                    if ($filter['edate'] != '') {
                        $where .= "
                            tgl_akhir_pekerjaan = '".$filter['edate']."' AND ";
                    }
                }
            }
            if (($filter['order'] != '') && ($filter['sort'] != '')) {
                $orderby .= "ORDER BY ".$filter['order']." ".$filter['sort'];
            }
        }

        $sql = "
            SELECT * FROM prc_proses_drup ppd
            WHERE $where coa_id ='".$coa_id." '
            $orderby
        ";

        return $this->db->query($sql)->result_array();
    }

    public function sql_drup($filter, $limit, $offset)
    {
        $page = '';
        if ($limit != '') {
            $page = 'LIMIT '.$limit.' OFFSET '.$offset;
        }

        $sql = "
            SELECT DISTINCT coa_id, kode_perkiraan, nama_perkiraan
            FROM prc_proses_drup JOIN adm_coa_new ON adm_coa_new.id = prc_proses_drup.coa_id
            $page
        ";

        return $this->db->query($sql);
    }

    public function data_rencana_pengadaan_matgis()
    {
        $post = $this->input->post();
        $page = $post['page'];
        $limit = $post['rows'];

        $filter = [];
        if (isset($post['fil'])) {
            $filter = [
                'fil' => $post['fil'],
                'divisi' => $post['divisi'],
                'b_date' => $post['b_date'],
                'period' => $post['period'],
                'free_text' => $post['free_text'],
            ];
        }

        if ($page < 1) {
            $offset = 0;
        } elseif ($page > 0) {
            $offset = $limit * $page;
        }

        $data = array();
        $data['limit'] = $limit;
        $data['offset'] = $offset;
        $data['page'] = (int)$page + 1;
        $data['shows'] = $limit;
        $data['num_rows'] = $this->Procpr_m->get_prcplanintegrasi_matgis($filter,'','')->num_rows();
        $data['result'] = $this->Procpr_m->get_prcplanintegrasi_matgis($filter, $limit, $offset)->result_array();

        echo json_encode($data);
    }

    public function detail_rencana_pengadaan_history()
    {
        $post = $this->input->post();
        $page = $post['page'];

        $filter = [];
        $filter['smbd'] = $post['smbd_code'];
        if (isset($post['fil'])) {
            $filter['fil'] =  $post['fil'];
            $filter['dd'] = $post['date'];
            $filter['search'] =  $post['search'];
        }

        $limit = $post['rows'];
        if ($page < 1) {
            $offset = 0;
        } elseif ($page > 0) {
            $offset = $limit * $page;
        }

        $data = array();
        $data['limit'] = $limit;
        $data['offset'] = $offset;
        $data['page'] = (int)$page + 1;
        $data['shows'] = $limit;
        $data['num_rows'] = $this->Procpr_m->query_pmcs_hisoty($filter,'','')->num_rows();
        $data['result'] = $this->Procpr_m->query_pmcs_hisoty($filter, $limit, $offset)->result_array();

        echo json_encode($data);
    }

    public function get_divisi()
    {
        $tipe = $this->input->post('tipe');
        $sql = "
            select
                distinct(ppm.ppm_planner_pos_name),
                case
                    when (ppm.ppm_planner_pos_code::text notnull ) then ppm.ppm_planner_pos_code::text
                    else ppm.ppms_planner_pos_code
                end as ppm_planner_pos_code
            from prc_plan_main ppm
            join prc_plan_item ppi on ppm.ppm_id = ppi.ppm_id
            where ppm.ppm_planner_pos_name notnull and ppm.ppm_is_sap = $tipe
        ";

        echo json_encode($this->db->query($sql)->result_array());
    }

    public function get_project()
    {
        $divisi = $this->input->post('divisi');
        $tipe = $this->input->post('tipe');
        $sql = '';
        if ($tipe < 1) {
            $sql = "
                select ppm_id, ppm_subject_of_work project
                from prc_plan_main
                where ppm_planner_pos_code = ". (int)$divisi;
        } else {
            $sql = "
                select ppm_id, ppm_subject_of_work project
                from prc_plan_main
                where ppms_planner_pos_code = '".$divisi."'";
        }

        echo json_encode($this->db->query($sql)->result_array());
    }

    public function get_pr()
    {
        $ppm_id = $this->input->post('ppm_id');
        $data = $this->db->get_where('prc_plan_item', ['ppm_id' => $ppm_id])->result_array();

        echo json_encode($data);
    }

    public function return_sap()
    {
        $ppm_id = $this->input->post('ppm_id');

        $sql = "
            select * from prc_plan_main ppm
            where ppm.ppm_id = $ppm_id
        ";

        $ppm = $this->db->get_where('prc_plan_main', ['ppm_id' => $ppm_id])->row_array();
        $ppi = $this->db->get_where('prc_plan_item', ['ppm_id' => $ppm_id])->result_array();

        // $sql_hist = "
        //     SELECT * FROM prc_plan_item ppi
        //     JOIN prc_plan_volume ppv ON ppi.ppm_id = ppv.ppm_id
        //     JOIN prc_plan_hist pph ON ppi.ppm_id = pph.ppm_id
        //     WHERE ppi.ppm_id = $ppm_id
        // ";
        $pph = $this->Comment_m->getAnggaran($ppm_id)->result_array();
        // $this->db->query($sql_hist)->result_array();

        $data = [
            'ppm' => $ppm,
            'ppi' => $ppi,
            'pph' => $pph
        ];

        echo json_encode($data);
    }

}
