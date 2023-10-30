<?php
    $view = 'contract/gr_ses/daftar_gr_ses_v';
    
    $data = array();

    $data['po_number'] = $this->db->select('ctr_po_number')->where('ctr_po_number !=', NULL)->get("prc_tender_main")->result_array();

    $this->template($view,"Daftar Data GR/SES", $data);
?>
