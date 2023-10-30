<?php 

		$id= $this->uri->segment(5, 0);

        $data = array(
        'satker_active' =>0,
  );    

		$this->db->where('satker_id', $id);
		$update=$this->db->update('adm_satker', $data);

		redirect(site_url('administration/master_data/satker'));