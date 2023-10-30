<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Vendor extends Telescoope_Controller
{

  var $data;

  public function __construct()
  {

    // Call the Model constructor
    parent::__construct();

    $this->load->model(array("Vendor_m", "Administration_m", 'Comment_m', "Workflow_m"));

    $this->load->library('grocery_CRUD');

    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'vendor';

    $this->data['controller_name'] = $this->uri->segment(1);

    $dir = './uploads/' . $this->data['dir'];

    $this->session->set_userdata("module", $this->data['dir']);

    if (!file_exists($dir)) {
      mkdir($dir, 0777, true);
    }

    $config['allowed_types'] = '*';
    $config['overwrite'] = false;
    $config['max_size'] = 3064;
    $config['upload_path'] = $dir;
    $this->load->library('upload', $config);

    $this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

    $selection = array(
      "selection_vendor"
    );

    foreach ($selection as $key => $value) {
      $this->data[$value] = $this->session->userdata($value);
    }

    if (empty($userdata)) {
      redirect(site_url('log/in'));
    }
  }

  public function panduan($params1 = "")
  {
    redirect(base_url("guide/WIKA_eSCM_Quick_Guide_VendorManagement_v0.1.pptx"));
  }

  public function doc_vendor($param1 = "", $param2 = "")
  { }
  public function daftar_pekerjaan($param1 = "", $param2 = "")
  {

    switch ($param1) {

      case 'daftar_pekerjaan_vendor':
        $this->daftar_pekerjaan_vendor();
        break;

      case 'daftar_pekerjaan_vendor_form':
        $this->daftar_pekerjaan_vendor_form($param2);
        break;

      default:
        $this->daftar_pekerjaan_vendor();
        break;
    }
  }

  public function verifikasi_dokumen_pq($id=""){
    if (!empty($id)) {

      include("vendor/vendor_tools/verifikasi_dokumen_pq.php");

    }else{
      redirect('vendor/daftar_pekerjaan');
    }
  }

  public function submit_verifikasi_doc_pq(){
    include("vendor/vendor_tools/submit_verifikasi_doc_pq.php");
  }

  public function data_template_doc_pq($vtm_id=""){
    include("vendor/vendor_tools/data_template_doc_pq.php");
  }

  public function vendor_tools($param1 = "", $param2 = "", $param3 = "", $param4="")
  {

    switch ($param1) {

      case 'aktivasi_vendor':
        $this->aktivasi_vendor();
        break;

      case 'aktivasi_vendor_form':
        $this->edit_aktivasi_vendor($param2);
        break;

      case 'verifikasi_dokumen_pq':
        $this->verifikasi_dokumen_pq($param2);
        break;

        //start code hlmifzi
      case 'aktivasi_vendor_commodity_form':
        $this->edit_aktivasi_commodity_vendor($param2);
        break;
        //end

      case 'survei_vendor':
        $this->survei_vendor();
        break;

      case 'doc_vendor':

        switch ($param2) {

          case 'add':
            $this->add_doc_vendor();
            break;

          case 'edit':
            $this->edit_doc_vendor($param3);
            break;

          case 'ubah_status':
            $this->ubah_status_doc_vendor($param3,$param4);
            break;

          case 'delete':
            $this->delete_doc_vendor($param3);
            break;

          case 'data':
            $this->data_doc_vnd();
            break;

          case 'submit_add':
            $this->submit_add_doc_vendor($param3);
            break;

          case 'submit_edit':
            $this->submit_edit_doc_vendor($param3);
            break;

          default:
            $this->view_doc_vendor();
            break;
        }
        break;

      default:
        $this->vendor_tools();
        break;
    }
  }

  public function sinkron_vendor($vendor_id = "")
  {
    include("vendor/daftar_vendor/daftar_seluruh_vendor/sinkron_vendor.php");
  }

  public function sinkron_nasabah($vendor_id = "")
  {
    include("vendor/daftar_vendor/daftar_seluruh_vendor/sinkron_nasabah.php");
  }

  public function daftar_vendor($param1 = "", $param2 = "")
  {

    switch ($param1) {

      case 'daftar_status_vendor':
        $this->daftar_status_vendor();
        break;

      case 'sinkron_vendor':
        $this->sinkron_vendor();
        break;

      case 'sinkron_nasabah':
        $this->sinkron_nasabah();
        break;

      case 'daftar_seluruh_vendor':
        $this->daftar_seluruh_vendor();
        break;

      case 'lihat_detail_vendor':
        $this->lihat_detail_vendor();
        break;

      default:
        $this->daftar_vendor();
        break;

      case 'generate_bidder_list':
        $this->generate_bidder_list($param2);
        break;

      case 'daftar_vendor_domisili_expired':
        $this->daftar_vendor_domisili_expired();
        break;
    }
  }

  public function daftar_mandor($param1 = "", $param2 = "")
  {

    switch ($param1) {

      case 'lihat_detail_mandor':
        $this->lihat_detail_mandor();
        break;

      case 'data_daftar_seluruh_mandor':
        $this->data_daftar_seluruh_mandor();
        break;

      default:
        $this->list_daftar_mandor();
        break;
    }
  }

  public function kinerja_vendor($param1 = "", $param2 = "")
  {

    switch ($param1) {

      case 'kpi_vendor':
        $this->kpi_vendor();
        break;

      case 'kpi_vendor_form':
        $this->kpi_vendor_form($param2);
        break;

      case 'kpi_vendor':
        $this->kpi_vendor();
        break;


      case 'aktivasi_suspend_vendor_form':
        $this->aktivasi_suspend_vendor_form($param2);
        break;

      case 'aktivasi_suspend_vendor':
        $this->aktivasi_suspend_vendor();
        break;

      case 'suspend_vendor':
        $this->suspend_vendor();
        break;

        //hlmlifzi
      case 'suspend_commodity_vendor':
        $this->suspend_commodity_vendor();
        break;
        //end

      case 'suspend_vendor_form':
        $this->suspend_vendor_form($param2);
        break;

        //start hlmifzi
      case 'suspend_vendor_commodity_form':
        $this->suspend_vendor_commodity_form($param2);
        break;
        //end

      case 'blacklist_vendor':
        $this->blacklist_vendor();
        break;

      case 'blacklist_vendor_form':
        $this->blacklist_vendor_form($param2);
        break;

      default:
        $this->blacklist_vendor();
        break;
    }
  }

  public function aktivasi_vendor()
  {
    include("vendor/vendor_tools/aktivasi_vendor.php");
  }

  public function data_aktivasi_vendor()
  {
    include("vendor/vendor_tools/data_aktivasi_vendor.php");
  }

  public function data_verifikasi_doc_pq()
  {
    include("vendor/vendor_tools/data_verifikasi_doc_pq.php");
  }

  //start code hlmifzi
  public function data_aktivasi_vendor_commodity()
  {
    include("vendor/vendor_tools/data_aktivasi_vendor_commodity.php");
  }
  //end

  public function edit_aktivasi_vendor($id)
  {
    include("vendor/vendor_tools/edit_aktivasi_vendor.php");
  }

  public function submit_edit_aktivasi_vendor()
  {
    include("vendor/vendor_tools/submit_edit_aktivasi_vendor.php");
  }

  //start code hlmifzi
  public function edit_aktivasi_commodity_vendor($id)
  {
    include("vendor/vendor_tools/edit_aktivasi_commodity_vendor.php");
  }

  public function submit_edit_aktivasi_commodity_vendor()
  {
    include("vendor/vendor_tools/submit_edit_aktivasi_commodity_vendor.php");
  }
  //end

  public function daftar_seluruh_vendor()
  {
    include("vendor/daftar_vendor/daftar_seluruh_vendor/daftar_seluruh_vendor.php");
  }

  public function data_daftar_seluruh_vendor()
  {
    include("vendor/daftar_vendor/daftar_seluruh_vendor/data_daftar_seluruh_vendor.php");
  }

  public function picker_seluruh_vendor()
  {
    include("vendor/daftar_vendor/daftar_seluruh_vendor/picker_seluruh_vendor.php");
  }

  public function lihat_detail_vendor()
  {
    include("vendor/daftar_vendor/daftar_seluruh_vendor/lihat_detail_vendor.php");
  }

  public function generate_bidder_list($param = "")
  {
    include("vendor/daftar_vendor/generate_bidder_list/generate_bidder_list.php");
  }

  public function data_generate_bidder_list()
  {
    include("vendor/daftar_vendor/generate_bidder_list/data_generate_bidder_list.php");
  }
  public function daftar_vendor_domisili_expired()
  {
    include("vendor/daftar_vendor/daftar_vendor_domisili_expired/daftar_vendor_domisili_expired.php");
  }

  public function data_daftar_vendor_domisili_expired()
  {
    include("vendor/daftar_vendor/daftar_vendor_domisili_expired/data_daftar_vendor_domisili_expired.php");
  }

  public function kpi_vendor()
  {
    include("vendor/kinerja_vendor/kpi_vendor.php");
  }

  public function data_kpi_vendor()
  {
    include("vendor/kinerja_vendor/data_kpi_vendor.php");
  }

  public function info_kpi_vendor($id = "")
  {
    include("vendor/kinerja_vendor/info_kpi_vendor.php");
  }

  public function view_kpi_vendor($id = "")
  {
    include("vendor/kinerja_vendor/view_kpi_vendor.php");
  }

  public function daftar_pekerjaan_vendor()
  {
    include("vendor/kinerja_vendor/daftar_pekerjaan_vendor.php");
  }

  public function data_daftar_pekerjaan_vendor()
  {
    include("vendor/kinerja_vendor/data_daftar_pekerjaan_vendor.php");
  }

  //hlmifzi
  public function data_daftar_pekerjaan_commodity_vendor()
  {
    include("vendor/kinerja_vendor/data_daftar_pekerjaan_commodity_vendor.php");
  }
  //end

  public function data_daftar_pekerjaan_blacklist_vendor()
  {
    include("vendor/kinerja_vendor/data_daftar_pekerjaan_blacklist_vendor.php");
  }

  public function daftar_pekerjaan_vendor_form($id)
  {
    include("vendor/kinerja_vendor/daftar_pekerjaan_vendor_form.php");
  }


  //start code hlmifzi
  public function daftar_pekerjaan_vendor_commodity_form($id)
  {
    include("vendor/kinerja_vendor/daftar_pekerjaan_vendor_commodity_form.php");
  }
  //end

  public function daftar_pekerjaan_blacklist_vendor_form($id)
  {
    include("vendor/kinerja_vendor/daftar_pekerjaan_blacklist_vendor_form.php");
  }

  public function submit_daftar_pekerjaan_blacklist()
  {
    include("vendor/kinerja_vendor/submit_daftar_pekerjaan_blacklist.php");
  }

  public function submit_daftar_pekerjaan()
  {
    include("vendor/kinerja_vendor/submit_daftar_pekerjaan.php");
  }

  //start code hlmifzi
  public function submit_daftar_pekerjaan_commodity()
  {
    include("vendor/kinerja_vendor/submit_daftar_pekerjaan_commodity.php");
  }
  // end


  public function suspend_vendor()
  {
    include("vendor/kinerja_vendor/suspend_vendor.php");
  }

  //start hlmifzi
  public function suspend_commodity_vendor()
  {
    include("vendor/kinerja_vendor/suspend_commodity_vendor.php");
  }

  //end


  public function data_suspend_vendor()
  {
    include("vendor/kinerja_vendor/data_suspend_vendor.php");
  }

  //start hlmifzi
  public function data_suspend_commodity_vendor()
  {
    include("vendor/kinerja_vendor/data_suspend_commodity_vendor.php");
  }
  //end

  public function suspend_vendor_form($id)
  {
    include("vendor/kinerja_vendor/suspend_vendor_form.php");
  }

  //start code hlmifzi
  public function suspend_vendor_commodity_form($id)
  {
    include("vendor/kinerja_vendor/suspend_vendor_commodity_form.php");
  }
  //end

  public function submit_suspend_vendor()
  {
    include("vendor/kinerja_vendor/submit_suspend_vendor.php");
  }

  //start code hlmifzi
  public function submit_suspend_commodity_vendor()
  {
    include("vendor/kinerja_vendor/submit_suspend_commodity_vendor.php");
  }
  //end


  public function aktivasi_suspend_vendor()
  {

    include("vendor/kinerja_vendor/aktivasi_suspend_vendor.php");
  }

  public function data_aktivasi_suspend_vendor()
  {
    include("vendor/kinerja_vendor/data_aktivasi_suspend_vendor.php");
  }

  public function aktivasi_suspend_vendor_form($id)
  {
    include("vendor/kinerja_vendor/aktivasi_suspend_vendor_form.php");
  }

  public function submit_aktivasi_suspend_vendor()
  {
    include("vendor/kinerja_vendor/submit_aktivasi_suspend_vendor.php");
  }

  public function blacklist_vendor()
  {
    include("vendor/kinerja_vendor/blacklist_vendor.php");
  }

  public function data_blacklist_vendor()
  {
    include("vendor/kinerja_vendor/data_blacklist_vendor.php");
  }

  public function data_blacklist_aktif()
  {
    include("vendor/kinerja_vendor/data_blacklist_aktif.php");
  }

  public function blacklist_vendor_form($id)
  {
    include("vendor/kinerja_vendor/blacklist_vendor_form.php");
  }

  public function submit_blacklist_vendor()
  {
    include("vendor/kinerja_vendor/submit_blacklist_vendor.php");
  }
  //start code hlmifzi
  public function detail_barang_kpi($id = "", $vendor = "")
  { //end code
    include("vendor/kinerja_vendor/detail_barang_kpi.php");
  }

  public function detail_vendor($type = "", $id = "")
  {
    include("vendor/vendor_tools/detail_vendor.php");
  }

  public function daf($type = "", $id = "")
  {
    include("vendor/vendor_tools/detail_vendor.php");
  }

  public function data_daftar_pekerjaan_vendor_aktivasi()
  {
    include("vendor/kinerja_vendor/data_daftar_pekerjaan_vendor_aktivasi.php");
  }

  public function daftar_pekerjaan_vendor_aktivasi_form($comment_id)
  {
    include("vendor/vendor_tools/approval_aktivasi_vendor.php");
  }

  public function vpi($param1 = "", $param2 = "", $param3 = "", $param4 = "", $param5 = "")
  {

    switch ($param1) {
        // case 'form':
        //   include("vendor/vpi/daftar_pekerjaan/form.php");
        //   break;
      case 'monitor_pekerjaan':

        switch ($param2) {
          case 'penilaian_header':
            include("vendor/vpi/monitor_pekerjaan/penilaian_header.php");
            break;

          case 'submit_penilaian_header':
            include("vendor/vpi/monitor_pekerjaan/submit_penilaian_header.php");
            break;

          case 'penilaian_vpi':

            if (!empty($param3) and !empty($param4)) {

              switch ($param4) {
                case 'barang':

                  switch ($param5) {

                    case 'ketepatan_progress':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_barang/ketepatan_progress.php');
                      break;

                    case 'mutu_pekerjaan':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_barang/hasil_mutu_pekerjaan.php');
                      break;

                    case 'k3ldan5r':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_barang/k3ldan5r.php');
                      break;

                    case 'pengamanan':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_barang/pengamanan.php');
                      break;
                  }

                  break;

                case 'jasa':

                  switch ($param5) {

                    case 'ketepatan_progress':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_jasa/ketepatan_progress.php');
                      break;

                    case 'mutu_pekerjaan':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_jasa/hasil_mutu_pekerjaan.php');
                      break;

                    case 'k3ldan5r':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_jasa/k3ldan5r.php');
                      break;

                    case 'pengamanan':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_jasa/pengamanan.php');
                      break;
                  }


                  break;

                case 'konsultan':

                  switch ($param5) {
                    case 'ketepatan_progress':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_konsultan/ketepatan_progress.php');
                      break;

                    case 'mutu_pekerjaan':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_konsultan/mutu_pekerjaan.php');
                      break;

                    case 'pelayanan':
                      include('vendor/vpi/monitor_pekerjaan/penilaian_vpi_konsultan/pelayanan.php');
                      break;
                  }

                  break;
              }
            } else {
              include("vendor/vpi/monitor_pekerjaan/penilaian_vpi.php");
            }
            break;


          default:
            include("vendor/vpi/monitor_pekerjaan/monitor_pekerjaan_vpi.php");
            break;
        }

        break;

      case 'daftar_pekerjaan':

        switch ($param2) {

          case 'penilaian_header':
            include("vendor/vpi/daftar_pekerjaan/penilaian_header.php");
            break;

          case 'check_penilaian_header':
            include("vendor/vpi/daftar_pekerjaan/check_penilaian_header.php");
            break;

          case 'submit_penilaian_header':
            include("vendor/vpi/daftar_pekerjaan/submit_penilaian_header.php");
            break;

            case 'submit_catatan_vpi_vendor':
              include("vendor/vpi/daftar_pekerjaan/submit_catatan_vpi_vendor.php");
              break;

          case 'penilaian_vpi':

            if (!empty($param3) and !empty($param4)) {

              switch ($param4) {
                case 'barang':

                  switch ($param5) {

                    case 'ketepatan_progress':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_barang/ketepatan_progress.php');
                      break;

                    case 'submit_ketepatan_progress':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_barang/submit_ketepatan_progress.php');
                      break;

                    case 'mutu_pekerjaan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_barang/hasil_mutu_pekerjaan.php');
                      break;

                    case 'submit_mutu_pekerjaan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_barang/submit_hasil_mutu_pekerjaan.php');
                      break;

                    case 'k3ldan5r':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_barang/k3ldan5r.php');
                      break;

                    case 'submit_k3ldan5r':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_barang/submit_k3ldan5r.php');
                      break;

                    case 'pengamanan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_barang/pengamanan.php');
                      break;

                    case 'submit_pengamanan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_barang/submit_pengamanan.php');
                      break;

                    case 'submit_kompilasi':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_barang/submit_kompilasi.php');
                      break;
                  }

                  break;

                case 'jasa':

                  switch ($param5) {

                    case 'ketepatan_progress':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/ketepatan_progress.php');
                      break;

                    case 'submit_ketepatan_progress':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/submit_ketepatan_progress.php');
                      break;

                    case 'mutu_pekerjaan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/hasil_mutu_pekerjaan.php');
                      break;

                    case 'submit_mutu_pekerjaan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/submit_hasil_mutu_pekerjaan.php');
                      break;

                    case 'k3ldan5r':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/k3ldan5r.php');
                      break;

                    case 'submit_k3ldan5r':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/submit_k3ldan5r.php');
                      break;

                    case 'pengamanan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/pengamanan.php');
                      break;

                    case 'submit_pengamanan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/submit_pengamanan.php');
                      break;

                    case 'submit_kompilasi':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_jasa/submit_kompilasi.php');
                      break;
                  }


                  break;

                case 'konsultan':

                  switch ($param5) {
                    case 'ketepatan_progress':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_konsultan/ketepatan_progress.php');
                      break;

                    case 'submit_ketepatan_progress':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_konsultan/submit_ketepatan_progress.php');
                      break;

                    case 'mutu_pekerjaan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_konsultan/mutu_pekerjaan.php');
                      break;

                    case 'submit_mutu_pekerjaan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_konsultan/submit_mutu_pekerjaan.php');
                      break;

                    case 'pelayanan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_konsultan/pelayanan.php');
                      break;

                    case 'submit_pelayanan':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_konsultan/submit_pelayanan.php');
                      break;

                    case 'submit_kompilasi':
                      include('vendor/vpi/daftar_pekerjaan/penilaian_vpi_konsultan/submit_kompilasi.php');
                      break;
                  }

                  break;
              }
            } else {
              include("vendor/vpi/daftar_pekerjaan/penilaian_vpi.php");
            }
            break;

          default:
            include("vendor/vpi/daftar_pekerjaan/daftar_pekerjaan_vpi.php");
            break;
        }

        break;


      case 'vendor_award':

        switch ($param2) {

          case 'data':
            include("vendor/vpi/vendor_award/data_vendor_award.php");
            break;

          case 'export_vendor_award':
            include("vendor/vpi/vendor_award/export_vendor_award.php");
            break;

          case 'export_vendor_award_excel':
            include("vendor/vpi/vendor_award/export_vendor_award_excel.php");
            break;

          default:
            include("vendor/vpi/vendor_award/vendor_award.php");
            break;
        }

        break;

      case 'catatan_vendor':

        switch ($param2) {

          case 'data':
            include("vendor/vpi/catatan_vendor/data_catatan_vendor.php");
            break;

          // case 'export_vendor_award':
          //   include("vendor/vpi/vendor_award/export_vendor_award.php");
          //   break;
          //
          // case 'export_vendor_award_excel':
          //   include("vendor/vpi/vendor_award/export_vendor_award_excel.php");
          //   break;

          default:
            include("vendor/vpi/catatan_vendor/catatan_vendor.php");
            break;
        }

        break;

      default:
        redirect(site_url(), 'refresh');
        break;
    }
  }

  public function vsi() {
    include("vendor/vsi/vsi.php");
  }

  public function exportkpivendor($param)
  {
    switch ($param) {
      case 'pdf':
        include("vendor/kinerja_vendor/export_data_kpi/export_pdf.php");
        break;

      case 'excel':
        include("vendor/kinerja_vendor/export_data_kpi/export_excel.php");
        break;
    }
  }

  public function daftar_status_vendor()
  {

    include("vendor/daftar_vendor/daftar_status_vendor/daftar_status_vendor.php");
  }



  public function data_verifikasi_vendor()
  {
    include("vendor/vendor_tools/data_verifikasi_vendor.php");
  }

  public function daftar_pekerjaan_verifikasi_form($id)
  {
    include("vendor/kinerja_vendor/daftar_pekerjaan_verifikasi_form.php");
  }

  public function submit_verifikasi_vendor()
  {
    include("vendor/vendor_tools/submit_verifikasi_vendor.php");
  }

  public function data_persetujuan_survei()
  {
    include("vendor/vendor_tools/data_persetujuan_survei.php");
  }

  public function daftar_pekerjaan_persetujuan_survei_form($id)
  {
    include("vendor/kinerja_vendor/daftar_pekerjaan_persetujuan_survei_form.php");
  }

  public function submit_persetujuan_survei_vendor()
  {
    include("vendor/vendor_tools/submit_persetujuan_survei_vendor.php");
  }

  public function data_hasil_survei()
  {
    include("vendor/vendor_tools/data_hasil_survei.php");
  }

  public function daftar_pekerjaan_hasil_survei_form($id)
  {
    include("vendor/kinerja_vendor/daftar_pekerjaan_hasil_survei_form.php");
  }

  public function submit_hasil_survei_vendor()
  {
    include("vendor/vendor_tools/submit_hasil_survei_vendor.php");
  }

  public function submit_aktivasi_vendor()
  {
    include("vendor/vendor_tools/submit_aktivasi_vendor.php");
  }
  // tfk
  public function survei_vendor()
  {
    $this->session->unset_userdata("tgl_awal");
    $this->session->unset_userdata("tgl_akhir");
    $this->session->unset_userdata("tgl_survey_awal");
    $this->session->unset_userdata("tgl_survey_akhir");
    $this->session->unset_userdata("vendor_name");
    include("vendor/vendor_tools/survei_vendor.php");
  }
  public function data_survei_vendor()
  {
    include("vendor/vendor_tools/data_survei_vendor.php");
  }
  public function laporan_excel_survei_vendor()
  {
    include("vendor/vendor_tools/laporan_excel_survei_vendor.php");
  }

  public function laporan_pdf_survei_vendor()
  {
    include("vendor/vendor_tools/laporan_pdf_survei_vendor.php");
  }
  public function clear_session_survei_vendor()
  {
    $this->session->unset_userdata("tgl_awal");
    $this->session->unset_userdata("tgl_akhir");
    $this->session->unset_userdata("tgl_survei_awal");
    $this->session->unset_userdata("tgl_survei_akhir");
    $this->session->unset_userdata("vendor_name");
  }

  public function view_doc_vendor()
  {
    include("vendor/vendor_tools/doc_vendor/view_doc_vendor.php");
  }
  public function add_doc_vendor()
  {
    include("vendor/vendor_tools/doc_vendor/add_doc_vendor.php");
  }
  public function edit_doc_vendor($id)
  {
    include("vendor/vendor_tools/doc_vendor/edit_doc_vendor.php");
  }
  public function submit_add_doc_vendor()
  {
    include("vendor/vendor_tools/doc_vendor/submit_add_doc_vendor.php");
  }
  public function submit_edit_doc_vendor()
  {
    include("vendor/vendor_tools/doc_vendor/submit_edit_doc_vendor.php");
  }
  public function data_doc_vnd()
  {
    include("vendor/vendor_tools/doc_vendor/data_doc_vnd.php");
  }
   public function ubah_status_doc_vendor($type,$id)
  {
    include("vendor/vendor_tools/doc_vendor/ubah_status_doc_vendor.php");
  }
  public function list_daftar_mandor()
  {
    include("mandor/daftar_seluruh_mandor.php");
  }
  public function data_daftar_seluruh_mandor()
  {
    include("mandor/data_daftar_seluruh_mandor.php");
  }

  public function update_status_mandor($status="", $vmh_id="")
  {
    include("mandor/update_status_mandor.php");
  }

  public function lihat_detail_mandor()
  {
    include("mandor/lihat_detail_mandor.php");
  }
  public function update_profil_mandor()
  {
    include("mandor/update_profil_mandor.php");
  }
  public function update_pic_mandor()
  {
    include("mandor/update_pic_mandor.php");
  }
  public function update_bidang_mandor()
  {
    include("mandor/update_bidang_mandor.php");
  }
  public function update_modal_mandor()
  {
    include("mandor/update_modal_mandor.php");
  }
  public function update_pengalaman_mandor()
  {
    include("mandor/update_pengalaman_mandor.php");
  }
  public function update_ahli_bidang_mandor()
  {
    include("mandor/update_ahli_bidang_mandor.php");
  }
  public function update_peralatan()
  {
    include("mandor/update_peralatan.php");
  }
  public function get_sub_bidang()
  {
    // $post = $this->input->post();

    // $getDataSubBidang = $this->db->get_where('adm_master',[
    //   'status'=> 'Y',
    //   'am_type' => 'sub_bidang_registration_mandor',
    //   'am_parent_code' => $post['bidang_code']])->result_array();

    // $return['data'] = $getDataSubBidang;

    // echo json_encode($return);

    $post = $this->input->post();
      $this->db->select('*');
      $this->db->from('adm_master');
      $this->db->where([
        'status'=> 'Y',
        'am_type' => 'sub_bidang_registration_mandor',
        'am_parent_code' => $post['bidang_code']]);
      if(!empty($post['selected_sub_bidang'])){
        $this->db->where_not_in('am_kode', $post['selected_sub_bidang']);
      }
      $return['data'] =  $this->db->get()->result_array();

      echo json_encode($return);
  }

  public function get_level2()
  {
		$kategori = $this->input->post('kategori', true);

		$resc = $this->db->get_where('vw_catalogue_level_1', ['resources_code_id' => $kategori])->row_array();

		$level2 = $this->db->get_where('vw_catalogue_level_2', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level2 as $v2) {
			$data[$no]['id'] = $v2['id'];
			$data[$no]['resources_code_id'] = $v2['resources_code_id'];
			$data[$no]['code'] = $v2['code'];
			$data[$no]['parent_code'] = $v2['parent_code'];
			$data[$no]['name'] = $v2['name'];
			$no++;
		}
		
        echo json_encode($data);
  }

  public function get_level3()
  {
    $level2 = $this->input->post('level2', true);

		$resc = $this->db->get_where('vw_catalogue_level_2', ['resources_code_id' => $level2])->row_array();

    $level3 = $this->db->get_where('vw_catalogue_level_3', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level3 as $v3) {
			$data[$no]['id'] = $v3['id'];
			$data[$no]['resources_code_id'] = $v3['resources_code_id'];
			$data[$no]['code'] = $v3['code'];
			$data[$no]['parent_code'] = $v3['parent_code'];
			$data[$no]['name'] = $v3['name'];
			$no++;
		}

    echo json_encode($data);
  }

  public function get_level4()
  {
    $level3 = $this->input->post('level3', true);

		$resc = $this->db->get_where('vw_catalogue_level_3', ['resources_code_id' => $level3])->row_array();

    $level4 = $this->db->get_where('vw_catalogue_level_4', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level4 as $v4) {
			$data[$no]['id'] = $v4['id'];
			$data[$no]['resources_code_id'] = $v4['resources_code_id'];
			$data[$no]['code'] = $v4['code'];
			$data[$no]['parent_code'] = $v4['parent_code'];
			$data[$no]['name'] = $v4['name'];
			$no++;
		}

    echo json_encode($data);
  }

  public function get_level5()
  {
    $level4 = $this->input->post('level4', true);

		$resc = $this->db->get_where('vw_catalogue_level_4', ['resources_code_id' => $level4])->row_array();

    $level5 = $this->db->get_where('vw_catalogue_level_5', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level5 as $v5) {
			$data[$no]['id'] = $v5['id'];
			$data[$no]['resources_code_id'] = $v5['resources_code_id'];
			$data[$no]['code'] = $v5['code'];
			$data[$no]['parent_code'] = $v5['parent_code'];
			$data[$no]['name'] = $v5['name'];
			$no++;
		}

    echo json_encode($data);
  }

  public function get_level6()
  {
    $level5 = $this->input->post('level5', true);

		$resc = $this->db->get_where('vw_catalogue_level_5', ['resources_code_id' => $level5])->row_array();
        
    $level6 = $this->db->get_where('vw_catalogue_level_6', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level6 as $v6) {
			$data[$no]['id'] = $v6['id'];
			$data[$no]['resources_code_id'] = $v6['resources_code_id'];
			$data[$no]['code'] = $v6['code'];
			$data[$no]['parent_code'] = $v6['parent_code'];
			$data[$no]['name'] = $v6['name'];
			$no++;
		}

    echo json_encode($data);
  }

  public function get_level7()
  {
    $level6 = $this->input->post('level6', true);

		$resc = $this->db->get_where('vw_catalogue_level_6', ['resources_code_id' => $level6])->row_array();
        
    $level7 = $this->db->get_where('vw_catalogue_level_7', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level7 as $v7) {
			$data[$no]['id'] = $v7['id'];
			$data[$no]['resources_code_id'] = $v7['resources_code_id'];
			$data[$no]['code'] = $v7['code'];
			$data[$no]['parent_code'] = $v7['parent_code'];
			$data[$no]['name'] = $v7['name'];
			$no++;
		}

    echo json_encode($data);
  }

  public function get_level8()
  {
    $level7 = $this->input->post('level7', true);

		$resc = $this->db->get_where('vw_catalogue_level_7', ['resources_code_id' => $level7])->row_array();
        
    $level8 = $this->db->get_where('vw_catalogue_level_8', ['parent_code' => $resc['code']])->result_array();

		$no = 0;
		$data = array();

		foreach($level8 as $v8) {
			$data[$no]['id'] = $v8['id'];
			$data[$no]['resources_code_id'] = $v8['resources_code_id'];
			$data[$no]['code'] = $v8['code'];
			$data[$no]['parent_code'] = $v8['parent_code'];
			$data[$no]['name'] = $v8['name'];
			$no++;
		}

    echo json_encode($data);
  }

  public function submit_katalog()
	{
    $post = $this->input->post();
		$vendor_id = $post['vendor_id'];	

		$this->db->trans_begin();

		$level = $post['level1'];
		$product_name = '';

		if ($post['level2'] != '') { $level = $post['level2']; } 
		if ($post['level3'] != '') { $level = $post['level3']; }
		if ($post['level4'] != '') { $level = $post['level4']; }
		if ($post['level5'] != '') { $level = $post['level5']; }
		if ($post['level6'] != '') { $level = $post['level6']; }
		if ($post['level7'] != '') { $level = $post['level7']; }
		if ($post['level8'] != '') { $level = $post['level8']; }

		$cek_nama = $this->db->get_where('adm_catalogue', ['resources_code_id' => $level])->row_array();

		$item_data = array(
			'vendor_id' => $vendor_id,
			'product_name' => $cek_nama['name'],
			'product_code' => $cek_nama['code'],
			'product_description' => $cek_nama['description'],
			'level' => $cek_nama['level'],
			'tod' => $post['tod_id'],
			'uom' => $post['uom_id'],
			'note' => $post['note'],
			'status' => 2,
			'created_at' => date('Y-m-d h:i:s')
		);
		
		$result = $this->db->insert('vnd_product', $item_data);

		$this->session->set_flashdata('tab', 'katalog');

		if ($result) {
			$this->db->trans_commit();

			// $curl_log = curl_init();

			// curl_setopt_array($curl_log, array(
			// 	CURLOPT_URL => 'https://e-catalogue.wika.co.id/api/users/token',
			// 	CURLOPT_RETURNTRANSFER => true,
			// 	CURLOPT_ENCODING => '',
			// 	CURLOPT_MAXREDIRS => 10,
			// 	CURLOPT_TIMEOUT => 0,
			// 	CURLOPT_FOLLOWLOCATION => true,
			// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// 	CURLOPT_CUSTOMREQUEST => 'POST',
			// 	CURLOPT_POSTFIELDS =>'{
			// 		"username": "admin",
			// 		"password": "wika123"
			// 	}',
			// 	CURLOPT_HTTPHEADER => array(
			// 		'Content-Type: text/plain'
			// 	),
			// ));

			// $response_log = curl_exec($curl_log);

			// curl_close($curl_log);			

			// $curl = curl_init();
			// curl_setopt_array($curl, array(
			// 	CURLOPT_URL => 'https://e-catalogue.wika.co.id/api/product/create',
			// 	CURLOPT_RETURNTRANSFER => true,
			// 	CURLOPT_ENCODING => '',
			// 	CURLOPT_MAXREDIRS => 10,
			// 	CURLOPT_TIMEOUT => 0,
			// 	CURLOPT_FOLLOWLOCATION => true,
			// 	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			// 	CURLOPT_CUSTOMREQUEST => 'POST',
			// 	CURLOPT_POSTFIELDS =>'{
			// 		"level1": "'.$post['level1'].'",
			// 		"level2": "'.$post['level2'].'",
			// 		"level3": "'.$post['level3'].'",
			// 		"level4": "'.$post['level4'].'",
			// 		"level5": "'.$post['level5'].'",
			// 		"level6": "'.$post['level6'].'",
			// 		"level7": "'.$post['level7'].'",
			// 		"level8": "'.$post['level8'].'",
			// 		"name": "'.$post['product_name'].'",
			// 		"note": "'.$post['note'].'",
			// 		"vendor_id": '.$vendor_id.',
			// 		"term_of_delivery_id": "'.$post['tod_id'].'",
			// 		"berat_unit": 1,
			// 		"uom_id": '.$post['uom_id'].',
			// 		"tgl_harga_valid": "",
			// 		"image": [],
			// 		"payment_product":[]
			// 	}',
			// 	CURLOPT_HTTPHEADER => array(
			// 		'token: Bearer ',
			// 		'Content-Type: text/plain'
			// 	),
			// ));

			// $response = curl_exec($curl);

			// curl_close($curl);
			$status = 1;
			echo $status;

		} else {
			$status = 3;
			$this->db->trans_rollback();
			echo $status;
		}
		
	}

  public function delete_katalog() {
    
    $id = $_GET['id'];
    $vendor_id = $_GET['vendor_id'];

		$this->db->trans_begin();

		$this->db->where('id', $id);
		$result = $this->db->delete('vnd_product');

		$this->session->set_flashdata('tab', 'katalog');
		if ($result) {

			$this->db->trans_commit();			
			$this->session->set_flashdata('res', '1');
			return redirect(site_url('vendor/daftar_vendor/lihat_detail_vendor/' . $vendor_id));

		} else {

			$this->db->trans_rollback();
			$this->session->set_flashdata('res', '2');
			return redirect(site_url('vendor/daftar_vendor/lihat_detail_vendor/' . $vendor_id));
		}
	}


}
