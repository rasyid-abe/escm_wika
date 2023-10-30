<?php 
    $view = 'padi/detail_transaksi_v';

    $transaksi_id = $this->uri->segment(4, 0);

    $data = array();

    $data['transaksi'] = $this->db->where('id', $transaksi_id)->get('vw_padi_transaksi')->row_array();

    $this->template($view,"Data Transaksi",$data);
?>