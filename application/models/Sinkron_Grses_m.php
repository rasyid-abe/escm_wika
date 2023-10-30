<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
class Sinkron_Grses_m extends CI_Model {
    
  public function do_sinkron(){

    $this->db->trans_begin();     

    $curl = curl_init();    

    $url = "https://fioridev.wika.co.id/ywikamm009/goods-movement-outb?sap-client=110"; 
    
    // Attach encoded JSON string to the POST fields
    
    $ch = curl_init($url);        
    curl_setopt($ch, CURLOPT_MAXREDIRS, 10);    
    curl_setopt($ch, CURLOPT_TIMEOUT, 0);
    curl_setopt($ch, CURLOPT_ENCODING, ''); 
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
    curl_setopt($ch, CURLOPT_POSTFIELDS, '{
      "IV_EBELN": "",
      "IW_CPUDT_RANGE": {
          "CPUDT_LOW": "2023-03-17",
          "CPUTM_LOW": "00:00:00",
          "CPUDT_HIGH": "2023-03-17",
          "CPUTM_HIGH": "23:59:59"
      }
    }'); 
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Authorization: Basic ' . base64_encode('WIKA_INT:Initial123'),
      'x-requested-with: XMLHttpRequest',
      'x-xhr-logon: accept="iframe"'
    ));
    
    $response = curl_exec($ch);      
    
    $arrays_data = json_decode($response, true);

    if (count($arrays_data["DATA"]) < 1){
        return 'not_found';
    } 

    curl_close($ch);    

    $this->db->delete('ctr_gr_ses', array('status' => 1));

    $dataDetail = [];
    $no = 0;
    foreach ($arrays_data["DATA"] as $aa => $v1) {
        $dataDetail[$no]['devid'] = $arrays_data['DEVID'];
        $dataDetail[$no]['packageid'] = $arrays_data['PACKAGEID'];
        $dataDetail[$no]['cocode'] = $arrays_data['COCODE'];
        $dataDetail[$no]['prctr'] = $arrays_data['PRCTR'];
        $dataDetail[$no]['timestamp'] = $arrays_data['TIMESTAMP'];
        $dataDetail[$no]['mat_doc'] = $v1['MAT_DOC'];
        $dataDetail[$no]['doc_year'] = $v1['DOC_YEAR'];
        $dataDetail[$no]['doc_date'] = $v1['DOC_DATE'];
        $dataDetail[$no]['psting_date'] = $v1['PSTNG_DATE'];
        $dataDetail[$no]['matdoc_itm'] = $v1['MATDOC_ITM'];
        $dataDetail[$no]['ref_doc'] = $v1['REF_DOC'];
        $dataDetail[$no]['material'] = $v1['MATERIAL'];
        $dataDetail[$no]['plant'] = $v1['PLANT'];
        $dataDetail[$no]['stge_loc'] = $v1['STGE_LOC'];
        $dataDetail[$no]['move_type'] = $v1['MOVE_TYPE'];
        $dataDetail[$no]['quantity'] = $v1['QUANTITY'];
        $dataDetail[$no]['entry_uom'] = $v1['ENTRY_UOM'];
        $dataDetail[$no]['po_number'] = $v1['PO_NUMBER'];
        $dataDetail[$no]['po_item'] = $v1['PO_ITEM'];
        $dataDetail[$no]['sync_at'] = date('Y-m-d h:i:s');
        $dataDetail[$no]['status'] = 1;
        $no++;                
    }

    if (count($dataDetail) > 0) {
        $detailresult = $this->db->insert_batch('ctr_gr_ses', $dataDetail);
    }

    if ($this->db->trans_status() == FALSE) {
      $this->db->trans_rollback();
      return 'fail';

    } else {
      $this->db->trans_commit();
      return 'success';
    }
    
  }

}
     