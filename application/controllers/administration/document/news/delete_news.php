<?php

$this->db->where('news_id', $id);
$del = $this->db->delete('vnd_news');

if($del){
	$this->setMessage("Berhasil menghapus berita");
}

redirect(site_url('administration/news'));
