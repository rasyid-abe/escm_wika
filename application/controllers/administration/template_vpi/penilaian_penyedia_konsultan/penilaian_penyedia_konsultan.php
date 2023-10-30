<?php 

  $view = 'administration/template_vpi/penilaian_penyedia_konsultan/penilaian_penyedia_konsultan_v';

  //submitiing insert or update value
  $post = $this->input->post();
  if (isset($post['mode']) and $post['mode'] == 'insert') {
    
    $where_cek = array(
      "target_ketepatan_progress",
      "bobot_ketepatan_progress",
      "target_mutu_pekerjaan",
      "bobot_mutu_pekerjaan",
      "target_mutu_personal",
      "bobot_mutu_personal",
      "target_pelayanan",
      "bobot_pelayanan");
    $this->db->where_in('abt_indicator', $where_cek);
    $check = $this->Administration_m->getTargetdanBobotKompilasiVPI("","konsultan")->num_rows();

    $data_template = array(
      array(
        'abt_indicator'=>"target_ketepatan_progress",
        "abt_seq"=>1,
        "abt_value"=>replace_comma($post['target_ketepatan_progress'])
      ),
      array(
        'abt_indicator'=>"bobot_ketepatan_progress",
        "abt_seq"=>2,
        "abt_value"=>replace_comma($post['bobot_ketepatan_progress'])
      ),
      array(
        'abt_indicator'=>"target_mutu_pekerjaan",
        "abt_seq"=>3,
        "abt_value"=>replace_comma($post['target_mutu_pekerjaan'])
      ),
      array(
        'abt_indicator'=>"bobot_mutu_pekerjaan",
        "abt_seq"=>4,
        "abt_value"=>replace_comma($post['bobot_mutu_pekerjaan'])
      ),
      array(
        'abt_indicator'=>"target_mutu_personal",
        "abt_seq"=>5,
        "abt_value"=>replace_comma($post['target_mutu_personal'])
      ),
      array(
        'abt_indicator'=>"bobot_mutu_personal",
        "abt_seq"=>6,
        "abt_value"=>replace_comma($post['bobot_mutu_personal'])
      ),
      array(
        'abt_indicator'=>"target_pelayanan",
        "abt_seq"=>8,
        "abt_value"=>replace_comma($post['target_pelayanan'])
      ),
      array(
        'abt_indicator'=>"bobot_pelayanan",
        "abt_seq"=>9,
        "abt_value"=>replace_comma($post['bobot_pelayanan'])
      )
    );
   

    $this->db->trans_begin();

    foreach ($data_template as $key => $value) {

      $value['abt_type'] = "konsultan";
      $value['created_datetime'] = date('Y-m-d h:i:s');
      $value['abt_status'] = 'A';
      if ($check > 0) {
        $where['abt_type'] = $value['abt_type'];
        $where['abt_indicator'] = $value['abt_indicator'];
      }else{
        $where="";
      }
      
      $insert = $this->Administration_m->InsertTargetdanBobotKompilasiVPI($value,$where);

    }
    if ($this->db->trans_status() === FALSE)
    {
      $this->db->trans_rollback();
      $this->session->set_flashdata(array('status_submit_vpi'=>'fail','msg_submit_vpi'=>'Gagal mengubah data'));
    }
    else
    {
      $this->db->trans_commit();
      $this->session->set_flashdata(array('status_submit_vpi'=>'success','msg_submit_vpi'=>'Berhasil mengubah data'));
      redirect(site_url('administration/template_vpi/penilaian_penyedia_konsultan'));

    }

  }
  //end of submitiing insert or update value

  $data = array();

  $get_data_bobot = $this->Administration_m->getTargetdanBobotKompilasiVPI("",'konsultan')->result_array();
  $data['data_bobot'] = [];
  $arrayNew = array();

  if (empty($get_data_bobot)) {
  	$arrayNew['target_ketepatan_progress'] = 0;
  	$arrayNew['target_mutu_pekerjaan'] = 0;
  	$arrayNew['target_mutu_personal'] = 0;
  	$arrayNew['target_pelayanan'] = 0;
  	$arrayNew['bobot_ketepatan_progress'] = 0;
  	$arrayNew['bobot_mutu_pekerjaan'] = 0;
  	$arrayNew['bobot_mutu_personal'] = 0;
  	$arrayNew['bobot_pelayanan'] = 0;
  	$data['total_target'] = 0;
  	$data['total_bobot'] = 0;
  }else{

  foreach ($get_data_bobot as $key => $value) {
  	$arrayNew[$value['abt_indicator']] = str_replace('.', ',', $value['abt_value']); 
  }

  $arrayNew['target_ketepatan_progress'] = isset($arrayNew['target_ketepatan_progress']) ? $arrayNew['target_ketepatan_progress'] : 0;
  	$arrayNew['target_mutu_pekerjaan'] = isset($arrayNew['target_mutu_pekerjaan']) ? $arrayNew['target_mutu_pekerjaan'] : 0;
  	$arrayNew['target_mutu_personal'] = isset($arrayNew['target_mutu_personal']) ? $arrayNew['target_mutu_personal'] : 0;
  	$arrayNew['target_pelayanan'] = isset($arrayNew['target_pelayanan']) ? $arrayNew['target_pelayanan'] : 0;

  	$arrayNew['bobot_ketepatan_progress'] = isset($arrayNew['bobot_ketepatan_progress']) ? $arrayNew['bobot_ketepatan_progress'] : 0;
  	$arrayNew['bobot_mutu_pekerjaan'] = isset($arrayNew['bobot_mutu_pekerjaan']) ? $arrayNew['bobot_mutu_pekerjaan'] : 0;
  	$arrayNew['bobot_mutu_personal'] = isset($arrayNew['bobot_mutu_personal']) ? $arrayNew['bobot_mutu_personal'] : 0;
  	$arrayNew['bobot_pelayanan'] = isset($arrayNew['bobot_pelayanan']) ? $arrayNew['bobot_pelayanan'] : 0;

	  $total_target = array(
	  	str_replace(',', '.', $arrayNew['target_ketepatan_progress']),
	  	str_replace(',', '.', $arrayNew['target_mutu_pekerjaan']),
	  	str_replace(',', '.', $arrayNew['target_mutu_personal']),
	  	str_replace(',', '.', $arrayNew['target_pelayanan']),
	  );

	  $total_bobot = array(
	  	str_replace(',', '.', $arrayNew['bobot_ketepatan_progress']),
	  	str_replace(',', '.', $arrayNew['bobot_mutu_pekerjaan']),
	  	str_replace(',', '.', $arrayNew['bobot_mutu_personal']),
	  	str_replace(',', '.', $arrayNew['bobot_pelayanan'])
	  );

	  $data['total_target'] = array_sum($total_target);
	  $data['total_bobot'] = array_sum($total_bobot);

  }

  array_push($data['data_bobot'] , $arrayNew);
  $data['data_bobot'] = $data['data_bobot'][0];
$this->template($view,"Penilaian Penyedia Konsultan",$data);
