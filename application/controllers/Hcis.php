<?php

use phpDocumentor\Reflection\PseudoTypes\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class Hcis extends CI_Controller {

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
        
    }

    public function send_message_wa($rfqNo,$privyId,$fullname = 'ADIP', $numberTo = '081316448288')
    {
       

    }

    public function get_data($nip)
    {
        
        # code...
       $result = array();
       $step = 1;
       //$this->db->where('nip', $);
       //$employee = $this->db->get('response_hcis')->result_array();

       $result = $this->hcis($nip);

       if(count($result->data) > 0 )
       {
           $result_data = $result->data[0];
           //update table
           //$dataUpdate['nip'] = $result_data->nip;
           $dataUpdate['nm_peg'] = $result_data->nm_peg;
           $dataUpdate['nm_jabatan'] = $result_data->nm_jabatan;
           $dataUpdate['nm_departemen'] = $result_data->nm_departemen;
           $dataUpdate['posisi'] = $result_data->posisi;
           $dataUpdate['no_spk'] = $result_data->no_spk;
           $dataUpdate['nama_proyek'] = $result_data->nama_proyek;
           $dataUpdate['kd_dep'] = $result_data->kd_dep;
           $dataUpdate['nm_fungsi_bidang'] = $result_data->nm_fungsi_bidang;

           
            
           $this->db->where('nip', $nip);
            
           $this->db->update('response_hcis', $dataUpdate);

           $db_error = $this->db->error();
           if (!empty($db_error)) {
               $step = 0;
           }
   
           

       }

      if($step == 1)
      {
          echo json_encode(array("code"=>200));
      } else {
        echo json_encode(array("code"=>404));
      }

        
       
       

    }


    public function syncAll()
    {
        
        # code...
       $result = array();
       $step = 1;
       //$this->db->where('nip', $);
       //$employee = $this->db->get('response_hcis')->result_array();

       $result = $this->hcis();

       if(count($result->data) > 0 )
       {

            foreach ($result->data as $key => $value) {
                # code...
                //update table
                
                $dataUpdate['nm_peg'] = $value->nm_peg;
                $dataUpdate['nm_jabatan'] = $value->nm_jabatan;
                $dataUpdate['nm_departemen'] = $value->nm_departemen;
                $dataUpdate['posisi'] = $value->posisi;
                $dataUpdate['no_spk'] = $value->no_spk;
                $dataUpdate['nama_proyek'] = $value->nama_proyek;
                $dataUpdate['kd_dep'] = $value->kd_dep;
                $dataUpdate['nm_fungsi_bidang'] = $value->nm_fungsi_bidang;
     
                $this->db->where('nip', $value->nip);
                 
                $this->db->update('response_hcis', $dataUpdate);
     
            }
          
           $db_error = $this->db->error();
           if (!empty($db_error)) {
               $step = 0;
           }
   
        
       }

      if($step == 1)
      {
          echo json_encode(array("code"=>200));
      } else {
        echo json_encode(array("code"=>404));
      }

        
       
       

    }

    private function GetAdmHcis($var = null)
    {
        # code...
    }

    private function hcis ($nip = "")
    {
        $curl = curl_init();

        $url = $nip != "" ? 'https://hcis.wika.co.id/services/rest/?format=json&method=MasterDataPegawai&pin=D9u84S&is_active=1&nip='.$nip : 'https://hcis.wika.co.id/services/rest/?format=json&method=MasterDataPegawai&pin=D9u84S&is_active=1';
        curl_setopt_array($curl, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $res = json_decode($response);
        

        return $res;
       
    }

   

}

/* End of file PrivyTest.php */


?>