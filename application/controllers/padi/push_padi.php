<?php 

    $umkm_id = $this->uri->segment(3, 0);

    $data = $this->db->where('id', $umkm_id)->get('padi_umkm')->row_array();

    $ch = curl_init( UMKM_PADI );
        
    $payload = json_encode( array( "transaksi" => array(
        "uid" => $data['vendor_id'],
        "nama_umkm" => $data['nama_umkm'],
        "alamat" => $data['alamat'],
        "blok_no_kav" => $data['blok_no_kav'],
        "kode_pos" => $data['kode_pos'],
        "kota" => $data['kota'],
        "provinsi" => $data['provinsi'],
        "no_telp" => $data['no_telp'],
        "hp" => $data['hp'],
        "email" => $data['email'],
        "kategori_usaha" => $data['kategori_usaha'],
        "jenis_kegiatan_usaha" => $data['jenis_kegiatan_usaha'],
        "npwp" => $data['npwp'],
        "nama_bank" => $data['nama_bank'],
        "country_bank" => $data['country_bank'],
        "no_rekening" => $data['no_rekening'],
        "nama_pemilik_rekening" => $data['nama_pemilik_rekening'],
        "longitute" => $data['longitute'],
        "latitute" => $data['latitute'],
        "total_project" => $data['total_project'],
        "total_revenue" => $data['total_revenue'],
        "ontime_rate" => $data['ontime_rate'],
        "average_rating" => $data['average_rating'],
        "nib" => $data['nib'],
        "badan_usaha" => $data['badan_usaha']
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

    $this->db->where('id', $umkm_id);
    $result = $this->db->update('padi_umkm', $data_status);

    if($result){
        if ($this->db->trans_status() === FALSE)  {
            $this->setMessage("Gagal unggah data");
            $this->db->trans_rollback();
        } else {
            $this->setMessage("Sukses unggah data");
            $this->db->trans_commit();
        }
        redirect(site_url('padi/umkm/detail/' . $data['id']));

    } else {
        $this->setMessage("Gagal unggah data");
        $this->db->trans_rollback();
        redirect(site_url('padi/umkm/detail/' . $data['id']));
    }

?>