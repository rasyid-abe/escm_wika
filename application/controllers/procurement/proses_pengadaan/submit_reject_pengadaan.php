<?php

    $userdata = $this->data['userdata'];

    if(isset($rfq)) {

        $this->db->trans_begin();

        $this->db->where('ptm_number', $rfq);
        $this->db->where('ptc_activity', 1140);
        $row = $this->db->get('prc_tender_comment')->row_array();
        
        //row last comment
        $this->db->where('ptm_number', $rfq);
        $this->db->order_by('ptc_id', 'desc');
        $lastrow = $this->db->get('prc_tender_comment')->row_array();
        //update last activity
        $update = array(
            'ptc_response' => 'reject_uskep',
            'ptc_comment' => $lastrow['ptc_position'],
            'ptc_end_date' => date('Y-m-d h:i:s'),
            'ptc_user' => $userdata['employee_id']
        );
        
        $this->db->where('ptc_id', $lastrow['ptc_id']);
        $this->db->update('prc_tender_comment', $update);
        
        $data = array(
            'ptm_status' => 1140
        );

        $this->db->where('ptm_number', $rfq);
        $this->db->update('prc_tender_main', $data);

        $insert = array(
            'ptc_activity' => 1140,
            'ptm_number' => $rfq,
            'ptc_pos_code' => $row['ptc_pos_code'],
            'ptc_position' => $row['ptc_position'],
            'ptc_start_date' => date('Y-m-d h:i:s')
        );
        
        $this->db->insert('prc_tender_comment', $insert);  
        
        

        if ($this->db->trans_status() === FALSE) {
    
            $this->setMessage("Gagal Reject Data");
            $this->db->trans_rollback();

        } else {
    
            //$this->setMessage("Sukses Reject Data");
            $this->db->trans_commit();
            $this->renderMessage("success Reject Data",site_url("procurement/daftar_pekerjaan"));  

        }

        $this->renderMessage("success");

    } else {

        $this->renderMessage("error");
    }


?>