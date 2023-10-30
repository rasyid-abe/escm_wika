<?php 

$get = $this->input->get();

$parent = (isset($get['parent']) && !empty($get['parent'])) ? $get['parent'] : "";
$level = (isset($get['level']) && !empty($get['level'])) ? $get['level'] : "";


if(!empty($parent) || !empty($level)){
	
	if (isset($get['type']) && $get['type'] == 'smbd') {
		if (strlen($parent)== 2) {
			$this->db->where('unspsc_code !=', null);
			$this->db->where('unspsc_code !=', '');
		}
	if (!empty($parent)) {
		$this->db->where('"b"."group_parent"', $parent);
	}
	
	$rows = $this->Commodity_m->getMatGroupSmbdAll($level)->result_array();
	}else{
		if (!empty($parent)) {
			$this->db->where('group_parent', $parent);
		}
	$rows = $this->Commodity_m->getMatGroupAll($level)->result_array();
	}
}
else{
	$rows = [];
}

echo json_encode($rows);
