<?php
$this->db->where('jenis_dokumen', 2);
$query = $this->db->get('adm_dokumen_flow');

$data['get_list'] = $query->result_array();
$title = 'Video Flow Sistem';

$view = 'administration/helpdesk/video_v';
$this->template($view, $title, $data);
