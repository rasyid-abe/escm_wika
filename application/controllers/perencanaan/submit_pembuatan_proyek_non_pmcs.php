<?php

$error = true;
$post = $this->input->post();

// mata_anggaran_inp

$ppm = array();
$ppm['ppm_type_of_plan'] = $post['jenis_rencana'];
$ppm['ppm_dept_name'] = $post['birounit_inp'];
$ppm['ppm_planner'] = $post['user_inp'];
$ppm['ppm_planner_pos_name'] = $post['pos_name'];
$ppm['ppm_planner_pos_code'] = $post['pos_id'];
$ppm['ppm_district_id'] = $post['district_id'];
$ppm['ppm_district_name'] = $post['district_name'];
$ppm['ppm_dept_id'] = $post['dept_id'];
$ppm['ppm_project_name'] = $post['nama_proyek'];
$ppm['ppm_project_id'] = $post['proyek_id'];
$ppm['ppm_subject_of_work'] = $post['nama_rencana_pekerjaan_inp'];
$ppm['ppm_scope_of_work'] = $post['deskripsi_rencana_pekerjaan_inp'];
$ppm['ppm_mata_anggaran'] = $post['mata_anggaran_code_inp'];
$ppm['ppm_nama_mata_anggaran'] = $post['mata_anggaran_label_inp'];
$ppm['ppm_sub_mata_anggaran'] = $post['sub_mata_anggaran_code_inp'];
$ppm['ppm_nama_sub_mata_anggaran'] = $post['sub_mata_anggaran_label_inp'];
$ppm['ppm_currency'] = $post['mata_uang_inp'];

$chint = strtr($post['pagu_anggaran_inp'], array('.' => ''));
$intpagu = explode(',', $chint);

$ppm['ppm_pagu_anggaran'] = (int) $intpagu[0];
$ppm['ppm_renc_pelaksanaan'] = $post['rencana_pelaksanaan_kebutuhan_year_inp'].'-'.$post['rencana_pelaksanaan_kebutuhan_month_inp'];
$ppm['ppm_renc_kebutuhan'] = $post['rencana_kebutuhan_year_inp'].'-'.$post['rencana_kebutuhan_month_inp'];

$this->db->insert('prc_plan_main', $ppm);
$insert_id = $this->db->insert_id();

if ($insert_id) {
    $error = true;
} else {
    $this->setMessage("Pembuatan Proyek (Non PMCS) gagal");
    $error = false;
}

for ($i=0; $i < count($post['doc_desc_inp']); $i++) {
    $ppd = array();
    $ppd['ppm_id'] = $insert_id;
    $ppd['ppd_category'] = $post['doc_category_inp'][$i];
    $ppd['ppd_description'] = $post['doc_desc_inp'][$i];
    $ppd['ppd_file_name'] = $post['doc_attachment_inp'][$i];

    $ippd = $this->db->insert('prc_plan_doc', $ppd);
    if ($ippd) {
        $error = true;
    } else {
        $error = false;
    }
}

if($error){
    $this->setMessage("Pembuatan Proyek (Non PMCS) berhasil");
    $this->renderMessage("sucess", site_url("perencanaan_pengadaan/pr_proyek_non_pmcs/pembuatan_proyek_non_pmcs"));
} else {
    $this->renderMessage("error");
}
