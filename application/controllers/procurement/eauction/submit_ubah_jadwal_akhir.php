<?php

$post = $this->input->post();

$ppm_id = (isset($post['ppm_id']) && !empty($post['ppm_id'])) ? $post['ppm_id'] : "";
$new_date = (isset($post['new_date']) && !empty($post['new_date'])) ? $post['new_date'] : "";

if(!empty($new_date) || $new_date != ""){
    $new_date = str_replace("T"," ", $new_date);
    $rows = $this->db->query("UPDATE prc_eauction_header SET tanggal_berakhir = '".$new_date."' WHERE ppm_id ='".$ppm_id."' ");
}
$this->output->set_content_type('application/json')->set_output(json_encode($post));