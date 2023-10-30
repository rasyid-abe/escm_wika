<?php 

$id = $this->session->userdata['avk_id'];

$get = $this->input->get();

$data[$get['key']] = $get['data'];
$data['updated_datetime'] = date('Y-m-d h:i:s');

$this->db->trans_begin();

$update = $this->Administration_m->updateKuesioner($id, $data);

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

// redirect(site_url('administration/template_vsi/template_kuesioner'));