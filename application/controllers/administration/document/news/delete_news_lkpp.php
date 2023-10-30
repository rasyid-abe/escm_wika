<?php

$this->db->where('id', $id);
$del = $this->db->delete('vnd_news_lkpp');

if($del){
	$this->setMessage("Berhasil menghapus berita");
}

redirect(site_url('administration/news'));
