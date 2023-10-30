<?php 
	// Load plugin PHPExcel
	include APPPATH.'third_party/PHPExcel/PHPExcel.php';

	if (!$this->upload->do_upload('file_umkm')) {

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

		redirect('padi/umkm');

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
						'vendor_id'             => $row['A'],
						'nama_umkm'             => $row['B'],
						'alamat'                => $row['C'],
						'blok_no_kav'           => $row['D'],
						'kode_pos'              => $row['E'],
						'kota'                  => $row['F'],
						'provinsi'              => $row['G'],
						'no_telp'               => $row['H'],
						'hp'                    => $row['I'],
						'email'                 => $row['J'],
						'kategori_usaha'        => $row['K'],
						'jenis_kegiatan_usaha'  => $row['L'],
						'npwp'                  => $row['M'],
						'nama_bank'             => $row['N'],
						'country_bank'          => $row['O'],
						'no_rekening'           => $row['P'],
						'nama_pemilik_rekening' => $row['Q'],
						'longitute'             => $row['R'],
						'latitute'              => $row['S'],
						'total_project'         => $row['T'],
						'total_revenue'         => $row['U'],
						'ontime_rate'           => $row['V'],
						'average_rating'        => $row['W'],
						'nib'                   => $row['X'],
						'badan_usaha'           => $row['Y'],
						'status_padi'           => 0,
						'created_at'	        => date("Y-m-d H:i:s"),
						'created_by'            => $this->session->userdata(do_hash(SESSION_PREFIX))
					));
				}
			$numrow++;
		}

		$result = $this->db->insert_batch('padi_umkm', $data);

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
		redirect('padi/umkm');

	}

?>