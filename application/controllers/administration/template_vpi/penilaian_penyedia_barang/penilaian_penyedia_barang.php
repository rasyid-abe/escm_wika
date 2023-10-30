<?php 

  $view = 'administration/template_vpi/penilaian_penyedia_barang/penilaian_penyedia_barang_v';

  //submitiing insert or update value
 
  $post = $this->input->post();
  if (isset($post['mode']) and $post['mode'] == 'insert') {

    $where_cek = array(
      "target_ketepatan_progress",
      "bobot_ketepatan_progress",
      "target_hasil_mutu_pekerjaan",
      "bobot_hasil_mutu_pekerjaan",
      "target_k3l",
      "bobot_k3l",
      "target_5r",
      "bobot_5r",
      "target_pengamanan",
      "bobot_pengamanan");
    $this->db->where_in('abt_indicator', $where_cek);
    $check = $this->Administration_m->getTargetdanBobotKompilasiVPI("","barang")->num_rows();

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
        'abt_indicator'=>"target_hasil_mutu_pekerjaan",
        "abt_seq"=>3,
        "abt_value"=>replace_comma($post['target_hasil_mutu_pekerjaan'])
      ),
      array(
        'abt_indicator'=>"bobot_hasil_mutu_pekerjaan",
        "abt_seq"=>4,
        "abt_value"=>replace_comma($post['bobot_hasil_mutu_pekerjaan'])
      ),
      array(
        'abt_indicator'=>"target_k3l",
        "abt_seq"=>5,
        "abt_value"=>replace_comma($post['target_k3l'])
      ),
      array(
        'abt_indicator'=>"bobot_k3l",
        "abt_seq"=>6,
        "abt_value"=>replace_comma($post['bobot_k3l'])
      ),
      array(
        'abt_indicator'=>"target_5r",
        "abt_seq"=>7,
        "abt_value"=>replace_comma($post['target_5r'])
      ),
      array(
        'abt_indicator'=>"bobot_5r",
        "abt_seq"=>8,
        "abt_value"=>replace_comma($post['bobot_5r'])
      ),
      array(
        'abt_indicator'=>"target_pengamanan",
        "abt_seq"=>9,
        "abt_value"=>replace_comma($post['target_pengamanan'])
      ),
      array(
        'abt_indicator'=>"bobot_pengamanan",
        "abt_seq"=>10,
        "abt_value"=>replace_comma($post['bobot_pengamanan'])
      )
    );
   

    $this->db->trans_begin();

    foreach ($data_template as $key => $value) {

      $value['abt_type'] = "barang";
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
      redirect(site_url('administration/template_vpi/penilaian_penyedia_barang'));

    }

  }
  //end of submitiing insert or update value

  $data = array();
  
  $get_data_bobot = $this->Administration_m->getTargetdanBobotKompilasiVPI('','barang')->result_array();
  $data['data_bobot'] = [];
  $arrayNew = array();
  if (empty($get_data_bobot)) {
  	$arrayNew['target_ketepatan_progress'] = 0;
  	$arrayNew['target_hasil_mutu_pekerjaan'] = 0;
  	$arrayNew['target_k3l'] = 0;
  	$arrayNew['target_5r'] = 0;
  	$arrayNew['target_pengamanan'] = 0;
  	$arrayNew['bobot_ketepatan_progress'] = 0;
  	$arrayNew['bobot_hasil_mutu_pekerjaan'] = 0;
  	$arrayNew['bobot_k3l'] = 0;
  	$arrayNew['bobot_5r'] = 0;
  	$arrayNew['bobot_pengamanan'] = 0;
  	$data['total_target'] = 0;
  	$data['total_bobot'] = 0;
  }else{

  	foreach ($get_data_bobot as $key => $value) {
	  	if (empty($value['abt_value'])) {
	  		$value['abt_value'] = 0;
	  	}
	  	$arrayNew[$value['abt_indicator']] = str_replace('.', ',', $value['abt_value']); 
	  }

  	$arrayNew['target_ketepatan_progress'] = isset($arrayNew['target_ketepatan_progress']) ? $arrayNew['target_ketepatan_progress'] : 0;
  	$arrayNew['target_hasil_mutu_pekerjaan'] = isset($arrayNew['target_hasil_mutu_pekerjaan']) ? $arrayNew['target_hasil_mutu_pekerjaan'] : 0;
  	$arrayNew['target_k3l'] = isset($arrayNew['target_k3l']) ? $arrayNew['target_k3l'] : 0;
  	$arrayNew['target_5r'] = isset($arrayNew['target_5r']) ? $arrayNew['target_5r'] : 0;
  	$arrayNew['target_pengamanan'] = isset($arrayNew['target_pengamanan']) ? $arrayNew['target_pengamanan'] : 0;

  	$arrayNew['bobot_ketepatan_progress'] = isset($arrayNew['bobot_ketepatan_progress']) ? $arrayNew['bobot_ketepatan_progress'] : 0;
  	$arrayNew['bobot_hasil_mutu_pekerjaan'] = isset($arrayNew['bobot_hasil_mutu_pekerjaan']) ? $arrayNew['bobot_hasil_mutu_pekerjaan'] : 0;
  	$arrayNew['bobot_k3l'] = isset($arrayNew['bobot_k3l']) ? $arrayNew['bobot_k3l'] : 0;
  	$arrayNew['bobot_5r'] = isset($arrayNew['bobot_5r']) ? $arrayNew['bobot_5r'] : 0;
  	$arrayNew['bobot_pengamanan'] = isset($arrayNew['bobot_pengamanan']) ? $arrayNew['bobot_pengamanan'] : 0;

	  $total_target = array(
	  	str_replace(',', '.', $arrayNew['target_ketepatan_progress']),
	  	str_replace(',', '.', $arrayNew['target_hasil_mutu_pekerjaan']),
	  	str_replace(',', '.', $arrayNew['target_k3l']),
	  	str_replace(',', '.', $arrayNew['target_5r']),
	  	str_replace(',', '.', $arrayNew['target_pengamanan'])
	  );

	  $total_bobot = array(
	  	str_replace(',', '.', $arrayNew['bobot_ketepatan_progress']),
	  	str_replace(',', '.', $arrayNew['bobot_hasil_mutu_pekerjaan']),
	  	str_replace(',', '.', $arrayNew['bobot_k3l']),
	  	str_replace(',', '.', $arrayNew['bobot_5r']),
	  	str_replace(',', '.', $arrayNew['bobot_pengamanan'])
	  );

	  $data['total_target'] = array_sum($total_target);
	  $data['total_bobot'] = array_sum($total_bobot);

  }

  array_push($data['data_bobot'] , $arrayNew);
  $data['data_bobot'] = $data['data_bobot'][0];
$this->template($view,"Penilaian Penyedia Barang",$data);
