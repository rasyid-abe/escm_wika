<?php 

$view = "vendor/vendor_tools/vendor_action_form";

$tenary = $this->Comment_m->getVendor($id, null)->row_array();

$vendor = $this->Vendor_m->getVendor($id)->row_array();

$activity_id = 6092;

$comment_list = $this->Comment_m->getVendor($id, null)->result_array();

$activity = $this->Workflow_m->getActivity($activity_id)->row_array();

$query = $this->db->where('vendor_id', $id)->get('vnd_header')->row_array();

if ($query['survey_recom'] != NULL) {
	$survey = [
		'y' => 'iradio_square-green ysurvei checked',
		'n' => 'iradio_square-green nsurvei'
	];
}else{
	$survey = [
		'y' => 'iradio_square-green ysurvei',
		'n' => 'iradio_square-green nsurvei checked'
	];
}
$data['url'] = "vendor/submit_hasil_survei_vendor";

$data['survey'] = $survey;

$data['data'] = $query;

$data['id'] = $id;

$data['activity_id'] = $activity_id;

$data['comment'] = (!empty($tenary['comment_id'])) ? $tenary['comment_id'] : null;

$data['comment_list'][0] = $comment_list;

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Workflow_m->getResponseList($activity_id);

$data['district'] = $this->Administration_m->getDistrict()->result_array();


$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);