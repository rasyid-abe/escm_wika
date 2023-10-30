<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . '/core/Base_Api_Controller.php';
require_once APPPATH . '/libraries/REST_Controller.php';

class contract extends Base_Api_Controller {

	public function __construct($config = 'rest'){

      	// Call the Model constructor
		parent::__construct($config);
		$this->load->model('sync_postgre_model');
		$this->load->model('Administration_m');

	}

	public function contract_get(){   		
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}
      
		$contract = array();

		$contract_id = $this->get('contract_id');
		$status = $this->get('status');
		$year = $this->get('year');

		$data = $this->sync_postgre_model->get_all_contract($contract_id, $status, $year)->result_array();
		$total = $this->sync_postgre_model->get_all_contract($contract_id, $status, $year)->num_rows();

		if ($data) {	
			foreach ($data as $key => $value) {							
				$contract[$key]['contract_id'] = $value['contract_id'];
				$contract[$key]['nama_spk'] = $value['nama_spk'];
				$contract[$key]['ptm_number'] = $value['ptm_number'];
				$contract[$key]['contract_number'] = $value['contract_number'];
				$contract[$key]['status_code'] = $value['status'];
				$contract[$key]['status_name'] = $value['awa_name'];
				$contract[$key]['contract_amount'] = $value['contract_amount'];
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
			}			

			$this->response([
				'status' => true,
				'total' => $total,
				'data' => $contract
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_proyek_get(){   		
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}
      
		$items = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_item($contract_id)->result_array();
		$total = $this->sync_postgre_model->get_contract_item($contract_id)->num_rows();

		if ($data) {	
			foreach ($data as $key => $value) {						
				$items[$key]['vendor_code'] = $value['vendor_code'];
				$items[$key]['item_code'] = $value['item_code'];
				$items[$key]['short_description'] = $value['short_description'];
				$items[$key]['price'] = $value['price'];
				$items[$key]['qty'] = $value['qty'];
				$items[$key]['uom'] = $value['uom'];
				$items[$key]['sub_total'] = $value['sub_total'];		
			}			

			$this->response([
				'status' => true,
				'total_item' => $total,
				'contract_id' => $contract_id,
				'data_item' => $items
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_item_get(){   		
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}
      
		$items = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_item($contract_id)->result_array();
		$total = $this->sync_postgre_model->get_contract_item($contract_id)->num_rows();

		if ($data) {	
			foreach ($data as $key => $value) {						
				$items[$key]['vendor_code'] = $value['vendor_code'];
				$items[$key]['item_code'] = $value['item_code'];
				$items[$key]['short_description'] = $value['short_description'];
				$items[$key]['price'] = $value['price'];
				$items[$key]['qty'] = $value['qty'];
				$items[$key]['uom'] = $value['uom'];
				$items[$key]['sub_total'] = $value['sub_total'];		
			}			

			$this->response([
				'status' => true,
				'total_item' => $total,
				'contract_id' => $contract_id,
				'data_item' => $items
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function contract_doc_get(){   		
		if ($this->authtoken() == 'fail'){
			return $this->unauthorized();
			die();
      	}
      
		$dokumen = array();

		$contract_id = $this->get('contract_id');

		if(!isset($contract_id)) {
			return $this->notfound();
			die();
		}

		$data = $this->sync_postgre_model->get_contract_dokumen($contract_id)->result_array();
		$total = $this->sync_postgre_model->get_contract_dokumen($contract_id)->num_rows();

		if ($data) {	
			foreach ($data as $key => $value) {								
				$dokumen[$key]['description'] = $value['description'];				
				$dokumen[$key]['file_name'] = $value['filename'];
				$dokumen[$key]['file_url'] = $value['filename'] != NULL ? site_url("log/download_attachment/contract/document/" . $value['filename']) : '';
				$dokumen[$key]['kirim_vendor?'] = $value['publish'] == 1 ? 'Ya' : 'Tidak';
				$dokumen[$key]['name_input'] = $value['name_input'];		
				$dokumen[$key]['upload_date'] = $value['upload_date'];			
			}			

			$this->response([
				'status' => true,
				'total_doc' => $total,
				'contract_id' => $contract_id,
				'data_doc' => $dokumen
			], REST_Controller::HTTP_OK);

		} else {
			$this->response([
				'status' => FALSE,
				'message' => 'No contract were found'
			], REST_Controller::HTTP_NOT_FOUND);
		}
	}

	public function data_po_pmcs_get(){
	   include('api/data_po_pmcs.php');
	}

    public function data_bapb_pmcs_get(){
       include('api/data_bapb_pmcs.php');
    }

    public function data_baop_pmcs_get(){
       include('api/data_baop_pmcs.php');
    }

    public function data_invoice_pmcs_get(){
       include('api/data_invoice_pmcs.php');
    }

}

/* End of file Api.php */
/* Location: ./application/controllers/Api.php */