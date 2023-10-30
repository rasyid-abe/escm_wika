<?php 

$view = "vendor/vendor_tools/vendor_action_form";

$tenary = $this->Comment_m->getVendor($id, null)->row_array();

$vendor = $this->Vendor_m->getVendor($id)->row_array();

$activity_id = 6090;

$comment_list = $this->Comment_m->getVendor($id, null)->result_array();

$activity = $this->Workflow_m->getActivity($activity_id)->row_array();

$this->db->where('vendor_id', $id);
$query = $this->db->get('vnd_header');

$data['vendor_type'] =  $this->Vendor_m->getVndType()->result_array();

$data['url'] = "vendor/submit_verifikasi_vendor";

$data['data'] = $query->row_array();

$data['id'] = $id;

$data['activity_id'] = $activity_id;

$data['comment'] = (!empty($tenary['comment_id'])) ? $tenary['comment_id'] : null;

$data['comment_list'][0] = $comment_list;

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Workflow_m->getResponseList($activity_id);

$data['district'] = $this->Administration_m->getDistrict()->result_array();


$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);