<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
class Sinkron_Catalog_m extends CI_Model {
    
  public function do_sinkron(){

    $this->db->trans_begin();     

    $curl = curl_init();    

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://e-catalogue.wika.co.id/index.php/api/resources_code/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ));
    
    $response = curl_exec($curl);      
    
    $arrays_data = json_decode($response, true);

    if (count($arrays_data) < 1){
        return 'not_found';
    } 

    curl_close($curl);    

    $this->db->truncate('adm_catalogue');

    $dataDetail = [];
    $no = 0;
    
    foreach ($arrays_data as $aa => $v1) {
        $dataDetail[$no]['resources_code_id'] = $v1[$no]['resources_code_id'];
        $dataDetail[$no]['code'] = $v1[$no]['code'];
        $dataDetail[$no]['parent_code'] = $v1[$no]['parent_code'];
        $dataDetail[$no]['material_id'] = $v1[$no]['material_id'];        
        $dataDetail[$no]['material_class'] = $v1[$no]['material_class'];
        $dataDetail[$no]['uoms_id'] = $v1[$no]['uoms_id'];
        $dataDetail[$no]['name'] = $v1[$no]['name'];
        $dataDetail[$no]['unspsc'] = $v1[$no]['unspsc'];
        $dataDetail[$no]['unspsc_name'] = $v1[$no]['unspsc_name'];
        $dataDetail[$no]['description'] = $v1[$no]['description'];
        $dataDetail[$no]['status'] = $v1[$no]['status'];
        $dataDetail[$no]['sts_matgis'] = $v1[$no]['sts_matgis'];
        $dataDetail[$no]['material_ap'] = $v1[$no]['material_ap'];
        $dataDetail[$no]['level'] = $v1[$no]['level'];
        $dataDetail[$no]['image'] = $v1[$no]['image'];
        $dataDetail[$no]['approve_date'] = $v1[$no]['approve_date'];
        $dataDetail[$no]['approve_by'] = $v1[$no]['approve_by'];
        $dataDetail[$no]['created_by'] = $v1[$no]['created_by'];
        $dataDetail[$no]['input_date'] = $v1[$no]['input_date'];
        $dataDetail[$no]['uoms_name'] = $v1[$no]['uoms_name'];
        $dataDetail[$no]['jenis_material'] = $v1[$no]['jenis_material'];
        $dataDetail[$no]['material_code'] = $v1[$no]['material_code'];
        $dataDetail[$no]['material_name'] = $v1[$no]['material_name'];
        $dataDetail[$no]['valuation_class_code'] = $v1[$no]['valuation_class_code'];
        $dataDetail[$no]['valuation_class_name'] = $v1[$no]['valuation_class_name'];
        $dataDetail[$no]['flag'] = '';
        $dataDetail[$no]['sync_date'] = date('Y-m-d h:i:s');
        $no++;                
    }

    if (count($dataDetail) > 0) {
        $detailresult = $this->db->insert_batch('adm_catalogue', $dataDetail);
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
     