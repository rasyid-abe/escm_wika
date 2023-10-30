<?php
$data = $this->db->where('id', $id)->get('adm_employee_proyek')->row_array(); 
$delete = $this->db->where('id', $id)->delete('adm_employee_proyek'); 

if($delete){    
    $this->setMessage("Berhasil menghapus proyek employee");
}
redirect(site_url('administration/user_management/employee/ubah/'.$data['employee_id']));
