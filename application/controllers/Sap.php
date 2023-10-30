<?php

    use phpDocumentor\Reflection\PseudoTypes\False_;

    defined('BASEPATH') OR exit('No direct script access allowed');

    class Sap extends CI_Controller {

        public function __construct()
        {
            parent::__construct();
            //Do your magic here
            $this->load->model(array("Procrfq_m", "Vendor_m", "Procedure_m", "Comment_m", "Procpanitia_m", "Contract_m"));
            $this->load->config('privy');
            $this->load->config('whatsapp');


        }

        public function generate_po($ptm_number)
        {
            $tender = $this->Procrfq_m->getMonitorRFQ($ptm_number)->row_array();
            $response['status'] = 'SUCCESS';
            $response['message'] = 'Generate Berhasil';

            //generate PO TEMPORARY
            if($tender['is_sap'] == 1)
            {
                $idko = "";
                $oop = $this->db->get_where('prc_tender_item', ['ptm_number' => $ptm_number])->row_array();
                $aa = "
                    cci.tit_code,
                    cci.tit_quantity,
                    cci.tit_unit,
                    (cci.tit_quantity * cci.tit_price) ::INTEGER as sub_total,
                ";
                $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";

                if ($oop['pr_acc_assig'] == "Q" && $oop['pr_cat_tech'] == 0) {
                    $idko = "B";              
                    $aa = "
                        cci.item_code,
                        cci.qty,
                        cci.uom,
                        cci.sub_total::INTEGER as sub_total,
                    ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                } 

                if ($oop['pr_acc_assig'] == "X" && $oop['pr_cat_tech'] == 5) {
                    $idko = "B";              
                    $aa = "
                        cci.item_code,
                        cci.qty,
                        cci.uom,
                        cci.sub_total::INTEGER as sub_total,
                    ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                } 

                if ($oop['pr_acc_assig'] == "N" && $oop['pr_cat_tech'] == 9) {
                    $idko = "J";
                    $aa = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                    $bb = "
                        cci.item_code,
                        cci.qty,
                        cci.uom,
                        cci.sub_total::INTEGER as sub_total,
                    ";
                } 

                if ($oop['pr_acc_assig'] == "U" && $oop['pr_cat_tech'] == 0) {
                    $idko = "A";
                    $aa = "
                        cci.item_code,
                        cci.qty,
                        cci.uom,
                        cci.sub_total::INTEGER as sub_total,
                    ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                } 

                $sql = "
                    select
                    cch.ctr_doc_type,
                    vnd.nasabah_code,
                    concat(to_char(cch.start_date, 'YYYY'), '.', to_char(cch.start_date, 'MM'), '.', to_char(cch.start_date, 'DD')) as start_date,
                    admi.code,
                    '' as lokasi,
                    cci.pr_retention,
                    cch.ctr_down_payment,
                    concat(to_char(cch.ctr_down_payment_date, 'YYYY'), '.', to_char(cch.ctr_down_payment_date, 'MM'), '.', to_char(cch.ctr_down_payment_date, 'DD')) as ctr_down_payment_date,
                    cci.item_po,
                    $aa
                    cci.pr_number_sap,
                    cci.pr_item_sap,
                    cch.contract_number,
                    concat(to_char(cch.ctr_delivery_date, 'YYYY'), '.', to_char(cch.ctr_delivery_date, 'MM'), '.', to_char(cch.ctr_delivery_date, 'DD')) as ctr_delivery_date,
                    cci.no_asset,
                    cci.sub_number,
                    cci.tax_code,
                    $bb
                    cch.ctr_scope,
                    concat(concat(to_char(cch.start_date, 'YYYY'),'.',to_char(cch.start_date, 'MM'),'.',to_char(cch.start_date, 'DD')),' - ',concat(to_char(cch.end_date, 'YYYY'),'.',to_char(cch.end_date, 'MM'),'.',to_char(cch.end_date, 'DD'))) as rangedate
                    from
                    ctr_contract_header cch
                    join ctr_contract_item cci on cch.contract_id = cci.contract_id              
                    left join vnd_header vnd on cch.vendor_id = vnd.vendor_id
                    left join adm_incoterm admi on cci.incoterm = admi.description
                    where
                    cch.is_sap = 1
                        and cch.contract_id = $contract_id
                ";

                $data = $this->db->query($sql)->result_array();

                $newl = "\n";
                $body = "";
                foreach ($data as $k => $v) {
                    $body .= $k+1 .'|'. implode("|",$v) . $newl;
                }

                $todaydate = date('Ymd');
                $time_utc=mktime(date('G'),date('i'),date('s'));
                $NowisTime=date('Gis',$time_utc);

                $hex = bin2hex(openssl_random_pseudo_bytes(16));

                $hea2 = "YMMI005".$idko."|".strtoupper($hex)."|A000||".$todaydate.$NowisTime;
                $head = 'DOC_NO|DOC_TYPE|VENDOR|DOC_DATE|INCOTERMS1|INCOTERMS2|RETENTION_PERCENTAGE|DOWNPAY_PERCENT|DOWNPAY_DUEDATE|PO_ITEM|MATERIAL|QUANTITY|PO_UNIT|NET_PRICE|PREQ_NO|PREQ_ITEM|VEND_MAT|DELIVERY_DATE|ASSET_NO|SUB_NUMBER|TAX_CODE|SERVICE|SERVICE_QTY|BASE_UOM|GR_PRICE|RUANG_LINGKUP|JANGKA_WAKTU';

                $directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Inbound';
                
                $path = 'uploads/PO';
                if (!is_dir($path))
                    mkdir($path, 0777, true);

                $filename = 'YMMI005'.$idko.'_'.$todaydate.$NowisTime.'.txt';
                $output = $hea2.$newl.$head.$newl.$body;
                file_put_contents($path.'/'.$filename, $output);

                copy($path.'/'.$filename, $directory.'/'.$filename);

            }

            echo json_encode($response);

        }

        public function Report_po($ptm_number)
        {
            # code...
            $idko = "";
            $oop = $this->db->get_where('prc_tender_item', ['ptm_number' => $ptm_number])->row_array();
            $aa = "
                cci.tit_code,
                cci.tit_quantity,
                cci.tit_unit,
                (cci.tit_quantity * cci.tit_price) ::INTEGER as sub_total,
            ";
            $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";

            if ($oop['tit_acc_assig'] == "Q" && $oop['tit_cat_tech'] == 0) {
                $idko = "B";              
                $aa = "
                    cci.tit_code,
                    cci.tit_quantity,
                    cci.tit_unit,
                    (cci.tit_quantity * cci.tit_price) as sub_total,
                ";
                $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
            }
            
            if ($oop['tit_acc_assig'] == "X" && $oop['tit_cat_tech'] == 5) {
                $idko = "B";              
                $aa = "
                    cci.tit_code,
                    cci.tit_quantity,
                    cci.tit_unit,
                    (cci.tit_quantity * cci.tit_price) as sub_total,
                ";
                $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
            } 

            if ($oop['tit_acc_assig'] == "P" && $oop['tit_cat_tech'] == 0) {
                $idko = "B";              
                $aa = "
                    cci.tit_code,
                    cci.tit_quantity,
                    cci.tit_unit,
                    (cci.tit_quantity * cci.tit_price) as sub_total,
                ";
                $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
            }

            if ($oop['tit_acc_assig'] == "N" && $oop['tit_cat_tech'] == 9) {
                $idko = "J";
                $aa = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                $bb = "
                    cci.tit_code,
                    cci.tit_quantity,
                    cci.tit_unit,
                    (cci.tit_quantity * cci.tit_price) as sub_total,
                ";
            } 

            if ($oop['tit_acc_assig'] == "U" && $oop['tit_cat_tech'] == 0) {
                $idko = "A";
                $aa = "
                    cci.tit_code,
                    cci.tit_quantity,
                    cci.tit_unit,
                    (cci.tit_quantity * cci.tit_price) as sub_total,
                ";
                $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
            }

            $sql = "
            select
            vnd.*,
                cch.*,
                $aa
                cci.tit_pr_number,
                cci.tit_pr_item,
                cch.ctr_po_number,
                cci.tit_no_asset,
                cci.tit_sub_number,
                $bb
                cci.tit_tax_code,
                cci.tit_description,
                cci.tit_price

            from
                prc_tender_main cch
                left join prc_tender_item cci on cch.ptm_number = cci.ptm_number
                left join adm_incoterm admi on cci.tit_incoterm = admi.description
                left join (select ptm_number,ptv_vendor_code vendor_id from vw_prc_evaluation where ptm_number = '".$ptm_number."' order by total desc limit 1) ptw on cch.ptm_number = ptw.ptm_number
                left join vnd_header vnd on ptw.vendor_id = vnd.vendor_id
            where
                cch.ptm_number = '$ptm_number'
            ";

            $report_po = $this->db->query($sql)->result_array();
           
            $data['report'] = $report_po[0];
            
            $this->load->view('procurement/doc_cetak/pdf_report_po', $data);
            
            //$view = "procurement/doc_cetak/pdf_report_po";
            $this->load->view($view,$data);
            //$this->template($view,"Generate PDF BAKP",$data);
            
            
            //$html = $this->output->get_output();
           
            // $this->load->helper('download');

            // $dompdf= new Dompdf\Dompdf();
            // $dompdf->set_paper('a4');
            // $dompdf->set_option('isHtml5ParserEnabled', true);
            // $dompdf->set_option('isRemoteEnabled', true);
            // $dompdf->set_option("isPhpEnabled", true);
            // $dompdf->load_html($html);
            // $dompdf->render();
            // // //$dompdf->stream("BAKP-".date('YmdHis').'-'.$rfq_id.'.pdf');
            // $filename = "REPORT_PO-".date('YmdHis').'-'.$ptm_number.'.pdf';
            // $output = $dompdf->output();
            // // //file_put_contents('uploads/'.$filename, $output);
            // force_download($filename, $output);
            //print_r($html);
        }

        public function export_po_txt($ptm_number)
        {
            # code...
            $this->load->helper('download');
                $idko = "";
                $oop = $this->db->get_where('prc_tender_item', ['ptm_number' => $ptm_number])->row_array();
                $aa = "
                    cci.tit_code,
                    cci.tit_quantity,
                    cci.tit_unit,
                    (cci.tit_quantity * cci.tit_price) ::INTEGER as sub_total,
                ";
                $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";

                if ($oop['tit_acc_assig'] == "Q" && $oop['tit_cat_tech'] == 0) {
                    $idko = "B";              
                    $aa = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (cci.tit_quantity * cci.tit_price) as sub_total,
                    ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                }
                
                if ($oop['tit_acc_assig'] == "X" && $oop['tit_cat_tech'] == 5) {
                    $idko = "B";              
                    $aa = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (cci.tit_quantity * cci.tit_price) as sub_total,
                    ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                } 

                if ($oop['tit_acc_assig'] == "P" && $oop['tit_cat_tech'] == 0) {
                    $idko = "B";              
                    $aa = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (cci.tit_quantity * cci.tit_price) as sub_total,
                    ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                }

                if ($oop['tit_acc_assig'] == "N" && $oop['tit_cat_tech'] == 9) {
                    $idko = "J";
                    $aa = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                    $bb = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (cci.tit_quantity * cci.tit_price) as sub_total,
                    ";
                } 

                if ($oop['tit_acc_assig'] == "U" && $oop['tit_cat_tech'] == 0) {
                    $idko = "A";
                    $aa = "
                        cci.tit_code,
                        cci.tit_quantity,
                        cci.tit_unit,
                        (cci.tit_quantity * cci.tit_price) as sub_total,
                    ";
                    $bb = "'' as service, '' as quantity, '' as uoms, '' as prices,";
                }

                $sql = "
                select
                    cch.ptm_doc_type_sap,
                    vnd.nasabah_code,
                    concat(to_char(cch.ptm_created_date, 'YYYY'), '.', to_char(cch.ptm_created_date, 'MM'), '.', to_char(cch.ptm_created_date, 'DD')) as start_date,
                    admi.code,
                    cci.tit_lokasi_incoterm,
                    cci.tit_retention,
                    cch.ctr_down_payment,
                    concat(to_char(cch.ctr_down_payment_date, 'YYYY'), '.', to_char(cch.ctr_down_payment_date, 'MM'), '.', to_char(cch.ctr_down_payment_date, 'DD')) ctr_down_payment_date,
                    (ROW_NUMBER () OVER (ORDER BY cci.tit_id) * 10 ) tit_item_po,
                    $aa
                    cci.tit_pr_number,
                    cci.tit_pr_item,
                    '' contract_number,
                    concat(to_char(cch.ctr_delivery_date, 'YYYY'), '.', to_char(cch.ctr_delivery_date, 'MM'), '.', to_char(cch.ctr_delivery_date, 'DD')) as ptm_created_date,
                    cci.tit_no_asset,
                    cci.tit_sub_number,
                    cci.tit_tax_code,
                    $bb
                    cch.ctr_scope,
                    concat(concat(to_char(cch.ctr_start_date, 'YYYY'),'.',to_char(cch.ctr_start_date, 'MM'),'.',to_char(cch.ctr_start_date, 'DD')),' - ',concat(to_char(cch.ctr_end_date, 'YYYY'),'.',to_char(cch.ctr_end_date, 'MM'),'.',to_char(cch.ctr_end_date, 'DD'))) as rangedate
                from
                    prc_tender_main cch
                    left join prc_tender_item cci on cch.ptm_number = cci.ptm_number
                    left join adm_incoterm admi on cci.tit_incoterm = admi.description
                    left join (select ptm_number,ptv_vendor_code vendor_id from vw_prc_evaluation where ptm_number = '".$ptm_number."' order by total desc limit 1) ptw on cch.ptm_number = ptw.ptm_number
                    left join vnd_header vnd on ptw.vendor_id = vnd.vendor_id
                where
                    cch.ptm_number = '$ptm_number'
                ";

                $data = $this->db->query($sql)->result_array();

                $newl = "\n";
                $body = "";
                foreach ($data as $k => $v) {
                    $body .= $k+1 .'|'. implode("|",$v) . $newl;
                }

                $todaydate = date('Ymd');
                $time_utc=mktime(date('G'),date('i'),date('s'));
                $NowisTime=date('Gis',$time_utc);

                $hex = bin2hex(openssl_random_pseudo_bytes(16));

                $hea2 = "YMMI005".$idko."|".strtoupper($hex)."|A000||".$todaydate.$NowisTime;
                $head = 'DOC_NO|DOC_TYPE|VENDOR|DOC_DATE|INCOTERMS1|INCOTERMS2|RETENTION_PERCENTAGE|DOWNPAY_PERCENT|DOWNPAY_DUEDATE|PO_ITEM|MATERIAL|QUANTITY|PO_UNIT|NET_PRICE|PREQ_NO|PREQ_ITEM|VEND_MAT|DELIVERY_DATE|ASSET_NO|SUB_NUMBER|TAX_CODE|SERVICE|SERVICE_QTY|BASE_UOM|GR_PRICE|RUANG_LINGKUP|JANGKA_WAKTU';

                $directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Inbound';
                
                $path = 'uploads/PO';
                if (!is_dir($path))
                    mkdir($path, 0777, true);

                $filename = 'YMMI005'.$idko.'_'.$todaydate.$NowisTime.'.txt';
                $output = $hea2.$newl.$head.$newl.$body;
                //file_put_contents($path.'/'.$filename, $output);
                //print_r(file_put_contents($path.'/'.$filename, $output));
                // exit;
                //copy($path.'/'.$filename, $directory.'/'.$filename);

                force_download($filename, $output);
            
        }
        
        public function update_po_number($filename = "")
        {
            $response['status'] = 'SUCCESS';
            $response['message'] = 'Update PO NUMBER SAP Berhasil';

            # code...
            $filename = $filename;
            $directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Inbound/Success/';            
            $poNumber = "";

            if(!file_exists($directory.$filename))
            {
                $response['status'] = 'ERROR';
                $response['message'] = 'FIle Atau Folder tidak ada !';
                echo json_encode($response);
                exit;
            }
            $data = file_get_contents($directory.$filename);

            if (!isset($data)) { 

                $directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Inbound/Error/';
                $data = file_get_contents($directory.$filename);

            }
            $countToRemove = 18;

            $rows = explode("|",$data);
            
            $countColumn = 14;

            for ($i=0; $i <= $countToRemove; $i++) { 
                # code...
                unset($rows[$i]);
            }

            $rows = array_values($rows);

            for ($i=0; $i < $countColumn; $i++) { 
                # code...
                if($i == 9 && $rows[$i] != "")
                {
                    $poNumber = $rows[$i];
                }
            }

            if($poNumber !="")
            {
                $update['ctr_po_number'] = $poNumber;
                $this->db->where('ctr_generate_text_number', $filename);
                $this->db->update('prc_tender_main', $update);
                
                $this->db->where('ctr_generate_text_number', $filename);
                $this->db->update('ctr_contract_header', $update);

                
                $response['status'] = 'SUCCESS';
                $response['message'] = 'Generate Berhasil';

                echo json_encode($response);

            } else {
                $response['status'] = 'ERROR';
                $response['message'] = 'PO NUMBER TIDAK TERUPDATE !';
                echo json_encode($response);

            }
        }

        public function update_po_number_syn($filename = "")
        {
            $response['status'] = 'SUCCESS';
            $response['message'] = 'Update PO NUMBER SAP Berhasil';

            # code...
            $filename = $filename;
            $directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Inbound/Success/';            
            $poNumber = "";

            if(!file_exists($directory.$filename))
            {
                $response['status'] = 'ERROR';
                $response['message'] = 'FIle Atau Folder tidak ada !';
                echo json_encode($response);
                exit;
            }
            $data = file_get_contents($directory.$filename);

            if (!isset($data)) { 

                $directory = dirname(__DIR__,4) . '/FTP/SAPInterface/S4HANADEV/Inbound/Error/';
                $data = file_get_contents($directory.$filename);

            }
            $countToRemove = 18;

            $rows = explode("|",$data);
            
            $countColumn = 14;

            for ($i=0; $i <= $countToRemove; $i++) { 
                # code...
                unset($rows[$i]);
            }

            $rows = array_values($rows);

            for ($i=0; $i < $countColumn; $i++) { 
                # code...
                if($i == 9 && $rows[$i] != "")
                {
                    $poNumber = $rows[$i];
                }
            }

            if($poNumber !="")
            {
                $update['ctr_po_number'] = $poNumber;
                $this->db->where('ctr_generate_text_number', $filename);
                $this->db->update('prc_tender_main', $update);
                
                $response['status'] = 'SUCCESS';
                $response['message'] = 'Generate Berhasil';

                echo json_encode($response);

            } else {
                $response['status'] = 'ERROR';
                $response['message'] = 'PO NUMBER TIDAK TERUPDATE !';
                echo json_encode($response);

            }
        }

        public function update_data_po_contract($rfqNo = null)
        {
            # code...
            $error = false;

            $post = $this->input->post();

            $id = $post['id'];

            $last_comment = $this->Comment_m->getContract("",$id,"")->row_array();

            $last_activity = (!empty($last_comment)) ? $last_comment['activity'] : 2000;


            $ptm_number = $last_comment['tender_id'];

            $this->db->select('pr_number');
            $this->db->where('ptm_number', $ptm_number);
            $getNoPR = $this->db->get('vw_prc_monitor')->row_array();

            $contract_id = $last_comment['contract_id'];


            $permintaan = $this->Procpr_m->getPR($getNoPR['pr_number'], $post['is_sap'])->row_array();

            $contract = $this->Contract_m->getContractNew($ptm_number)->row_array();

            $contract_header = $this->Contract_m->getData($contract_id)->row_array();

            $perencanaan_id = $permintaan['ppm_id'];

            $ccc_user = NULL;

            $tender = $this->Procrfq_m->getRFQ($last_comment['tender_id'])->row_array();

            $header = array();

            $header['item_kontrak_inp'] = $post['item_kontrak_inp'];
            $header['ctr_doc_type'] = $post['ctr_doc_type'];
            $header['type_winner_inp'] = $post['type_winner_inp'];
            $header['subject_work'] = $post['subject_work'];
            $header['scope_work'] = $post['scope_work'];
            $header['ctr_term_condition'] = $post['ctr_term_condition'];
            $header['kategori_pekerjaan_inp'] = $post['kategori_pekerjaan_inp'];
            $updateHeader = $this->Contract_m->updateData($contract_id,$header);

            



        }

        public function update_contract_item_po($contract_id)
        {
            # code...
            $post = json_decode($this->input->post('values'));
            $key = $this->input->post('key');

            $this->db->where('contract_item_id', $key);
                
            $update = $this->db->update('ctr_contract_item', $post);
            $code = ($update) ? 200 : 400;

            $this->db->where('is_delete',0);
            $item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
            echo json_encode(array('code'=> $code,'data'=> $item2));

            
        }

        public function insert_contract_item_po($contract_id)
        {
            # code...
            $post = json_decode($this->input->post('values'));
           
            $item_code = $post->item_code;

            $this->db->where('is_delete',0);
            $item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
            $contract = $this->db->get_where('ctr_contract_header', ['contract_id' => $contract_id])->row_array();


            $this->db->where('ppi_code',$item_code);
            $itemPR = $this->db->get('prc_pr_item')->row_array();


            $input_item['item_code'] = $post->item_code;
            //$input_item['tit_id'] = $post['tit_id'];
            $input_item['short_description'] = $itemPR['ppi_description'];
            $input_item['long_description'] = $itemPR['ppi_description'];
            $input_item['qty'] = $post->qty;
            $input_item['max_qty'] = $post->qty;
            $input_item['uom'] = $itemPR['ppi_unit'];
            $input_item['sub_total'] = (int)$post->qty * (int)$post->price;
            $input_item['price'] = $post->price;
            $input_item['vendor_code'] = $contract['vendor_id'];

            $input_item['hps'] = isset($post->hps) ? $post->hps : 0;
            $input_item['sumber_hps'] = isset($post->sumber_hps) ? $post->sumber_hps : "";

            

            $input_item['contract_id'] = $contract['contract_id'];


            $input_item['incoterm'] = isset($post->incoterm) ? $post->incoterm : "";
            $input_item['lokasi_incoterm'] = isset($post->lokasi_incoterm) ? $post->lokasi_incoterm : "";

            $input_item['pr_number_sap'] = $itemPR['ppis_pr_number'];
            $input_item['pr_item_sap'] = $itemPR['ppis_pr_item'];
            $input_item['no_asset'] = $itemPR['ppi_no_asset'];
            $input_item['sub_number'] = $itemPR['ppi_sub_number'];
            $input_item['tax_code'] = $itemPR['ppi_tax_code'];
            $input_item['pr_delivery_date'] = $itemPR['ppis_delivery_date'];
            $input_item['pr_type_sap'] = $itemPR['ppis_pr_type'];
            $input_item['pr_acc_assig'] = $itemPR['ppis_acc_assig'];
            $input_item['pr_cat_tech'] = $itemPR['ppis_cat_tech'];
            $input_item['pr_retention'] = $itemPR['ppi_retention'];

            $input_item['is_new'] = 1;



            //$this->db->where('contract_item_id', $key);
                
             $insert = $this->db->insert('ctr_contract_item', $input_item);
             $code = ($insert) ? 200 : 400;

             $this->db->where('is_delete',0);
             $item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
            
            echo json_encode(array('code'=> $code,'data'=> $item2));

            
        }

        public function remove_contract_item_po($contract_id)
        {
            # code...
            $post = json_decode($this->input->post('values'));
            $key = $this->input->post('key');

            $this->db->where('contract_item_id', $key);
            $data['is_delete'] = 1;
            $update = $this->db->update('ctr_contract_item', $data);
            $code = ($update) ? 200 : 400;

            $this->db->where('is_delete',0);
            $item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
            echo json_encode(array('code'=> $code,'data'=> $item2));

            
        }

        public function get_item_contract_po($contract_id)
        {
            # code...
            $this->db->where('is_delete',0);
            $item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
            $data = $item2;
            echo json_encode(array('data'=> $data));

            
        }

        public function push_edit_po_sap($contract_id)
        {
            # code...
            $item2 = $this->db->get_where('ctr_contract_item', ['contract_id' => $contract_id])->result_array();
            $itemNew[] = array();

            foreach ($item2 as $key => $value) {
                # code...
                $itemNew[$key]['PO_NUMBER'] = $value['pr_number_sap'];
                $itemNew[$key]['INCOTERMS1'] = $value['pr_number_sap'];
                $itemNew[$key]['INCOTERMS2'] = $value['pr_number_sap'];
                $itemNew[$key]['PO_NUMBER'] = $value['pr_number_sap'];
                $itemNew[$key]['PO_NUMBER'] = $value['pr_number_sap'];
                $itemNew[$key]['PO_NUMBER'] = $value['pr_number_sap'];
                $itemNew[$key]['PO_NUMBER'] = $value['pr_number_sap'];
                $itemNew[$key]['PO_NUMBER'] = $value['pr_number_sap'];


            }

            $message = "Push Berhasil";

            echo json_encode(array('code'=> 200,'message'=> $message));

        }

        public function get_item_pr_dropdown($rfqno="")
        {
            # code...
            // $tender = $this->Procrfq_m->getMonitorRFQ($rfqno)->row_array();

            // $this->db->where('pr_spk_code',$tender['spk_code']);
            // echo json_encode($this->db->get("vw_pr_item_dropdown")->result_array());
            
            $get = $this->input->get();

            $filtering = $this->uri->segment(3, 0);

            $perencanaan = null;

            if (isset($get['spk_code'])) {
            $this->db->select('ppm_id');
            $this->db->distinct();
            $this->db->where('ppm_project_id', $get['spk_code']);
            $perencanaan = $this->db->get('prc_plan_main')->row_array();   
            }

            $order = (isset($get['order']) && !empty($get['order'])) ? $get['order'] : "asc";
            $limit = (isset($get['limit']) && !empty($get['limit'])) ? $get['limit'] : 10;
            $search = (isset($get['search']) && !empty($get['search'])) ? $this->db->escape_like_str(strtolower($get['search'])) : "";
            $offset = (isset($get['offset']) && !empty($get['offset'])) ? $get['offset'] : 0;
            $field_order = (isset($get['sort']) && !empty($get['sort'])) ? $get['sort'] : "smbd_code";

            $id = (isset($get['id']) && !empty($get['id'])) ? $get['id'] : "";

            if(!empty($search)){
            $this->db->group_start();
            $this->db->like("LOWER((group_smbd_code)::text)",$search);
            $this->db->or_like("LOWER((smbd_code)::text)",$search);
            $this->db->or_like("LOWER((ppis_pr_number)::text)",$search);
            $this->db->or_like("LOWER(smbd_name)",$search);
            $this->db->or_like("LOWER(unit)",$search);
            $this->db->or_like("LOWER((price)::text)",$search);
            $this->db->or_like("LOWER(group_smbd_name)",$search);
            $this->db->group_end();
            }

            if(!empty($id)){

            // $group_code = substr($id, 0, 3);
            // $smbd_code =  $id;
            $arr = array(
                'ppi_id' => $id
            );
            $this->db->where($arr);
            }

            if (!empty($perencanaan)) {
            $this->db->where('a.ppm_id', $perencanaan['ppm_id']); 
            }

            $result = $this->db->get("vw_prc_pr_item_sap a");

            $data['total'] = $result->num_rows();

            if(!empty($search)){
            $this->db->group_start();
            $this->db->like("LOWER((group_smbd_code)::text)",$search);
            $this->db->or_like("LOWER((smbd_code)::text)",$search);
            $this->db->or_like("LOWER(smbd_name)",$search);
            $this->db->or_like("LOWER((ppis_pr_number)::text)",$search);
            $this->db->or_like("LOWER(unit)",$search);
            $this->db->or_like("LOWER((price)::text)",$search);
            $this->db->or_like("LOWER(group_smbd_name)",$search);
            $this->db->group_end();
            }

            if(!empty($order)){
            $this->db->order_by("smbd_code",$order);
            $this->db->order_by($field_order,$order);
            }

            if(!empty($limit)){
            //$this->db->limit($limit,$offset);
            }

            if(!empty($id)){

            //  $group_code = substr($id, 0, 3);
            //  $smbd_code =  $id;
            $arr = array(
            'ppi_id' => $id
            );
            $this->db->where($arr);

            }

            if (!empty($perencanaan)) {
            $this->db->where('a.ppm_id', $perencanaan['ppm_id']); 
            }

            $result = $this->db->get("vw_prc_pr_item_sap a");

            $rows = $result->result_array();

            foreach ($rows as $key => $value) {

            $rows[$key]['checkbox'] = true;
            $rows[$key]["price"] = inttomoney($rows[$key]["price"]);
            $rows[$key]["ppv_max"] = $rows[$key]["ppv_max"]+0;
            $rows[$key]["ppv_remain"] = $rows[$key]["ppv_remain"]+0;

            }


            if (!empty($id)) {

            $smbd_code = $this->db->where('ppi_id', $id)->limit(1)->get('vw_prc_pr_item_sap')->row_array();

            $this->db->select("substr((periode_pengadaan::text), 1,4) as tahun");
            $this->db->where('spk_code', $get['spk_code']);
            $this->db->where('smbd_code', $smbd_code['smbd_catalog_code']);
            $this->db->group_by("substr((periode_pengadaan::text), 1,4)");
            $periode_pengadaan_tahun = $this->db->get('prc_plan_integrasi')->result_array();
            $n = 0;
            foreach ($periode_pengadaan_tahun as $key => $value_thn) {

                $rows['periode_pengadaan'][$n] = array(
                'id' => $value_thn['tahun'],
                'text' => $value_thn['tahun'],
                'children' => array()
                );
                
                $tahun = $value_thn['tahun'];
                $this->db->select('periode_pengadaan');
                $this->db->where('spk_code', $get['spk_code']);
                $this->db->where('smbd_code', $smbd_code['smbd_catalog_code']);
                $this->db->like('(periode_pengadaan)::text', "$tahun");
                $periode_pengadaan = $this->db->get('prc_plan_integrasi')->result_array();
                $no = 1;
                foreach ($periode_pengadaan as $key => $value) {

                $date = date_create($value['periode_pengadaan']);
                $rows['periode_pengadaan'][$n]['children'][] = array(
                'parent' => $value_thn['tahun'],
                'id' => $value['periode_pengadaan'],
                'text' => date_format($date,"d-M-Y")
                );

                $no++;
            }
            
            $n++;
            }
            }

            $data['rows'] = $rows;

            echo json_encode($rows);

        }

        public function get_incoterm()
        {
            echo json_encode($this->db->get("adm_incoterm")->result_array());
        }

        public function get_sumber_hps()
        {
            $sumber_hps = [
                [
                  'value' => 'a. RAB proyek yang telah disahkan didalam RKP',
                  'option' => 'a. RAB proyek yang telah disahkan didalam RKP',
                ],
                [
                  'value' => 'b. Informasi biaya satuan yang dipublikasikan secara resmi oleh Badan Pusat Statistik (BPS)',
                  'option' => 'b. Informasi biaya satuan yang dipublikasikan secara resmi oleh Badan Pusat Statistik (BPS)',
                ],
                [
                  'value' => 'c. Informasi biaya satuan yang dipublikasikan secara resmi oleh asosiasi terkait dan sumber
                  data lain yang dapat dipertanggungjawabkan',
                  'option' => 'c. Informasi biaya satuan yang dipublikasikan secara resmi oleh asosiasi terkait dan sumber
                  data lain yang dapat dipertanggungjawabkan',
                ],
                [
                  'value' => 'd. Daftar biaya/tarif barang/jasa yang dikeluarkan oleh pabrikan / distributor tunggal',
                  'option' => 'd. Daftar biaya/tarif barang/jasa yang dikeluarkan oleh pabrikan / distributor tunggal',
                ],
                [
                  'value' => 'e. Biaya kontrak sebelumnya atau yang sedang berjalan dengan mempertimbangkan faktor perubahan biaya',
                  'option' => 'e. Biaya kontrak sebelumnya atau yang sedang berjalan dengan mempertimbangkan faktor perubahan biaya',
                ],
                [
                  'value' => 'f. Inflasi tahun sebelumnya, suku bunga berjalan dan/atau kurs tengah Bank Indonesia',
                  'option' => 'f. Inflasi tahun sebelumnya, suku bunga berjalan dan/atau kurs tengah Bank Indonesia',
                ],
                [
                  'value' => 'g. Hasil perbandingan dengan kontrak sejenis, baik yang dilakukan dengan instansi lain maupun pihak lain',
                  'option' => 'g. Hasil perbandingan dengan kontrak sejenis, baik yang dilakukan dengan instansi lain maupun pihak lain',
                ],
                [
                  'value' => 'h. Perkiraan perhitungan biaya yang dilakukan oleh konsultan perencanaan',
                  'option' => 'h. Perkiraan perhitungan biaya yang dilakukan oleh konsultan perencanaan',
                ],
                [
                  'value' => 'i. Norma indeks; dan/atau',
                  'option' => 'i. Norma indeks; dan/atau',
                ],
                [
                  'value' => 'j. Informasi lain yang dapat dipertanggungjawabkan',
                  'option' => 'j. Informasi lain yang dapat dipertanggungjawabkan',
                ]
              ];

              echo json_encode($sumber_hps);

        }

    }

?>