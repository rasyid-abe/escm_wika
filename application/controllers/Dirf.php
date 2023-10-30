<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dir extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));
        $this->load->config('privy');
        $this->load->config('whatsapp');


    }


    public function index()
    {
       $directory = dirname(__DIR__,3) . '/sap/PR';
       $file = $this->scan_dir($directory);
       print_r($file);

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





}

/* End of file PrivyTest.php */


?>
