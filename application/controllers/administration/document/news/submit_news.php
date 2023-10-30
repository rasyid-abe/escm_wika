<?php
if (is_uploaded_file($_FILES['image']['tmp_name'])) {
    $this->upload->do_upload('image');
    $files = $this->upload->data();
    $data['image'] = $files['file_name'] ? $files['file_name'] : '';
}else{
    unset($data['image']);
}

$post = $this->input->post();

$userdata = $this->Administration_m->getLogin();

$data = array(
	'kategori' => $post['kategori'],
	'tittle' => $post['tittle'],
	'content' => $post['content'],
	'image' => $data['image']
	);

  // print_r($data);

$insert = $this->db->insert('vnd_news', $data);

if($insert){
	$this->setMessage("Berhasil menambah berita");
}

redirect(site_url('administration/news'));
