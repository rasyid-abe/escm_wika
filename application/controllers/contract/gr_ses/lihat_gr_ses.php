<?php

$view = 'contract/gr_ses/lihat_gr_ses_v';

$gr_id = $this->uri->segment(4);

$position = $this->Administration_m->getPosition("ADMIN");

if(!$position){
    $this->noAccess("Hanya Admin yang dapat melihat");
}

$data['row'] = $this->Contract_m->getGrses($gr_id)->row_array();

$this->template($view, "Detail Data GR/SES", $data);
