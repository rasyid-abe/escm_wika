<?php
$this->db->where('jenis_dokumen', 1);
$query = $this->db->get('adm_dokumen_flow');

$data['get_list'] = $query->result_array();
$title = 'Flow ESCM';

$view = 'administration/helpdesk/flow_v';
$this->template($view, $title, $data);
