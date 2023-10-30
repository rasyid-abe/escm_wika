<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

    foreach (array('pos_name_inp','job_title_inp') as $key => $value) {
        $tambah[$value] = $this->security->xss_clean($tambah[$value]);
    }

    $this->db->select_max('pos_id');
    $max_id = $this->db->get('adm_pos');

    if (($max_id+1) == 212) {
    
        $this->db->query('SELECT setval("adm_pos_pos_id_seq", COALESCE((SELECT MAX(pos_id::integer)+2 FROM adm_pos), 1), false)');
    }

    $data = array(
        'pos_name' => $tambah['pos_name_inp'],
        'dept_id' => $tambah['dept_id_inp'],
        'job_title' =>$tambah['job_title_inp'],
        'district_id' => $tambah['district_id_inp'],
        );

    $insert = $this->db->insert('adm_pos', $data);

    if($insert){
        $this->setMessage("Berhasil menambah posisi");
    }

}

redirect(site_url('administration/admin_tools/position'));