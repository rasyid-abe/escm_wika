<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Createpdf extends Telescoope_Controller {


	public function __construct(){

        // Call the Model constructor
		parent::__construct();
		$this->load->model(array("Procedure2_m","Procedure3_m","Contract_m","Procrfq_m","Administration_m","Comment_m","Administration_m","Workflow_m","Addendum_m","Procplan_m","Procpr_m"));
    }

    public function index(){
        $this->load->helper('pdf_helper');

        // $param = $this->input->post('param');
        // $param = 'kontrak';

        // // $id = $this->input->post('id');
        // $id = 65;

        // switch ($param) {
        //     case 'kontrak':
        //     $header= $this->db->where('contract_id',$id)->get('ctr_contract_header')->row_array();
            
        //     $item = $this->db->where('contract_id',$id)->get('ctr_contract_item')->result_array();
                
        //     $data['data'] = $this->db->where('contract_id',$id)->where('is_final',1)->get('ctr_contract_surat')->row()->konten_surat;
                
        //     $data['data'] .= '<br pagebreak="true"/>';
        //     $data['data'] .= 'Contract Number : '.$header['contract_number'];
        //     $data['data'] .= '<br/>';
        //     $data['data'] .= 'PTM Number : '.$header['ptm_number'];
        //     $data['data'] .= '<br/>';
        //     $data['data'] .= 'Vendor name: '.$header['vendor_name'];
        //     $data['data'] .= '<br/>';
        //     $data['data'] .= 'Vendor id: '.$header['vendor_id'];
        //     $data['data'] .= '<br/>'; 
        //     $data['data'] .= '<br/>'; 
        //     $data['data'] .= '<br/>'; 
        //     $data['data'] .= '<table class="table table-bordered">';
        //     $data['data'] .= '<thead> <tr> <th>Item Code</th> <th>Short Desc</th> <th>Long Desc</th> <th>Price</th> <th>Qty</th> <th>Min Qty</th> <th>Max Qty</th> <th>UOM</th> <th>PPN</th> <th>PPH</th> </tr> </thead>';
        //     $data['data'] .= '<tbody>';
        //     foreach ($item as $key => $value) {
        //         $data['data'] .= "<tr><td>".$value['item_code']."</td> <td>".$value['short_description']."</td> <td>".$value['long_description']."</td> <td>".$value['price']."</td> <td>".$value['qty']."</td> <td>".$value['min_qty']."</td> <td>".$value['max_qty']."</td> <td>".$value['uom']."</td> <td>".$value['ppn']."</td> <td>". $value['pph'] ."</td> </tr>";
        //     }
        //     $data['data'] .= '</tbody> </table>';

        //         break;
            
        //     default:
        //         # code...
        //         break;
        // }


        $this->load->view('pdfreport', $data);
    }

    public function open_qr($ptm_number){

        $last_comment = $this->Comment_m->getContract($ptm_number,"","")->row_array();
        $comment_id = $last_comment['comment_id'];
        $ptm_number = $last_comment['tender_id'];

        $data['contract'] = $last_comment;

        $this->load->view('arrow_qr_v',$data);
    }

    public function data_vendor($ptm_number){

        $data['vendor'] = $this->Procrfq_m->getVendorQuoMainRFQ("",$ptm_number)->row_array();

        print_r($data);
        exit;
    }


    public function data_vendor_pemenang($ptm_number){
        
        $vendor_id = $this->db->query("select * from vnd_header vnd, prc_tender_vendor_status ptvs
        where ptvs.ptm_number = '".$ptm_number."' and ptvs.pvs_is_winner =1
        and ptvs.pvs_vendor_code = vnd.vendor_id ")->result_array();

        $vendor_id = $vendor_id[0]['vendor_id'];

        $data = array(

            'jumlah' =>1,
            'header'=> array(),
            'query'=> array(),
            'alamat'=> array(),
            'tipe'=> array(),
            'akta'=> array(),
            'izin_lain'=> array(),
            'agent_importir'=> array(),
            'board'=> array(),
            'bank'=> array(),
            'financial'=> array(),
            'barang'=> array(),
            'sdm'=> array(),
            'sertifikasi'=> array(),
            'fasilitas'=> array(),
            'pengalaman'=> array(),
            'tambahan'=> array(),
            'dokumen'=> array(),

        );

        $data['query'] = $this->db->where('vendor_id', $vendor_id)->get('vnd_header')->row_array();

        $url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
        $url_doc = "https://vendor.pengadaan.com/Download";
        $data['url_ws'] = $url_ws;
        $data['url_doc'] = $url_doc;

        $vendor = json_decode(file_get_contents($url_ws."/vndheader.json?token=123456&act=1&vndHeader.vendorId=".$vendor_id), true);
        if(!empty($vendor)){
        $data['header'] = (isset($vendor["listVndHeader"][0])) ? $vendor["listVndHeader"][0] : array();
        }

        $alamat = json_decode(file_get_contents($url_ws."/vndaddress.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($alamat)){
        $data['alamat'] = $alamat["listVndAddress"];
        //print_r($data['alamat']);
        }

        $tipe = json_decode(file_get_contents($url_ws."/vndcompanytype.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($tipe)){
        $tipe = $tipe["listVndCompanyType"];
        $mytipe = array();
        if(!empty($tipe)){
        foreach ($tipe as $key => $value) {
            $mytipe[] = array("company_type"=>$value['id']['companyType']);
        }
        }
        $data['tipe'] = $mytipe;
        }

        $akta = json_decode(file_get_contents($url_ws."/vndakta.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($akta)){
            $data['akta'] = $akta["listVndAkta"];
        }

        $ijin = json_decode(file_get_contents($url_ws."/vndijin.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($ijin)){
            $data['izin_lain'] = $ijin["listVndIjin"];
        }

        $agent = json_decode(file_get_contents($url_ws."/vndagent.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($agent)){
            $data['agent_importir'] = $agent["listVndAgent"];
        }

        $board = json_decode(file_get_contents($url_ws."/vndboard.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($board)){
            $data['board'] = $board["listVndBoard"];
        }

        $bank = json_decode(file_get_contents($url_ws."/vndbank.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($bank)){
            $data['bank'] = $bank["listVndBank"];
        }

        $financial = json_decode(file_get_contents($url_ws."/vndfinrpt.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($financial)){
            $data['financial'] = $financial["listVndFinRpt"];
        }

        $data['barang'] = $this->db->query("select distinct group_type as catalog_type, product_name, product_description, brand, vnd_product.source , vnd_product.type from vnd_product left join com_group on product_code = group_code where vendor_id = ".$vendor_id)->result_array();

        $sdm = json_decode(file_get_contents($url_ws."/vndsdm.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($sdm)){
            $data['sdm'] = $sdm["listVndSdm"];
        }

        $sertifikasi = json_decode(file_get_contents($url_ws."/vndcert.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($sertifikasi)){
            $data['sertifikasi'] = $sertifikasi["listVndCert"];
        }

        $fasilitas = json_decode(file_get_contents($url_ws."/vndequip.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($fasilitas)){
            $data['fasilitas'] = $fasilitas["listVndEquip"];
        }

        $pengalaman = json_decode(file_get_contents($url_ws."/vndcv.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($pengalaman)){
            $data['pengalaman'] = $pengalaman["listVndCv"];
        }

        $tambahan = json_decode(file_get_contents($url_ws."/vndadd.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($tambahan)){
            $data['tambahan'] = $tambahan["listVndAdd"];
        }

        $dokumen = json_decode(file_get_contents($url_ws."/vndsuppdoc.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
        if(!empty($dokumen)){
            $data['dokumen'] = $dokumen["listVndSuppDoc"];
        }

        $mydata = array();

        foreach ($data as $key => $value) {
        $k = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key));
        $mydata[$k] = $value;
        if(is_array($value) && !empty($value)){
            foreach ($value as $key2 => $value2) {
            $k2 = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key2));
            $mydata[$k][$k2] = $value2;
            if(is_array($value2) && !empty($value2)){
                foreach ($value2 as $key3 => $value3) {
                $k3 = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key3));
                $mydata[$k][$k2][$k3] = $value3;
                if(is_array($value3) && !empty($value3)){
                    foreach ($value3 as $key4 => $value4) {
                    $k4 = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key4));
                    $mydata[$k][$k2][$k3][$k4] = $value4;
                    }
                }
                }
            }
            }
        }
        }


        $mydata['doc_pq'] = $this->Vendor_m->getDocPqDetail("", $vendor_id, "2")->result_array();
        $this->load->view('vendor/vendor_pemenang.php',$mydata);
    }

}
