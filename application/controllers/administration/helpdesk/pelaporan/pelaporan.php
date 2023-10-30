<?php
$get_url = $this->db->get('vnd_pelaporan')->result_array();;

$title = 'Pelaporan';
$data['get_data'] = $get_url;

$view = 'administration/helpdesk/pelaporan_v';
$this->template($view, $title, $data);
