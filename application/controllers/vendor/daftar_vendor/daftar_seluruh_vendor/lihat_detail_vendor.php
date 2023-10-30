<?php 

  $view = 'vendor/daftar_vendor/daftar_seluruh_vendor/lihat_detail_vendor_v';

  $vendor_id = $this->uri->segment(4, 0);

  switch ($this->uri->segment(3,0)) {
    case 'lihat_detail_vendor':
      $vendor_id = $this->uri->segment(4, 0);
      break;
    
    default:
      $vendor_id = $this->uri->segment(3, 0);
      break;
  }

  $data = array();

  // data tama
  $data['header'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_header')->row_array();
  $data['alamat'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_alamat')->result_array();
  $data['kontak'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_kontak')->result_array();
  $data['account'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_account')->result_array();

  // data legal
  $data['akta'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_akta')->result_array();
  $data['izin'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_izin')->result_array();
  $data['sk'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_sk')->result_array();
  $data['sertifikat'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_sertifikat')->result_array();

  // data pajak
  $data['spt'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_spt')->result_array();

  // data keuangan
  $data['bank'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_bank')->result_array();
  $data['laporan'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_fin_rpt')->result_array();

  // document
  $data['dnb'] = $this->db->where('vendor_id', $vendor_id)->where('jenis', 'listVndDnB')->get('vnd_dnb')->result_array();

  $data['saham'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_saham')->result_array();
  $data['pengurus'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_board')->result_array();
  $data['personil'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_personil')->result_array();
  $data['exp_work'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_pengalaman')->result_array();
  $data['fasilitas'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_fasilitas')->result_array();
  $data['produk'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_product')->result_array();
  $data['bidang'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_bidang_usaha')->result_array();
  $data['company'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_company')->result_array();
  $data['anak_perusahaan'] = $this->db->select('vendor_id, vendor_name')->where('vendor_id', $vendor_id)->where('reg_status_id', 8)->get('vnd_header')->result_array();

  // data cqsms
  $data['cqsms'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_cqsms')->result_array();

  $data['education'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_education')->result_array();
  $data['training'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_training')->result_array();
  $data['comment_list'] = $this->Vendor_m->getVendorComment($vendor_id, '')->result_array();

  // anak perusahaan
  $data['anak_1'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Bangunan Gedung Tbk')->get('vnd_anak_perusahaan')->num_rows();
  $data['anak_2'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Rekayasa Konstruksi')->get('vnd_anak_perusahaan')->num_rows();
  $data['anak_3'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Realty')->get('vnd_anak_perusahaan')->num_rows();
  $data['anak_4'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Serang Panimbang')->get('vnd_anak_perusahaan')->num_rows();
  $data['anak_5'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT WIKA Tirta Jaya Jatiluhur')->get('vnd_anak_perusahaan')->num_rows();
  $data['anak_6'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Beton Tbk')->get('vnd_anak_perusahaan')->num_rows();
  $data['anak_7'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Industri Konstruksi')->get('vnd_anak_perusahaan')->num_rows();
  $data['anak_8'] = $this->db->where('vendor_id', $vendor_id)->where('nama_perusahaan', 'PT Wijaya Karya Bitumen')->get('vnd_anak_perusahaan')->num_rows();

  $data['adm_cot'] = $this->db->get('adm_cot_kelompok')->result_array();
  $data['vnd_push_performance'] = $this->db->where('vendorId', $vendor_id)->get('vnd_vpi_push_performance')->row_array();

  $curl_uom = curl_init();
  $curl_tod = curl_init();

  $data_uom = array();
  $data_tod = array();

  $no_uom = 0;
  $no_tod = 0;

  // uom
  // curl_setopt_array($curl_uom, array(
  //   CURLOPT_URL => 'https://e-catalogue.wika.co.id/api/uoms',
  //   CURLOPT_RETURNTRANSFER => true,
  //   CURLOPT_ENCODING => '',
  //   CURLOPT_MAXREDIRS => 10,
  //   CURLOPT_TIMEOUT => 0,
  //   CURLOPT_FOLLOWLOCATION => true,
  //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //   CURLOPT_CUSTOMREQUEST => 'GET'
  // ));

  // $response_uom = curl_exec($curl_uom);

  // curl_close($curl_uom);

  // $arrays_uom = json_decode($response_uom, true);

  // foreach ($arrays_uom["data"] as $key => $v) {
  //   $data_uom[$no_uom]['id'] = $v['id'];
  //   $data_uom[$no_uom]['name'] = $v['name'] . '(' . $v['description'] . ')';
  //   $no_uom++;
  // }

  // tod
  // curl_setopt_array($curl_tod, array(
  //   CURLOPT_URL => 'https://e-catalogue.wika.co.id/api/tod',
  //   CURLOPT_RETURNTRANSFER => true,
  //   CURLOPT_ENCODING => '',
  //   CURLOPT_MAXREDIRS => 10,
  //   CURLOPT_TIMEOUT => 0,
  //   CURLOPT_FOLLOWLOCATION => true,
  //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //   CURLOPT_CUSTOMREQUEST => 'GET'
  // ));

  // $response_tod = curl_exec($curl_tod);

  // curl_close($curl_tod);

  // $arrays_tod = json_decode($response_tod, true);

  // foreach ($arrays_tod["data"] as $key => $v) {
  //   $data_tod[$no_tod]['id'] = $v['id'];
  //   $data_tod[$no_tod]['name'] = $v['name'];
  //   $no_tod++;
  // }

  $data['level1'] = $this->db->get('vw_catalogue_level_1')->result_array();
  $data['get_uoms'] = '';
  $data['get_tod'] = '';

  $this->template($view, "Profil Vendor", $data);

?>