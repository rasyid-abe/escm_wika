<?php 

defined('BASEPATH') OR exit('No direct script access allowed');

class Master_pr extends Telescoope_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Contract_m"));        

        $userdata = $this->Administration_m->getLogin();

        $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

        $userdata = $this->data['userdata'];

        if(empty($userdata)){
            redirect(site_url('log/in'));
        }
    }

    public function index($detailId = "")
    {
    
    }

    public function get_main($id = "")
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

        $fil = $this->input->post();
        
        if (count($fil) > 0) {
            if ($fil['pg'] != '') {
                $this->db->where('vw_prc_perencanaan_rari.pr_dept_id', $fil['pg']);
            }
            if ($fil['project'] != '') {
                $this->db->where('vw_prc_perencanaan_rari.pr_spk_code', $fil['project']);
            }
            if ($fil['prtype'] != '') {
                $this->db->where('vw_prc_perencanaan_rari.ppis_pr_type', $fil['prtype']);
            }
        }

        $this->db->order_by('vw_prc_perencanaan_rari.pr_number', 'desc');

        if (!in_array($userdata['job_title'], $job_title)) {
            if (( (count($fil) > 0) && ($fil['pg'] != '') ) || ( (count($fil) > 0) && ($fil['project'] != '') )) {
                $res = $this->db->get('vw_prc_perencanaan_rari')->result_array();
                $data['data'] = $res;
            } else {
                $data['data'] = [];
            }
        } else {
            if (count($fil) > 0) {                
                $res = $this->db->get('vw_prc_perencanaan_rari')->result_array();
                $data['data'] = $res;

            } else {
                $data['data'] = [];
            }
        }

        echo json_encode($data);
    }

    public function get_vendor($id = "")
    {
        $data = array();

        $this->db->order_by('vendor_id', 'desc');
        $res = $this->db->get('vnd_header')->result_array();

        $data['data'] = $res;
        echo json_encode($data);
    }
    
    public function update_pr()
    {
       $post = json_decode($this->input->post('values'));
       $key = $this->input->post('key');

       $this->db->where('ppi_id', $key);
       $this->db->update('prc_pr_item', $post);

       $code = 200;

       echo json_encode(array('code'=> $code));
       
    }
}

?>