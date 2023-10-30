<?php

$ticket_id = $this->uri->segment(5, 0);

$this->db->where('ticket_id', $ticket_id);
$query = $this->db->get('vnd_ticket');

$this->db->where('ticket_id', $ticket_id);
$res = $this->db->get('vnd_ticket_chat');

$data = array();
$title = 'Detail Ticket';
$data['data_detail'] =  $query->row();
$data['res'] =  $res->result_array();

$view = 'administration/helpdesk/ticket/ticket_detail_v';
$this->template($view, $title, $data);
