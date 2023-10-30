<?php 

$id= $this->uri->segment(5, 0);

$data = array(
'active' => "Nonaktif",
);    

$update = $this->Administration_m->updateRegion($id, $data);

redirect(site_url('administration/master_data/lokasi_proyek'));