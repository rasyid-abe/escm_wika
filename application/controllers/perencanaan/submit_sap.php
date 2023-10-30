<?php

$user = $this->data['userdata'];
$ppm = $this->session->flashdata('ppm');
$ppi = $this->session->flashdata('ppi');
$ppv = $this->session->flashdata('ppv');
$pph = $this->session->flashdata('pph');

$userdata = [
    'ppm_district_id' => $user['district_id'],
    'ppm_district_name' => $user['district_name'],
    'ppm_planner' => $user['complete_name'],
];

$sts = [];
for ($i=0; $i < count($ppm); $i++) {
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
            'ppi_code' => $ppi[$i]['ppi_code'],
            'ppi_harga' => $ppi[$i]['ppi_harga'],
            'ppi_jumlah' => $ppi[$i]['ppi_jumlah']
        ]);
        if ($it_id->num_rows() > 0) {
            $this->db->where('ppis_pr_number', $ppi[$i]['ppis_pr_number']);
            $ppi_up = array_merge($ppi[$i], ['status_rkp' => "C"]);
            if ($this->db->update('prc_plan_item', $ppi_up)) {
                $ret = true;
            } else {
                $ret = true;
            }


            $sm_id = $this->db->get_where('prc_plan_volume', [
                'ppv_smbd_code' => $ppv[$i]['ppv_smbd_code'],
                'ppm_id' => $smbdid['ppm_id']
            ]);
            if ($sm_id->num_rows() > 0) {
                $this->db->where('ppv_smbd_code', $ppv[$i]['ppv_smbd_code']);
                if ($this->db->update('prc_plan_volume', $ppv[$i])) {
                    $ret = true;
                } else {
                    $ret = true;
                }
            } else {
                $ppv_in = array_merge($ppv[$i], ['ppm_id' => $smbdid['ppm_id']]);
                if ($res = $this->db->insert('prc_plan_volume', $ppv_in)) {
                    $ret = true;
                } else {
                    $ret = true;
                }
            }

        } else {
            $ppi_in = array_merge($ppi[$i], ['ppm_id' => $smbdid['ppm_id'], 'status_rkp' => "N"]);
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
        }

    } else {
        $ppm_in = array_merge($ppm[$i], $userdata);
        if ($this->db->insert('prc_plan_main', $ppm_in)) {
            $ret = true;
        } else {
            $ret = true;
        }

        $ppm_id = $this->db->insert_id();

        $ppi_in = array_merge($ppi[$i], ['ppm_id' => $ppm_id]);
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

echo json_encode(true);
