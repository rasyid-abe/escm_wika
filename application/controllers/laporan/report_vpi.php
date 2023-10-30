<?php 
    $view = 'laporan/report_vpi_v';
    $data = array();
    $year = 0;
    $param = $_GET;
    if(isset($param['year']))
    {
        $year = $param['year'];
    }
   
    $getYear = $this->db->get('vw_year_list');

    $data = array();
    $data['year'] = $getYear->result_array();

    $data['data_vendor'] = [];
    $data['data_proyek'] = [];
    $data['data_divisi'] = [];

    $this->db->where('vpi_year', $year);
    
    $data_vendor = $this->db->get('vw_report_vpi_score_vendor')->result_array();
    $data_proyek = $this->db->get('vw_report_vpi_score_proyek')->result_array();
    $data_divisi = $this->db->get('vw_report_vpi_score_dept')->result_array();

    $data['data_vendor'] = $data_vendor;
    $data['data_proyek'] = $data_proyek;
    $data['data_divisi'] = $data_divisi;
    

    $this->template($view,"REPORT VPI",$data);
?>