<?php

    $post = $this->input->post();
		$header = array();
		$detail = array();
		$matgis = $this->get_matgis($post['h_matgis'])[0];
		$total = 0;
		$ret = true;

		$emp = $this->get_employee();


		if(!empty($post['item_subtotal']))
		{
			foreach ($post['item_subtotal'] as $key => $value) {
				# code...
				$total += $value;
			}
		}else {
			$this->session->set_flashdata('error', 'Gagal Simpan !');
			$this->session->set_flashdata('message', 'Gagal Simpan, Item tidak boleh Kosong !');

			return redirect('procurement/perencanaan_pengadaan/tambah_perencanaan_non_pmcs');
		}

		if(empty($_FILES))
		{
			$this->session->set_flashdata('error', 'Gagal Simpan !');
			$this->session->set_flashdata('message', 'Gagal Simpan, lampiran tidak boleh Kosong !');

			return redirect('procurement/perencanaan_pengadaan/tambah_perencanaan_non_pmcs');
		}


		//upload file

		$header['ppm_subject_of_work'] = $matgis['label'];
		$header['ppm_scope_of_work'] = $matgis['label'];
		$header['ppm_district_id'] = 1;
		$header['ppm_district_name'] = 'Kantor Pusat';
		$header['ppm_dept_id'] = $emp['dept_id'];
		$header['ppm_dept_name'] = $emp['dept_name'];
		$header['ppm_planner'] = $emp['fullname'];
		$header['ppm_planner_pos_code'] = $emp['pos_id'];
		$header['ppm_planner_pos_name'] = $emp['job_title'];
		$header['ppm_status'] = 1;
		$header['ppm_created_date'] = date('Y-m-d H:i:s');
		$header['ppm_currency'] = $post['h_curr_code'];
		$header['ppm_type_of_plan'] = "rkp_non_pmcs";
		$header['ppm_kode_rencana'] = "NPM".date('Ymdhis').rand(10000,100000);

		$header['ppm_pagu_anggaran'] = $total;

		$insertHeader = $this->db->insert('prc_plan_main', $header);
		$headerId = $this->db->insert_id();

		if(!$insertHeader) { $ret = false;}


		//get detail
		foreach ($post['item_subtotal'] as $key => $value) {
			# code...
			$detail[$key]['ppm_id'] = $headerId;
			$detail[$key]['ppi_item_type'] = $post['item_tipe'][$key];
			$detail[$key]['ppi_item_desc'] = $post['item_desc'][$key];
			$detail[$key]['ppi_code'] = $post['item_kode'][$key];
			$detail[$key]['ppi_harga'] = $post['item_harga_satuan'][$key];
			$detail[$key]['ppi_jumlah'] = str_replace('.','',$post['item_jumlah'][$key]);
			$detail[$key]['ppi_satuan'] = $post['item_satuan'][$key];

		}

		$retDetail = $this->db->insert_batch('prc_plan_item', $detail);

		$comment['ppm_id'] = $headerId;
		$comment['comment_date'] = date('Y-m-d H:i:s');
		$comment['comment_name'] = $emp['fullname'];
		$comment['comments'] = $post['komentar'];

		$com = $this->db->insert('prc_plan_comment', $comment);

		$this->upload_file($_FILES['files'],$headerId);

		if($ret) {
			$this->session->set_flashdata('success', 'Berhasil Di Kirim !');
			return redirect('procurement/perencanaan_pengadaan/perencanaan_non_pmcs/');
		} else {
			$this->session->set_flashdata('error', 'Gagal Simpan !');
			return redirect('procurement/perencanaan_pengadaan/perencanaan_non_pmcs/');
		}
