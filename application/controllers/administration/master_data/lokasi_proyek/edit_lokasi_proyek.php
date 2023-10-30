<?php 

$id = $this->uri->segment(5, 0);

$data = $this->Administration_m->getRegion($id)->row_array();

$data = [
    'controller_name' => "administration/master_data/lokasi_proyek",
    'id' => $id,
    'data' => $data
];

$this->template('administration/master_data/lokasi_proyek/edit_lokasi_proyek_v',"Ubah Lokasi Proyek",$data);