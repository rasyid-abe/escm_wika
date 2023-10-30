<?php 
    $view = 'padi/detail_umkm_v';

    $vendor_id = $this->uri->segment(4, 0);

    $data = array();

    $data['umkm'] = $this->db->where('id', $vendor_id)->get('vw_padi_umkm')->row_array();

    $this->template($view,"Data UMKM",$data);
?>