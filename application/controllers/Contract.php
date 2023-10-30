<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract extends Telescoope_Controller {

	var $data;

	public function __construct(){

		// Call the Model constructor
		parent::__construct();

		$this->load->model(array("Procedure2_m","Procedure3_m","Contract_m","Procrfq_m","Administration_m","Comment_m","Administration_m","Workflow_m","Addendum_m","Procplan_m","Procpr_m"));

		$this->data['date_format'] = "h:i A | d M Y";

		$this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

		$this->data['data'] = array();

		$this->data['post'] = $this->input->post();

		$userdata = $this->Administration_m->getLogin();

		$this->data['dir'] = 'contract';

		$this->data['controller_name'] = $this->uri->segment(1);

		$dir = './uploads/'.$this->data['dir'];

		$this->session->set_userdata("module",$this->data['dir']);

		if (!file_exists($dir)){
			mkdir($dir, 0777, true);
		}

		$config['allowed_types'] = '*';
		$config['overwrite'] = false;
		$config['max_size'] = 3064;
		$config['upload_path'] = $dir;
		$this->load->library('upload', $config);
		$this->load->model("Global_m");
		$this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

		$selection = array(
			"selection_milestone"
		);
		foreach ($selection as $key => $value) {
			$this->data[$value] = $this->session->userdata($value);
		}

		if(empty($userdata)){
			redirect(site_url('log/in'));
		}

	}

	public function save_item_sap()
	{
		$p = $this->input->post();

		if ($p['tpo'] == "PO Asset") {
			$upd['no_asset'] = $p['ass'];
			$upd['sub_number'] = $p['sub'];
		}

		$upd['item_po'] = $p['ipo'];
		$upd['tax_code'] = $p['tax'];

		$this->db->where('contract_item_id', $p['cid']);
		if ($this->db->update('ctr_contract_item', $upd)) {
			echo json_encode(true);
		} else {
			echo json_encode(false);
		}
	}

	public function export_txt()
	{
		$cid = $this->input->post('contract_id');
		$this->generate_po('export', $cid);
	}

	public function list_daftar_rfq_po(){
        include("procurement/tender_po/tender_po_rfq.php");
    }

	public function generate_po($tipe, $cid)
	{
		$this->db->order_by('contract_id');

		$idko = "";
		$ooh = $this->db->get_where('ctr_contract_header', ['contract_id' => $cid])->row_array();
		$oop = $this->db->get_where('ctr_contract_item', ['contract_id' => $ooh['contract_id']])->row_array();
		$aa = "
			cci2.item_code as item_code,
			TRUNC(cci2.qty) qty,
			cci2.uom,
			TRUNC(cci2.hps) as sub_total,
			";
		$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";

		if ($oop['pr_acc_assig'] == "Q" && $oop['pr_cat_tech'] == 0) {
			$idko = "B";
			$aa = "
			cci2.item_code as item_code,
			TRUNC(cci2.qty) qty,
			cci2.uom,
			TRUNC(cci2.hps) as sub_total,
				";
			$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
		}

		if ($oop['pr_acc_assig'] == "X" && $oop['pr_cat_tech'] == 5) {
			$idko = "B";
			$aa = "
			cci2.item_code as item_code,
			TRUNC(cci2.qty) qty,
			cci2.uom,
			TRUNC(cci2.hps) as sub_total,
				";
			$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
		}

		if ($oop['pr_acc_assig'] == "P" && $oop['pr_cat_tech'] == 0) {
			$idko = "B";
			$aa = "
			cci2.item_code as item_code,
			TRUNC(cci2.qty) qty,
			cci2.uom,
			TRUNC(cci2.hps) as sub_total,
				";
			$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
		}

		if ($oop['pr_acc_assig'] == "N" && $oop['pr_cat_tech'] == 9) {
			$idko = "J";
			$aa = "'' as service, '' as quantity, '' as uoms, '' as prices,";
			$bb = "
			cci2.item_code as item_code,
			TRUNC(cci2.qty) qty,
			cci2.uom,
			TRUNC(cci2.hps) as sub_total,
				";
		}

		if ($oop['pr_acc_assig'] == "U" && $oop['pr_cat_tech'] == 0) {
			$idko = "A";
			$aa = "
			cci2.item_code as item_code,
			TRUNC(cci2.qty) qty,
			cci2.uom,
			TRUNC(cci2.hps) as sub_total,
				";
			$bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
		}

		$sql = "
		  select
			cch2.ctr_doc_type,
			vnd.code_bp,
			concat(to_char(now(), 'YYYY'), '.', to_char(now(), 'MM'), '.', to_char(now(), 'DD')) start_date,
			admi.code,
			cci2.lokasi_incoterm,
			cci2.pr_retention,
			case
			when cch2.ctr_down_payment = 0 then null
			else cch2.ctr_down_payment
			end as ctr_down_payment,
			case
			when cch2.ctr_down_payment_date is not null
			then concat(to_char(cch2.ctr_down_payment_date, 'YYYY'), '.', to_char(cch2.ctr_down_payment_date, 'MM'), '.', to_char(cch2.ctr_down_payment_date, 'DD'))
			else null
			end as ctr_down_payment_date,
			(ROW_NUMBER () OVER (ORDER BY cci2.item_code desc) * 10 ) tit_item_po,
			$aa
			cci2.pr_number_sap,
			cci2.pr_item_sap,
			cch2.contract_number contract_number,
			case
			when cch2.ctr_delivery_date is not null
			then concat(to_char(cch2.ctr_delivery_date, 'YYYY'), '.', to_char(cch2.ctr_delivery_date, 'MM'), '.', to_char(cch2.ctr_delivery_date, 'DD'))
			else null
			end as ptm_created_date,
			cci2.no_asset,
			cci2.sub_number,
			cci2.tax_code,
			$bb
			cch2.ctr_scope,
			concat(concat(to_char(cch2.start_date, 'YYYY'),'.',to_char(cch2.start_date, 'MM'),'.',to_char(cch2.start_date, 'DD')),' - ',concat(to_char(cch2.end_date, 'YYYY'),'.',to_char(cch2.end_date, 'MM'),'.',to_char(cch2.end_date, 'DD'))) as rangedate
		  from
		  ctr_contract_header cch2
		  LEFT JOIN ctr_contract_item cci2 ON cch2.contract_id = cci2.contract_id
		  LEFT JOIN adm_incoterm admi ON cci2.incoterm = admi.description
		  LEFT JOIN vnd_header vnd ON cci2.vendor_code = vnd.vendor_id

		where
			cch2.contract_id = '$cid'
		order by cci2.item_code DESC";

		$data = $this->db->query($sql)->result_array();

		$newl = "\n";
		$body = "";
		foreach ($data as $k => $v) {
			$body .= $k+1 .'|'. implode("|",$v) . $newl;
		}

		$todaydate = date('Ymd');
		$time_utc=mktime(date('G'),date('i'),date('s'));
		$NowisTime=date('Gis',$time_utc);

		$hex = bin2hex(openssl_random_pseudo_bytes(16));

		$hea2 = "YMMI005".$idko."|".strtoupper($hex)."|A000||".$todaydate.$NowisTime;
		$head = 'DOC_NO|DOC_TYPE|VENDOR|DOC_DATE|INCOTERMS1|INCOTERMS2|RETENTION_PERCENTAGE|DOWNPAY_PERCENT|DOWNPAY_DUEDATE|PO_ITEM|MATERIAL|QUANTITY|PO_UNIT|NET_PRICE|PREQ_NO|PREQ_ITEM|VEND_MAT|DELIVERY_DATE|ASSET_NO|SUB_NUMBER|TAX_CODE|SERVICE|SERVICE_QTY|BASE_UOM|GR_PRICE|RUANG_LINGKUP|JANGKA_WAKTU';

		if ($tipe != 'export') {
			$directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Inbound';

			$path = 'uploads/PO';
			if (!is_dir($path))
				mkdir($path, 0777, true);

			$filename = 'YMMI005'.$idko.'_'.$todaydate.$NowisTime.'.txt';
			$output = $hea2.$newl.$head.$newl.$body;
			file_put_contents($path.'/'.$filename, $output);

			$this->db->where('contract_id', $cid);
			$this->db->update('ctr_contract_header', ['ctr_generate_text_number' => $filename]);

			$copy = copy($path.'/'.$filename, $directory.'/'.$filename);
			if ($copy) {
				return 'success';
			} else {
				return 'error';
			}
		} else {
			$filename = 'YMMI005'.$idko.'_'.$todaydate.$NowisTime.'.txt';
			$output = $hea2.$newl.$head.$newl.$body;

			 //update field generate po contract
			 $update['ctr_generate_text_number'] = $filename;

			 $this->db->where('contract_id', $cid);
			 $this->db->update('ctr_contract_header', $update);

			header("Content-type: text/plain");
			header("Content-Disposition: attachment; filename=".$filename);

			echo $output;
		}
	}

	public function syncpo()
	{
		$cccid = $this->input->post('cccid');
		$cid = $this->db->get_where('ctr_contract_comment', ['ccc_id' => $cccid])->row('contract_id');
		return $this->generate_po($tipe = 'sync', $cid);
	}

	public function daftar_pekerjaan($param1 = "" ,$param2 = ""){

		switch ($param1) {

			case 'proses_kontrak':
			$this->proses_kontrak();
			break;

			case 'proses_addendum':
			$this->proses_addendum();
			break;

			case 'edit':
			$this->edit_kontrak_sap($param2);
			break;

			default:
			include("contract/daftar_pekerjaan/daftar_pekerjaan.php");
			break;

		}

	}

	public function edit_kontrak_sap($param)
	{
		include("contract/daftar_pekerjaan/edit_kontrak_sap.php");
	}

	public function pembatalan_kontrak($param1 = ""){

		switch ($param1) {

			case 'proses':
			include("contract/proses_kontrak/tool_proses_pembatalan_kontrak.php");
			break;

			default:
			include("contract/proses_kontrak/tool_pembatalan_kontrak.php");
			break;

		}
	}

	public function proses_pembatalan_kontrak(){
		include("contract/proses_kontrak/proses_pembatalan_kontrak.php");
	}
	public function pdf_comment(){
		include("contract/monitor/pdf_comment.php");
	}

	public function submit_comment_contract(){
		include("contract/monitor/submit_comment_contract.php");
	}

	public function edit_comment_contract(){
		include("contract/monitor/edit_comment_contract.php");
	}

	public function get_edit_comment_contract(){
		include("contract/monitor/get_edit_comment_contract.php");
	}

	public function submit_delete_comment($id = ""){
		include("contract/monitor/submit_delete_comment.php");
	}

	public function submit_pembatalan_kontrak(){
		include("contract/proses_kontrak/submit_pembatalan_kontrak.php");
	}

	public function monitor_bast(){
		include("contract/monitor/monitor_bast.php");
	}

	public function picker_progress_wo(){
		include("contract/proses_progress/picker_progress_wo.php");
	}

	public function picker_progress_wo_matgis(){
		include("contract/proses_progress/picker_progress_wo_matgis.php");
	}

	public function picker_item_milestone(){
		include("contract/proses_progress/picker_item_milestone.php");
	}

	public function data_progress_wo(){
		include("contract/proses_progress/data_progress_wo.php");
	}
	public function data_progress_wo_matgis(){
		include("contract/proses_progress/data_progress_wo_matgis.php");
	}

	public function lihat_bast(){
		include("contract/work_order/lihat_bast.php");
	}

	public function monitor_wo(){
		include("contract/monitor/monitor_wo.php");
	}

	public function monitoring_matgis($param1=""){

		//redirect function for matgis monitoring
		switch ($param1) {

			case 'monitor_wo_matgis':
			redirect(site_url('contract_matgis/monitor_matgis/wo'));
			break;

			case 'monitoring_report_monev':
			redirect(site_url('contract_matgis/monitor_matgis/monev'));
			break;

			case 'monitoring_si':
			redirect(site_url('contract_matgis/monitor_matgis/si'));
			break;

			case 'monitor_sppm':
			redirect(site_url('contract_matgis/monitor_matgis/sppm'));
			break;

			case 'monitor_do':
			redirect(site_url('contract_matgis/monitor_matgis/do'));
			break;

			case 'monitor_sj':
			redirect(site_url('contract_matgis/monitor_matgis/sj'));
			break;

			case 'monitor_bapb':
			redirect(site_url('contract_matgis/monitor_matgis/bapb'));
			break;

			case 'monitor_invoice':
			redirect(site_url('contract_matgis/monitor_matgis/invoice'));
			break;
		}
	}

	public function DeleteFile($file)
	{
		$this->load->helper("file");
		$path="uploads/contract/".$file;
		unlink($path);
		return "success";
	}

	public function lihat_wo($id = ""){
		include("contract/work_order/lihat_wo.php");
	}
	public function lihat_wo_matgis($id = ""){
		include("contract/work_order/lihat_wo_matgis.php");
	}

	public function monitor_progress($act = "",$type = ""){
		include("contract/monitor/monitor_progress.php");
	}

	public function lihat_progress_wo($id = ""){
		include("contract/proses_progress/lihat_progress_wo.php");
	}
	public function lihat_progress_wo_matgis($id = ""){
		include("contract/proses_progress/lihat_progress_wo_matgis.php");
	}

	public function data_monitor_wo(){
		include("contract/monitor/data_monitor_wo.php");
	}

	public function data_monitor_wo_matgis(){
		include("contract/monitoring_matgis/data_monitor_wo_matgis.php");
	}
	public function data_wo_matgis_aktif(){
		include("contract/work_order/data_wo_matgis_aktif.php");
	}

	public function data_item_milestone(){
		include("contract/proses_kontrak/data_item_milestone.php");
	}

	public function monitor($param1 = "" ,$param2 = "",$param3 = ""){

		switch ($param1) {

			case 'monitor_wo':

			switch ($param2) {
				case 'lihat':
				$this->lihat_wo($param2);
				break;

				default:
				$this->monitor_wo();
				break;
			}

			break;

			case 'monitor_bast':

			switch ($param2) {
				case 'lihat':
				$this->lihat_bast();
				break;

				default:
				$this->monitor_bast();
				break;
			}

			break;

			case 'monitor_progress':

			switch ($param2) {
				case 'lihat':
				$this->lihat_progress();
				break;

				default:
				$this->monitor_progress($param2,$param3);
				break;
			}

			break;

			case 'monitor_kontrak':

			switch ($param2) {
				case 'lihat':
				$this->lihat_kontrak();
				break;

				default:
				$this->monitor_kontrak($param2);
				break;
			}

			break;

			case 'Kontrak':

			switch ($param2) {
				case 'lihat':
				$this->lihat_kontrak();
				break;

				default:
				$this->Kontrak($param2);
				break;
			}

			break;

			case 'monitor_adendum_kontrak':

			switch ($param2) {
				case 'lihat':
				$this->lihat_addendum();
				break;

				default:
				$this->monitor_addendum();
				break;
			}

			break;

			case 'monitor_tagihan':
			$this->monitor_tagihan();
			break;

			default:

			break;

		}

	}

	public function gr_ses($param1 = ""){

		switch ($param1) {

			case 'data_gr_ses':
			$this->data_gr_ses();
			break;

			case 'lihat':
			$this->lihat_gr_ses();
			break;

			default:
			include("contract/gr_ses/daftar_gr_ses.php");
			break;

		}

	}	

	public function work_order($param1 = "" ,$param2 = ""){

		switch ($param1) {

			case 'proses_work_order':
			$this->proses_work_order();
			break;

			case 'work_order':
			include("contract/work_order/work_order.php");
			break;

			default:
			include("contract/work_order/work_order.php");
			break;

		}

	}
	public function work_order_matgis($param1 = ""){

		switch ($param1) {

			case 'task_lists_matgis':
			redirect(site_url('contract_matgis/task_lists'));
			break;

			case 'work_order_matgis':
			redirect(site_url('contract_matgis/create_matgis/po'));
			break;

			case 'skbdn':
			redirect(site_url('contract_matgis/create_matgis/skbdn'));
			break;

			case 'shipping_instruction':
			redirect(site_url('contract_matgis/create_matgis/si'));
			break;

			case 'sppm':
			redirect(site_url('contract_matgis/create_matgis/sppm'));
			break;

			case 'bapb':
			redirect(site_url('contract_matgis/create_matgis/bapb'));
			break;

			case 'monitoring_monev':
			redirect(site_url('contract_matgis/monitor_matgis/monev'));

			case 'monitoring_matgis':
			redirect(site_url('contract_matgis/monitor_matgis/reports'));
			break;
		}

	}

	public function proses_kontrak(){
		include("contract/proses_kontrak/proses_kontrak.php");
	}

	public function proses_addendum(){
		include("addendum/proses_addendum/proses_addendum.php");
	}

	public function submit_proses_kontrak(){
		include("contract/proses_kontrak/submit_proses_kontrak.php");
	}

	public function submit_proses_kontrak_manual(){
		include("contract/proses_kontrak/submit_proses_kontrak_manual.php");
	}

	public function submit_proses_kontrak_manual_sap(){
		include("contract/proses_kontrak/submit_proses_kontrak_manual_sap.php");
	}

	public function update_proses_kontrak_manual_sap(){
		include("contract/proses_kontrak/update_proses_kontrak_manual_sap.php");
	}

	public function data_pekerjaan_adendum(){
		include("contract/daftar_pekerjaan/data_pekerjaan_adendum.php");
	}

	public function data_pekerjaan_kontrak(){
		include("contract/daftar_pekerjaan/data_pekerjaan_kontrak.php");
	}

	public function data_pekerjaan_kontrak_sap(){
		include("contract/daftar_pekerjaan/data_pekerjaan_kontrak_sap.php");
	}

	public function data_pekerjaan_po_manual(){
		include("contract/daftar_pekerjaan/data_pekerjaan_po_manual.php");
	}

	public function data_pekerjaan_amandemen(){
		include("contract/daftar_pekerjaan/data_pekerjaan_amandemen.php");
	}

	public function update_milestone(){
		include("contract/proses_kontrak/update_milestone.php");
	}

	public function data_progress_milestone(){
		include("contract/proses_kontrak/data_progress_milestone.php");
	}

	public function data_monitor_progress_milestone(){
		include("contract/proses_progress/data_monitor_progress_milestone.php");
	}

	public function data_progress($type,$id = ""){
		include("contract/proses_progress/data_progress.php");
	}

	public function lihat_progress_milestone($id = ""){
		include("contract/proses_progress/lihat_progress_milestone.php");
	}

	public function data_monitor_progress_wo(){
		include("contract/proses_progress/data_monitor_progress_wo.php");
	}

	public function data_comment_milestone(){
		include("contract/proses_kontrak/data_comment_milestone.php");
	}

	public function load_progress_milestone(){
		include("contract/proses_kontrak/load_progress_milestone.php");
	}

	public function save_milestone_progress(){
		include("contract/proses_kontrak/save_milestone_progress.php");
	}

	public function save_milestone_comment(){
		include("contract/proses_kontrak/save_milestone_comment.php");
	}

	public function tagihan_milestone(){
		include("contract/proses_kontrak/tagihan_milestone.php");
	}

	public function data_milestone(){
		include("contract/proses_kontrak/data_milestone.php");
	}

	public function save_invoice(){
		include("contract/proses_kontrak/save_invoice.php");
	}

	public function data_tagihan(){
		include("contract/proses_kontrak/data_tagihan.php");
	}

	public function lihat_tagihan(){
		include("contract/proses_kontrak/lihat_tagihan.php");
	}

	public function lihat_kontrak(){
		include("contract/monitor/lihat_kontrak.php");
	}

	public function lihat_addendum(){
		include("addendum/monitor/lihat_addendum.php");
	}

	public function monitor_tagihan(){
		include("contract/monitor/monitor_tagihan.php");
	}

	public function monitor_kontrak($act = ""){
		include("contract/monitor/monitor_kontrak.php");
	}

	public function list_contract($act = ""){
		include("contract/monitor/monitor_kontrak.php");
	}

	public function Kontrak($act = ""){
		include("contract/monitor/Kontrak.php");
	}

	public function data_monitor_kontrak($act = ""){
		include("contract/monitor/data_monitor_kontrak.php");
	}

	public function data_padi_umkm($act = ""){
		include("contract/monitor/data_padi_umkm.php");
	}

	public function data_padi_transaksi($act = ""){
		include("contract/monitor/data_padi_transaksi.php");
	}

	public function monitor_addendum(){
		include("addendum/monitor/monitor_addendum.php");
	}

	public function data_monitor_addendum(){
		include("addendum/monitor/data_monitor_addendum.php");
	}

	public function data_pekerjaan_wo(){
		include("contract/daftar_pekerjaan/data_pekerjaan_wo.php");
	}

	public function task_lists_matgis(){
		//include("contract/daftar_pekerjaan/data_pekerjaan_wo_matgis.php");

	}

	public function manual(){
		include("contract/proses_kontrak/manual.php");
	}

	public function manual_sap($pl = ''){
		include("contract/proses_kontrak/manual_sap.php");
	}

	public function umkm_padi(){
		include("contract/monitor/lihat_umkm_padi.php");
	}

	public function create_work_order(){
		include("contract/work_order/work_order.php");
	}

	public function create_work_order_matgis(){
		include("contract/work_order/work_order_matgis.php");
	}

	public function data_work_order(){
		include("contract/work_order/data_work_order.php");
	}

	public function data_work_order_matgis(){
		include("contract/work_order/data_work_order_matgis.php");
	}

	public function sync_grses(){
		include("contract/gr_ses/sync_grses.php");
	}

	public function submit_gr_ses(){
		include("contract/gr_ses/submit_add_gr_ses.php");
	}

	public function delete_gr_ses($id = ""){
		include("contract/gr_ses/delete_gr_ses.php");
	}

	public function data_gr_ses($gr_id = ""){
		include("contract/gr_ses/data_gr_ses.php");
	}

	public function lihat_gr_ses($gr_id = ""){
		include("contract/gr_ses/lihat_gr_ses.php");
	}

	public function lihat_release_po($po_id = ""){
		include("contract/proses_kontrak/lihat_release_po.php");
	}

	public function proses_work_order($contract_id = ""){
		include("contract/proses_work_order/proses_work_order.php");
	}

	public function proses_work_order_matgis($contract_id = ""){
		include("contract/proses_work_order/proses_work_order_matgis.php");
	}

	public function submit_proses_work_order(){
		include("contract/proses_work_order/submit_proses_work_order.php");
	}

	public function submit_proses_work_order_matgis(){
		include("contract/proses_work_order/submit_proses_work_order_matgis.php");
	}

	public function submit_proses_si_matgis(){
		include("contract/proses_work_order/submit_proses_si_matgis.php");
	}

	public function submit_proses_sppm_matgis(){
		include("contract/proses_work_order/submit_proses_sppm_matgis.php");
	}

	public function lihat_work_order(){
		include("contract/proses_work_order/lihat_work_order.php");
	}

	public function proses_wo($id = ""){
		include("contract/proses_work_order/proses_wo.php");
	}


	public function lihat_work_order_matgis(){
		include("contract/proses_work_order/lihat_work_order_matgis.php");
	}

	public function proses_wo_matgis($id = ""){
		include("contract/proses_work_order/proses_wo_matgis.php");
	}

	public function proses_si_matgis($id = ""){
		include("contract/proses_work_order/proses_si_matgis.php");
	}

	public function proses_sppm_matgis($id = ""){
		include("contract/proses_work_order/proses_sppm_matgis.php");
	}

	public function data_pekerjaan_progress_wo($id = ""){
		include("contract/daftar_pekerjaan/data_pekerjaan_progress_wo.php");
	}

	public function data_pekerjaan_progress_wo_matgis($id = ""){
		include("contract/daftar_pekerjaan/data_pekerjaan_progress_wo_matgis.php");
	}

	public function proses_progress_wo($id = ""){
		include("contract/proses_progress/proses_progress_wo.php");
	}

	public function proses_progress_wo_matgis($id = ""){
		include("contract/proses_progress/proses_progress_wo_matgis.php");
	}

	public function proses_progress_milestone($id = ""){
		include("contract/proses_progress/proses_progress_milestone.php");
	}

	public function submit_proses_progress_milestone(){
		include("contract/proses_progress/submit_proses_progress_milestone.php");
	}

	public function submit_proses_progress_wo(){
		include("contract/proses_progress/submit_proses_progress_wo.php");
	}
	public function submit_proses_progress_wo_matgis(){
		include("contract/proses_progress/submit_proses_progress_wo_matgis.php");
	}
	public function data_bast_wo(){
		include("contract/proses_progress/data_bast_wo.php");
	}

	public function data_bast_milestone(){
		include("contract/proses_progress/data_bast_milestone.php");
	}

	public function data_invoice_wo(){
		include("contract/proses_progress/data_invoice_wo.php");
	}
	public function data_invoice_wo_matgis(){
		include("contract/proses_progress/data_invoice_wo_matgis.php");
	}

	public function data_invoice_milestone(){
		include("contract/proses_progress/data_invoice_milestone.php");
	}

	public function proses_bast_milestone($id = ""){
		include("contract/proses_progress/proses_bast_milestone.php");
	}

	public function proses_bast_wo($id = ""){
		include("contract/proses_progress/proses_bast_wo.php");
	}

	public function proses_bast_wo_matgis($id = ""){
		include("contract/proses_progress/proses_bast_wo_matgis.php");
	}

	public function submit_proses_bast_wo($id = ""){
		include("contract/proses_progress/submit_proses_bast_wo.php");
	}

	public function submit_proses_bast_wo_matgis($id = ""){
		include("contract/proses_progress/submit_proses_bast_wo.php");
	}
	public function proses_invoice_wo($id = ""){
		include("contract/proses_progress/proses_invoice_wo.php");
	}
	public function proses_invoice_wo_matgis($id = ""){
		include("contract/proses_progress/proses_invoice_wo_matgis.php");
	}
	public function proses_invoice_milestone($id = ""){
		include("contract/proses_progress/proses_invoice_milestone.php");
	}

	public function submit_proses_invoice_wo($id = ""){
		include("contract/proses_progress/submit_proses_invoice_wo.php");
	}

	public function submit_proses_invoice_wo_matgis($id = ""){
		include("contract/proses_progress/submit_proses_invoice_wo_matgis.php");
	}

	public function submit_proses_invoice_milestone($id = ""){
		include("contract/proses_progress/submit_proses_invoice_milestone.php");
	}
	//hlmifzi

	public function submit_proses_bast_milestone($id = ""){
		include("contract/proses_progress/submit_proses_bast_milestone.php");
	}

	public function data_monitor_bast_milestone(){
		include("contract/monitor/data_monitor_bast_milestone.php");
	}

	public function data_monitor_bast_wo(){
		include("contract/monitor/data_monitor_bast_wo.php");
	}

	public function data_monitor_bast_wo_matgis(){
		include("contract/monitor/data_monitor_bast_wo_matgis.php");
	}

	public function lihat_bast_wo($id = ""){
		include("contract/monitor/lihat_bast_wo.php");
	}

	public function lihat_bast_wo_matgis($id = ""){
		include("contract/monitor/lihat_bast_wo_matgis.php");
	}
	public function lihat_bast_milestone($id = ""){
		include("contract/monitor/lihat_bast_milestone.php");
	}

	public function push_wo(){
		include("contract/work_order/push_wo.php");
	}

	public function panduan($params1 = ""){
		// show_404(); //sementara ini karena blm ada file guide manualnya
		switch ($params1) {
			case 'manual_contract_management':
			// redirect(base_url("guide/WIKA_eSCM_User_Guide_v1.1.pdf"));
			redirect(base_url("guide/user_guide.zip"));
			break;

			default:
			show_404();
			break;
		}

	}

	public function set_upload_options($path) {

		$config = array();
		$config['upload_path'] = './'.$path;
	    $config['allowed_types'] = 'pdf|doc|docx';
		$config['max_size']      = 4096;
		$config['max_filename']	 = '255';
	    $config['overwrite']     = TRUE;

	    return $config;
	}

}
