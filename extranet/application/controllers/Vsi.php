<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vsi extends MY_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model(array("Vsi_m"));
		if($this->session->userdata('reg_status_id') != 8){
            redirect(site_url());
		};
	}

	public function kuesioner()
	{
		$periode = $this->Vsi_m->getPeriode()->row_array();
		$list = $this->Vsi_m->getListVsi()->result_array();
		$template = $this->Vsi_m->getTemplateKuesioner()->row_array();
		$periode = $periode;
		$month = date('F', mktime(0, 0, 0, $periode['month'], 10));

		$data['list'] = ($periode != NULL) ? $list : array();
		$data['template'] = ($periode != NULL) ? $template : NULL;
		$data['periode'] = ($periode != NULL) ? $periode : NULL;
		$data['month'] = ($periode != NULL) ? $month : NULL;
		$data['message'] = $this->session->userdata("message");

		$data['title'] = 'List Survey Kepuasan Vendor';
		$this->layout->view('list_vsi', $data);

	}

	public function CountVsi()
	{
		$ret = TRUE;
		$list = $this->Vsi_m->getListVsi()->result_array();
		if(count($list) > 0) $ret = FALSE;

		return $ret;
	}

	public function insert_kuesioner()
	{
		$post = $this->input->post();

		$template = $this->Vsi_m->getTemplateKuesioner($post['template_id'])->row_array();

		$kue = $this->Vsi_m->getKuesioner("", $template['atk_id'], "")->result_array();

		$contr = $this->Vsi_m->getContractor()->result_array();

		foreach ($kue as $key => $value) {
			$name[] = $value['avk_header'];
		}

		$names = array_unique($name);

		foreach ($names as $kh => $vh) {
			$header[] = $this->Vsi_m->getKuesioner("", $template['atk_id'], $vh)->result_array();
		}
		$keterangan[1] = 'Tidak Puas';
		$keterangan[2] = 'Kurang Puas';
		$keterangan[3] = 'Puas';
		$keterangan[4] = 'Sangat Puas';

		$data = [
					'quest_id' => $template['atk_id'],
					'header' => $header,
					'contractor' => $contr,
					'title' => 'Isi VSI',
					'keterangan'=>$keterangan
				];
		$this->layout->view("vsi/kuesioner", $data);
	}


	public function lihat_kuesioner()
	{
		$user = $this->session->userdata("userid");

		$questmaster = $this->Vsi_m->getVndQuest("", $user)->row_array();

		$kue = $this->Vsi_m->getVndKuesioner($questmaster['vvq_id'])->result_array();

		$contr = $this->Vsi_m->getTemplateContractor($questmaster['vvq_id'])->result_array();

		foreach ($kue as $key => $value) {
			$name[] = $value['vvk_quest_header'];
		}

		$names = array_unique($name);

		foreach ($names as $kh => $vh) {
			$quest[] = $this->Vsi_m->getVndKuesioner($questmaster['vvq_id'], $vh)->result_array();
		}

		$data = [
					'quest_id' => $questmaster['vvq_id'],
					'quest' => $quest,
					'master' => $questmaster,
					'contractor' => $contr,
				];

		$data['title'] = 'Lihat Kuisioner';

		$this->layout->view("vsi/lihat_kuesioner", $data);
	}


	public function survey()
	{
		$data = [];
		$this->layout->view("vsi/survey", $data);
	}


	public function presentase()
	{
		$data = [];
		$this->layout->view("vsi/presentase", $data);
	}

	public function submit_kuesioner()
	{
		$post = $this->input->post();

		$this->db->trans_begin();
		$vend = $this->Vsi_m->getVendorData($this->session->userdata("userid"))->row_array();
		$qm = [
				'template_id' => $post['quest_id'],
				//'vvq_already' => $post['already'],
				//'vvq_reason' => $post['reason'],
				//'vvq_evaluator' => $post['evaluator'],
				//'vvq_job' => $post['job_rank'],
				'vendor_code' => $this->session->userdata("userid"),
				'created_date' => date("Y-m-d H:i:s"),
				//'vvq_comment' => $post['komentar_inp'],
				'vendor_name' => $vend['vendor_name'],
				'periode' => (date('m') < 7) ? "Periode : Januari s/d Juni ".date('Y') : "Periode : Juli s/d Desember ".date('Y'),
				'periode_number' =>(date('m') < 7) ? 1 : 2,
				'periode_year'=> date('Y')
				];

		$questmaster = $this->Vsi_m->insertVndQuest($qm);

		// $arr = array_combine($post['name_inp'], $post['type_inp']);

		// $c = 1;

		// foreach ($arr as $n => $t) {
		// 	$cont['vvc_name'] = $n;
		// 	$cont['vvc_type'] = $t;
		// 	$cont['created_date'] = date("Y-m-d H:i:s");

		// 	$cid[] = $this->Vsi_m->insertContractor($cont);
		// 	$c++;
		// }

		$ques = $this->Vsi_m->getKuesioner("", $post['quest_id'], "")->result_array();

		foreach ($ques as $kq => $vq) {
			$sa = "satis_".$vq['avk_id'];
			$im = "imp_".$vq['avk_id'];

			$que = [
					'vvk_quest' => $vq['avk_id'],
					'vvk_quest_name' => $vq['avk_quest'],
					'vvk_satis_score' => $post[$sa],
					'vvk_imp_score' => $post[$im],
					'questmaster_id' => $questmaster,
					'vvk_quest_header' => $vq['avk_header']
				];
			$inq = $this->Vsi_m->insertVndKuesioner($que);
		}

		// foreach ($cid as $k => $v) {
		// 	$c_temp = [
		// 				'cont_id' => $v,
		// 				'vct_score' => $post['con'.$k],
		// 				'questmaster_id' => $questmaster
		// 			];
		// 	$ctid = $this->Vsi_m->insertContractorTemplate($c_temp);
		// }

		if ($this->db->trans_status() === FALSE)
		{
	        $this->db->trans_rollback();
	        // $this->setMessage("Gagal mengirim survey kuesioner");
			$this->session->set_userdata("message","Gagal mengirim survey kuesioner");
			redirect(site_url("vsi/kuesioner"));
		}
		else
		{
	        $this->db->trans_commit();
			$this->session->set_userdata("message","Berhasil mengirim survey kuesioner");
			redirect(site_url("vsi/kuesioner"));
		}
	}

}
