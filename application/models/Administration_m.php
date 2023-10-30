<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration_m extends CI_Model {

	public function __construct(){

		parent::__construct();

		$this->load->helper('security');

	}

	public function sync() {

        $ch_login = curl_init( CRM_WIKA_LOGIN );

        $data = array(
            'UserName' => 'ES941692@wika',
            'UserPassword' => 'ES941692@wika'
        );

        $payload = json_encode( $data );

        $fullPath = dir(getcwd());

        $cookie_jar = $fullPath->path . '\assets\crmtmp.tmp';

        curl_setopt($ch_login, CURLOPT_COOKIEJAR, $cookie_jar);
        curl_setopt($ch_login, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch_login, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch_login, CURLOPT_HEADER, 1);
        curl_setopt($ch_login, CURLOPT_VERBOSE, 1);
        curl_setopt($ch_login, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch_login, CURLOPT_POST, true);
        curl_setopt($ch_login, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch_login, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json')
        );

        $result = curl_exec($ch_login);

        $header_size = curl_getinfo($ch_login, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);

        preg_match_all('/^set-cookie:\s*([^;]*)/mi', $header, $matches);
        $cookies = array();
        foreach($matches[1] as $item) {
            parse_str($item, $cookie);
            $cookies = array_merge($cookies, $cookie);
        }

		if (isset($cookies['BPMCSRF'])) {
			setcookie('BPMCSRF', $cookies['BPMCSRF']);
			setcookie('BPMLOADER', $cookies['BPMLOADER']);
			setcookie('_ASPXAUTH', $cookies['_ASPXAUTH']);
			setcookie('UserName', $cookies['UserName']);
			$this->session->set_userdata('BPMCSRF', $cookies['BPMCSRF']);
			curl_close($ch_login);
			return $cookies['BPMCSRF'];
			
		} else {
			curl_close($ch_login);
		}
		
    }

	public function get_data_api_crm($payload_info, $bpmcsrf)
	{

		  $fullPath = dir(getcwd());

		  $cookie_jar = $fullPath->path . '\assets\crmtmp.tmp';


		  $ch_info = curl_init( CRM_WIKA_INFO );
		  // $BPMCSRF = isset($_COOKIE['BPMCSRF']) ? $_COOKIE['BPMCSRF'] : '1';

		  curl_setopt($ch_info, CURLOPT_COOKIEFILE, $cookie_jar);
		  curl_setopt($ch_info, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($ch_info, CURLINFO_HEADER_OUT, true);
		  curl_setopt($ch_info, CURLOPT_POST, true);
		  curl_setopt($ch_info, CURLOPT_POSTFIELDS, $payload_info);
		  curl_setopt($ch_info, CURLOPT_HTTPHEADER, array(
		      'Content-Type: application/json',
		      'BPMCSRF:'. $bpmcsrf)
		  );

		  return curl_exec($ch_info);
	}

	public function get_transporter()
	{
		$this->db->where('is_transporter',1);
		return $this->db->get("vnd_header")->result_array();
	}

	public function isHeadQuatersProcurement($ptm_number){
		$getdistrict = $this->db
		->select("district_code")
		->where("b.ptm_number",$ptm_number)
		->join("prc_pr_main a","a.pr_number=b.pr_number")
		->join("prc_plan_main d","a.ppm_id=d.ppm_id")
		->join("adm_district c","c.district_id=d.ppm_district_id")
		->get("prc_tender_main b")->row_array();
		$code = (isset($getdistrict['district_code'])) ? $getdistrict['district_code'] : "";
		return ($code == HEADQUATERS_CODE);
	}

	public function isHeadQuaters($district_id){
		$getdistrict = $this->db
		->select("district_code")
		->where("district_id",$district_id)
		->get("adm_district b")->row_array();
		$code = (isset($getdistrict['district_code'])) ? $getdistrict['district_code'] : "";
		return ($code == HEADQUATERS_CODE);
	}

	public function getProcurementLocation($ptm_number){

	}

	//y
	public function getEmployeeJoin($employee = ""){
		if(!empty($employee)){
			$this->db->where("employee_id",$employee);
			$this->db->where(array("employee_id"=>$employee, "job_title"=>"PELAKSANA PENGADAAN"));
		}

		return  $this->db->get("vw_adm_pos A");
	}
	//end

	public function getDelPoint($id = ""){

		if(!empty($id)){

			$this->db->where("del_point_id",$id);

		}

		$this->db->where("del_point_active",'1');

		return $this->db->get("adm_del_point");

	}

	public function getUserRule($id = ""){

		if(!empty($id)){

			$this->db->where("employee_id",$id);

		}

		$this->db->order_by("complete_name","asc");

		return $this->db->get("user_login_rule");

	}

	public function getDistrict($id = ""){

		if(!empty($id)){

			$this->db->where("district_id",$id);

		}

		return $this->db->get("adm_district");

	}

	public function getUserData($id = ""){

		if(!empty($id)){

			if(is_numeric($id)){

				$this->db->where('id',$id);

			} else {

				$this->db->where('username_user',$id);

			}

		}

		return $this->db->get('adm_user');

	}


	public function getUserByJob($job = ""){

		$this->db->select("A.employee_id,A.pos_id,A.pos_name,C.fullname");

		if(!empty($job)){

			$this->db->where('job_title',$job);

		}

		$this->db->join("adm_pos B","A.pos_id = B.pos_id","INNER");

		$this->db->join("adm_employee C","C.id = A.employee_id","INNER");

		$this->db->order_by("fullname","asc");

		return $this->db->get('adm_employee_pos A');

	}

	public function checkLogin($username, $password){

		$where = array(
			'user_name' => $username,
			'password' => strtoupper(do_hash($password,'sha1'))
			);

		$this->db->where($where);

		return $this->db->get('adm_user');

	}

	public function loginApi($username,$password){

		$url = "https://dev-ecatalog.scmwika.com/api_new/GenerateToken";
        $curl = curl_init($url);

        $data = array (
            'username' => $username,
            'password' => $password
        );

        $payload = json_encode($data);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'Accept:application/json'
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($curl);
        $response = json_decode($result, true);

		return $response;
	}

	public function getPos($id = ""){
		if(!empty($id)){
			$this->db->where("pos_id",$id);
		}
		return $this->db->get("adm_pos");
	}

	public function getEmployeePos($employee = ""){
		if(!empty($employee)){
			$this->db->where("employee_id",$employee);
		}

		// return  $this->db->get("vw_adm_pos A");
		return  $this->db->get("vw_adm_pos_v1 A"); //y get
	}

	public function getEmployeeProyek($employee = ""){
		if(!empty($employee)){
			$this->db->where("employee_id",$employee);
		}

		return  $this->db->get("adm_employee_proyek");
	}

	public function getEmployeeCat($employee = ""){
		if(!empty($employee)){
			$this->db->where("employee_id",$employee);
		}

		return  $this->db->get("adm_employee_cat");
	}

	//start delegasi
	public function getEmployeePosDelegasi($employee = ""){
		if(!empty($employee)){
			/*$this->db->where("employee_id",$employee);*/

			$where = "where employee_id=$employee";
		}

		/*return  $this->db->query("vw_adm_pos A");*/
		return $this->db->query("
				select * from adm_employee_pos $where
				union
				select b.* from adm_delegasi a
				join adm_employee_pos b on a.from = b.employee_id
				where a.to = $employee and now() between start_date and end_date;
			");
	}
	//end delegasi


	public function getDeptUser($employee_id = ""){
		$position = $this->getPosition($employee_id);
		$data = array();
		foreach ($position as $key => $value) {
			$data[] = $value['dept_id'];
		}
		return $data;
	}

	public function getPosition($job_title = "",$employee_id = ""){

		$employee = $this->getLogin();

		if(empty($employee_id)){
			$employee_id = $employee['employee_id'];
		}
		if(!empty($job_title)){
			if(is_array($job_title)){
				$this->db->where_in("job_title",$job_title);
				$data = $this->getEmployeePos($employee_id)->result_array();
			} else {
				$this->db->where("job_title",$job_title);
				$data = $this->getEmployeePos($employee_id)->row_array();
			}
		} else {
			$data = $this->getEmployeePos($employee_id)->result_array();
		}

		return $data;

	}

	public function getLogin(){

		$id = $this->session->userdata(do_hash(SESSION_PREFIX));

		$login = $this->getUser($id)->row_array();

		$role = $this->session->userdata(do_hash("ROLE"));

		if(!empty($role)){
			$this->db->where("pos_id",$role);
			$getrole = $this->getEmployeePos($login['employee_id'])->row_array();
			if(!empty($getrole)){
				$login = array_merge($login,$getrole);
			}
		}

		return $login;

	}

	public function getUser($id = ""){

		if(!empty($id)){
			$this->db->where("A.id",$id);
		}

		return $this->db->get('vw_user_access A');

	}

	public function getMenuUser($employee){

		$role = $this->session->userdata(do_hash("ROLE"));

		if(empty($role)){
			$p = $this->getLogin();
		} else {
			$p = $this->getPos($role)->row_array();
		}

		$role = $p['job_title'];

		$this->db->join("adm_menu","menu_id=menuid","inner");
		$this->db->where("jobtitle",$role);

		$parent_menu = $this->db->order_by("menu_code","asc")->get("adm_jobtitle_menu")->result_array();
		$allparent = array();
		$menu = array();
		foreach ($parent_menu as $key => $value) {
			if(!in_array($value['parent_id'], $allparent)){
				$allparent[] = $value['parent_id'];
			}
			$menu[$value['parent_id']][$value['menuid']] = $value;
		}

		if(!empty($allparent)){
			$this->db->where_in("menuid",$allparent);
		}

		$parent_menu = $this->db->join("adm_menu","menu_id=menuid","inner")
		->where("parent_id",0)
		->order_by("menu_code","asc")
		->get("adm_jobtitle_menu")->result_array();

		foreach ($parent_menu as $key => $value) {
			$menu[$value['parent_id']][$value['menuid']] = $value;
		}

		return $menu;
	}

	public function getMenu($jobtitle = ""){

		if(!empty($jobtitle)){
			$this->db->join("adm_jobtitle_menu","menu_id=menuid","inner");
			$this->db->where("jobtitle",$jobtitle);
		}

		$parent_menu = $this->db->order_by("menu_code","asc")->get("adm_menu")->result_array();
		$menu = array();
		foreach ($parent_menu as $key => $value) {

			$menu[$value['parent_id']][$value['menuid']] = $value;
		}

		return $menu;

	}

	public function get_salutation($id = ""){

		if(!empty($id)){

			$this->db->where("adm_salutation_id",$id);

		}

		return $this->db->get("adm_salutation");

	}

	public function get_job_pos($id = ""){

		if(!empty($id)){

			$this->db->where("pos_id",$id);

		}

		return $this->db->get("adm_pos");

	}

	public function get_proyek_post($id = ""){		
		
		$this->db->select("ppm_id, ppm_project_id, ppm_project_name, ppm_dept_id, ppm_dept_name");

		if(!empty($id)){

			$this->db->where("ppm_id",$id);

		}

		$this->db->where("ppm_is_sap", 1);

		$this->db->order_by("ppm_id", "desc");

		return $this->db->get("prc_plan_main");

	}

	public function get_employee($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("adm_employee");

	}

	public function get_employee_type_name($id){

		$data = $this->db->where("employee_type_id = '$id'")->get("adm_employee_type")->row_array();

		return (isset($data['employee_type_name'])) && (!empty($data['employee_type_name'])) ? $data['employee_type_name'] : "";

	}

	public function get_divisi_departemen($id = ""){

		$this->db->select("*,
			CASE COALESCE(dept_type,0)
			WHEN 0 THEN 'Divisi/Departemen'
			WHEN 1 THEN 'Pelabuhan'
			END AS dept_type_name");

		if(!empty($id)){

			$this->db->where("dept_id",$id);

		}

		$this->db->where("dept_active",1);

		return $this->db->get("adm_dept");

	}

	public function get_departemen($id = ""){

		$this->db->select("a.*, b.divisi_utama_type");
		$this->db->join('vw_adm_divisi_utama b', 'b.divisi_utama_id = a.district_id');

		if(!empty($id)){

			$this->db->where("a.dept_id",$id);

		}

		$this->db->where("a.dept_active",1);

		return $this->db->get("adm_dept a");

	}

	public function get_divisi($id = ""){

		$this->db->select("c.*, b.divisi_utama_type,b.divisi_utama_name");
		$this->db->join('adm_dept a', 'a.dept_id = c.dept_id');
		$this->db->join('vw_adm_divisi_utama b', 'b.divisi_utama_id = a.district_id');
		if(!empty($id)){

			$this->db->where("c.divisi_id",$id);

		}

		$this->db->where("c.divisi_active",1);

		return $this->db->get("adm_divisi c");

	}

	public function get_biro($id = ""){

		$this->db->select("c.*, b.divisi_utama_type,b.divisi_utama_name");
		$this->db->join('adm_dept a', 'a.dept_id = c.dept_id');
		$this->db->join('vw_adm_divisi_utama b', 'b.divisi_utama_id = a.district_id');
		if(!empty($id)){

			$this->db->where("c.biro_id",$id);

		}

		$this->db->where("c.biro_active",1);

		return $this->db->get("adm_biro c");

	}

	public function get_harbour($id = ""){

		if(!empty($id)){

			$this->db->where("dept_id",$id);

		}

		$where = "dept_active=1 AND dept_type=1";
		$this->db->where($where);

		return $this->db->get("adm_dept");

	}

	public function get_dist_name($id = ""){

		if(!empty($id)){

			$this->db->where("district_id",$id);

		}

		return $this->db->get("adm_district");

	}

	public function get_dept_name($id = ""){

		if(!empty($id)){

			$this->db->where("dept_id",$id);

		}

		return $this->db->get("adm_dept");

	}

	public function get_divbirnit_dept_name($id){

		$data = $this->db->where("district_id",$id)->get("adm_district")->row_array();

		return (isset($data['district_name'])) && (!empty($data['district_name'])) ? $data['district_name'] : "";

	}

	public function get_lane_name($id){

		$data = $this->db->where("dept_id",$id)->get("adm_dept")->row_array();

		return (isset($data['dept_name'])) && (!empty($data['dept_name'])) ? $data['dept_name'] : "";

	}


	public function get_delivery_point($id = ""){

		if(!empty($id)){

			$this->db->where("del_point_id",$id);

		}

		$this->db->where("del_point_active",1);

		return $this->db->get("adm_del_point");
	}


	public function get_daftar_kantor($id = ""){

		if(!empty($id)){

			$this->db->where("district_id",$id);

		}

		return $this->db->get("adm_district");

	}

	//haqim
	public function get_divisi_utama($id = ""){

		if(!empty($id)){

			$this->db->where("divisi_utama_id",$id);

		}

		return $this->db->get("vw_adm_divisi_utama");

	}
	//end

	public function get_currency($id = ""){

		if(!empty($id)){

			$this->db->where("curr_id",$id);

		}

		return $this->db->get("adm_curr");

	}

	public function get_gudang($id = ""){

		if(!empty($id)){

			$this->db->where("id_war",$id);

		}

		return $this->db->get("adm_warehouse");

	}

	public function get_catalog($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("adm_catalogue");

	}

	public function get_employee_type($id = ""){

		if(!empty($id)){

			$this->db->where("employee_type_id",$id);

		}

		return $this->db->get("adm_employee_type");
	}


	public function get_mata_anggaran($id = ""){

		if(!empty($id)){

			$this->db->where("pag_id",$id);

		}

		return $this->db->get("prc_anggaran");
	}

	//haqim

	public function getHieMenu(){
		return $this->db->get('adm_hierarchy_menu')->result_array();
	}

	public function getParentId($id = "",$type = "pr"){

		switch ($type) {
				case 'rkp':
				$tabel = "adm_auth_hie_rkp";
				// $tabel = "adm_auth_hie_5";
				break;

				case 'rkap':
				$tabel = "adm_auth_hie_rkap";
				// $tabel = "adm_auth_hie_6";
				break;

				case 'pr-proyek':
				$tabel = "adm_auth_hie_pr_proyek";
				// $tabel = "adm_auth_hie_7";
				break;

				case "pr-non-proyek":
				$tabel = "adm_auth_hie_pr_non_proyek";
				break;

				case 'rfq-proyek':
				$tabel = "adm_auth_hie_rfq_proyek";
				// $tabel = "adm_auth_hie_8";
				break;

				case 'rfq-non-proyek':
				$tabel = "adm_auth_hie_rfq_non_proyek";
				// $tabel = "adm_auth_hie_2";
				break;

				case 'pemenang-proyek':
				$tabel = "adm_auth_hie_pemenang_proyek";
				// $tabel = "adm_auth_hie_9";
				break;

				case 'pemenang-non-proyek':
				// $tabel = "adm_auth_hie_3";
				$tabel = "adm_auth_hie_pemenang_non_proyek";
				break;

				case 'kontrak-proyek':
				$tabel = "adm_auth_hie_kontrak_proyek";
				// $tabel = "adm_auth_hie_10";
				break;

				case 'kontrak-non-proyek':
				$tabel = "adm_auth_hie_kontrak_non_proyek";
				// $tabel = "adm_auth_hie_11";
				break;
			// case 'inventory':
			// $tabel = "adm_auth_hie_4";
			// break;

			// default:
			// $tabel = "adm_auth_hie";
			// break;
		}


		if(!empty($id)){

			$this->db->where("$tabel.auth_hie_id",$id);

		}
		$this->db->join("adm_pos","$tabel.pos_id=adm_pos.pos_id","left");
		return $this->db->get("$tabel");

	}
	//end

	public function get_pos_id($id = ""){

		if(!empty($id)){

			$this->db->where("pos_id",$id);

		}

		return $this->db->get("vw_pos");
	}

	public function get_job_title($id = ""){

		if(!empty($id)){

			$this->db->where("job_title",$id);

		}

		return $this->db->get("adm_jobtitle");
	}

	public function get_user_data($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("adm_user");
	}

	public function user_access_view($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("vw_user_access");
	}

	public function employee_view($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("vw_employee");
	}

	public function convert_nama_department($id){

		$data = $this->db->where("dept_id = '$id'")->get("adm_dept")->row_array();

		return (isset($data['dept_name'])) && (!empty($data['dept_name'])) ? $data['dept_name'] : "";

	}

	public function convert_nama_distrik($id){

		$data = $this->db->where("district_id = '$id'")->get("adm_district")->row_array();

		return (isset($data['district_name'])) && (!empty($data['district_name'])) ? $data['district_name'] : "";

	}

	public function convert_posisi($id){

		$data = $this->db->where("pos_id = '$id'")->get("adm_pos")->row_array();

		return (isset($data['pos_name'])) && (!empty($data['pos_name'])) ? $data['pos_name'] : "";

	}

	public function convert_nama_employee($id){

		$data = $this->db->where("id = '$id'")->get("adm_employee")->row_array();

		return (isset($data['fullname'])) && (!empty($data['fullname'])) ? $data['fullname'] : "";

	}

	public function getCommittee($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("adm_committee");
	}

	public function getBidCommittee2($id = "",$committee_id = ""){

		$this->db->select("team_order,fullname,committee_pos,name_abct,(select count(ptp_id) FROM prc_tender_prep WHERE prc_tender_prep.adm_bid_committee = vw_adm_bid_committee.committee_id) as used")->distinct();

		if(!empty($id)){

			$this->db->where("team_order",$id);

		}

		if(!empty($committee_id)){

			$this->db->where("committee_id",$committee_id);

		}

		return $this->db->get("vw_adm_bid_committee");
	}

	public function getCommitteeType($id = ""){

		if(!empty($id)){

			$this->db->where("id_abct",$id);

		}

		return $this->db->get("adm_bid_committee_type");
	}

	public function getExchangeRate($id = ""){

		if(!empty($id)){

			$this->db->where("exchange_rate_id",$id);

		}

		return $this->db->get("adm_exchange_rate");
	}

	public function getCurrency($id = ""){

		if(!empty($id)){

			$this->db->where("curr_id",$id);

		}

		return $this->db->get("adm_curr");
	}

	public function convert_exchange_rate($id){

		$data = $this->db->where("curr_code = '$id'")->get("adm_curr")->row_array();

		return (isset($data['curr_name'])) && (!empty($data['curr_name'])) ? $data['curr_name'] : "";

	}

	public function getMasterAnggaran($id = ""){

		if(!empty($id)){

			$this->db->where("pag_mata_anggaran",$id);

		}

		return $this->db->get("prc_anggaran_master");
	}

	public function get_lintasan($id = ""){

		$this->db->select("*,
			CASE COALESCE(roundtrip_type,0)
			WHEN 0 THEN 'Tidak'
			WHEN 1 THEN 'Ya'
			END AS roundtrip_type_name");

		if(!empty($id)){

			$this->db->where("lane_id",$id);

		}

		//$this->db->where("lane_active",1);

		return $this->db->get("vw_lane");

	}

	public function getCot($id = ""){

		if(!empty($id)){
			$this->db->where("cot_id",$id);
		}

		$this->db->order_by("jenis_nasabah","asc");

		return $this->db->get("adm_cot");

	}

	public function getPosbyJob($job){

		if(!empty($job)){
			$this->db->order_by("pos_id", "desc");
			return $this->db->where("job_title", $job)->get("adm_pos");
		}
	}

	public function getAllJob($employee_id, $limit){

		if(!empty($employee_id)){

			if (!empty($limit)) {
				$this->db->limit(5);
			}
			$this->db->select("vw_job_all.*");
			$this->db->where("vw_adm_pos_v1.employee_id", $employee_id);
			$this->db->group_start();
			$this->db->where("vw_job_all.employee_id", $employee_id);
			$this->db->or_where("vw_job_all.employee_id", null);
			$this->db->group_end();
			$this->db->join("vw_adm_pos_v1", "vw_adm_pos_v1.pos_id = vw_job_all.pos_id");
			$this->db->where("activity !=", "Terminasi Lelang Disetujui");
			$x = $this->db->get("vw_job_all");
			return $x;
		}
	}

	public function getMessageRfq($name){

		if (!empty($name)) {
			$this->db->select("id,rfq_number,pesan,employee_from");
			$this->db->where(array('status'=> 0, 'TRIM(employee_to)'=>$name));
			$this->db->order_by("id","desc");
			return $this->db->get("prc_chat_rfq");
		}
	}

	//Aspek Penilaian Mutu Pekerjaan dan Personal
	public function addAspekPenilaianMutu($data=array()){
		$insert = $this->db->insert_batch('adm_aspek_penilaian_mutu', $data);
		return $insert;
	}

	public function updateAspekPenilaianMutu($id,$data=array()){
		$this->db->where('apm_id', $id);
		$this->db->update('adm_aspek_penilaian_mutu', $data);
	}

	public function getAspekPenilaianMutu($id=""){

		if(!empty($id)){

			$this->db->where("apm_id",$id);

		}
		return $this->db->get("vw_adm_aspek_penilaian_mutu");
	}

	public function NonaktifAspekPenilaianMutu($id=array()){

		$this->db->where_in("apm_id",$id);

		$this->db->update("adm_aspek_penilaian_mutu", array("apm_status"=>"N"));
	}


	public function ActivateAspekPenilaianMutu($id=array()){

		$this->db->where_in("apm_id",$id);

		$this->db->update("adm_aspek_penilaian_mutu", array("apm_status"=>"A"));
	}

	public function getTargetdanBobotKompilasiVPI($id="",$type){

		if (!empty($id)) {
			$this->db->where('abt_id', $id);
		}
		$this->db->order_by('abt_seq', 'asc');

		$this->db->group_start();
		$this->db->where('abt_type', $type);
		$this->db->where('abt_status', "A");
		$this->db->group_end();


		return $this->db->get('adm_target_dan_bobot_kompilasi_vpi');
	}

	public function InsertTargetdanBobotKompilasiVPI($data,$where=""){


		if (!empty($where)) {
			$this->db->where($where);
			$check = $this->db->get('adm_target_dan_bobot_kompilasi_vpi')->num_rows();
			if($check > 0){
				$this->db->update('adm_target_dan_bobot_kompilasi_vpi', $data, $where);
			}else{
				$this->db->insert('adm_target_dan_bobot_kompilasi_vpi', $data);
			}

		}else{
			$this->db->insert('adm_target_dan_bobot_kompilasi_vpi', $data);
		}

		return $this->db->affected_rows();

	}

	//Kuesioner Kepuasan Vendor
	public function addKuesioner($data=array()){
		$insert = $this->db->insert_batch('adm_vsi_kuesioner', $data);
		return $insert;
	}

	public function updateKuesioner($id="", $data=array()){
		$this->db->where('avk_id', $id);
		$this->db->update('adm_vsi_kuesioner', $data);
	}

	public function getKuesioner($id="", $id_template=""){

		if(!empty($id)){

			$this->db->where("avk_id",$id);

		}
		if(!empty($id_template)){

			$this->db->where("template_id",$id_template);

		}
		return $this->db->get("adm_vsi_kuesioner");
	}

	public function UpdateStatusKuesioner($id=array()){

		$data = $this->db->where_in("avk_id", $id)->get("adm_vsi_kuesioner")->result_array();

		foreach ($data as $k => $v) {

			if ($v['avk_status'] == "Aktif") {
				$status_to = "Non Aktif";
			}else{
				$status_to = "Aktif";
			}

			$this->db->where_in("avk_id",$id);

			$this->db->update("adm_vsi_kuesioner", array("avk_status"=>$status_to, 'updated_datetime'=>date('Y-m-d h:i:s')));
		}

	}


	//Template Kuesioner Kepuasan Vendor
	public function addTemplateKuesioner($data=array()){
		$insert = $this->db->insert_batch('adm_vsi_template_kuesioner', $data);
		return $insert;
	}

	public function updateTemplateKuesioner($id="" ,$data=array()){

		$this->db->where('atk_id', $id);
		$this->db->update('adm_vsi_template_kuesioner', $data);
	}

	public function getTemplateKuesioner($id="", $where=array()){

		if(!empty($id)){

			$this->db->where("atk_id",$id);

		}
		if(!empty($where)){

			$this->db->where($where);

		}
		return $this->db->get("adm_vsi_template_kuesioner");
	}

	public function UpdateStatusTemplateKuesioner($id, $status){

		if(!empty($id)){

			$this->db->where("atk_id",$id);

			if ($status == "nonaktif") {
				$status_to = "Non Aktif";
			}else{
				$status_to = "Aktif";
			}

		}

		$this->db->update("adm_vsi_template_kuesioner", array("atk_status"=>$status_to, "updated_datetime"=>date('Y-m-d h:i:s')));
	}

	public function getRegion($id=""){

		if (!empty($id)) {

			$this->db->where("region_id", $id);
		}
		return $this->db->get("adm_region");
	}

	public function updateRegion($id="", $data=array()){

		if (!empty($id)) {

			$this->db->where("region_id", $id);
			return $this->db->update("adm_region", $data);
		}
	}

	public function insertRegion($input=""){

		if (!empty($input)) {

			return $this->db->insert("adm_region", $input);
		}
	}

	public function insertMasterMdiv($input=array()){

		if (!empty($input)) {

			return $this->db->insert("adm_master_mdiv", $input);
		}
	}

	public function getMasterMdiv($where=array()){

		$this->db->select("a.*, b.region_name, c.pos_name, d.dept_name");

		if (!empty($where)) {
			$this->db->where($where);
		}

		$this->db->join("adm_region b","b.region_id=a.region_id");
		$this->db->join("adm_pos c","c.pos_id=a.pos_code");
		$this->db->join("adm_dept d","d.dept_id=a.dept_code");

		return $this->db->get("adm_master_mdiv a");
	}

	public function updateMasterMdiv($id="", $data=array()){

		if(!empty($id)){

			return $this->db->where("amm_id", $id)->update("adm_master_mdiv", $data);
		}
	}

	public function getVendorVsi($id="", $template="", $vendor=""){

		if (!empty($id))
		{
			$this->db->where("vvq_id", $id);
		}
		if (!empty($template))
		{
			$this->db->where("template_id", $template);
		} else
		{
			$this->db->where("vendor_code", $vendor);
		}
		return $this->db->get("vnd_vsi_quest");
	}

	public function getVendorVsiPeriodeYear($id="", $template="", $vendor="",$periode="",$year=""){

		if (!empty($id))
		{
			$this->db->where("vvq_id", $id);
		}
		if (!empty($periode))
		{
			$this->db->where("periode_number", $periode);
		}
		if (!empty($year))
		{
			$this->db->where("periode_year", $year);
		}
		if (!empty($template))
		{
			$this->db->where("template_id", $template);
		}

		if(!empty($vendor))
		{
			$this->db->where("vendor_code", $vendor);
		}

		return $this->db->get("vnd_vsi_quest");
	}

	public function getVendorVsiKues($id="", $quest="", $head=""){

		if (!empty($id))
		{
			$this->db->where("vvk_id", $id);
		}
		if (!empty($quest))
		{
			$this->db->where("questmaster_id", $quest);
		}
		if (!empty($head))
		{
			$this->db->where("vvk_quest_header", $head);
		}
		return $this->db->get("vnd_vsi_kuesioner");
	}

	// adm vpi baru
	//hasil mutu pekerjaan
	public function addHasilMutuPekerjaan($data=array()){
		$insert = $this->db->insert_batch('adm_vpi_hasil_mutu_pekerjaan', $data);
		return $insert;
	}

	public function updateHasilMutuPekerjaan($id,$data=array(),$type){
		$this->db->group_start();
		$this->db->where('ahm_type', $type);
		$this->db->where('ahm_id', $id);
		$this->db->group_end();
		$this->db->update('adm_vpi_hasil_mutu_pekerjaan', $data);
	}

	public function getHasilMutuPekerjaan($id="",$type){

		$this->db->where('ahm_type', $type);
		if(!empty($id)){

			$this->db->where("ahm_id",$id);

		}
		$this->db->order_by('ahm_seq', 'asc');
		$this->db->where('ahm_status_name', 'Aktif');

		return $this->db->get("vw_adm_vpi_hasil_mutu_pekerjaan");
	}

	public function NonaktifHasilMutuPekerjaan($id=array(),$type){

		$this->db->where('ahm_type', $type);
		$this->db->where_in("ahm_id",$id);

		$this->db->update("adm_vpi_hasil_mutu_pekerjaan", array("ahm_status"=>"N"));
	}


	public function ActivateHasilMutuPekerjaan($id=array(),$type){

		$this->db->where('ahm_type', $type);
		$this->db->where_in("ahm_id",$id);

		$this->db->update("adm_vpi_hasil_mutu_pekerjaan", array("ahm_status"=>"A"));
	}

	//template k3l
	public function addK3l($data=array()){
		$insert = $this->db->insert_batch('adm_vpi_k3l', $data);
		return $insert;
	}

	public function updateK3l($id,$data=array(),$type){
		$this->db->group_start();
		$this->db->where('ak_type', $type);
		$this->db->where('ak_id', $id);
		$this->db->group_end();
		$this->db->update('adm_vpi_k3l', $data);
	}

	public function getK3l($id="",$type){

		$this->db->where('ak_type', $type);
		if(!empty($id)){

			$this->db->where("ak_id",$id);

		}

		$this->db->order_by('ak_seq', 'asc');
		return $this->db->get("vw_adm_vpi_k3l");
	}

	public function NonaktifK3l($id=array(),$type){

		$this->db->where('ak_type', $type);
		$this->db->where_in("ak_id",$id);

		$this->db->update("adm_vpi_k3l", array("ak_status"=>"N"));
	}

	public function ActivateK3l($id=array(),$type){

		$this->db->where('ak_type', $type);
		$this->db->where_in("ak_id",$id);

		$this->db->update("adm_vpi_k3l", array("ak_status"=>"A"));
	}

	//template 5r
	public function add5r($data=array()){
		$insert = $this->db->insert_batch('adm_vpi_5r', $data);
		return $insert;
	}

	public function update5r($id,$data=array(),$type){
		$this->db->group_start();
		$this->db->where('ar_type', $type);
		$this->db->where('ar_id', $id);
		$this->db->group_end();
		$this->db->update('adm_vpi_5r', $data);
	}

	public function get5r($id="",$type){

		$this->db->where('ar_type', $type);
		if(!empty($id)){

			$this->db->where("ar_id",$id);

		}
		$this->db->order_by('ar_seq', 'asc');
		return $this->db->get("vw_adm_vpi_5r");
	}

	public function Nonaktif5r($id=array(),$type){

		$this->db->where('ar_type', $type);
		$this->db->where_in("ar_id",$id);

		$this->db->update("adm_vpi_5r", array("ar_status"=>"N"));
	}

	public function Activate5r($id=array(),$type){
		$this->db->where('ar_type', $type);
		$this->db->where_in("ar_id",$id);

		$this->db->update("adm_vpi_5r", array("ar_status"=>"A"));
	}

	//template pengamanan
	public function addPengamanan($data=array()){
		$insert = $this->db->insert_batch('adm_vpi_pengamanan', $data);
		return $insert;
	}

	public function updatePengamanan($id,$data=array(),$type){
		$this->db->group_start();
		$this->db->where('ap_type', $type);
		$this->db->where('ap_id', $id);
		$this->db->group_end();
		$this->db->update('adm_vpi_pengamanan', $data);
	}

	public function getPengamanan($id="",$type){
		$this->db->where('ap_type', $type);
		if(!empty($id)){

			$this->db->where("ap_id",$id);

		}
		$this->db->order_by('ap_seq', 'asc');
		return $this->db->get("vw_adm_vpi_pengamanan");
	}

	public function NonaktifPengamanan($id=array(),$type){

		$this->db->where('ap_type', $type);
		$this->db->where_in("ap_id",$id);

		$this->db->update("adm_vpi_pengamanan", array("ap_status"=>"N"));
	}

	public function ActivatePengamanan($id=array(),$type){

		$this->db->where('ap_type', $type);
		$this->db->where_in("ap_id",$id);

		$this->db->update("adm_vpi_pengamanan", array("ap_status"=>"A"));
	}

	//pelayanan
	public function addAspekPenilaianPelayanan($data=array()){
		$insert = $this->db->insert_batch('adm_aspek_penilaian_pelayanan', $data);
		return $insert;
	}

	public function updateAspekPenilaianPelayanan($id,$data=array()){
		$this->db->where('app_id', $id);
		$this->db->update('adm_aspek_penilaian_pelayanan', $data);
	}

	public function getAspekPenilaianPelayanan($id=""){

		if(!empty($id)){

			$this->db->where("app_id",$id);

		}
		$this->db->order_by('app_seq', 'asc');
		return $this->db->get("vw_adm_aspek_penilaian_pelayanan");
	}

	public function NonaktifAspekPenilaianPelayanan($id=array()){

		$this->db->where_in("app_id",$id);

		$this->db->update("adm_aspek_penilaian_pelayanan", array("app_status"=>"N"));
	}

	public function ActivateAspekPenilaianPelayanan($id=array()){

		$this->db->where_in("app_id",$id);

		$this->db->update("adm_aspek_penilaian_pelayanan", array("app_status"=>"A"));
	}


	public function getJenis($id = ""){

		if(!empty($id)){
			$this->db->where("acj_id",$id);
		}

		$this->db->order_by("acj_name","asc");

		return $this->db->get("adm_cot_jenis");

	}
	public function getKelompok($id = ""){

		if(!empty($id)){
			$this->db->where("ack_id",$id);
		}

		$this->db->order_by("ack_name","asc");

		return $this->db->get("adm_cot_kelompok");

	}

	public function getHasilKompilasi(){

		return $this->db->select("periode, template_id, atk_name")->distinct()->join("adm_vsi_template_kuesioner x", "x.atk_id=y.template_id", "left")->get("vnd_vsi_quest y");
	}


}
