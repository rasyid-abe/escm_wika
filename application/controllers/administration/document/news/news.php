<?php

  $view = 'administration/news/news_v';

  $get_news_vendor = $this->db->get('vnd_news');
  $get_news_lkpp = $this->db->get('vnd_news_lkpp');

	$data['title'] = 'Daftar News';
	$data['get_list'] = $get_news_vendor->result_array();
	$data['get_lkpp'] = $get_news_lkpp->result_array();

  $this->template($view,"Daftar Berita", $data);
