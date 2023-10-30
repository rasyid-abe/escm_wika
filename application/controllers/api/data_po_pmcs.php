<?php
	$this->db->trans_begin();

            if (!empty($this->get('no_spk'))) {
                // $this->db->where('no_spk', $this->get('no_spk'));
                $nomor_spk = $this->get('no_spk');
            }else{
            	$this->response(array('status' => 'No SPK tidak boleh kosong', 'status_code' => 502));
            	exit();
            }

            if (!empty($this->get('kode_departemen'))) {
                 // $this->db->where('kode_departemen', $this->get('kode_departemen'));
                $kode_dept = $this->get('kode_departemen');
            }else{
                $this->response(array('status' => 'Kode Departemen tidak boleh kosong', 'status_code' => 502));
                exit();
            }

            if (!empty($this->get('no_kontrak'))) {
                $nomor_kontrak = $this->get('no_kontrak');
            }else{
                $nomor_kontrak = '';
            }

            if (!empty($this->get('jenis_kontrak'))) {
                $jenis_kontrak = $this->get('jenis_kontrak');
            }else{
                $jenis_kontrak = '';
            }

            if (!empty($this->get('no_po'))) {
                 // $this->db->where('no_po', $this->get('no_po'));
                $nomor_po = $this->get('no_po');
            }else{
                $nomor_po = '';
            }

           $data = $this->db->query("SELECT * FROM api_data_po_pmcs('".$nomor_spk."','".$nomor_kontrak."','".$kode_dept."','".$nomor_po."','".$jenis_kontrak."')")->row()->api_data_po_pmcs;

       //      $data_po = $this->db->get('vw_data_po_pmcs')->result_array();
       //      if (count($data_po) > 0) {

       //      $data = array(); 
       //      $no = 0;
       //      foreach ($data_po as $key => $value) {
       //      	$this->db->select('kode_sumberdaya,volume_sumberdaya,satuan_sumberdaya,harga_satuan,is_matgis');
       //      	$this->db->where('po_id', $value['po_id']);
       //      	$data_sumberdaya = $this->db->get('vw_data_item_po_pmcs')->result_array();
       //      	$data[$key]['no_kontrak'] = $value['no_kontrak'];
    			// $data[$key]['tanggal_mulai_kontrak'] = $value['tanggal_mulai_kontrak'];
			    // $data[$key]['tanggal_akhir_kontrak']= $value['tanggal_akhir_kontrak'];
			    // $data[$key]['no_po']= $value['no_po'];
			    // $data[$key]['tanggal_po']= $value['tanggal_po'];
			    // $data[$key]['no_spk']= $value['no_spk'];
			    // $data[$key]['kode_departement']= $value['kode_departement'];
			    // $data[$key]['kode_nasabah']= $value['kode_nasabah'];
			    // $data[$key]['fasilitas_bank']= $value['fasilitas_bank'];
       //      	$data[$key]['sumberdaya'] = $data_sumberdaya;
       //      	// break;
       //      	$no++;
       //      }

        if ($this->db->trans_status() === FALSE)
            {   
                $this->db->trans_rollback();
                $this->response(array('status' => 'fail', 'status_code' => 502));
            }else{
                $this->db->trans_commit();
                $this->response(array('status' => 'success', 'status_code' => 200, 'result' => json_decode($data)));
            }
        // }else{
        //     $this->response(array('status' => 'warning', 'status_code' => 501, 'result' => 'Data tidak ditemukan'));
        // }