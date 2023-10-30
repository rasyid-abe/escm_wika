<?php 

$this->load->model("Procplan_m");

$total = 0;
$totalrkp = 0;
$totalrkap = 0;
$sum = 0;
$ldeptrkp = "";
$ldeptrkap = "";
$lma = "";
$ld = "";
$llm = "";
$llma = "";
$lld = "";
$lcoa = "";
$lldd = "";
$pdeptrkp = [];

$this->db->order_by('ppm_dept_name', 'desc');
$this->db->where_in('ppm_is_integrated', [1,2]);
$this->db->join('project_info', 'project_info.kode_spk=vw_prc_plan_main.ppm_project_id', 'left');
$this->db->join('adm_coa', 'ppm_sub_mata_anggaran=ac_coa', 'left');
$plan = $this->Procplan_m->getPerencanaanPengadaan()->result_array();

// echo $this->db->last_query();

foreach ($plan as $key => $value) {
  
  $total += $value['ppm_pagu_anggaran'];

  $dats = [
      'dept'  => $value['ppm_dept_name'],
      'spk'   => $value['ppm_project_id'],
      'plan'  => $value['ppm_project_name'],
      'jo'  => ($value['is_jo'] == "t") ? "JO" : "Non JO",
      'prov'  => $value['lokasi'],
      'val' => $value['ppm_pagu_anggaran'],
      'ma'  => $value['ac_mata_anggaran'],
      'sma' => $value['ac_sub_mata_anggaran'],
      'coa' => $value['ppm_sub_mata_anggaran'],
      'cname' => $value['ppm_nama_sub_mata_anggaran']
    ];
  
  if ($value['ppm_type_of_plan'] == "rkap") {

    if ($value['ppm_dept_name'] == $ldeptrkap) {
      $sumnp += $value['ppm_pagu_anggaran'];
    }else{
      $sumnp = $value['ppm_pagu_anggaran'];
    }

    $rkapdept[$key]['dept'] = $value['ppm_dept_name'];
    $rkapdept[$key]['sum'] = $sumnp;

    $plandept[$value['ppm_dept_name']]['rkap'][] = $dats;
    $totalrkap += $value['ppm_pagu_anggaran'];

    $perma[$key]['ma'] = $value['ac_mata_anggaran'];
    $perma[$key]['dept'] = $value['ppm_dept_name'];
    $perma[$key]['nsum'] = $value['ppm_pagu_anggaran'];

    $persma[$key]['sma'] = $value['ac_sub_mata_anggaran'];
    $persma[$key]['dept'] = $value['ppm_dept_name'];
    $persma[$key]['nsum'] = $value['ppm_pagu_anggaran'];

    $percoa[$key]['coa'] = $value['ppm_sub_mata_anggaran']." ".$value['ppm_nama_sub_mata_anggaran'];
    $percoa[$key]['dept'] = $value['ppm_dept_name'];
    $percoa[$key]['nsum'] = $value['ppm_pagu_anggaran'];

    $ldeptrkap = $value['ppm_dept_name'];
  }

  if ($value['ppm_type_of_plan'] == "rkp") {

    if ($value['ppm_dept_name'] == $ldeptrkp) {
      $sump += $value['ppm_pagu_anggaran'];
    }else{
      $sump = $value['ppm_pagu_anggaran'];
    } 

    $rkpdept[$key]['dept'] = $value['ppm_dept_name'];
    $rkpdept[$key]['sum'] = $sump;

    $plandept[$value['ppm_dept_name']]['rkp'][] = $dats;
    $totalrkp += $value['ppm_pagu_anggaran'];

    $pdeptrkp = $dats;  
    $ldeptrkp = $value['ppm_dept_name'];
  }
}

//per mata anggaran
arsort($perma);

foreach ($perma as $key => $value) {

  if ($value['ma'] == $lma ) {
    $summa += $value['nsum'];
  }else{
    $summa = $value['nsum'];
  }
  $prm[$key]['nsum'] = $value['nsum'];
  $prm[$key]['ma'] = $value['ma'];
  $prm[$key]['sum'] = $summa;
  $prm[$key]['dept'] = $value['dept'];
  $lma = $value['ma'];
}

$pr = array_reverse($prm);

foreach (array_values($pr) as $ky => $val) {
  if ($ld == $val['dept'] ) {
    $ss += $val['nsum'];

    $prsum = [
      'sum'  => $ss,
      'dept' => $val['dept']
    ];
    $perm[$val['ma']]['data'][] = $prsum;
  }else{

    $ss = $val['nsum'];

    $prsum = [
      'sum'  => $ss,
      'dept' => $val['dept']
    ];
    $perm[$val['ma']]['data'][] = $prsum;

  }
  $ld = $val['dept'];
}

//end

//per sub mata anggaran
arsort($persma);

foreach ($persma as $key => $value) {

  if ($value['sma'] == $llma ) {
    $sumsma += $value['nsum'];
  }else{
    $sumsma = $value['nsum'];
  }
  $prsm[$key]['nsum'] = $value['nsum'];
  $prsm[$key]['sma'] = $value['sma'];
  $prsm[$key]['sum'] = $sumsma;
  $prsm[$key]['dept'] = $value['dept'];
  $llma = $value['sma'];
}

$prs = array_reverse($prsm);

foreach (array_values($prs) as $ky => $val) {
  if ($lld == $val['dept'] ) {
    $sss += $val['nsum'];

    $prsmasum = [
      'sum'  => $sss,
      'dept' => $val['dept']
    ];
    $persm[$val['sma']]['data'][] = $prsmasum;
  }else{

    $sss = $val['nsum'];

    $prsmasum = [
      'sum'  => $sss,
      'dept' => $val['dept']
    ];
    $persm[$val['sma']]['data'][] = $prsmasum;

  }
  $lld = $val['dept'];
}
//end

//per coa
arsort($percoa);

foreach ($percoa as $key => $value) {

  if ($value['coa'] == $lcoa ) {
    $sumcoa += $value['nsum'];
  }else{
    $sumcoa = $value['nsum'];
  }
  $prc[$key]['nsum'] = $value['nsum'];
  $prc[$key]['coa'] = $value['coa'];
  $prc[$key]['sum'] = $sumcoa;
  $prc[$key]['dept'] = $value['dept'];
  $lcoa = $value['coa'];
}

$prsc = array_reverse($prc);

foreach (array_values($prsc) as $ky => $val) {
  if ($lldd == $val['dept'] && $lc == $val['coa']) {
    $ssss += $val['nsum'];

    $prcsum = [
      'sum'  => $ssss,
      'dept' => $val['dept']
    ];
    $perc[$val['coa']]['data'][] = $prcsum;
  }else{

    $ssss = $val['nsum'];

    $prcsum = [
      'sum'  => $ssss,
      'dept' => $val['dept']
    ];
    $perc[$val['coa']]['data'][] = $prcsum;

  }
  // var_dump($perc);
  $lldd = $val['dept'];
  $lc = $val['coa'];
}
//end
// var_dump($percoa);

$data = [
    'total'   => $total,
    'totalrkap' => $totalrkap,
    'totalrkp'  => $totalrkp,
    'rkpdept' => $rkpdept,
    'rkapdept'  => $rkapdept,
    'plandept'  => $plandept,
    'perma'   => array_values($prm),
    'perm'    => $perm, 
    'persma'  => array_values($prsm),
    'persm'   => $persm,
    'prc'   => array_values($prc),
    'perc'    => $perc  
  ];
