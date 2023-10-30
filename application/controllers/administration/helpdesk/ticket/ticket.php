<?php

$this->db->order_by("ticket_id", "desc");
$list = $this->db->get("vnd_ticket")->result_array();

$title = 'Daftar Tiket';
$data['get_list'] = $list;

$view = 'administration/helpdesk/ticket/ticket_v';

$this->template($view, $title, $data);
