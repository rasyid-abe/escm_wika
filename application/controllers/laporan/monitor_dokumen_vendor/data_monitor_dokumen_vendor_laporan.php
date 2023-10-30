<?php 

$get = $this->input->get();

$filtering = $this->uri->segment(3, 0);

$order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "ASC";
$limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
$search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
$offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
$field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "vendor_id";


if (!empty($expired)) {
  $infoDate = date('Y-m-d', strtotime('+2 months'));
  $this->db->group_start();
  $this->db->or_where("address_domisili_exp_date <=",$infoDate);
  $this->db->or_where("siup_to <=",$infoDate);
  $this->db->or_where("tdp_to <=",$infoDate);
  $this->db->group_end();
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  // $this->db->or_like("('siup_to')::text","('$search')::text");
  // $this->db->or_like("('tdp_to')::text","('$search')::text");
  $this->db->group_end();
}


$data['total'] = $this->Vendor_m->getVendor()->num_rows();
///////////////////////////////////////////////////////// data  //////////////////////////////////////////////////////

if (!empty($expired)) {
  $infoDate = date('Y-m-d', strtotime('+2 months'));
  $this->db->group_start();
  $this->db->or_where("address_domisili_exp_date <=",$infoDate);
  $this->db->or_where("siup_to <=",$infoDate);
  $this->db->or_where("tdp_to <=",$infoDate);
  $this->db->group_end();
}

if(!empty($search)){
  $this->db->group_start();
  $this->db->like("LOWER(vendor_name)",$search);
  // $this->db->or_like('LOWER(address_domisili_exp_date::text)',$search);
  // $this->db->or_like("('siup_to')::text","('$search')::text");
  // $this->db->or_like("('tdp_to')::text","('$search')::text");
  $this->db->group_end();
}

if(!empty($order)){
  $this->db->order_by($field_order,$order);
}

if(!empty($limit)){
  $this->db->limit($limit,$offset);
}

$rows = $this->Vendor_m->getVendor()->result_array();
$sess['docVendQ'] = $this->db->last_query();
$this->session->set_userdata($sess);

foreach ($rows as $key => $value) {

  $domisiliDate = !empty($value['address_domisili_exp_date']) ? $value['address_domisili_exp_date'] : null  ;
  $siupDate     = !empty($value['siup_to']) ? $value['siup_to'] : null  ;
  $tdpDate      = !empty($value['tdp_to']) ? $value['tdp_to'] : null  ;

  $now = date("Y-m-d");
  $d1 = new DateTime($now);
  $d2 = new DateTime($domisiliDate);
  $numberDays = $d2->diff($d1)->format("%a");
 
    if ($numberDays > 60 && strtotime($domisiliDate) > strtotime($now) ){
      $labelColor = "info";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";

    } else if ($numberDays < 60 && $numberDays > 0 && strtotime($domisiliDate) > strtotime($now)){
      $labelColor = "warning";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";

    } else if(strtotime($domisiliDate) < strtotime($now)){
      $labelColor = "danger";
      $minus = "";
      $numberDays = "Sudah Kadaluarsa";
    }
  $TDPCount = '<a class="label label-'.$labelColor.'">'.$minus."".$numberDays.'</label>';
  $rows[$key]['address_domisili_exp_date'] = empty($domisiliDate) ? "-" : date('Y-m-d',strtotime($domisiliDate)).'<br/>'.$TDPCount ;
  
  
  $d1 = new DateTime($now);
  $d2 = new DateTime($siupDate);
  $numberDays =  $d2->diff($d1)->format("%a");
    if ($numberDays > 60 && strtotime($siupDate) > strtotime($now) ){
      $labelColor = "info";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";
    } else if ($numberDays < 60 && $numberDays > 0 && strtotime($siupDate) > strtotime($now)){
      $labelColor = "warning";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";

    } else if(strtotime($siupDate) < strtotime($now)){
      $labelColor = "danger";
      $minus = "";
      $numberDays = "Sudah Kadaluarsa";
    }
  $TDPCount = '<a class="label label-'.$labelColor.'">'.$minus."".$numberDays.'</label>';
  $rows[$key]['siup_to'] = empty($siupDate) ? "-" : date('Y-m-d',strtotime($siupDate)).'<br/>'.$TDPCount;

  $d1 = new DateTime($now);
  $d2 = new DateTime($tdpDate);
  $numberDays =  $d2->diff($d1)->format("%a");
    if ($numberDays > 60 && strtotime($tdpDate) > strtotime($now) ){
      $labelColor = "info";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";
    } else if ($numberDays < 60 && $numberDays > 0 && strtotime($tdpDate) > strtotime($now)){
      $labelColor = "warning";
      $minus = "";
      $numberDays = $numberDays." Hari Lagi";

    } else if(strtotime($tdpDate) < strtotime($now)){
      $labelColor = "danger";
      $minus = "";
      $numberDays = "Sudah Kadaluarsa";
    }
  $TDPCount = '<a class="label label-'.$labelColor.'">'.$minus."".$numberDays.'</label>';
  $rows[$key]['tdp_to'] = empty($tdpDate) ? "-" : date('Y-m-d',strtotime($tdpDate)).'<br/>'.$TDPCount;

}

$data['rows'] = $rows;

echo json_encode($data);