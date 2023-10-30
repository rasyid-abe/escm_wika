<?php

require_once(APPPATH . 'libraries/jqSuitePHP/jqUtils.php');

class MY_Model extends CI_Model {
  
    function __construct(){

      parent::__construct();

    }

	  public function sendEmail($to = "",$title = "",$message = ""){
      //start code hlmifzi
      $config['protocol'] = 'smtp';
      $config['smtp_host'] = '10.4.0.44';
      //$config['smtp_user'] = 'admin@wikamail.id';
      //$config['smtp_crypto'] = "tls";
      $config['smtp_port'] = 25;
      $config['mailtype'] = 'html';
      $config['wordwrap'] = TRUE;
      $config['useragent'] = COMPANY_NAME;
      $config['charset'] = 'utf8';
      $config['crlf'] = "\r\n";
      $config['newline'] = "\r\n";
      //end

      $this->load->library(array('email','parser'));

      $this->email->initialize($config);

      $email_cont = $this->load->view("email/alert","",true);

      $content = trim($email_cont);

      $data['message'] = $message;

      $data['title'] = $title;

      $html = $this->parser->parse_string($content,$data,true);

      $this->email->from('info.scm@wika.co.id', COMPANY_NAME);
      $this->email->to($to); 

      $this->email->subject($title);
      $this->email->message($html);  


      $email = $this->email->send();

      //$this->email->clear();

      if($email){

        $this->setMessage("Success to send email to ".$to."!");

      }

      return $html;

    }
}

?>
