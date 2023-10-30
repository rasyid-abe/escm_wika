<?php

$post = $this->input->post();

$data = array (
            'coa_id' => $this->input->post('coa_id'),
            'kode_sumber_daya' => $this->input->post('kode_sumber_daya'),
            'nama_program' => $this->input->post('nama_program'),
            'pemilik_program' => $this->input->post('pemilik_program'),
            'pengelola_anggaran' => $this->input->post('pengelola_anggaran'),
            'penyedia' => $this->input->post('penyedia'),
            'swakelola' => $this->input->post('swakelola'),
            'tgl_mulai_pengadaan' => $this->input->post('tgl_mulai_pengadaan'),
            'tgl_akhir_pengadaan' => $this->input->post('tgl_akhir_pengadaan'),
            'tgl_mulai_pekerjaan' => $this->input->post('tgl_mulai_pekerjaan'),
            'tgl_akhir_pekerjaan' => $this->input->post('tgl_akhir_pekerjaan'),
            'volume' => $this->input->post('volume'),
            'satuan' => $this->input->post('satuan'),
            'harga_satuan' => $this->input->post('harga_satuan'),
            'catatan' => $this->input->post('catatan'),
            'date_created' => date('Y-m-d h:i:s'),
            'created_by' => $this->userdata['user_name']
        );

$insert = $this->db->insert('prc_proses_drup', $data);

if($insert){
	$this->setMessage("Berhasil menambah data");
}

redirect(site_url('procurement/perencanaan_pengadaan/drup'));
