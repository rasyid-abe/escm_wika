<?php
$selection = $this->data['selection_k3l'];

$this->db->trans_begin();

$nonaktifkan = $this->Administration_m->ActivateK3l($selection,'jasa');

if ($this->db->trans_status() === FALSE)
  {
    $this->db->trans_rollback();
    echo "Gagal Mengaktifkan data";
  }
  else
  {
    $this->db->trans_commit();
    echo "Sukses Mengaktifkan data";

  }

$this->unset_session('selection_k3l');
