<?php 

$view = 'commodity/kat_jasa_sumberdaya/lihat_katalog_jasa_smbd_v';
$data['v'] = $this->Commodity_m->getSrvCatalogSmbd($id)->row_array();
$getdata = $this->Comment_m->getCommodity($id)->result_array();
$data['dir'] = COMMODITY_KATALOG_JASA_FOLDER;
if(!empty($getdata)){
	$data["comment_list"][0] = $getdata;
}
$this->template($view,"Lihat Katalog Jasa Sumberdaya",$data);

