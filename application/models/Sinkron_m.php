<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
class Sinkron_m extends CI_Model {
    
  public function do_sinkron($vendorParams = ""){

    $this->db->trans_begin();
     
    if (!empty($vendorParams)) {
       $vendorIdparams = "?vendorId=".$vendorParams;
    } else {
       $vendorIdparams = "";
    }

    $curl = curl_init();    

    $data_token = array(
        // dev
        // 'token' => '9401A056-B477-499D-AF52-FC3A4F573092'

        // prod 
        'token' => '7D67DB6F-8610-4566-BFB7-EB613EE7535B'
    );

    $payload_token = json_encode( $data_token );
    
    curl_setopt_array($curl, array(      
      CURLOPT_URL => "https://pdc-api.pengadaan.com/security/login",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $payload_token,
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
      ),
    ));

    $response_token = curl_exec($curl);
    $err = curl_error($curl);	  

    curl_close($curl);  

    if ($err) {
      echo "cURL Error #:" . $err;
      return "cURL Error #:" . $err;
      exit();
    } else {
      $obj_response = json_decode($response_token);
      $accessToken = $obj_response->accessToken;
      $tokenType = $obj_response->tokenType;
    }

    // header

      $url_vendor_header = "https://pdc-api.pengadaan.com:443/vendor/header".$vendorIdparams; 

      $ch = curl_init($url_vendor_header);        
      curl_setopt($ch, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch, CURLOPT_ENCODING, ''); 
      curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_header = curl_exec($ch);      
      
      $arrays_header = json_decode($response_header, true);

      if (count($arrays_header["data"]) < 1){
        return 'not_found';
      } 

      $dataHeader = $arrays_header["data"];

      curl_close($ch);
      
      if ($arrays_header['resultCode'] != 200) {
        echo $arrays_header['resultCode'];
        exit();
      }
    
      foreach($dataHeader as $k => $v){
      
        if($v["qualification"] == '1'){
          $klasifikasi = 'K';
          $siup_type = 'Kecil';
        } elseif($v["qualification"] == '2'){
          $klasifikasi = 'M';
          $siup_type = 'Menengah';
        } elseif($v["qualification"] == '3'){
          $klasifikasi = 'B';
          $siup_type = 'Besar';
        } else if($v["qualification"] == '4'){
          $klasifikasi = 'R';
          $siup_type = 'Mikro';
        } else {
          $klasifikasi = NULL;
          $siup_type = NULL;
        }

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_header')->num_rows();

        //update
        if($check > 0){ 
    
          $dataUpdate = array(
            'vendor_name'               => $v["vendorName"],
            'email_address'             => $v["email"],
            'modified_date'             => date('Y-m-d H:i:s'),
            'fin_class'                 => $klasifikasi,
            'login_id'                  => $v["email"],
            //'password'                  => $v["password"],
            'prefix'                    => $v["companyType"],
            'district_id'               => 0,
            'address_domisili_no'       => $v["domisiliNo"],
            'address_domisili_date'     => $v['domisiliStart'],
            'npwp_no'                   => $v["taxId"],
            'vendor_type'               => $v["vendorType"],
            'siup_type'                 => $siup_type,
            'nib_no'                    => $v["nib"],
            'vnd_jenis'                 => 'Pengadaan.com',
            'categoryIdBumnkarya'       => $v["categoryIdBumnkarya"],
            'companyProfile'            => $v["companyProfile"],
            'contactMobileNo'           => $v["contactMobileNo"],
            'facebook'                  => $v["facebook"],
            'instagram'                 => $v["instagram"],
            'linkGoogleMaps'            => $v["linkGoogleMaps"],
            'linkedin'                  => $v["linkedin"],
            'twitter'                   => $v["twitter"],
            'qualification'             => $v["qualification"],
            'website'                   => $v["website"],
            'domisiliEnd'               => $v["domisiliEnd"],
            'industryKey'               => $v["industryKey"],
            'instanceName'              => $v["instanceName"],
            'syncron_date'              => date('Y-m-d H:i:s')
          );
          
          $dataAlamat = [];
          $na = 0;
          foreach ($v["listVndAddress"] as $a => $v1) {
            if ($v1['addressId'] != null) {
              $dataAlamat[$na]['vendor_id']     = $v['vendorId'];
              $dataAlamat[$na]['type']          = $v1['type'];
              $dataAlamat[$na]['alamat']        = $v1['address'];
              $dataAlamat[$na]['province_name'] = $v1['province'];
              $dataAlamat[$na]['city_name']     = $v1['city'];
              $dataAlamat[$na]['district_name'] = $v1['district'];
              $dataAlamat[$na]['country']       = $v1['country'];
              $dataAlamat[$na]['kode_pos']      = $v1['postCode'];
              $dataAlamat[$na]['phone1']        = $v1['phone1'];
              $dataAlamat[$na]['phone2']        = $v1['phone2'];
              $dataAlamat[$na]['fax']           = $v1['fax'];
              $dataAlamat[$na]['updated_at']    = date('Y-m-d H:i:s');
              $dataAlamat[$na]['addressId']     = $v1['addressId'];
              $dataAlamat[$na]['picDirector']   = $v1['picDirector'];
              $dataAlamat[$na]['picFront']      = $v1['picFront'];
              $dataAlamat[$na]['picGoogleMaps'] = $v1['picGoogleMaps'];
              $dataAlamat[$na]['picOffice']     = $v1['picOffice'];
              $dataAlamat[$na]['provinceId']    = $v1['provinceId'];
              $dataAlamat[$na]['cityId']        = $v1['cityId'];
              $na++;
            }
          }

          $dataKontak = [];
          $nk = 0;
          foreach ($v["listVndContact"] as $k => $v2) {
            if ($v2['contactId'] != null) {
              $dataKontak[$nk]['vendor_id']    = $v['vendorId'];
              $dataKontak[$nk]['nama_lengkap'] = $v2['fullname'];
              $dataKontak[$nk]['email']        = $v2['email'];
              $dataKontak[$nk]['no_telp']      = $v2['phone'];
              $dataKontak[$nk]['mobile_phone'] = $v2['mobilePhone'];
              $dataKontak[$nk]['updated_at']   = date('Y-m-d H:i:s');
              $dataKontak[$nk]['contactId']    = $v2['contactId'];
              $nk++;
            }
          }
      
          $dataItem = [];
          $no = 0;
          foreach ($v["listVndProduct"] as $p => $v3) {
            if ($v3['productId'] != null) {
              $dataItem[$no]['product_id']    = $v3['productId'];
              $dataItem[$no]['vendor_id']     = $v["vendorId"];
              $dataItem[$no]['product_name']  = $v3['productName'];
              $dataItem[$no]['product_code']  = str_replace(".","",$v3['codeGroup']);
              $dataItem[$no]['name_group']    = $v3['nameGroup'];
              $dataItem[$no]['brand']         = $v3['brand'];
              $dataItem[$no]['source']        = $v3['source'];
              $dataItem[$no]['type']          = $v3['type'];
              $dataItem[$no]['status']        = 1;
              $dataItem[$no]['updated_at']    = date('Y-m-d H:i:s');
              $no++;
            }
          }

          $dataBank = [];
          $nb = 0;
          foreach ($v["listVndBank"] as $b => $v4) {
            if ($v4['bankId'] != null) {
              $dataBank[$nb]['vendor_id']           = $v['vendorId'];
              $dataBank[$nb]['account_no']          = $v4['accountNo'];
              $dataBank[$nb]['account_name']        = $v4['accountOwner'];
              $dataBank[$nb]['bank_id']             = $v4['bankSwiftCode'];
              $dataBank[$nb]['bank_branch']         = $v4['branch'];
              $dataBank[$nb]['bank_name']           = $v4['bankName'];
              $dataBank[$nb]['currency']            = $v4['currency'];
              $dataBank[$nb]['country']             = $v4['bankCountry'];
              $dataBank[$nb]['transactionalAtt']    = $v4['transactionalAtt'];
              $dataBank[$nb]['statementLetterAtt']  = $v4['statementLetterAtt'];
              $dataBank[$nb]['bankId']              = $v4['bankId'];
              $dataBank[$nb]['last_modified']       = date('Y-m-d H:i:s');
              $nb++;
            }
          }

          $dataAccount = [];
          $nac = 0;
          foreach ($v["listAccount"] as $acc => $v5) {
            if ($v5['email'] != null) {
              $dataAccount[$nac]['vendor_id'] = $v['vendorId'];
              $dataAccount[$nac]['email']     = $v5['email'];
              $dataAccount[$nac]['ismaster']  = $v5['isMaster'];
              $dataAccount[$nac]['password']  = $v5['password'];
              $nac++;
            }
          }

          //insert to db
          $this->db->where('vendor_id', $v["vendorId"]);
          $headresult = $this->db->update('vnd_header', $dataUpdate);
          
          if (count($dataAlamat) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_alamat");
            $alamatresult = $this->db->insert_batch('vnd_alamat', $dataAlamat);
          }

          if (count($dataKontak) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_kontak");
            $kontakresult = $this->db->insert_batch('vnd_kontak', $dataKontak);
          }

          if (count($dataItem) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->where("status",1);
            $this->db->delete("vnd_product");
            $itemresult = $this->db->insert_batch('vnd_product', $dataItem);
          }
          
          if (count($dataBank) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_bank");
            $bankresult = $this->db->insert_batch('vnd_bank', $dataBank);
          }

          if (count($dataAccount) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_account");
            $accountresult = $this->db->insert_batch('vnd_account', $dataAccount);
          }
          
        } else {
        
          $dataInsert = array(
            'vendor_id'                 => $v["vendorId"],
            'vendor_name'               => $v["vendorName"],
            'email_address'             => $v["email"],
            'creation_date'             => $v["createdDate"],
            'fin_class'                 => $klasifikasi,
            'login_id'                  => $v["email"],
            'password'                  => $v["password"],
            'prefix'                    => $v["companyType"],
            'district_id'               => 0,
            'address_domisili_no'       => $v["domisiliNo"],
            'address_domisili_date'     => $v['domisiliStart'],
            'npwp_no'                   => $v["taxId"],
            'vendor_type'               => $v["vendorType"],
            'siup_type'                 => $siup_type,
            'nib_no'                    => $v["nib"],
            'vnd_jenis'                 => 'Pengadaan.com',
            'categoryIdBumnkarya'       => $v["categoryIdBumnkarya"],
            'companyProfile'            => $v["companyProfile"],
            'contactMobileNo'           => $v["contactMobileNo"],
            'facebook'                  => $v["facebook"],
            'instagram'                 => $v["instagram"],
            'linkGoogleMaps'            => $v["linkGoogleMaps"],
            'linkedin'                  => $v["linkedin"],
            'twitter'                   => $v["twitter"],
            'qualification'             => $v["qualification"],
            'website'                   => $v["website"],
            'domisiliEnd'               => $v["domisiliEnd"],
            'industryKey'               => $v["industryKey"],
            'instanceName'              => $v["instanceName"],
            'syncron_date'              => date('Y-m-d H:i:s')
          );

          $dataAlamat = [];
          $na = 0;
          foreach ($v["listVndAddress"] as $a => $v1) {
            if ($v1['addressId'] != null) {
              $dataAlamat[$na]['vendor_id']     = $v['vendorId'];
              $dataAlamat[$na]['type']          = $v1['type'];
              $dataAlamat[$na]['alamat']        = $v1['address'];
              $dataAlamat[$na]['province_name'] = $v1['province'];
              $dataAlamat[$na]['city_name']     = $v1['city'];
              $dataAlamat[$na]['district_name'] = $v1['district'];
              $dataAlamat[$na]['country']       = $v1['country'];
              $dataAlamat[$na]['kode_pos']      = $v1['postCode'];
              $dataAlamat[$na]['phone1']        = $v1['phone1'];
              $dataAlamat[$na]['phone2']        = $v1['phone2'];
              $dataAlamat[$na]['fax']           = $v1['fax'];
              $dataAlamat[$na]['updated_at']    = date('Y-m-d H:i:s');
              $dataAlamat[$na]['addressId']     = $v1['addressId'];
              $dataAlamat[$na]['picDirector']   = $v1['picDirector'];
              $dataAlamat[$na]['picFront']      = $v1['picFront'];
              $dataAlamat[$na]['picGoogleMaps'] = $v1['picGoogleMaps'];
              $dataAlamat[$na]['picOffice']     = $v1['picOffice'];
              $dataAlamat[$na]['provinceId']    = $v1['provinceId'];
              $dataAlamat[$na]['cityId']        = $v1['cityId'];
              $na++;
            }
          }

          $dataKontak = [];
          $nk = 0;
          foreach ($v["listVndContact"] as $k => $v2) {
            if ($v2['contactId'] != null) {
              $dataKontak[$nk]['vendor_id']    = $v['vendorId'];
              $dataKontak[$nk]['nama_lengkap'] = $v2['fullname'];
              $dataKontak[$nk]['email']        = $v2['email'];
              $dataKontak[$nk]['no_telp']      = $v2['phone'];
              $dataKontak[$nk]['mobile_phone'] = $v2['mobilePhone'];
              $dataKontak[$nk]['created_at']   = date('Y-m-d H:i:s');
              $dataKontak[$nk]['contactId']    = $v2['contactId'];
              $nk++;
            }
          }
      
          $dataItem = [];
          $no = 0;
          foreach ($v["listVndProduct"] as $p => $v3) {
            if ($v3['productId'] != null) {
              $dataItem[$no]['product_id']    = $v3['productId'];
              $dataItem[$no]['vendor_id']     = $v["vendorId"];
              $dataItem[$no]['product_name']  = $v3['productName'];
              $dataItem[$no]['product_code']  = str_replace(".","",$v3['codeGroup']);
              $dataItem[$no]['name_group']    = $v3['nameGroup'];
              $dataItem[$no]['brand']         = $v3['brand'];
              $dataItem[$no]['source']        = $v3['source'];
              $dataItem[$no]['type']          = $v3['type'];
              $dataItem[$no]['status']        = 1;
              $dataItem[$no]['created_at']    = date('Y-m-d H:i:s');
              $no++;
            }
          }

          $dataBank = [];
          $nb = 0;
          foreach ($v["listVndBank"] as $b => $v4) {
            if ($v4['bankId'] != null) {
              $dataBank[$nb]['vendor_id']           = $v['vendorId'];
              $dataBank[$nb]['account_no']          = $v4['accountNo'];
              $dataBank[$nb]['account_name']        = $v4['accountOwner'];
              $dataBank[$nb]['bank_id']             = $v4['bankSwiftCode'];
              $dataBank[$nb]['bank_branch']         = $v4['branch'];
              $dataBank[$nb]['bank_name']           = $v4['bankName'];
              $dataBank[$nb]['currency']            = $v4['currency'];
              $dataBank[$nb]['country']             = $v4['bankCountry'];
              $dataBank[$nb]['transactionalAtt']    = $v4['transactionalAtt'];
              $dataBank[$nb]['statementLetterAtt']  = $v4['statementLetterAtt'];
              $dataBank[$nb]['bankId']              = $v4['bankId'];
              $dataBank[$nb]['created_at']          = date('Y-m-d H:i:s');
              $nb++;
            }
          }

          $dataAccount = [];
          $nac = 0;
          foreach ($v["listAccount"] as $acc => $v5) {
            if ($v5['email'] != null) {
              $dataAccount[$nac]['vendor_id'] = $v['vendorId'];
              $dataAccount[$nac]['email']     = $v5['email'];
              $dataAccount[$nac]['ismaster']  = $v5['isMaster'];
              $dataAccount[$nac]['password']  = $v5['password'];
              $nac++;
            }
          }

          //insert to db 
          $headresult = $this->db->insert('vnd_header', $dataInsert);

          if (count($dataAlamat) > 0) {
            $alamatresult = $this->db->insert_batch('vnd_alamat', $dataAlamat);
          }		

          if (count($dataKontak) > 0) {
            $kontakresult = $this->db->insert_batch('vnd_kontak', $dataKontak);
          }		

          if (count($dataItem) > 0) {
            $itemresult = $this->db->insert_batch('vnd_product', $dataItem);
          }

          if (count($dataBank) > 0) {
            $bankresult = $this->db->insert_batch('vnd_bank', $dataBank);
          }

          if (count($dataAccount) > 0) {
            $accountresult = $this->db->insert_batch('vnd_account', $dataAccount);
          }
        }
      }

    // end header

    // legal 
    
      $url_vendor_legal = "https://pdc-api.pengadaan.com:443/vendor/legal".$vendorIdparams; 

      $ch2 = curl_init($url_vendor_legal);        
      curl_setopt($ch2, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch2, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch2, CURLOPT_ENCODING, ''); 
      curl_setopt($ch2, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch2, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch2, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_legal = curl_exec($ch2);
      
      $arrays_legal = json_decode($response_legal, true);

      $dataLegal = $arrays_legal["data"];
      
      if ($arrays_legal['resultCode'] != 200) {
        echo $arrays_legal['resultCode'];
        exit();
      }

      curl_close($ch2);

      foreach($dataLegal as $l => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_header')->num_rows();
        
        //update
        if(!empty($check)){ 

          $dataAkta = [];
          $nak = 0;
          foreach ($v["listVndAkta"] as $ak => $v1) {
            if ($v['vendorId'] != null) {
              $dataAkta[$nak]['alamat_notaris'] = $v1['address'];
              $dataAkta[$nak]['nomor_akta']     = $v1['aktaNumber'];
              $dataAkta[$nak]['lampiran']       = $v1['attachment'];
              $dataAkta[$nak]['tgl_buat']       = $v1['date'];
              $dataAkta[$nak]['nama_notaris']   = $v1['name'];
              $dataAkta[$nak]['type_akta']      = $v1['type'];
              $dataAkta[$nak]['vendor_id']      = $v['vendorId'];
              $nak++;
            }
          }

          $dataIzin = [];
          $niz = 0;
          foreach ($v["listVndIjin"] as $iz => $v2) {
            if ($v['vendorId'] != null) {
              $dataIzin[$niz]['lampiran']       = $v2['attachment'];
              $dataIzin[$niz]['tgl_kadaluarsa'] = $v2['expiredDate'];
              $dataIzin[$niz]['penerbit']       = $v2['issuedBy'];
              $dataIzin[$niz]['kategori']       = $v2['kbliNoCategory'];
              $dataIzin[$niz]['nomor_izin']     = $v2['permitNumber'];
              $dataIzin[$niz]['tgl_buat']       = $v2['startDate'];
              $dataIzin[$niz]['type_izin']      = $v2['type'];
              $dataIzin[$niz]['vendor_id']      = $v['vendorId'];
              $niz++;
            }
          }
          
          $dataSk = [];
          $ns = 0;
          foreach ($v["listVndSk"] as $sk => $v3) {
            if ($v['vendorId'] != null) {
              $dataSk[$ns]['lampiran']     = $v3['attachment'];
              $dataSk[$ns]['nomor_akta']   = $v3['skAktaNo'];
              $dataSk[$ns]['sk_type']      = $v3['skAktaType'];
              $dataSk[$ns]['tgl_buat']     = $v3['skDate'];
              $dataSk[$ns]['nomor_sk']     = $v3['skNumber'];
              $dataSk[$ns]['vendor_id']    = $v['vendorId'];
              $ns++;
            }
          }

          $dataCert = [];
          $nc = 0;
          foreach ($v["listVndCert"] as $cer => $v4) {
            if ($v['vendorId'] != null) {
              $dataCert[$nc]['lampiran']          = $v4['certAtt'];
              $dataCert[$nc]['nama_sertifikat']   = $v4['certName'];
              $dataCert[$nc]['nomor_sertifikat']  = $v4['certNumber'];
              $dataCert[$nc]['tgl_kadaluarsa']    = $v4['expiredDate'];
              $dataCert[$nc]['penerbit']          = $v4['issuedBy'];
              $dataCert[$nc]['noValidTo']         = $v4['noValidTo'];
              $dataCert[$nc]['tgl_buat']          = $v4['startDate'];
              $dataCert[$nc]['type_sertifikat']   = $v4['type'];
              $dataCert[$nc]['vendor_id']         = $v['vendorId'];
              $nc++;
            }
          }

          if (count($dataAkta) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_akta");
            $aktaresult = $this->db->insert_batch('vnd_akta', $dataAkta);
          }

          if (count($dataIzin) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_izin");
            $izinresult = $this->db->insert_batch('vnd_izin', $dataIzin);
          }

          if (count($dataSk) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_sk");
            $skresult = $this->db->insert_batch('vnd_sk', $dataSk);
          }

          if (count($dataCert) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_sertifikat");
            $certresult = $this->db->insert_batch('vnd_sertifikat', $dataCert);
          }
          
        } else {
      
          $dataAkta = [];
          $nak = 0;
          foreach ($v["listVndAkta"] as $ak => $v1) {
            if ($v['vendorId'] != null) {
              $dataAkta[$nak]['alamat_notaris'] = $v1['address'];
              $dataAkta[$nak]['nomor_akta']     = $v1['aktaNumber'];
              $dataAkta[$nak]['lampiran']       = $v1['attachment'];
              $dataAkta[$nak]['tgl_buat']       = $v1['date'];
              $dataAkta[$nak]['nama_notaris']   = $v1['name'];
              $dataAkta[$nak]['type_akta']      = $v1['type'];
              $dataAkta[$nak]['vendor_id']      = $v['vendorId'];
              $dataAkta[$nak]['created_at']     = date('Y-m-d H:i:s');
              $nak++;
            }
          }

          $dataIzin = [];
          $niz = 0;
          foreach ($v["listVndIjin"] as $iz => $v2) {
            if ($v['vendorId'] != null) {
              $dataIzin[$niz]['lampiran']       = $v2['attachment'];
              $dataIzin[$niz]['tgl_kadaluarsa'] = $v2['expiredDate'];
              $dataIzin[$niz]['penerbit']       = $v2['issuedBy'];
              $dataIzin[$niz]['kategori']       = $v2['kbliNoCategory'];
              $dataIzin[$niz]['nomor_izin']     = $v2['permitNumber'];
              $dataIzin[$niz]['tgl_buat']       = $v2['startDate'];
              $dataIzin[$niz]['type_izin']      = $v2['type'];
              $dataIzin[$niz]['vendor_id']      = $v['vendorId'];
              $dataIzin[$niz]['created_at']     = date('Y-m-d H:i:s');
              $niz++;
            }
          }
          
          $dataSk = [];
          $ns = 0;
          foreach ($v["listVndSk"] as $sk => $v3) {
            if ($v['vendorId'] != null) {
              $dataSk[$ns]['lampiran']     = $v3['attachment'];
              $dataSk[$ns]['nomor_akta']   = $v3['skAktaNo'];
              $dataSk[$ns]['sk_type']      = $v3['skAktaType'];
              $dataSk[$ns]['tgl_buat']     = $v3['skDate'];
              $dataSk[$ns]['nomor_sk']     = $v3['skNumber'];
              $dataSk[$ns]['vendor_id']    = $v['vendorId'];
              $dataSk[$ns]['created_at']   = date('Y-m-d H:i:s');
              $ns++;
            }
          }

          $dataCert = [];
          $nc = 0;
          foreach ($v["listVndCert"] as $cer => $v4) {
            if ($v['vendorId'] != null) {
              $dataCert[$nc]['lampiran']          = $v4['certAtt'];
              $dataCert[$nc]['nama_sertifikat']   = $v4['certName'];
              $dataCert[$nc]['nomor_sertifikat']  = $v4['certNumber'];
              $dataCert[$nc]['tgl_kadaluarsa']    = $v4['expiredDate'];
              $dataCert[$nc]['penerbit']          = $v4['issuedBy'];
              $dataCert[$nc]['noValidTo']         = $v4['noValidTo'];
              $dataCert[$nc]['tgl_buat']          = $v4['startDate'];
              $dataCert[$nc]['type_sertifikat']   = $v4['type'];
              $dataCert[$nc]['vendor_id']         = $v['vendorId'];
              $dataCert[$nc]['created_at']        = date('Y-m-d H:i:s');
              $nc++;
            }
          }
          
          if (count($dataAkta) > 0) {
            $aktaresult = $this->db->insert_batch('vnd_akta', $dataAkta);
          }		

          if (count($dataIzin) > 0) {
            $izinresult = $this->db->insert_batch('vnd_izin', $dataIzin);
          }		

          if (count($dataSk) > 0) {
            $skresult = $this->db->insert_batch('vnd_sk', $dataSk);
          }		

          if (count($dataCert) > 0) {
            $certresult = $this->db->insert_batch('vnd_sertifikat', $dataCert);
          }		

        }
      }

    // end legal

    // pajak
    
      $url_vendor_pajak = "https://pdc-api.pengadaan.com:443/vendor/pajak".$vendorIdparams; 

      $ch3 = curl_init($url_vendor_pajak);        
      curl_setopt($ch3, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch3, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch3, CURLOPT_ENCODING, ''); 
      curl_setopt($ch3, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch3, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch3, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch3, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_pajak = curl_exec($ch3);
      
      $arrays_pajak = json_decode($response_pajak, true);

      $dataPajak = $arrays_pajak["data"];
      
      if ($arrays_pajak['resultCode'] != 200) {
        echo $arrays_pajak['resultCode'];
        exit();
      }

      curl_close($ch3);

      foreach($dataPajak as $pj => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_spt')->num_rows();

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check_pj = $this->db->get('vnd_pajak')->num_rows();
        
        if(!empty($check)){ 

          $dataSpt = [];
          $nspt = 0;
          foreach ($v["listVndSpt"] as $spt => $v1) {
            if ($v['vendorId'] != null) {
              $dataSpt[$nspt]['spt_id']         = $v1['sptId'];
              $dataSpt[$nspt]['spt_lampiran']   = $v1['sptAttachment'];
              $dataSpt[$nspt]['bukti_lampiran'] = $v1['buktiAttachment'];
              $dataSpt[$nspt]['tgl_lapor']      = $v1['sptDate'];
              $dataSpt[$nspt]['tahun']          = $v1['year'];
              $dataSpt[$nspt]['vendor_id']      = $v['vendorId'];
              $dataSpt[$nspt]['created_at']     = date('Y-m-d H:i:s');
              $nspt++;
            }
          }

          if (count($dataSpt) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_spt");
            $sptresult = $this->db->insert_batch('vnd_spt', $dataSpt);
          }
          
        } else {
      
          $dataSpt = [];
          $nspt = 0;
          foreach ($v["listVndSpt"] as $spt => $v1) {
            if ($v['vendorId'] != null) {
              $dataSpt[$nspt]['spt_id']         = $v1['sptId'];
              $dataSpt[$nspt]['spt_lampiran']   = $v1['sptAttachment'];
              $dataSpt[$nspt]['bukti_lampiran'] = $v1['buktiAttachment'];
              $dataSpt[$nspt]['tgl_lapor']      = $v1['sptDate'];
              $dataSpt[$nspt]['tahun']          = $v1['year'];
              $dataSpt[$nspt]['vendor_id']      = $v['vendorId'];
              $dataSpt[$nspt]['created_at']     = date('Y-m-d H:i:s');
              $nspt++;
            }
          }
          
          if (count($dataSpt) > 0) {
            $sptresult = $this->db->insert_batch('vnd_spt', $dataSpt);
          }			

        }

        if(!empty($check_pj)){
          $dataUpdate = array(
            'taxid'          => $v["taxId"],
            'taxname'        => $v["taxName"],
            'taxdistrict'    => $v["taxDistrict"],
            'name'           => $v["name"],
            'npwppkp'        => $v["npwpPkp"],
            'pkpattachment'  => $v["pkpAttachment"],
            'pkpcreateddate' => $v["pkpCreatedDate"],
            'pkpnumber'      => $v["pkpNumber"],
            'province'       => $v["province"],
            'city'           => $v["city"],
            'district'       => $v["district"],
            'address'        => $v["address"],
            'postcode'       => $v["postCode"],
            'attachment'     => $v["attachment"],
            'completeddate'  => $v["completedDate"],
            'vendor_id'      => $v['vendorId']
          );

          //update db
          $this->db->where('vendor_id', $v["vendorId"]);
          $pajakresult = $this->db->update('vnd_pajak', $dataUpdate);
        }

        if(empty($check_pj)) {
          $dataInsert = array(
            'taxid'          => $v["taxId"],
            'taxname'        => $v["taxName"],
            'taxdistrict'    => $v["taxDistrict"],
            'name'           => $v["name"],
            'npwppkp'        => $v["npwpPkp"],
            'pkpattachment'  => $v["pkpAttachment"],
            'pkpcreateddate' => $v["pkpCreatedDate"],
            'pkpnumber'      => $v["pkpNumber"],
            'province'       => $v["province"],
            'city'           => $v["city"],
            'district'       => $v["district"],
            'address'        => $v["address"],
            'postcode'       => $v["postCode"],
            'attachment'     => $v["attachment"],
            'completeddate'  => $v["completedDate"],
            'vendor_id'      => $v['vendorId'],
            'created_at'     => date('Y-m-d H:i:s')
          );

          //insert to db 
          $pajakresult = $this->db->insert('vnd_pajak', $dataInsert);
        }
      }

    // end pajak

    // saham/shareholder
    
      $url_vendor_saham = "https://pdc-api.pengadaan.com:443/vendor/saham".$vendorIdparams; 

      $ch4 = curl_init($url_vendor_saham);        
      curl_setopt($ch4, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch4, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch4, CURLOPT_ENCODING, ''); 
      curl_setopt($ch4, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch4, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch4, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch4, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch4, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_saham = curl_exec($ch4);
      
      $arrays_saham = json_decode($response_saham, true);

      $dataSaham = $arrays_saham["data"];
      
      if ($arrays_saham['resultCode'] != 200) {
        echo $arrays_saham['resultCode'];
        exit();
      }

      curl_close($ch4);

      foreach($dataSaham as $shm => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_saham')->num_rows();
        
        if(!empty($check)){ 

          $dataSaham = [];
          $nshm = 0;
          foreach ($v["listVndShareholder"] as $shm => $v1) {
            if ($v['vendorId'] != null) {
              $dataSaham[$nshm]['address']          = $v1['address'];
              $dataSaham[$nshm]['category']         = $v1['category'];
              $dataSaham[$nshm]['country']          = $v1['country'];
              $dataSaham[$nshm]['prop']             = $v1['province'];
              $dataSaham[$nshm]['city']             = $v1['city'];
              $dataSaham[$nshm]['district']         = $v1['district'];
              $dataSaham[$nshm]['id_card']          = $v1['idCard'];
              $dataSaham[$nshm]['nama_pemegang']    = $v1['name'];
              $dataSaham[$nshm]['nationality']      = $v1['nationality'];
              $dataSaham[$nshm]['lampiran_ktp']     = $v1['ktpAttachment'];
              $dataSaham[$nshm]['lampiran_npwp']    = $v1['npwpAttachment'];
              $dataSaham[$nshm]['no_telp']          = $v1['phone'];
              $dataSaham[$nshm]['kode_pos']         = $v1['postCode'];
              $dataSaham[$nshm]['jml_kepemilikan']  = $v1['qty'];
              $dataSaham[$nshm]['tipe_saham']       = $v1['stockType'];
              $dataSaham[$nshm]['stockholder_id']   = $v1['stockholderId'];
              $dataSaham[$nshm]['tax_id']           = $v1['taxId'];
              $dataSaham[$nshm]['type']             = $v1['type'];
              $dataSaham[$nshm]['vendor_id']        = $v['vendorId'];
              $dataSaham[$nshm]['created_at']       = date('Y-m-d H:i:s');
              $nshm++;
            }
          }

          if (count($dataSaham) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_saham");
            $shmresult = $this->db->insert_batch('vnd_saham', $dataSaham);
          }
          
        } else {
      
          $dataSaham = [];
          $nshm = 0;
          foreach ($v["listVndShareholder"] as $shm => $v1) {
            if ($v['vendorId'] != null) {
              $dataSaham[$nshm]['address']          = $v1['address'];
              $dataSaham[$nshm]['category']         = $v1['category'];
              $dataSaham[$nshm]['country']          = $v1['country'];
              $dataSaham[$nshm]['prop']             = $v1['province'];
              $dataSaham[$nshm]['city']             = $v1['city'];
              $dataSaham[$nshm]['district']         = $v1['district'];
              $dataSaham[$nshm]['id_card']          = $v1['idCard'];
              $dataSaham[$nshm]['nama_pemegang']    = $v1['name'];
              $dataSaham[$nshm]['nationality']      = $v1['nationality'];
              $dataSaham[$nshm]['lampiran_ktp']     = $v1['ktpAttachment'];
              $dataSaham[$nshm]['lampiran_npwp']    = $v1['npwpAttachment'];
              $dataSaham[$nshm]['no_telp']          = $v1['phone'];
              $dataSaham[$nshm]['kode_pos']         = $v1['postCode'];
              $dataSaham[$nshm]['jml_kepemilikan']  = $v1['qty'];
              $dataSaham[$nshm]['tipe_saham']       = $v1['stockType'];
              $dataSaham[$nshm]['stockholder_id']   = $v1['stockholderId'];
              $dataSaham[$nshm]['tax_id']           = $v1['taxId'];
              $dataSaham[$nshm]['type']             = $v1['type'];
              $dataSaham[$nshm]['vendor_id']        = $v['vendorId'];
              $dataSaham[$nshm]['created_at']       = date('Y-m-d H:i:s');
              $nshm++;
            }
          }
          
          if (count($dataSaham) > 0) {
            $shmresult = $this->db->insert_batch('vnd_saham', $dataSaham);
          }			

        }
      }

    // end saham/shareholder

    // pengurus/board
    
      $url_vendor_pengurus = "https://pdc-api.pengadaan.com:443/vendor/pengurus".$vendorIdparams; 

      $ch5 = curl_init($url_vendor_pengurus);        
      curl_setopt($ch5, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch5, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch5, CURLOPT_ENCODING, ''); 
      curl_setopt($ch5, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch5, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch5, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch5, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch5, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch5, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch5, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_pengurus = curl_exec($ch5);
      
      $arrays_pengurus = json_decode($response_pengurus, true);

      $dataPengurus = $arrays_pengurus["data"];
      
      if ($arrays_pengurus['resultCode'] != 200) {
        echo $arrays_pengurus['resultCode'];
        exit();
      }

      curl_close($ch5);

      foreach($dataPengurus as $png => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_board')->num_rows();
        
        if(!empty($check)){ 

          $dataPengurus = [];
          $np = 0;
          foreach ($v["listVndBoard"] as $png => $v1) {
            if ($v['vendorId'] != null) {
              $dataPengurus[$np]['boardId']       = $v1['boardId'];
              $dataPengurus[$np]['country']       = $v1['country'];
              $dataPengurus[$np]['province']      = $v1['province'];
              $dataPengurus[$np]['city']          = $v1['city'];
              $dataPengurus[$np]['district']      = $v1['district'];
              $dataPengurus[$np]['address']       = $v1['address'];
              $dataPengurus[$np]['post_code']     = $v1['postCode'];
              $dataPengurus[$np]['nationality']   = $v1['nationality'];
              $dataPengurus[$np]['npwp']          = $v1['taxId'];
              $dataPengurus[$np]['ktp']           = $v1['idCard'];
              $dataPengurus[$np]['name']          = $v1['name'];
              $dataPengurus[$np]['position']      = $v1['position'];
              $dataPengurus[$np]['phone']         = $v1['telephoneNo'];
              $dataPengurus[$np]['lampiran_ktp']  = $v1['idAttachment'];
              $dataPengurus[$np]['lampiran_npwp'] = $v1['taxAttachment'];
              $dataPengurus[$np]['vendor_id']     = $v['vendorId'];
              $dataPengurus[$np]['created_at']    = date('Y-m-d H:i:s');
              $np++;
            }
          }

          if (count($dataPengurus) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_board");
            $pengurusresult = $this->db->insert_batch('vnd_board', $dataPengurus);
          }
          
        } else {
      
          $dataPengurus = [];
          $np = 0;
          foreach ($v["listVndBoard"] as $png => $v1) {
            if ($v['vendorId'] != null) {
              $dataPengurus[$np]['boardId']       = $v1['boardId'];
              $dataPengurus[$np]['country']       = $v1['country'];
              $dataPengurus[$np]['province']      = $v1['province'];
              $dataPengurus[$np]['city']          = $v1['city'];
              $dataPengurus[$np]['district']      = $v1['district'];
              $dataPengurus[$np]['address']       = $v1['address'];
              $dataPengurus[$np]['post_code']     = $v1['postCode'];
              $dataPengurus[$np]['nationality']   = $v1['nationality'];
              $dataPengurus[$np]['npwp']          = $v1['taxId'];
              $dataPengurus[$np]['ktp']           = $v1['idCard'];
              $dataPengurus[$np]['name']          = $v1['name'];
              $dataPengurus[$np]['position']      = $v1['position'];
              $dataPengurus[$np]['phone']         = $v1['telephoneNo'];
              $dataPengurus[$np]['lampiran_ktp']  = $v1['idAttachment'];
              $dataPengurus[$np]['lampiran_npwp'] = $v1['taxAttachment'];
              $dataPengurus[$np]['vendor_id']     = $v['vendorId'];
              $dataPengurus[$np]['created_at']    = date('Y-m-d H:i:s');
              $np++;
            }
          }
          
          if (count($dataPengurus) > 0) {
            $pengurusresult = $this->db->insert_batch('vnd_board', $dataPengurus);
          }			

        }
      }

    // end pengurus/board

    // personil
    
      $url_vendor_personil = "https://pdc-api.pengadaan.com:443/vendor/personil".$vendorIdparams; 

      $ch6 = curl_init($url_vendor_personil);        
      curl_setopt($ch6, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch6, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch6, CURLOPT_ENCODING, ''); 
      curl_setopt($ch6, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch6, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch6, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch6, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch6, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($ch6, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch6, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_personil = curl_exec($ch6);
      
      $arrays_personil = json_decode($response_personil, true);

      $dataPersonil = $arrays_personil["data"];
      
      if ($arrays_personil['resultCode'] != 200) {
        echo $arrays_personil['resultCode'];
        exit();
      }

      curl_close($ch6);

      foreach($dataPersonil as $pers => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_personil')->num_rows();
        
        if(!empty($check)){ 

          $dataPersonil = [];
          $nps = 0;
          foreach ($v["listVndSdm"] as $pers => $v1) {
            if ($v['vendorId'] != null) {
              $dataPersonil[$nps]['sdm_id']                 = $v1['sdmId'];
              $dataPersonil[$nps]['country']                = $v1['country'];
              $dataPersonil[$nps]['kewarganegaraan']        = $v1['nationality'];
              $dataPersonil[$nps]['province']               = $v1['province'];
              $dataPersonil[$nps]['city']                   = $v1['city'];
              $dataPersonil[$nps]['district']               = $v1['district'];
              $dataPersonil[$nps]['alamat']                 = $v1['address'];
              $dataPersonil[$nps]['kode_pos']               = $v1['postCode'];
              $dataPersonil[$nps]['nama_karyawan']          = $v1['name'];
              $dataPersonil[$nps]['no_telp']                = $v1['phone'];
              $dataPersonil[$nps]['tempat_lahir']           = $v1['birthdatePlace'];
              $dataPersonil[$nps]['gender']                 = $v1['gender'];
              $dataPersonil[$nps]['jenjang_pendidikan']     = $v1['degree'];
              $dataPersonil[$nps]['jurusan']                = $v1['major'];
              $dataPersonil[$nps]['ijazah_lampiran']        = $v1['educationAttachment'];
              $dataPersonil[$nps]['lokasi_pen']             = $v1['educationCity'];
              $dataPersonil[$nps]['nama_lembaga_pen']       = $v1['educationName'];
              $dataPersonil[$nps]['tahun_lulus']            = $v1['graduationDate'];
              $dataPersonil[$nps]['sertifikat_lampiran']    = $v1['certificationAttachment'];
              $dataPersonil[$nps]['lokasi_pel']             = $v1['certificationCity'];
              $dataPersonil[$nps]['nama_lembaga_pel']       = $v1['certificationName'];
              $dataPersonil[$nps]['nama_pelatihan']         = $v1['certificationType'];
              $dataPersonil[$nps]['kontrak_kerja_lampiran'] = $v1['contractAttachment'];
              $dataPersonil[$nps]['sim_lampiran']           = $v1['driveLicenseAttachment'];
              $dataPersonil[$nps]['tgl_mulai']              = $v1['startDate'];
              $dataPersonil[$nps]['tgl_selesai']            = $v1['finishDate'];
              $dataPersonil[$nps]['posisi']                 = $v1['position'];
              $dataPersonil[$nps]['status_karyawan']        = $v1['status'];
              $dataPersonil[$nps]['ktp_lampiran']           = $v1['idAttachment'];
              $dataPersonil[$nps]['nomor_ktp']              = $v1['idCard'];
              $dataPersonil[$nps]['last_work_date']         = $v1['lastWorkDate'];
              $dataPersonil[$nps]['lokasi_pekerjaan']       = $v1['location'];
              $dataPersonil[$nps]['project_name']           = $v1['projectName'];
              $dataPersonil[$nps]['project_owner']          = $v1['projectOwner'];
              $dataPersonil[$nps]['ref_client_lampiran']    = $v1['refDocAttachment'];
              $dataPersonil[$nps]['pendukung_lampiran']     = $v1['workAttachment'];
              $dataPersonil[$nps]['tahun_pelatihan']        = $v1['year'];
              $dataPersonil[$nps]['nomor_npwp']             = $v1['taxId'];
              $dataPersonil[$nps]['vendor_id']              = $v['vendorId'];
              $nps++;
            }
          }

          if (count($dataPersonil) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_personil");
            $personilresult = $this->db->insert_batch('vnd_personil', $dataPersonil);
          }
          
        } else {
      
          $dataPersonil = [];
          $nps = 0;
          foreach ($v["listVndSdm"] as $pers => $v1) {
            if ($v['vendorId'] != null) {
              $dataPersonil[$nps]['sdm_id']                 = $v1['sdmId'];
              $dataPersonil[$nps]['country']                = $v1['country'];
              $dataPersonil[$nps]['kewarganegaraan']        = $v1['nationality'];
              $dataPersonil[$nps]['province']               = $v1['province'];
              $dataPersonil[$nps]['city']                   = $v1['city'];
              $dataPersonil[$nps]['district']               = $v1['district'];
              $dataPersonil[$nps]['alamat']                 = $v1['address'];
              $dataPersonil[$nps]['kode_pos']               = $v1['postCode'];
              $dataPersonil[$nps]['nama_karyawan']          = $v1['name'];
              $dataPersonil[$nps]['no_telp']                = $v1['phone'];
              $dataPersonil[$nps]['tempat_lahir']           = $v1['birthdatePlace'];
              $dataPersonil[$nps]['gender']                 = $v1['gender'];
              $dataPersonil[$nps]['jenjang_pendidikan']     = $v1['degree'];
              $dataPersonil[$nps]['jurusan']                = $v1['major'];
              $dataPersonil[$nps]['ijazah_lampiran']        = $v1['educationAttachment'];
              $dataPersonil[$nps]['lokasi_pen']             = $v1['educationCity'];
              $dataPersonil[$nps]['nama_lembaga_pen']       = $v1['educationName'];
              $dataPersonil[$nps]['tahun_lulus']            = $v1['graduationDate'];
              $dataPersonil[$nps]['sertifikat_lampiran']    = $v1['certificationAttachment'];
              $dataPersonil[$nps]['lokasi_pel']             = $v1['certificationCity'];
              $dataPersonil[$nps]['nama_lembaga_pel']       = $v1['certificationName'];
              $dataPersonil[$nps]['nama_pelatihan']         = $v1['certificationType'];
              $dataPersonil[$nps]['kontrak_kerja_lampiran'] = $v1['contractAttachment'];
              $dataPersonil[$nps]['sim_lampiran']           = $v1['driveLicenseAttachment'];
              $dataPersonil[$nps]['tgl_mulai']              = $v1['startDate'];
              $dataPersonil[$nps]['tgl_selesai']            = $v1['finishDate'];
              $dataPersonil[$nps]['posisi']                 = $v1['position'];
              $dataPersonil[$nps]['status_karyawan']        = $v1['status'];
              $dataPersonil[$nps]['ktp_lampiran']           = $v1['idAttachment'];
              $dataPersonil[$nps]['nomor_ktp']              = $v1['idCard'];
              $dataPersonil[$nps]['last_work_date']         = $v1['lastWorkDate'];
              $dataPersonil[$nps]['lokasi_pekerjaan']       = $v1['location'];
              $dataPersonil[$nps]['project_name']           = $v1['projectName'];
              $dataPersonil[$nps]['project_owner']          = $v1['projectOwner'];
              $dataPersonil[$nps]['ref_client_lampiran']    = $v1['refDocAttachment'];
              $dataPersonil[$nps]['pendukung_lampiran']     = $v1['workAttachment'];
              $dataPersonil[$nps]['tahun_pelatihan']        = $v1['year'];
              $dataPersonil[$nps]['nomor_npwp']             = $v1['taxId'];
              $dataPersonil[$nps]['vendor_id']              = $v['vendorId'];
              $dataPersonil[$nps]['created_at']             = date('Y-m-d H:i:s');
              $nps++;
            }
          }
          
          if (count($dataPersonil) > 0) {
            $personilresult = $this->db->insert_batch('vnd_personil', $dataPersonil);
          }			

        }
      }

    // end personil

    // pengalaman
    
      $url_vendor_pengalaman = "https://pdc-api.pengadaan.com:443/vendor/pengalaman".$vendorIdparams; 

      $ch7 = curl_init($url_vendor_pengalaman);        
      curl_setopt($ch7, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch7, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch7, CURLOPT_ENCODING, ''); 
      curl_setopt($ch7, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch7, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch7, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch7, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch7, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($ch7, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch7, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_pengalaman = curl_exec($ch7);
      
      $arrays_pengalaman = json_decode($response_pengalaman, true);

      $dataPengalaman = $arrays_pengalaman["data"];
      
      if ($arrays_pengalaman['resultCode'] != 200) {
        echo $arrays_pengalaman['resultCode'];
        exit();
      }

      curl_close($ch7);

      foreach($dataPengalaman as $peng => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_pengalaman')->num_rows();
        
        if(!empty($check)){ 

          $dataPengalaman = [];
          $npn = 0;
          foreach ($v["listVndCv"] as $peng => $v1) {
            if ($v['vendorId'] != null) {
              $dataPengalaman[$npn]['cv_id']              = $v1['cvId'];
              $dataPengalaman[$npn]['alamat']             = $v1['address'];
              $dataPengalaman[$npn]['nomor_kontrak']      = $v1['contractNumber'];
              $dataPengalaman[$npn]['nilai']              = $v1['contractValue'];
              $dataPengalaman[$npn]['ruang_lingkup']      = $v1['scope'];
              $dataPengalaman[$npn]['tgl_kontrak']        = $v1['startDate'];
              $dataPengalaman[$npn]['tgl_selesai']        = $v1['endDate'];
              $dataPengalaman[$npn]['lokasi_kerja']       = $v1['location'];
              $dataPengalaman[$npn]['no_telp']            = $v1['phone'];
              $dataPengalaman[$npn]['nama_pekerjaan']     = $v1['projectName'];
              $dataPengalaman[$npn]['nama_pemberi']       = $v1['projectOwner'];
              $dataPengalaman[$npn]['currency']           = $v1['currency'];
              $dataPengalaman[$npn]['referensi_lampiran'] = $v1['refAtt'];
              $dataPengalaman[$npn]['kontrak_lampiran']   = $v1['contractAtt'];
              $dataPengalaman[$npn]['vendor_id']          = $v['vendorId'];
              $npn++;
            }
          }

          if (count($dataPengalaman) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_pengalaman");
            $pengalamanresult = $this->db->insert_batch('vnd_pengalaman', $dataPengalaman);
          }
          
        } else {
      
          $dataPengalaman = [];
          $npn = 0;
          foreach ($v["listVndCv"] as $peng => $v1) {
            if ($v['vendorId'] != null) {
              $dataPengalaman[$npn]['cv_id']              = $v1['cvId'];
              $dataPengalaman[$npn]['alamat']             = $v1['address'];
              $dataPengalaman[$npn]['nomor_kontrak']      = $v1['contractNumber'];
              $dataPengalaman[$npn]['nilai']              = $v1['contractValue'];
              $dataPengalaman[$npn]['ruang_lingkup']      = $v1['scope'];
              $dataPengalaman[$npn]['tgl_kontrak']        = $v1['startDate'];
              $dataPengalaman[$npn]['tgl_selesai']        = $v1['endDate'];
              $dataPengalaman[$npn]['lokasi_kerja']       = $v1['location'];
              $dataPengalaman[$npn]['no_telp']            = $v1['phone'];
              $dataPengalaman[$npn]['nama_pekerjaan']     = $v1['projectName'];
              $dataPengalaman[$npn]['nama_pemberi']       = $v1['projectOwner'];
              $dataPengalaman[$npn]['currency']           = $v1['currency'];
              $dataPengalaman[$npn]['referensi_lampiran'] = $v1['refAtt'];
              $dataPengalaman[$npn]['kontrak_lampiran']   = $v1['contractAtt'];
              $dataPengalaman[$npn]['vendor_id']          = $v['vendorId'];
              $dataPengalaman[$npn]['created_at']         = date('Y-m-d H:i:s');
              $npn++;
            }
          }
          
          if (count($dataPengalaman) > 0) {
            $pengalamanresult = $this->db->insert_batch('vnd_pengalaman', $dataPengalaman);
          }			

        }
      }

    // end pengalaman

    // alat
    
      $url_vendor_alat = "https://pdc-api.pengadaan.com:443/vendor/fasilitasPeralatan".$vendorIdparams; 

      $ch8 = curl_init($url_vendor_alat);        
      curl_setopt($ch8, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch8, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch8, CURLOPT_ENCODING, ''); 
      curl_setopt($ch8, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch8, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch8, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch8, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch8, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($ch8, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch8, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_alat = curl_exec($ch8);
      
      $arrays_alat = json_decode($response_alat, true);

      $dataAlat = $arrays_alat["data"];
      
      if ($arrays_alat['resultCode'] != 200) {
        echo $arrays_alat['resultCode'];
        exit();
      }

      curl_close($ch8);

      foreach($dataAlat as $peng => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_fasilitas')->num_rows();
        
        if(!empty($check)){ 

          $dataAlat = [];
          $nfa = 0;
          foreach ($v["listVndEquip"] as $fa => $v1) {
            if ($v['vendorId'] != null) {
              $dataAlat[$nfa]['equip_id']       = $v1['equipId'];
              $dataAlat[$nfa]['nama_fasilitas'] = $v1['name'];
              $dataAlat[$nfa]['merek']          = $v1['brand'];
              $dataAlat[$nfa]['kondisi']        = $v1['condition'];
              $dataAlat[$nfa]['lokasi']         = $v1['location'];
              $dataAlat[$nfa]['kepemilikan']    = $v1['ownership'];
              $dataAlat[$nfa]['specification']  = $v1['specification'];
              $dataAlat[$nfa]['jumlah']         = $v1['qty'];
              $dataAlat[$nfa]['tipe_fasilitas'] = $v1['type'];
              $dataAlat[$nfa]['purchase_date']  = $v1['purchaseDate'];
              $dataAlat[$nfa]['lampiran']       = $v1['attachment'];
              $dataAlat[$nfa]['vendor_id']      = $v['vendorId'];
              $nfa++;
            }
          }

          if (count($dataAlat) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_fasilitas");
            $alatresult = $this->db->insert_batch('vnd_fasilitas', $dataAlat);
          }
          
        } else {
      
          $dataAlat = [];
          $nfa = 0;
          foreach ($v["listVndEquip"] as $fa => $v1) {
            if ($v['vendorId'] != null) {
              $dataAlat[$nfa]['equip_id']       = $v1['equipId'];
              $dataAlat[$nfa]['nama_fasilitas'] = $v1['name'];
              $dataAlat[$nfa]['merek']          = $v1['brand'];
              $dataAlat[$nfa]['kondisi']        = $v1['condition'];
              $dataAlat[$nfa]['lokasi']         = $v1['location'];
              $dataAlat[$nfa]['kepemilikan']    = $v1['ownership'];
              $dataAlat[$nfa]['specification']  = $v1['specification'];
              $dataAlat[$nfa]['jumlah']         = $v1['qty'];
              $dataAlat[$nfa]['tipe_fasilitas'] = $v1['type'];
              $dataAlat[$nfa]['purchase_date']  = $v1['purchaseDate'];
              $dataAlat[$nfa]['lampiran']       = $v1['attachment'];
              $dataAlat[$nfa]['vendor_id']      = $v['vendorId'];
              $dataAlat[$nfa]['created_at']     = date('Y-m-d H:i:s');
              $nfa++;
            }
          }
          
          if (count($dataAlat) > 0) {
            $alatresult = $this->db->insert_batch('vnd_fasilitas', $dataAlat);
          }			

        }
      }

    // end alat

    // produk
    
      $url_vendor_produk = "https://pdc-api.pengadaan.com:443/vendor/klasifikasiBidangUsaha".$vendorIdparams; 

      $ch9 = curl_init($url_vendor_produk);        
      curl_setopt($ch9, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch9, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch9, CURLOPT_ENCODING, ''); 
      curl_setopt($ch9, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch9, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch9, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch9, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch9, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($ch9, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch9, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_produk = curl_exec($ch9);
      
      $arrays_produk = json_decode($response_produk, true);

      $dataProduk = $arrays_produk["data"];
      
      if ($arrays_produk['resultCode'] != 200) {
        echo $arrays_produk['resultCode'];
        exit();
      }

      curl_close($ch9);

      foreach($dataProduk as $pr => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_product')->num_rows();
        
        if(!empty($check)){ 

          $dataProduk = [];
          $nbu = 0;
          foreach ($v["listVndProduct"] as $prod => $v1) {
            if ($v['vendorId'] != null) {
              $dataProduk[$nbu]['brand']        = $v1['brand'];
              $dataProduk[$nbu]['product_code'] = $v1['codeGroup'];
              $dataProduk[$nbu]['name_group']   = $v1['nameGroup'];
              $dataProduk[$nbu]['product_id']   = $v1['productId'];
              $dataProduk[$nbu]['product_name'] = $v1['productName'];
              $dataProduk[$nbu]['source']       = $v1['source'];
              $dataProduk[$nbu]['type']         = $v1['type'];
              $dataProduk[$nbu]['vendor_id']    = $v['vendorId'];
              $dataProduk[$nbu]['updated_at']   = date('Y-m-d H:i:s');
              $nbu++;
            }
          }

          if (count($dataProduk) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->where("status",1);
            $this->db->delete("vnd_product");
            $produkresult = $this->db->insert_batch('vnd_product', $dataProduk);
          }
          
        } else {
      
          $dataProduk = [];
          $nbu = 0;
          foreach ($v["listVndProduct"] as $prod => $v1) {
            if ($v['vendorId'] != null) {
              $dataProduk[$nbu]['brand']        = $v1['brand'];
              $dataProduk[$nbu]['product_code'] = $v1['codeGroup'];
              $dataProduk[$nbu]['name_group']   = $v1['nameGroup'];
              $dataProduk[$nbu]['product_id']   = $v1['productId'];
              $dataProduk[$nbu]['product_name'] = $v1['productName'];
              $dataProduk[$nbu]['source']       = $v1['source'];
              $dataProduk[$nbu]['type']         = $v1['type'];
              $dataProduk[$nbu]['vendor_id']    = $v['vendorId'];
              $dataProduk[$nbu]['created_at']   = date('Y-m-d H:i:s');
              $nbu++;
            }
          }
          
          if (count($dataProduk) > 0) {
            $produkresult = $this->db->insert_batch('vnd_product', $dataProduk);
          }			

        }
      }

    // end produk

    // cv perorangan

      $url_vendor_perorangan = "https://pdc-api.pengadaan.com:443/vendor/cvPerorangan".$vendorIdparams; 

      $ch10 = curl_init($url_vendor_perorangan);        
      curl_setopt($ch10, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch10, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch10, CURLOPT_ENCODING, ''); 
      curl_setopt($ch10, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch10, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch10, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch10, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch10, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($ch10, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch10, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_perorangan = curl_exec($ch10);
      
      $arrays_perorangan = json_decode($response_perorangan, true);

      $dataPerorangan = $arrays_perorangan["data"];

      curl_close($ch10);
      
      if ($arrays_perorangan['resultCode'] != 200) {
        echo $arrays_perorangan['resultCode'];
        exit();
      }

      foreach($dataPerorangan as $cv => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check = $this->db->get('vnd_header')->num_rows();

        //update
        if(!empty($check)){ 
    
          $dataUpdate = array(
                'vendor_name'         => $v["fullname"],
                'addres_prop'         => $v["province"],
                'address_city'        => $v["city"],
                'address_district'    => $v["district"],
                'address_street'      => $v["address"],
                'address_postcode'    => $v["postCode"],
                'address_country'     => $v["country"],
                'npwp_no'             => $v["taxId"],
                'status_fp'           => $v["status"],
                'contact_name'        => $v["fullname"],
                'contact_phone_no'    => $v["telephoneNo"],
                'vendor_type'         => $v["vendorType"],
                'birth_date'          => $v["boardBirthdate"],
                'birth_place'         => $v["boardBirthplace"],
                'completed_date'      => $v["completedDate"],
                'id_card'             => $v["idCard"],
                'contract_attachment' => $v["contractAttachment"],
                'sim_attachment'      => $v["drivingLicenseAttachment"],
                'id_attachment'       => $v["idAttachment"],
                'ref_doc_attachment'  => $v["refDocAttachment"],
                'tax_attachment'      => $v["taxAttachment"],
                'siup_type'           => "Perorangan",
                'fin_class'           => "P",
                'vnd_jenis'           => 'Pengadaan.com',
                'modified_date'       => date('Y-m-d H:i:s'),
                'syncron_date'        => date('Y-m-d H:i:s')
          );

          $dataEducation = [];
          $ned = 0;
          foreach ($v["listVndEducation"] as $ed => $v1) {
            if ($v['vendorId'] != null) {
              $dataEducation[$ned]['vendor_id']     = $v['vendorId'];
              $dataEducation[$ned]['education_id']  = $v1['educationId'];
              $dataEducation[$ned]['institute']     = $v1['institute'];
              $dataEducation[$ned]['degree']        = $v1['degree'];
              $dataEducation[$ned]['major']         = $v1['major'];
              $dataEducation[$ned]['city']          = $v1['city'];
              $dataEducation[$ned]['year']          = $v1['year'];
              $dataEducation[$ned]['attachment']    = $v1['attachment'];
              $ned++;
            }
          }

          $dataWork = [];
          $nw = 0;
          foreach ($v["listVndExpWork"] as $wo => $v1) {
            if ($v['vendorId'] != null) {
              $dataWork[$nw]['vendor_id']     = $v['vendorId'];
              $dataWork[$nw]['exp_work_id']   = $v1['expWorkId'];
              $dataWork[$nw]['company_name']  = $v1['companyName'];
              $dataWork[$nw]['start_date']    = $v1['startDate'];
              $dataWork[$nw]['end_date']      = $v1['endDate'];
              $dataWork[$nw]['location']      = $v1['location'];
              $dataWork[$nw]['position']      = $v1['position'];
              $dataWork[$nw]['project_name']  = $v1['projectName'];
              $dataWork[$nw]['attachment']    = $v1['attachment'];
              $nw++;
            }
          }

          $dataTraining = [];
          $nt = 0;
          foreach ($v["listVndTraining"] as $vt => $v1) {
            if ($v['vendorId'] != null) {
              $dataTraining[$nt]['vendor_id']   = $v['vendorId'];
              $dataTraining[$nt]['training_id'] = $v1['trainingId'];
              $dataTraining[$nt]['city']        = $v1['city'];
              $dataTraining[$nt]['name']        = $v1['name'];
              $dataTraining[$nt]['institute']   = $v1['institute'];
              $dataTraining[$nt]['year']        = $v1['year'];
              $dataTraining[$nt]['attachment']  = $v1['attachment'];
              $nt++;
            }
          }

          //insert to db
          $this->db->where('vendor_id', $v["vendorId"]);
          $headresult = $this->db->update('vnd_header', $dataUpdate);
          
          if (count($dataEducation) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_education");
            $educationresult = $this->db->insert_batch('vnd_education', $dataEducation);
          }

          if (count($dataWork) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_exp_work");
            $workresult = $this->db->insert_batch('vnd_exp_work', $dataWork);
          }

          if (count($dataTraining) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_training");
            $trainingresult = $this->db->insert_batch('vnd_training', $dataTraining);
          }
          
        } else {
        
            $dataInsert = array(
                'vendor_name'         => $v["fullname"],
                'addres_prop'         => $v["province"],
                'address_city'        => $v["city"],
                'address_district'    => $v["district"],
                'address_street'      => $v["address"],
                'address_postcode'    => $v["postCode"],
                'address_country'     => $v["country"],
                'npwp_no'             => $v["taxId"],
                'status_fp'           => $v["status"],
                'contact_name'        => $v["fullname"],
                'contact_phone_no'    => $v["telephoneNo"],
                'vendor_type'         => $v["vendorType"],
                'birth_date'          => $v["boardBirthdate"],
                'birth_place'         => $v["boardBirthplace"],
                'completed_date'      => $v["completedDate"],
                'id_card'             => $v["idCard"],
                'contract_attachment' => $v["contractAttachment"],
                'sim_attachment'      => $v["drivingLicenseAttachment"],
                'id_attachment'       => $v["idAttachment"],
                'ref_doc_attachment'  => $v["refDocAttachment"],
                'tax_attachment'      => $v["taxAttachment"],
                'siup_type'           => "Perorangan",
                'fin_class'           => "P",
                'vnd_jenis'           => 'Pengadaan.com',
                'modified_date'       => date('Y-m-d H:i:s'),
                'syncron_date'        => date('Y-m-d H:i:s')
            );

            $dataEducation = [];
            $ned = 0;
            foreach ($v["listVndEducation"] as $ed => $v1) {
                if ($v['vendorId'] != null) {
                    $dataEducation[$ned]['vendor_id']     = $v['vendorId'];
                    $dataEducation[$ned]['education_id']  = $v1['educationId'];
                    $dataEducation[$ned]['institute']     = $v1['institute'];
                    $dataEducation[$ned]['degree']        = $v1['degree'];
                    $dataEducation[$ned]['major']         = $v1['major'];
                    $dataEducation[$ned]['city']          = $v1['city'];
                    $dataEducation[$ned]['year']          = $v1['year'];
                    $dataEducation[$ned]['attachment']    = $v1['attachment'];
                    $dataEducation[$ned]['created_at']    = date('Y-m-d H:i:s');
                    $ned++;
                }
            }

            $dataWork = [];
            $nw = 0;
            foreach ($v["listVndExpWork"] as $wo => $v1) {
                if ($v['vendorId'] != null) {
                    $dataWork[$nw]['vendor_id']     = $v['vendorId'];
                    $dataWork[$nw]['exp_work_id']   = $v1['expWorkId'];
                    $dataWork[$nw]['company_name']  = $v1['companyName'];
                    $dataWork[$nw]['start_date']    = $v1['startDate'];
                    $dataWork[$nw]['end_date']      = $v1['endDate'];
                    $dataWork[$nw]['location']      = $v1['location'];
                    $dataWork[$nw]['position']      = $v1['position'];
                    $dataWork[$nw]['project_name']  = $v1['projectName'];
                    $dataWork[$nw]['attachment']    = $v1['attachment'];
                    $dataWork[$nw]['created_at']    = date('Y-m-d H:i:s');
                    $nw++;
                }
            }

            $dataTraining = [];
            $nt = 0;
            foreach ($v["listVndTraining"] as $vt => $v1) {
                if ($v['vendorId'] != null) {
                    $dataTraining[$nt]['vendor_id']   = $v['vendorId'];
                    $dataTraining[$nt]['training_id'] = $v1['trainingId'];
                    $dataTraining[$nt]['city']        = $v1['city'];
                    $dataTraining[$nt]['name']        = $v1['name'];
                    $dataTraining[$nt]['institute']   = $v1['institute'];
                    $dataTraining[$nt]['year']        = $v1['year'];
                    $dataTraining[$nt]['attachment']  = $v1['attachment'];
                    $dataTraining[$nt]['created_at']  = date('Y-m-d H:i:s');
                    $nt++;
                }
            }

            //insert to db 
            $headresult = $this->db->insert('vnd_header', $dataInsert);

            if (count($dataEducation) > 0) {
                $educationresult = $this->db->insert_batch('vnd_education', $dataEducation);
            }		

            if (count($dataWork) > 0) {
                $workresult = $this->db->insert_batch('vnd_exp_work', $dataWork);
            }	

            if (count($dataTraining) > 0) {
                $trainingresult = $this->db->insert_batch('vnd_training', $dataTraining);
            }		

        }
      }

    // end cv perorangan
    
    // keuangan
    
      $url_vendor_keuangan = "https://pdc-api.pengadaan.com:443/vendor/keuangan".$vendorIdparams; 

      $ch11 = curl_init($url_vendor_keuangan);        
      curl_setopt($ch11, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch11, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch11, CURLOPT_ENCODING, ''); 
      curl_setopt($ch11, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch11, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch11, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch11, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch11, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($ch11, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch11, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_keuangan = curl_exec($ch11);
      
      $arrays_keuangan = json_decode($response_keuangan, true);

      $dataKeuangan = $arrays_keuangan["data"];
      
      if ($arrays_keuangan['resultCode'] != 200) {
        echo $arrays_keuangan['resultCode'];
        exit();
      }

      curl_close($ch11);

      foreach($dataKeuangan as $keu => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check_header = $this->db->get('vnd_header')->num_rows();

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check_bank = $this->db->get('vnd_bank')->num_rows();

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $this->db->where('jenis', 'listVndDnB');
        $check_dnb = $this->db->get('vnd_dnb')->num_rows();

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check_fin = $this->db->get('vnd_fin_rpt')->num_rows();
        
        if($check_header > 0){
          $dataUpdate = array(
            'kemampuanNyata' => $v["kemampuanNyata"],
            'md_mata_uang' => $v["modalDisetorCurrency"],
            'md_nilai' => $v["modalDisetorNilai"],
            'mu_mata_uang' => $v["modalUsahaCurrency"],
            'mu_nilai' => $v["modalUsahaNilai"],
            'nilaiPekerjaanBerjalan' => $v["nilaiPekerjaanBerjalan"],
            'notBankruptAtt' => $v["notBankruptAtt"],
            'sisaKemampuanNyata' => $v["sisaKemampuanNyata"],
            'npwp_no' => $v["taxId"],
            'totalModalTahunTerakhir' => $v["totalModalTahunTerakhir"],
          );

          //update to db
          $this->db->where('vendor_id', $v["vendorId"]);
          $headresult = $this->db->update('vnd_header', $dataUpdate);
        }

        if($check_dnb > 0){ 

          $dataDnb = [];
          $nd = 0;
          foreach ($v["listVndDnB"] as $n => $v2) {
            if ($v2['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v2['attachment'];
              $dataDnb[$nd]['docname'] = $v2['docName'];
              $dataDnb[$nd]['doctype'] = $v2['docType'];
              $dataDnb[$nd]['notes'] = $v2['notes'];
              $dataDnb[$nd]['jenis'] = 'listVndDnB';
              $dataDnb[$nd]['created_at'] = date('Y-m-d H:i:s');
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_dnb");
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }
          
        } else {
      
          $dataDnb = [];
          $nd = 0;
          foreach ($v["listVndDnB"] as $n => $v2) {
            if ($v2['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v2['attachment'];
              $dataDnb[$nd]['docname'] = $v2['docName'];
              $dataDnb[$nd]['doctype'] = $v2['docType'];
              $dataDnb[$nd]['notes'] = $v2['notes'];
              $dataDnb[$nd]['jenis'] = 'listVndDnB';
              $dataDnb[$nd]['created_at'] = date('Y-m-d H:i:s');
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }

        }

        if($check_fin > 0){ 

          $dataFin = [];
          $nf = 0;
          foreach ($v["listVndFinRpt"] as $f => $v3) {
            if ($v3['finRptId'] != null) {
              $dataFin[$nf]['vendor_id']  = $v['vendorId'];
              $dataFin[$nf]['asset'] = $v3['asset'];
              $dataFin[$nf]['attachment'] = $v3['attachment'];
              $dataFin[$nf]['auditoraddress'] = $v3['auditorAddress'];
              $dataFin[$nf]['auditorname'] = $v3['auditorName'];
              $dataFin[$nf]['currency'] = $v3['currency'];
              $dataFin[$nf]['finaudittype'] = $v3['finAuditType'];
              $dataFin[$nf]['finrpttotalcapital'] = $v3['finRptTotalCapital'];
              $dataFin[$nf]['hutang'] = $v3['hutang'];
              $dataFin[$nf]['income'] = $v3['income'];
              $dataFin[$nf]['netprofit'] = $v3['netProfit'];
              $dataFin[$nf]['operatingexpenses'] = $v3['operatingExpenses'];
              $dataFin[$nf]['reportdate'] = $v3['reportDate'];
              $dataFin[$nf]['type'] = $v3['type'];
              $dataFin[$nf]['year'] = $v3['year'];
              $dataFin[$nf]['created_at'] = date('Y-m-d H:i:s');
              $nf++;
            }
          }
          
          if (count($dataFin) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_fin_rpt");
            $finresult = $this->db->insert_batch('vnd_fin_rpt', $dataFin);
          }
          
        } else {
      
          $dataFin = [];
          $nf = 0;
          foreach ($v["listVndFinRpt"] as $f => $v3) {
            if ($v3['finRptId'] != null) {
              $dataFin[$nf]['vendor_id']  = $v['vendorId'];
              $dataFin[$nf]['asset'] = $v3['asset'];
              $dataFin[$nf]['attachment'] = $v3['attachment'];
              $dataFin[$nf]['auditoraddress'] = $v3['auditorAddress'];
              $dataFin[$nf]['auditorname'] = $v3['auditorName'];
              $dataFin[$nf]['currency'] = $v3['currency'];
              $dataFin[$nf]['finaudittype'] = $v3['finAuditType'];
              $dataFin[$nf]['finrpttotalcapital'] = $v3['finRptTotalCapital'];
              $dataFin[$nf]['hutang'] = $v3['hutang'];
              $dataFin[$nf]['income'] = $v3['income'];
              $dataFin[$nf]['netprofit'] = $v3['netProfit'];
              $dataFin[$nf]['operatingexpenses'] = $v3['operatingExpenses'];
              $dataFin[$nf]['reportdate'] = $v3['reportDate'];
              $dataFin[$nf]['type'] = $v3['type'];
              $dataFin[$nf]['year'] = $v3['year'];
              $dataFin[$nf]['created_at'] = date('Y-m-d H:i:s');
              $nf++;
            }
          }
          
          if (count($dataFin) > 0) {
            $finresult = $this->db->insert_batch('vnd_fin_rpt', $dataFin);
          }

        }

        if(!empty($check_bank)){ 

          $dataBank = [];
          $nb = 0;
          foreach ($v["listVndBank"] as $b => $v4) {
            if ($v4['bankId'] != null) {
              $dataBank[$nb]['vendor_id']           = $v['vendorId'];
              $dataBank[$nb]['account_no']          = $v4['accountNo'];
              $dataBank[$nb]['account_name']        = $v4['accountOwner'];
              $dataBank[$nb]['bank_id']             = $v4['bankSwiftCode'];
              $dataBank[$nb]['bank_branch']         = $v4['branch'];
              $dataBank[$nb]['bank_name']           = $v4['bankName'];
              $dataBank[$nb]['currency']            = $v4['currency'];
              $dataBank[$nb]['country']             = $v4['bankCountry'];
              $dataBank[$nb]['transactionalAtt']    = $v4['transactionalAtt'];
              $dataBank[$nb]['statementLetterAtt']  = $v4['statementLetterAtt'];
              $dataBank[$nb]['bankId']              = $v4['bankId'];
              $dataBank[$nb]['last_modified']       = date('Y-m-d H:i:s');
              $nb++;
            }
          }
          
          if (count($dataBank) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_bank");
            $bankresult = $this->db->insert_batch('vnd_bank', $dataBank);
          }
          
        } else {
      
          $dataBank = [];
          $nb = 0;
          foreach ($v["listVndBank"] as $b => $v4) {
            if ($v4['bankId'] != null) {
              $dataBank[$nb]['vendor_id']           = $v['vendorId'];
              $dataBank[$nb]['account_no']          = $v4['accountNo'];
              $dataBank[$nb]['account_name']        = $v4['accountOwner'];
              $dataBank[$nb]['bank_id']             = $v4['bankSwiftCode'];
              $dataBank[$nb]['bank_branch']         = $v4['branch'];
              $dataBank[$nb]['bank_name']           = $v4['bankName'];
              $dataBank[$nb]['currency']            = $v4['currency'];
              $dataBank[$nb]['country']             = $v4['bankCountry'];
              $dataBank[$nb]['transactionalAtt']    = $v4['transactionalAtt'];
              $dataBank[$nb]['statementLetterAtt']  = $v4['statementLetterAtt'];
              $dataBank[$nb]['bankId']              = $v4['bankId'];
              $dataBank[$nb]['last_modified']       = date('Y-m-d H:i:s');
              $nb++;
            }
          }
          
          if (count($dataBank) > 0) {
            $bankresult = $this->db->insert_batch('vnd_bank', $dataBank);
          }

        }

      }

    // end keuangan

    // docs
    
      $url_vendor_doc = "https://pdc-api.pengadaan.com:443/vendor/othersDoc".$vendorIdparams; 

      $ch12 = curl_init($url_vendor_doc);        
      curl_setopt($ch12, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch12, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch12, CURLOPT_ENCODING, ''); 
      curl_setopt($ch12, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch12, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch12, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch12, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch12, CURLOPT_SSL_VERIFYHOST, false);
      curl_setopt($ch12, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch12, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_doc = curl_exec($ch12);
      
      $arrays_doc = json_decode($response_doc, true);

      $dataDoc = $arrays_doc["data"];
      
      if ($arrays_doc['resultCode'] != 200) {
        echo $arrays_doc['resultCode'];
        exit();
      }

      curl_close($ch12);

      foreach($dataDoc as $doc => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check_header = $this->db->get('vnd_header')->num_rows();

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $this->db->where('jenis', 'listDocJasaKhusus');
        $check_jk = $this->db->get('vnd_dnb')->num_rows();

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $this->db->where('jenis', 'listDocKerjasama');
        $check_kj = $this->db->get('vnd_dnb')->num_rows();

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $this->db->where('jenis', 'listDocManajemen');
        $check_mm = $this->db->get('vnd_dnb')->num_rows();

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $this->db->where('jenis', 'listDocMandor');
        $check_md = $this->db->get('vnd_dnb')->num_rows();
        
        if($check_header > 0){
          $dataUpdate = array(
            'antiBriberyAtt' => $v["antiBriberyAtt"],
            'antiBriberyPolicyAtt' => $v["antiBriberyPolicyAtt"],
            'domesticAtt' => $v["domesticAtt"],
            'organizationAtt' => $v["organizationAtt"],
            'paktaAtt' => $v["paktaAtt"],
            'umkmAtt' => $v["umkmAtt"]
          );

          //update to db
          $this->db->where('vendor_id', $v["vendorId"]);
          $headresult = $this->db->update('vnd_header', $dataUpdate);
        }

        if($check_jk > 0){ 

          $dataDnb = [];
          $nd = 0;
          foreach ($v["listDocJasaKhusus"] as $n => $v1) {
            if ($v1['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v1['attachment'];
              $dataDnb[$nd]['docname'] = $v1['docName'];
              $dataDnb[$nd]['doctype'] = $v1['docType'];
              $dataDnb[$nd]['notes'] = $v1['notes'];
              $dataDnb[$nd]['jenis'] = 'listDocJasaKhusus';
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_dnb");
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }
          
        } else {
      
          $dataDnb = [];
          $nd = 0;
          foreach ($v["listDocJasaKhusus"] as $n => $v1) {
            if ($v1['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v1['attachment'];
              $dataDnb[$nd]['docname'] = $v1['docName'];
              $dataDnb[$nd]['doctype'] = $v1['docType'];
              $dataDnb[$nd]['notes'] = $v1['notes'];
              $dataDnb[$nd]['jenis'] = 'listDocJasaKhusus';
              $dataDnb[$nd]['created_at'] = date('Y-m-d H:i:s');
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }

        }

        if($check_kj > 0){ 

          $dataDnb = [];
          $nd = 0;
          foreach ($v["listDocKerjasama"] as $n => $v1) {
            if ($v1['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v1['attachment'];
              $dataDnb[$nd]['docname'] = $v1['docName'];
              $dataDnb[$nd]['doctype'] = $v1['docType'];
              $dataDnb[$nd]['notes'] = $v1['notes'];
              $dataDnb[$nd]['jenis'] = 'listDocKerjasama';
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_dnb");
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }
          
        } else {
      
          $dataDnb = [];
          $nd = 0;
          foreach ($v["listDocKerjasama"] as $n => $v1) {
            if ($v1['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v1['attachment'];
              $dataDnb[$nd]['docname'] = $v1['docName'];
              $dataDnb[$nd]['doctype'] = $v1['docType'];
              $dataDnb[$nd]['notes'] = $v1['notes'];
              $dataDnb[$nd]['jenis'] = 'listDocKerjasama';
              $dataDnb[$nd]['created_at'] = date('Y-m-d H:i:s');
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }

        }

        if($check_mm > 0){ 

          $dataDnb = [];
          $nd = 0;
          foreach ($v["listDocManajemen"] as $n => $v1) {
            if ($v1['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v1['attachment'];
              $dataDnb[$nd]['docname'] = $v1['docName'];
              $dataDnb[$nd]['doctype'] = $v1['docType'];
              $dataDnb[$nd]['notes'] = $v1['notes'];
              $dataDnb[$nd]['jenis'] = 'listDocManajemen';
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_dnb");
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }
          
        } else {
      
          $dataDnb = [];
          $nd = 0;
          foreach ($v["listDocManajemen"] as $n => $v1) {
            if ($v1['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v1['attachment'];
              $dataDnb[$nd]['docname'] = $v1['docName'];
              $dataDnb[$nd]['doctype'] = $v1['docType'];
              $dataDnb[$nd]['notes'] = $v1['notes'];
              $dataDnb[$nd]['jenis'] = 'listDocManajemen';
              $dataDnb[$nd]['created_at'] = date('Y-m-d H:i:s');
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }

        }

        if($check_md > 0){ 

          $dataDnb = [];
          $nd = 0;
          foreach ($v["listDocMandor"] as $n => $v1) {
            if ($v1['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v1['attachment'];
              $dataDnb[$nd]['docname'] = $v1['docName'];
              $dataDnb[$nd]['doctype'] = $v1['docType'];
              $dataDnb[$nd]['notes'] = $v1['notes'];
              $dataDnb[$nd]['jenis'] = 'listDocMandor';
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_dnb");
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }
          
        } else {
      
          $dataDnb = [];
          $nd = 0;
          foreach ($v["listDocMandor"] as $n => $v1) {
            if ($v1['attachment'] != null) {
              $dataDnb[$nd]['vendor_id']  = $v['vendorId'];
              $dataDnb[$nd]['attachment'] = $v1['attachment'];
              $dataDnb[$nd]['docname'] = $v1['docName'];
              $dataDnb[$nd]['doctype'] = $v1['docType'];
              $dataDnb[$nd]['notes'] = $v1['notes'];
              $dataDnb[$nd]['jenis'] = 'listDocMandor';
              $dataDnb[$nd]['created_at'] = date('Y-m-d H:i:s');
              $nd++;
            }
          }
          
          if (count($dataDnb) > 0) {
            $dnbresult = $this->db->insert_batch('vnd_dnb', $dataDnb);
          }

        }

      }

    // end docs

    // cqsms
    
      $url_vendor_cqsms = "https://pdc-api.pengadaan.com:443/vendor/cqsms".$vendorIdparams; 

      $ch13 = curl_init($url_vendor_cqsms);        
      curl_setopt($ch13, CURLOPT_MAXREDIRS, 10);    
      curl_setopt($ch13, CURLOPT_TIMEOUT, 0);    
      curl_setopt($ch13, CURLOPT_ENCODING, ''); 
      curl_setopt($ch13, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
      curl_setopt($ch13, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($ch13, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch13, CURLOPT_SSL_VERIFYPEER, false); 
      curl_setopt($ch13, CURLOPT_SSL_VERIFYHOST, false); 
      curl_setopt($ch13, CURLOPT_CUSTOMREQUEST, 'GET'); 
      curl_setopt($ch13, CURLOPT_HTTPHEADER, array(
          'Authorization: ' . $tokenType . ' ' . $accessToken
      ));                                                                                                            
      
      $response_cqsms = curl_exec($ch13);
      
      $arrays_cqsms = json_decode($response_cqsms, true);

      $dataCqsms = $arrays_cqsms["data"];
      
      if ($arrays_cqsms['resultCode'] != 200) {
        echo $arrays_cqsms['resultCode'];
        exit();
      }

      curl_close($ch13);

      foreach($dataCqsms as $cq => $v){
      
        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check_header = $this->db->get('vnd_header')->num_rows();

        $this->db->select('vendor_id');
        $this->db->where('vendor_id', $v["vendorId"]);
        $check_cqsms = $this->db->get('vnd_cqsms')->num_rows();
        
        if($check_header > 0){
          $dataUpdate = array(
            'lastCqsmsApprovedDate' => $v["lastCqsmsApprovedDate"],
          );

          //update to db
          $this->db->where('vendor_id', $v["vendorId"]);
          $headresult = $this->db->update('vnd_header', $dataUpdate);
        }

        if($check_cqsms > 0){ 

          $dataCqsms = [];
          $dataCqsmsItem = [];
          $dataCqsmsDoc = [];

          $nc = 0;
          $ni = 0;
          $nd = 0;

          foreach ($v["cqsmsData"] as $n => $v2) {
            if ($v2['cqsmsId'] != null) {
              $dataCqsms[$nc]['vendor_id']  = $v['vendorId'];
              $dataCqsms[$nc]['cqsmsid']  = $v2['cqsmsId'];
              $dataCqsms[$nc]['cqsmsapproveddate']  = $v2['cqsmsApprovedDate'];
              $dataCqsms[$nc]['cqsmsgrade']  = $v2['cqsmsGrade'];
              $dataCqsms[$nc]['cqsmsnilaiakhir']  = $v2['cqsmsNilaiAkhir'];
              $dataCqsms[$nc]['cqsmsnilaiawal']  = $v2['cqsmsNilaiAwal'];
              $dataCqsms[$nc]['cqsmspenguranganqhse']  = $v2['cqsmsPenguranganQhse'];
              $dataCqsms[$nc]['cqsmstype']  = $v2['cqsmsType'];
              $dataCqsms[$nc]['created_at'] = date('Y-m-d H:i:s');
              $nc++;

              foreach ($v2["cqsmsItems"] as $n2 => $v3) {
                $dataCqsmsItem[$ni]['bab'] = $v3['bab']; 
                $dataCqsmsItem[$ni]['item'] = $v3['item']; 
                $dataCqsmsItem[$ni]['itemid'] = $v3['itemId']; 
                $dataCqsmsItem[$ni]['notes'] = $v3['notes']; 
                $dataCqsmsItem[$ni]['poin'] = $v3['poin']; 
                $dataCqsmsItem[$ni]['created_at'] = date('Y-m-d H:i:s');
                $ni++;

                foreach ($v3["listAttachment"] as $n3 => $v4) {
                  $dataCqsmsDoc[$nd]['docid'] = $v4['docId']; 
                  $dataCqsmsDoc[$nd]['docname'] = $v4['docName']; 
                  $dataCqsmsDoc[$nd]['docurl'] = $v4['docUrl']; 
                  $dataCqsmsDoc[$nd]['created_at'] = date('Y-m-d H:i:s');
                }

                if (count($dataCqsmsDoc) > 0) {
                  $this->db->where("cqsms_item_id",$v3['itemId']);
                  $this->db->delete("vnd_cqsms_doc");
                  $docresult = $this->db->insert_batch('vnd_cqsms_doc', $dataCqsmsDoc);
                }
              }
              
              if (count($dataCqsmsItem) > 0) {
                $this->db->where("cqsms_id",$v2['cqsmsId']);
                $this->db->delete("vnd_cqsms_items");
                $itemresult = $this->db->insert_batch('vnd_cqsms_items', $dataCqsmsItem);
              }

            }
          }
          
          if (count($dataCqsms) > 0) {
            $this->db->where("vendor_id",$v["vendorId"]);
            $this->db->delete("vnd_cqsms");
            $cqsmsresult = $this->db->insert_batch('vnd_cqsms', $dataCqsms);
          }
          
        } else {
      
          $dataCqsms = [];
          $dataCqsmsItem = [];
          $dataCqsmsDoc = [];

          $nc = 0;
          $ni = 0;
          $nd = 0;

          foreach ($v["cqsmsData"] as $n => $v2) {
            if ($v2['cqsmsId'] != null) {
              $dataCqsms[$nc]['vendor_id']  = $v['vendorId'];
              $dataCqsms[$nc]['cqsmsid']  = $v2['cqsmsId'];
              $dataCqsms[$nc]['cqsmsapproveddate']  = $v2['cqsmsApprovedDate'];
              $dataCqsms[$nc]['cqsmsgrade']  = $v2['cqsmsGrade'];
              $dataCqsms[$nc]['cqsmsnilaiakhir']  = $v2['cqsmsNilaiAkhir'];
              $dataCqsms[$nc]['cqsmsnilaiawal']  = $v2['cqsmsNilaiAwal'];
              $dataCqsms[$nc]['cqsmspenguranganqhse']  = $v2['cqsmsPenguranganQhse'];
              $dataCqsms[$nc]['cqsmstype']  = $v2['cqsmsType'];
              $dataCqsms[$nc]['created_at'] = date('Y-m-d H:i:s');
              $nc++;
              
              foreach ($v2["cqsmsItems"] as $n2 => $v3) {
                $dataCqsmsItem[$ni]['bab'] = $v3['bab']; 
                $dataCqsmsItem[$ni]['item'] = $v3['item']; 
                $dataCqsmsItem[$ni]['itemid'] = $v3['itemId']; 
                $dataCqsmsItem[$ni]['notes'] = $v3['notes']; 
                $dataCqsmsItem[$ni]['poin'] = $v3['poin']; 
                $dataCqsmsItem[$ni]['created_at'] = date('Y-m-d H:i:s');
                $ni++;

                foreach ($v3["listAttachment"] as $n3 => $v4) {
                  $dataCqsmsDoc[$nd]['docid'] = $v4['docId']; 
                  $dataCqsmsDoc[$nd]['docname'] = $v4['docName']; 
                  $dataCqsmsDoc[$nd]['docurl'] = $v4['docUrl']; 
                  $dataCqsmsDoc[$nd]['created_at'] = date('Y-m-d H:i:s');
                }

                if (count($dataCqsmsDoc) > 0) {
                  $docresult = $this->db->insert_batch('vnd_cqsms_doc', $dataCqsmsDoc);
                }
              }
              
              if (count($dataCqsmsItem) > 0) {
                $itemresult = $this->db->insert_batch('vnd_cqsms_items', $dataCqsmsItem);
              }
            }
          }
          
          if (count($dataCqsms) > 0) {
            $cqsmsresult = $this->db->insert_batch('vnd_cqsms', $dataCqsms);
          }

        }

      }

    // end cqsms

    if ($this->db->trans_status() == FALSE){
      $this->db->trans_rollback();
      return 'fail';

    } else {
      $this->db->trans_commit();
      return 'success';
    }
    
  }

  public function pushContract(){
    
    $curl = curl_init();    

    $data_token = array(
        'token' => '9401A056-B477-499D-AF52-FC3A4F573092'
    );

    $payload_token = json_encode( $data_token );
    
    curl_setopt_array($curl, array(      
      CURLOPT_URL => "https://pdc-api.pengadaan.com/security/login",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $payload_token,
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
      ),
    ));

    $response_token = curl_exec($curl);
    $err = curl_error($curl);	  

    curl_close($curl);  

    if ($err) {
      echo "cURL Error #:" . $err;
      return "cURL Error #:" . $err;
      exit();
    } else {
      $obj_response = json_decode($response_token);
      $accessToken = $obj_response->accessToken;
      $tokenType = $obj_response->tokenType;
    }

    $curl2 = curl_init();

    curl_setopt_array($curl2, array(
      CURLOPT_URL => 'https://pdc-api.pengadaan.com:443/karya/pushContract',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
          "contractDescription": "string",
          "contractEndDate": "2022-07-29T06:44:59.115Z",
          "contractNumber": "string",
          "contractNumberMain": "string",
          "contractSignDate": "2022-07-29T06:44:59.115Z",
          "contractStartDate": "2022-07-29T06:44:59.115Z",
          "contractTypeId": 0,
          "contractValue": 0,
          "currency": "string",
          "vendorId": 0,
          "vendorNpwp": "string"
      }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $tokenType . ' ' . $accessToken,
        'Content-Type: application/json'
      ),
    ));

    $response2 = curl_exec($curl2);

    curl_close($curl2);

    if ($this->db->trans_status() == FALSE){
      $this->db->trans_rollback();
      return 'fail';

    } else {
      $this->db->trans_commit();
      return 'success';
    }
  }

  public function pushPerformance(){
    
    $curl = curl_init();    

    $data_token = array(
      'token' => '7D67DB6F-8610-4566-BFB7-EB613EE7535B'
    );

    $payload_token = json_encode( $data_token );
    
    curl_setopt_array($curl, array(      
      CURLOPT_URL => "https://pdc-api.pengadaan.com/security/login",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_SSL_VERIFYPEER => false,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => $payload_token,
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json"
      ),
    ));

    $response_token = curl_exec($curl);
    $err = curl_error($curl);	  

    curl_close($curl);  

    if ($err) {
      echo "cURL Error #:" . $err;
      return "cURL Error #:" . $err;
      exit();
    } else {
      $obj_response = json_decode($response_token);
      $accessToken = $obj_response->accessToken;
      $tokenType = $obj_response->tokenType;
    }

    $curl2 = curl_init();

    curl_setopt_array($curl2, array(
      CURLOPT_URL => 'https://pdc-api.pengadaan.com:443/karya/pushVendorPerformance',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
          "penaltyArticle": "string",
          "penaltyDescription": "string",
          "penaltyEnddate": "2022-07-29T08:40:13.079Z",
          "penaltyStartdate": "2022-07-29T08:40:13.079Z",
          "penaltyStatusId": 0,
          "vendorId": 0,
          "vendorNpwp": "string"
      }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: ' . $tokenType . ' ' . $accessToken,
        'Content-Type: application/json'
      ),
    ));

    $response2 = curl_exec($curl2);

    curl_close($curl2);

    if ($this->db->trans_status() == FALSE){
      $this->db->trans_rollback();
      return 'fail';

    } else {
      $this->db->trans_commit();
      return 'success';
    }
  }

  private function checkpos($arr){
    
    $allData = [];

    foreach ($arr as $k => $v) {
      
      if ($v['pos'] == 'DIREKTUR UTAMA') {
        $allData['DIREKTUR UTAMA'][] = $v; 
      
      }else if ($v['pos'] == 'PRESIDEN DIREKTUR') {
        $allData['PRESIDEN DIREKTUR'][] = $v; 

      }else if ($v['pos'] == 'DIREKTUR') {
        $allData['DIREKTUR'][] = $v; 

      }else{
        $allData['ELSE'][] = $v; 
      }
    }


    if (!empty($allData['DIREKTUR UTAMA'])) {
      $data = $allData['DIREKTUR UTAMA'][0];

    }else if (!empty($allData['PRESIDEN DIREKTUR'])) {
      $data = $allData['PRESIDEN DIREKTUR'][0];

    }else if(!empty($allData['DIREKTUR'])){
      $data = $allData['DIREKTUR'][0];

    }else{
      $data = $allData['ELSE'][0];
    }

    return $ret = [
        'name' => $data['name'],
        'pos'  => $data['pos']
      ];

  }

  public function getBankWs($vendor_id = ''){
		$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
		$databank = json_decode(file_get_contents($url_ws."/vndbank.json?token=123456&vendorId=".$vendor_id."&act=1"), true);

		$cou = count($databank['listVndBank']);

		for ($i=0; $i < $cou; $i++) {

			$isbank = strpos($databank['listVndBank'][$i]['currency'], "IDR");

			if ($isbank !== FALSE) {
				$nama = $databank['listVndBank'][$i]['accountName'];
				$bank = $databank['listVndBank'][$i]['bankName'];
				$rek = $databank['listVndBank'][$i]['accountNo'];
				$alamat = $databank['listVndBank'][$i]['address'];
				$cabang = $databank['listVndBank'][$i]['bankBranch'];
				$bankid = $databank['listVndBank'][$i]['bankId'];
				$matauang = $databank['listVndBank'][$i]['currency'];
				$vendorid = $databank['listVndBank'][$i]['vndHeader'];
			}

			if (!isset($nama) || !isset($bank) || !isset($rek)) {
				$nama = $databank['listVndBank'][$i]['accountName'];
				$bank = $databank['listVndBank'][$i]['bankName'];
				$rek = $databank['listVndBank'][$i]['accountNo'];
				$alamat = $databank['listVndBank'][$i]['address'];
				$cabang = $databank['listVndBank'][$i]['bankBranch'];
				$bankid = $databank['listVndBank'][$i]['bankId'];
				$matauang = $databank['listVndBank'][$i]['currency'];
				$vendorid = $databank['listVndBank'][$i]['vndHeader'];
			}
		}

		$banks = [
			'nama' => isset($nama) ? $nama : NULL,
			'bank' => isset($bank) ? $bank : NULL,
			'rek' => isset($rek) ? $rek : NULL,
			'alamat' => isset($alamat) ? $alamat : NULL,
			'cabang' => isset($cabang) ? $cabang : NULL,
			'bankid' => isset($bankid) ? $bankid : NULL,
			'matauang' => isset($matauang) ? $matauang : NULL,
			'vendorid' => isset($vendorid) ? $vendorid : NULL
		];

		return $banks;
	}

}
     