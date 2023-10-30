<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Privy
{
    protected $ci;
    var $datetime;

    public function __construct()
    {
        $this->ci =& get_instance();
        $this->ci->load->config("privy");
        $this->datetime = date("c",strtotime(date('Y-m-d H:i:s')));
    }

    public function signature()
    {
        # code...
    }

    public function Auth()
    {
        # code...
    }
    
    public function UploadDocument()
    {
        # code...

    }

    

}

/* End of file Privy.php */

?>