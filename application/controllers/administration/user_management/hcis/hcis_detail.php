<?php 


    $this->db->where('nip', $id);
    $query = $this->db->get('vw_user_employee_hcis');

    $data = array(
    'controller_name'=>"administration"
    );
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $view = 'administration/user_management/hcis/hcis_detail_v';
    $this->template($view,"Detail HCIS",$data);