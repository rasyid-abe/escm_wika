<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once APPPATH.'core/Base_Api_Controller.php';

class Sync extends Base_Api_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('sync_postgre_model');
	}

	public function departement_get()
	{
        
        $data = $this->sync_postgre_model->get_all_dept_data();        
        if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No department were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    }
    
	public function role_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_role();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No role were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function smbd_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_smbd();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No role were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function pg_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_pg();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No role were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function tax_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_tax();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No role were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
	
	public function incoterm_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_incoterm();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No role were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
    
	public function vendor_get()
	{
       
		$data = $this->sync_postgre_model->get_all_vendor_data();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No vendor were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    }
    
	public function kontrak_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_kontrak();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No kontrak were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    }
    
	public function user_get()
	{
		$data = $this->sync_postgre_model->get_all_data_users();

		$proyek = array();

		if ($data) {
			foreach ($data as $key => $value) {			
				
				$data_proyek = $this->sync_postgre_model->get_user_proyek($value['employee_id']);

				$user[$key]['employee_id'] = $value['employee_id'];
				$user[$key]['fullname'] = $value['complete_name'];
				$user[$key]['pos_id'] = $value['pos_id'];
				$user[$key]['pos_name'] = $value['pos_name'];
				$user[$key]['user_name'] = $value['user_name'];
				$user[$key]['email'] = $value['email'];
				$user[$key]['password'] = $value['password'];
				$user[$key]['dept_id'] = $value['dept_id'];
				$user[$key]['dept_name'] = $value['dept_name'];
				$user[$key]['proyek'] = $data_proyek;				
			}			

			$this->response([
				'status' => true,
				'data' => $user,
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No user were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    }

	public function pr_get()
	{
		$header_pr = array();
		$item_pr = array();

		$data = $this->sync_postgre_model->get_all_pr();
		
		if ($data) {	
			foreach ($data as $key => $value) {							
				$header_pr[$key]['nomor_pr'] = $value['ppis_pr_number'];
				$header_pr[$key]['acc_assig'] = $value['ppis_acc_assig'];
				$header_pr[$key]['cat_tech'] = $value['ppis_cat_tech'];
				$header_pr[$key]['line'] = $value['ppis_pr_item'];
				$header_pr[$key]['kode_sda'] = str_replace(' ', '', $value['ppi_code']);
				$header_pr[$key]['pr_type'] = $value['ppis_pr_type'];
				$header_pr[$key]['type_of_plan'] = $value['ppm_type_of_plan'];
				$header_pr[$key]['project_name'] = $value['ppm_project_name'];
				$header_pr[$key]['desc'] = $value['ppi_item_desc'];
				$header_pr[$key]['pg'] = $value['ppm_dept_name'];
				$header_pr[$key]['uom'] = $value['ppi_satuan'];
				$header_pr[$key]['qty'] = $value['ppi_jumlah'];
				$header_pr[$key]['harsat'] = $value['ppi_harga'];
				$header_pr[$key]['subtotal'] = $value['subtotal'];
				$header_pr[$key]['price_unit'] = $value['ppi_temp_vol'];
				$header_pr[$key]['urut_costctr'] = $value['ppi_pr_order'];
				$header_pr[$key]['req_date'] = $value['ppms_start_date'];
				$header_pr[$key]['finish_date'] = $value['ppms_finish_date'];
				$header_pr[$key]['dev_date'] = $value['ppis_delivery_date'];
				$header_pr[$key]['status'] = $value['status_rkp'];
				$header_pr[$key]['project_id'] = $value['ppm_project_id'];
				$header_pr[$key]['project_id2'] = $value['ppms_project_id'];
				$header_pr[$key]['subject_of_work'] = $value['ppm_subject_of_work'];
				$header_pr[$key]['scope_of_work'] = $value['ppm_scope_of_work'];
				$header_pr[$key]['pagu_anggaran'] = $value['ppm_pagu_anggaran'];
				$header_pr[$key]['sisa_anggaran'] = $value['ppm_sisa_anggaran'];
				$header_pr[$key]['storage_loc'] = $value['ppms_storage_loc'];
				$header_pr[$key]['tgl_tender'] = $value['ppms_tgl_tender'];
				$header_pr[$key]['tgl_po'] = $value['ppms_tgl_po'];
				$header_pr[$key]['target_kedatangan'] = $value['ppms_target_kedatangan'];
				$header_pr[$key]['ekgrp'] = $value['ppm_ekgrp'];
				$header_pr[$key]['is_uskep_online'] = $value['ptm_is_uskep_online'];
				$header_pr[$key]['dept_id'] = $value['ppm_dept_id'];
				$header_pr[$key]['ppm_dept_name'] = $value['ppm_dept_name'];
				$header_pr[$key]['mata_uang'] = $value['ppi_mata_uang'];
				$header_pr[$key]['incoterm'] = $value['tit_incoterm'];
				$header_pr[$key]['lokasi_incoterm'] = $value['tit_lokasi_incoterm'];
				$header_pr[$key]['sumber_hps'] = $value['tit_sumber_hps'];
				$header_pr[$key]['hps'] = $value['tit_hps'];
				$header_pr[$key]['delete_flag'] = $value['ppi_delete_flag'];
				$header_pr[$key]['created_at'] = $value['ppi_created_at'];
				$header_pr[$key]['update_date'] = $value['ppi_update_at'];
			}			

			$this->response([
				'status' => true,
				'total' => count($data),
				'data' => $header_pr
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}

    }
    
	public function data_lelang_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_lelang();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No data lelang were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    }
    
	public function amandemen_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_amandemen();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No amandemen were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
    }
    
	public function project_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_project();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No project were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function grses_get()
	{
       
		$data = $this->sync_postgre_model->get_all_data_grses();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No project were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
	
	public function prc_plan_get()
	{
        $page = $this->get('row');
		$data = $this->sync_postgre_model->get_all_data_prc_plan($page);
		$num_row = $this->sync_postgre_model->get_all_data_prc_plan2();
		if ($data) {
			$this->response([
				'status' => true,
				'total' => $num_row-$page,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No prc plan were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function vpi_get()
	{       
		$data = $this->sync_postgre_model->get_all_data_vpi();
		if ($data) {
			$this->response([
				'status' => true,
				'data' => $data,
			], REST_Controller::HTTP_OK);
		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No vpi were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_get()
	{   		

		$contract = array();
		$items = array();
		$dokumen = array();
		$jaminan = array();
		$milestone = array();
		$person = array();
		$vpi = array();

		$data = $this->sync_postgre_model->get_all_contract()->result_array();
		
		if ($data) {	
			foreach ($data as $key => $value) {			
				
				$data_item = $this->sync_postgre_model->get_contract_item($value['contract_id'])->result_array();
				$data_dokumen = $this->sync_postgre_model->get_contract_dokumen($value['contract_id'])->result_array();
				$data_jaminan = $this->sync_postgre_model->get_contract_jaminan($value['contract_id']);
				$data_milestone = $this->sync_postgre_model->get_contract_milestone($value['contract_id']);
				$data_person = $this->sync_postgre_model->get_contract_person($value['contract_id']);
				$data_vpi = $this->sync_postgre_model->get_contract_vpi($value['contract_id'], $value['vendor_id']);

				$contract[$key]['contract_id'] = $value['contract_id'];
				$contract[$key]['ptm_number'] = $value['ptm_number'];
				$contract[$key]['contract_number'] = $value['contract_number'];
				$contract[$key]['status'] = $value['status'];
				$contract[$key]['contract_amount'] = number_format($value['contract_amount']);
				$contract[$key]['vendor_id'] = $value['vendor_id'];
				$contract[$key]['vendor_name'] = $value['vendor_name'];
				$contract[$key]['subject_work'] = $value['subject_work'];
				$contract[$key]['scope_work'] = $value['scope_work'];
				$contract[$key]['contract_type'] = $value['contract_type'];
				$contract[$key]['currency'] = $value['currency'];
				$contract[$key]['ctr_jenis'] = $value['ctr_jenis'];
				$contract[$key]['kategori_pekerjaan'] = $value['kategori_pekerjaan'];
				$contract[$key]['sign_date'] = $value['sign_date'];
				$contract[$key]['start_date'] = $value['start_date'];
				$contract[$key]['end_date'] = $value['end_date'];
				$contract[$key]['created_date'] = $value['created_date'];
				$contract[$key]['nomor_kontrak_sebelumnya'] = $value['amandemen_number'];
	
				foreach($data_item as $key_item => $value_item)
				{
					$items[$key_item]['contract_id'] = $value_item['contract_id'];
					$items[$key_item]['vendor_code'] = $value_item['vendor_code'];
					$items[$key_item]['item_code'] = $value_item['item_code'];
					$items[$key_item]['short_description'] = $value_item['short_description'];
					$items[$key_item]['price'] = number_format($value_item['price']);
					$items[$key_item]['qty'] = number_format($value_item['qty']);
					$items[$key_item]['uom'] = $value_item['uom'];
					$items[$key_item]['sub_total'] = number_format($value_item['sub_total']);			
				}
	
				$contract[$key]['sumberdaya'] = $items;		

				foreach($data_dokumen as $key_dokumen => $value_dokumen)
				{
					$dokumen[$key_dokumen]['contract_id'] = $value_dokumen['contract_id'];		
					$dokumen[$key_dokumen]['description'] = $value_dokumen['description'];		
					$dokumen[$key_dokumen]['file_name'] = $value_dokumen['filename'];
					$dokumen[$key_dokumen]['file_url'] = $value_dokumen['filename'] != NULL ? site_url("log/download_attachment/contract/document/" . $value_dokumen['filename']) : '';
					$dokumen[$key_dokumen]['kirim_vendor?'] = $value_dokumen['publish'] == 1 ? 'Ya' : 'Tidak';
					$dokumen[$key_dokumen]['name_input'] = $value_dokumen['name_input'];
					$dokumen[$key_dokumen]['upload_date'] = $value_dokumen['upload_date'];		
				}
	
				$contract[$key]['dokumen'] = $dokumen;		
				
				foreach($data_jaminan as $key_jaminan => $value_jaminan)
				{
					$jaminan[$key_jaminan]['contract_id'] = $value_jaminan['cj_contract_id'];
					$jaminan[$key_jaminan]['jenis_jaminan'] = $value_jaminan['cj_jenis_jaminan'];
					$jaminan[$key_jaminan]['tipe_jaminan'] = $value_jaminan['cj_tipe_jaminan'];
					$jaminan[$key_jaminan]['nama_perusahaan'] = $value_jaminan['cj_nama_perusahaan'];
					$jaminan[$key_jaminan]['nomor_jaminan'] = $value_jaminan['cj_nomor_jaminan'];
					$jaminan[$key_jaminan]['alamat'] = $value_jaminan['cj_alamat'];
					$jaminan[$key_jaminan]['nilai'] = number_format($value_jaminan['cj_nilai']);
					$jaminan[$key_jaminan]['date_start'] = $value_jaminan['cj_date_end'];
				}
	
				$contract[$key]['jaminan'] = $jaminan;		

				foreach($data_milestone as $key_milestone => $value_milestone)
				{
					$milestone[$key_milestone]['contract_id'] = $value_milestone['contract_id'];
					$milestone[$key_milestone]['description'] = $value_milestone['description'];
					$milestone[$key_milestone]['percentage'] = $value_milestone['percentage'];
					$milestone[$key_milestone]['target_date'] = $value_milestone['target_date'];
					$milestone[$key_milestone]['nilai'] = number_format($value_milestone['nilai']);
					$milestone[$key_milestone]['note'] = $value_milestone['note'];
				}
	
				$contract[$key]['milestone'] = $milestone;		
				
				foreach($data_person as $key_person => $value_person)
				{
					$person[$key_person]['contract_id'] = $value_person['cp_contract_id'];			
					$person[$key_person]['nama_lengkap'] = $value_person['cp_nama_lengkap'];			
					$person[$key_person]['jabatan'] = $value_person['cp_jabatan'];			
					$person[$key_person]['divisi'] = $value_person['cp_divisi'];			
					$person[$key_person]['nama_perusahaan'] = $value_person['cp_nama_perusahaan'];			
					$person[$key_person]['no_telp'] = $value_person['cp_no_telp'];			
					$person[$key_person]['email'] = $value_person['cp_email'];			
					$person[$key_person]['note'] = $value_person['cp_note'];			
					$person[$key_person]['created_by'] = $value_person['cp_created_by'];			
					$person[$key_person]['created_date'] = $value_person['cp_created_date'];
				}
	
				$contract[$key]['person_in_charge'] = $person;		
				
				foreach($data_vpi as $key_vpi => $value_vpi)
				{
					$vpi[$key_vpi]['contract_id'] = $value_vpi['contract_id'];	
					$vpi[$key_vpi]['vendor_id'] = $value_vpi['vendor_id'];	
					$vpi[$key_vpi]['vendor_name'] = $value_vpi['vendor_name'];	
					
					$dateObj   = DateTime::createFromFormat('!m', $value_vpi['vpi_month']);
					$monthName = $dateObj->format('F');

					$vpi[$key_vpi]['vpi_date_time'] = $value_vpi['vpi_date'] . '-' . $monthName . '-' . $value_vpi['vpi_year'];				
					$vpi[$key_vpi]['vpi_score'] = $value_vpi['vpi_score'];	
					$vpi[$key_vpi]['start_date'] = $value_vpi['start_date'];	
					$vpi[$key_vpi]['end_date'] = $value_vpi['end_date'];	
				}
	
				$contract[$key]['vpi'] = $vpi;		
			}			

			$this->response([
				'status' => true,
				'data' => $contract,
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function po_get()
	{
		$contract = array();
		$dokumen = array();

		$data = $this->sync_postgre_model->get_all_contract()->result_array();
		
		if ($data) {	
			foreach ($data as $key => $value) {			
				
				$data_item = $this->sync_postgre_model->get_contract_item($value['contract_id'])->result_array();
				$data_dokumen = $this->sync_postgre_model->get_contract_dokumen($value['contract_id'])->result_array();

				$contract[$key]['contract_id'] = $value['contract_id'];
				$contract[$key]['ptm_number'] = $value['ptm_number'];
				$contract[$key]['dept_id'] = $value['dept_id'];
				$contract[$key]['dept_name'] = $value['dept_name'];
				$contract[$key]['dept_code'] = $value['dep_code'];
				$contract[$key]['kode_spk'] = $value['kode_spk'];
				$contract[$key]['nama_spk'] = $value['nama_spk'];
				$contract[$key]['po_number'] = $value['ctr_po_number'];
				$contract[$key]['contract_number'] = $value['contract_number'];
				$contract[$key]['status'] = $value['status'];
				$contract[$key]['contract_amount'] = number_format($value['contract_amount']);
				$contract[$key]['vendor_id'] = $value['vendor_id'];
				$contract[$key]['vendor_name'] = $value['vendor_name'];
				$contract[$key]['vendor_address'] = $value['address_street'] == NULL ? $value['alamat'] : '';
				$contract[$key]['vendor_country'] = $value['address_country'] == NULL ? $value['country'] : '';
				$contract[$key]['subject_work'] = $value['subject_work'];
				$contract[$key]['scope_work'] = $value['scope_work'];
				$contract[$key]['contract_type'] = $value['contract_type'];
				$contract[$key]['currency'] = $value['currency'];
				$contract[$key]['ctr_jenis'] = $value['ctr_jenis'];
				$contract[$key]['kategori_pekerjaan'] = $value['kategori_pekerjaan'];
				$contract[$key]['sign_date'] = $value['sign_date'];
				$contract[$key]['start_date'] = $value['start_date'];
				$contract[$key]['end_date'] = $value['end_date'];
				$contract[$key]['created_date'] = $value['created_date'];
				$contract[$key]['nomor_kontrak_sebelumnya'] = $value['amandemen_number'];
				$contract[$key]['sumberdaya'] = $data_item;		
				$contract[$key]['dokumen'] = $data_dokumen;		
			}			

			$this->response([
				'status' => true,
				'data' => $contract,
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}
}