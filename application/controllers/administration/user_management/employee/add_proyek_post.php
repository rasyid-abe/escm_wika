<?php
	
    $proyek_post=$this->Administration_m->get_proyek_post()->result_array();

    $data = array(
        'controller_name'=>"administration",
        'proyek_post' =>$proyek_post,
        'employee_id'=>$id,
    );

    $this->template('administration/user_management/employee/add_proyek_post_v',"Tambah Proyek", $data);
  