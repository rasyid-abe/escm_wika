<?php
	$this->db->trans_begin();
            if (!empty($this->get('no_spk'))) {
                $this->db->where('spk_code', $this->get('no_spk'));
            }else{
            	$this->response(array('status' => 'No SPK tidak boleh kosong', 'status_code' => 502));
            	exit();
            }
            if (!empty($this->get('kode_departemen'))) {
                 $this->db->where('dep_code', $this->get('kode_departemen'));
            }else{
                $this->response(array('status' => 'Kode Departemen tidak boleh kosong', 'status_code' => 502));
                exit();
            }
            if (!empty($this->get('no_bapb'))) {
                 $this->db->where('bastp_number', $this->get('no_bapb'));
            }
            if (!empty($this->get('no_sppm'))) {
                $this->db->where('sppm_number', $this->get('no_sppm'));
            }
            $this->db->where('bastp_type', 'bapb');
            $data_bapb = $this->db->get('vw_data_bastp_pmcs')->result_array();

            if (count($data_bapb) > 0) {
                
            $data = array(); 
            $no = 0;
            foreach ($data_bapb as $key => $value) {
            	$this->db->select('kode_sumberdaya,volume_sumberdaya,satuan_sumberdaya,harga_satuan,is_matgis');
                $this->db->where('bastp_number', $value['bastp_number']);
                $data_sumberdaya = $this->db->get('vw_data_item_bastp_pmcs')->result_array();
            	$data[$key]['no_bapb'] = $value['bastp_number'];
    			$data[$key]['no_spk'] = $value['spk_code'];
                $data[$key]['no_sppm'] = $value['sppm_number'];
			    $data[$key]['kode_departemen']= $value['dep_code'];
			    $data[$key]['tanggal_bapb']= $value['bastp_date'];
			    $data[$key]['no_po']= $value['po_number'];
			    $data[$key]['kode_nasabah']= $value['nasabah_code'];
            	$data[$key]['sumberdaya'] = $data_sumberdaya;
            	// break;
            	$no++;
            }

        if ($this->db->trans_status() === FALSE)
            {   
                $this->db->trans_rollback();
                $this->response(array('status' => 'fail', 'status_code' => 502));
            }else{
                $this->db->trans_commit();
                $this->response(array('status' => 'success', 'status_code' => 200, 'result' => $data));
            }
        }else{
            $this->response(array('status' => 'warning', 'status_code' => 501, 'result' => 'Data tidak ditemukan'));
        }