<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define("DEFAULT_MAXLENGTH", 500); //before 120 
define("DEFAULT_MAXLENGTH_TEXT", 800);
define("DEFAULT_MAXLENGTH_CODE", 10);
define("GLOBAL_PPN", 0.1);
define("COMMODITY_GROUP_MAX_LEVEL", 1);
define("COMMODITY_KATALOG_JASA_PATH", "commodity/katalog/katalog_jasa_sumberdaya");
define("COMMODITY_KATALOG_BARANG_PATH", "commodity/katalog/katalog_barang_sumberdaya");
define("COMMODITY_KATALOG_ALL_PATH", "commodity/katalog/katalog_all_sumberdaya");
define("COMMODITY_GRUP_JASA_PATH", "commodity/katalog/grup_jasa");
define("COMMODITY_GRUP_BARANG_PATH", "commodity/katalog/grup_barang");
define("COMMODITY_HARGA_JASA_PATH", "commodity/daftar_harga/daftar_harga_jasa");
define("COMMODITY_HARGA_BARANG_PATH", "commodity/daftar_harga/daftar_harga_barang");
define("COMMODITY_KATALOG_JASA_FOLDER", "commodity/jasa");
define("COMMODITY_KATALOG_BARANG_FOLDER", "commodity/barang");
define("PROCUREMENT_MATA_ANGGARAN_PATH", "procurement/mata_anggaran");
define("PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER", "procurement/perencanaan");
//helmi
define("PROCUREMENT_PERENCANAAN_CHAT_SPPBJ_FOLDER", "procurement/chat_sppbj");
define("CONTRACT_INVOICE_LAMPIRAN", "http://localhost/adw/wika_v1/extranet/attachment");
define("ASET_BERKALA_LAMPIRAN", "http://localhost/adw/wika_v1/uploads/aset/aset_berkala");
//end
//haqim
define("PROCUREMENT_PERENCANAAN_CHAT_RFQ_FOLDER", "procurement/chat_rfq");
//end
define("PROCUREMENT_PERENCANAAN_PENGADAAN_PATH", "procurement/perencanaan_pengadaan");
define("PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER", "procurement/permintaan");
define("PROCUREMENT_PERMINTAAN_PENGADAAN_PATH", "procurement/permintaan_pengadaan");
define("PROCUREMENT_TENDER_PENGADAAN_FOLDER", "procurement/tender");
define("PROCUREMENT_TEMPLATE_EVALUASI_PATH", "procurement/template_evaluasi");
define("PROCUREMENT_PANITIA_PENGADAAN_PATH", "procurement/procurement_tools/panitia_pengadaan");
define("PROCUREMENT_VERIFIKASI_VENDOR_PATH", "procurement/verifikasi_vendor");
define("PROCUREMENT_EVALUASI_TEKNIS_VENDOR_PATH", "procurement/evaluasi_teknis");
define("PROCUREMENT_EVALUASI_HARGA_VENDOR_PATH", "procurement/evaluasi_harga");
define("PROCUREMENT_SANGGAHAN_PICKER_PATH", "procurement/picker_sanggahan");
define("PROCUREMENT_SANGGAHAN_DETAIL_PATH", "procurement/lihat_sanggahan");
define("CONTRACT_FOLDER", "contract");
define("ADDENDUM_FOLDER", "addendum");
define("CONTRACT_UPDATE_MILESTONE_PATH", "contract/update_milestone");
define("CONTRACT_TAGIHAN_MILESTONE_PATH", "contract/tagihan_milestone");
define("TIKET_PERMINTAAN_TIKET_FOLDER", "tiket");
define("TIKET_PERMINTAAN_TIKET_PATH", "tiket");
define("DEFAULT_FORMAT_DATETIME", "d/m/y - H:i:s");
define("DEFAULT_FORMAT_DATE", "d/m/y");
define("DEFAULT_FORMAT_TIME", "H:i:s");
define("DEFAULT_FORMAT_DATETIME_DB", "Y-m-d H:i:s");
define("EXTRANET_URL", "https://vendor.wika.co.id/");
define("DEFAULT_BOOTSTRAP_TABLE_CONFIG", "striped:true,
      sidePagination:'server',
      smartDisplay:false,
      cookie:true,
      cookieExpire:'1h',
      showExport:false,
      exportTypes:['json', 'xml', 'csv', 'txt', 'excel'],
      showFilter:true,
      flat:true,
      keyEvents:false,
      showMultiSort:false,
      reorderableColumns:false,
      resizable:false,
      pagination:true,
      cardView:false,
      detailView:false,
      search:true,
      showRefresh:true,
      showToggle:true,
        clickToSelect:true,
      showColumns:true,");
define("DEFAULT_BOOTSTRAP_TABLE_CONFIG_NOSEARCH", "striped:true,
      sidePagination:'server',
      smartDisplay:false,
      cookie:true,
      cookieExpire:'1h',
      showExport:false,
      exportTypes:['json', 'xml', 'csv', 'txt', 'excel'],
      showFilter:true,
      flat:true,
      keyEvents:false,
      showMultiSort:false,
      reorderableColumns:false,
      resizable:false,
      pagination:true,
      cardView:false,
      detailView:false,
      search:false,
      showRefresh:true,
      showToggle:true,
        clickToSelect:true,
      showColumns:true,");
define("DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME","Aksi");
define("INTRANET_UPLOAD_FOLDER", "http://192.168.2.207/wika/uploads");
define("COMPANY_NAME","PT WIJAYA KARYA (Persero) Tbk");
define("COMPANY_LABEL","PT WIJAYA KARYA (Persero) Tbk");
define("COMPANY_ADDRESS","PT WIJAYA KARYA (Persero) Tbk.<br/>
        JL. D.I. Panjaitan Kav. 9-10, Jakarta 13340 <br/>
        Phone : +6221 8067 9200<br/>
        Fax: +6221 2289 3830 - INDONESIA");
define("COMPANY_EMAIL","humas@wika.co.id");
define("COMPANY_WEBSITE","localhost:9090/web_scm_wika/");
define("SESSION_PREFIX","wika_int");
//define("WEBSOCKET_URL","ws://192.168.2.206:8899/");
define("HEADQUATERS_CODE", "110");
define("UMKM_PADI", "https://api.apilogy.id/padi-umkm/1.2.0/padis");
define("API_KEY_PADI", "yuscxx6qiewMh4JIybGoLVWPKPcbCRI4");
define('NASABAH_URL', 'http://developer.wika.co.id/nasabah/index.php/apiscm');
define('BUDGET_URL', 'https://fioridev.wika.co.id/ywikamm012/prchk-budget-outb?sap-client=110');
define("CRM_WIKA_LOGIN", "https://crm.wika.co.id/ServiceModel/AuthService.svc/Login");
define("CRM_WIKA_INFO", "https://crm.wika.co.id/0/rest/WikaAPI/GetProyekSCMInfo");
define("ARG_TOKEN", "WIKA-ESCM-V2");
