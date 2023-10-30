<?php
$selection = $this->data['selection_hasil_mutu_pekerjaan'];
if (empty($selection)) {
  $this->setMessage("Pilih data untuk dinonaktifkan");
  $this->template_vpi('penilaian_penyedia_jasa/hasil_mutu_pekerjaan');
  exit();
}
$this->db->trans_begin();

$nonaktifkan = $this->Administration_m->NonaktifHasilMutuPekerjaan($selection,'jasa');

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

$this->unset_session('selection_hasil_mutu_pekerjaan');
