<?php 

$view = "vendor/vendor_tools/aktivasi_vendor_form";

$comment = $this->Comment_m->getVendor(null, $comment_id)->row_array();

$comment_list = $this->Comment_m->getVendor($comment['vendor_id'], null)->result_array();
$activity = $this->Workflow_m->getActivity($comment['activity'])->row_array();
$activity_id = (!empty($activity['awa_id'])) ? $activity['awa_id'] : 6090;
$vendor = $this->Vendor_m->getVendor($comment['vendor_id'])->row_array();
$cot = $this->Administration_m->getCot($vendor['cot_id'])->row_array();
$district = $this->Administration_m->getDistrict($vendor['district_id'])->row_array();

$data['id'] = $comment['vendor_id'];
$data['comment'] = (!empty($comment['comment_id'])) ? $comment['comment_id'] : null;
$data['comment_list'][0] = $comment_list;
$data['data'] = $vendor;
$data['data']['active'] = $comment['active'];
$data['data']['cot'] = $cot['jenis_nasabah'];
$data['data']['district'] = $district['district_name'];
$data['activity_id'] = $activity_id;
$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();
$data['workflow_list'] = $this->Workflow_m->getResponseList($activity_id);
$data['district'] = $this->Administration_m->getDistrict()->result_array();

$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);