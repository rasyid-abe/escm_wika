<?php

	$this->db->trans_begin();
 
    $this->db->where('id', $id)->delete('prc_proses_drup');

    if ($this->db->trans_status() === FALSE)  {
        $this->setMessage("Gagal hapus data");
        $this->db->trans_rollback();
    }
    else  {
        $this->setMessage("Sukses hapus data");
        $this->db->trans_commit();
    }	

	redirect(site_url('perencanaan_pengadaan/pr_non_proyek_drup/pembuatan_drup'));

?>
