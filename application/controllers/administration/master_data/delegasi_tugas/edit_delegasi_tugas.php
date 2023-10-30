<?php 

    $this->db->where('id', $id);
    $query = $this->db->get('adm_delegasi');
    
    $employee=$this->db->get('vw_employee')->result_array();

    $data = array(
    'controller_name'=>"administration",
    'employee' =>$employee,
    'employee1' =>$employee
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/delegasi_tugas/edit_delegasi_tugas_v',"Ubah Delegasi Pekerjaan",$data);