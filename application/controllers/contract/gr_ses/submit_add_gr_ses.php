<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

    $data = array(
        'devid' => $tambah['devid'],
        'packageid' => $tambah['packageid'],
        'cocode' => $tambah['cocode'],
        'mat_doc' => $tambah['mat_doc'],
        'doc_year' => $tambah['doc_year'],
        'doc_date' => $tambah['doc_date'],
        'psting_date' => $tambah['psting_date'],
        'matdoc_itm' => (int)$tambah['matdoc_itm'],
        'ref_doc' => $tambah['ref_doc'],
        'material' => $tambah['material'],
        'plant' => $tambah['plant'],
        'move_type' => $tambah['move_type'],
        'quantity' => $tambah['quantity'],
        'entry_uom' => $tambah['entry_uom'],
        'po_number' => $tambah['po_number'],
        'po_item' => (int)$tambah['po_item'],
        'sync_at' => date('Y-m-d h:i:s'),
        'status' => 2
    );

    $insert = $this->db->insert('ctr_gr_ses', $data);

    if($insert){
    	$this->setMessage("Berhasil menambah data.");
    }

}

redirect(site_url('contract/gr_ses'));