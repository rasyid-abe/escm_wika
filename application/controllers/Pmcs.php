<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// use Restserver\Libraries\REST_Controller;
require(APPPATH . 'libraries/REST_Controller.php');

class Pmcs extends REST_Controller {

	function __construct($config = 'rest') {
        parent::__construct($config);
    }

    public function auto_create_matgis_procurement(){

		$this->db->select("
			a.spk_code,
			a.dept_code,
			a.group_smbd_code,
			a.smbd_code,
			a.unit,
			a.price,
			sum(a.smbd_quantity) as total,
			(select ppv_remain from prc_plan_volume where ppv_smbd_code = a.smbd_code order by ppv_id desc limit 1) as remain
			")
		->group_by('
			a.spk_code,
			a.smbd_code,
			a.dept_code,
			a.dept_name,
			a.group_smbd_name,
			a.group_smbd_code,
			a.smbd_code,
			a.smbd_name,
			a.unit,
			a.price')
		->where("a.smbd_code !=",null)
		->where("a.is_matgis",'t');

		$result = $this->db->get("prc_plan_integrasi a");

		$rearrange = [];

		foreach ($result->result_array() as $key => $value) {

			$value['price'] = round($value['price'],2);

			$value['total'] = round($value['total'],2);

			$value['remain'] = round($value['remain'],2);

			$pkey = $value['spk_code']."-".$value['dept_code']."-".$value['group_smbd_code'];

			$t = $this->db->like("pr_scope_of_work",$pkey)
			->get("prc_pr_main a")->num_rows();

			if($value['remain'] > 0 && empty($t)){

				$rearrange[$pkey][] = $value;

			}

		}

		foreach ($rearrange as $key => $value) {

			$this->db->trans_begin();

			$x = explode("-", $key);

			$i = $this->db->select("group_smbd_name")->where("group_smbd_code",$x[2])
			->get("prc_plan_integrasi a")->row_array();

			$y = $this->db->select("dept_name")->where("dept_code",$x[1])
			->get("prc_plan_integrasi a")->row_array();

			$judul = strtoupper($x[0]." - KEBUTUHAN MATERIAL STRATEGIS ".$i['group_smbd_name']." ".$y['dept_name']." ".date("Y"));

			$spk_code = "MATGIS.".str_replace("-", ".", $key).".".date("Y");

			$plan = $this->db->select("
				ppm_mata_anggaran,
				ppm_nama_mata_anggaran,
				ppm_sub_mata_anggaran,
				ppm_nama_sub_mata_anggaran,
				ppm_planner,
				ppm_planner_id,
				ppm_planner_pos_code,
				ppm_planner_pos_name,
				ppm_pagu_anggaran,
				ppm_sisa_anggaran,
				ppm_district_id,
				ppm_subject_of_work,
				ppm_scope_of_work,
				ppm_district_name,
				ppm_dept_id,
				ppm_dept_name,
				ppm_project_name,
				ppm_currency,
				ppm_type_of_plan,
				ppm_dept_name,
				ppm_id
				")->where("ppm_project_id",$x[0])
			->get("prc_plan_main a")->row_array();

			$input['pr_number'] = $this->Procpr_m->getUrutPR();
			$input['pr_requester_name'] = $plan['ppm_planner'];
			$input['ppm_id'] = $plan['ppm_id'];
			$input['pr_requester_pos_code'] = $plan['ppm_planner_pos_code'];
			$input['pr_requester_pos_name'] = $plan['ppm_planner_pos_name'];
			$input['pr_created_date'] = date("Y-m-d H:i:s");
			$input['pr_subject_of_work'] = $plan['ppm_subject_of_work'];
			$input['pr_scope_of_work'] = $plan['ppm_scope_of_work']." ".$key;
			$input['pr_district_id'] = $plan['ppm_district_id'];
			$input['pr_district'] = $plan['ppm_district_name'];
			$input['pr_currency'] = $plan['ppm_currency'];
			$input['pr_status'] = 1001;
			$input['pr_dept_id'] = $plan['ppm_dept_id'];
			$input['pr_dept_name'] = $plan['ppm_dept_name'];
			$input['pr_mata_anggaran'] = $plan['ppm_mata_anggaran'];
			$input['pr_nama_mata_anggaran'] = $plan['ppm_nama_mata_anggaran'];
			$input['pr_sub_mata_anggaran'] = $plan['ppm_sub_mata_anggaran'];
			$input['pr_nama_sub_mata_anggaran'] = $plan['ppm_nama_sub_mata_anggaran'];
			$input['pr_pagu_anggaran'] = (int) $plan['ppm_pagu_anggaran'];
			$input['pr_sisa_anggaran'] = $input['pr_pagu_anggaran'];
			$input['pr_requester_id'] = $plan['ppm_planner_id'];
			$input['pr_type_of_plan'] = $plan['ppm_type_of_plan'];
			$input['pr_project_name'] = $plan['ppm_project_name'];
			$input['pr_type'] = "MATERIAL STRATEGIS";
			$input['pr_packet'] = $judul;
			$input['pr_spk_code'] = $x[0];

			$sisa_anggaran = (int) ($plan['ppm_sisa_anggaran']) ? $plan['ppm_sisa_anggaran'] : 0;

			foreach ($value as $key2 => $value2) {

				$z = $this->db->select("smbd_name")->where("smbd_code",$value2['smbd_code'])->get("prc_plan_integrasi a")->row_array();

				$item['ppi_code'] = $value2['smbd_code'];
				$item['pr_number'] = $input['pr_number'];
				$item['ppi_description'] = $z['smbd_name'];
				$item['ppi_quantity'] = $value2['remain'];
				$item['ppi_unit'] = $value2['unit'];
				$item['ppi_price'] = $value2['price'];
				$item['ppi_currency'] = $input['pr_currency'];
				$item['ppi_type'] = 'MULTIPLE';
				$item['ppi_ppn'] = 0;
				$item['ppi_pph'] = 0;
				$item['ppi_spk_code'] = $input['pr_spk_code'];

				$this->db->insert("prc_pr_item",$item);

				$sisa_anggaran -= $item['ppi_price']*$item['ppi_quantity'];

			}

			$input['pr_sisa_anggaran'] = (int) $sisa_anggaran;

			$comment['ppc_pos_code'] = $input['pr_requester_pos_code'];
			$comment['ppc_position'] = $input['pr_requester_pos_name'];

			$comment['pr_number'] = $input['pr_number'];
			$comment['ppc_activity'] = $input['pr_status'];
			$comment['ppc_start_date'] = date("Y-m-d H:i:s");
			$comment['ppc_comment'] = "[SYSTEM] MATERIAL STRATEGIS PMCS ".$key;

			$this->db->insert("prc_pr_main",$input);

			$this->db->insert("prc_pr_comment",$comment);

			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
			} else {
				$this->db->trans_commit();
			}

		}

	}

    public function index_post(){
		
		$data = $this->input->raw_input_stream;
		$data1 = json_decode($data);
		
		$data_isi = $data1[0]->data;
		
		$spk_code = $data1[0]->spk_code;
		$nama_proyek = $data1[0]->nama_proyek;
		$kode_departemen = $data1[0]->kode_departemen;
		$nama_departemen = $data1[0]->nama_departemen;
		$periode_locking = $data1[0]->periode_locking;
		$user_id = $data1[0]->user_id;
		$nama_user = $data1[0]->nama_user;
        $mata_uang = $data1[0]->mata_uang;

        $date_lock = DateTime::createFromFormat('d/m/Y',$periode_locking);
        
        //echo date_format($periode_locking,"Y/m/d H:i:s");die;
        //$tgl = array('01/10/2017','02/10/2017','03/10/2017','04/10/2017','05/10/2017');

        $check = $this->db->query ("SELECT id, (to_char(periode_pengadaan::date,'dd/mm/yyyy')||smbd_code||coa_code||spk_code ) as val  
        FROM prc_plan_integrasi
        WHERE spk_code = '".$spk_code."' 
        AND dept_code = '".$kode_departemen."';")->result_array();

        //print_r($check);

        $validate =array_column($check, 'val', 'id');
        // print_r($validate);

        $insert_plan = array();
        $update_plan = array();
        
        foreach($data_isi as $myval)
		{
            $kode_master_sumberdaya  = $myval->kode_master_sumberdaya;
            $nama_master_sumberdaya  = $myval->nama_master_sumberdaya;
            $kelompok_sumberdaya  = $myval->kelompok_sumberdaya;
            $kode_sumberdaya  = $myval->kode_sumberdaya;
            $nama_sumberdaya  = $myval->nama_sumberdaya;
            $satuan  = $myval->satuan;
            $harga_satuan  = $myval->harga_satuan;
            $kode_coa  = $myval->kode_coa;
            $nama_coa  = $myval->nama_coa;
            $is_matgis  = $myval->is_matgis;
			 
            foreach($myval->detail as $detail)
            {
                //echo in_array($detail->periode_pengadaan,$tgl);
                //echo $detail->periode_pengadaan.$kode_sumberdaya.$kode_coa;
                $id_plan = array_search($detail->periode_pengadaan.$kode_sumberdaya.$kode_coa.$spk_code, $validate, true);
                if($id_plan){
                    
                    $update = array(
                        'id' => $id_plan,
                        //'project_name' => $nama_proyek,
                        //'group_smbd_code' => $kode_master_sumberdaya,
                        //'group_smbd_name' => $nama_master_sumberdaya,
                        //'smbd_type' => $kelompok_sumberdaya,
                        //'smbd_code' => $kode_sumberdaya,
                        //'smbd_name' => $nama_sumberdaya,
                        'unit' => $satuan,
                        'smbd_quantity' => floatval($detail->volume_sumberdaya),
                        'price' => number_format($harga_satuan,10,".",""), 
                        //'price' => floatval($harga_satuan), 
                        'total' => number_format($detail->total_nilai,10,".",""), 
                        //'total' => floatval($detail->total_nilai), 
                        'currency' => $mata_uang,
                        //'user_id' => $user_id,
                        'user_name' => $nama_user,
                        //'periode_locking' => strval(date_format("Y-m-d H:i:s", $date_lock)),
                        'periode_locking' => $date_lock->format('Y-m-d'),
                        'updated_date' => date("Y-m-d H:i:s"),
                        'is_matgis' => $is_matgis
                    );
                    array_push($update_plan,$update); 
                    //print_r($update);

                }
                else{
                
                    $date_period = DateTime::createFromFormat('d/m/Y',$detail->periode_pengadaan);;

                    $insert = array(
                        'spk_code' => $spk_code,
                        'project_name' => $nama_proyek, 
                        'dept_code' => $kode_departemen, 
                        'dept_name' => $nama_departemen, 
                        'group_smbd_code' => $kode_master_sumberdaya, 
                        'group_smbd_name' => $nama_master_sumberdaya,
                        'smbd_type' => $kelompok_sumberdaya,
                        'smbd_code' => $kode_sumberdaya, 
                        'smbd_name' => $nama_sumberdaya, 
                        'unit' => $satuan, 
                        'smbd_quantity' => floatval($detail->volume_sumberdaya),
                        'periode_pengadaan' => $date_period->format('Y-m-d'), 
                        'price' => number_format($harga_satuan,10,".",""), 
                        //'price' => floatval($harga_satuan), 
                        'total' => number_format($detail->total_nilai,10,".",""), 
                        //'total' => floatval($detail->total_nilai), 
                        'coa_code' => $kode_coa, 
                        'coa_name' => $nama_coa, 
                        'currency' => $mata_uang, 
                        'user_id' => $user_id, 
                        'user_name' => $nama_user,
                        'periode_locking' => $date_lock->format('Y-m-d'),
                        'updated_date' => date("Y-m-d H:i:s"), 
                        'is_matgis' => $is_matgis
                    );
                    array_push($insert_plan,$insert);
                    
                }

            }
            $this->db->query(
                "SELECT * FROM check_item_katalog_pmcs(
                    '".$kode_master_sumberdaya."',
                    '".$nama_master_sumberdaya."',
                    '".$kode_sumberdaya."',
                    '".$nama_sumberdaya."',
                    '".$satuan."',
                    REPLACE(('$harga_satuan'), ',', '.')::varchar,
                    '".$is_matgis."');"
                    );
            
			 
        }	

        //print_r($update_plan);
        //print_r($insert_plan);
       $this->db->trans_start();
       if(!empty($update_plan)) $this->db->update_batch('prc_plan_integrasi',$update_plan,'id');
       if(!empty($insert_plan)) $this->db->insert_batch('prc_plan_integrasi', $insert_plan);  
       if(!empty($spk_code) && !empty($kode_departemen)){
            $check_kat = $this->db->query(
                "SELECT * FROM check_perencanaan_pmcs(
                    '".$spk_code."',
                    '".$kode_departemen."');"
                    );
       }
       else{
           $this->response(array('status' => 'Gagal Generate Perencanaan pengadaan Kode SPK dan Kode Departemen Tidak Boleh Kosong!', 503));
       }
       $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {   
            $this->db->trans_rollback();
            $this->response(array('status' => 'fail', 'status_code' => 502));
        }else{
            $this->db->trans_commit();
            $this->response(array('status' => 'Insert Perencanaan Success', 'status_code' => 200));
            $this->auto_create_matgis_procurement();
        }
        
    }

    public function index_posts(){

        $data2 = $this->post();
        $total_data = true;
        $data_null = false;

                        // $check_group_type=$this->db->query(
                //     "SELECT group_type 
                //     FROM com_group_smbd 
                //     WHERE group_code = '".$kode_master_sumberdaya."';")
                // ->row_array();

                // if($check_group_type['group_type'] == 'M'){
                    
                //     $count_check_kat=$this->db->query(
                //         "SELECT COUNT ( * ) as check_kat
                //         FROM com_mat_catalog_smbd 
                //         WHERE mat_group_code = '".$kode_master_sumberdaya."';")
                //     ->row_array();

                //     if($count_check_kat['check_kat'] >= 1){
                        
                //         $last_smbd_code=$this->db->query(
                //             "SELECT mat_catalog_code 
                //             FROM com_mat_catalog_smbd
                //             WHERE mat_group_code = '".$kode_master_sumberdaya."'
                //             ORDER BY mat_catalog_code DESC 
                //             LIMIT 1;")
                //         ->row_array();

                //     }
                //     else{

                //     }

                // }
                // else if ($check_group_type['group_type'] == 'S'){
                    
                //     $count_check_kat=$this->db->query(
                //         "SELECT COUNT ( * ) as check_kat
                //         FROM com_srv_catalog_smbd 
                //         WHERE srv_group_code = '".$kode_master_sumberdaya."';")
                //     ->row_array();

                //     if($count_check_kat['check_kat'] >= 1){
                        
                //         $last_smbd_code=$this->db->query(
                //             "SELECT srv_catalog_code 
                //             FROM com_srv_catalog_smbd 
                //             WHERE srv_group_code = '".$kode_master_sumberdaya."'
                //             ORDER BY srv_catalog_code DESC 
                //             LIMIT 1;")
                //         ->row_array();

                //     }
                //     else{

                //     }
                // }
                // else{
                //     print_r($check_group_type);
                // }

        // $this->response(array('status' => $this->post(), 200));
        for($i = 0;$i<count($data2);$i++){
            if (count($data2[$i]) != 21) {
                $total_data = false;
            }
            // echo $i." ".count($os[$i])."<br>";
        }

        for($i=0;$i<21;$i++){
            if (in_array('', array_column($data2, $i))) {
                $data_null = true;
                if (in_array(null, array_column($data2, $i))) {
                    $data_null = true;
                }
            }
        }

        if ($data_null == true) {
          
            $this->response(array('status' => 'Terdapat data kosong!', 502));

        }elseif($total_data == false){

            $this->response(array('status' => 'Jumlah object per row tidak sesuai!', 503));            

        }else{
    	// $this->response(array('status' => $this->post(), 200));
    	$data = json_encode($this->post());
    	// echo $data;
    	$this->db->trans_begin();
    	$this->db->query("SELECT * FROM api_pmcs('".$data."')");
    	if ($this->db->trans_status() === FALSE)
		    {   
		        $this->db->trans_rollback();
		        $this->response(array('status' => 'fail', 'status_code' => 502));
		    }else{
		        $this->db->trans_commit();
		        $this->response(array('status' => 'success', 'status_code' => 200));
		    }
        }

		   //  $this->response(array('status' => $this->post(), 502));
    }

    public function index_get(){

             // $this->response(array('status' => !empty($this->get('hello')) ? 'true' : 'false', 200));

    $this->db->trans_begin();
        $this->db->select('spk_code,dept_code as kode_departemen,dept_name as nama_departemen,group_smbd_code as kode_group_katalog,group_smbd_name as nama_group_katalog,smbd_code as kode_katalog, smbd_name as nama_katalog,unit,first_volume as volume_awal,remain_volume as volume_sisa');

            if (!empty($this->get('spk_code'))) {
                $this->db->where('spk_code', $this->get('spk_code'));
            }
            if (!empty($this->get('kode_departemen'))) {
                 $this->db->where('dept_code', $this->get('kode_departemen'));
            }
            if (!empty($this->get('kode_group_katalog'))) {
                 $this->db->where('group_smbd_code', $this->get('kode_group_katalog'));
            }
            if (!empty($this->get('kode_katalog'))) {
                 $this->db->where('smbd_code', $this->get('kode_katalog'));
            }
            if (!empty($this->get('periode_pengadaan'))) {
                 $this->db->where('periode_pengadaan', $this->get('periode_pengadaan'));
            }
            $data = $this->db->get('vw_prc_plan_volume_remain')->result_array();

        if ($this->db->trans_status() === FALSE)
            {   
                $this->db->trans_rollback();
                $this->response(array('status' => 'fail', 'status_code' => 502));
            }else{
                $this->db->trans_commit();
                $this->response(array('status' => 'success', 'status_code' => 200, 'result' => $data));
            }
    }



}

/* End of file controllername.php */
/* Location: ./application/controllers/controllername.php */