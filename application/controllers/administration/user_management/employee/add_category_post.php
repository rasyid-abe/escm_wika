<?php    

    $data = array(
        'controller_name'=>"administration",     
        'employee_id'=>$id,
    );

    $this->template('administration/user_management/employee/add_category_post_v',"Tambah Kategori", $data);
  