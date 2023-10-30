<?php
	$view = 'contract/proses_kontrak/release_po_v';

	// $position = $this->Administration_m->getPosition("PIC USER");

	// if(!$position){
	// 	$this->noAccess("Hanya PIC USER yang dapat membuat kontrak manual");
	// }

	$data = array();

	$this->template($view,"Pesan Release PO dari SAP",$data);
?>
