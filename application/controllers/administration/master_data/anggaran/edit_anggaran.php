<?php

    $data = array(
    'controller_name'=>"administration",
    'dept'=>$this->Administration_m->get_divisi_departemen()->result_array(),
    );

    $this->db->where('id', $id);
    $query = $this->db->get('adm_coa_new');

    $data['data'] = $query->row_array();
    $data['id'] = $id;

    $this->template('administration/master_data/anggaran/edit_anggaran_v',"Ubah Anggaran (COA)",$data);
