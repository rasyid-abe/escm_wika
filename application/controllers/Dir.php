<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dir extends CI_Controller {

    var $data;

    public function __construct()
    {
        parent::__construct();
        //Do your magic here

        $this->load->model(array("Administration_m", "Procpr_m", "Comment_m", "Sinkron_Sap_m"));
        $userdata = $this->Administration_m->getLogin();
        $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();
        $this->load->library(array('excel','session'));
    }

    public function import_excel()
    {
        $all_ppm = $all_ppi = $all_ppv = $all_pph = $all_ppm_pr = $all_ppi_pr = array();
        $batch = 10;

        $insert = false;

        if (isset($_FILES["fileExcel"]["name"])) {
			$path = $_FILES["fileExcel"]["tmp_name"];

			$object = PHPExcel_IOFactory::load($path);
            // $worksheet = $object->getWorksheetIterator()[0];
            $sh = 0;
			foreach($object->getWorksheetIterator() as $worksheet)
			{
                if ($sh < 1) {
                    $highestRow = $worksheet->getHighestRow();
                    $highestColumn = $worksheet->getHighestColumn();
                    for($row=1; $row<=$highestRow; $row++)
                    {

                        $sdate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(10, $row)->getValue()));
                        $edate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(11, $row)->getValue()));
                        $udate = date("Y-m-d", PHPExcel_Shared_Date::ExcelToPHP($worksheet->getCellByColumnAndRow(12, $row)->getValue()));
                        $iddept = $this->db->get_where('adm_purchasing_group', ['pg_code' => $worksheet->getCellByColumnAndRow(8, $row)->getValue()])->row('dept_id');

                        $ppr = 'rkp';
                        if (($worksheet->getCellByColumnAndRow(15, $row)->getValue() == 'ZPW2') && ($worksheet->getCellByColumnAndRow(8, $row)->getValue() == 'A0M')) {
                            $ppr = 'rkp_matgis';
                        } elseif ($worksheet->getCellByColumnAndRow(15, $row)->getValue() == 'ZPW1') {
                            $ppr = 'rkap';
                        }

                        $harga_ = 0;
                        if ($worksheet->getCellByColumnAndRow(23, $row)->getValue() > 1) {
                            $harga_ = (int)str_replace(array('.', ','), '', $worksheet->getCellByColumnAndRow(22, $row)->getValue()) / (int)$worksheet->getCellByColumnAndRow(23, $row)->getValue();
                        } else {
                            $harga_ = (int)str_replace(array('.', ','), '', $worksheet->getCellByColumnAndRow(22, $row)->getValue());
                        }

                        $delete_flag = $worksheet->getCellByColumnAndRow(30, $row)->getValue() == 'X' ? 'D' : $worksheet->getCellByColumnAndRow(30, $row)->getValue();

                        $arr_ppm = [
                            'ppm_project_id' => (string)$worksheet->getCellByColumnAndRow(0, $row)->getValue(),
                            'ppm_project_name' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                            'ppms_project_id' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                            'ppm_subject_of_work' => $worksheet->getCellByColumnAndRow(3, $row)->getValue() == '                                        ' ? $worksheet->getCellByColumnAndRow(5, $row)->getValue() : $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                            'ppms_planner_pos_code' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
                            'ppm_planner_pos_name' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
                            'ppms_storage_loc' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
                            'ppm_scope_of_work' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                            'ppm_dept_id' => $iddept,
                            'ppm_dept_name' => $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
                            'ppms_start_date' => $sdate != '0000-00-00' ? $sdate : null,
                            'ppms_finish_date' => $edate != '0000-00-00' ? $edate : null,
                            'ppm_is_sap' => 1,
                            'ppm_type_of_plan' => $ppr,
                        ];

                        $arr_ppi = [
                            'ppis_used_date' => $udate != '0000-00-00' ? $udate : null,
                            'ppis_pr_number' => $worksheet->getCellByColumnAndRow(13, $row)->getValue(),
                            'ppis_pr_item' => (string)$worksheet->getCellByColumnAndRow(14, $row)->getValue(),
                            'ppis_pr_type' => $worksheet->getCellByColumnAndRow(15, $row)->getValue(),
                            'ppis_acc_assig' => $worksheet->getCellByColumnAndRow(16, $row)->getValue(),
                            'ppis_cat_tech' => $worksheet->getCellByColumnAndRow(17, $row)->getValue(),
                            'ppi_code' => preg_replace('/\s+/', '', $worksheet->getCellByColumnAndRow(18, $row)->getValue()),
                            'ppi_item_desc' => $worksheet->getCellByColumnAndRow(19, $row)->getValue(),
                            'ppi_jumlah' => (float)$worksheet->getCellByColumnAndRow(20, $row)->getValue(),
                            'ppi_satuan' => $worksheet->getCellByColumnAndRow(21, $row)->getValue(),
                            'ppi_harga' => $harga_,
                            'ppi_temp_vol' => $worksheet->getCellByColumnAndRow(23, $row)->getValue(),
                            'ppi_mata_uang' => $worksheet->getCellByColumnAndRow(24, $row)->getValue(),
                            'ppis_wbs_element' => $worksheet->getCellByColumnAndRow(25, $row)->getValue(),
                            'ppis_wbs_element_desc' => $worksheet->getCellByColumnAndRow(26, $row)->getValue(),
                            'ppis_network' => $worksheet->getCellByColumnAndRow(27, $row)->getValue(),
                            'ppis_network_desc' => $worksheet->getCellByColumnAndRow(28, $row)->getValue(),
                            'ppis_remark' => $worksheet->getCellByColumnAndRow(29, $row)->getValue(),
                            'ppi_delete_flag' => $delete_flag,
                            'ppi_is_sap' => 1,
                            'ppis_delivery_date' => $edate != '0000-00-00' ? $edate : null,
                            'ppi_pr_order' => (int)$worksheet->getCellByColumnAndRow(31, $row)->getValue(),
                        ];

                        $arr_ppv = [
                            'ppv_smbd_code' => preg_replace('/\s+/', '', $worksheet->getCellByColumnAndRow(18, $row)->getValue()),
                            'ppv_unit' => $worksheet->getCellByColumnAndRow(21, $row)->getValue(),
                            'ppv_main' => (float)$worksheet->getCellByColumnAndRow(20, $row)->getValue(),
                            'ppv_remain' => (float)$worksheet->getCellByColumnAndRow(20, $row)->getValue(),
                            'ppv_plus' => 0,
                            'ppv_minus' => 0,
                            'ppv_activity' => 0,
                            'ppv_prc' => 'PR',
                            'created_datetime' => date('Y-m-d H:i:s')
                        ];

                        $arr_pph = [
                            'pph_main' => (float)$worksheet->getCellByColumnAndRow(20, $row)->getValue(),
                            'pph_remain' => (float)$worksheet->getCellByColumnAndRow(20, $row)->getValue(),
                            'pph_first' => $worksheet->getCellByColumnAndRow(13, $row)->getValue(),
                            'pph_desc' => 0,
                            'pph_date' => date('Y-m-d H:i:s')
                        ];

                        // paket
                        $arr_ppm_pr = [
                            'pr_dept_id' => $iddept,
                            'pr_dept_name' => $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
                            'pr_project_id' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
                            'pr_project_name' => $worksheet->getCellByColumnAndRow(11, $row)->getValue(),
                            'pr_subject_of_work' => $worksheet->getCellByColumnAndRow(3, $row)->getValue() == '                                        ' ? $worksheet->getCellByColumnAndRow(5, $row)->getValue() : $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                            'pr_scope_of_work' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
                            'pr_spk_code' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
                            'pr_created_date' => date('Y-m-d h:i:s'),
                            'pr_status' => 1000,
                            'pr_doc_type' => $worksheet->getCellByColumnAndRow(15, $row)->getValue(),
                            'pr_jadwal_pengadaan_awal' => $sdate != '0000-00-00' ? $sdate : null,
                            'pr_jadwal_pengadaan_akhir' => $edate != '0000-00-00' ? $edate : null,
                            'pr_is_sap' => 1,
                            'pr_packet' => 'Perencanaan ' . $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                            'pr_type_of_plan' => $ppr,
                        ];

                        $arr_ppi_pr = [
                            'ppi_code' => preg_replace('/\s+/', '', $worksheet->getCellByColumnAndRow(18, $row)->getValue()),
                            'ppi_description' => $worksheet->getCellByColumnAndRow(19, $row)->getValue(),
                            'ppi_quantity' => (float)$worksheet->getCellByColumnAndRow(20, $row)->getValue(),
                            'ppi_unit' => $worksheet->getCellByColumnAndRow(21, $row)->getValue(),
                            'ppi_price' => (int)str_replace(array('.', ','), '', $worksheet->getCellByColumnAndRow(22, $row)->getValue()),
                            'ppi_ppn' => 0,
                            'ppi_pph' => 0,
                            'ppis_pr_number' => (string)$worksheet->getCellByColumnAndRow(13, $row)->getValue(),
                            'ppis_pr_item' => (string)$worksheet->getCellByColumnAndRow(14, $row)->getValue(),
                            'ppis_delivery_date' => $edate != '0000-00-00' ? $edate : null,
                            'ppis_pr_type' => $worksheet->getCellByColumnAndRow(15, $row)->getValue(),
                            'ppis_acc_assig' => $worksheet->getCellByColumnAndRow(16, $row)->getValue(),
                            'ppis_cat_tech' => $worksheet->getCellByColumnAndRow(17, $row)->getValue(),
                            'ppi_delete_flag' => $delete_flag,
                            'ppi_currency' => $worksheet->getCellByColumnAndRow(24, $row)->getValue(),
                            'ppi_pr_order' => (int)$worksheet->getCellByColumnAndRow(31, $row)->getValue(),
                        ];

                        array_push($all_ppm, $arr_ppm);
                        array_push($all_ppi, $arr_ppi);
                        array_push($all_ppv, $arr_ppv);
                        array_push($all_pph, $arr_pph);

                        // paket
                        array_push($all_ppm_pr, $arr_ppm_pr);
                        array_push($all_ppi_pr, $arr_ppi_pr);
                    }
                    $insert = $this->insert($all_ppm, $all_ppi, $all_ppv, $all_pph, $all_ppm_pr, $all_ppi_pr);
                }

                $sh++;

			}

            if ($insert) {
                $full_url = site_url()."perencanaan_pengadaan/prn_sap_list";
                echo "<script>
                window.location.href='".$full_url."';
                alert('Import Excel Success!');
                </script>";
            } else {
                $full_url = site_url()."perencanaan_pengadaan/prn_sap_list";
                echo "<script>
                window.location.href='".$full_url."';
                alert('Import Excel Failed!');
                </script>";
            }

		} else {
            $full_url = site_url()."perencanaan_pengadaan/prn_sap_list";
            echo "<script>
            window.location.href='".$full_url."';
            alert('File not found!');
            </script>";
		}
    }

    public function index()
    {
        $directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Outbound';
        $file = $this->scan_dir($directory);
        $newl = "\n";
        $s = $f = 0;
        foreach ($file as $v) {
            if (substr($v, -4) == '.txt') {
                $ls = explode("-",$v);
                if ($ls[0] == 'YMMI004') {
                    $save = $this->read_file($v, $directory);
                    if ($save) {
                        file_put_contents($directory.'/Success/log.txt', $v.$newl, FILE_APPEND);
                        $s++;
                    } else {
                        file_put_contents($directory.'/Error/log.txt', $v.$newl, FILE_APPEND);
                        $f++;
                    }

                    if (copy($directory.'/'.$v, $directory.'/Archive/'.$v)) {
                        unlink($directory.'/'.$v);
                    }
                }
            }
        }

        $full_url = site_url()."perencanaan_pengadaan/prn_sap_list";
        echo "<script>
        window.location.href='".$full_url."';
        alert('Import PR Success');
        </script>";
    }

    public function sync_api()
    {
        $cek_status = $this->Sinkron_Sap_m->do_sinkron();

        if ($cek_status == 'success') {
            $status = 'success';
            $msg = 'Sukses mensinkronkan data';

        } elseif ($cek_status == 'fail') {
            $status = 'fail';
            $msg = 'Gagal mensinkronkan data';

        } elseif ($cek_status == 'not_found') {
            $status = 'not_found';
            $msg = 'Data tidak ditemukan';

        } else {
            $status = 'error_ws';
            $msg = 'Terjadi kesalahan teknis';
        }

        redirect(site_url("perencanaan_pengadaan/prn_sap_list?status=$status&msg=$msg"));
    }

    private function scan_dir($dir) {
        $ignored = array('.', '..', '.svn', '.htaccess');

        $files = array();
        foreach (scandir($dir) as $file) {
            if (in_array($file, $ignored)) continue;
            $files[$file] = filemtime($dir . '/' . $file);
        }
        arsort($files);
        $files = array_keys($files);

        return ($files) ? $files : false;
    }

    private function read_file($v, $path)
    {
        $datas=array();
        $fp=fopen($path.'/'.$v, 'r') or die("Unable to open file!");
        while (!feof($fp))
        {
            $line=fgets($fp);

            //process line however you like
            $line=trim($line);

            //add to array
            $datas[]=explode('|', $line);

        }
        fclose($fp);

        $save = $this->save($datas);
        return $save;
    }

    private function save($datas)
    {
        $ret = false;
        $all_ppm = $all_ppm_pr = $all_ppi = $all_ppi_pr = $all_ppv = $all_pph = [];

        for ($i=2; $i < count($datas); $i++) {
            if (count($datas[$i]) != 1) {
                $sdate = substr($datas[$i][10],0,4).'-'.substr($datas[$i][10],4,2).'-'.substr($datas[$i][10],6,2);
                $edate = substr($datas[$i][11],0,4).'-'.substr($datas[$i][11],4,2).'-'.substr($datas[$i][11],6,2);
                $udate = substr($datas[$i][12],0,4).'-'.substr($datas[$i][12],4,2).'-'.substr($datas[$i][12],6,2);
                $iddept = $this->db->get_where('adm_purchasing_group', ['pg_code' => $datas[$i][8]])->row('dept_id');

                $ppr = 'rkp';
                if (($datas[$i][15] == 'ZPW2') && ($datas[$i][8] == 'A0M')) {
                    $ppr = 'rkp_matgis';
                } elseif ($datas[$i][15] == 'ZPW1') {
                    $ppr = 'rkap';
                }

                $harga_ = 0;
                if ($datas[$i][23] > 1) {
                    $harga_ = (int)str_replace(array('.', ','), '', $datas[$i][22]) / (int)$datas[$i][23];
                } else {
                    $harga_ = (int)str_replace(array('.', ','), '', $datas[$i][22]);
                }

                $delete_flag = $datas[$i][30] == 'X' ? 'D' : $datas[$i][30];

                $arr_ppm = [
                    'ppm_project_id' => (string)$datas[$i][0],
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
                    'ppis_pr_item' => (string)$datas[$i][14],
                    'ppis_pr_type' => $datas[$i][15],
                    'ppis_acc_assig' => $datas[$i][16],
                    'ppis_cat_tech' => $datas[$i][17],
                    'ppi_code' => preg_replace('/\s+/', '', $datas[$i][18]),
                    'ppi_item_desc' => $datas[$i][19],
                    'ppi_jumlah' => (float)$datas[$i][20],
                    'ppi_satuan' => $datas[$i][21],
                    'ppi_harga' => $harga_,
                    'ppi_temp_vol' => $datas[$i][23],
                    'ppi_mata_uang' => $datas[$i][24],
                    'ppis_wbs_element' => $datas[$i][25],
                    'ppis_wbs_element_desc' => $datas[$i][25],
                    'ppis_network' => $datas[$i][27],
                    'ppis_network_desc' => $datas[$i][28],
                    'ppis_remark' => $datas[$i][29],
                    'ppi_delete_flag' => $delete_flag,
                    'ppi_is_sap' => 1,
                    'ppis_delivery_date' => $edate != '0000-00-00' ? $edate : null,
                    'ppi_pr_order' => (int)$datas[$i][31],
                ];

                $arr_ppv = [
                    'ppv_smbd_code' => preg_replace('/\s+/', '', $datas[$i][18]),
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

                // paket
                $arr_ppm_pr = [
                    'pr_dept_id' => $iddept,
                    'pr_dept_name' => $datas[$i][9],
                    'pr_project_id' => $datas[$i][0],
                    'pr_project_name' => $datas[$i][1],
                    'pr_subject_of_work' => $datas[$i][3],
                    'pr_scope_of_work' => $datas[$i][7],
                    'pr_spk_code' => $datas[$i][0],
                    'pr_created_date' => date('Y-m-d h:i:s'),
                    'pr_status' => 1000,
                    'pr_doc_type' => $datas[$i][15],
                    'pr_jadwal_pengadaan_awal' => $sdate != '0000-00-00' ? $sdate : null,
                    'pr_jadwal_pengadaan_akhir' => $edate != '0000-00-00' ? $edate : null,
                    'pr_is_sap' => 1,
                    'pr_packet' => 'Perencanaan ' . $datas[$i][1],
                    'pr_type_of_plan' => $ppr,
                ];

                $arr_ppi_pr = [
                    'ppi_code' => preg_replace('/\s+/', '', $datas[$i][18]),
                    'ppi_description' => $datas[$i][19],
                    'ppi_quantity' => (float)$datas[$i][20],
                    'ppi_unit' => $datas[$i][21],
                    'ppi_price' => (int)str_replace(array('.', ','), '', $datas[$i][22]),
                    'ppi_ppn' => 0,
                    'ppi_pph' => 0,
                    'ppis_pr_number' => (string)$datas[$i][13],
                    'ppis_pr_item' => (string)$datas[$i][14],
                    'ppis_delivery_date' => $edate != '0000-00-00' ? $edate : null,
                    'ppis_pr_type' => $datas[$i][15],
                    'ppis_acc_assig' => $datas[$i][16],
                    'ppis_cat_tech' => $datas[$i][17],
                    'ppi_delete_flag' => $delete_flag,
                    'ppi_currency' => $datas[$i][24],
                    'ppi_pr_order' => (int)$datas[$i][31],
                ];

                array_push($all_ppm, $arr_ppm);
                array_push($all_ppi, $arr_ppi);
                array_push($all_ppv, $arr_ppv);
                array_push($all_pph, $arr_pph);

                // paket
                array_push($all_ppm_pr, $arr_ppm_pr);
                array_push($all_ppi_pr, $arr_ppi_pr);
            }
        }
        return $this->insert($all_ppm, $all_ppi, $all_ppv, $all_pph, $all_ppm_pr, $all_ppi_pr);
    }

    private function insert($all_ppm, $all_ppi, $all_ppv, $all_pph, $all_ppm_pr, $all_ppi_pr)
    {
        $user = $this->data['userdata'];

        $ppm = $all_ppm;
        $ppi = $all_ppi;
        $ppv = $all_ppv;
        $pph = $all_pph;

        // paket
        $ppm_pr = $all_ppm_pr;
        $ppi_pr = $all_ppi_pr;

        // echo "<pre>";
        // print_r($ppm_pr);
        // die;
        $userdata = [
            'ppm_district_id' => $user['district_id'],
            'ppm_district_name' => $user['district_name'],
            'ppm_planner' => $user['complete_name'],
        ];

        $sts = [];
        
        for ($i=0; $i < count($ppm); $i++) {
            $pr_number_new = $this->Procpr_m->getUrutPR();
            
            $it_id = $this->db->get_where('prc_plan_main', [
                'ppm_project_id' => $ppm[$i]['ppm_project_id'],
                'ppm_project_name' => $ppm[$i]['ppm_project_name']
            ]);
            
            if ($it_id->num_rows() > 0) {
                
                $ck_pr = $it_id->row_array();

                $ppm_v = $this->db->get_where('prc_plan_item', ['ppis_pr_number' => $ppi[$i]['ppis_pr_number'], 'ppis_pr_item' => $ppi[$i]['ppis_pr_item'], 'ppi_code' => $ppi[$i]['ppi_code']]);
                if ($ppm_v->num_rows() > 0) {
                    $ppm_up = array_merge($ppm[$i], [
                        'ppm_project_id' => trim($ck_pr['ppm_project_id']).';'.trim($ppm[$i]['ppm_project_id']),
                        'ppm_project_name' => trim($ck_pr['ppm_project_name']).';'.trim($ppm[$i]['ppm_project_name'])
                    ]);

                    $this->db->where('ppm_id', $ck_pr['ppm_id']);
                    if ($this->db->update('prc_plan_main', $ppm_up)) {
                        $ret = true;
                    } else {
                        $ret = false;
                    }

                    $ppi_up = array_merge($ppi[$i], ['status_rkp' => "C", 'ppi_update_at' => date('Y-m-d h:i:s')]);

                    if(($ppi[$i]['ppi_delete_flag'] == 'X') || ($ppi[$i]['ppi_delete_flag'] == 'x') ){
                        $ppi_up = array_merge($ppi[$i], ['status_rkp' => "D", 'ppi_update_at' => date('Y-m-d h:i:s')]);
                    }

                    $ppi_up1 = array_merge($ppi_up, [
                        'ppi_jumlah' => (float)$ck_pr['ppi_jumlah'] + (float)$ppi[$i]['ppi_jumlah'],
                        'ppi_pr_distribute' => 1
                    ]);

                    $this->db->where('ppis_pr_number', $ppi[$i]['ppis_pr_number']);
                    $this->db->where('ppis_pr_item', $ppi[$i]['ppis_pr_item']);
                    $this->db->where('ppi_code', $ppi[$i]['ppi_code']);
                    if ($this->db->update('prc_plan_item', $ppi_up)) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }

                    $sm_id = $this->db->get_where('prc_plan_volume', [
                        'ppv_smbd_code' => $ppv[$i]['ppv_smbd_code'],
                        'ppm_id' => $ck_pr['ppm_id']
                    ]);

                    if ($sm_id->num_rows() < 1) {
                        $ppv_in = array_merge($ppv[$i], ['ppm_id' => $ck_pr['ppm_id']]);
                        if ($res = $this->db->insert('prc_plan_volume', $ppv_in)) {
                            $ret = true;
                        } else {
                            $ret = true;
                        }
                    } else {
                        $sm_idv = $sm_id->row_array();
                        $ppv_up = array_merge($ppv[$i], [
                            'ppv_main' => (float)$sm_idv['ppv_main'] + (float)$ppv[$i]['ppv_main'],
                            'ppv_remain' => (float)$sm_idv['ppv_remain'] + (float)$ppv[$i]['ppv_remain']
                        ]);

                        $this->db->where('ppv_smbd_code', $ppv[$i]['ppv_smbd_code']);
                        if ($this->db->update('prc_plan_volume', $ppv_up)) {
                            $ret = true;
                        } else {
                            $ret = true;
                        }
                    }

                    $ppm_pr_up = array_merge($ppm_pr[$i], [
                        'pr_project_id' => trim($ck_pr['ppm_project_id']).';'.trim($ppm_pr[$i]['pr_project_id']),
                        'pr_project_name' => trim($ck_pr['ppm_project_name']).';'.trim($ppm_pr[$i]['pr_project_name'])
                    ]);

                    $this->db->where('ppm_id', $ck_pr['ppm_id']);
                    if ($this->db->update('prc_pr_main', $ppm_pr_up)) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }

                    // deletion flag
                    $ppi_pr_up = array_merge($ppi_pr[$i], ['ppi_status_update' => "C", 'ppi_update_at' => date('Y-m-d h:i:s')]);
                    if($ppi[$i]['ppi_delete_flag'] == 'X') {
                        $ppi_pr_up = array_merge($ppi_pr[$i], ['ppi_status_update' => "D", 'ppi_update_at' => date('Y-m-d h:i:s')]);
                    }

                    $ppi_pr_up1 = array_merge($ppi_pr_up, [
                        'ppi_quantity' => (float)$ck_pr['ppi_jumlah'] + (float)$ppi_pr[$i]['ppi_quantity'],
                        'ppi_pr_distribute' => 1
                    ]);

                    $this->db->where('ppis_pr_number', $ppi_pr[$i]['ppis_pr_number']);
                    $this->db->where('ppis_pr_item', $ppi_pr[$i]['ppis_pr_item']);
                    $this->db->where('ppi_code', $ppi_pr[$i]['ppi_code']);
                    if ($this->db->update('prc_pr_item', $ppi_pr_up)) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }

                } else {
                    // paket
                    $ppm_pr_in = array_merge($ppm_pr[$i], ['ppm_id' => $ck_pr['ppm_id'], 'pr_number' => $pr_number_new]);
                    if ($this->db->insert('prc_pr_main', $ppm_pr_in)) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }

                    $ppi_pr_in = array_merge($ppi_pr[$i], ['pr_number' => $pr_number_new, 'ppi_status_update' => 'N', 'ppi_created_at' => date('Y-m-d h:i:s'), 'ppi_update_at' => date('Y-m-d h:i:s')]);
                    if ($res = $this->db->insert('prc_pr_item', $ppi_pr_in)) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }
                    // end paket

                    $ppi_in = array_merge($ppi[$i], ['ppm_id' => $ck_pr['ppm_id'], 'ppi_update_at' => date('Y-m-d h:i:s')]);
                    if ($res = $this->db->insert('prc_plan_item', $ppi_in)) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }

                    $ppv_in = array_merge($ppv[$i], ['ppm_id' => $ck_pr['ppm_id']]);
                    if ($res = $this->db->insert('prc_plan_volume', $ppv_in)) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }

                    $pph_in = array_merge($pph[$i], ['ppm_id' => $ck_pr['ppm_id']]);
                    if ($res = $this->db->insert('prc_plan_hist', $pph_in)) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }
                }

            } else {
                $ppm_in = array_merge($ppm[$i], $userdata);
                if ($this->db->insert('prc_plan_main', $ppm_in)) {
                    $ret = true;
                } else {
                    $ret = true;
                }

                $ppm_id = $this->db->insert_id();

                // paket
                $ppm_pr_in = array_merge($ppm_pr[$i], ['ppm_id' => $ppm_id, 'pr_number' => $pr_number_new]);
                if ($this->db->insert('prc_pr_main', $ppm_pr_in)) {
                    $ret = true;
                } else {
                    $ret = true;
                }

                $ppi_pr_in = array_merge($ppi_pr[$i], ['pr_number' => $pr_number_new, 'ppi_status_update' => 'N', 'ppi_created_at' => date('Y-m-d h:i:s'), 'ppi_update_at' => date('Y-m-d h:i:s')]);
                if ($res = $this->db->insert('prc_pr_item', $ppi_pr_in)) {
                    $ret = true;
                } else {
                    $ret = true;
                }
                // end paket

                $ppi_in = array_merge($ppi[$i], ['ppm_id' => $ppm_id, 'ppi_update_at' => date('Y-m-d h:i:s')]);
                if ($res = $this->db->insert('prc_plan_item', $ppi_in)) {
                    $ret = true;
                } else {
                    $ret = true;
                }

                $ppv_in = array_merge($ppv[$i], ['ppm_id' => $ppm_id]);
                if ($res = $this->db->insert('prc_plan_volume', $ppv_in)) {
                    $ret = true;
                } else {
                    $ret = true;
                }

                $pph_in = array_merge($pph[$i], ['ppm_id' => $ppm_id]);
                if ($res = $this->db->insert('prc_plan_hist', $pph_in)) {
                    $ret = true;
                } else {
                    $ret = true;
                }
            }
        }

        $projj = [];
        for ($i=0; $i < count($ppm); $i++) {
            $it_id = $this->db->get_where('prc_plan_item', [
                'ppis_pr_number' => $ppi[$i]['ppis_pr_number'],
                'ppis_pr_item' => $ppi[$i]['ppis_pr_item'],
                'ppi_code' => $ppi[$i]['ppi_code']
            ]);
            
            if ($it_id->num_rows() > 0) {

                $ppm_v = $this->db->get_where('prc_plan_main', ['ppm_id' => $ck_pr['ppm_id']])->row_array();
                if (!in_array($ppm_v['ppm_id'], $projj)) {
                    array_push($projj, $ppm_v['ppm_id']);
                }
            }
        }

        for ($i=0; $i < count($projj); $i++) {
            $sql_sum = "
            select (sum(ppi.ppi_harga * ppi.ppi_jumlah)) as anggaran
            from prc_plan_item ppi
            where ppi.ppi_is_sap = 1 and ppi.ppm_id = $projj[$i]
            ";

            $anggaran = $this->db->query($sql_sum)->row('anggaran');

            $update = [
                'ppm_pagu_anggaran' => (int)$anggaran,
                'ppm_sisa_anggaran' => (int)$anggaran,
            ];
            $this->db->where('ppm_id', $projj[$i]);
            $this->db->update('prc_plan_main', $update);
        }

        return $ret;
    }

}

?>
