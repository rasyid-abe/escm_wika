<?php

$this->db->order_by("faq_id", "desc");
$this->db->where('category', 1);
$get_url1 = $this->db->get("vnd_faq_helpdesk")->result_array();

$this->db->where('category', 2);
$get_url2 = $this->db->get("vnd_faq_helpdesk")->result_array();

$this->db->where('category', 3);
$get_url3 = $this->db->get("vnd_faq_helpdesk")->result_array();

$this->db->where('category', 4);
$get_url4 = $this->db->get("vnd_faq_helpdesk")->result_array();

$title = 'FAQ';
$data['get_list1'] = $get_url1;
$data['get_list2'] = $get_url2;
$data['get_list3'] = $get_url3;
$data['get_list4'] = $get_url4;

$view = 'administration/helpdesk/faq_v';
$this->template($view, $title, $data);
