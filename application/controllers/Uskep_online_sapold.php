<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Uskep_online_sap extends Telescoope_Controller
{
    var $data;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array("Administration_m", "Administration_m", "Comment_m", "Procedure_m", "Procrfq_m"));

        $this->data['date_format'] = "h:i A | d M Y";
        $this->data['data'] = array();
        $this->data['post'] = $this->input->post();
        $this->data['dir'] = 'administration';
        $this->data['controller_name'] = $this->uri->segment(1);

        $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');
        $userdata = $this->Administration_m->getLogin();

        $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();
        $this->data['rfq_number'] = $this->Procrfq_m->getUrutRFQ();
        $this->data['projects'] = $this->db->get_where('prc_plan_main', ['ppm_is_sap' => 1])->result_array();

        if (empty($userdata)) {
            redirect(site_url('log/in'));
        }
    }

    public function remove_data($rfq)
    {
        $this->db->where('no_rfq', $rfq);
        $this->db->where('is_sap', 1);
        $del = $this->db->delete('uskep_online');
        if ($del) {
            echo json_encode(1);
        } else {
            echo json_encode(0);
        }
    }

    public function get_list_vendor()
    {
        $data = $this->Vendor_m->getVendorList()->result_array();
        $pic = $this->db->get('adm_user')->result_array();
        echo json_encode([$data, $pic]);
    }

    public function get_list_pic()
    {
        $pic = $this->db->get('adm_user')->result_array();
        echo json_encode($pic);
    }

    public function check_typlan_dsp()
    {
        $d = $this->input->post('tplan');
        echo json_encode(
            $this->db->get_where('adm_matriks_kegiatan', [
                'tipe_plan' => $d,
                'tipe_uskep' => 'PENILAIAN'
            ])->result()
        );
    }

    public function check_komisi_dsp()
    {
        $d = $this->input->post('tplan');
        $e = $this->input->post('komisi');
        $s = $this->input->post('spk');

        $id = $this->db->get_where('adm_matriks_kegiatan', [
            'tipe_plan' => $d,
            'tipe_uskep' => 'PENILAIAN',
            'komisi' => $e
        ])->row('id');
        $data = $this->db->get_where('adm_matriks_kewenangan_kegiatan', [
            'kegiatan_id' => $id
        ])->result();

        $nm_kew = [];
        foreach ($data as $k => $v) {

            if($v->job_title == "KEPALA SEKSI" && $d == "rkp")
            {
                $this->db->like('nm_jabatan', $v->job_title);
                $this->db->where('nm_fungsi_bidang', $v->nm_fungsi_bidang);

            } else {
                $this->db->where('nm_jabatan', $v->job_title);

                if ($v->job_title == "DIREKTUR" && $d == "rkp") {
                    $this->db->where('posisi', 'DIREKTUR OPERASI 1');
                } else if($v->job_title == "DIREKTUR" && $d == "rkp_matgis") {
                    $this->db->where('posisi', 'DIREKTUR QUALITY HEALTH SAFETY AND ENVIRONTMENT');
                } else if($v->job_title == "MANAJER" && $d == "rkp_matgis") {
                    $this->db->where('nm_biro', 'SUB DEPARTEMEN MATERIAL DAN JASA STRATEGIS');
                } else if($v->job_title == "MANAJER" && $d == "rkp") {
                    $this->db->where('nm_direktorat', 'DIVISI SUPPLY CHAIN MANAGEMENT');
                } else if($v->job_title == "DIREKTUR" && $d == "rkap") {
                    $this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');
                } else if($v->job_title == "KEPALA DIVISI" && $d == "rkap") {
                    $this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');
                } else if($v->job_title == "PIC ANGGARAN") {
                    $this->db->where('posisi', 'KEPALA DIVISI KEUANGAN');
                } else if(strpos($v->job_title,"MANAJER PROYEK")) {
                    $this->db->where('no_spk', $s);
                }

            }

    		$this->db->where('status', 'aktif');
    		$this->db->order_by('nm_peg', 'asc');

            $nm_kew[] = $this->db->get('response_hcis')->result();
        }

        $merged = array_merge([], ...$nm_kew);

        echo json_encode([$data,$merged]);
    }

    public function dsp($win, $mtd)
    {
        $view = 'uskep_online/dsp_sap_v';

    	$data = array();
    	$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();

        $data['winner'] = $win;
        $data['mtd'] = $mtd;
        $data['rfq'] = $this->Procrfq_m->getUrutRFQ();
        $data['k_spk'] = '';
        $data['k_proyek'] = '';
    	$this->template($view,"USKEP ONLINE",$data);
    }

    public function edit_dsp($cid = '', $rfqcode)
    {
        include("uskep_online/sap/edit_dsp.php");
    }

    public function submit_dsp()
    {
        include("uskep_online/submit_dsp.php");
    }

    public function check_kewenangan_dpkn()
    {
        $tipePlan = $this->input->post('tipePlan');
        $tipeProyek = $this->input->post('tipeProyek');
        $komisi = $this->input->post('komisi');
        $spk = $this->input->post('spk');

        $id = $this->db->get_where('adm_matriks_kegiatan', [
            'tipe_plan' => $tipePlan,
            'tipe_proyek' => $tipeProyek,
            'tipe_uskep' => 'BAKP',
            'komisi' => $komisi
        ])->row('id');


        $this->db->order_by('order_no', 'asc');
        $data = $this->db->get_where('adm_matriks_kewenangan_kegiatan', [
            'kegiatan_id' => $id
        ])->result();

        $d[] = $data[6];

        $arr = $res = [];
        foreach ($data as $k => $v) {
            if(!strpos($v->job_title,"MANAJER PROYEK"))
    		{
    			$this->db->where('nm_jabatan', $v->job_title);
    		}
    		if($v->job_title == "DIREKTUR" && $tipePlan == "rkp")
    		{
    			$this->db->where('posisi', 'DIREKTUR OPERASI 1');
    		}
    		else if($v->job_title == "DIREKTUR" && $tipePlan == "rkp_matgis")
    		{
    			$this->db->where('posisi', 'DIREKTUR QUALITY HEALTH SAFETY AND ENVIRONTMENT');
    		}
    		else if($v->job_title == "MANAJER" && $tipePlan == "rkp_matgis")
    		{
    			$this->db->where('nm_biro', 'SUB DEPARTEMEN MATERIAL DAN JASA STRATEGIS');
    		}

    		else if($v->job_title == "DIREKTUR" && $tipePlan == "rkap")
    		{
    			$this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');
    		}

    		else if($v->job_title == "KEPALA DIVISI" && $tipePlan == "rkap")
    		{
    			$this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');

    		}
    		else if($v->job_title == "KEPALA DIVISI" && $v->nm_fungsi_bidang == "OPERASI")
    		{
    				$this->db->like('direksi', 'DIREKTORAT OPERASI');
    				// $this->db->where('kd_dep', $tender['ptm_dep_code']);
    		}
    		else if($v->job_title == "PIC ANGGARAN")
    		{
    			$this->db->where('posisi', 'KEPALA DIVISI KEUANGAN');
    		}
    		else if(strpos($v->job_title,"MANAJER PROYEK"))
    		{
    			$this->db->like('nm_jabatan', $v->job_title);
    			// $this->db->where('nm_fungsi_bidang', $v->nm_fungsi_bidang);
    			if($v->job_title == "MANAJER PROYEK MEGA")
    			{
    				$this->db->or_where('nm_jabatan', 'MANAJER PROYEK BESAR');
    			}

    			if($spk != "")
    			{
    				$this->db->where('no_spk', $spk);
    				$this->db->or_where('no_spk_rangkap', $spk);
    			}
    		}
    		else {
                $this->db->where('nm_fungsi_bidang', $v->nm_fungsi_bidang);
    		}
    		$this->db->where('status', 'aktif');
    		$nm = $this->db->get('response_hcis')->result();

            $arr['job_title'] = $v->job_title;
            $arr['nm_fungsi_bidang'] = $v->nm_fungsi_bidang;
            $arr['posisi'] = $v->posisi;
            $arr['kategori'] = $v->kategori;

            // if(!strpos($v->job_title,"MANAJER PROYEK")) {
    		// 	$this->db->where('nm_jabatan', $v->job_title);
    		// }
            //
            // if ($v->job_title == "DIREKTUR" && $tipePlan == "rkp") {
    		// 	$this->db->where('posisi', 'DIREKTUR OPERASI 1');
    		// } else if($v->job_title == "DIREKTUR" && $tipePlan == "rkp_matgis") {
    		// 	$this->db->where('posisi', 'DIREKTUR QUALITY HEALTH SAFETY AND ENVIRONTMENT');
    		// } else if($v->job_title == "MANAJER" && $tipePlan == "rkp_matgis") {
    		// 	$this->db->where('nm_biro', 'SUB DEPARTEMEN MATERIAL DAN JASA STRATEGIS');
    		// 	//SUB DEPARTEMEN MATERIAL DAN JASA STRATEGIS
    		// } else if($v->job_title == "DIREKTUR" && $tipePlan == "rkap") {
    		// 	$this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');
    		// } else if($v->job_title == "KEPALA DIVISI" && $tipePlan == "rkap") {
    		// 	$this->db->where('nm_fungsi_bidang !=', 'ENGINEERING');
    		// } else if($v->job_title == "KEPALA DIVISI" && $v->nm_fungsi_bidang == "OPERASI") {
    		// 	$this->db->like('direksi', 'DIREKTORAT OPERASI');
    		// } else if($v->job_title == "PIC ANGGARAN") {
    		// 	$this->db->where('posisi', 'KEPALA DIVISI KEUANGAN');
    		// } else if(strpos($v->job_title,"MANAJER PROYEK")) {
            //     if ($v->job_title == 'MANAJER PROYEK MEGA') {
            //         $this->db->like('nm_jabatan', 'MANAJER PROYEK BESAR');
            //     } else {
            //         $this->db->like('nm_jabatan', $v->job_title);
            //     }
            //     $this->db->where('nm_fungsi_bidang', $v->nm_fungsi_bidang);
            //     if ($spk != "") {
            //         $this->db->where('no_spk', $spk);
            //         $this->db->or_where('no_spk_rangkap', $spk);
            //     }
    		// }
    		// $this->db->where('status', 'aktif');
            // $nm = $this->db->get('response_hcis')->result();

            $arr['nama'] = [];
            foreach ($nm as $i => $e) {
                $arr['nama'][] = $e->nm_peg;
            }

            array_push($res, $arr);
        }
        echo json_encode([$res, $id]);
    }

    public function dpkn()
    {
        include("uskep_online/sap/dpkn.php");
    }

    public function edit_dpkn($cid = '', $rfqcode)
    {
        include("uskep_online/sap/edit_dpkn.php");
    }

    public function submit_dpkn()
    {
        include("uskep_online/submit_dpkn.php");
    }

    public function bakp()
    {
        include("uskep_online/sap/bakp.php");
    }

    public function edit_bakp($cid = '', $rfqcode)
    {
        include("uskep_online/sap/edit_bakp.php");
    }

    public function submit_bakp()
    {
        include("uskep_online/submit_bakp.php");
    }

    public function uskep_pdf($rfq)
    {
        $view = "uskep_online/pdf/uskep_pdf";

        $db = $this->db->get_where('uskep_online', ['no_rfq' => $rfq])->row_array();
        $bakp = json_decode($db['data_bakp']);
        $dpkn = json_decode($db['data_dpkn']);
        $dsp = json_decode($db['data_dsp']);
        $esign = json_decode($db['esign_dpkn']);
        $alpha = range('A', 'Z');

        $vendor = [];
        foreach (json_decode($db['vendor']) as $key => $value) {
            $vend = $this->db->get_where('vnd_header', ['vendor_id' => $value])->row_array();
    		array_push($vendor, $vend);
        }
        $cols = count($vendor);

        $data_bakp = [];
        $data_bakp['tek_perc'] = $dsp->teknis->percent_teknis;
    	$data_bakp['threshold'] = $dsp->teknis->threshold;
        $data_bakp['hrg_perc'] = $dsp->harga->percent_harga;
        $data_bakp['hrg_hps'] = $dsp->harga->nilai_hps;
        $data_bakp['nilai_rab'] = $bakp->nilai_rab;
        $data_bakp['cols'] = $cols;
        $data_bakp['pengadaan'] = $db['paket_pengadaan'];
        $data_bakp['proyek'] = $db['proyek'];
        $data_bakp['no_rfq'] = $db['no_rfq'];
        $data_bakp['vendor'] = $vendor;
        $data_bakp['nomor_bakp'] = $bakp->nomor_bakp;
        $data_bakp['tgl_bakp'] = $bakp->tgl_bakp;
        $data_bakp['nilai_rab'] = $bakp->nilai_rab;
        $data_bakp['hari'] = $bakp->hari;
        $data_bakp['tanggal'] = $bakp->tanggal;
        $data_bakp['bulan'] = $bakp->bulan;
        $data_bakp['tahun'] = $bakp->tahun;
        $data_bakp['fultgl'] = $bakp->fultgl;
        $data_bakp['tempat'] = $bakp->tempat;
        $data_bakp['daftar'] = $bakp->daftar;
        $data_bakp['penawaran'] = $bakp->penawaran;
        $data_bakp['catatan_tbl1'] = $bakp->catatan_tbl1;
        $data_bakp['status21'] = $bakp->status21;
        $data_bakp['catatan_tbl21'] = $bakp->catatan_tbl21;
        $data_bakp['nilai22'] = $bakp->nilai22;
        $data_bakp['bobot22'] = $bakp->bobot22;
        $data_bakp['catatan_tbl22'] = $bakp->catatan_tbl22;
        $data_bakp['nego23'] = $bakp->nego23;
        $data_bakp['effi23'] = $bakp->effi23;
        $data_bakp['nilai23'] = $bakp->nilai23;
        $data_bakp['bobot23'] = $bakp->bobot23;
        $data_bakp['nilai24'] = $bakp->nilai24;
        $data_bakp['rank24'] = $bakp->rank24;
        $data_bakp['tatatan_tbl24'] = $bakp->tatatan_tbl24;
        $data_bakp['ven_win'] = $bakp->ven_win;
        $data_bakp['ven_omZ'] = $bakp->ven_omZ;
        $data_bakp['note'] = $bakp->note;
        $data_bakp['esign'] = $esign;
        $data_bakp['title'] = $this->db->get_where('adm_matriks_kegiatan', ['id'=>$esign->keg_id])->row_array();
        $data_bakp['mtode'] = $db['metode_pengadaan'];


        $devv = [];
        foreach ($dsp->harga->deviasi as $key => $value) {
            $devv[] = number_format((int)$value,0,',','.');
        }

        $data_dsp = [];
        $data_dsp['pengadaan'] = $db['paket_pengadaan'];
        $data_dsp['proyek'] = $db['proyek'];
        $data_dsp['no_rfq'] = $db['no_rfq'];
        $data_dsp['vendor'] = $vendor;
        $data_dsp['adm_status'] = $dsp->administrasi->status_vendor;
        $data_dsp['adm_poin'] = $dsp->administrasi->poin;
        $data_dsp['cols'] = $cols;
        $data_dsp['alpha'] = $alpha;
        $data_dsp['tek_status'] = $dsp->teknis->status;
        $data_dsp['tek_percent'] = $dsp->teknis->percent_teknis;
        $data_dsp['threshold'] = $dsp->teknis->threshold;
        $data_dsp['tek_nilai'] = $dsp->teknis->nilai;
        $data_dsp['tek_bobot'] = $dsp->teknis->bobot;
        $data_dsp['tek_poin'] = $dsp->teknis->poin;
        $data_dsp['hrg_percent'] = $dsp->harga->percent_harga;
        $data_dsp['hrg_hps'] = $dsp->harga->nilai_hps;
        $data_dsp['hrg_nilai'] = $dsp->harga->nilai;
        $data_dsp['hrg_bobot'] = $dsp->harga->bobot;
        $data_dsp['hrg_nego'] = $dsp->harga->harga_nego;
        $data_dsp['hrg_dev'] = $devv;
        $data_dsp['hrg_eva'] = $dsp->harga->evaluasi;
        $data_dsp['hrg_rank'] = $dsp->harga->peringkat;
        $data_dsp['esign'] = json_decode($db['esign_dsp']);



        $data_depkn = [];
        $data_depkn['cols'] = $cols;
        $data_depkn['pengadaan'] = $db['paket_pengadaan'];
        $data_depkn['proyek'] = $db['proyek'];
        $data_depkn['no_rfq'] = $db['no_rfq'];
        $data_depkn['vendor'] = $vendor;
        $data_depkn['tgl_penawaran'] = $dpkn->tgl_penawaran;
        $data_depkn['klarifikasi_nego'] = $dpkn->klarifikasi_nego;
        $data_depkn['poin_pena'] = $dpkn->poin_penawaran;
        $data_depkn['rab_pena'] = $dpkn->total_rab;
        $data_depkn['vend_pena'] = $dpkn->total_penawaran_vendor;
        $data_depkn['poin_nego'] = $dpkn->poin_negosiasi;
        $data_depkn['rab_nego'] = $dpkn->total_rab;
        $data_depkn['vend_nego'] = $dpkn->total_negosiai_vendor;
        $data_depkn['klarifikasi'] = $dpkn->klarifikasi;
        $data_depkn['esign'] = $esign;
        $data_depkn['title'] = $this->db->get_where('adm_matriks_kegiatan', ['id'=>$esign->keg_id])->row_array();
        $data_depkn['idx_ketua'] = array_search('Ketua', $esign->kategori);
        $data_depkn['idx_usulan'] = array_search('Mengusulkan', $esign->posisi);
        $data_depkn['notes'] = $dpkn->catatan;
        $data_depkn['data_uskep'] = $this->Procrfq_m->getUskepData($rfq)->row_array();


        $data = [];
        $data['bakp'] = $data_bakp;
        $data['dsp'] = $data_dsp;
        $data['depkn'] = $data_depkn;

        $this->load->view($view, $data);


        $html = $this->output->get_output();

        $dompdf=new Dompdf\Dompdf();
        $dompdf->set_paper('a4');
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option("isPhpEnabled", true);

        $dompdf->load_html($html);
        $dompdf->render();

        $filename = "USKEP-".date('YmdHis').'-'.$rfq.'.pdf';
        $output = $dompdf->output();
        file_put_contents('uploads/'.$filename, $output);

        $data_update = array(
        	'bakp_filename' =>$filename
        );
        $this->db->where('no_rfq', $rfq);
        $this->db->update('uskep_online', $data_update);

        $full_url = base_url()."uploads/".$filename;
        redirect($full_url);
    }

    public function dsp_pdf($rfq)
    {
        $view = "uskep_online/pdf/dsp_pdf";

        $db = $this->db->get_where('uskep_online', ['no_rfq' => $rfq])->row_array();
        $dsp = json_decode($db['data_dsp']);
        $esign = json_decode($db['esign_dsp']);
        $alpha = range('A', 'Z');

        $vendor = [];
        foreach (json_decode($db['vendor']) as $key => $value) {
            $vend = $this->db->get_where('vnd_header', ['vendor_id' => $value])->row_array();
    		array_push($vendor, $vend);
        }
        $cols = count($vendor);

        $data = [];
        $data['pengadaan'] = $db['paket_pengadaan'];
        $data['proyek'] = $db['proyek'];
        $data['no_rfq'] = $db['no_rfq'];
        $data['vendor'] = $vendor;
        $data['adm_status'] = $dsp->administrasi->status_vendor;
        $data['adm_poin'] = $dsp->administrasi->poin;
        $data['cols'] = $cols;
        $data['alpha'] = $alpha;

        $data['tek_status'] = $dsp->teknis->status;
        $data['tek_percent'] = $dsp->teknis->percent_teknis;
        $data['threshold'] = $dsp->teknis->threshold;
        $data['tek_nilai'] = $dsp->teknis->nilai;
        $data['tek_bobot'] = $dsp->teknis->bobot;
        $data['tek_poin'] = $dsp->teknis->poin;

        $data['hrg_percent'] = $dsp->harga->percent_harga;
        $data['hrg_hps'] = $dsp->harga->nilai_hps;
        $data['hrg_nilai'] = $dsp->harga->nilai;
        $data['hrg_bobot'] = $dsp->harga->bobot;
        $data['hrg_nego'] = $dsp->harga->harga_nego;

        $devv = [];
        foreach ($dsp->harga->deviasi as $key => $value) {
            $devv[] = number_format((int)$value,0,',','.');
        }

        $data['hrg_dev'] = $devv;
        $data['hrg_eva'] = $dsp->harga->evaluasi;
        $data['hrg_rank'] = $dsp->harga->peringkat;

        $data['esign'] = $esign;

        $this->load->view($view, $data);

        $html = $this->output->get_output();

        $dompdf=new Dompdf\Dompdf();
        if ($cols > 4) {
            $dompdf->set_paper('a3');
        } else {
            $dompdf->set_paper('a4');
        }
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option("isPhpEnabled", true);

        $dompdf->load_html($html);
        $dompdf->render();

        $filename = "SISTEMPENILAIAN-".date('YmdHis').'-'.$rfq.'.pdf';

        $data_update = array(
        	'dsp_filename' =>$filename
        );
        $this->db->where('no_rfq', $rfq);
        $this->db->update('uskep_online', $data_update);

        $output = $dompdf->output();
        file_put_contents('uploads/'.$filename, $output);

        $full_url = base_url()."uploads/".$filename;
        redirect($full_url);

        // echo "<pre>";
        // print_r($db);

        // add cukup sekali
        // langsung edit

        // dpkn catatan optional
        // bakpl catatan optional
        // bakp poin catatan optional
        // pdf dulu
        // esign

    }

    public function dpkn_pdf($rfq)
    {
        $view = "uskep_online/pdf/dpkn_pdf";

        $db = $this->db->get_where('uskep_online', ['no_rfq' => $rfq])->row_array();
        $dpkn = json_decode($db['data_dpkn']);
        $esign = json_decode($db['esign_dpkn']);
        $alpha = range('A', 'Z');

        $vendor = [];
        foreach (json_decode($db['vendor']) as $key => $value) {
            $vend = $this->db->get_where('vnd_header', ['vendor_id' => $value])->row_array();
    		array_push($vendor, $vend);
        }
        $cols = count($vendor);

        $data = [];
        $data['cols'] = $cols;
        $data['pengadaan'] = $db['paket_pengadaan'];
        $data['proyek'] = $db['proyek'];
        $data['no_rfq'] = $db['no_rfq'];
        $data['vendor'] = $vendor;
        $data['tgl_penawaran'] = $dpkn->tgl_penawaran;
        $data['klarifikasi_nego'] = $dpkn->klarifikasi_nego;
        $data['poin_pena'] = $dpkn->poin_penawaran;
        $data['rab_pena'] = $dpkn->total_rab;
        $data['vend_pena'] = $dpkn->total_penawaran_vendor;
        $data['poin_nego'] = $dpkn->poin_negosiasi;
        $data['rab_nego'] = $dpkn->total_rab;
        $data['vend_nego'] = $dpkn->total_negosiai_vendor;
        $data['klarifikasi'] = $dpkn->klarifikasi;

        $data['esign'] = $esign;
        $data['title'] = $this->db->get_where('adm_matriks_kegiatan', ['id'=>$esign->keg_id])->row_array();
        $data['idx_ketua'] = array_search('Ketua', $esign->kategori);
        $data['idx_usulan'] = array_search('Mengusulkan', $esign->posisi);

        $data['notes'] = $dpkn->catatan;
        $data['data_uskep'] = $this->Procrfq_m->getUskepData($rfq)->row_array();
        $this->load->view($view, $data);


        $html = $this->output->get_output();

        $dompdf=new Dompdf\Dompdf();
        $dompdf->set_paper('a3', 'landscape');
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option("isPhpEnabled", true);

        $dompdf->load_html($html);
        $dompdf->render();

        $filename = "DEPKN-".date('YmdHis').'-'.$rfq.'.pdf';
        $output = $dompdf->output();
        file_put_contents('uploads/'.$filename, $output);

        $data_update = array(
        	'dpkn_filename' =>$filename
        );
        $this->db->where('no_rfq', $rfq);
        $this->db->update('uskep_online', $data_update);

        $full_url = base_url()."uploads/".$filename;
        redirect($full_url);
    }

    public function bakp_pdf($rfq)
    {
        $view = "uskep_online/pdf/bakp_pdf";

        $db = $this->db->get_where('uskep_online', ['no_rfq' => $rfq])->row_array();
        $bakp = json_decode($db['data_bakp']);
        $dsp = json_decode($db['data_dsp']);
        $esign = json_decode($db['esign_dpkn']);
        $alpha = range('A', 'Z');

        $vendor = [];
        foreach (json_decode($db['vendor']) as $key => $value) {
            $vend = $this->db->get_where('vnd_header', ['vendor_id' => $value])->row_array();
    		array_push($vendor, $vend);
        }
        $cols = count($vendor);

        $data = [];
        $data['tek_perc'] = $dsp->teknis->percent_teknis;
    	$data['threshold'] = $dsp->teknis->threshold;
        $data['hrg_perc'] = $dsp->harga->percent_harga;
        $data['hrg_hps'] = $dsp->harga->nilai_hps;
        $data['nilai_rab'] = $bakp->nilai_rab;
        $data['cols'] = $cols;
        $data['pengadaan'] = $db['paket_pengadaan'];
        $data['proyek'] = $db['proyek'];
        $data['no_rfq'] = $db['no_rfq'];
        $data['vendor'] = $vendor;
        $data['nomor_bakp'] = $bakp->nomor_bakp;
        $data['tgl_bakp'] = $bakp->tgl_bakp;
        $data['nilai_rab'] = $bakp->nilai_rab;
        $data['hari'] = $bakp->hari;
        $data['tanggal'] = $bakp->tanggal;
        $data['bulan'] = $bakp->bulan;
        $data['tahun'] = $bakp->tahun;
        $data['fultgl'] = $bakp->fultgl;
        $data['tempat'] = $bakp->tempat;
        $data['daftar'] = $bakp->daftar;
        $data['penawaran'] = $bakp->penawaran;
        $data['catatan_tbl1'] = $bakp->catatan_tbl1;
        $data['status21'] = $bakp->status21;
        $data['catatan_tbl21'] = $bakp->catatan_tbl21;
        $data['nilai22'] = $bakp->nilai22;
        $data['bobot22'] = $bakp->bobot22;
        $data['catatan_tbl22'] = $bakp->catatan_tbl22;
        $data['nego23'] = $bakp->nego23;
        $data['effi23'] = $bakp->effi23;
        $data['nilai23'] = $bakp->nilai23;
        $data['bobot23'] = $bakp->bobot23;
        $data['nilai24'] = $bakp->nilai24;
        $data['rank24'] = $bakp->rank24;
        $data['tatatan_tbl24'] = $bakp->tatatan_tbl24;
        $data['ven_win'] = $bakp->ven_win;
        $data['ven_omZ'] = $bakp->ven_omZ;
        $data['note'] = $bakp->note;
        $data['esign'] = $esign;
        $data['title'] = $this->db->get_where('adm_matriks_kegiatan', ['id'=>$esign->keg_id])->row_array();
        $data['mtode'] = $db['metode_pengadaan'];
        $this->load->view($view, $data);


        $html = $this->output->get_output();

        $dompdf=new Dompdf\Dompdf();
        $dompdf->set_paper('a4');
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->set_option("isPhpEnabled", true);

        $dompdf->load_html($html);
        $dompdf->render();

        $filename = "BAKP-".date('YmdHis').'-'.$rfq.'.pdf';
        $output = $dompdf->output();
        file_put_contents('uploads/'.$filename, $output);

        $data_update = array(
        	'bakp_filename' =>$filename
        );
        $this->db->where('no_rfq', $rfq);
        $this->db->update('uskep_online', $data_update);

        $full_url = base_url()."uploads/".$filename;
        redirect($full_url);
    }

    public function privyDSP()
    {
        $view = 'uskep_online/esign/request_esign_dsp_sap_v';

        $data = array();

        $rfqNo = (isset($post['id'])) ? $post['id'] : $this->uri->segment(3, 0);
        $privyId = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

        $data['id'] = $rfqNo;
        $data['privy'] = $privyId;

        $row = $this->db->get_where('uskep_online', ['no_rfq' => $rfqNo])->row_array();
        $data['dokumen'] = 'uploads/' . $row['dsp_filename'];


        $this->template($view,"E-sign Form",$data);
    }

    public function privyDPKN()
    {
        $view = 'uskep_online/esign/request_esign_dpkn_v';

        $data = array();

        $rfqNo = (isset($post['id'])) ? $post['id'] : $this->uri->segment(3, 0);
        $privyId = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

        $data['id'] = $rfqNo;
        $data['privy'] = $privyId;

        $row = $this->db->get_where('uskep_online', ['no_rfq' => $rfqNo])->row_array();
        $data['dokumen'] = 'uploads/' . $row['dpkn_filename'];

        $this->template($view,"E-sign Form",$data);
    }

    public function privyBAKP()
    {
        $view = 'uskep_online/esign/request_esign_bakp_v';

        $data = array();

        $rfqNo = (isset($post['id'])) ? $post['id'] : $this->uri->segment(3, 0);
        $privyId = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

        $data['id'] = $rfqNo;
        $data['privy'] = $privyId;

        $row = $this->db->get_where('uskep_online', ['no_rfq' => $rfqNo])->row_array();
        $data['dokumen'] = 'uploads/' . $row['bakp_filename'];

        $this->template($view,"E-sign Form",$data);
    }

    public function get_list_items()
    {
        $data = $this->db->get_where('prc_plan_item', ['ppm_id' => $this->input->post('ppm_id')])->result_array();
        echo json_encode($data);
    }

    public function get_detail_item()
    {
        $data = $this->db->get_where('prc_plan_item', ['ppi_code' => $this->input->post('ppi_code')])->row_array();
        echo json_encode($data);
    }
}
