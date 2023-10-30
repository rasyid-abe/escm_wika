<?php


defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH . '/core/Base_Api_Controller.php';
require_once APPPATH . '/libraries/REST_Controller.php';
require_once APPPATH . '/libraries/JWT.php';
require_once APPPATH . '/libraries/BeforeValidException.php';
require_once APPPATH . '/libraries/ExpiredException.php';
require_once APPPATH . '/libraries/SignatureInvalidException.php';

class Wzone extends Base_Api_Controller {
    var $appSecret;
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Administration_m',"Procpr_m","Procrfq_m","Contract_m","Vendor_m","Dashboard_m"));

        $this->load->config('wzone');


    }


    public function auth_get()
    {

        $token = $this->input->get('token');
        $redirectBack = $this->input->get('redirect_back');
        
        $res = $this->check_app_token($token);

       

        if(isset($res->responseMsg))
        {
            if($res->responseMsg == "Success.")
            {
                $nip = $res->responseData->nip;

                $this->db->where('nip', $nip);
                $userEmp = $this->db->get('vw_user_employee')->row_array();
                if(count($userEmp) > 0)
                {
                    $api_new = $this->Administration_m->loginApi("admin", "wika123");
                    $cookie_name = "e_catalog_api";
                    setcookie($cookie_name, $api_new['data']['token'], time() + (86400 * 30), "/");

                    $first_pos = $this->db->where("employee_id",$userEmp['employeeid'])->order_by('is_main_job','desc')->get("vw_adm_pos")->row()->pos_id;
					$this->session->set_userdata(do_hash("ROLE"),$first_pos);
					$this->session->set_userdata(do_hash(SESSION_PREFIX),$userEmp['user_id']);

                    redirect(site_url('home'));
                } else {
                    
                    redirect($redirectBack);
                }
                print_r($res);
                exit;
            } else {
                redirect($redirectBack);
            }
        } else {
            
        }
        
        $this->response([
            'status' => true,
            'data' => []
        ], REST_Controller::HTTP_OK);
    }

    private function check_app_token($token)
    {
        # code...
        $app_secret = $this->config->item("APP_SECRET");
        $url = $this->config->item("URL")."/app/sso/valid?token=".$token."&app_secret=".$app_secret;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
            )
        ));


        $response = curl_exec($curl);

        curl_close($curl);
        $res = json_decode($response);

        return $res;

    }


    public function ftp_get()
    {
        // connect and login to FTP server
            $ftp_server = "103.23.21.233";
            $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
            $login = ftp_login($ftp_conn, "escm_ftp", " 0Wcfx5^76");

            $contents = ftp_nlist($ftp_conn, ".");

            var_dump($contents);

    }

    

}

/* End of file PrivyTest.php */


?>