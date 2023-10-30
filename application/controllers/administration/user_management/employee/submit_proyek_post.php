<?php 

$tambah=$this->input->post();

$check = $this->db->where(array("ppm_id"=>$tambah['ppm_id_inp'], "employee_id"=>$tambah['employee_id']))
->get("adm_employee_proyek")->num_rows();

if($check > 0){
    
    $this->setMessage("Proyek sudah ada");    

    redirect(site_url('administration/user_management/employee/ubah/'.$tambah['employee_id']));

} else {

    $data_plan = $this->db->where('ppm_id', $tambah['ppm_id_inp'])->get('prc_plan_main')->row_array(); 

    $data = array(
        'employee_id' => $tambah['employee_id'],
        'ppm_id' => $tambah['ppm_id_inp'],
        'ppm_project_id' => $data_plan['ppm_project_id'],
        'ppm_project_name' => $data_plan['ppm_project_name'],
        'ppm_dept_id' => $data_plan['ppm_dept_id'],
        'ppm_dept_name' => $data_plan['ppm_dept_name']
    );

    $insert = $this->db->insert('adm_employee_proyek', $data);

    if($insert){        
        $this->setMessage("Berhasil menambahkan proyek employee");
    }

    redirect(site_url('administration/user_management/employee/ubah/'.$tambah['employee_id']));

}