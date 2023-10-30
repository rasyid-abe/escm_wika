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

    public function import_uskep()
    {

        $config['upload_path']          = './uploads/';
        $config['allowed_types']        = 'pdf';
        $config['max_size']             = 10000;

        $this->load->library('upload', $config);
        $this->upload->overwrite = true;

        if ( ! $this->upload->do_upload('fileUskep'))
        {
            $error = array('error' => $this->upload->display_errors());
        } else {
            $filename = $this->upload->data('file_name');
            $insert = [
                'paket_pengadaan' => 'Upload ' . $filename,
                'proyek' => 'Proyek ' . $filename,
                'no_rfq' => $this->Procrfq_m->getUrutRFQ(),
                'vendor' => 0,
                'bakp_filename' => $filename,
                'created_by' => $this->data['userdata']['employee_id'],
                'date_created' => date("Y-m-d H:i:s"),
                'data_dpkn' => 0,
                'is_sap' => 1,
                'metode_pengadaan' => "Tender_Terbatas",
            ];

            $ins = $this->db->insert("uskep_online", $insert);

            if ($ins) {
                $full_url = site_url()."/contract/manual_sap";
                echo "<script>
                window.location.href='".$full_url."';
                alert('Upload Uskep Success!');
                </script>";
            } else {
                $full_url = site_url()."/contract/manual_sap";
                echo "<script>
                window.location.href='".$full_url."';
                alert('Upload Uskep Failed!');
                </script>";
            }
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
        $this->db->where("reg_isactivate", "1");
        $data = $this->db->get('vnd_header')->result_array();
        $pic = $this->db->get('adm_user')->result_array();
        $projects = $this->db->get_where('prc_plan_main', ['ppm_is_sap' => 1])->result_array();

        $staf = array('STAF DEPARTEMEN','STAF PROYEK','STAFF');
    	$this->db->where_not_in('nm_jabatan', $staf);
    	$this->db->where('status', 'aktif');
        $this->db->select('nip,nm_peg,posisi');
    	$hcis = $this->db->get('response_hcis')->result_array();

        echo json_encode([$data, $pic, $projects, $hcis]);
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

    public function dsp()
    {
        $view = 'uskep_online/dsp_sap_v';
        $get = json_decode($this->input->get('data'));

        $vendor = [];
        foreach ($get[3] as $k => $v) {
            $vendor[] = $this->db->get_where('vnd_header', ['vendor_id' => $get[3][$k]])->row('vendor_name');
        }

        $uskep = $this->db->get_where('uskep_online', ['no_rfq' => $get[2]]);

        $p = json_decode($uskep->row('data_dpkn'));

    	$data = array();
        $data['mtd'] = $uskep->row('metode_pengadaan');
        // $data['ttd_dsp'] = $dsp_ttd;
        $data['pengadaan'] = $get[1];
        $data['k_spk'] = $get[0];
        $data['rfq'] = $get[2];
        $data['vt'] = implode("-", $get[3]);
        $data['vendor'] = implode(".-.",$vendor);
        $data['nego'] = implode("-", $get[4]);
        $data['costplan'] = $get[5];

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

    public function ttdlist()
    {
        $p = $this->input->post();
        $ppm = $this->db->get_where('prc_plan_main', ['ppm_project_id' => $p['idprk']])->row_array();

        $this->db->where_in('ppis_pr_number', $p['prnum']);
        $this->db->where('ppm_id', $ppm['ppm_id']);
        $ppi = $this->db->get('prc_plan_item')->result_array();

        $ppicode = [];
        foreach ($ppi as $k => $v) {
            $ppicode[] = trim($v['ppi_code']);
        }

        $this->db->select('flag');
        $this->db->where_in('code', $ppicode);
        $cat = $this->db->get('adm_catalogue')->result_array();

        $min = $p['min'];
        $proyek = $ppm['ppm_type_of_plan'] == 'rkap' ? 'non-proyek' : 'proyek';
        $catmanagement = $cat[0]['flag'] == '' ? 0 : 1;
        $pinfo = $this->db->get_where('project_info', ['kode_spk_sap' => $p['idprk']])->row_array();

        $nilai = strtolower($pinfo['klasifikasi_name']) == 'mega' ? 'besar' : strtolower($pinfo['klasifikasi_name']);

        $jnspengadaan = '';
        $proyek_big = $min >= 100000000000 ? '1' : '0';
        $doctype = 'depkn-dsp';

        $kelas = '';
        if ($catmanagement == '0') {
            if (($min <= 2000000000) && ($nilai == 'kecil')) {
                $kelas = 'low';
            } else if (($min <= 5000000000) && ($nilai == 'menengah')) {
                $kelas = 'low';
            } else if (($min <= 10000000000) && ($nilai == 'besar')) {
                $kelas = 'low';
            } else if (( ($min > 2000000000) && ($min <= 50000000000) ) && ($nilai == 'kecil')) {
                $kelas = 'medium';
            } else if (( ($min > 5000000000) && ($min <= 50000000000) ) && ($nilai == 'menengah')) {
                $kelas = 'medium';
            } else if (( ($min > 10000000000) && ($min <= 50000000000) ) && ($nilai == 'besar')) {
                $kelas = 'medium';
            } else {
                $kelas = 'high';
            }
        }

        if ($proyek != '') {
            $this->db->where('tipe_proyek', $proyek);
        }
        if ($catmanagement != '') {
            $this->db->where('is_category_management', $catmanagement);
        }
        if ($jnspengadaan != '') {
            $this->db->where('tipe_kontrak', $jnspengadaan);
        }
        if ($nilai != '') {
            $this->db->where('nilai', $nilai);
        }
        if ($kelas != '') {
            $this->db->where('kelas', $kelas);
        }
        if ($proyek_big != '') {
            $this->db->where('proyek_big', $proyek_big);
        }

        $this->db->where('tipe_dokumen', $doctype);
        $this->db->select('max(order_no)');
        $max = $this->db->get('vw_response_hcis')->row_array();

        $depkn_ttd = [];
        for ($i=1; $i <= (int)$max['max']; $i++) {
            if ($proyek != '') {
                $this->db->where('tipe_proyek', $proyek);
            }
            if ($catmanagement != '') {
                $this->db->where('is_category_management', $catmanagement);
            }
            if ($jnspengadaan != '') {
                $this->db->where('tipe_kontrak', $jnspengadaan);
            }
            if ($nilai != '') {
                $this->db->where('nilai', $nilai);
            }
            if ($kelas != '') {
                $this->db->where('kelas', $kelas);
            }
            if ($proyek_big != '') {
                $this->db->where('proyek_big', $proyek_big);
            }
            $this->db->where('tipe_dokumen', $doctype);
            $this->db->where('order_no', $i);
            $depkn_ttd[] = $this->db->get('vw_response_hcis')->result_array();
        }

        $return = [
            'ttd' => $depkn_ttd,
            'tipePlan' => $proyek,
            'tipeProyek' => $nilai,
            'catmanagement' => $catmanagement,
            'jnspengadaan' => $jnspengadaan,
        ];

        echo json_encode($return);
    }

    public function ttdlist_bakp()
    {
        $uskep = $this->db->get_where('uskep_online', ['no_rfq' => $this->input->post('rfq')]);

    	$p = json_decode($uskep->row('data_dpkn'));

    	$proyek = $p->tipe_proyek;
    	$catmanagement = $p->catmanagement;
    	$jnspengadaan = $p->jnspengadaan;
    	$nilai = $p->nilai;

    	$min = min($p->total_negosiai_vendor);

    	$proyek_big = $min >= 100000000000 ? '1' : '0';

    	$kelas = '';
    	if ($p->catmanagement == '0') {
    		if (($min <= 2000000000) && ($p->nilai == 'kecil')) {
    			$kelas = 'low';
    		} else if (($min <= 5000000000) && ($p->nilai == 'menengah')) {
    			$kelas = 'low';
    		} else if (($min <= 10000000000) && ($p->nilai == 'besar')) {
    			$kelas = 'low';
    		} else if (( ($min > 2000000000) && ($min <= 50000000000) ) && ($p->nilai == 'kecil')) {
    			$kelas = 'medium';
    		} else if (( ($min > 5000000000) && ($min <= 50000000000) ) && ($p->nilai == 'menengah')) {
    			$kelas = 'medium';
    		} else if (( ($min > 10000000000) && ($min <= 50000000000) ) && ($p->nilai == 'besar')) {
    			$kelas = 'medium';
    		} else {
    			$kelas = 'high';
    		}
    	}

    	$doctype = 'bakp';

    	if ($proyek != '') {
    		$this->db->where('tipe_proyek', $proyek);
    	}
    	if ($catmanagement != '') {
    		$this->db->where('is_category_management', $catmanagement);
    	}
    	if ($jnspengadaan != '') {
    		$this->db->where('tipe_kontrak', $jnspengadaan);
    	}
    	if ($nilai != '') {
    		$this->db->where('nilai', $nilai);
    	}
    	if ($kelas != '') {
    		$this->db->where('kelas', $kelas);
    	}
    	if ($proyek_big != '') {
    		$this->db->where('proyek_big', $proyek_big);
    	}

    	$this->db->where('tipe_dokumen', $doctype);
    	$this->db->select('max(order_no)');
    	$max = $this->db->get('vw_response_hcis')->row_array();

    	$bakp_ttd = [];
    	for ($i=1; $i <= (int)$max['max']; $i++) {
    		if ($proyek != '') {
                $this->db->where('tipe_proyek', $proyek);
            }
            if ($catmanagement != '') {
                $this->db->where('is_category_management', $catmanagement);
            }
            if ($jnspengadaan != '') {
                $this->db->where('tipe_kontrak', $jnspengadaan);
            }
    		if ($nilai != '') {
                $this->db->where('nilai', $nilai);
            }
            if ($kelas != '') {
                $this->db->where('kelas', $kelas);
            }
            if ($proyek_big != '') {
                $this->db->where('proyek_big', $proyek_big);
            }
    		$this->db->where('tipe_dokumen', $doctype);
    		$this->db->where('order_no', $i);
    		$bakp_ttd[] = $this->db->get('vw_response_hcis')->result_array();
    	}

        echo json_encode($bakp_ttd);
    }

    public function check_kewenangan_dpkn()
    {
        $p = $this->input->post();
        $proyek = $p['proyek'];
        $catmanagement = $p['catmanagement'];
        $jnspengadaan = $p['jnspengadaan'];
        $kelas = $p['kelas'];
        $nilai = $p['nilai'];
        $proyek_big = $p['proyek_big'];
        $doctype = 'depkn-dsp';

        // echo "<pre>";
        // print_r($p);
        // die;

        if ($proyek != '') {
            $this->db->where('tipe_proyek', $proyek);
        }
        if ($catmanagement != '') {
            $this->db->where('is_category_management', $catmanagement);
        }
        if ($jnspengadaan != '') {
            $this->db->where('tipe_kontrak', $jnspengadaan);
        }
        if ($nilai != '') {
            $this->db->where('nilai', $nilai);
        }
        if ($kelas != '') {
            $this->db->where('kelas', $kelas);
        }
        if ($proyek_big != '') {
            $this->db->where('proyek_big', $proyek_big);
        }

        $this->db->where('tipe_dokumen', $doctype);
        $this->db->select('max(order_no)');
        $max = $this->db->get('vw_response_hcis')->row_array();

        $depkn_ttd = [];
        for ($i=1; $i <= (int)$max['max']; $i++) {
            if ($proyek != '') {
                $this->db->where('tipe_proyek', $proyek);
            }
            if ($catmanagement != '') {
                $this->db->where('is_category_management', $catmanagement);
            }
            if ($jnspengadaan != '') {
                $this->db->where('tipe_kontrak', $jnspengadaan);
            }
            if ($nilai != '') {
                $this->db->where('nilai', $nilai);
            }
            if ($kelas != '') {
                $this->db->where('kelas', $kelas);
            }
            if ($proyek_big != '') {
                $this->db->where('proyek_big', $proyek_big);
            }
            $this->db->where('tipe_dokumen', $doctype);
            $this->db->where('order_no', $i);
            $depkn_ttd[] = $this->db->get('vw_response_hcis')->result_array();
        }

        echo json_encode($depkn_ttd);
    }

    public function dpkn($win, $mtd)
    {
        include("uskep_online/sap/dpkn.php");
    }

    public function edit_dpkn($cid = '', $rfqcode)
    {
        include("uskep_online/sap/edit_dpkn.php");
    }

    public function intClean($money)
    {
        $cleanString = preg_replace('/([^0-9\.,])/i', '', $money);
        $onlyNumbersString = preg_replace('/([^0-9])/i', '', $money);

        $separatorsCountToBeErased = strlen($cleanString) - strlen($onlyNumbersString) - 1;

        $stringWithCommaOrDot = preg_replace('/([,\.])/', '', $cleanString, $separatorsCountToBeErased);
        $removedThousandSeparator = preg_replace('/(\.|,)(?=[0-9]{3,}$)/', '',  $stringWithCommaOrDot);

        return (float) str_replace(',', '.', $removedThousandSeparator);
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
        $esign_dpkn = json_decode($db['esign_dpkn']);
        $esign_bakp = json_decode($db['esign_bakp']);
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
        $data_bakp['esign_bakp'] = $esign_bakp;
        $data_bakp['idx_ketua'] = array_search('Ketua', $esign_bakp->kategori);
        $data_bakp['idx_usulan'] = array_search('Mengusulkan', $esign_bakp->posisi);
        // $data_bakp['title'] = $this->db->get_where('adm_matriks_kegiatan', ['id'=>$esign->keg_id])->row_array();
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
        $data_dsp['alpha'] = $alpha;
        $data_dsp['adm_status'] = $dsp->administrasi->status_vendor;;
        $data_dsp['adm_poin'] = $dsp->administrasi->item_adm;
        $data_dsp['adm_bobot'] = $dsp->administrasi->bobot;
        $data_dsp['adm_vendor'] = $dsp->administrasi->vendor;
        $data_dsp['cols'] = $cols;
        $data_dsp['alpha'] = $alpha;
        $data_dsp['tek_status'] = $dsp->teknis->status;
        $data_dsp['tek_percent'] = $dsp->teknis->percent_teknis;
        $data_dsp['threshold'] = $dsp->teknis->threshold;
        $data_dsp['tek_nilai'] = $dsp->teknis->nilai;
        $data_dsp['tek_bobot'] = $dsp->teknis->bobot;
        $data_dsp['tek_poin'] = $dsp->teknis->poin;
        $data_dsp['idScore'] = $dsp->teknis->idScore;
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
        // $data_depkn['esign'] = $esign;
        // $data_depkn['title'] = $this->db->get_where('adm_matriks_kegiatan', ['id'=>$esign->keg_id])->row_array();
        $data_depkn['idx_ketua'] = array_search('Ketua', $esign_dpkn->kategori);
        $data_depkn['idx_usulan'] = array_search('Mengusulkan', $esign_dpkn->posisi);
        $data_depkn['notes'] = $dpkn->catatan;
        $data_depkn['esign_dpkn'] = $esign_dpkn;
        $data_depkn['data_uskep'] = $this->Procrfq_m->getUskepData($rfq)->row_array();

        // echo "<pre>";
        // print_r($data_depkn);
        // die;


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
        // $data = $this->db->get_where('prc_plan_item', [
        //     'ppm_id' => $this->input->post('ppm_id'),
        //     'ppis_pr_number' => $this->input->post('prnum')
        // ])->result_array();
        $ppm_id = $this->input->post('ppm_id');
        $prnum = $this->input->post('prnum');
        $sql = "
            SELECT ppi.*, ppv.ppv_remain FROM prc_plan_item ppi
            JOIN prc_plan_volume ppv ON ppi.ppi_code = ppv.ppv_smbd_code
            WHERE ppi.ppis_pr_number = $prnum AND ppv.ppv_remain > 0 AND ppv.ppm_id = $ppm_id
            ORDER BY ppv.created_datetime DESC
            LIMIT 1
        ";

        $data = $this->db->query($sql)->row_array();
        echo json_encode($data);
    }

    public function get_detail_item()
    {
        $pr = $this->input->post('prnum');
        $d = $this->db->get_where('prc_plan_item', ['ppis_pr_number' => $pr])->row_array();
        $sql = "
            SELECT ppi.*, ppv.ppv_remain FROM prc_plan_item ppi
            JOIN prc_plan_volume ppv ON ppi.ppi_code = ppv.ppv_smbd_code
            WHERE ppi.ppi_code = '".$d['ppi_code']."'
            AND ppv.ppv_remain > 0
            AND ppv.ppm_id = ".$d['ppm_id']."
            ORDER BY ppv.created_datetime DESC
            LIMIT 1
        ";

        $data = $this->db->query($sql)->row_array();
        echo json_encode($data);
    }

    public function get_klasifikasi($spk_code)
    {
        $data = $this->db->select('klasifikasi_name')->get_where('project_info', ['kode_spk_sap' => $spk_code])->row_array();
        echo json_encode($data);
    }

    public function get_budget($no_rfq)
    {

        $this->db->join('ctr_contract_item', 'ctr_contract_item.contract_id = ctr_contract_header.contract_id', 'left');
        $data_contract = $this->db->where('ptm_number', $no_rfq)->get("ctr_contract_header")->row_array();

        $curl = curl_init();

        $data = array();

        curl_setopt_array($curl, array(
            CURLOPT_URL => BUDGET_URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_POSTFIELDS =>'{
                    "PRNUM": "1120000218",
                    "PRITM": "10",
                    "PRVAL": "93750000",
                    "PRCUR": "IDR"
                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Basic ' . base64_encode('WIKA_INT:Initial123'),
                'x-requested-with: XMLHttpRequest',
                'x-xhr-logon: accept="iframe"'
            ),
        ));

        $response = curl_exec($curl);

        $arrays_data = json_decode($response, true);

        curl_close($curl);

        if (isset($arrays_data["DATA"])) {

            $data['E_EXCED'] = $arrays_data["DATA"][0]["E_EXCED"];
            $data['E_AVAIL'] = $arrays_data["DATA"][0]["E_AVAIL"];
            $data['E_WBS'] = $arrays_data["DATA"][0]["E_WBS"];
            $data['PRNUM'] = $arrays_data["DATA"][0]["PRNUM"];
            $data['PRITM'] = $arrays_data["DATA"][0]["PRITM"];
            $data['PRVAL'] = $arrays_data["DATA"][0]["PRVAL"];
            $data['PRCUR'] = $arrays_data["DATA"][0]["PRCUR"];
            $data['E_STATUS'] = $arrays_data["DATA"][0]["E_STATUS"];

        } else {

            $data['E_PESAN'] = 'Budget Tidak Tersedia.';
        }

        echo json_encode($data);
    }
}
