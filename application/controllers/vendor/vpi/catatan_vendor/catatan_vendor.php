<?php
  $view = 'vendor/vpi/catatan_vendor/catatan_vendor_v';
  $query = $this->db->get('vnd_vpi_note');

  $data = array();
  $data['catatan'] = $query->result_array();

  $this->template($view, "Catatan Vendor", $data);
?>
