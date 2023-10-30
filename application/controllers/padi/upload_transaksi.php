<?php 
	// Load plugin PHPExcel
	include APPPATH.'third_party/PHPExcel/PHPExcel.php';

	if (!$this->upload->do_upload('file_transaksi')) {

		//upload gagal
		$this->session->set_flashdata('notif', '
			<div class="alert alert-danger alert-dismissible my-2" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
				<span>PROSES IMPORT GAGAL! ' . $this->upload->display_errors() . '</span>
			</div>
		');
		
		//redirect halaman
		echo(error_log);

		redirect('padi/transaksi');

	} else {

		$data_upload = $this->upload->data();

		$excelreader  = new PHPExcel_Reader_Excel2007();
		$loadexcel    = $excelreader->load('uploads/padi/'.$data_upload['file_name']); // Load file yang telah diupload ke folder excel
		$sheet        = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

		$data = array();

		$numrow = 1;
		foreach($sheet as $row){
				if($numrow > 1){
					array_push($data, array(
						'tanggal_transaksi'   		=> $row['A'],
						'transaksi_id'        		=> $row['B'],
						'bumn_id'      		  		=> $row['C'],
						'nama_project'        		=> $row['D'],
						'kategori_project'    		=> $row['E'],
						'total_nilai_project' 		=> $row['F'],
						'tipe_nilai_project'  		=> $row['G'],
						'kategori_umkm' 	  		=> $row['H'],
						'uid_umkm' 			  		=> $row['I'],
						'nama_umkm' 		  		=> $row['J'],
						'target_penyelesaian' 		=> $row['K'],
						'tanggal_order_placement'	=> $row['L'],
						'tanggal_confirmation' 		=> $row['M'],
						'tanggal_delivery' 			=> $row['N'],
						'tannggal_invoice' 			=> $row['O'],
						'total_cycle_time' 			=> $row['P'],
						'kategori_delivery_time' 	=> $row['Q'],
						'rating' 					=> $row['R'],
						'feedback' 					=> $row['S'],
						'deskripsi_project' 		=> $row['T'],
						'id_satker' 				=> $row['U'],
						'is_pdn' 					=> $row['V'],
						'tkdn' 						=> $row['W'],
						'is_certificate' 			=> $row['X'],
						'certificate_tkdn' 			=> $row['Y'],
						'status_padi' 				=> 0,
						'created_at'				=> date("Y-m-d H:i:s"),
						'created_by' 				=> $this->session->userdata(do_hash(SESSION_PREFIX))
					));
				}
			$numrow++;
		}

		$result = $this->db->insert_batch('padi_transaksi', $data);

		//delete file from server
		unlink(realpath('uploads/padi/'.$data_upload['file_name']));

		//upload success
		$this->session->set_flashdata('notif', '
			<div class="alert alert-success alert-dismissible my-2" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
				<span>PROSES IMPORT BERHASIL!</span>
			</div>
		');

		//redirect halaman
		redirect('padi/transaksi');

	}

?>