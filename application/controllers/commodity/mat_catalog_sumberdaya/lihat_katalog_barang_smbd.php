<?php 

$view = 'commodity/mat_catalog_sumberdaya/lihat_katalog_barang_smbd_v';
$data['v'] = $this->Commodity_m->getMatCatalogSmbd($id)->row_array();
$getdata = $this->Comment_m->getCommodity($id)->result_array();
$data['dir'] = COMMODITY_KATALOG_BARANG_FOLDER;
if(!empty($getdata)){
	$data["comment_list"][0] = $getdata;
}
$this->template($view,"Lihat Katalog Barang Sumberdaya",$data);