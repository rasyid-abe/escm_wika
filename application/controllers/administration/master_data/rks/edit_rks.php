<?php

    $this->db->where('id', $id);
    $query = $this->db->get('adm_rks');

    $data = array(
    'controller_name'=>"administration",
    );

    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/rks/edit_rks_v',"Ubah RKS",$data);
