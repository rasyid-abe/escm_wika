<?php 

    $post = $this->input->post();

    $userdata = $this->data['userdata'];

    $check = 0;
    
    $this->db->trans_begin();

    if($post['id_inp'] > 0) {
        $this->db->where(array("id" => $post['id_inp']));
        $check = $this->db->get("prc_proses_drup")->num_rows();
    }

    if($check > 0){
        $update = array(        
            'kode_sumber_daya' => $this->security->xss_clean($post['kode_item']),
            'nama_program' => $this->security->xss_clean($post['deskripsi_item_inp']),
            'pemilik_program' => $this->security->xss_clean($post['pemilik_program_inp']),
            'pengelola_anggaran' => $this->security->xss_clean($post['pengelola_anggaran_inp']),
            'penyedia' => $this->security->xss_clean($post['jenis_penyedia_inp']),
            'swakelola' => isset($post['swakelola_inp']) ? 'Ya' : 'Tidak',
            'tgl_mulai_pengadaan' => $this->security->xss_clean($post['tgl_mulai_pengadaan_inp']),
            'tgl_akhir_pengadaan' => $this->security->xss_clean($post['tgl_akhir_pengadaan_inp']),
            'tgl_mulai_pekerjaan' => $this->security->xss_clean($post['tgl_mulai_pekerjaan_inp']),
            'tgl_akhir_pekerjaan' => $this->security->xss_clean($post['tgl_akhir_pekerjaan_inp']),
            'volume' => $this->security->xss_clean(moneytoint($post['jumlah_item_inp'])),
            'satuan' => $this->security->xss_clean($post['satuan_item_inp']),
            'harga_satuan' => $this->security->xss_clean(moneytoint($post['harga_satuan_item_inp'])),
            'catatan' => $this->security->xss_clean($post['catatan_inp']),
            'pic_user' => $this->security->xss_clean($post['pic_inp']),
            'currency' => $this->security->xss_clean($post['drup_currency']),
            'date_updated' => date("Y-m-d H:i:s"),
            'updated_by' => $userdata['complete_name']
        );
        
        $this->db->where('id', $post['id_inp'])->update('prc_proses_drup', $update);

    } else {
        $input = array(
            'coa_id' => $this->security->xss_clean($post['coa_id_inp']),            
            'kode_sumber_daya' => $this->security->xss_clean($post['kode_item']),
            'nama_program' => $this->security->xss_clean($post['deskripsi_item_inp']),
            'pemilik_program' => $this->security->xss_clean($post['pemilik_program_inp']),
            'pengelola_anggaran' => $this->security->xss_clean($post['pengelola_anggaran_inp']),
            'penyedia' => $this->security->xss_clean($post['jenis_penyedia_inp']),
            'swakelola' => isset($post['swakelola_inp']) ? 'Ya' : 'Tidak',
            'tgl_mulai_pengadaan' => $this->security->xss_clean($post['tgl_mulai_pengadaan_inp']),
            'tgl_akhir_pengadaan' => $this->security->xss_clean($post['tgl_akhir_pengadaan_inp']),
            'tgl_mulai_pekerjaan' => $this->security->xss_clean($post['tgl_mulai_pekerjaan_inp']),
            'tgl_akhir_pekerjaan' => $this->security->xss_clean($post['tgl_akhir_pekerjaan_inp']),
            'volume' => $this->security->xss_clean(moneytoint($post['jumlah_item_inp'])),
            'satuan' => $this->security->xss_clean($post['satuan_item_inp']),
            'harga_satuan' => $this->security->xss_clean(moneytoint($post['harga_satuan_item_inp'])),
            'catatan' => $this->security->xss_clean($post['catatan_inp']),
            'pic_user' => $this->security->xss_clean($post['pic_inp']),
            'currency' => $this->security->xss_clean($post['drup_currency']),
            'date_created' => date("Y-m-d H:i:s"),
            'created_by' => $userdata['complete_name']
        );
     
        $this->db->insert('prc_proses_drup', $input); 
    }

    if ($this->db->trans_status() === FALSE)  {
        $this->setMessage("Gagal menambah data");
        $this->db->trans_rollback();
    }
    else  {
        $this->setMessage("Sukses menambah data");
        $this->db->trans_commit();
    }

    $this->renderMessage("success",site_url("perencanaan_pengadaan/pr_non_proyek_drup/pembuatan_drup"));

?>