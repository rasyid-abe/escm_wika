<?php 

$post = $this->input->post();

if(!empty($post)){
	$user = $this->Administration_m->getLogin();
	$id = $post['id'];

	$tgl_mulai     = date("Y-m-d h:i:s",strtotime($post['tgl_mulai_inp']));
	$tgl_berakhir  = date("Y-m-d h:i:s",strtotime($post['tgl_berakhir_inp']));

	$data = array(
		'start_date' =>$this->security->xss_clean($tgl_mulai),
        'end_date' => $this->security->xss_clean($tgl_berakhir),
        'from' => $this->security->xss_clean($post['dari_inp']),
        'to' => $this->security->xss_clean($post['kepada_inp']),
        'updated_by'=> $user['employee_id'],
        'notes'=> $this->security->xss_clean($post['keterangan_inp']),
        'updated_date'=>date('Y-m-d'),
        'isActive'=>1
        );
  
		   
	$update = $this->db->where('id', $id)->update('adm_delegasi', $data);
	$employee = $this->Administration_m->get_employee($post['dari_inp'])->row_array();
	$pos = $this->Administration_m->getEmployeePos($post['dari_inp'])->result_array();
	$employeeto = $this->Administration_m->get_employee($post['kepada_inp'])->row_array();

	$position = "";
	foreach ($pos as $key => $value) {
	    $position .= $key+1;
	    $position .= ". ".$value['job_title']."<br>";
	}
	    
	if($update){
		$title = "Pemberitahuan Delegasi Pekerjaan";

		$msg = "Dengan hormat,
		<br/>
		<br/>
		Bersama ini kami sampaikan bahwa ".$user['complete_name']." telah mendelegasikan tugas dari ".$employee['fullname']." kepada anda untuk dapat melaksanakan pekerjaanya mulai tanggal ".$tgl_mulai." hingga tanggal ".$tgl_berakhir." dengan alasan
		".$post['keterangan_inp'].".
		<p>
		<br/>
		Posisi yang di delegasikan : 
		<br/>
		<br/>".
		$position
		."<br/>Salam,
		<br/>
		".COMPANY_NAME;

		$mail = $employeeto['email'];

		$email = $this->sendEmail($mail,$title,$msg);
		
		$this->setMessage("Berhasil mengubah Delegasi Pekerjaan");
	}
		
	
}

redirect(site_url('administration/master_data/delegasi_tugas'));