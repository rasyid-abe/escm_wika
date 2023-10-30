<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pusher extends Telescoope_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->model(array('Administration_m',"Procpr_m","Procrfq_m","Contract_m","Vendor_m"));
		$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');
		$userdata = $this->Administration_m->getLogin();
		$this->data['userdata'] = (!empty($userdata)) ? $userdata : array();
		$sess = $this->session->all_userdata();

        $this->ci = &get_instance();
        $this->ci->load->config("pusher");
	}

	public function sendMessage(){
        $post = $this->input->post();
        if(empty($post)){
            return;
        }
        
        $options = array(
            'cluster' => $this->config->item('PUSHER_cluster'),
            'useTLS' => false,
        );
        
        $pusher = new Pusher\Pusher(
            $this->config->item('PUSHER_key'),
            $this->config->item('PUSHER_secret'),
            $this->config->item('PUSHER_app_id'),
            $options
        );
        $data['message'] = $post['message'];
        $pusher->trigger('my-channel', 'my-event', $data);
	}   
}