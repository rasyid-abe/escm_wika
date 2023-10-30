<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Administration extends Telescoope_Controller
{

  var $data;

  public function __construct()
  {

    // Call the Model constructor
    parent::__construct();

    $this->load->model(array("Administration_m", "Administration_m", "Comment_m", "Procedure_m"));

    $this->load->library('grocery_CRUD');

    $this->data['date_format'] = "h:i A | d M Y";

    $this->form_validation->set_error_delimiters('<div class="help-block">', '</div>');

    $this->data['data'] = array();

    $this->data['post'] = $this->input->post();

    $userdata = $this->Administration_m->getLogin();

    $this->data['dir'] = 'administration';

    $this->data['controller_name'] = $this->uri->segment(1);

    $dir = './uploads/' . $this->data['dir'];

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
      "selection_mata_anggaran",
      "selection_aspek_penilaian_pelayanan",
      "selection_aspek_penilaian_mutu_pekerjaan_dan_personal",
      "selection_kuesioner",
      "selection_hasil_mutu_pekerjaan",
      "selection_k3l",
      "selection_5r",
      "selection_pengamanan",
    );

    foreach ($selection as $key => $value) {
      $this->data[$value] = $this->session->userdata($value);
    }

    /*
    if($userdata['job_title'] != "ADMIN"){
      $this->noAccess();
    }
    */

    if (empty($userdata)) {
      redirect(site_url('log/in'));
    }
  }

  public function sync_catalog(){
		include("administration/master_data/catalog/sync_catalog.php");
	}

  public function document($param1 = "", $param2 = "", $param3 = "")
  {
    switch ($param1) {
      case 'news':
        switch ($param2) {

          case 'tambah':
            $this->submit_news();
            break;

          case 'hapus':
            $this->delete_news($param3);
            break;

          case 'hapus_lkpp':
            $this->delete_news_lkpp($param3);
            break;

          case 'add':
            $this->submit_news_lkpp();
            break;
        }
      default:
        $this->news();
        break;
    }
  }

  public function user_management($param1 = "", $param2 = "", $param3 = "")
  {

    switch ($param1) {

      case 'user_access':

        switch ($param2) {

          case 'add_user_access':
            $this->add_user_access();
            break;

          case 'ubah':
            $this->edit_user_access($param3);
            break;

          case 'hapus':
            $this->delete_user_access($param3);
            break;

          default:
            $this->user_access();
            break;
        }
        break;

      case 'hcis':

        switch ($param2) {

          case 'detail':
            $this->detail_hcis($param3);
            break;

          default:
            include("administration/user_management/hcis/hcis.php");
            break;
        }
        break;


        case 'privy':

          switch ($param2) {
  
            case 'detail':
              $this->detail_hcis($param3);
              break;
  
            default:
              include("administration/user_management/privy/privy_register.php");
              break;
          }
          break;

      case 'employee':

        switch ($param2) {

          case 'add_employee':
            $this->add_employee();
            break;

          case 'ubah':
            $this->edit_employee($param3);
            break;

          case 'hapus':
            $this->delete_employee($param3);
            break;

          case 'add_job_post':
            $this->add_job_post($param3);
            break;

          case 'add_proyek_post':
            $this->add_proyek_post($param3);
            break;

          case 'add_category_post':
            $this->add_category_post($param3);
            break;

          case 'hapus_job_post':
            $this->delete_job_post($param3);
            break;

          case 'hapus_proyek_post':
            $this->delete_proyek_post($param3);
            break;

          case 'hapus_category_post':
            $this->delete_category_post($param3);
            break;

          default:
            $this->employee();
            break;
        }

        break;

      default:
        $this->user_management();
        break;
    }
  }


  public function master_data($param1 = "", $param2 = "", $param3 = "")
  {


    switch ($param1) {

      case 'deskripsi_matgis':

        switch ($param2) {

          case 'tambah':
            $this->add_deskripsi_matgis();
            break;

          case 'ubah':
            $this->edit_deskripsi_matgis($param3);
            break;

          case 'hapus':
            $this->delete_deskripsi_matgis($param3);
            break;

          default:

            $this->deskripsi_matgis();
            break;
        }

        break;

      case 'data_crm':

        switch ($param2) {

          default:

            $this->data_crm();
            break;
        }

        break;

      case 'proyek':

        switch ($param2) {

          case 'tambah':
            $this->add_proyek();
            break;

          case 'ubah':
            $this->edit_proyek($param3);
            break;

          case 'hapus':
            $this->delete_proyek($param3);
            break;

          default:
            $this->proyek();
            break;
        }

        break;

        case 'hse':

          switch ($param2) {

            case 'verivikasi':
              $this->hse_verivikasi($param3);
              break;

            // case 'ubah':
            //   $this->edit_proyek($param3);
            //   break;

            // case 'hapus':
            //   $this->delete_proyek($param3);
            //   break;

            default:
              $this->hse($param2);
              break;
          }

          break;

      case 'pph':

        switch ($param2) {

          case 'tambah':
            $this->add_pph();
            break;

          case 'ubah':
            $this->edit_pph($param3);
            break;

          case 'hapus':
            $this->delete_pph($param3);
            break;

          case 'check':
            $this->check_pph($param3);
            break;

          default:
            $this->pph();
            break;
        }

        break;
        //haqim
      case 'divisi_utama':

        switch ($param2) {

          case 'add_divisi_utama':
            $this->add_divisi_utama();
            break;

          case 'ubah':
            $this->edit_divisi_utama($param3);
            break;

          case 'hapus':
            $this->delete_divisi_utama($param3);
            break;


          default:
            $this->divisi_utama();
            break;
        }

        break;

      case 'departemen':

        switch ($param2) {

          case 'add_departemen':
            $this->add_departemen();
            break;

          case 'ubah':
            $this->edit_departemen($param3);
            break;

          case 'nonaktif':
            $this->nonaktif_departemen($param3);
            break;

          default:
            $this->departemen();
            break;
        }

        break;

      case 'divisi':

        switch ($param2) {

          case 'add_divisi':
            $this->add_divisi();
            break;

          case 'ubah':
            $this->edit_divisi($param3);
            break;

          case 'nonaktif':
            $this->nonaktif_divisi($param3);
            break;

          default:
            $this->divisi();
            break;
        }

        break;

      case 'biro':

        switch ($param2) {

          case 'add_biro':
            $this->add_biro();
            break;

          case 'ubah':
            $this->edit_biro($param3);
            break;

          case 'nonaktif':
            $this->nonaktif_biro($param3);
            break;

          default:
            $this->biro();
            break;
        }

        break;
        //end


      case 'divisi_departemen':

        switch ($param2) {

          case 'add_divisi_departemen':
            $this->add_divisi_departemen();
            break;

          case 'ubah':
            $this->edit_divisi_departemen($param3);
            break;

          case 'nonaktif':
            $this->nonaktif_divisi_departemen($param3);
            break;

          default:
            $this->divisi_departemen();
            break;
        }

        break;

      case 'gudang':

        switch ($param2) {

          case 'tambah':
            $this->add_gudang();
            break;

          case 'ubah':
            $this->edit_gudang($param3);
            break;

          case 'hapus':
            $this->delete_gudang($param3);
            break;

          default:
            $this->gudang();
            break;
        }

        break;

      case 'catalog':

        switch ($param2) {

          default:
            $this->catalog();
            break;
        }

        break;

      case 'kapal':

        switch ($param2) {

          case 'tambah':
            $this->add_kapal();
            break;

          case 'ubah':
            $this->edit_kapal($param3);
            break;

          case 'hapus':
            $this->delete_kapal($param3);
            break;

          default:
            $this->kapal();
            break;
        }

        break;


      case 'ruangan':

        switch ($param2) {

          case 'tambah':
            $this->add_ruangan();
            break;

          case 'ubah':
            $this->edit_ruangan($param3);
            break;

          case 'hapus':
            $this->delete_ruangan($param3);
            break;

          default:
            $this->ruangan();
            break;
        }

        break;

      case 'property_aset':

        switch ($param2) {

          case 'tambah':
            $this->add_property_aset();
            break;

          case 'ubah':
            $this->edit_property_aset($param3);
            break;

          case 'hapus':
            $this->delete_property_aset($param3);
            break;

          default:
            $this->property_aset();
            break;
        }

        break;

      case 'anggaran':

        switch ($param2) {

          case 'tambah':
            $this->add_anggaran();
            break;

          case 'ubah':
            $this->edit_anggaran($param3);
            break;

          case 'hapus':
            $this->delete_anggaran($param3);
            break;

          default:
            $this->anggaran();
            break;
        }

        break;

      case 'rks':

        switch ($param2) {

          case 'tambah':
            $this->add_rks();
            break;

          case 'tambah':
            $this->submit_add_rks_header();
            break;

          case 'tambah':
            $this->submit_add_rks_header_sub();
            break;

          case 'tambah':
            $this->submit_add_rks_description();
            break;

          case 'ubah':
            $this->edit_rks($param3);
            break;

          case 'hapus':
            $this->delete_rks($param3);
            break;

          default:
            $this->rks();
            break;
        }

        break;

      case 'kategori_pajak':

        switch ($param2) {

          case 'tambah':
            $this->add_kategori_pajak();
            break;

          case 'ubah':
            $this->edit_kategori_pajak($param3);
            break;

          case 'hapus':
            $this->delete_kategori_pajak($param3);
            break;

          default:
            $this->kategori_pajak();
            break;
        }

        break;

      case 'delivery_point':

        switch ($param2) {

          case 'add_delivery_point':
            $this->add_delivery_point();
            break;

          case 'ubah':
            $this->edit_delivery_point($param3);
            break;

          case 'nonaktif':
            $this->nonaktif_delivery_point($param3);
            break;

          default:
            $this->delivery_point();
            break;
        }

        break;

      case 'daftar_kantor':

        switch ($param2) {

          case 'add_daftar_kantor':
            $this->add_daftar_kantor();
            break;

          case 'ubah':
            $this->edit_daftar_kantor($param3);
            break;

          case 'hapus':
            $this->delete_daftar_kantor($param3);
            break;


          default:
            $this->daftar_kantor();
            break;
        }

        break;

      case 'currency':

        switch ($param2) {

          case 'add_currency':
            $this->add_currency();
            break;

          case 'ubah':
            $this->edit_currency($param3);
            break;

          case 'hapus':
            $this->delete_currency($param3);
            break;


          default:
            $this->currency();
            break;
        }

        break;

      case 'employee_type':

        switch ($param2) {

          case 'add_employee_type':
            $this->add_employee_type();
            break;

          case 'ubah':
            $this->edit_employee_type($param3);
            break;

          case 'hapus':
            $this->delete_employee_type($param3);
            break;


          default:
            $this->employee_type();
            break;
        }

        break;

      case 'salutation':

        switch ($param2) {

          case 'add_salutation':
            $this->add_salutation();
            break;

          case 'ubah':
            $this->edit_salutation($param3);
            break;

          case 'hapus':
            $this->delete_salutation($param3);
            break;


          default:
            $this->salutation();
            break;
        }

        break;

      case 'menu_management':

        $this->menu_management();

        break;


      case 'lintasan':

        switch ($param2) {

          case 'add_lintasan':
            $this->add_lintasan();
            break;

          case 'ubah':
            $this->edit_lintasan($param3);
            break;

          case 'nonaktif':
            $this->nonaktif_lintasan($param3);
            break;

          default:
            $this->lintasan();
            break;
        }

        break;

        //y delegasi
      case 'delegasi_tugas':

        switch ($param2) {

          case 'add_delegasi_tugas':
            $this->add_delegasi_tugas();
            break;

          case 'ubah':
            $this->edit_delegasi_tugas($param3);
            break;

          default:
            $this->delegasi_tugas();
            break;
        }
        //end
        break;

      case 'master_mdiv':

        switch ($param2) {

          case 'add':
            include("administration/master_data/master_mdiv/add_master_mdiv.php");
            break;

          case 'edit':
            include("administration/master_data/master_mdiv/edit_master_mdiv.php");
            break;

          case 'submit_add':
            include("administration/master_data/master_mdiv/submit_add_master_mdiv.php");
            break;

          case 'submit_edit':
            include("administration/master_data/master_mdiv/submit_edit_master_mdiv.php");
            break;

          case 'data':
            include("administration/master_data/master_mdiv/data_master_mdiv.php");
            break;

          case 'nonaktif':
            include("administration/master_data/master_mdiv/nonaktif_master_mdiv.php");
            break;

          default:
            include("administration/master_data/master_mdiv/master_mdiv.php");
            break;
        }
        //end
        break;

      case 'lokasi_proyek':

        switch ($param2) {

          case 'add':
            include("administration/master_data/lokasi_proyek/add_lokasi_proyek.php");
            break;

          case 'edit':
            include("administration/master_data/lokasi_proyek/edit_lokasi_proyek.php");
            break;

          case 'submit_add':
            include("administration/master_data/lokasi_proyek/submit_add_lokasi_proyek.php");
            break;

          case 'submit_edit':
            include("administration/master_data/lokasi_proyek/submit_edit_lokasi_proyek.php");
            break;

          case 'data':
            include("administration/master_data/lokasi_proyek/data_lokasi_proyek.php");
            break;

          case 'nonaktif':
            include("administration/master_data/lokasi_proyek/nonaktif_lokasi_proyek.php");
            break;

          default:
            include("administration/master_data/lokasi_proyek/lokasi_proyek.php");
            break;
        }
        break;

      case 'penilaian_resiko_paket':

        switch ($param2) {

          case 'add':
            include("administration/master_data/penilaian_resiko_paket/add_resiko_paket.php");
            break;

          case 'edit':
            include("administration/master_data/lokasi_proyek/edit_lokasi_proyek.php");
            break;

          case 'submit_add':
            include("administration/master_data/lokasi_proyek/submit_add_lokasi_proyek.php");
            break;

          case 'submit_edit':
            include("administration/master_data/lokasi_proyek/submit_edit_lokasi_proyek.php");
            break;

          default:
            include("administration/master_data/penilaian_resiko_paket/penilaian_resiko_paket.php");
            break;
        }
        break;
        //end

    }
  }

  public function admin_tools($param1 = "", $param2 = "", $param3 = "", $param4 = "")
  {

    switch ($param1) {

      case 'hierarchy_position':

        switch ($param2) {

          case 'add':
            $this->act_hierarchy_position($param2, $param3, $param4);
            break;

          case 'edit':
            $this->act_hierarchy_position($param2, $param3, $param4);
            break;

          case 'delete':
            $this->delete_hierarchy_position($param3, $param4);
            break;


          default:
            $this->hierarchy_position();
            break;
        }

        break;

      case 'position':

        switch ($param2) {

          case 'add_position':
            $this->add_position();
            break;

          case 'ubah':
            $this->edit_position($param3);
            break;

          default:
            $this->position();
            break;
        }

        break;

      case 'exchange_rate':

        switch ($param2) {

          case 'add_exchange_rate':
            $this->add_exchange_rate();
            break;

          case 'ubah':
            $this->edit_exchange_rate($param3);
            break;

          case 'hapus':
            $this->delete_exchange_rate($param3);
            break;

          default:
            $this->exchange_rate();
            break;
        }
        break;


        //START
      case 'lintasan':

        switch ($param2) {

          case 'tambah':
            $this->add_lintasan();
            break;

          case 'ubah':
            $this->edit_lintasan($param3);
            break;

          case 'hapus':
            $this->delete_lintasan($param3);
            break;

          default:
            $this->lintasan();
            break;
        }

        break;
    }
  }

  public function helpdesk($param1 = "", $param2 = "", $param3 = "", $param4 = "")
  {
    switch ($param1) {
      case 'ticket':
        switch ($param2) {
          case 'edit_ticket':
            $this->edit_ticket();
            break;

          case 'detail_ticket':
            $this->detail_ticket();
            break;

          case 'delete_ticket':
            $this->delete_ticket($param3);
            break;

          case 'get_ticket':
            $this->get_ticket();
            break;

          case 'submit_ticket':
            $this->submit_ticket();
            break;

          case 'add_chat':
            $this->add_chat();
            break;

          case 'delete_chat':
            $this->delete_chat();
            break;

          default:
            $this->ticket();
            break;
        }
        break;
      case 'faq':
        switch ($param2) {
          case 'add_faq':
            $this->add_faq();
            break;

          case 'delete_faq':
            $this->delete_faq();
            break;

          default:
            $this->faq();
            break;
        }
        break;

      case 'flow':
        switch ($param2) {
          case 'add_flow':
            $this->add_flow();
            break;

          case 'delete_flow':
            $this->delete_flow();
            break;

          default:
            $this->flow();
            break;
        }
        break;

      case 'video':
        switch ($param2) {
          case 'add_video':
            $this->add_video();
            break;

          case 'delete_video':
            $this->delete_video();
            break;

          default:
            $this->video();
            break;
        }
        break;

      case 'pelaporan':
        switch ($param2) {
          case 'delete_pelaporan':
            $this->delete_pelaporan();
            break;

          default:
            $this->pelaporan();
            break;
        }
        break;

      default:
        # code...
        break;
    }
  }


  function detail_hcis($id)
  {
    include("administration/user_management/hcis/hcis_detail.php");
  }


  public function pelaporan()
  {
    include("administration/helpdesk/pelaporan/pelaporan.php");
  }

  public function delete_pelaporan()
  {
    include("administration/helpdesk/pelaporan/delete_pelaporan.php");
  }

  public function add_video()
  {
    include("administration/helpdesk/video/add_video.php");
  }

  public function delete_video()
  {
    include("administration/helpdesk/video/delete_video.php");
  }

  public function video()
  {
    include("administration/helpdesk/video/video.php");
  }

  public function add_flow()
  {
    include("administration/helpdesk/flow/add_flow.php");
  }

  public function delete_flow()
  {
    include("administration/helpdesk/flow/delete_flow.php");
  }

  public function flow()
  {
    include("administration/helpdesk/flow/flow.php");
  }

  public function faq()
  {
    include("administration/helpdesk/faq/faq.php");
  }

  public function add_faq()
  {
    include("administration/helpdesk/faq/add_faq.php");
  }
  public function delete_faq()
  {
    include("administration/helpdesk/faq/delete_faq.php");
  }

  public function ticket()
  {
    include("administration/helpdesk/ticket/ticket.php");
  }

  public function get_ticket()
  {
    include("administration/helpdesk/ticket/get_all_ticket.php");
  }

  public function get_edit_ticket()
  {
    include("administration/helpdesk/ticket/get_edit_ticket.php");
  }

  public function submit_ticket()
  {
    include("administration/helpdesk/ticket/submit_ticket.php");
  }

  public function edit_ticket()
  {
    include("administration/helpdesk/ticket/edit_ticket.php");
  }

  public function detail_ticket()
  {
    include("administration/helpdesk/ticket/detail_ticket.php");
  }

  public function delete_ticket()
  {
    include("administration/helpdesk/ticket/delete_ticket.php");
  }

  public function add_chat()
  {
    include("administration/helpdesk/ticket/add_chat.php");
  }

  public function delete_chat()
  {
    include("administration/helpdesk/ticket/delete_chat.php");
  }

  public function user_access()
  {
    include("administration/user_management/user_access/user_access.php");
  }

  public function add_user_access()
  {
    include("administration/user_management/user_access/add_user_access.php");
  }
  public function edit_user_access($id)
  {
    include("administration/user_management/user_access/edit_user_access.php");
  }

  public function submit_add_user_access()
  {
    include("administration/user_management/user_access/submit_add_user_access.php");
  }

  public function submit_edit_user_access()
  {
    include("administration/user_management/user_access/submit_edit_user_access.php");
  }

  public function delete_user_access($id)
  {
    include("administration/user_management/user_access/delete_user_access.php");
  }

  public function data_user_access()
  {
    include("administration/user_management/user_access/data_user_access.php");
  }

  public function alias_user_access()
  {
    include("administration/user_management/user_access/alias_user_access.php");
  }

// HSE
  public function hse($id=0)
  {
    include("administration/master_data/hse/hse.php");
  }

  public function hse_verivikasi($id=0)
  {
    include("administration/master_data/hse/hse_verivikasi.php");
  }

  public function employee()
  {
    include("administration/user_management/employee/employee.php");
  }

  public function add_employee()
  {
    include("administration/user_management/employee/add_employee.php");
  }
  public function edit_employee($id)
  {
    include("administration/user_management/employee/edit_employee.php");
  }

  public function submit_employee()
  {
    include("administration/user_management/employee/submit_employee.php");
  }

  public function submit_edit_employee()
  {
    include("administration/user_management/employee/submit_edit_employee.php");
  }

  public function delete_employee($id)
  {
    include("administration/user_management/employee/delete_employee.php");
  }

  public function data_employee()
  {
    include("administration/user_management/employee/data_employee.php");
  }

  public function alias_employee()
  {
    include("administration/user_management/employee/alias_employee.php");
  }

  public function add_job_post($id)
  {
    include("administration/user_management/employee/add_job_post.php");
  }

  public function add_proyek_post($id)
  {
    include("administration/user_management/employee/add_proyek_post.php");
  }

  public function add_category_post($id)
  {
    include("administration/user_management/employee/add_category_post.php");
  }

  public function submit_job_post()
  {
    include("administration/user_management/employee/submit_job_post.php");
  }

  public function submit_proyek_post()
  {
    include("administration/user_management/employee/submit_proyek_post.php");
  }

  public function submit_cat_post()
  {
    include("administration/user_management/employee/submit_cat_post.php");
  }

  public function data_job_post()
  {
    include("administration/user_management/employee/data_job_post.php");
  }

  public function data_proyek_post()
  {
    include("administration/user_management/employee/data_proyek_post.php");
  }

  public function data_category_post()
  {
    include("administration/user_management/employee/data_category_post.php");
  }

  public function delete_job_post($id)
  {
    include("administration/user_management/employee/delete_job_post.php");
  }

  public function delete_proyek_post($id)
  {
    include("administration/user_management/employee/delete_proyek_post.php");
  }

  public function delete_category_post($id)
  {
    include("administration/user_management/employee/delete_category_post.php");
  }

  public function data_hierarchy_position($id = "")
  {
    include("administration/admin_tools/hierarchy_position/data_hierarchy_position.php");
  }

  public function divisi_departemen()
  {
    include("administration/master_data/divisi_departemen/divisi_departemen.php");
  }

  public function data_divisi_departemen()
  {
    include("administration/master_data/divisi_departemen/data_divisi_departemen.php");
  }

  public function alias_divisi_departemen()
  {
    include("administration/master_data/divisi_departemen/alias_divisi_departemen.php");
  }

  public function add_divisi_departemen()
  {
    include("administration/master_data/divisi_departemen/add_divisi_departemen.php");
  }

  public function submit_add_divisi_departemen()
  {
    include("administration/master_data/divisi_departemen/submit_add_divisi_departemen.php");
  }

  public function edit_divisi_departemen($id)
  {
    include("administration/master_data/divisi_departemen/edit_divisi_departemen.php");
  }

  public function submit_edit_divisi_departemen()
  {
    include("administration/master_data/divisi_departemen/submit_edit_divisi_departemen.php");
  }

  public function nonaktif_divisi_departemen()
  {
    include("administration/master_data/divisi_departemen/nonaktif_divisi_departemen.php");
  }

  //haqim
  public function biro()
  {
    include("administration/master_data/biro/biro.php");
  }

  public function add_biro()
  {
    include("administration/master_data/biro/add_biro.php");
  }

  public function submit_add_biro()
  {
    include("administration/master_data/biro/submit_add_biro.php");
  }

  public function data_biro()
  {
    include("administration/master_data/biro/data_biro.php");
  }

  public function edit_biro($id)
  {
    include("administration/master_data/biro/edit_biro.php");
  }

  public function submit_edit_biro()
  {
    include("administration/master_data/biro/submit_edit_biro.php");
  }

  public function nonaktif_biro()
  {
    include("administration/master_data/biro/nonaktif_biro.php");
  }

  public function divisi()
  {
    include("administration/master_data/divisi/divisi.php");
  }

  public function data_divisi()
  {
    include("administration/master_data/divisi/data_divisi.php");
  }

  public function add_divisi()
  {
    include("administration/master_data/divisi/add_divisi.php");
  }

  public function submit_add_divisi()
  {
    include("administration/master_data/divisi/submit_add_divisi.php");
  }

  public function edit_divisi($id)
  {
    include("administration/master_data/divisi/edit_divisi.php");
  }

  public function submit_edit_divisi()
  {
    include("administration/master_data/divisi/submit_edit_divisi.php");
  }

  public function nonaktif_divisi()
  {
    include("administration/master_data/divisi/nonaktif_divisi.php");
  }

  public function departemen()
  {
    include("administration/master_data/departemen/departemen.php");
  }

  public function data_departemen()
  {
    include("administration/master_data/departemen/data_departemen.php");
  }

  public function alias_departemen()
  {
    include("administration/master_data/divisi_departemen/alias_divisi_departemen.php");
  }

  public function add_departemen()
  {
    include("administration/master_data/departemen/add_departemen.php");
  }

  public function submit_add_departemen()
  {
    include("administration/master_data/departemen/submit_add_departemen.php");
  }

  public function edit_departemen($id)
  {
    include("administration/master_data/departemen/edit_departemen.php");
  }

  public function submit_edit_departemen()
  {
    include("administration/master_data/departemen/submit_edit_departemen.php");
  }

  public function nonaktif_departemen()
  {
    include("administration/master_data/departemen/nonaktif_departemen.php");
  }

  //end

  public function delivery_point()
  {
    include("administration/master_data/delivery_point/delivery_point.php");
  }

  public function data_delivery_point()
  {
    include("administration/master_data/delivery_point/data_delivery_point.php");
  }

  public function alias_delivery_point()
  {
    include("administration/master_data/delivery_point/alias_delivery_point.php");
  }

  public function add_delivery_point()
  {
    include("administration/master_data/delivery_point/add_delivery_point.php");
  }

  public function submit_add_delivery_point()
  {
    include("administration/master_data/delivery_point/submit_add_delivery_point.php");
  }

  public function edit_delivery_point($id)
  {
    include("administration/master_data/delivery_point/edit_delivery_point.php");
  }

  public function submit_edit_delivery_point()
  {
    include("administration/master_data/delivery_point/submit_edit_delivery_point.php");
  }

  public function nonaktif_delivery_point()
  {
    include("administration/master_data/delivery_point/nonaktif_delivery_point.php");
  }

  public function divisi_utama()
  {
    include("administration/master_data/divisi_utama/divisi_utama.php");
  }

  public function add_divisi_utama()
  {
    include("administration/master_data/divisi_utama/add_divisi_utama.php");
  }

  public function submit_add_divisi_utama()
  {
    include("administration/master_data/divisi_utama/submit_add_divisi_utama.php");
  }

  public function data_divisi_utama()
  {
    include("administration/master_data/divisi_utama/data_divisi_utama.php");
  }

  public function edit_divisi_utama($id)
  {
    include("administration/master_data/divisi_utama/edit_divisi_utama.php");
  }

  public function submit_edit_divisi_utama()
  {
    include("administration/master_data/divisi_utama/submit_edit_divisi_utama.php");
  }

  public function delete_divisi_utama($id)
  {
    include("administration/master_data/divisi_utama/delete_divisi_utama.php");
  }

  public function daftar_kantor()
  {
    include("administration/master_data/daftar_kantor/daftar_kantor.php");
  }

  public function data_daftar_kantor()
  {
    include("administration/master_data/daftar_kantor/data_daftar_kantor.php");
  }

  public function alias_daftar_kantor()
  {
    include("administration/master_data/daftar_kantor/alias_daftar_kantor.php");
  }

  public function add_daftar_kantor()
  {
    include("administration/master_data/daftar_kantor/add_daftar_kantor.php");
  }

  public function submit_add_daftar_kantor()
  {
    include("administration/master_data/daftar_kantor/submit_add_daftar_kantor.php");
  }

  public function edit_daftar_kantor($id)
  {
    include("administration/master_data/daftar_kantor/edit_daftar_kantor.php");
  }

  public function submit_edit_daftar_kantor()
  {
    include("administration/master_data/daftar_kantor/submit_edit_daftar_kantor.php");
  }

  public function delete_daftar_kantor($id)
  {
    include("administration/master_data/daftar_kantor/delete_daftar_kantor.php");
  }

  public function gudang()
  {
    include("administration/master_data/gudang/gudang.php");
  }

  public function catalog()
  {
    include("administration/master_data/catalog/catalog.php");
  }

  public function data_gudang()
  {
    include("administration/master_data/gudang/data_gudang.php");
  }

  public function data_catalog()
  {
    include("administration/master_data/catalog/data_catalog.php");
  }

  public function add_gudang()
  {
    include("administration/master_data/gudang/add_gudang.php");
  }

  public function submit_add_gudang()
  {
    include("administration/master_data/gudang/submit_add_gudang.php");
  }

  public function edit_gudang($id)
  {
    include("administration/master_data/gudang/edit_gudang.php");
  }

  public function submit_edit_gudang()
  {
    include("administration/master_data/gudang/submit_edit_gudang.php");
  }

  public function delete_gudang($id)
  {
    include("administration/master_data/gudang/delete_gudang.php");
  }

  public function komponisasi_template()
  {
    include("administration/master_data/komponisasi_template/komponisasi_template.php");
  }

  public function data_komponisasi_template()
  {
    include("administration/master_data/komponisasi_template/data_komponisasi_template.php");
  }

  public function tree_komponisasi_template()
  {
    include("administration/master_data/komponisasi_template/tree_komponisasi_template.php");
  }


  public function add_komponisasi_template()
  {
    include("administration/master_data/komponisasi_template/add_komponisasi_template.php");
  }

  public function submit_add_komponisasi_template()
  {
    include("administration/master_data/komponisasi_template/submit_add_komponisasi_template.php");
  }

  public function edit_komponisasi_template($id)
  {
    include("administration/master_data/komponisasi_template/edit_komponisasi_template.php");
  }

  public function submit_edit_komponisasi_template()
  {
    include("administration/master_data/komponisasi_template/submit_edit_komponisasi_template.php");
  }

  public function delete_komponisasi_template($id)
  {
    include("administration/master_data/komponisasi_template/delete_komponisasi_template.php");
  }


  public function kapal()
  {
    include("administration/master_data/kapal/kapal.php");
  }

  public function data_kapal()
  {
    include("administration/master_data/kapal/data_kapal.php");
  }

  public function add_kapal()
  {
    include("administration/master_data/kapal/add_kapal.php");
  }

  public function submit_add_kapal()
  {
    include("administration/master_data/kapal/submit_add_kapal.php");
  }

  public function edit_kapal($id)
  {
    include("administration/master_data/kapal/edit_kapal.php");
  }

  public function submit_edit_kapal()
  {
    include("administration/master_data/kapal/submit_edit_kapal.php");
  }

  public function delete_kapal($id)
  {
    include("administration/master_data/kapal/delete_kapal.php");
  }


  public function mata_anggaran_picker()
  {
    include("procurement/mata_anggaran/picker_mata_anggaran.php");
  }

  public function property_aset()
  {
    include("administration/master_data/property_aset/property_aset.php");
  }

  public function data_property_aset()
  {
    include("administration/master_data/property_aset/data_property_aset.php");
  }

  public function add_property_aset()
  {
    include("administration/master_data/property_aset/add_property_aset.php");
  }

  public function submit_add_property_aset()
  {
    include("administration/master_data/property_aset/submit_add_property_aset.php");
  }

  public function edit_property_aset($id)
  {
    include("administration/master_data/property_aset/edit_property_aset.php");
  }

  public function submit_edit_property_aset()
  {
    include("administration/master_data/property_aset/submit_edit_property_aset.php");
  }

  public function delete_property_aset($id)
  {
    include("administration/master_data/property_aset/delete_property_aset.php");
  }


  public function ruangan()
  {
    include("administration/master_data/ruangan/ruangan.php");
  }

  public function data_ruangan()
  {
    include("administration/master_data/ruangan/data_ruangan.php");
  }

  public function add_ruangan()
  {
    include("administration/master_data/ruangan/add_ruangan.php");
  }

  public function submit_add_ruangan()
  {
    include("administration/master_data/ruangan/submit_add_ruangan.php");
  }

  public function edit_ruangan($id)
  {
    include("administration/master_data/ruangan/edit_ruangan.php");
  }

  public function submit_edit_ruangan()
  {
    include("administration/master_data/ruangan/submit_edit_ruangan.php");
  }

  public function delete_ruangan($id)
  {
    include("administration/master_data/ruangan/delete_ruangan.php");
  }


  public function kategori_pajak()
  {
    include("administration/master_data/kategori_pajak/kategori_pajak.php");
  }

  public function data_kategori_pajak()
  {
    include("administration/master_data/kategori_pajak/data_kategori_pajak.php");
  }

  public function add_kategori_pajak()
  {
    include("administration/master_data/kategori_pajak/add_kategori_pajak.php");
  }

  public function submit_add_kategori_pajak()
  {
    include("administration/master_data/kategori_pajak/submit_add_kategori_pajak.php");
  }

  public function edit_kategori_pajak($id)
  {
    include("administration/master_data/kategori_pajak/edit_kategori_pajak.php");
  }

  public function submit_edit_kategori_pajak()
  {
    include("administration/master_data/kategori_pajak/submit_edit_kategori_pajak.php");
  }

  public function delete_kategori_pajak($id)
  {
    include("administration/master_data/kategori_pajak/delete_kategori_pajak.php");
  }

  public function pph()
  {
    include("administration/master_data/pph/pph.php");
  }

  public function add_pph()
  {
    include("administration/master_data/pph/add_pph.php");
  }

  public function data_pph()
  {
    include("administration/master_data/pph/data_pph.php");
  }

  public function submit_add_pph()
  {
    include("administration/master_data/pph/submit_add_pph.php");
  }

  public function edit_pph($id)
  {
    include("administration/master_data/pph/edit_pph.php");
  }

  public function submit_edit_pph()
  {
    include("administration/master_data/pph/submit_edit_pph.php");
  }

  public function dropdown_pph()
  {
    include("administration/master_data/pph/dropdown_pph.php");
  }

  public function delete_pph($id)
  {
    include("administration/master_data/pph/delete_pph.php");
  }

  public function check_pph($pph)
  {
    include("administration/master_data/pph/pph_check.php");
  }

  public function proyek()
  {
    include("administration/master_data/proyek/proyek.php");
  }

  public function add_proyek()
  {
    include("administration/master_data/proyek/add_proyek.php");
  }

  public function submit_add_proyek()
  {
    include("administration/master_data/proyek/submit_add_proyek.php");
  }

  public function edit_proyek($id)
  {
    include("administration/master_data/proyek/edit_proyek.php");
  }

  public function submit_edit_proyek()
  {
    include("administration/master_data/proyek/submit_edit_proyek.php");
  }

  public function delete_proyek($id)
  {
    include("administration/master_data/proyek/delete_proyek.php");
  }

  public function data_proyek($picker = "")
  {
      // echo "<pre>";
      // print_r($picker);
      // die;
    include("administration/master_data/proyek/data_proyek.php");
  }

  public function picker_nama_proyek()
  {
    include("administration/master_data/proyek/picker_nama_proyek.php");
  }

  public function anggaran()
  {
    include("administration/master_data/anggaran/anggaran.php");
  }

  public function data_anggaran()
  {
    include("administration/master_data/anggaran/data_anggaran.php");
  }

  public function add_anggaran()
  {
    include("administration/master_data/anggaran/add_anggaran.php");
  }

  public function submit_add_anggaran()
  {
    include("administration/master_data/anggaran/submit_add_anggaran.php");
  }

  public function edit_anggaran($id)
  {
    include("administration/master_data/anggaran/edit_anggaran.php");
  }

  public function submit_edit_anggaran()
  {
    include("administration/master_data/anggaran/submit_edit_anggaran.php");
  }

  public function delete_anggaran($id)
  {
    include("administration/master_data/anggaran/delete_anggaran.php");
  }

  public function picker_anggaran()
  {
    include("administration/master_data/anggaran/picker_anggaran.php");
  }

  public function news()
  {
    include("administration/document/news/news.php");
  }

  public function submit_news()
  {
    include("administration/document/news/submit_news.php");
  }

  public function delete_news($id)
  {
    include("administration/document/news/delete_news.php");
  }

  public function delete_news_lkpp($id)
  {
    include("administration/document/news/delete_news_lkpp.php");
  }

  public function submit_news_lkpp()
  {
    include("administration/document/news/submit_news_lkpp.php");
  }

  public function rks()
  {
    include("administration/master_data/rks/rks.php");
  }

  public function data_rks()
  {
    include("administration/master_data/rks/data_rks.php");
  }

  public function add_rks()
  {
    include("administration/master_data/rks/add_rks.php");
  }

  public function submit_add_rks_header()
  {
    include("administration/master_data/rks/submit_add_rks_header.php");
  }

  public function submit_add_rks_header_sub()
  {
    include("administration/master_data/rks/submit_add_rks_header_sub.php");
  }

  public function submit_add_rks_description()
  {
    include("administration/master_data/rks/submit_add_rks_description.php");
  }

  public function edit_rks($id)
  {
    include("administration/master_data/rks/edit_rks.php");
  }

  public function submit_edit_rks()
  {
    include("administration/master_data/rks/submit_edit_rks.php");
  }

  public function delete_rks($id)
  {
    include("administration/master_data/rks/delete_rks.php");
  }

  public function currency()
  {
    include("administration/master_data/currency/currency.php");
  }

  public function data_currency()
  {
    include("administration/master_data/currency/data_currency.php");
  }

  public function alias_currency()
  {
    include("administration/master_data/currency/alias_currency.php");
  }

  public function add_currency()
  {
    include("administration/master_data/currency/add_currency.php");
  }

  public function submit_add_currency()
  {
    include("administration/master_data/currency/submit_add_currency.php");
  }

  public function edit_currency($id)
  {
    include("administration/master_data/currency/edit_currency.php");
  }

  public function submit_edit_currency()
  {
    include("administration/master_data/currency/submit_edit_currency.php");
  }

  public function delete_currency($id)
  {
    include("administration/master_data/currency/delete_currency.php");
  }



  public function employee_type()
  {
    include("administration/master_data/employee_type/employee_type.php");
  }

  public function data_employee_type()
  {
    include("administration/master_data/employee_type/data_employee_type.php");
  }

  public function alias_employee_type()
  {
    include("administration/master_data/employee_type/alias_employee_type.php");
  }

  public function add_employee_type()
  {
    include("administration/master_data/employee_type/add_employee_type.php");
  }

  public function submit_add_employee_type()
  {
    include("administration/master_data/employee_type/submit_add_employee_type.php");
  }

  public function edit_employee_type($id)
  {
    include("administration/master_data/employee_type/edit_employee_type.php");
  }

  public function submit_edit_employee_type()
  {
    include("administration/master_data/employee_type/submit_edit_employee_type.php");
  }

  public function delete_employee_type($id)
  {
    include("administration/master_data/employee_type/delete_employee_type.php");
  }

  public function salutation()
  {
    include("administration/master_data/salutation/salutation.php");
  }

  public function data_salutation()
  {
    include("administration/master_data/salutation/data_salutation.php");
  }

  public function alias_salutation()
  {
    include("administration/master_data/salutation/alias_salutation.php");
  }

  public function add_salutation()
  {
    include("administration/master_data/salutation/add_salutation.php");
  }

  public function submit_add_salutation()
  {
    include("administration/master_data/salutation/submit_add_salutation.php");
  }

  public function edit_salutation($id)
  {
    include("administration/master_data/salutation/edit_salutation.php");
  }

  public function submit_edit_salutation()
  {
    include("administration/master_data/salutation/submit_edit_salutation.php");
  }

  public function delete_salutation($id)
  {
    include("administration/master_data/salutation/delete_salutation.php");
  }

  public function data_user_list()
  {
    include("administration/user_management/data_user_list.php");
  }

  public function menu_management()
  {
    include("administration/master_data/menu_management/menu_management.php");
  }

  public function data_menu_management()
  {
    include("administration/master_data/menu_management/data_menu_management.php");
  }

  public function submit_menu_management()
  {
    include("administration/master_data/menu_management/submit_menu_management.php");
  }

  public function data_master_mata_anggaran()
  {
    include("administration/master_data/mata_anggaran/master_mata_anggaran/data_master_mata_anggaran.php");
  }

  public function add_master_mata_anggaran()
  {
    include("administration/master_data/mata_anggaran/master_mata_anggaran/add_master_mata_anggaran.php");
  }

  public function submit_add_master_mata_anggaran()
  {
    include("administration/master_data/mata_anggaran/master_mata_anggaran/submit_add_master_mata_anggaran.php");
  }

  public function edit_master_mata_anggaran($id)
  {
    include("administration/master_data/mata_anggaran/master_mata_anggaran/edit_master_mata_anggaran.php");
  }

  public function submit_edit_master_mata_anggaran()
  {
    include("administration/master_data/mata_anggaran/master_mata_anggaran/submit_edit_master_mata_anggaran.php");
  }

  public function delete_master_mata_anggaran($id)
  {
    include("administration/master_data/mata_anggaran/master_mata_anggaran/delete_master_mata_anggaran.php");
  }

  public function hierarchy_position()
  {
    include("administration/admin_tools/hierarchy_position/hierarchy_position.php");
  }

  public function act_hierarchy_position($act, $id, $type = "")
  {
    include("administration/admin_tools/hierarchy_position/form_hierarchy_position.php");
  }

  public function submit_hierarchy_position()
  {
    include("administration/admin_tools/hierarchy_position/submit_hierarchy_position.php");
  }

  public function edit_hierarchy_position($id)
  {
    include("administration/admin_tools/hierarchy_position/edit_hierarchy_position.php");
  }

  public function submit_edit_hierarchy_position()
  {
    include("administration/admin_tools/hierarchy_position/submit_edit_hierarchy_position.php");
  }

  public function delete_hierarchy_position($id)
  {
    include("administration/admin_tools/hierarchy_position/delete_hierarchy_position.php");
  }

  public function position()
  {
    include("administration/admin_tools/position/position.php");
  }

  public function data_position()
  {
    include("administration/admin_tools/position/data_position.php");
  }

  public function add_position()
  {
    include("administration/admin_tools/position/add_position.php");
  }

  public function submit_add_position()
  {
    include("administration/admin_tools/position/submit_add_position.php");
  }

  public function edit_position($id)
  {
    include("administration/admin_tools/position/edit_position.php");
  }

  public function submit_edit_position()
  {
    include("administration/admin_tools/position/submit_edit_position.php");
  }

  public function delete_position($id)
  {
    include("administration/admin_tools/position/delete_position.php");
  }

  public function exchange_rate()
  {
    include("administration/admin_tools/exchange_rate/exchange_rate.php");
  }

  public function data_exchange_rate()
  {
    include("administration/admin_tools/exchange_rate/data_exchange_rate.php");
  }

  public function alias_exchange_rate()
  {
    include("administration/admin_tools/exchange_rate/alias_exchange_rate.php");
  }

  public function add_exchange_rate()
  {
    include("administration/admin_tools/exchange_rate/add_exchange_rate.php");
  }

  public function submit_add_exchange_rate()
  {
    include("administration/admin_tools/exchange_rate/submit_add_exchange_rate.php");
  }

  public function edit_exchange_rate($id)
  {
    include("administration/admin_tools/exchange_rate/edit_exchange_rate.php");
  }

  public function submit_edit_exchange_rate()
  {
    include("administration/admin_tools/exchange_rate/submit_edit_exchange_rate.php");
  }

  public function delete_exchange_rate($id)
  {
    include("administration/admin_tools/exchange_rate/delete_exchange_rate.php");
  }

  public function generate_menu()
  {
    include("administration/master_data/menu_management/generate_menu.php");
  }

  public function generate_anggaran()
  {
    include("administration/master_data/anggaran/generate_anggaran.php");
  }


  public function lintasan()
  {
    include("administration/master_data/lintasan/lintasan.php");
  }

  public function data_lintasan()
  {
    include("administration/master_data/lintasan/data_lintasan.php");
  }

  public function alias_lintasan()
  {
    include("administration/master_data/lintasan/alias_lintasan.php");
  }

  public function add_lintasan()
  {
    include("administration/master_data/lintasan/add_lintasan.php");
  }

  public function submit_add_lintasan()
  {
    include("administration/master_data/lintasan/submit_add_lintasan.php");
  }

  public function edit_lintasan($id)
  {
    include("administration/master_data/lintasan/edit_lintasan.php");
  }

  public function submit_edit_lintasan()
  {
    include("administration/master_data/lintasan/submit_edit_lintasan.php");
  }

  public function nonaktif_lintasan()
  {
    include("administration/master_data/lintasan/nonaktif_lintasan.php");
  }

  //y delegasi
  public function delegasi_tugas()
  {
    include("administration/master_data/delegasi_tugas/delegasi_tugas.php");
  }

  public function data_delegasi_tugas()
  {
    include("administration/master_data/delegasi_tugas/data_delegasi_tugas.php");
  }

  public function add_delegasi_tugas()
  {
    include("administration/master_data/delegasi_tugas/add_delegasi_tugas.php");
  }

  public function submit_add_delegasi_tugas()
  {
    include("administration/master_data/delegasi_tugas/submit_add_delegasi_tugas.php");
  }

  public function edit_delegasi_tugas($id)
  {
    include("administration/master_data/delegasi_tugas/edit_delegasi_tugas.php");
  }

  public function submit_edit_delegasi_tugas()
  {
    include("administration/master_data/delegasi_tugas/submit_edit_delegasi_tugas.php");
  }
  //end delegasi

  public function data_crm()
  {
    include("administration/master_data/data_crm/data_crm.php");
  }

  public function deskripsi_matgis()
  {
    include("administration/master_data/deskripsi_matgis/deskripsi_matgis.php");
  }

  public function data_deskripsi_matgis()
  {
    include("administration/master_data/deskripsi_matgis/data_deskripsi_matgis.php");
  }

  public function alias_deskripsi_matgis()
  {
    include("administration/master_data/deskripsi_matgis/alias_deskripsi_matgis.php");
  }

  public function add_deskripsi_matgis()
  {
    include("administration/master_data/deskripsi_matgis/add_deskripsi_matgis.php");
  }

  public function submit_add_deskripsi_matgis()
  {
    include("administration/master_data/deskripsi_matgis/submit_add_deskripsi_matgis.php");
  }

  public function edit_deskripsi_matgis($id)
  {
    include("administration/master_data/deskripsi_matgis/edit_deskripsi_matgis.php");
  }

  public function submit_edit_deskripsi_matgis()
  {
    include("administration/master_data/deskripsi_matgis/submit_edit_deskripsi_matgis.php");
  }

  public function nonaktif_deskripsi_matgis()
  {
    include("administration/master_data/deskripsi_matgis/nonaktif_deskripsi_matgis.php");
  }

  public function template_vpi($param1, $param2 = "", $param3 = "", $param4 = "")
  {

    switch ($param1) {

        //template penilaian penyedia barang
      case 'penilaian_penyedia_barang':

        switch ($param2) {

            // hasil_mutu_pekerjaan
          case 'hasil_mutu_pekerjaan':

            switch ($param3) {
              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_barang/hasil_mutu_pekerjaan/submit_add_hasil_mutu_pekerjaan.php");
                break;

              case 'data_hasil_mutu_pekerjaan':
                include("administration/template_vpi/penilaian_penyedia_barang/hasil_mutu_pekerjaan/data_hasil_mutu_pekerjaan.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_barang/hasil_mutu_pekerjaan/update_hasil_mutu_pekerjaan.php");
                break;

              case 'nonaktif':
                include("administration/template_vpi/penilaian_penyedia_barang/hasil_mutu_pekerjaan/delete_hasil_mutu_pekerjaan.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_barang/hasil_mutu_pekerjaan/activate_hasil_mutu_pekerjaan.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_barang/hasil_mutu_pekerjaan/hasil_mutu_pekerjaan.php");
                break;
            }

            break;

            //k3l
          case 'k3l':
            switch ($param3) {

              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_barang/k3l/submit_add_k3l.php");
                break;

              case 'data_k3l':
                include("administration/template_vpi/penilaian_penyedia_barang/k3l/data_k3l.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_barang/k3l/update_k3l.php");
                break;

              case 'nonaktif':
                include("administration/template_vpi/penilaian_penyedia_barang/k3l/delete_k3l.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_barang/k3l/activate_k3l.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_barang/k3l/k3l.php");
                break;
            }

            break;

            //5r
          case '5r':
            switch ($param3) {
              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_barang/5r/submit_add_5r.php");
                break;

              case 'data_5r':
                include("administration/template_vpi/penilaian_penyedia_barang/5r/data_5r.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_barang/5r/update_5r.php");
                break;

              case 'nonaktif':
                include("administration/template_vpi/penilaian_penyedia_barang/5r/delete_5r.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_barang/5r/activate_5r.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_barang/5r/5r.php");
                break;
            }
            break;

            //pengamanan
          case 'pengamanan':
            switch ($param3) {

              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_barang/pengamanan/submit_add_pengamanan.php");
                break;

              case 'data_pengamanan':
                include("administration/template_vpi/penilaian_penyedia_barang/pengamanan/data_pengamanan.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_barang/pengamanan/update_pengamanan.php");
                break;

              case 'nonaktif':
                include("administration/template_vpi/penilaian_penyedia_barang/pengamanan/delete_pengamanan.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_barang/pengamanan/activate_pengamanan.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_barang/pengamanan/pengamanan.php");
                break;
            }
            break;

          case 'bobot_dan_target':
            switch ($param3) {

              case 'submit':
                include("administration/template_vpi/penilaian_penyedia_barang/bobot_dan_target/submit_bobot_dan_target.php");
                break;
            }
            break;

          default:
            include("administration/template_vpi/penilaian_penyedia_barang/penilaian_penyedia_barang.php");
            break;
        }
        break;

        //template penilaian penyedia jasa

      case 'penilaian_penyedia_jasa':

        switch ($param2) {

            // hasil_mutu_pekerjaan
          case 'hasil_mutu_pekerjaan':
            switch ($param3) {
              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_jasa/hasil_mutu_pekerjaan/submit_add_hasil_mutu_pekerjaan.php");
                break;

              case 'data_hasil_mutu_pekerjaan':
                include("administration/template_vpi/penilaian_penyedia_jasa/hasil_mutu_pekerjaan/data_hasil_mutu_pekerjaan.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_jasa/hasil_mutu_pekerjaan/update_hasil_mutu_pekerjaan.php");
                break;

              case 'nonaktif': //nonaktifkan
                include("administration/template_vpi/penilaian_penyedia_jasa/hasil_mutu_pekerjaan/delete_hasil_mutu_pekerjaan.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_jasa/hasil_mutu_pekerjaan/activate_hasil_mutu_pekerjaan.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_jasa/hasil_mutu_pekerjaan/hasil_mutu_pekerjaan.php");
                break;
            }

            break;

            //k3l
          case 'k3l':
            switch ($param3) {
              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_jasa/k3l/submit_add_k3l.php");
                break;

              case 'data_k3l':
                include("administration/template_vpi/penilaian_penyedia_jasa/k3l/data_k3l.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_jasa/k3l/update_k3l.php");
                break;

              case 'nonaktif':
                include("administration/template_vpi/penilaian_penyedia_jasa/k3l/delete_k3l.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_jasa/k3l/activate_k3l.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_jasa/k3l/k3l.php");
                break;
            }

            break;

            //5r
          case '5r':
            switch ($param3) {
              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_jasa/5r/submit_add_5r.php");
                break;

              case 'data_5r':
                include("administration/template_vpi/penilaian_penyedia_jasa/5r/data_5r.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_jasa/5r/update_5r.php");
                break;

              case 'nonaktif':
                include("administration/template_vpi/penilaian_penyedia_jasa/5r/delete_5r.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_jasa/5r/activate_5r.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_jasa/5r/5r.php");
                break;
            }
            break;

          case 'pengamanan':

            switch ($param3) {
              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_jasa/pengamanan/submit_add_pengamanan.php");
                break;

              case 'data_pengamanan':
                include("administration/template_vpi/penilaian_penyedia_jasa/pengamanan/data_pengamanan.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_jasa/pengamanan/update_pengamanan.php");
                break;

              case 'nonaktif':
                include("administration/template_vpi/penilaian_penyedia_jasa/pengamanan/delete_pengamanan.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_jasa/pengamanan/activate_pengamanan.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_jasa/pengamanan/pengamanan.php");
                break;
            }
            break;

          case 'bobot_dan_target':
            switch ($param3) {

              case 'submit':
                include("administration/template_vpi/penilaian_penyedia_jasa/bobot_dan_target/submit_bobot_dan_target.php");
                break;
            }
            break;

          default:
            include("administration/template_vpi/penilaian_penyedia_jasa/penilaian_penyedia_jasa.php");
            break;
        }
        break;

      case 'penilaian_penyedia_konsultan':

        switch ($param2) {

          case 'mutu':

            switch ($param3) {
              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_konsultan/mutu/submit_add.php");
                break;

              case 'data_mutu':
                include("administration/template_vpi/penilaian_penyedia_konsultan/mutu/data_mutu.php");
                break;

              case 'nonaktif':
                include("administration/template_vpi/penilaian_penyedia_konsultan/mutu/delete_mutu.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_konsultan/mutu/activate_mutu.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_konsultan/mutu/update_mutu.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_konsultan/mutu/mutu.php");
                break;
            }

            break;

          case 'pelayanan':

            switch ($param3) {
              case 'submit_add':
                include("administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/submit_add.php");
                break;

              case 'data_pelayanan':
                include("administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/data_pelayanan.php");
                break;

              case 'nonaktif':
                include("administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/delete_pelayanan.php");
                break;

              case 'aktifkan':
                include("administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/activate_pelayanan.php");
                break;

              case 'update':
                include("administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/update_pelayanan.php");
                break;

              default:
                include("administration/template_vpi/penilaian_penyedia_konsultan/pelayanan/pelayanan.php");
                break;
            }

            break;

          case 'bobot_dan_target':
            switch ($param3) {

              case 'submit':
                include("administration/template_vpi/penilaian_penyedia_konsultan/bobot_dan_target/submit_bobot_dan_target.php");
                break;
            }
            break;

          default:
            include("administration/template_vpi/penilaian_penyedia_konsultan/penilaian_penyedia_konsultan.php");
            break;
        }

        break;


        break;
    }
  }


  public function template_vsi($param1, $param2 = "")
  {

    switch ($param1) {

      case 'template_kuesioner':

        switch ($param2) {
          case 'submit_add':
            include("administration/template_vsi/template_kuesioner/submit_add_template_kuesioner.php");
            break;

          case 'data_template_kuesioner':
            include("administration/template_vsi/template_kuesioner/data_template_kuesioner.php");
            break;

          case 'nonaktif':
            include("administration/template_vsi/template_kuesioner/delete_template_kuesioner.php");
            break;

          case 'ubah_status':
            include("administration/template_vsi/template_kuesioner/update_status_template_kuesioner.php");
            break;

          case 'update':
            include("administration/template_vsi/template_kuesioner/update_template_kuesioner.php");
            break;

          case 'list':
            include("administration/template_vsi/template_kuesioner/template_kuesioner.php");
            break;

          default:
            include("administration/template_vsi/template_kuesioner/template_kuesioner.php");
            break;
        }

        break;

      case 'kuesioner':

        switch ($param2) {
          case 'submit_add':
            include("administration/template_vsi/kuesioner/submit_add_kuesioner.php");
            break;

          case 'data_kuesioner':
            include("administration/template_vsi/kuesioner/data_kuesioner.php");
            break;

          case 'update_status':
            include("administration/template_vsi/kuesioner/update_status_kuesioner.php");
            break;

          case 'update':
            include("administration/template_vsi/kuesioner/update_kuesioner.php");
            break;

          default:
            include("administration/template_vsi/kuesioner/kuesioner.php");
            break;
        }

        break;

      case 'template_kompilasi':

        switch ($param2) {

          case 'data':
            include("administration/template_vsi/template_kompilasi/data_template_kompilasi.php");
            break;

          case 'lihat':
            include("administration/template_vsi/template_kompilasi/lihat_template_kompilasi.php");
            break;

          default:
            include("administration/template_vsi/template_kompilasi/template_kompilasi.php");
            break;
        }

        break;
    }
  }
  public function panduan()
  {
    redirect(base_url("guide/WIKA_eSCM_Quick_Guide_Administration_v0.1.pptx"));
  }
}
