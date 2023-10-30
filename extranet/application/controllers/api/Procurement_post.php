<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Procurement_post extends MY_Api {
    function __construct() {
        // Construct the parent class
        parent::__construct();
        // $this->auth();
        $this->load->model(array("Api_m", "Procurementapi_m"));
    }

    public function test_post() {   
        $theCredential = $this->user_data;
        $this->response($theCredential, 200); // OK (200) being the HTTP response code
	}

    public function wikapis_input_post(){
        include ("proc_post/wika_pis.php");
    }

    public function wikapis_input_get(){
        include ("proc_get/wika_pis.php");
    }

    public function kode_nasabah_input_post(){
        include("proc_post/kode_nasabah.php");
    }

    // public function hcis_input_post(){
    //     include ("proc_post/hcis.php");
    // }

    public function nasabah_invoice_post(){
        include ("proc_post/nasabah_invoice.php");
    }
}
