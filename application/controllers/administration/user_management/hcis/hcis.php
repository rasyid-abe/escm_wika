<?php 

  $view = 'administration/user_management/hcis/hcis_v';

  $hcis = $this->db->get('vw_user_employee_hcis')->result_array();
  


  $data = array(

      'jumlah' =>1,
      'data_hcis'=> json_encode($hcis)
    );

  

  $this->template($view,"USER HCIS",$data);