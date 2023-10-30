<?php 

$id= $this->uri->segment(5, 0);

$data = array(
'active' => "Nonaktif",
);    

$update = $this->Administration_m->updateMasterMdiv($id, $data);

redirect(site_url('administration/master_data/master_mdiv'));