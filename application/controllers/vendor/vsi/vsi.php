<?php
  $view = 'vendor/vsi/vsi_v';
  $periode = '1';
	$year = '2020';

  $getVSIVendorList = $this->db->get('vw_vsi_vendor_list');
  $getPeriode = $this->db->get('vw_get_periode_vsi');
  $getYear = $this->db->get('vw_year_list');

  $data = array();
  $data['rows'] = $getVSIVendorList->result_array();
  $data['periode'] = $getYear->result_array();
  $data['year'] = $getYear->result_array();
  $data['vsi_summary'] = $this->Vendor_m->get_vsi_summary($periode,$year);

  $data['label_pertanyaan_kepuasan'] = $this->Vendor_m->get_pertanyaan_label(1,$periode,$year);
	$data['label_pertanyaan_kepentingan'] = $this->Vendor_m->get_pertanyaan_label(2,$periode,$year);

  $data['data_asset_line_kepuasan'] = $this->Vendor_m->get_asset_line_chart(1,$periode,$year);
	$data['data_asset_line_kepentingan'] = $this->Vendor_m->get_asset_line_chart(2,$periode,$year);
	$data['data_scatter_chart'] = $this->Vendor_m->get_dataset_scatter_chart($periode,$year);

  $data['data_satisfication_map'] = $this->Vendor_m->get_satisfacation_map($periode,$year);
  $data['score_rows'] = $this->Vendor_m->get_vsi_vendor_score($periode,$year);

  $data['card_vsi_more'] = 0;
  $data['card_vsi_less'] = 0;
  $data['card_quest'] = 0;
  $data['card_responden'] = 0;


  $data['header'] = [];
  $data['th'] = array_count_values([]);
  $data['headname'] = [];
  $data['vendor'] = [];
  $data['quest'] = [];
  $data['imp'] = [];
  $data['satis'] = [];
  $data['period'] = $periode;

  $param = $_GET;
  if(isset($param['periode']) && isset($param['year']))
  {
    $vd = $this->Administration_m->getVendorVsiPeriodeYear("","","", $param['periode'],$param['year'])->result_array();

   
    if(count($vd) > 0)
    {
    $view = 'vendor/vsi/vsi_param_v';

    $period = $vd[0]['periode'];

    foreach ($vd as $k => $v) {
      $this->db->order_by("vvk_quest_header");
      $dats[] = $this->Administration_m->getVendorVsiKues("", $v['vvq_id'])->result_array();
      // $tohead[] = $dats[0][0]['vvk_quest_header'];
    }

    foreach ($dats[0] as $key => $value) {
      $head[] = $value['vvk_quest_header'];
    }

    $hm = array_unique($head);
    foreach ($hm as $key => $value) {
      $headname[] = $value;
    }

    $isi = [];	
    $satis = [];
    $im = [];
    $imp = [];
    //line char header
    $linePertanyaan = [];

    foreach ($dats as $key => $value) {
      foreach ($value as $y => $v) {
        $isi[$y] = (int)$v['vvk_satis_score'];
        $im[$y] = (int)$v['vvk_imp_score'];
        $linePertanyaan[$y] = $v['vvk_quest_name'];
      }
      $satis[$key] = $isi;
      $imp[$key] = $im;
     
    

    }

				$allv = 0;
				$count = [];
				$vsit = 0;
        $more60 = 0;
        $less60 = 0;
        $dataLineChartImp = [];
        $dataLineChartSatis = [];

       
        //variable sheet vsi per vendor
        $vsiPerVendor = [];

				foreach ($vd as $ky => $val) {
					
							$pre = 0;
              $tot = 0;
              foreach ($dats[$ky] as $keys => $values) {
                $tot += $values['vvk_imp_score'];
                $impvend[$ky] = $tot;
                $weightimp[$keys][$ky] = $values['vvk_imp_score']/$impvend[$ky];
              }

							foreach ($weightimp as $key => $value) {
								$pre += $value[$ky];
							}
							$vsi = ($pre/4)*100;

              if($vsi > 60)
              {
                $more60 = $more60 + 1;
              } else {
                $less60 = $less60 + 1;

              }

              $vsiPerVendor[$ky]['vendor_name'] = $val['vendor_name'];
              $vsiPerVendor[$ky]['vsi_percentage'] = $vsi." %";

              $dataLineChartImp[$ky]['name'] = $val['vendor_name'];
              $dataLineChartImp[$ky]['data'] = $imp[$ky];
             

              $dataLineChartSatis[$ky]['name'] = $val['vendor_name'];
              $dataLineChartSatis[$ky]['data'] = $satis[$ky];
             



							$vsit += $vsi;
             
        }
			
				
				$average=  $vsit/count($vd);
			

    $data['card_vsi_more'] = $more60;
    $data['card_vsi_less'] = $less60;
    $data['card_quest'] = count($dats[0]) * count($vd);
    $data['card_responden'] = count($vd);

    //VSI PERCENTAGE PER VENDO
    $data['vsi_percentage_vendor'] = $vsiPerVendor;

  
    $data['header'] = $dats[0];
    $data['th'] = array_count_values([]);
    $data['headname'] = $headname;
    $data['vendor'] = $vd;
    $data['quest'] = $dats;
    $data['imp'] = $imp;
    $data['total_imp'] = $imp;

    $data['satis'] = $satis;
    $data['period'] = $periode;
    
    //line header chart
    $data['line_question'] = json_encode($linePertanyaan);
    $data['chart_imp'] = json_encode($dataLineChartImp);
    $data['chart_satis'] = json_encode($dataLineChartSatis);

    }
    


  }
  

  $this->template($view, "Laporan VSI", $data);
?>
