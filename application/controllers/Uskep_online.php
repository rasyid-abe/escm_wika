<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Uskep_online extends Telescoope_Controller
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
        $this->data['projects'] = $this->db->get('project_info')->result_array();

        if (empty($userdata)) {
            redirect(site_url('log/in'));
        }
    }

    public function remove_data($rfq)
    {
        $this->db->where('no_rfq', $rfq);
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

    public function dsp($win)
    {
        $view = 'uskep_online/dsp_v';

    	$data = array();
    	$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();
        $data['winner'] = $win;
        $data['rfq'] = $this->Procrfq_m->getUrutRFQ();
        $data['k_spk'] = '';
        $data['k_proyek'] = '';
    	$this->template($view,"USKEP ONLINE",$data);
    }

    public function dsp_s($rfq, $win)
    {
        $view = 'uskep_online/dsp_v';

    	$data = array();
    	$data['bidderList'] = $this->Vendor_m->getVendorList()->result_array();
        $data['winner'] = $win;
        $data['rfq'] = $rfq;
        // $data['k_spk'] = $pr[0];
        // $data['k_proyek'] = $pr[1];
    	$this->template($view,"USKEP ONLINE",$data);
    }

    public function edit_dsp($rfqcode)
    {
        include("uskep_online/edit_dsp.php");
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

        // echo "<pre>";
        // print_r($tipePlan);
        // echo "<br>";
        // print_r($tipeProyek);
        // echo "<br>";
        // print_r($komisi);
        // echo "<br>";
        // print_r($data);
        // echo "<br>";
        // print_r($d);
        // die;
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
        include("uskep_online/dpkn.php");
    }

    public function edit_dpkn($rfqcode)
    {
        include("uskep_online/edit_dpkn.php");
    }

    public function submit_dpkn()
    {
        include("uskep_online/submit_dpkn.php");
    }

    public function bakp()
    {
        include("uskep_online/bakp.php");
    }

    public function edit_bakp($rfqcode)
    {
        include("uskep_online/edit_bakp.php");
    }

    public function submit_bakp()
    {
        include("uskep_online/submit_bakp.php");
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
        $view = 'uskep_online/esign/request_esign_dsp_v';

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
}
