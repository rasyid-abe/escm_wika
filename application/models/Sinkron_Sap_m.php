<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sinkron_Sap_m extends CI_Model {

  public function do_sinkron(){

    $curl = curl_init();

    $this->db->trans_begin();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://fioridev.wika.co.id/ywikamm011/pr-outbound?sap-client=110',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_POSTFIELDS =>'{"s_banfn":""}',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Basic ' . base64_encode('WIKA_INT:Initial123'),
            'Content-Type: application/json',
            'sap-usercontext=sap-client=110'
        ),
    ));

    $response = curl_exec($curl);

    $arrays_data = json_decode($response, true);

    if (count($arrays_data["DATA"]) < 1){
        return 'not_found';
    }

    curl_close($curl);

    $no = 0;

    $ret = false;

    $all_ppm = $all_ppm_pr = $all_ppi = $all_ppi_pr = $all_ppv = $all_pph = [];

    foreach ($arrays_data["DATA"] as $key => $v) {
        $sdate = $v['BADAT'];
        $edate = $v['LFDAT'];
        $udate = $v['BADAT2'];
        $iddept = $this->db->get_where('adm_purchasing_group', ['pg_code' => $v['EKGRP']])->row('dept_id');

        $ppr = 'rkp';
        if (($v['BSART'] == 'ZPW2') && ($v['EKGRP'] == 'A0M')) {
            $ppr = 'rkp_matgis';
        } elseif ($v['BSART'] == 'ZPW1') {
            $ppr = 'rkap';
        }

        $harga_ = 0;
        if ($v['PEINH'] > 1) {
            $harga_ = (int)str_replace(array('.', ','), '', $v['PREIS']) / (int)$v['PEINH'];
        } else {
            $harga_ = (int)str_replace(array('.', ','), '', $v['PREIS']);
        }

        $arr_ppm = [
            'ppm_project_id' => (string)$v['PRCTR'],
            'ppm_project_name' => $v['KTEXT_PRC'],
            'ppms_project_id' => $v['PSPHI'],
            'ppm_subject_of_work' => $v['POST1_PRJ'],
            'ppms_planner_pos_code' => $v['SETNAME'],
            'ppm_planner_pos_name' => $v['DESCRIPT'],
            'ppms_storage_loc' => $v['LGORT'],
            'ppm_scope_of_work' => $v['LGOBE'],
            'ppm_ekgrp' => $v['EKGRP'],
            'ppm_dept_id' => $iddept,
            'ppm_dept_name' => $v['EKNAM'],
            'ppms_start_date' => $sdate != '0000-00-00' ? $sdate : null,
            'ppms_finish_date' => $edate != '0000-00-00' ? $edate : null,
            'ppm_is_sap' => 1,
            'ppm_type_of_plan' => $ppr,
        ];

        $arr_ppi = [
            'ppis_used_date' => $udate != '0000-00-00' ? $udate : null,
            'ppis_pr_number' => $v['BANFN'],
            'ppis_pr_item' => (string)$v['BNFPO'],
            'ppis_pr_type' => $v['BSART'],
            'ppis_acc_assig' => $v['KNTTP'],
            'ppis_cat_tech' => $v['PSTYP'],
            'ppi_code' => preg_replace('/\s+/', '', $v['MATNR']),
            'ppi_item_desc' => $v['MAKTX'],
            'ppi_jumlah' => (float)$v['MENGE'],
            'ppi_satuan' => $v['MEINS'],
            'ppi_harga' => $harga_,
            'ppi_temp_vol' => $v['PEINH'],
            'ppi_mata_uang' => $v['WAERS'],
            'ppis_wbs_element' => $v['PS_PSP_PNR'],
            'ppis_wbs_element_desc' => $v['PS_PSP_PNR'],
            'ppis_network' => $v['NPLNR'],
            'ppis_network_desc' => $v['KTEXT_NET'],
            'ppis_remark' => $v['REMARKS'],
            'ppi_delete_flag' => $v['LOEKZ'],
            'ppi_is_sap' => 1,
            'ppis_delivery_date' => $edate != '0000-00-00' ? $edate : null,
            'ppi_pr_order' => (int)$v['ZEBKN'],
        ];

        $arr_ppv = [
            'ppv_smbd_code' => preg_replace('/\s+/', '', $v['MATNR']),
            'ppv_unit' => $v['MEINS'],
            'ppv_main' => (float)$v['MENGE'],
            'ppv_remain' => (float)$v['MENGE'],
            'ppv_plus' => 0,
            'ppv_minus' => 0,
            'ppv_activity' => 0,
            'ppv_prc' => 'PR',
            'created_datetime' => date('Y-m-d H:i:s')
        ];

        $arr_pph = [
            'pph_main' => (float)$v['MENGE'],
            'pph_remain' => (float)$v['MENGE'],
            'pph_first' => $v['BANFN'],
            'pph_desc' => 0,
            'pph_date' => date('Y-m-d H:i:s')
        ];

        // paket
        $arr_ppm_pr = [
            'pr_dept_id' => $iddept,
            'pr_dept_name' => $v['EKNAM'],
            'pr_project_name' => $v['KTEXT_PRC'],
            'pr_subject_of_work' => $v['PRCTR'] . ' - ' . $v['POST1_PRJ'],
            'pr_scope_of_work' => $v['LGOBE'],
            'pr_ekgrp' => $v['EKGRP'],
            'pr_spk_code' => $v['PRCTR'],
            'pr_created_date' => date('Y-m-d h:i:s'),
            'pr_status' => 1000,
            'pr_doc_type' => $v['BSART'],
            'pr_jadwal_pengadaan_awal' => $sdate != '0000-00-00' ? $sdate : null,
            'pr_jadwal_pengadaan_akhir' => $edate != '0000-00-00' ? $edate : null,
            'pr_is_sap' => 1,
            'pr_packet' => 'Pengadaan ' . $v['MAKTX'],
            'pr_type_of_plan' => $ppr,
        ];

        $arr_ppi_pr = [
            'ppi_code' => preg_replace('/\s+/', '', $v['MATNR']),
            'ppi_description' => $v['MAKTX'],
            'ppi_quantity' => (float)$v['MENGE'],
            'ppi_unit' => $v['MEINS'],
            'ppi_price' => (int)str_replace(array('.', ','), '', $v['PREIS']),
            'ppi_ppn' => 0,
            'ppi_pph' => 0,
            'ppis_pr_number' => (string)$v['BANFN'],
            'ppis_pr_item' => (string)$v['BNFPO'],
            'ppis_delivery_date' => $edate != '0000-00-00' ? $edate : null,
            'ppis_pr_type' => $v['BSART'],
            'ppis_acc_assig' => $v['KNTTP'],
            'ppis_cat_tech' => $v['PSTYP'],
            'ppi_delete_flag' => $v['LOEKZ'],
            'ppi_currency' => $v['WAERS'],
            'ppi_temp_vol' => $v['PEINH'],
            'ppi_pr_order' => (int)$v['ZEBKN']
        ];

        array_push($all_ppm, $arr_ppm);
        array_push($all_ppi, $arr_ppi);
        array_push($all_ppv, $arr_ppv);
        array_push($all_pph, $arr_pph);

        // paket
        array_push($all_ppm_pr, $arr_ppm_pr);
        array_push($all_ppi_pr, $arr_ppi_pr);
    }

    $user = $this->data['userdata'];

    $ppm = $all_ppm;
    $ppi = $all_ppi;
    $ppv = $all_ppv;
    $pph = $all_pph;

    // paket
    $ppm_pr = $all_ppm_pr;
    $ppi_pr = $all_ppi_pr;

    $userdata = [
        'ppm_district_id' => $user['district_id'],
        'ppm_district_name' => $user['district_name'],
        'ppm_planner' => $user['complete_name'],
    ];

    $sts = [];

    for ($i=0; $i < count($ppm); $i++) {
        $pr_number_new = $this->Procpr_m->getUrutPR();
        $pr_id = $this->db->get_where('prc_plan_main', ['ppm_project_id' => $ppm[$i]['ppm_project_id']]);

        if ($pr_id->num_rows() > 0) {
            $smbdid = $pr_id->row_array();
            $this->db->where('ppm_project_id', $ppm[$i]['ppm_project_id']);
            if ($this->db->update('prc_plan_main', $ppm[$i])) {
                $ret = true;
            } else {
                $ret = false;
            }

            $it_id = $this->db->get_where('prc_plan_item', [
                'ppis_pr_number' => $ppi[$i]['ppis_pr_number'],
                'ppis_pr_item' => $ppi[$i]['ppis_pr_item'],
                'ppi_code' => $ppi[$i]['ppi_code']
            ]);

            if ($it_id->num_rows() > 0) {
                $this->db->where('ppis_pr_number', $ppi[$i]['ppis_pr_number']);
                $this->db->where('ppis_pr_item', $ppi[$i]['ppis_pr_item']);
                $ppi_up = array_merge($ppi[$i], ['status_rkp' => "C", 'ppi_update_at' => date('Y-m-d h:i:s')]);

                // deletion flag
                if(($ppi[$i]['ppi_delete_flag'] == 'X') || ($ppi[$i]['ppi_delete_flag'] == 'x') ){
                    $ppi_up = array_merge($ppi[$i], ['status_rkp' => "D", 'ppi_update_at' => date('Y-m-d h:i:s')]);
                }

                if ($this->db->update('prc_plan_item', $ppi_up)) {
                    $ret = true;
                } else {
                    $ret = true;
                }

                // paket
                $this->db->where('ppm_id', $smbdid['ppm_id']);
                if ($this->db->update('prc_pr_main', $ppm_pr[$i])) {
                    $ret = true;
                } else {
                    $ret = true;
                }

                $this->db->where('ppis_pr_number', $ppi_pr[$i]['ppis_pr_number']);
                $this->db->where('ppis_pr_item', $ppi_pr[$i]['ppis_pr_item']);
                $ppi_pr_up = array_merge($ppi_pr[$i], ['ppi_status_update' => "C", 'ppi_update_at' => date('Y-m-d h:i:s')]);

                // deletion flag
                if($ppi[$i]['ppi_delete_flag'] == 'X') {
                    $ppi_pr_up = array_merge($ppi_pr[$i], ['ppi_status_update' => "D", 'ppi_update_at' => date('Y-m-d h:i:s')]);
                }

                if ($this->db->update('prc_pr_item', $ppi_pr_up)) {
                    $ret = true;
                } else {
                    $ret = true;
                }
                // end paket

                $sm_id = $this->db->get_where('prc_plan_volume', [
                    'ppv_smbd_code' => $ppv[$i]['ppv_smbd_code'],
                    'ppm_id' => $smbdid['ppm_id']
                ]);

                if ($sm_id->num_rows() < 1) {
                    $ppv_in = array_merge($ppv[$i], ['ppm_id' => $smbdid['ppm_id']]);
                    if ($res = $this->db->insert('prc_plan_volume', $ppv_in)) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }
                } else {
                    $this->db->where('ppv_smbd_code', $ppv[$i]['ppv_smbd_code']);
                    if ($this->db->update('prc_plan_volume', $ppv[$i])) {
                        $ret = true;
                    } else {
                        $ret = true;
                    }
                }

            } else {
                $ppi_in = array_merge($ppi[$i], ['ppm_id' => $smbdid['ppm_id'], 'status_rkp' => "N", 'ppi_update_at' => date('Y-m-d h:i:s')]);
                if ($res = $this->db->insert('prc_plan_item', $ppi_in)) {
                    $ret = true;
                } else {
                    $ret = false;
                }

                $ppv_in = array_merge($ppv[$i], ['ppm_id' => $smbdid['ppm_id']]);
                if ($res = $this->db->insert('prc_plan_volume', $ppv_in)) {
                    $ret = true;
                } else {
                    $ret = true;
                }

                // paket
                $ppm_pr_in = array_merge($ppm_pr[$i], ['ppm_id' => $smbdid['ppm_id'], 'pr_number' => $pr_number_new]);
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
        if (!in_array($ppm[$i]['ppm_project_id'], $projj)) {
            array_push($projj, $ppm[$i]['ppm_project_id']);
        }
    }

    foreach ($projj as $k => $v) {
        $pid = $this->db->get_where('prc_plan_main', ['ppm_project_id' => $v])->row('ppm_id');
        $sql_sum = "
        select (sum(ppi.ppi_harga * ppi.ppi_jumlah)) as anggaran
        from prc_plan_item ppi
        where ppi.ppi_is_sap = 1 and ppi.ppm_id = $pid
        ";

        $anggaran = $this->db->query($sql_sum)->row('anggaran');

        $update = [
            'ppm_pagu_anggaran' => (int)$anggaran,
            'ppm_sisa_anggaran' => (int)$anggaran,
        ];
        $this->db->where('ppm_id', $pid);
        $this->db->update('prc_plan_main', $update);
    }

    if ($this->db->trans_status() == FALSE) {

        $this->db->trans_rollback();
        return 'fail';

    } else {

        $this->db->trans_commit();
        return 'success';
    }

  }

}
