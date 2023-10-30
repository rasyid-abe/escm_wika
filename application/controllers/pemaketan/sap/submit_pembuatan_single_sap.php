<?php

$userdata = $this->data['userdata'];

$position = $this->Administration_m->getPosition("PIC USER");

if (!$position) {
    $this->setMessage("Hanya PIC USER yang dapat membuat permintaan pengadaan");
    redirect("paket_pengadaan/paket_sap"); 
}

if (isset($_GET["submit_data_pr"])) {

    $v = $this->db->where('pr_number', $_GET["submit_data_pr"])->get('prc_pr_main')->row_array();    

    $itm = $this->db->where('pr_number', $_GET["submit_data_pr"])->get('prc_pr_item')->row_array();

    if(!isset($itm['ppi_dev_date']) || !isset($itm['ppi_pdt']) || !isset($itm['ppi_tax_code']) || !isset($itm['ppi_type_po']) || !isset($itm['ppi_po_date']) || !isset($itm['ppi_tender_date'])) {
        $this->setMessage("Gagal proses. Data belum dilengkapi.");
        redirect("paket_pengadaan/paket_sap"); 
    }

    if($v['pr_status'] > 1009) {
        $this->setMessage("Gagal proses data. Perencanaan sudah ada.");
        redirect("paket_pengadaan/paket_sap"); 
    }
    
    $item_inp = $this->db->where('pr_number', $_GET["submit_data_pr"])->get('prc_pr_item')->row_array();

    $perencanaan_id = $v['ppm_id'];
    $pr_number = $v['pr_number'];
    $response = 287;
    $com = "Lanjutkan";

    $this->db->trans_begin();    

    $data_update = array(
        'pr_dept_id' => $position['dept_id'],
        'pr_dept_name' => $position['dept_name'],
        'pr_created_date' => date("Y-m-d H:i:s"),
        'pr_requester_name' => $userdata['complete_name'],
        'pr_requester_pos_code' => $position['pos_id'],
        'pr_requester_pos_name' => $position['pos_name'],
        'pr_requester_id' => $userdata['employee_id']
    );
    $this->db->where('pr_number', $pr_number);
    $update_main = $this->db->update('prc_pr_main', $data_update);

    // insert data komentar
    $comment = $this->Comment_m->insertProcurementPR($pr_number, 1000, $com, $response);

    $last_id = $this->db->insert_id();

    $return = $this->Procedure_m->prc_pr_comment_complete($pr_number, $userdata['complete_name'], 1000, $response, $com, "", $last_id, $perencanaan_id, $userdata['employee_id'], "", $v['pr_type_of_plan'], "", "", "");

    if ($return['nextactivity'] == 1010) {
        $lasthist = $this->Procplan_m->getHist("", $perencanaan_id)->row_array();
        $hist = array(
            'ppm_id' => $perencanaan_id,
            'pph_main' => $lasthist['pph_remain'],
            'pph_date' => date("Y-m-d H:i:s"),
            'pph_desc' => $return['nextactivity'],
            'pph_first' => $pr_number,
            'pph_mod' => $pr_number
        );
        
        // potong anggaran
        // $potong = $this->Procplan_m->updateDataPerencanaanPengadaan($perencanaan_id, array('ppm_sisa_anggaran' => $post['sisa_pagu_inp']));
        // insert history anggaran
        $plan_hist = $this->Procplan_m->insertHist($hist);

        $check_vol = $this->Procplan_m->getVolumeHist("", $perencanaan_id)->result_array();
        if (count($check_vol) > 0) {
            $getVolumeHist = $this->Procplan_m->getVolumeHist($item_inp['ppi_code'], $perencanaan_id)->row_array();
            $dataVolume = array(
                'ppm_id' => $perencanaan_id,
                'ppv_main' => $getVolumeHist['ppv_main'],
                'ppv_minus' => $item_inp['ppi_quantity'],
                'ppv_remain' => ($getVolumeHist['ppv_main'] - $item_inp['ppi_quantity']),
                'ppv_activity' => 1010,
                'ppv_no' => $pr_number,
                'ppv_smbd_code' => $item_inp['ppi_code'],
                'ppv_unit' => $getVolumeHist['ppv_unit'],
                'ppv_prc' => "PR",
                'created_datetime' => date("Y-m-d H:i:s"),
            );
            $volumeHist = $this->Procplan_m->insertVolumeHist($dataVolume);
        }
    }

    if (!empty($return['nextactivity'])) {

        $comment = $this->Comment_m->insertProcurementPR($pr_number, $return['nextactivity'], "", "", "", $return['nextposcode'], $return['nextposname']);
    }

    if ($this->db->trans_status() === FALSE) {
        $this->setMessage("Gagal mengirim data");
        $this->db->trans_rollback();
    } else {
        $this->setMessage("Sukses mengirim data");
        $this->db->trans_commit();
    }

    redirect("paket_pengadaan/paket_sap"); 

} else {

    $this->setMessage("Nomor PR tidak ditemukan.");
    $error = true;
}

?>