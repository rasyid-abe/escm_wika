<?php
$data = $this->db->where('id', $id)->get('adm_employee_cat')->row_array(); 
$delete = $this->db->where('id', $id)->delete('adm_employee_cat'); 

if($delete){    
    $this->setMessage("Berhasil menghapus kategori employee");
}
redirect(site_url('administration/user_management/employee/ubah/'.$data['employee_id']));
