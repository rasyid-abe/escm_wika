<?php
$selection = $this->data['selection_pengamanan'];

$this->db->trans_begin();

$nonaktifkan = $this->Administration_m->NonaktifPengamanan($selection,'jasa');

if ($this->db->trans_status() === FALSE)
  {
    $this->db->trans_rollback();
    echo "Gagal Menonaktifkan data";
  }
  else
  {
    $this->db->trans_commit();
    echo "Sukses Menonaktifkan data";

  }

$this->unset_session('selection_pengamanan');
