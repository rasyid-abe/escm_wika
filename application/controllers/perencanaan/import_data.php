<?php

$path 		= 'uploads/perencanaan_pengadaan/';
$json 		= [];
$this->upload_config($path);
if (!$this->upload->do_upload('file')) {
    $json = [
        'error_message' => showErrorMessage($this->upload->display_errors()),
    ];
} else {
    $file_data 	= $this->upload->data();
    $file_name 	= $path.$file_data['file_name'];

    $datas=array();
    $fp=fopen($file_name, 'r') or die("Unable to open file!");
    while (!feof($fp))
    {
        $line=fgets($fp);

        //process line however you like
        $line=trim($line);

        //add to array
        $datas[]=explode('|', $line);

    }
    fclose($fp);

    $all_ppm = $all_ppi = $all_ppv = $all_pph = [];
    for ($i=2; $i < count($datas); $i++) {
        if (count($datas[$i]) != 1) {
            $sdate = substr($datas[$i][10],0,4).'-'.substr($datas[$i][10],4,2).'-'.substr($datas[$i][10],6,2);
            $edate = substr($datas[$i][11],0,4).'-'.substr($datas[$i][11],4,2).'-'.substr($datas[$i][11],6,2);
            $udate = substr($datas[$i][12],0,4).'-'.substr($datas[$i][12],4,2).'-'.substr($datas[$i][12],6,2);
            $iddept = $this->db->get_where('adm_dept', ['dep_code' => $datas[$i][8]])->row('dept_id');

            $ppr = 'rkp';
            if (($datas[$i][15] == 'ZPW2') && ($datas[$i][8] == 'A0M')) {
                $ppr = 'rkp_matgis';
            } elseif ($datas[$i][15] == 'ZPW1') {
                $ppr = 'rkap';
            }

            $arr_ppm = [
                'ppm_project_id' => $datas[$i][0],
                'ppm_project_name' => $datas[$i][1],
                'ppms_project_id' => $datas[$i][2],
                'ppm_subject_of_work' => $datas[$i][3],
                'ppms_planner_pos_code' => $datas[$i][4],
                'ppm_planner_pos_name' => $datas[$i][5],
                'ppms_storage_loc' => $datas[$i][6],
                'ppm_scope_of_work' => $datas[$i][7],
                'ppm_dept_id' => $iddept,
                'ppm_dept_name' => $datas[$i][9],
                'ppms_start_date' => $sdate != '0000-00-00' ? $sdate : null,
                'ppms_finish_date' => $edate != '0000-00-00' ? $edate : null,
                'ppm_is_sap' => 1,
                'ppm_type_of_plan' => $ppr,
            ];

            $arr_ppi = [
                'ppis_used_date' => $udate != '0000-00-00' ? $udate : null,
                'ppis_pr_number' => $datas[$i][13],
                'ppis_pr_item' => $datas[$i][14],
                'ppis_pr_type' => $datas[$i][15],
                'ppis_acc_assig' => $datas[$i][16],
                'ppis_cat_tech' => $datas[$i][17],
                'ppi_code' => $datas[$i][18],
                'ppi_item_desc' => $datas[$i][19],
                'ppi_jumlah' => (float)$datas[$i][20],
                'ppi_satuan' => $datas[$i][21],
                'ppi_harga' => (int)str_replace(array('.', ','), '', $datas[$i][22]),
                'ppi_mata_uang' => $datas[$i][23],
                'ppis_wbs_element' => $datas[$i][24],
                'ppis_wbs_element_desc' => $datas[$i][25],
                'ppis_network' => $datas[$i][26],
                'ppis_network_desc' => $datas[$i][27],
                'ppis_remark' => $datas[$i][28],
                'ppi_is_sap' => 1,
                'ppis_delivery_date' => $edate != '0000-00-00' ? $edate : null,
            ];

            $arr_ppv = [
                'ppv_smbd_code' => $datas[$i][18],
                'ppv_unit' => $datas[$i][21],
                'ppv_main' => (float)$datas[$i][20],
                'ppv_remain' => (float)$datas[$i][20],
                'ppv_plus' => 0,
                'ppv_minus' => 0,
                'ppv_activity' => 0,
                'ppv_prc' => 'PR',
                'created_datetime' => date('Y-m-d H:i:s')
            ];

            $arr_pph = [
                'pph_main' => (float)$datas[$i][20],
                'pph_remain' => (float)$datas[$i][20],
                'pph_first' => $datas[$i][13],
                'pph_desc' => 0,
                'pph_date' => date('Y-m-d H:i:s')
            ];

            array_push($all_ppm, $arr_ppm);
            array_push($all_ppi, $arr_ppi);
            array_push($all_ppv, $arr_ppv);
            array_push($all_pph, $arr_pph);
        }
    }

    $json = [
        'ppm' => $all_ppm,
        'ppi' => $all_ppi,
        'ppv' => $all_ppv,
        'pph' => $all_pph,
    ];

    # for save to db
    $this->session->set_flashdata('ppm',$all_ppm);
    $this->session->set_flashdata('ppi',$all_ppi);
    $this->session->set_flashdata('ppv',$all_ppv);
    $this->session->set_flashdata('pph',$all_pph);
}

echo json_encode($json);
