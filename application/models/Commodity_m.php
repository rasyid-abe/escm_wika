<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commodity_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getSourcing($id = ""){

		if(!empty($id)){

			$this->db->where("sourcing_id",$id);

		}

		return $this->db->get("com_sourcing");

	}

	public function getMatCatalog($id = ""){

		$this->db->select("*,COALESCE(
			(
			SELECT cmp.total_cost FROM com_mat_price cmp WHERE cmc.mat_catalog_code = cmp.mat_catalog_code AND cmp.status = 'A' ORDER BY cmp.updated_datetime DESC LIMIT 1
			),0) as total_price,
			CASE cmc.status WHEN 'A' THEN 'Aktif' WHEN 'R' THEN 'Revisi' WHEN 'N' THEN 'Nonaktif' ELSE 'Belum Disetujui' END AS status_name,cmc.image",false);
		
		if(!empty($id)){

			$this->db->where("cmc.mat_catalog_code ='".$id."'");

		}

		$this->db->join("vw_com_group","vw_com_group.code_group = cmc.mat_group_code","inner");

		$this->db->where("type_group","M");

		$this->db->order_by("cmc.updated_datetime","desc");

		return $this->db->get("com_mat_catalog cmc");

	}

	public function getMatCatalogSmbd($id = "",$is_matgis = ""){

		if(!empty($id)){

			$this->db->where("cmc.mat_catalog_code ='".$id."'");

		}

		return $this->db->get("mvw_com_mat_catalog_smbd cmc");

	}
	
	public function getTiketCatalog($id = ""){

		$this->db->select("*,COALESCE(
			(
			SELECT cmp.total_cost FROM com_mat_price cmp WHERE cmc.mat_catalog_code = cmp.mat_catalog_code AND cmp.status = 'A' ORDER BY cmp.updated_datetime DESC LIMIT 1
			),0) as total_price,
			CASE status WHEN 'A' THEN 'Aktif' WHEN 'R' THEN 'Revisi' WHEN 'N' THEN 'Nonaktif' ELSE 'Belum Disetujui' END AS status_name",false);

		if(!empty($id)){

			$this->db->where("cmc.mat_catalog_code ='".$id."'");

		}

		$this->db->join("vw_com_group","vw_com_group.code_group = cmc.mat_group_code","inner");

		$where = "type_group='M' AND mat_group_code=14111801";		
		$this->db->where($where);
		$this->db->order_by("cmc.updated_datetime","desc");

		return $this->db->get("com_mat_catalog cmc");

	}

	public function getMatCatalogActive($id = ""){
		$this->db->where("status !=","N");
		return $this->getMatCatalog($id);
	}

	public function getSrvCatalog($id = ""){

		$this->db->select("*,'' as uom,COALESCE(
			(
			SELECT csp.total_price FROM com_srv_price csp WHERE csc.srv_catalog_code = csp.srv_catalog_code AND csp.status = 'A' ORDER BY csp.updated_datetime DESC LIMIT 1
			),0) as total_price,
			CASE status WHEN 'A' THEN 'Aktif' WHEN 'R' THEN 'Revisi' WHEN 'N' THEN 'Nonaktif' ELSE 'Belum Disetujui' END AS status_name",false);

		if(!empty($id)){

			$this->db->where("csc.srv_catalog_code ='".$id."'");

		}

		$this->db->join("vw_com_group","vw_com_group.code_group = csc.srv_group_code","inner");

		$this->db->where("type_group","S");

		$this->db->order_by("csc.updated_datetime","desc");

		return $this->db->get("com_srv_catalog csc");

	}

	public function getSrvCatalogSmbd($id = ""){
		
		if(!empty($id)){

			$this->db->where("csc.srv_catalog_code ='".$id."'");

		}

		return $this->db->get("mvw_com_srv_catalog_smbd csc");

	}

	public function getAllCatalogSmbd($id = "",$is_matgis = ""){

		if(!empty($id)){

			$this->db->where("cmc.catalog_code ='".$id."'");

		}

		$this->db->join("com_group_smbd","com_group_smbd.group_code = cmc.group_code");

		return $this->db->get("mvw_smbd_barang_jasa cmc");

	}

	public function getSrvCatalogActive($id = ""){
		$this->db->where("status !=","N");
		return $this->getSrvCatalog($id);
	}

	public function getMatGroup($id = ""){

		if(!empty($id)){

			$this->db->where("group_code = '$id'");

		}
		
		$this->db->select("group_code as mat_group_code, group_name as mat_group_name, group_parent as mat_group_parent, group_status as mat_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group");

		$this->db->where("group_type","M");

		$this->db->order_by("group_code,group_parent","asc");

		$this->db->order_by("updated_datetime","desc");

		return $this->db->get("com_group");

	}

	public function getMatGroupSmbd($id = ""){

		if(!empty($id)){

			$this->db->where("group_code = '$id'");

		}
		
		$this->db->select("group_code as mat_group_code, group_name as mat_group_name, group_parent as mat_group_parent,unspsc_code as unspsc_code, group_status as mat_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group,
			CASE  
			WHEN group_status = 'A' THEN 'Aktif'
			ELSE 'Belum Aktif' 
			END AS status_name, is_matgis");

		$this->db->where("group_type","M");

		$this->db->order_by("group_code,group_parent","asc");

		$this->db->order_by("updated_datetime","desc");

		return $this->db->get("com_group_smbd");

	}
	
	public function getMatGroupAll($level = ""){

		if ($level == 1) {
			$this->db->where('group_parent', ''	);
		}

		if(!empty($level)){
			
			$this->db->group_start();
			$this->db->where("CHAR_LENGTH(group_code)", $level*2, false);
			$this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+1, false);
			if($level == 4){
				$this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+2, false);
			}
			$this->db->group_end();

		}
		
		$this->db->select("group_code as mat_group_code, group_name as mat_group_name, group_parent as mat_group_parent, group_status as mat_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group");

		$this->db->where("group_type","M");

		$this->db->order_by("group_code","asc");

		return $this->db->get("com_group");

	}

	//sumberdaya
	public function getMatGroupSmbdAll($level = ""){

		if(!empty($level)){
			
			$this->db->group_start();
			$this->db->where("CHAR_LENGTH(b.group_code)", $level, false);
			// $this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+1, false);
			// if($level == 4){
			// 	$this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+2, false);
			// }
			$this->db->group_end();

		}
		
		$this->db->select("b.group_code as mat_group_code, b.group_name as mat_group_name, b.group_parent as mat_group_parent, b.group_status as mat_group_status, b.updated_datetime, b.group_code as code_group, b.group_name as name_group, b.group_type as type_group");

		$this->db->where("b.group_type","M");

		if ($level >= 3) {
			$this->db->join('com_group a', 'a.group_code = b.unspsc_code');
		}

		$this->db->order_by("b.group_code","asc");

		return $this->db->get("com_group_smbd b");

	}
	
	public function getSrvGroupAll($level = ""){

		if(!empty($level)){
			
			$this->db->group_start();
			$this->db->where("CHAR_LENGTH(group_code)", $level*2, false);
			$this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+1, false);
			if($level == 4){
				$this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+2, false);
			}
			$this->db->group_end();

		}
		
		$this->db->select("group_code as srv_group_code, group_name as srv_group_name, group_parent as srv_group_parent, group_status as srv_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group");

		$this->db->where("group_type","S");

		$this->db->order_by("group_code","asc");

		return $this->db->get("com_group");

	}

	public function getSrvGroupSmbdAll($level = ""){

		if(!empty($level)){
			
			$this->db->group_start();
			$this->db->where("CHAR_LENGTH(b.group_code)", $level, false);
			$this->db->group_end();

		}
		
		$this->db->select("b.group_code as srv_group_code, b.group_name as srv_group_name, b.group_parent as srv_group_parent, b.group_status as srv_group_status,b.updated_datetime, b.group_code as code_group, b.group_name as name_group, b.group_type as type_group");

		$this->db->where("b.group_type","S");
		if ($level >= 3) {
			$this->db->join('com_group a', 'a.group_code = b.unspsc_code');
		}

		$this->db->order_by("b.group_code","asc");

		return $this->db->get("com_group_smbd b");

	}

	public function getMatGroupActive($id = ""){

		$this->db->where("group_status","A");

		return $this->getMatGroup($id);

	}

	public function getMatSmbdGroupActive($id = ""){

		$this->db->where("group_status","A");

		return $this->getMatGroupSmbd($id);

	}

	public function getSrvGroup($id = ""){

		if(!empty($id)){

			$this->db->where("group_code = '$id'");

		}
		
		$this->db->select("group_code as srv_group_code, group_name as srv_group_name, group_parent as srv_group_parent, group_status as srv_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group");

		$this->db->where("group_type","S");

		$this->db->order_by("group_code,group_parent","asc");

		$this->db->order_by("updated_datetime","desc");

		return $this->db->get("com_group");

	}

	public function getSrvGroupSmbd($id = ""){

		if(!empty($id)){

			$this->db->where("group_code = '$id'");

		}
		
		$this->db->select("group_code as srv_group_code, group_name as srv_group_name, group_parent as srv_group_parent, group_status as srv_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group,unspsc_code,
			CASE  
			WHEN group_status = 'A' THEN 'Aktif'
			ELSE 'Belum Aktif' 
			END AS status_name, is_matgis");

		$this->db->where("group_type","S");

		$this->db->order_by("group_code,group_parent","asc");

		$this->db->order_by("updated_datetime","desc");

		return $this->db->get("com_group_smbd");

	}

	public function getSrvGroupActive($id = ""){

		$this->db->where("group_status","A");

		return $this->getSrvGroup($id);

	}

	public function getSrvSmbdGroupActive($id = ""){

		$this->db->where("group_status","A");

		return $this->getSrvGroupSmbd($id);

	}

	public function getSrvPrice($id = "", $srvcode = ""){


		if(!empty($id)){

			$this->db->where("srv_price_id",$id);

		}

		if(!empty($srvcode)){

			$this->db->where("srv_catalog_code",$srvcode);

		}

		return $this->db->get('vw_com_srv_price');

	}

	public function getSrvSmbdPrice($id = "", $srvcode = ""){

		if(!empty($id)){

			$this->db->where("srv_price_id",$id);

		}

		if(!empty($srvcode)){

			$this->db->where("srv_catalog_code",$srvcode);

		}

		return $this->db->get('vw_com_srv_price_smbd');

	}


	public function getMatPrice($id = "", $matcode = ""){

		if(!empty($id)){

			$this->db->where("mat_price_id",$id);

		}

		if(!empty($matcode)){

			$this->db->where("mat_catalog_code",$matcode);

		}

		return $this->db->get("vw_com_mat_price");

	}

		public function getMatSmbdPrice($id = "", $matcode = ""){

		if(!empty($id)){

			$this->db->where("mat_price_id",$id);

		}

		if(!empty($matcode)){

			$this->db->where("mat_catalog_code",$matcode);

		}

		return $this->db->get("vw_com_mat_price_smbd");

	}

	public function getUrutSrvCatalog($code = ""){

		$kode = "";

		if(!empty($code)){
			$this->db->where("srv_group_code ='".$code."'");
		}

		$urut = $this->getSrvCatalog()->num_rows();

		$this->db->where("srv_group_status",null);

		$group = $this->getSrvGroup($code)->row_array();

		//$kode .= $group['srv_group_code'];

		//$kode .= urut_id($urut+1,6);

		return $urut;

	}

	public function getUrutMatCatalog($code = ""){

		$kode = "";

		if(!empty($code)){
			$this->db->where("mat_group_code ='".$code."'");
		}

		$urut = $this->getMatCatalog()->num_rows();

		$this->db->where("mat_group_status",null);

		$group = $this->getMatGroup($code)->row_array();

		//$kode .= $group['mat_group_code'];

		//$kode .= urut_id($urut+1,6);

		return $urut;

	}
	
	public function getUrutMatGroup($code = ""){
		if(strlen($code) == 4){
			$this->db->select("CAST(substring(max(group_code) FROM 5 FOR 2) AS INT)+1 as urut", false);
		}
		else if(strlen($code) == 6){
			$this->db->select("CAST(substring(max(group_code) FROM 7 FOR 2) AS INT)+1 as urut", false);
		}
		else{
			$this->db->select("CAST(substring(max(group_code) FROM 8 FOR 2) AS INT)+1 as urut", false);
		}
		
		if(!empty($code)){
			$this->db->where("group_parent ='".$code."'");
		}
		
		$this->db->where("group_type", "M");
		
		$urut = $this->db->get("com_group")->row()->urut;
		
		if(empty($urut)) $urut = 1;
		
		return urut_id($urut,2);
	}
	
	public function getUrutSrvGroup($code = ""){
		if(strlen($code) == 4){
			$this->db->select("CAST(SUBSTRING(max(group_code) FROM 5 FOR 2) AS INT)+1 as urut", false);
		}
		else if(strlen($code) == 6){
			$this->db->select("CAST(SUBSTRING(max(group_code) FROM 7 FOR 2) AS INT)+1 as urut", false);
		}
		else{
			$this->db->select("CAST(SUBSTRING(max(group_code) FROM 8 FOR 2) AS INT)+1 as urut", false);
		}
		
		if(!empty($code)){
			$this->db->where("group_parent ='".$code."'");
		}
		
		$this->db->where("group_type", "S");
		
		$urut = $this->db->get("com_group")->row()->urut;
		
		if(empty($urut)) $urut = 1;
		
		return urut_id($urut,2);
	}


	public function getUrutCatalog($code = "",$smbd = ""){

		if (!empty($smbd)) {
			$mat_tbl = 'com_mat_catalog_smbd';
			$srv_tbl = 'com_srv_catalog_smbd';
			$group_tbl = 'com_group_smbd';
		}else {
			$mat_tbl = 'com_mat_catalog';
			$srv_tbl = 'com_srv_catalog';
			$group_tbl = 'com_group';
		}
		$this->db->where("group_code", $code);
		$this->db->where("group_type", "M");
		$mat = $this->db->get($group_tbl)->num_rows();
		
		$panjang = strlen($code)+1;
		
		// if($mat){
		// 	$this->db->where("mat_group_code ='".$code."'");
			
		// 	$this->db->select("CAST(SUBSTRING(max(mat_catalog_code) FROM ".$panjang." FOR 6) AS INT)+1 as urut", false);
			
		// 	$urut = $this->db->get($mat_tbl)->row()->urut;
		// }
		// else{
		// 	$this->db->where("srv_group_code ='".$code."'");
			
		// 	$this->db->select("CAST(SUBSTRING(max(srv_catalog_code) FROM ".$panjang." FOR 6) AS INT)+1 as urut", false);
			
		// 	$urut = $this->db->get($srv_tbl)->row()->urut;
		// }
		
		// if($urut < 1){
		// 	$urut = 1;
		// }

		// if (!empty($smbd)) {
		// 	$kode = $code.urut_id($urut,3);
		// }else {
		// 	$kode = $code.urut_id($urut,6);
		// }
		

		// return $kode;

		$increment = 1;
		$is_unique = 0;
		while($is_unique == 0) {
		        if($mat){
		                $this->db->where("mat_group_code ='".$code."'");
		                $this->db->select("CAST(SUBSTRING(max(mat_catalog_code) FROM ".$panjang." FOR 6) AS INT)+".$increment." as urut", false);
		                $urut = $this->db->get($mat_tbl)->row()->urut;
		        }
		        else{
		                $this->db->where("srv_group_code ='".$code."'");
		                $this->db->select("CAST(SUBSTRING(max(srv_catalog_code) FROM ".$panjang." FOR 6) AS INT)+".$increment." as urut", false);
		                $urut = $this->db->get($srv_tbl)->row()->urut;
		        }
		        if($urut < 1){
		                $urut = 1;
		        }
		        if (!empty($smbd)) {
		                $kode = $code.urut_id($urut,3);
		        }else {
		                $kode = $code.urut_id($urut,6);
		        }
		        if($mat){
		                $check = $this->db
		                ->select('mat_catalog_code')
		                ->where('mat_catalog_code', $kode)
		                ->get($mat_tbl)->num_rows();
		        }else{
		                $check = $this->db
		                ->select('srv_catalog_code')
		                ->where('srv_catalog_code', $kode)
		                ->get($srv_tbl)->num_rows();
		        }
		        $is_unique = 1;
		        if ($check > 0) {
		                $is_unique = 0;
		                $increment++;
		        }

		}

        return $kode;

	}

	public function getUnspscGroupCode($group_code){
		$this->db->where('a.group_code', $group_code);
		$this->db->select('a.unspsc_code,b.group_name,a.is_matgis');
		$this->db->join('com_group b', 'b.group_code = a.unspsc_code');
		return $this->db->get('com_group_smbd a')->row_array();
	}

	public function insertDataMatCatalog($input=array()){

		if (!empty($input)){

			$input['mat_catalog_code'] = $this->getUrutCatalog($input['mat_group_code']);
			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_mat_catalog",$input);

			if($this->db->affected_rows()){
				return $input['mat_catalog_code'];
			}

		}
		
	}

	public function insertDataMatCatalogSmbd($input=array()){

		if (!empty($input)){

			$input['mat_catalog_code'] = $this->getUrutCatalog($input['mat_group_code'],1);
			$input['updated_datetime'] = date("Y-m-d H:i:s");
			$unspsc = $this->getUnspscGroupCode($input['mat_group_code']);
			$input['mat_unspsc_group_code'] = $unspsc['unspsc_code'];

			$this->db->insert("com_mat_catalog_smbd",$input);

			if($this->db->affected_rows()){
				return $input['mat_catalog_code'];
			}

		}
		
	}

	public function insertDataMatGroup($input=array()){

		if (!empty($input)){
			
			$input["group_code"] = $input["mat_group_parent"].$this->getUrutMatGroup($input["mat_group_parent"])."A";
			
			$input["group_name"] = $input["mat_group_name"];
			unset($input["mat_group_name"]);
			
			$input["group_parent"] = $input["mat_group_parent"];
			unset($input["mat_group_parent"]);
			
			$input["group_status"] = "A";
			
			$input["group_type"] = "M";

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_group",$input);

			return $this->db->affected_rows();
		}
	}

	public function insertDataMatGroupSmbd($data=array()){
		if (!empty($data)){

			$max_id = $this->db->select_max('group_code')
			->where(array('group_parent' => $data['group_parent']))
			->get('com_group_smbd')->row_array();

			// $urut = substr($max_id['group_code'], -1)+1;
			$urut = substr($max_id['group_code'], -1);
			if ($urut == 9) {
				$urut = 'A';
			} elseif (!is_integer($urut)) {
				$urut = strtolower($urut);
				$urut++;
				$urut = strtoupper($urut);
			} else {
				$urut = substr($urut)+1;
			}

			$input['group_code'] = $data['group_parent'].$urut;
			$input['group_parent'] = $data['group_parent'];
			$input['group_name'] = $data['name'];
			$input['unspsc_code'] = $data['unspsc_code'];
			$input["group_status"] = "A";
			$input["group_type"] = "M";
			$input['updated_datetime'] = date("Y-m-d H:i:s");
			$input["is_matgis"] = $data['is_matgis'];

			$this->db->insert("com_group_smbd",$input);

			return $this->db->affected_rows();

		}
	}

	public function updateDataMatGroupSmbd($data=array()){
		if (!empty($data)){

			$this->db->trans_begin();

			$this->db->select('group_status');
			$this->db->where('group_parent', substr($data['group_code'], 0,1));
			$lvl1_status = $this->db->get('com_group_smbd')->row()->group_status;

			if ($lvl1_status = 'A') {
					$input = array(
					'updated_datetime' => date("Y-m-d H:i:s"),
					'group_status' => 'A'
				);
				$this->db->where('group_code', $lvl1_status);
				$this->db->update("com_group_smbd",$input);
			}

			$this->db->select('group_status');
			$this->db->where('group_parent', substr($data['group_code'], 0,2));
			$lvl2_status = $this->db->get('com_group_smbd')->row()->group_status;

			if ($lvl2_status = 'A') {
					$input = array(
					'updated_datetime' => date("Y-m-d H:i:s"),
					'group_status' => 'A'
				);
				$this->db->where('group_code', $lvl2_status);
				$this->db->update("com_group_smbd",$input);
			}

			$this->db->where('group_code', $data['group_code']);
			$input = array(
				'unspsc_code'=> $data['unspsc_code'],
				'group_name'=> $data['group_name'],
				'updated_datetime' => date("Y-m-d H:i:s"),
				'group_status' => 'A'
			);

			$this->db->update("com_group_smbd",$input);

			if ($this->db->trans_status() === FALSE)
			{
			  $this->db->trans_rollback();
			}
			else
			{
			  $this->db->trans_commit();
			}

			return $this->db->affected_rows();

		}
	}

	public function insertDataSrvGroupSmbd($data=array()){
		if (!empty($data)){

			$max_id = $this->db->select_max('group_code')
			->where(array('group_parent' => $data['group_parent']))
			->get('com_group_smbd')->row_array();

			// $urut = substr($max_id['group_code'], -1)+1;
			$urut = substr($max_id['group_code'], -1);
			if ($urut == 9) {
				$urut = 'A';
			} elseif (!is_integer($urut)) {
				$urut = strtolower($urut);
				$urut++;
				$urut = strtoupper($urut);
			}else {
				$urut = substr($urut)+1;
			}

			$input['group_code'] = $data['group_parent'].$urut;
			$input['group_parent'] = $data['group_parent'];
			$input['group_name'] = $data['name'];
			$input['unspsc_code'] = $data['unspsc_code'];
			$input["group_status"] = "A";
			$input["group_type"] = "S";
			$input['updated_datetime'] = date("Y-m-d H:i:s");
			$input["is_matgis"] = $data['is_matgis'];

			$this->db->insert("com_group_smbd",$input);

			return $this->db->affected_rows();

		}
	}

		public function updateDataSrvGroupSmbd($data=array()){
		if (!empty($data)){

			$this->db->trans_begin();

			$this->db->select('group_status');
			$this->db->where('group_parent', substr($data['group_code'], 0,1));
			$lvl1_status = $this->db->get('com_group_smbd')->row()->group_status;

			if ($lvl1_status != 'A') {
					$input = array(
					'updated_datetime' => date("Y-m-d H:i:s"),
					'group_status' => 'A'
				);

				$this->db->update("com_group_smbd",$input);
			}

			$this->db->select('group_status');
			$this->db->where('group_parent', substr($data['group_code'], 0,2));
			$lvl2_status = $this->db->get('com_group_smbd')->row()->group_status;

			if ($lvl2_status != 'A') {
					$input = array(
					'updated_datetime' => date("Y-m-d H:i:s"),
					'group_status' => 'A'
				);

				$this->db->update("com_group_smbd",$input);
			}

			$this->db->where('group_code', $data['group_code']);
			$input = array(
				'unspsc_code'=> $data['unspsc_code'],
				'updated_datetime' => date("Y-m-d H:i:s"),
				'group_status' => 'A'
			);

			$this->db->update("com_group_smbd",$input);

			if ($this->db->trans_status() === FALSE)
			{
			  $this->db->trans_rollback();
			}
			else
			{
			  $this->db->trans_commit();
			}

			return $this->db->affected_rows();

		}
	}

	public function insertDataSrvCatalog($input=array()){

		if (!empty($input)){

			$input['srv_catalog_code'] = $this->getUrutCatalog($input['srv_group_code']);
			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_srv_catalog",$input);

			if($this->db->affected_rows()){
				return $input['srv_catalog_code'];
			}

		}
	}

	public function insertDataSrvCatalogSmbd($input=array()){

		if (!empty($input)){

			$input['srv_catalog_code'] = $this->getUrutCatalog($input['srv_group_code'],1);
			$input['updated_datetime'] = date("Y-m-d H:i:s");
			$unspsc = $this->getUnspscGroupCode($input['srv_group_code']);
			$input['srv_unspsc_group_code'] = $unspsc['unspsc_code'];

			$this->db->insert("com_srv_catalog_smbd",$input);

			if($this->db->affected_rows()){
				return $input['srv_catalog_code'];
			}

		}
	}

	public function insertDataSrvGroup($input=array()){

		if (!empty($input)){

			$input["group_code"] = $input["srv_group_parent"].$this->getUrutSrvGroup($input["srv_group_parent"])."A";
			
			$input["group_name"] = $input["srv_group_name"];
			unset($input["srv_group_name"]);
			
			$input["group_parent"] = $input["srv_group_parent"];
			unset($input["srv_group_parent"]);
			
			$input["group_status"] = "A";
			
			$input["group_type"] = "S";
			
			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_group",$input);

			return $this->db->affected_rows();
		}
	}

	public function insertDataMatPrice($input=array()){

		if (!empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_mat_price",$input);

			$last_id = $this->db->insert_id();

			if($this->db->affected_rows()){
				return $last_id;
			}
			
		}
	}

		public function insertDataMatSmbdPrice($input=array()){

		if (!empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_mat_price_smbd",$input);

			$last_id = $this->db->insert_id();

			if($this->db->affected_rows()){
				return $last_id;
			}
			
		}
	}

	public function insertDataSrvPrice($input=array()){

		if (!empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_srv_price",$input);

			$last_id = $this->db->insert_id();

			if($this->db->affected_rows()){
				return $last_id;
			}
		}
	}

	public function insertDataSrvSmbdPrice($input=array()){

		if (!empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_srv_price_smbd",$input);

			$last_id = $this->db->insert_id();

			if($this->db->affected_rows()){
				return $last_id;
			}
		}
	}

	public function insertDataSourcing($input=array()){

		if (!empty($input)){

			$this->db->insert("com_sourcing",$input);

			return $this->db->affected_rows();
		}
	}

	public function push_sumberdaya($smbd_code,$type){

		$headers = array(
			"Content-Type: application/json",
		    "cache-control: no-cache"
		);
		if (THIS_ENV == 'DEV') {
			$url = 'http://10.4.0.42/apirest/index.php/sumberdaya';
		}elseif (THIS_ENV == 'PROD') {
			$url = 'http://e-accounting-dc.wika.co.id/apirest/index.php/sumberdaya';
		}

		if ($type == 'mat') {
			$this->db->select('group_name');
			$this->db->where('group_parent', substr($smbd_code, 0, 1)."0");
			$this->db->join('com_group_smbd b', 'b.group_code = a.mat_group_code', 'right');
			$data = $this->db->get('com_mat_catalog_smbd a')->row_array();
			$tipe_sumberdaya = $data['group_name'];
			if ($tipe_sumberdaya == 'subkont') {
				$tipe_sumberdaya == 'subkontraktor';
			}

			// $this->db->select('a.mat_catalog_code, a.mat_group_code, a.long_description as mat_catalog_name, b.group_name');
			// $this->db->where('mat_catalog_code', $smbd_code);
			// $this->db->join('com_group_smbd b', 'b.group_code = a.mat_group_code', 'left');
			// $catalog_data = $this->db->get('com_mat_catalog_smbd a')->row_array();
			$this->db->select("a.group_code, a.group_name, a.group_parent as kode_jenis_sumberdaya, b.group_name as nama_jenis_sumberdaya, COALESCE(b.is_matgis, 'f') as is_matgis");
			$this->db->join('com_group_smbd b', 'b.group_code = a.group_parent');
			$this->db->where('a.group_code', substr($smbd_code, 0, 3));
			$catalog_data = $this->db->get('com_group_smbd a')->row_array();

			$send_data = array(
				"kode_master_sumberdaya" => $catalog_data['group_code'],
				"nama_master_sumberdaya" => $catalog_data['group_name'],
				"kode_jenis_sumberdaya" => $catalog_data['kode_jenis_sumberdaya'],
				"nama_jenis_sumberdaya" => $catalog_data['nama_jenis_sumberdaya'],
				"tipe_sumberdaya" => $tipe_sumberdaya,
				"is_matgis" => $catalog_data['is_matgis']
			);

		}elseif ($type == 'srv') {
			$this->db->select('group_name');
			$this->db->where('group_parent', substr($smbd_code, 0, 1)."0");
			$this->db->join('com_group_smbd b', 'b.group_code = a.srv_group_code', 'right');
			$data = $this->db->get('com_srv_catalog_smbd a')->row_array();
			$tipe_sumberdaya = $data['group_name'];
			if ($tipe_sumberdaya == 'subkont') {
				$tipe_sumberdaya == 'subkontraktor';
			}

			// $this->db->select('a.srv_catalog_code, a.srv_group_code, a.long_description as srv_catalog_name, b.group_name');
			// $this->db->where('srv_catalog_code', $smbd_code);
			// $this->db->join('com_group_smbd b', 'b.group_code = a.srv_group_code', 'left');
			// $catalog_data = $this->db->get('com_srv_catalog_smbd a')->row_array();

			$this->db->select("a.group_code, a.group_name, a.group_parent as kode_jenis_sumberdaya, b.group_name as nama_jenis_sumberdaya, COALESCE(b.is_matgis, 'f') as is_matgis");
			$this->db->join('com_group_smbd b', 'b.group_code = a.group_parent');
			$this->db->where('a.group_code', substr($smbd_code, 0, 3));
			$catalog_data = $this->db->get('com_group_smbd a')->row_array();

			$send_data = array(
				"kode_master_sumberdaya" => $catalog_data['group_code'],
				"nama_master_sumberdaya" => $catalog_data['group_name'],
				"kode_jenis_sumberdaya" => $catalog_data['kode_jenis_sumberdaya'],
				"nama_jenis_sumberdaya" => $catalog_data['nama_jenis_sumberdaya'],
				"tipe_sumberdaya" => $tipe_sumberdaya,
				"is_matgis" => $catalog_data['is_matgis']
			);
		}

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => "",
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 30,
		  CURLOPT_CUSTOMREQUEST => "POST",
		  CURLOPT_POSTFIELDS => json_encode($send_data),
		  CURLOPT_HTTPHEADER => array(
		    "Content-Type: application/json",
		    "cache-control: no-cache"
		  ),
		));

		return json_decode(curl_exec($curl),true);
		// $err = curl_error($curl);

		curl_close($curl);

	}


	public function updateDataMatCatalog($id, $input = array(),$isSmbd = ''){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");
			
			if (!empty($isSmbd)) {
				
				if(isset($input['mat_group_code'])){
				$input['mat_catalog_code'] = $this->getUrutCatalog($input['mat_group_code'],1);
				}

				$this->db->where("mat_catalog_code = '".$id."'")->update('com_mat_catalog_smbd',$input);

			}else{

				if(isset($input['mat_group_code'])){
				$input['mat_catalog_code'] = $this->getUrutCatalog($input['mat_group_code']);
				}

				$this->db->where("mat_catalog_code = '".$id."'")->update('com_mat_catalog',$input);

			} 
			

			if(isset($input['mat_group_code'])){
				return $input['mat_catalog_code'];
			}
			else{
				return $this->db->affected_rows();
			}

		}

	}

	public function updateDataSrvCatalog($id, $input = array(), $isSmbd=""){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			if (!empty($isSmbd)) {
				
				if(isset($input['srv_group_code'])){
				$input['srv_catalog_code'] = $this->getUrutCatalog($input['srv_group_code'],1);
				}

				$this->db->where("srv_catalog_code = '".$id."'")->update('com_srv_catalog_smbd',$input);

			}else{
			
				if(isset($input['srv_group_code'])){
					$input['srv_catalog_code'] = $this->getUrutCatalog($input['srv_group_code']);
				}

				$this->db->where("srv_catalog_code = '".$id."'")->update('com_srv_catalog',$input);
			}

			if(isset($input['srv_group_code'])){
				return $input['srv_catalog_code'];
			}
			else{
				return $this->db->affected_rows();
			}

		}

	}

	public function updateDataMatGroup($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where("group_code = '$id'")->update('com_group',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataSrvGroup($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where("group_code = '$id'")->update('com_group',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataMatPrice($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where('mat_price_id',$id)->update('com_mat_price',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataMatSmbdPrice($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where('mat_price_id',$id)->update('com_mat_price_smbd',$input);

			return $this->db->affected_rows();

		}

	}
	
	public function updateDataSrvPrice($id, $input = array()){

		if(!empty($id) && !empty($input)){
 
			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where('srv_price_id',$id)->update('com_srv_price',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataSrvSmbdPrice($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where('srv_price_id',$id)->update('com_srv_price_smbd',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataSourcing($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('sourcing_id',$id)->update('com_sourcing',$input);

			return $this->db->affected_rows();

		}

	}
	
	public function deleteDataMatCatalog($id = ""){

		if (!empty($id)){
			
			//$this->db->where('mat_catalog_code',$id)->delete('com_mat_catalog');

			$this->db->where("mat_catalog_code = '$id'")->update('com_mat_catalog',array("status"=>"N"));
			
			return $this->db->affected_rows();
		}
	}

	public function deleteDataMatCatalogSmbd($id = ""){

		if (!empty($id)){
			
			//$this->db->where('mat_catalog_code',$id)->delete('com_mat_catalog');

			$this->db->where("mat_catalog_code = '$id'")->update('com_mat_catalog_smbd',array("status"=>"N"));
			
			return $this->db->affected_rows();
		}
	}

	public function deleteDataSrvCatalog($id = ""){

		if (!empty($id)){
			
			//$this->db->where('srv_catalog_code',$id)->delete('com_srv_catalog');
			
			$this->db->where("srv_catalog_code = '$id'")->update('com_srv_catalog',array("status"=>"N"));

			return $this->db->affected_rows();
		}

	}

	public function deleteDataSrvCatalogSmbd($id = ""){

		if (!empty($id)){
			
			//$this->db->where('srv_catalog_code',$id)->delete('com_srv_catalog');
			
			$this->db->where("srv_catalog_code = '$id'")->update('com_srv_catalog_smbd',array("status"=>"N"));

			return $this->db->affected_rows();
		}

	}

	public function deleteDataMatGroup($id = ""){

		if (!empty($id)){
			
			$this->db->where("group_code = '$id'")->delete('com_group');
			
			return $this->db->affected_rows();
		}
		
	}

	public function deleteDataSrvPrice($id = ""){

		if (!empty($id)){
			
			$this->db->where('srv_price_id',$id)->delete('com_srv_price');
			
			return $this->db->affected_rows();
		}
		
	}

	public function deleteDataSourcing($id = ""){

		if (!empty($id)){
			
			$this->db->where('sourcing_id',$id)->delete('com_sourcing');
			
			return $this->db->affected_rows();
		}
		
	}

	public function getSrvGroupName($id){

		$data = $this->db->where("group_code = '$id'")->get("com_group")->row_array();

		return (isset($data['group_name'])) && (!empty($data['group_name'])) ? $data['group_name'] : "";
		
	}

	public function getMatGroupName($id){

		$data = $this->db->where("group_code = '$id'")->get("com_group")->row_array();

		return (isset($data['group_name'])) && (!empty($data['group_name'])) ? $data['group_name'] : "";
		
	}
	
	public function getSourcingName($id){

		$data = $this->db->where("sourcing_id",$id)->get("com_sourcing")->row_array();

		return (isset($data['sourcing_name'])) && (!empty($data['sourcing_name'])) ? $data['sourcing_name'] : "";
		
	}

	public function getMatLevelGroupList($id){

		$data = array();

		while (!empty($id)) {
			$group = $this->getMatGroup($id)->row_array();
			$data[] = $group;
			$id = $group['mat_group_parent'];
		}

		return array_reverse($data);

	}

	public function getMatSmbdLevelGroupList($id){

		$data = array();

		while (!empty($id)) {

			$group = $this->getMatGroupSmbd($id)->row_array();
			$data[] = $group;
			$id = $group['mat_group_parent'];

		}

		return array_reverse($data);

	}

	public function getMatLevelName($id){
		$data = $this->getMatLevelGroupList($id);
		$name = "";
		foreach ($data as $key => $value) {
			$name .= $value['mat_group_name'];
			$name .= ($key == count($data)-1) ? "" : " > ";
		}
		return $name;
	}

	public function getSrvLevelGroupList($id){

		$data = array();

		while (!empty($id)) {
			$group = $this->getSrvGroup($id)->row_array();
			$data[] = $group;
			$id = $group['srv_group_parent'];
		}

		return array_reverse($data);

	}

	public function getSrvSmbdLevelGroupList($id){

		$data = array();

		while (!empty($id)) {
			$group = $this->getSrvGroupSmbd($id)->row_array();
			$data[] = $group;
			$id = $group['srv_group_parent'];
		}

		return array_reverse($data);

	}

	public function getSrvLevelName($id){
		$data = $this->getSrvLevelGroupList($id);
		$name = "";
		foreach ($data as $key => $value) {
			$name .= $value['srv_group_name'];
			$name .= ($key == count($data)-1) ? "" : " > ";
		}
		return $name;
	}

	//start barang
	public function insertMatHist($matcode,$isSmbd=""){
		if (!empty($isSmbd)) {
			$table = 'com_mat_price_smbd';
		}else{
			$table = 'com_mat_price';
		}
		$data = $this->db->where("mat_catalog_code", $matcode)->get($table)->row_array();
		// foreach ($data as $key => $value) {
		// 	$input[$key] = $value;
		// }
		$input['mat_price_id'] = $data['mat_price_id'];
		$input['mat_catalog_code'] = $data['mat_catalog_code'];
		$input['short_description'] = $data['short_description'];
		$input['long_description'] = $data['long_description'];
		$input['del_point_id'] = $data['del_point_id'];
		$input['del_point_name'] = $data['del_point_name'];
		$input['sourcing_date'] = $data['sourcing_date'];
		$input['sourcing_id'] = $data['sourcing_id'];
		$input['currency'] = $data['currency'];
		$input['unit_price'] = $data['unit_price'];
		$input['handling_cost'] = $data['handling_cost'];
		$input['insurance_cost'] = $data['insurance_cost'];
		$input['freight_cost'] = $data['freight_cost'];
		$input['tax_duty'] = $data['tax_duty'];
		$input['total_cost'] = $data['total_cost'];
		$input['discount'] = $data['discount'];
		$input['vendor'] = $data['vendor'];
		$input['notes'] = $data['notes'];
		$input['is_active'] = $data['is_active'];
		$input['status'] = $data['status'];
		$input['update_by'] = $data['update_by'];
		$input['update_by_user'] = $data['update_by_user'];
		$input['attachment'] = $data['attachment'];
		$input['updated_datetime'] = $data['updated_datetime'];
		$input['mat_unspsc_group_code'] = isset($data['unspsc_group_code']) AND !empty($data['unspsc_group_code']) ? $data['unspsc_group_code'] : null ;
		$input['mat_unspsc_group_name'] = isset($data['unspsc_group_name']) AND !empty($data['unspsc_group_name']) ? $data['unspsc_group_name'] : null ;
		$input['thn_pengadaan'] = $data['thn_pengadaan'];
		$input['dept'] = $data['dept'];
		$input['location'] = $data['location'];
		$input['duration'] = $data['duration'];
		

		$this->db->insert("com_mat_hist", $input);
	}

	public function getMatHist($id){
		return $this->db->where("mat_price_id", $id)->get("com_mat_hist");
	}

	public function getMatHistDat($id){
		return $this->db->where("cmh_id", $id)->get("com_mat_hist");
	}

	public function getMatDat($id){
		return $this->db->where("mat_price_id", $id)->get("com_mat_price");
	}

	public function getMatDatSmbd($id){
		return $this->db->where("mat_price_id", $id)->get("com_mat_price_smbd");
	}

	public function newPrice($tenary, $matcode, $input,$isSmbd=""){
		if (!empty($isSmbd)) {
			$table = 'com_mat_price_smbd';
		}else{
			$table = 'com_mat_price';
		}
		if ($tenary == NULL) {
			return $this->db->insert($table, $input);
		}
		else{
			$this->insertMatHist($matcode);
			return $this->db->where("mat_catalog_code", $matcode)->update($table, $input);
		}
	}
	//end barang

	//start jasa
	public function insertSrvHist($srvcode,$isSmbd=""){
		if (!empty($isSmbd)) {
			$table = 'com_srv_price_smbd';
		}else{
			$table = 'com_srv_price';
		}
		$data = $this->db->where("srv_catalog_code", $srvcode)->get($table)->row_array();
		//print_r($data);
		// foreach ($data as $key => $value) {
		// 	$input[$key] = $value;
		// }
		$input['srv_price_id'] = $data['srv_price_id'];
		$input['srv_catalog_code'] = $data['srv_catalog_code'];
		$input['short_description'] = $data['short_description'];
		$input['long_description'] = $data['long_description'];
		$input['del_point_id'] = $data['del_point_id'];
		$input['del_point_name'] = $data['del_point_name'];
		$input['sourcing_date'] = $data['sourcing_date'];
		$input['sourcing_id'] = $data['sourcing_id'];
		$input['currency'] = $data['currency'];
		$input['total_price'] = $data['total_price'];
		$input['vendor'] = $data['vendor'];
		$input['notes'] = $data['notes'];
		$input['is_active'] = $data['is_active'];
		$input['status'] = $data['status'];
		$input['updated_by'] = $data['update_by'];
		$input['updated_by_user'] = $data['update_by_user'];
		$input['attachment'] = $data['attachment'];
		$input['updated_datetime'] = $data['updated_datetime'];
		$input['srv_unspsc_group_code'] = isset($data['unspsc_group_code']) AND !empty($data['unspsc_group_code']) ? $data['unspsc_group_code'] : null ;
		$input['srv_unspsc_group_name'] = isset($data['unspsc_group_name']) AND !empty($data['unspsc_group_name']) ? $data['unspsc_group_name'] : null ;
		$input['thn_pengadaan'] = $data['thn_pengadaan'];
		$input['dept'] = $data['dept'];
		$input['location'] = $data['location'];
		$input['duration'] = $data['duration'];
		
		$this->db->insert("com_srv_hist", $input);
	}

	public function getSrvHist($id){
		return $this->db->where("srv_price_id", $id)->get("com_srv_hist");
	}

	public function getSrvHistDat($id){
		return $this->db->where("csh_id", $id)->get("com_srv_hist");
	}

	public function getSrvDat($id){
		return $this->db->where("srv_price_id", $id)->get("com_srv_price");
	}

	public function getSrvSmbdDat($id){
		return $this->db->where("srv_price_id", $id)->get("com_srv_price_smbd");
	}

	public function newSrvPrice($tenary, $srvcode, $input,$isSmbd=""){
		if (!empty($isSmbd)) {
			$table = "com_srv_price_smbd";
			//echo "test3";
			//print_r($input);
		}else{
			$table="com_srv_price";
			//echo "test2";
			//print_r($input);
		}
		if (empty($tenary)) {
			//echo "test";
			return $this->db->insert($table, $input);
		}
		else{
			//echo "test";
			//print_r($input);
			//$this->insertSrvHist($srvcode);
			return $this->db->where("srv_catalog_code", $srvcode)->update($table, $input);
		}
	}
	//end jasa

}