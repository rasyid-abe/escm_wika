<?php 
    $post = $this->input->post("data");
    $ret['code'] = 0;
    $ret['messages'] =  "";

    $step = false;
    foreach ($post as $key => $data) {
        # code...
    
        $transaksi_id = $data['id'];

        $ch = curl_init( UMKM_PADI );
            
        $payload = json_encode( array( "transaksi" => array(
            "tanggal_transaksi" => $data['tanggal_transaksi'],
            "transaksi_id" => $data['transaksi_id'],
            "bumn_id" => $data['bumn_id'],
            "nama_project" => $data['nama_project'],
            "kategori_project" => $data['kategori_project'],
            "total_nilai_project" => $data['total_nilai_project'],
            "tipe_nilai_project" => $data['tipe_nilai_project'],
            "kategori_umkm" => $data['kategori_umkm_id'],
            "uid_umkm" => $data['uid_umkm'],
            "nama_umkm" => $data['nama_umkm'],
            "target_penyelesaian" => $data['target_penyelesaian'],
            "tanggal_order_placement" => $data['tanggal_order_placement'],
            "tanggal_confirmation" => $data['tanggal_confirmation'],
            "tanggal_delivery" => $data['tanggal_delivery'],
            "tannggal_invoice" => $data['tannggal_invoice'],
            "total_cycle_time" => $data['total_cycle_time'],
            "kategori_delivery_time" => $data['kategori_delivery_time_id'],
            "rating" => $data['rating_id'],
            "feedback" => $data['feedback'],
            "deskripsi_project" => $data['deskripsi_project'],
            "id_satker" => $data['id_satker'],
            "is_pdn" => $data['is_pdn_id'],
            "tkdn" => $data['tkdn'],
            "is_certificate" => $data['is_certificate_id'],
            "certificate_tkdn" => $data['certificate_tkdn']
        ) ) );

        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
        curl_setopt( $ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'x-api-key:' . API_KEY_PADI,
            'User-Agent:WIKA_E-SCM_V2'
        ));

        $result = curl_exec($ch);

        $res_padi = json_decode($result, true);    

        curl_close($ch);

        $this->db->trans_begin(); 

        $data_status = array(
            'status_padi' => 1,
        );

        $this->db->where('id', $transaksi_id);
        $result = $this->db->update('padi_transaksi', $data_status);

        if($result){
            if ($this->db->trans_status() === FALSE)  {
                //$this->setMessage("Gagal unggah data");
                $this->db->trans_rollback();
                $ret['code'] = 500;
                $ret['messages'] =  $data['nama_project']. " Gagal push data !";

                echo json_encode($ret);
                exit;

            } else {
                $this->db->trans_commit();
                $step = true;
            }
            //redirect(site_url('padi/umkm/detail/' . $data['id']));

        } else {
            //$this->setMessage("Gagal unggah data");
            $this->db->trans_rollback();
            $ret['code'] = 500;
            $ret['messages'] =  $data['nama_project']. " Gagal push data !";

            echo json_encode($ret);
            exit;
            //redirect(site_url('padi/umkm/detail/' . $data['id']));
        }

    }

    if($step)
    {

        $ret['code'] = 200;
        $ret['messages'] =  " Sukses push data !";
    } else {
        $ret['code'] = 500;
        $ret['messages'] = " Gagal push data !";

    }

    echo json_encode($ret);
    

?>