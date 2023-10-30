<?php

    $employee=$this->db->get('vw_employee')->result_array();

    $data = array(
    'controller_name'=>"administration",
    'employee1' =>$employee,
    'employee' =>$employee
    );

    $this->template('administration/master_data/delegasi_tugas/add_delegasi_tugas_v',"Tambah Delegasi Pekerjaan",$data);
  