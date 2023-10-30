<?php
$selection = $this->data['selection_pengamanan'];

$this->db->trans_begin();

$aktifkan = $this->Administration_m->ActivatePengamanan($selection,'barang');

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

$this->unset_session('selection_pengamanan');
