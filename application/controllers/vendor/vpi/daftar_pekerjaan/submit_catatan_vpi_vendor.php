<?php
$files = "";
$post = $_POST;

		if (is_uploaded_file($_FILES['lampiran']['tmp_name'])) {
            $files = $this->do_upload('lampiran','vpi', 'catatan');
        }

		if ($files != "") {
			$data = array(
				'vendor_id' => '25',
				'nama' => $this->userdata['complete_name'],
				'is_good' => $this->input->post('status'),
				'note' => $this->input->post('note'),
				'lampiran' => $files ? $files : '',
				'created_by' => $this->userdata['user_name'],
				'date_create' => date('Y-m-d H:i:s')
			);
	
			$this->db->trans_begin();
			$this->db->insert('vnd_vpi_note', $data);
			
			$this->session->set_flashdata('tab', 'submit');
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$this->session->set_flashdata('res', 'gagal');
				redirect(base_url("/vendor/vpi/catatan_vendor"));
	
			} else {
				$this->db->trans_commit();
				$this->session->set_flashdata('res', 'sukses');
				redirect(base_url("/vendor/vpi/catatan_vendor"));
			}
		} else {
			
			redirect(base_url("/vendor/vpi/catatan_vendor"));
		}

?>