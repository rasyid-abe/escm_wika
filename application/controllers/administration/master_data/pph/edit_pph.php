<?php 

    $data = array(
    'controller_name'=>"administration",
    );

    $this->db->where('id', $id);
    $query = $this->db->get('adm_master_pph');
    
    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/pph/edit_pph_v',"Ubah Data Master Pajak Penghasilan (PPh)",$data);