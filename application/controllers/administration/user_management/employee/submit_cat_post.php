<?php 

$tambah=$this->input->post();

$check = $this->db->where(array("category"=>$tambah['category_inp'], "employee_id"=>$tambah['employee_id']))
->get("adm_employee_cat")->num_rows();

if($check > 0){
    
    $this->setMessage("Kategori sudah ada");    

    redirect(site_url('administration/user_management/employee/ubah/'.$tambah['employee_id']));

} else {

    $data = array(
        'employee_id' => $tambah['employee_id'],
        'category' => $tambah['category_inp']        
    );

    $insert = $this->db->insert('adm_employee_cat', $data);

    if($insert){        
        $this->setMessage("Berhasil menambahkan kategori employee");
    }

    redirect(site_url('administration/user_management/employee/ubah/'.$tambah['employee_id']));

}