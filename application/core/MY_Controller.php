<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Telescoope_Controller extends CI_Controller
{

  var $error_page = false;

  function __construct()
  {

    parent::__construct();

    //$this->output->enable_profiler(TRUE);

    $this->load->model(array('globalparam_m', 'Administration_m', 'Vendor_m'));

    $this->lang->load(array('form_validation', 'custom'), 'indonesian');

    $this->load->helper('language');

    $this->data["picker"] = $this->session->userdata("picker");

    $default_currency = array();

    $currency = $this->db->get("adm_curr")->result_array();

    foreach ($currency as $key => $value) {
      $default_currency[$value['curr_code']] = $value['curr_code'] . " - " . $value['curr_name'];
    }

    $this->data['default_currency'] = $default_currency;

    $validation_key = array(
      "required",
      "isset",
      "valid_email",
      "valid_emails",
      "valid_url",
      "valid_ip",
      "min_length",
      "max_length",
      "exact_length",
      "alpha",
      "alpha_numeric",
      "alpha_numeric_spaces",
      "alpha_dash",
      "numeric",
      "is_numeric",
      "integer",
      "regex_match",
      "matches",
      "differs",
      "is_unique",
      "is_natural",
      "is_natural_no_zero",
      "decimal",
      "less_than",
      "less_than_equal_to",
      "greater_than",
      "greater_than_equal_to",
      "error_message_not_set",
      "in_list"
    );

    foreach ($validation_key as $key => $value) {

      $translate = $this->lang->line('form_validation_' . $value);
      $this->form_validation->set_message($value, $translate);
    }
  }

  public function setMessage($message)
  {

    $current_message = $this->session->userdata("message");


    if (!empty($message)) {
      if (is_array($message)) {
        $message = implode("<br/>", $message);
      }
      $this->session->set_userdata("message", $message . "<br/>" . $current_message);
    }
  }

  public function renderMessage($status, $redirect = "")
  {

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $message = validation_errors();
    $message .= $this->session->userdata("message");

    if ($this->input->is_ajax_request()) {

      $this->output
        ->set_content_type('application/json')
        ->set_output(json_encode(array('message' => $message, "status" => $status, "redirect" => $redirect)));

      $this->session->unset_userdata("message");
    } else {
      $this->template("", "Sorry", array());
    }
  }

  public function sendEmail($to = "", $title = "", $message = "", $is_with_no_response = "")
  {

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'mx-gw.wika.co.id';
    $config['smtp_user'] = 'admin@wikamail.id';
    $config['smtp_crypto'] = "tls";
    $config['smtp_port'] = 26;
    $config['mailtype'] = 'html';
    $config['wordwrap'] = TRUE;
    $config['useragent'] = COMPANY_NAME;
    $config['charset'] = 'utf8';
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";


    $this->load->library(array('email', 'parser'));

    $this->email->initialize($config);

    $email_cont = $this->load->view("email/alert", "", true);

    $content = trim($email_cont);

    $data['message'] = $message;

    $data['title'] = $title;

    $html = $this->parser->parse_string($content, $data, true);

    $this->email->reply_to('info.scm@wika.co.id', 'INFO SCM WIKA');
    $this->email->from('admin@wikamail.id', COMPANY_NAME);
    $this->email->to($to);

    $this->email->subject($title);
    $this->email->message($html);

    $email = $this->email->send();

    $this->email->clear();

    if ($email) {

      if (!empty($is_with_no_response)) {
        $this->setMessage("Success to send email to " . $to . "!");
      }
    }

    return $html;
  }

  public function noAccess($message = "")
  {
    $msg = (empty($message)) ? "Sorry you dont have access to this menu" : $message;
    $this->setMessage($msg);
    $this->renderMessage("error", "");
    $this->error_page = true;
  }

  public function selection($selector)
  {

    $get = $this->input->get();

    $filter_add = array();
    $filter_del = array();

    $selection = $this->data[$selector];

    foreach ($get as $key => $value) {
      if ($value == 1) {
        $filter_add[] = $key;
      } else {
        $filter_del[] = $key;
      }
    }

    foreach ($filter_add as $key => $value) {
      if (!empty($selection)) {
        if (!in_array($value, $selection)) {
          $selection[] = $value;
        }
      } else {
        $selection[] = $value;
      }
    }

    if (!empty($filter_del) && is_array($selection)) {
      $selection = array_intersect($selection, $filter_del);
    }

    if (empty($get)) {
      $selection = array();
    } else {
    }

    $selection = @array_unique($selection);

    $this->session->set_userdata($selector, $selection);
  }

  public function set_session($key = "", $val = "")
  {
    if (!empty($key)) {
      $this->session->set_userdata($key, $val);
    }
  }

  public function unset_session($key = "", $val = "")
  {
    if (!empty($key)) {
      $this->session->unset_userdata($key);
    }
  }

  public function picker()
  {

    $selector = "picker";

    $get = $this->input->get();

    if (!empty($get)) {

      $this->session->unset_userdata($selector);

      $filter_add = array();
      $filter_del = array();

      foreach ($get as $key => $value) {
        $selection = $key;
      }

      $this->session->set_userdata($selector, $selection);
    } else {
      $data = $this->session->userdata($selector);
      echo json_encode($data);
    }
  }

  public function template($view =  "", $title = "", $data = array())
  {

    $user = $this->Administration_m->getLogin();

    $mymenu = $this->Administration_m->getMenuUser($user['employee_id']);

    $data['position'] = $this->Administration_m->getEmployeePosDelegasi($user['employee_id'])->result_array(); //y add

    $menu = array();

    if (!empty($mymenu)) {

      foreach ($mymenu[0] as $key => $value) {

        $menu[$value['url_path']] = array(
          "icon" => $value['icon'],
          "label" => $value['menu_name'],
          "child" => array()
        );

        if (isset($mymenu[$value['menu_id']]) && !empty($mymenu[$value['menu_id']])) {

          $sub = $mymenu[$value['menu_id']];

          $child = array();

          foreach ($sub as $key2 => $value2) {

            $subsub = array();

            $child2 = array();

            if (isset($mymenu[$value2['menu_id']]) && !empty($mymenu[$value2['menu_id']])) {

              $subsub = $mymenu[$value2['menu_id']];

              foreach ($subsub as $key3 => $value3) {

                $child2[$value['url_path'] . "/" . $value2['url_path'] . "/" . $value3['url_path']] = array("label" => $value3['menu_name'], "icon" => $value3['icon'], "child" => array());
              }
            }

            $child[$value['url_path'] . "/" . $value2['url_path']] = array("label" => $value2['menu_name'], "icon" => $value2['icon'], "child" => $child2);
          }

          $menu[$value['url_path']]['child'] = $child;
        }
      }
    }

    $data['main_menu'] = $menu;

    $data['mytitle'] = $title;

    $setting = $this->globalparam_m->getData();

    if (empty($view)) {
      $view = "default_v";
    }

    if (!empty($title)) {
      $title = $setting['site_name'] . " - " . $title;
    } else {
      $title = $setting['site_name'];
    }

    $data['body'] = $view;
    $data['judul'] = $title;
    $data['user_login'] = $user;

    $this->db->order_by("time", "desc");

    $data['jobs'] = $this->Administration_m->getAllJob($user['employee_id'], "")->result_array();

    $data['jobsrow'] = $this->Administration_m->getAllJob($user['employee_id'], 5)->result_array();


    //hlmifzi
    $infoDate = date('Y-m-d', strtotime('+2 months'));
    $this->db->or_where("address_domisili_exp_date <=", $infoDate);
    $this->db->or_where("siup_to <=", $infoDate);
    $this->db->or_where("tdp_to <=", $infoDate);
    $data['docExVends'] = $this->Vendor_m->getVendor()->result_array();

    //end

    $msg = $this->Administration_m->getMessageRfq(trim($user['first_last_name']));

    $data['messages'] = null;

    if ($msg) {

      $data['messages'] = $msg->result_array();
    }

    if (count($data['messages']) == 0) {
      $data['tmessages'] = 0;
    } else {
      $data['tmessages'] = 1;
    }

    $session_userdata = [
      'totalmessages' => "<span class=\"label label-info pull-right\">" . count($data['messages']) . "</span>",
      'totaljob' => "<span class=\"label label-info pull-right\">" . count($data['jobs']) . "</span>",
      'totalDocExVend' => "<span class=\"label label-warning pull-right\">" . count($data['docExVends']) . "</span>",
    ];

    $this->session->set_userdata($session_userdata);

    $data = array_merge($this->data, $data, $setting);

    if (!$this->error_page) {

      $this->load->view("template", $data);
    }
  }

  //===========K=====To PDF
  public function generatePDF($data)
  {
    $this->load->helper('pdf_helper');

    $this->load->view('pdfreport', $data);
  }
  //=================
  //===========K=====To Excel
  public function generateExcel($data)
  {

    $this->load->view('excelreport', $data);
  }
  //=================
  //==================Motong Angka
  function truncate_number($number, $precision = 2)
  {
    // Zero causes issues, and no need to truncate
    if (0 == (int)$number) {
      return round($number, 2);
    }
    // Are we negative?
    $negative = $number / abs($number);
    // Cast the number to a positive to solve rounding
    $number = abs($number);
    // Calculate precision number for dividing / multiplying
    $precision = pow(10, $precision);
    // Run the math, re-applying the negative value to ensure returns correctly negative / positive
    return floor($number * $precision) / $precision * $negative;
  }
  //==================


  public function syarat_penunjuk_lgsg($id)
  {
    // gunakan ID untuk pencarian data dari Key
    $data = [
      1 => "1. Barang dan Jasa yang dibutuhkan bagi kinerja utama perusahaan dan tidak dapat ditunda keberadaannya (business critical asset)",
      2 => "2. Hanya terdapat satu penyedia Barang dan Jasa yang dapat melaksanakan pekerjaan sesuai kebutuhan pengguna (user requirement) atau sesuai dengan ketentuan peraturan perundangan yang berlaku",
      3 => "3. Barang dan jasa yg bersifat knowledge intensive dimana untuk menggunakan dan memelihara produk tersebut membutuhkan kelangsungan pengetahuan dari penyedia barang dan jasa",
      4 => "4. Bila pelaksanaan pengadaan barang dan jasa dengan menggunakan cara tender/seleksi  umum atau tender terbatas/seleksi terbatas, telah 2 (dua) kali dilakukan dan tidak mendapatkan Penyedia Barang dan Jasa yang dibutuhkan atau tidak ada pihak yang memenuhi kriteria atau tidak ada pihak yang mengikuti tender / seleksi",
      5 => "5. Barang dan jasa yang dimiliki oleh pemegang Hak Atas Kekayaan Intelektual (HAKI) atau yg memiliki jaminan (warranty) dari Original Equipment Manufacture",
      6 => "6. Penanganan darurat untuk keamanan, keselamatan masyarakat dan aset strategis perusahaan",
      7 => "7. Barang dan jasa yang merupakan pembelian berulang (repeat order) sepanjang harga yang ditawarkan menguntungkan dengan tidak mengorbankan kualitas barang dan jasa",
      8 => "8. Penanganan darurat akibat bencana alam, baik yang bersifat lokal maupun nasional (force majeure)",
      9 => "9. Barang dan jasa lanjutan yang secara teknis merupakan satu kesatuan yang sifatnya tidak dapat dipecah-pecah dari pekerjaan yang sudah dilaksanakan sebelumny",
      10 => "10. Penyedia barang dan Jasa adalah BUMN, Anak Perusahaan atau Perusahaan Terafiliasi BUMN, sepanjang kualitas harga dan tujuannya dapat dipertanggungjawabkan dan barang dan jasa yang dibutuhkan merupakan produk atau layanan sesuai dengan bidang usaha dari penyedia barang dan jasa bersangkutan",
      11 => "11. Pengadaan barang dan jasa dalam jumlah dan nilai tertentu yang ditetapkan Direksi dengan terlebih dahulu mendapat persetujuan dewan Komisaris",
      12 => "12. Konsultan yang tidak direncanakan sebelumnya untuk menghadapi permasalahan tertentu yang sifat pelaksanaan pekerjaannya harus segera dan tidak dapat ditunda",
    ];

    if (!empty($id) || $id != "") {
      return $data[$id];
    } else {
      return $data;
    }
  }

  public function do_upload($filename, $tenderid, $job)
  {
    $config['upload_path'] = 'uploads/' . $tenderid . '/' . $job;
    if ($job != "penawaran" || $job != "prakualifikasi") {
      $config['max_size'] = 10250;
    } else {
      $config['max_size'] = 10250;
    }

    $config['allowed_types'] = '*';
    $config['encrypt_name'] = true;

    if (!is_dir('uploads')) {
      mkdir('uploads', 0777, true);
    }
    if (!is_dir('uploads/' . $tenderid)) {
      mkdir('uploads/' . $tenderid, 0777, true);
    }
    if (!is_dir('uploads/' . $tenderid . '/' . $job)) {
      mkdir('uploads/' . $tenderid . '/' . $job, 0777, true);
    }

    $this->load->library('upload', $config);

    $this->upload->initialize($config);

    $upload = $this->upload->do_upload($filename);

    if ($upload) {
      return $this->upload->data('file_name');
    } else {
      return array("0" => "1", "1" => $this->upload->display_errors());
    }
  }
}
