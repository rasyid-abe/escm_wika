<?php 

$post = $this->input->post();
$userdata = $this->data['userdata'];

$this->db->where("a.active", "Aktif");
$cek = $this->Administration_m->getMasterMdiv(array("a.region_id"=>$post['region_inp']))->row_array();

if ($cek != NULL) {

    echo "<script> alert('Wilayah ini sudah memiliki MDIV') </script>";
    echo "<script> location.href = 'add' </script>";

}else{

    if(!empty($post)){

        $data = [
            'region_id' => $post['region_inp'],
            'pos_code' => $post['pos_inp'],
            'dept_code' => $post['dept_inp'],
            'active' => "Aktif",
            'created_datetime' => date("Y-m-d H:i:s"),
            'updated_datetime' => date("Y-m-d H:i:s"),
            'pos_code_modifier' => $userdata['pos_id'],
            'pos_name_modifier' => $userdata['pos_name'],
            'employee_id_modifier' => $userdata['employee_id'],
            'employee_modifier' => $userdata['complete_name']
        ];

        $insert = $this->Administration_m->insertMasterMdiv($data);
        
        if($insert){
            $this->setMessage("Berhasil menambah master mdiv");
        }

    }

    redirect(site_url('administration/master_data/master_mdiv'));
}
