<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getVendorActive($id = ""){

			$this->db->where_in("status",array("5","9"));

		return $this->getVendor($id);

	}

	public function push_kode_nasabah($vendor_id) {

		$this->db->trans_begin();    

		$data = $this->db->where("vendor_id", $vendor_id)->get("vw_vnd_header")->row_array();

		$curl = curl_init();    

		$urln = "http://nasabah.wika.co.id/index.php/mod_excel/get_json_pmcs"; 

		$chn = curl_init($urln);        
		curl_setopt($chn, CURLOPT_MAXREDIRS, 10);    
		curl_setopt($chn, CURLOPT_TIMEOUT, 0);
		curl_setopt($chn, CURLOPT_ENCODING, ''); 
		curl_setopt($chn, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($chn, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($chn, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($chn, CURLOPT_SSL_VERIFYPEER, false); 
		curl_setopt($chn, CURLOPT_SSL_VERIFYHOST, false); 
		curl_setopt($chn, CURLOPT_CUSTOMREQUEST, 'GET'); 
		
		$response = curl_exec($chn);      
		
		$arrays_datan = json_decode($response, true);

		curl_close($chn);    

		$this->db->truncate('vnd_nasabah_online');

		$dataNasabah = [];
		$no = 0;
		foreach ($arrays_datan as $a => $vn) {
			$dataNasabah[$no]['jns'] = $vn['jns'];
			$dataNasabah[$no]['ns_id'] = $vn['id'];
			$dataNasabah[$no]['kdnasabah_temp'] = $vn['kdnasabah_temp'];
			$dataNasabah[$no]['nmnasabah'] = $vn['nmnasabah'];
			$dataNasabah[$no]['alamat'] = $vn['alamat'];
			$dataNasabah[$no]['npwp'] = preg_replace('/[^a-zA-Z0-9_ -]/s','', $vn['npwp']);
			$dataNasabah[$no]['alamat_npwp'] = $vn['alamat_npwp'];
			$dataNasabah[$no]['kota'] = $vn['kota'];
			$dataNasabah[$no]['kode_pos'] = $vn['kode_pos'];
			$dataNasabah[$no]['telepon'] = $vn['telepon'];
			$dataNasabah[$no]['fax'] = $vn['fax'];
			$dataNasabah[$no]['website'] = $vn['website'];
			$dataNasabah[$no]['email'] = $vn['email'];
			$dataNasabah[$no]['nama_kontak'] = $vn['nama_kontak'];
			$dataNasabah[$no]['jenis'] = $vn['jenis'];
			$dataNasabah[$no]['jabatan'] = $vn['jabatan'];
			$dataNasabah[$no]['handphone'] = $vn['handphone'];
			$dataNasabah[$no]['tipe'] = $vn['tipe'];
			$dataNasabah[$no]['keterangan'] = $vn['keterangan'];
			$dataNasabah[$no]['kelompok'] = $vn['kelompok'];
			$dataNasabah[$no]['kol1'] = $vn['kol1'];
			$dataNasabah[$no]['kol2'] = $vn['kol2'];
			$dataNasabah[$no]['cotid'] = $vn['cotid'];
			$dataNasabah[$no]['kdnasabah'] = $vn['kdnasabah'];
			$dataNasabah[$no]['kdbp_sap'] = $vn['kdbp_sap'];
			$dataNasabah[$no]['sync_date'] = date('Y-m-d h:i:s');
			$no++;                
		}

		if (count($dataNasabah) > 0) {
			$nasabahresult = $this->db->insert_batch('vnd_nasabah_online', $dataNasabah);
		}

		if ($this->db->trans_status() == FALSE) {

			$this->db->trans_rollback();		
			return 'fail';

		} else {
		
			$this->db->trans_commit();	
			
			$npwp_nasabah = preg_replace('/[^a-zA-Z0-9_ -]/s','', $data['npwp_no']);

			$rowNasabah = $this->db->where("npwp", str_replace("-", "", $npwp_nasabah))->get("vnd_nasabah_online")->row_array();

			$data_update = array(
				'nasabah_code' => $rowNasabah['kdnasabah_temp'],
				'code_bp' => $rowNasabah['kdbp_sap']
			);

			$this->db->where('vendor_id', $vendor_id);
			$this->db->update('vnd_header', $data_update);

			$headers = array(
				'Cache-Control: no-cache',
				'Content-Type: multipart/form-data',
				'content-type: multipart/form-data; boundary=----WebKitFormBoundary7MA4YWxkTrZu0gW'
			);

			$url = NASABAH_URL;

			$vendordoc = $this->getDocWs($data['vendor_id']);
			$vendorbank = $this->getBankWs($data['vendor_id']);
			$direktur = $this->getBoardWs($data['vendor_id']);

			$posData = [
				//important
				'jenisperusahaan' => $data["prefix"],
				'nmnasabah' => $data["vendor_name"],
				'alamat' => $data["address_street"],
				'nama_direktur' => $data["contact_name"],
				'tipe' => "Vendor",
				'npwp' => $data["npwp_no"],
				'kota' => $data["npwp_city"],
				'kode_pos' => $data["npwp_postcode"],
				'propinsi' => $data["npwp_prop"],
				'telepon' => $data["address_phone_no"],
				'tempat_perusahaan' => $data["address_street"],
				'tanggal_perusahaan' => $data["address_domisili_date"],
				'nama_kontak' => $data["contact_name"],
				'tipe_perusahaan' => "Swasta",
				'jenis' => $data['cot_jenis_name'],
				'jabatan' => $data["contact_pos"],
				'pkp' => $data["npwp_pkp"],
				'telpon1' => $data["address_phone_no"],
				'handphone' => $data["address_phone_no"],
				'kelompok' => $data['cot_kelompok_name'],
				'jenis_kantor' => "Pusat",
				'siupp' => $data["siup_no"],
				'cotid' => $data["vnd_cot"],

				//not important
				'keterangan' => NULL,
				'is_pkp' => $data["npwp_pkp"],
				'alamat_npwp' => $data["npwp_address"],
				'ext' => NULL,
				'fax' => NULL,
				'website' => $data["address_website"],
				'email' => $data["email_address"],
				'kualifikasi_vendor' => NULL,
				'sertifikat' => NULL,
				'nama_kontak2' => NULL,
				'jabatan2' => NULL,
				'jenis_nasabah' => $data['jenis_nasabah'],
				'skt' => $data["npwp_pkp_no"],
				'email1' => $data["email_address"],
				'email2' => NULL,
				'fax_cp1' => NULL,
				'fax_cp2' => NULL,
				'telpon2' => NULL,
				'handphone2' => NULL,
				'tipe_lain_perusahaan' => NULL,
				'tipe_faktur' => NULL,
				'nama_bank' => $vendorbank['bank'],
				'cabang' => NULL,
				'nomor_rekening' => $vendorbank['rek'],
				'atas_nama' => $vendorbank['nama'],
				'is_app' => "t",
				'id_user' => NULL,
				'file_npwp' => $vendordoc['npwpdoc'],
				'file_sppkp' => $vendordoc['pkpdoc'],
				'file_lain' => NULL
			];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_POST, count($posData));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $posData);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);

			$result = curl_exec($ch);

			$arrays_data = json_decode($result, true);

			if (count($arrays_data["status"]) < 1){
				return 'not_found';
				
			} else {
				if ($arrays_data["status"] == "success"){							
					return 'success';
		
				} else {
					return 'fail';
				}
			}		

			return $result;
			curl_close($ch);
		
		}

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
			}

			if (!isset($nama) || !isset($bank) || !isset($rek)) {
				$nama = $databank['listVndBank'][$i]['accountName'];
				$bank = $databank['listVndBank'][$i]['bankName'];
				$rek = $databank['listVndBank'][$i]['accountNo'];
			}
		}

		$banks = [
			'nama' => isset($nama) ? $nama : NULL,
			'bank' => isset($bank) ? $bank : NULL,
			'rek' => isset($rek) ? $rek : NULL
		];

		return $banks;
	}

	public function getDocWs($vendor_id = ''){

		$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
		$url_doc = "https://verifikasi.pengadaan.com/pengadaanvendor/Download/";

		$dokumen = json_decode(file_get_contents($url_ws."/vndsuppdoc.json?token=123456&vendorId=".$vendor_id."&act=1"), true);

		if(!empty($dokumen)){
			$dokumen = array_reverse($dokumen["listVndSuppDoc"]);
		}

		$cou = count($dokumen);

		for ($i=0; $i < $cou ; $i++) {
			$npwpcek = strpos(strtolower($dokumen[$i]['vndSuppdocDesc']), "npwp");
			$npwpcek1 = strpos(strtolower($dokumen[$i]['vndSuppdocDesc']), "perusahaan");

			$pkpcek = strpos(strtolower($dokumen[$i]['vndSuppdocDesc']), "pkp");
			if ($pkpcek !== FALSE) {
				$pkp = $url_doc.$dokumen[$i]['vndSuppdocFilename'];
			}
			if ($npwpcek !== FALSE && $npwpcek1 !== FALSE) {
				$npwp = $url_doc.$dokumen[$i]['vndSuppdocFilename'];
			}
			if (!isset($npwp)) {
				if ($npwpcek !== FALSE){
					$npwp = $url_doc.$dokumen[$i]['vndSuppdocFilename'];
				}
			}
		}

		$doc['pkpdoc'] = isset($pkp) ? $pkp : NULL;
		$doc['npwpdoc'] = isset($npwp) ? $npwp : NULL;

		return $doc;
	}

	public function getBoardWs($vendor_id = ''){

		$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
		$boards = json_decode(file_get_contents($url_ws."/vndboard.json?token=123456&vendorId=".$vendor_id."&act=1"), true);

		$cou = count($boards['listVndBoard']);

		for ($i=0; $i < $cou; $i++) {

			$pos = $boards['listVndBoard'][$i]['pos'];

			if ($pos == "DIREKTUR UTAMA") {
				$board = $boards['listVndBoard'][$i];
				break;
			}else if ($pos == "PRESIDEN DIREKTUR") {
				$board = $boards['listVndBoard'][$i];
				break;
			}else if ($pos == "DIREKTUR"){
				$board = $boards['listVndBoard'][$i];
				break;
			}else{
				$board = NULL;
			}
		}

		return $board;
	}

	public function getVendorComment($code = "",$id = ""){

		$this->db->select("vnd_comment_id as comment_id,
		vendor_id,
		vc_start_date as comment_date,
		vc_end_date as comment_end_date,
		vc_name as comment_name,
		vc_response as response,
		vc_comment as comments,
		vc_activity_code as activity,
		(SELECT pos_name FROM vw_pos WHERE (pos_id)::text = (vc_position)::text) as position,
		vc_end_date as end_date,
		vc_active as active,
		vc_attachment as attachment,
		vc_activity as activity_name");

		if(!empty($code)){

			$this->db->where("vendor_id = '".$code."'");

		}

		if(!empty($id)){

			$this->db->where("vnd_comment_id",$id);

		}

		$this->db->order_by("vnd_comment_id","desc");

		return $this->db->get("vnd_comment");

	}

	public function getDaftarPekerjaanVerifikasiDocPQ($id=""){
		if (!empty($id)) {
			$this->db->where('vdp_id', $id);
		}

		$this->db->where('vdp_status', "1");

		return $this->db->get('vw_daftar_pekerjaan_doc_pq');
	}

	public function getVndType(){
		$this->db->select('vnd_type_master.*');
		//$this->db->group_by('vnd_type_master.vtm_id');
		$this->db->join('adm_vnd_doc', 'adm_vnd_doc.vtm_id = vnd_type_master.vtm_id', 'right');
		return $this->db->get('vnd_type_master');
	}

	public function insertVndDocPq($data){

		$this->db->insert('vnd_doc_pq',$data);
		return $this->db->insert_id();
		// return $this->db->affected_rows();
	}

	public function getDocPq($id="", $template_id=""){
		if (!empty($id)) {
			$this->db->where('vdp_id', $id);
		}
		if (!empty($template_id)) {
			$this->db->where('avd_id', $template_id);
		}

		return $this->db->get('vnd_doc_pq');
	}

	public function getDocPqDetail($id="",$vendor_id="", $status=""){

		$this->db->select('vtm_name, avd_name, adm_vnd_doc_detail.vdd_name,vendor_id,vnd_doc_pq.vtm_id,vnd_doc_pq.vdp_she_main,vnd_doc_pq_detail.*');

		if (!empty($id)) {
			$this->db->where('vnd_doc_pq_detail.vdp_id', $id);
		}
		if (!empty($vendor_id)) {
			$this->db->where('vendor_id', $vendor_id);
		}
		if (!empty($status)) {
			$this->db->where('vdp_status', $status);
		}


		$this->db->join('vnd_doc_pq', 'vnd_doc_pq.vdp_id = vnd_doc_pq_detail.vdp_id', 'left');
		$this->db->join('vnd_type_master', 'vnd_type_master.vtm_id = vnd_doc_pq.vtm_id', 'left');
		$this->db->join('adm_vnd_doc_detail', 'adm_vnd_doc_detail.vdd_id = vnd_doc_pq_detail.vdd_id', 'left');
		$this->db->join('adm_vnd_doc', 'adm_vnd_doc_detail.avd_id = adm_vnd_doc.avd_id', 'left');
		$this->db->where('is_active', 1);
		$this->db->order_by('adm_vnd_doc_detail.vdd_id', 'asc');
		return $this->db->get('vnd_doc_pq_detail');
	}

	public function updateDocPqDetail($id="",$data=""){
	return $this->db->update('vnd_doc_pq_detail', $data, ['vdpd_id'=>$id]);
	}


	public function updatePqHeader($id, $data){

		$this->db->where('vdp_id', $id);
		return $this->db->update('vnd_doc_pq', $data);
	}

	public function getTemplateDocPq($id="", $vtm_id=""){

		if (!empty($id)) {
			$this->db->where('avd_id', $id);
		}

		if (!empty($vtm_id)) {
			$this->db->where('vtm_id', $vtm_id);
		}

		return $this->db->get('adm_vnd_doc');
	}

	public function getVendor($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_vnd_header");

	}

	public function getVendor_v2($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_vnd_header_v2");

	}

	public function getAllVendor($code = ""){

		$this->db->select("vendor_id, address_street, vendor_name, COALESCE(vnd_reg_status.reg_status_name, 'Inactive'::character varying) AS reg_status_name, contact_name, customer_code, email_address, nasabah_code, reg_status_name, vnd_jenis");

		$this->db->join('vnd_reg_status', 'vnd_reg_status.reg_status_code = vnd_header.status', 'left');

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vnd_header");

	}

	public function getMandor($code = ""){

		if(!empty($code)){

			$this->db->where("vmh_id",$code);

		}

		return $this->db->get("vnd_mandor_header");

	}

	public function getMandorDetail($code = "", $table=""){

		if(!empty($code)){

			$this->db->where("vmh_id",$code);

		}

		return $this->db->get($table);

	}

	public function getVendorKpi($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_vnd_kpi");

	}

	public function getVendorStatus($code = ""){
		return $this->db->get("vw_laporan_vendor_status");

	}
	//start code hlmifzi
	public function getVendorCommodity($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vnd_suspend_commodity_vendor");

	}
	//end

	public function getBidderList($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_vnd_bidder_list");

	}

	public function getVendorList($code = ""){

		$this->db->distinct('vendor_id');
		$this->db->select('vendor_id, vendor_name, fin_class, vnd_jenis');
		$this->db->where("reg_isactivate", "1");
		
		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}
		$this->db->order_by("vendor_id", "asc");
		return $this->db->get("vnd_header");

	}

	public function getDaftarPekerjaan($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_daftar_pekerjaan_vendor");

	}

	public function getDaftarPekerjaanBlacklist($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_daftar_pekerjaan_blacklist_vendor");

	}

	public function getDaftarSuspend($id = ""){

		if(!empty($id)){

			$this->db->where("vendor_id ='".$id."'");

		}

		return $this->db->get("vnd_comment");

	}

	public function getAktivasiSuspend($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_aktivasi_suspend_vendor");

	}

	public function getUnsuspendVendor($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_unsuspend_vendor");

	}

	public function getBlacklistVendor($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_blacklist_vendor");

	}

	public function updateVendor($id = "", $data = array()){
		if(!empty($id)){
			$this->db->where("vendor_id", $id);
			if (!empty($data)) {
				return $this->db->update("vnd_header", $data);
			}
		}
	}

	//vpi lama

	public function getDataPenilaianMutu($id="",$contract_id=""){

		if (!empty($id)) {
			$this->db->where('vpm_id', $id);
		}else if (!empty($contract_id)) {
			$this->db->where('vpm_contract_id', $contract_id);
		}

		return $this->db->get('vnd_vpi_hasil_mutu_pekerjaan');

	}

		public function insertDataPenilaianMutu($data=array()){

		$this->db->insert('vnd_vpi_hasil_mutu_pekerjaan', $data);

		return $this->db->insert_id();

	}

	public function UpdateDataPenilaianMutu($data=array(), $where=array()){


		$this->db->update('vnd_vpi_hasil_mutu_pekerjaan', $data, $where);

		return $this->db->affected_rows();

	}

//

	public function getDataPenilaianKetepatanProgress($id="",$contract_id=""){

		if (!empty($id)) {
			$this->db->where('vpkp_id', $id);
		}else if (!empty($contract_id)) {
			$this->db->where('vpkp_contract_id', $contract_id);
		}

		return $this->db->get('vnd_penilaian_ketepatan_progress');

	}

		public function insertDataPenilaianKetepatanProgress($data=array()){

		$this->db->insert('vnd_penilaian_ketepatan_progress', $data);

		return $this->db->insert_id();

	}

	public function UpdateDataPenilaianKetepatanProgress($data=array(), $where=array()){


		$this->db->update('vnd_penilaian_ketepatan_progress', $data, $where);

		return $this->db->affected_rows();

	}

	public function getVndKompilasiVPI($contract_id=""){

		if (!empty($contract_id)) {
			$this->db->where('vkv_contract_id', $contract_id);
		}

		return $this->db->get('vnd_kompilasi_vpi');

	}

	public function InsertVndKompilasiVPI($data){

		$this->db->insert('vnd_kompilasi_vpi', $data);

		return $this->db->affected_rows();

	}

	public function InsertVndKompilasiVPIScore($data){

		$this->db->insert('vnd_kompilasi_vpi_score', $data);

		return $this->db->affected_rows();

	}

	public function getDataKompilasiVPI($contract_id=""){

		if (!empty($contract_id)) {
			$this->db->where('contract_id', $contract_id);
		}

		return $this->db->get('vw_kompilasi_vpi');

	}

	public function getDataDetailKompilasiVPI($contract_id=""){

		if (!empty($contract_id)) {
			$this->db->where('vkv_contract_id', $contract_id);
		}

		$this->db->join('vnd_kompilasi_vpi_score b', 'b.vkv_id = a.vkv_id');
		return $this->db->get('vnd_kompilasi_vpi a');

	}

	public function getVendorAward($vendor_id=""){
		if (!empty($vendor_id)) {
			$this->db->where('vendor_id', $vendor_id);
		}

		return $this->db->get('vw_vnd_award');
	}

	public function getVendorNote()
	{
		return $this->db->get('vnd_vpi_note')->result();
	}

	//vpi baru
	//vpi header
	public function insertVPIHeader($data=array()){

		$this->db->insert('vnd_vpi_header', $data);

		return $this->db->insert_id();

	}

	public function UpdateVPIHeader($data=array(), $where=array()){


		$this->db->update('vnd_vpi_header', $data, $where);

		return $this->db->affected_rows();

	}

	public function getVPIHeader($vnd_id="",$vvh_id="",$where=""){

		if (!empty($vnd_id)) {
			$this->db->where('vvh_vendor_id', $vnd_id);
		}
		if (!empty($vvh_id)) {
			$this->db->where('vvh_id', $vvh_id);
		}
		if (!empty($where)) {
			$this->db->where($where);
		}

		return $this->db->get('vnd_vpi_header');

	}

	//k3l5r

	public function insertVPIK3l5r($data=array()){

		$this->db->insert('vnd_vpi_k3l_5r_header', $data);

		return $this->db->insert_id();

	}

	public function UpdateVPIK3l5r($data=array(), $where=array()){


		$this->db->update('vnd_vpi_k3l_5r_header', $data, $where);

		return $this->db->affected_rows();

	}

	public function getVPIK3l5r($vvh_id="",$where=""){

		if (!empty($vvh_id)) {
			$this->db->where('vvh_id', $vvh_id);
		}
		if (!empty($where)) {
			$this->db->where($where);
		}

		return $this->db->get('vnd_vpi_k3l_5r_header');

	}

	public function insertVPIK3l5rScore($data=array()){

		$this->db->insert_batch('vnd_vpi_k3l_5r_score', $data);

		return $this->db->affected_rows();

	}

	public function UpdateVPIK3l5rScore($data=array()){

		$this->db->update_batch('vnd_vpi_k3l_5r_score', $data, 'vvks_id');

		return $this->db->affected_rows();

	}

	public function getVPIK3l5rScore($vvh_id="",$where=""){

		if (!empty($vvh_id)) {
			$this->db->where('vvh_id', $vvh_id);
		}
		if (!empty($where)) {
			$this->db->where($where);
		}

		return $this->db->get('vnd_vpi_k3l_5r_score');

	}

	//vpi pengamanan

	public function insertVPIPengamanan($data=array()){

		$this->db->insert('vnd_vpi_pengamanan', $data);

		return $this->db->insert_id();

	}

	public function UpdateVPIPengamanan($data=array(), $where=array()){


		$this->db->update('vnd_vpi_pengamanan', $data, $where);

		return $this->db->affected_rows();

	}

	public function getVPIPengamanan($vvh_id="",$where=""){

		if (!empty($vvh_id)) {
			$this->db->where('vvh_id', $vvh_id);
		}
		if (!empty($where)) {
			$this->db->where($where);
		}

		return $this->db->get('vnd_vpi_pengamanan');

	}

	public function insertVPIPengamananScore($data=array()){

		$this->db->insert_batch('vnd_vpi_pengamanan_score', $data);

		return $this->db->affected_rows();

	}

	public function UpdateVPIPengamananScore($data=array()){

		$this->db->update_batch('vnd_vpi_pengamanan_score', $data, 'vvps_id');

		return $this->db->affected_rows();

	}

	public function getVPIPengamananScore($vvh_id="",$where=""){

		if (!empty($vvh_id)) {
			$this->db->where('vvh_id', $vvh_id);
		}
		if (!empty($where)) {
			$this->db->where($where);
		}

		return $this->db->get('vnd_vpi_pengamanan_score');

	}

	//kompilasi vpi

	public function getVPIKompilasi($vvh_id=""){
		if (!empty($vvh_id)) {
			$this->db->where('vvh_id', $vvh_id);
		}

		return $this->db->get('vnd_vpi_kompilasi');
	}

	public function insertVPIKompilasi($data){

		$this->db->insert('vnd_vpi_kompilasi', $data);

		return $this->db->insert_id();
	}

	public function UpdateVPIKompilasi($data=array(), $where=array()){

		$this->db->update('vnd_vpi_kompilasi', $data, $where);

		return $this->db->affected_rows();

	}

	public function insertVPIKompilasiScore($data=array()){

		$this->db->insert_batch('vnd_vpi_kompilasi_score', $data);

		return $this->db->affected_rows();

	}

	public function UpdateVPIKompilasiScore($data=array()){

		$this->db->update_batch('vnd_vpi_kompilasi_score', $data, 'vks_id');

		return $this->db->affected_rows();

	}

	public function getVPIKompilasiScore($vvh_id="",$where=""){

		if (!empty($vvh_id)) {
			$this->db->where('vvh_id', $vvh_id);
		}
		if (!empty($where)) {
			$this->db->where($where);
		}

		return $this->db->get('vnd_vpi_kompilasi_score');

	}

	//vpi pelayanan

	public function insertVPIPelayanan($data=array()){

		$this->db->insert('vnd_vpi_pelayanan', $data);

		return $this->db->insert_id();

	}

	public function UpdateVPIPelayanan($data=array(), $where=array()){


		$this->db->update('vnd_vpi_pelayanan', $data, $where);

		return $this->db->affected_rows();

	}

	public function insertVPIPelayananScore($data=array()){

		$this->db->insert_batch('vnd_vpi_pelayanan_score', $data);

		return $this->db->affected_rows();

	}

	public function UpdateVPIPelayananScore($data=array()){

		$this->db->update_batch('vnd_vpi_pelayanan_score', $data, 'vppa_id');

		return $this->db->affected_rows();

	}

	public function getVPIPelayanan($id="",$contract_id=""){

		if (!empty($id)) {
			$this->db->where('vpp_id', $id);
		}else if (!empty($contract_id)) {
			$this->db->where('vpp_contract_id', $contract_id);
		}

		return $this->db->get('vnd_vpi_pelayanan');

	}

	public function getVPIPelayananScore($vvh_id="",$where=""){

		if (!empty($vvh_id)) {
			$this->db->where('vvh_id', $vvh_id);
		}
		if (!empty($where)) {
			$this->db->where($where);
		}

		return $this->db->get('vnd_vpi_pelayanan_score');

	}

	public function getPersetujuanSurvei()
	{
		return $this->db->select("CASE vc_active
									WHEN 3 THEN
										'Rekomendasi Survei'
									ELSE
										'Rekomendasi Tidak Survei'
									END as rekomendasi,vc.*,vh.*")
						->from("vnd_comment vc")
						->join("vw_vnd_header vh", "vh.vendor_id=vc.vendor_id")
						->where_in("vc_active", array(4, 3))
						->get();
	}

	public function getAnotherDoc($vendor_id = ""){
		if(!empty($vendor_id)){
			$this->db->where("vendor_id", $vendor_id);
		}
		return $this->db->get("vnd_docs");
	}

	public function insertVndDoc($data = []){

		$this->db->insert('adm_vnd_doc', $data);

		return $this->db->insert_id();
	}

	public function getVndDoc($id = ""){

		if(!empty($id)){
			$this->db->where("avd_id", $id);
		}
		$this->db->join('vnd_type_master vtm', 'vtm.vtm_id = adm_vnd_doc.vtm_id', 'left');
		return $this->db->get("adm_vnd_doc");
	}

	public function updateVndDoc($id = "",$data){

		if (!empty($id)) {
			$this->db->where('avd_id', $id);
		}
		return $this->db->update('adm_vnd_doc', $data);
	}

	public function insertVndDocDetail($data){

		$this->db->insert('adm_vnd_doc_detail', $data);

		 $this->db->select('max(vdd_id)+1 as last_vdd_id');
		 return $this->getVndDocDetail()->row()->last_vdd_id;
	}

	public function getVndDocDetail($id = "", $avd = ""){

		if(!empty($id)){
			$this->db->where("vdd_id", $id);
		}
		if(!empty($avd)){
			$this->db->where("avd_id", $avd);
		}
		$this->db->where('vdd_status', 1);
		return $this->db->get("adm_vnd_doc_detail");
	}

	public function updateVndDocDetail($id = "" ,$data = []){

		return $this->db->where('vdd_id', $id)->update('adm_vnd_doc_detail', $data);
	}

	public function replaceVndDocDetail($id, $input){

		if(!empty($id) && !empty($input)){
			$vdd_id = isset($input['vdd_id']) ? $input['vdd_id'] : "";
			$check = $this->getVndDocDetail($vdd_id)->row_array();

			if(!empty($check) AND !empty($vdd_id)){
				$last_id = $check['vdd_id'];
				$this->updateVndDocDetail($last_id,$input);
			} else {
				$this->insertVndDocDetail($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;
		}else{
			return 0;
		}
	}

	public function deleteIfNotExistVndDocDetail($id,$new_data){
		$this->db->where_not_in("vdd_id",$new_data)->where("avd_id",$id)->update("adm_vnd_doc_detail",array("vdd_status"=>0));
		return $this->db->affected_rows();
	}

	public function getMasterVndType($id=""){
		if (!empty($id)) {
			$this->db->where('vtm_id', $id);
		}

		return $this->db->get('vnd_type_master');
	}

	public function get_vsi_summary($periode,$year) {
		$q = $this->db->query("SELECT vsi_report_sum(".$periode.",'".$year."')");
		$res = $q->row_array();

		$ret = str_replace('(','',$res['vsi_report_sum']);
		$ret = str_replace(')','',$ret);
		$ret = explode(',',$ret);

		$result['questionaire'] = $ret[0];
		$result['responden'] = $ret[1];
		$result['score_less_60'] = $ret[2];
		$result['score_more_60'] = $ret[3];

		return $result;
	}

	public function get_pertanyaan_label($type,$periode,$year)
	{
		$data = array();
		$this->db->select('pertanyaan_name');
		$this->db->where('pertanyaan_type_id', $type);
		$this->db->where('periode', $periode);
		$res = $this->db->get('vw_vsi_header_detail')->result_array();

		if(count($res) > 0) {
			foreach ($res as $key => $value) {
				# code...
				$data[$key] = $value['pertanyaan_name'];

			}
		}

		return json_encode($data);
	}

	private function random_color_part() {
		return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
	}

	private function random_color() {
		return $this->random_color_part() . $this->random_color_part() . $this->random_color_part();
	}

	public function get_satisfacation_map($periode,$year)
	{
		$q = "SELECT X.*,((X.sum_kepuasan::numeric / X.sum_kepentingan::numeric) * 100) as index_kinerja from (".
			 " SELECT  p.pertanyaan_name as pertanyaan,".
			 " (SELECT sum(answer_score) from vw_vsi_vendor_input where vsi_type = 1 and periode = ".$periode." and year = '".$year."' and pertanyaan = p.pertanyaan_name) as sum_kepuasan,".
			 " (SELECT sum(answer_score) from vw_vsi_vendor_input where vsi_type = 2 and periode = ".$periode." and year = '".$year."' and pertanyaan = p.pertanyaan_name) as sum_kepentingan,".
			 " (SELECT avg(answer_score) from vw_vsi_vendor_input where vsi_type = 1 and periode = ".$periode." and year = '".$year."' and pertanyaan = p.pertanyaan_name) as avg_x_kepuasan,".
			 " (SELECT avg(answer_score) from vw_vsi_vendor_input where vsi_type = 2 and periode = ".$periode." and year = '".$year."' and pertanyaan = p.pertanyaan_name) as avg_y_kepentingan".
			" FROM (SELECT P.pertanyaan_name from vw_vsi_header_detail P where p.periode = ".$periode." and P.YEAR = '".$year."' GROUP BY P.pertanyaan_name) as p ) as X ";

		$res = $this->db->query($q)->result_array();

		return $res;

	}

	public function get_asset_line_chart($vsiType,$periode,$year)
	{
		$data = array();
		$this->db->select('vendor_id');
		$this->db->select('vendor_name');


		$this->db->where('periode', $periode);
		$this->db->where('year', $year);
		$this->db->where('vsi_type', $vsiType);

		$this->db->group_by(array("vendor_id","vendor_name"));
		$vendor = $this->db->get('vw_vsi_vendor_input')->result_array();

		if(count($vendor) > 0) {

			foreach ($vendor as $key => $value) {
				# code...
				$data[$key]['label'] = $value['vendor_name'];
				$data[$key]['data'] = $this->get_datachart_vendor_answer_score($value['vendor_id'],$vsiType,$periode,$year);
				$data[$key]['lineTension'] = 0;
				$data[$key]['fill'] = 0;
				$data[$key]['borderColor'] = "#".$this->random_color();
				$data[$key]['pointBorderColor'] = "#".$this->random_color();
				$data[$key]['pointBackgroundColor'] = "#FFF";
				$data[$key]['pointBorderWidth'] = 2;
				$data[$key]['pointHoverBorderWidth'] = 2;
				$data[$key]['pointRadius'] = 4;

			}
		}

		return json_encode($data);

	}

	public function get_dataset_scatter_chart($periode,$year)
	{
		$data = array();
		$xy = array();

		$map = $this->get_satisfacation_map($periode,$year);

		foreach ($map as $key => $value) {
				$xy[$key] = [
					"x"=> $value['avg_x_kepuasan'],
					"y"=> $value['avg_y_kepentingan']
				];
		}

		$data[0]['label'] = "Pertanyaan";
		$data[0]['data'] =$xy;
		$data[0]['backgroundColor'] = "#".$this->random_color(); //"rgba(47, 139, 230, 0.6)";
		$data[0]['borderColor'] = "transparent";
		$data[0]['pointBorderColor'] = "#".$this->random_color();
		$data[0]['pointBackgroundColor'] = "#FFF";
		$data[0]['pointBorderWidth'] = 2;
		$data[0]['pointHoverBorderWidth'] = 2;
		$data[0]['pointRadius'] = 4;

		return json_encode($data);
	}

	public function get_vsi_vendor_score($periode,$year)
	{
		# code...
		$q = $this->db->query("SELECT vsi_report_score_vendor(".$periode.",'".$year."')");
		$res = $q->row_array()["vsi_report_score_vendor"];

		return json_decode($res);

	}

}
