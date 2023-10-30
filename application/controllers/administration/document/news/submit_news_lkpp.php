<?php

$post = $this->input->post();

$userdata = $this->Administration_m->getLogin();

$data = array(
	'link_img' => $post['link_img'],
	'link_title' => $post['link_title'],
	'link_content' => $post['link_content'],
	'link_lanjutan' => $post['link_lanjutan']
	);

$insert = $this->db->insert('vnd_news_lkpp', $data);

if($insert){
	$this->setMessage("Berhasil menambah berita LKPP");
}

redirect(site_url('administration/news'));
