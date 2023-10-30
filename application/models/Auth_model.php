<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}	

	public function getAllData($table)
    {
        return $this->db->get($table);
    }

    public function getAllDataLimited($table, $limit, $offset)
    {
        return $this->db->get($table, $limit, $offset);
    }

    public function getSelectedDataLimited($table, $data, $limit, $offset)
    {
        return $this->db->get_where($table, $data, $limit, $offset);
    }

    //select table
    public function getSelectedData($table, $data)
    {
        return $this->db->get_where($table, $data);
    }
	public function MaxWoNo()
    {
        $year = date("Y");
        $bulan = date("m");
        $text = "SELECT max(wo_number) AS no FROM ctr_wo_header WHERE wo_number LIKE 'WO.ECATALOG.%'";
        $data = $this->auth_model->manualQuery($text);
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $t) {
                $no = $t->no;
                $tmp = ((int)substr($no, -5)) + 1;
                $hasil = 'WO.ECATALOG.'.$year.''.$bulan.'.' . sprintf("%05s", $tmp);
            }
        } else {
            $hasil = 'WO.ECATALOG.'.$year.''.$bulan.'.00001';
        }
        return $hasil;
    }
    
    public function MaxPoNo()
    {
        $year = date("Y");
        $bulan = date("m");
        $text = "SELECT max(po_number) AS no FROM ctr_po_header WHERE po_number LIKE 'PO.%'";
        $data = $this->auth_model->manualQuery($text);
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $t) {
                $no = $t->no;
                $tmp = ((int)substr($no, -5)) + 1;
                $hasil = 'PO.'.$year.''.$bulan.'.' . sprintf("%05s", $tmp);
            }
        } else {
            $hasil = 'PO.'.$year.''.$bulan.'.00001';
        }
        return $hasil;
	}
	
	public function MaxSppmNo()
    {
        $year = date("Y");
        $bulan = date("m");
        $text = "SELECT max(sppm_number) AS no FROM ctr_sppm_header WHERE sppm_number LIKE 'SPPM.ECATALOG.%'";
        $data = $this->auth_model->manualQuery($text);
        if ($data->num_rows() > 0) {
            foreach ($data->result() as $t) {
                $no = $t->no;
                $tmp = ((int)substr($no, -5)) + 1;
                $hasil = 'SPPM.ECATALOG.'.$year.''.$bulan.'.' . sprintf("%05s", $tmp);
            }
        } else {
            $hasil = 'SPPM.ECATALOG.'.$year.''.$bulan.'.00001';
        }
        return $hasil;
    }
	//select table
  
	//update table
    function updateData($table, $data, $field_key)
    {
        return $this->db->update($table, $data, $field_key);
    }

    function deleteData($table, $data)
    {
        return $this->db->delete($table, $data);
    }

    function insertData($table, $data)
    {
        $this->db->insert($table, $data);
        //print_r($this->db->last_query());die;
        return $this->db->insert_id($table, $data);
    }

    //Query manual
    function manualQuery($q)
    {
        return $this->db->query($q);
    }
	


public function push_umkm($id,$type){

    $headers = array(
        "Content-Type: application/json",
        "cache-control: no-cache"
    );
        //echo $id;die;
    $url = 'https://api.thebigbox.id/padi-umkm/1.0.0/padis';
	//$url = 'https://xx.com';

    if ($type == 'vendor') {
		
		if (!empty($id)) {
			$idParams = "aa.vendor_id=".$id;
		}else{
			$idParams = "CAST(aa.vendor_id as text) like '%'";
		}
		
		$this->db->select("
			distinct(aa.vendor_id) as vendor_id,
			aa.vendor_name,
			aa.address_street,
			aa.npwp_city as address_city,
			aa.npwp_prop as address_prop,
			aa.address_postcode,
			aa.address_phone_no,
			aa.contact_phone_no,
			REPLACE(REPLACE(aa.npwp_no, '.', ''),'-','') as npwp_no,
			aa.email_address,
			aa.siup_type,
			bb.bank_name,
			bb.account_no,
			bb.account_name,
			substring(bb.currency,1,2) as country");
		$this->db->where($idParams);
		$where = "aa.siup_type in ('Kecil','Menengah')";
		$this->db->where($where);
		$this->db->join("vnd_bank bb","aa.vendor_id = bb.vendor_id");
		$this->db->limit(10);
        $data = $this->db->get('vnd_header aa')->result_array();
		//echo $this->db->last_query();die;
		// if(!$data){
			// echo $this->db->_error_message();
		// }
		
		foreach($data as $a => $value){
			$send_data = array(
				"umkm" => 
							array(
								"uid" => 'WIKA-'.$value['vendor_id'],
								"nama_umkm" => $value['vendor_name'],
								"alamat" => $value['address_street'],
								"blok_no_kav" => '',//$data['group_code'],
								"kode_pos" => $value['address_postcode'],
								"kota" => $value['address_city'],
								"provinsi" => $value['address_prop'],
								"no_telp" => $value['address_phone_no'],
								"hp" => $value['contact_phone_no'],
								"email" => $value['email_address'],
								"kategori_usaha" => $value['siup_type'],
								"jenis_kegiatan_usaha" => '',//$data['group_code'],
								"npwp" => $value['npwp_no'],
								"nama_bank" => $value['bank_name'],
								"country_bank" => $value['country'],
								"no_rekening" => $value['account_no'],
								"nama_pemilik_rekening" => $value['account_name'],
								"longitute" => '',//$data['group_code'],
								"latitute" => '',//$data['group_code'],
								"total_project" => '',//$data['group_code'],
								"total_revenue" => '',//$data['group_code'],
								"ontime_rate" => '85%',//$data['group_code'],
								"average_rating" => '80%'//$data['group_code']
							),
			);
			
		}

    }elseif ($type == 'transaksi') {
        $this->db->select("
			distinct(dd.ptm_number),
			case
				when bb.siup_type = 'Menengah' then '3'
				when bb.siup_type = 'Kecil' then '3'
			else ''
			end as kategori_umkm,
			aa.vendor_name,
			aa.created_date as terbuat_kontrak,
			aa.start_date as tgl_mulai_kontrak,
			aa.end_date as tgl_akhir_kontrak,
			aa.contract_amount as nilai_kontrak,
			cc.ptm_project_name as project,
			cc.ptm_packet as deskripsi_pekerjaan,
			case
				when dd.tit_code like 'EB%' then '4'
				when dd.tit_code like 'E%' then '3'
				when dd.tit_code like 'A%' then '1'
				when dd.tit_code like 'B%' then '1'
			else ''
			end as jenis_kegiatan");
        $this->db->where('aa.status', '1901');
		$this->db->where('aa.ptm_number', $id);
		$this->db->join('vnd_header bb on bb.vendor_id = aa.vendor_id');
		$this->db->join('prc_tender_main cc on cc.ptm_number = aa.ptm_number');
		$this->db->join('prc_tender_item dd on dd.ptm_number = cc.ptm_number');
        $data = $this->db->get('ctr_contract_header aa')->row_array();

        $send_data = array(
            "transaksi" =>  
                            array(
                                "tanggal_transaksi" => $data['tgl_mulai_kontrak'],
                                "transaksi_id" => "",
                                "bumn_id" => "",
                                "nama_project" => $data['deskripsi_pekerjaan'],
                                "kategori_project" => $data['jenis_kegiatan'],
                                "total_nilai_project" => $data['nilai_kontrak'],
                                "tipe_nilai_project" => "CAPEX",
                                "kategori_umkm" => $data['kategori_umkm'],
                                "uid_umkm" => "",
                                "nama_umkm" => $data['vendor_name'], 
                                "target_penyelesaian" => $data['tgl_akhir_kontrak'],
                                "tanggal_order_placement" => $data['tgl_awal_kontrak'],
                                "tanggal_confirmation" => $data['tanggal_awal_kontrak'],
                                "tannggal_invoice" => "",//$data['vendor_id'],
                                "total_cycle_time" => "",
                                "kategori_delivery_time" => "3",
                                "rating" => "4",
                                "feedback" => "OK",
                                "deskripsi_project" => $data['deskripsi_pekerjaan']
                            ),
            
        );
    }elseif ($type == 'bumn') {
        $this->db->select("
			aa.ptm_number as no_rfq,
			aa.ptm_packet as pekerjaan,
			bb.ptp_reg_opening_date as tgl_publish_tender,
			bb.ptp_quot_closing_date as tgl_target,
			(select ptc_end_date from prc_tender_comment where ptm_number = aa.ptm_number and ptc_activity = 1180) as tgl_tunjuk_pemenang,
			aa.ptm_pagu_anggaran,
			case
				when CURRENT_TIMESTAMP > bb.ptp_quot_closing_date
					then 'Close'
				else 'Open'
			end as status,
			string_agg(etd_item, ', ') as detail,
			(select xx.siup_type from prc_tender_vendor x join vnd_header xx on x.ptv_vendor_code = xx.vendor_id limit 1) as siup_type");
        $status = array('1902', '1903');
		$metode = array('1', '0');
		$this->db->group_by(array("aa.ptm_number","aa.ptm_packet","bb.ptp_reg_opening_date","bb.ptp_quot_opening_date","aa.ptm_pagu_anggaran","bb.ptp_quot_closing_date"));
		$this->db->where_not_in('aa.ptm_status', $status);
		$this->db->where_in('aa.ptp_tender_method', $metode);
		$this->db->where('aa.ptm_number', $id);
		$this->db->join('prc_tender_prep bb on on aa.ptm_number = bb.ptm_number');
		$this->db->join('prc_evaluation_template_detail cc on cc.evt_id = bb.evt_id');
        $data = $this->db->get('prc_tender_main aa')->row_array();

        $send_data = array(
            "bumn" =>  
						array(
							"bumn_id"  => "", // "1",
							"nama_bumn"  => "", // "Wika Test Via Postman",
							"total_asset_bumn"  => "",//$data[''], // "100000",
							"total_project"  => "",//$data[''], // "100",
							"total_nilai_project"  => "",//$data[''], // "1000000",
							"total_nilai_capex"  => "",//$data[''], // "2000",
							"total_nilai_opex"  => "",//$data[''], // "3000",
							"tender_id"  => "", // "123",
							"nama_project_tender"  => $data['pekerjaan'], // "test",
							"tanggal_publish_tender"  => $data['tgl_publish_tender'], // "2020-10-20",
							"tanggal_target_kelengkapan_data"  => $data['tgl_target'], // "2020-10-20",
							"tanggal_pengumuman_hasil_tender"  => $data['tgl_tunjuk_pemenang'], // "2020-10-21",
							"nilai_project_tender"  => $data['ptm_pagu_anggaran'], // "12345",
							"status_project_tender"  => $data['status'], // "open",
							"detail_requirement"  => $data['detail'], // "ok!",
							"kategori_project_tender"  => ""//$data[''], // "Material Konstruksi"
						),
            
        );
    }
	
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($send_data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);

	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "x-api-key: 4HEOK3ARJVQhlusr2N1NvhiMUA3w33La",
		"Content-Type: application/json"));

	
	$raw_response = curl_exec($ch);


	$error = curl_error($ch);
	$response = json_decode($raw_response,TRUE);
	// var_dump($response);die;
}
}

?>