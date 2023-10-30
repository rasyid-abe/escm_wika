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

            if (!empty($this->get('no_invoice'))) {
                 $this->db->where('invoice_number', $this->get('no_invoice'));
            }

            $data = $this->db->get('vw_data_invoice_pmcs')->result_array();

            if (count($data) > 0) {
                
            $data_invoice = array(); 
            $no = 0;
            foreach ($data as $key => $value) {
                $this->db->select('kode_sumberdaya,volume_sumberdaya,satuan_sumberdaya,harga_satuan,is_matgis');
                $this->db->where('invoice_number', $value['invoice_number']);
                $data_sumberdaya = $this->db->get('vw_data_item_invoice_pmcs')->result_array();
                $data_invoice[$key]['no_bast'] = $value['bastp_number'];
                $data_invoice[$key]['no_invoice'] = $value['invoice_number'];
                $data_invoice[$key]['no_spk'] = $value['spk_code'];
                $data_invoice[$key]['kode_departemen']= $value['dep_code'];
                $data_invoice[$key]['tanggal_invoice']= $value['invoice_date'];
                $data_invoice[$key]['kode_nasabah']= $value['nasabah_code'];
                $data_invoice[$key]['sumberdaya'] = $data_sumberdaya;
                $no++;
            }

        if ($this->db->trans_status() === FALSE)
            {   
                $this->db->trans_rollback();
                $this->response(array('status' => 'fail', 'status_code' => 502));
            }else{
                $this->db->trans_commit();
                $this->response(array('status' => 'success', 'status_code' => 200, 'result' => $data_invoice));
            }
        }else{
            $this->response(array('status' => 'warning', 'status_code' => 501, 'result' => 'Data tidak ditemukan'));
        }