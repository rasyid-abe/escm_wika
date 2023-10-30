<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
class Sinkron_Release_m extends CI_Model {
    
    public function do_sinkron($nomor_po){ 

        $url = "https://fioridev.wika.co.id/ywikamm014/release-po?sap-client=110";     

        $ch = curl_init($url);        
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);    
        curl_setopt($ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($ch, CURLOPT_ENCODING, ''); 
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
        curl_setopt($ch, CURLOPT_HEADER , true );
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET'); 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic ' . base64_encode('WIKA_INT:Initial123'),
            'x-requested-with: XMLHttpRequest',
            'x-xhr-logon: accept="iframe"',
            'x-csrf-token: Fetch'
        ));

        $response = curl_exec($ch);

        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $headerStr = substr($response, 0, $headerSize);
        $bodyStr = substr($response, $headerSize);

        $headers = $this->headersToArray($headerStr);

        curl_close($ch); 

        if (empty($headers['x-csrf-token'])) {
            return 'fail';
        }

        // =========================================== Start POST Field ===========================================  

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "DEVID": "YMMI014",
                "PACKAGEID": "' . strtoupper(md5(uniqid())) .'",
                "COCODE": "A000",
                "PRCTR": "",
                "TIMESTAMP": "' . date('YmdHis') . '",
                "DATA": [
                    {
                        "PO_NUMBER": "' . $nomor_po . '"
                    }
                ]
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic ' . base64_encode('WIKA_INT:Initial123'),
                'x-csrf-token:' . $headers['x-csrf-token'],
                'Cookie:' . $headers['set-cookie'],
                'Content-Type: application/json'
            ),
        ));

        $response_post = curl_exec($curl);

        $arrays_data = json_decode($response_post, true);

        curl_close($curl);

        $this->db->delete('ctr_release_po', array('nomor_po' => $nomor_po));

        $dataDetail = [];
        $no = 0;
        foreach ($arrays_data as $key => $v) {
            $dataDetail[$no]['nomor_po'] = $nomor_po;
            $dataDetail[$no]['type_res'] = $v['TYPE'];
            $dataDetail[$no]['id_interface'] = $v['ID'];
            $dataDetail[$no]['number_res'] = $v['NUMBER'];
            $dataDetail[$no]['message_res'] = $v['MESSAGE'];
            $dataDetail[$no]['log_no'] = $v['LOG_NO'];
            $dataDetail[$no]['log_msg_no'] = $v['LOG_MSG_NO'];
            $dataDetail[$no]['message_v1'] = $v['MESSAGE_V1'];
            $dataDetail[$no]['message_v2'] = $v['MESSAGE_V2'];
            $dataDetail[$no]['message_v3'] = $v['MESSAGE_V3'];
            $dataDetail[$no]['message_v4'] = $v['MESSAGE_V4'];
            $dataDetail[$no]['parameter'] = $v['PARAMETER'];
            $dataDetail[$no]['row_res'] = $v['ROW'];
            $dataDetail[$no]['field'] = $v['FIELD'];
            $dataDetail[$no]['system_res'] = $v['SYSTEM'];
            $dataDetail[$no]['sync_at'] = date('Y-m-d h:i:s');
            $no++;                
        }

        if (count($dataDetail) > 0) {
            $detailresult = $this->db->insert_batch('ctr_release_po', $dataDetail);
        }
           
        if (!$detailresult) {
            return 'fail';
    
        } else {

            $get_message = $this->db->order_by('id_res', 'desc')->get_where('ctr_release_po', array('nomor_po' => $nomor_po), 1)->row_array();
            return $get_message;
        }

        // =========================================== End POST Field ===========================================
    
    }

    function headersToArray($str){
        $headers = array();
        $headersTmpArray = explode( "\r\n" , $str );
        for ( $i = 0 ; $i < count( $headersTmpArray ) ; ++$i )
        {
            // we dont care about the two \r\n lines at the end of the headers
            if ( strlen( $headersTmpArray[$i] ) > 0 )
            {
                // the headers start with HTTP status codes, which do not contain a colon so we can filter them out too
                if ( strpos( $headersTmpArray[$i] , ":" ) )
                {
                    $headerName = substr( $headersTmpArray[$i] , 0 , strpos( $headersTmpArray[$i] , ":" ) );
                    $headerValue = substr( $headersTmpArray[$i] , strpos( $headersTmpArray[$i] , ":" )+1 );
                    $headers[$headerName] = $headerValue;
                }
            }
        }
        return $headers;
    }

}
     