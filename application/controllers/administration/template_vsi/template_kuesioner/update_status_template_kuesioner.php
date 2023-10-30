<?php

$status = $this->uri->segment(5,0);
$id  = $this->uri->segment(6,0);

$this->db->trans_begin();

$cek = $this->Administration_m->getTemplateKuesioner("", array('atk_status'=>'Aktif'))->result_array();

if ($cek != NULL && $status == "aktif") {
	
	echo "<script> alert('Hanya satu template yang dapat diaktifkan. Silahkan non aktifkan template lain terlebih dulu')</script>";
    echo "<script> location.href = '".site_url('administration/template_vsi/template_kuesioner')."' </script>";

}else{
	$update = $this->Administration_m->UpdateStatusTemplateKuesioner($id, $status);
	if ($this->db->trans_status() === FALSE)
	{
	  $this->setMessage("Gagal memproses data");
	  $this->db->trans_rollback();
	}
	else
	{
	  $this->setMessage("Sukses memproses data");
	  $this->db->trans_commit();

	}

	redirect(site_url('administration/template_vsi/template_kuesioner'));
}