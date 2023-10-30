<?php

$selection = $this->data['selection_kuesioner'];

$this->db->trans_begin();

$nonaktifkan = $this->Administration_m->UpdateStatusKuesioner($selection);

if ($this->db->trans_status() === FALSE)
  {
    // $this->setMessage("Gagal memproses data");
    $this->db->trans_rollback();
    echo "Gagal Mengubah Data";
  }
  else
  {

    // $this->setMessage("Sukses memproses data");
    $this->db->trans_commit();
    echo "Sukses Mengubah Data";

  }

$this->unset_session('selection_kuesioner');
