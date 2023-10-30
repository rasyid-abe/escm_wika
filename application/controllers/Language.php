<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Language extends Telescoope_Controller {

	public function setLang(){
        $lang = $this->input->get('lang');
		if($lang === 'indonesian' || $lang === 'english'){
			$this->session->set_userdata(array(
                'site_lang' => $lang,
            ));
            header('location:'.$_SERVER['HTTP_REFERER']);
		}else{
            http_response_code(403);
            echo 'Forbidden';
        }

	}

}