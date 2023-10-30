<?php
    
        $delimiters = array(
        ';' => 0,
        ',' => 0,
        "\t" => 0,
        "|" => 0
        );

        $handle = fopen($_FILES['perencanaan_csv']['tmp_name'], "r");
        $firstLine = fgets($handle);
        fclose($handle); 
        foreach ($delimiters as $delimiter => &$count) {
            $count = count(str_getcsv($firstLine, $delimiter));
        }

        $delimiter =  array_search(max($delimiters), $delimiters);

        $countmain=0;

        $fpmain = fopen($_FILES['perencanaan_csv']['tmp_name'],'r') or die("can't open file");


        while(($csv_linemain = fgetcsv($fpmain, 1000, $delimiter)) !== FALSE)
        {

         $countmain++;

            if($countmain == 1)
            {
                continue;
            }//keep this "if condition" if you want to remove the first row
            for($i = 0, $j = count($csv_linemain); $i < $j; $i++)
            {
                $insert_csvmain = array();
                // $insert_csvmain[$i] = $csv_linemain[$i];
                $insert_csvmain['spk'] = $csv_linemain[0];
                $insert_csvmain['nama_proyek'] = $csv_linemain[1];
                $insert_csvmain['kode_departemen'] = $csv_linemain[2];
                $insert_csvmain['nama_departemen'] = $csv_linemain[3];
                $insert_csvmain['kode_master_sumberdaya'] = $csv_linemain[4];
                $insert_csvmain['nama_master_sumberdaya'] = $csv_linemain[5];
                $insert_csvmain['kelompok_sumberdaya'] = $csv_linemain[6];
                $insert_csvmain['kode_sumberdaya'] = $csv_linemain[7];
                $insert_csvmain['nama_sumberdaya'] = $csv_linemain[8];
                $insert_csvmain['satuan'] = $csv_linemain[9];
                $insert_csvmain['volume_sumberdaya'] = str_replace(',', '.', $csv_linemain[10]);
                $insert_csvmain['periode_pengadaan'] = $csv_linemain[11];
                $insert_csvmain['harga_satuan'] = str_replace(',', '.', $csv_linemain[12]);
                $insert_csvmain['total_nilai'] = str_replace(',', '.', $csv_linemain[13]);
                $insert_csvmain['kode_coa'] = $csv_linemain[14];
                $insert_csvmain['nama_coa'] = $csv_linemain[15];
                $insert_csvmain['mata_uang'] = $csv_linemain[16];
                $insert_csvmain['user_id'] = $csv_linemain[17];
                $insert_csvmain['nama_user'] = $csv_linemain[18];
                $insert_csvmain['periode_locking'] = $csv_linemain[19];

                // $data = array();
                
                
            }
            $fields = array(
                'spk_code'=>$insert_csvmain['spk'],
                'dept_code'=>$insert_csvmain['kode_departemen'],
                'group_smbd_code'=>$insert_csvmain['kode_master_sumberdaya'],
                'smbd_type'=>$insert_csvmain['kelompok_sumberdaya'],
                'smbd_code' => $insert_csvmain['kode_sumberdaya'],
                'smbd_quantity' => $insert_csvmain['volume_sumberdaya'],
                'coa_code'=>$insert_csvmain['kode_coa'],
                'user_name'=> $insert_csvmain['nama_user'],
                'periode_pengadaan'=>$insert_csvmain['periode_pengadaan'],
                'periode_locking'=>$insert_csvmain['periode_locking']
            );
            $this->db->where($fields);
            $check = $this->db->get('prc_plan_integrasi')->num_rows();
            if ($check == 0) {
                $this->db->trans_begin();
             $data = array(
                    'spk_code' => $insert_csvmain['spk'],
                    'project_name'=> $insert_csvmain['nama_proyek'],
                    'dept_code' => $insert_csvmain['kode_departemen'],
                    'dept_name' => $insert_csvmain['nama_departemen'],
                    'group_smbd_code' => $insert_csvmain['kode_master_sumberdaya'],
                    'group_smbd_name' => $insert_csvmain['nama_master_sumberdaya'],
                    'smbd_type' => $insert_csvmain['kelompok_sumberdaya'],
                    'smbd_code' => $insert_csvmain['kode_sumberdaya'],
                    'smbd_name' => $insert_csvmain['nama_sumberdaya'],
                    'unit' => $insert_csvmain['satuan'],
                    'smbd_quantity' => $insert_csvmain['volume_sumberdaya'],
                    'periode_pengadaan' => $insert_csvmain['periode_pengadaan'],
                    'price' => $insert_csvmain['harga_satuan'],
                    'total' => $insert_csvmain['total_nilai'],
                    'coa_code' => $insert_csvmain['kode_coa'],
                    'coa_name' => $insert_csvmain['nama_coa'],
                    'currency' => $insert_csvmain['mata_uang'],
                    'user_id' => $insert_csvmain['user_id'],
                    'user_name' => $insert_csvmain['nama_user'],
                    'periode_locking' => $insert_csvmain['periode_locking'],
                    'updated_date' => date("Y-m-d H:i:s"),
                );

                 $insert = $this->db->insert('prc_plan_integrasi', $data);

            
         if ($this->db->trans_status() === FALSE and $insert == false)
          {
            $this->db->trans_rollback();
            $message = "error";
            echo json_encode($message);
            exit();
            
          }
          else
          {
            $this->db->trans_commit();
            $message = "sukses";
          }
            
        }
        else{
             $message = "sukses";
        }

        $i++;


    }

        if (isset($message)) {
            echo json_encode($message);
        }
        // if ($message == 'error') {
        //     echo json_encode($message);
        // }else{
        //     echo json_encode($message);
        // }
        fclose($fpmain);

        // echo json_encode($insert_csvmain);