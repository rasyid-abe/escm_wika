<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sync_postgre_model extends CI_Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_vendor_data()
    {        
        $this->db->select("vendor_id, vendor_name, contact_name, contact_phone_no, contact_email, address_street, login_id, password, dir_name, dir_pos");        
        $query = $this->db->get('vnd_header');

        return $query->result();
    }

    public function get_all_vendor($vendor_id, $name="", $nasabah_code="", $address="", $email="", $type="", $reg_status="", $limit=0, $offset=0, $dinamic=0)
    {        
        $this->db->order_by('vendor_id', 'desc');

        if(isset($vendor_id)) {
            $this->db->or_where('vendor_id', $vendor_id);
        }

        if(isset($name)) {
            $this->db->or_like('vendor_name', strtoupper($name));
        }

        if(isset($nasabah_code)) {
            $this->db->or_like('nasabah_code', $nasabah_code);
        }

        if(isset($address)) {
            $this->db->or_like('address_street', $address);
        }

        if(isset($email)) {
            $this->db->or_like('email_address', $email);
        }

        if(isset($type)) {
            $this->db->or_like('vendor_type', $type);            
        }

        if($reg_status == 'Active') {
            if($dinamic == 0) {
                $this->db->or_where('reg_status_id', 8);
            } else {
                $this->db->where('reg_status_id', 8);
            }            
        } 
        
        if($reg_status == 'Inactive') {
            if($dinamic == 0) {
                $this->db->or_where('reg_status_id !=', 8);
            } else {
                $this->db->where('reg_status_id !=', 8);
            }            
        }

        if($limit > 0 || $offset > 0) {
            $this->db->limit($limit,$offset);
        }

        return $query = $this->db->get('vnd_header');
    }

    public function get_vendor_alamat($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_alamat');
    }

    public function get_vendor_kontak($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_kontak');
    }

    public function get_vendor_akta($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_akta');
    }

    public function get_vendor_sk($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_sk');
    }

    public function get_vendor_izin($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_izin');
    }

    public function get_vendor_sertifikat($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_sertifikat');
    }

    public function get_vendor_spt($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_spt');
    }

    public function get_vendor_bank($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_bank');
    }

    public function get_vendor_lap_tahun($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_fin_rpt');
    }

    public function get_vendor_saham($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_saham');
    }

    public function get_vendor_personil($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_personil');
    }

    public function get_vendor_pengurus($vendor_id="")
    {        
        $this->db->order_by('board_id', 'desc');
        
        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }
        
        return $query = $this->db->get('vnd_board');
    }

    public function get_vendor_pengalaman($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_pengalaman');
    }

    public function get_vendor_fasilitas($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_fasilitas');
    }

    public function get_vendor_produk($vendor_id="")
    {        
        $this->db->order_by('product_id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_product');
    }

    public function get_vendor_cqsms($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_cqsms');
    }

    public function get_vendor_dnb($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_dnb');
    }

    public function get_vendor_account($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_account');
    }

    public function get_vendor_bidang($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_bidang_usaha');
    }

    public function get_vendor_company($vendor_id="")
    {        
        $this->db->order_by('id', 'desc');

        if(isset($vendor_id)) {
            $this->db->where('vendor_id', $vendor_id);
        }

        return $query = $this->db->get('vnd_company');
    }

    public function get_vendor_summary()
    {        
        return $query = $this->db->get('vw_vendor_summary');
    }

    public function get_all_dept_data()
    {
        $this->db->select("a.dept_id, a.dept_name, a.dep_code , b.pos_id , b.pos_name, c.fullname as complete_name")
        ->from('adm_dept a')
        ->join('adm_employee_pos b',"a.dept_id = b.dept_id AND b.pos_name LIKE 'Kepala Divisi %' AND b.is_main_job = '1'",'left', FALSE)
        ->join('adm_employee c', 'b.employee_id = c.id','left')
        ->where('a.dept_active', 1);
        $query = $this->db->get();

        return $query->result();
    }

    public function get_all_data_lelang()
    {
        $this->db->select("a.subject_work
        , b.ptm_dept_id
        , b.ptm_dept_name
        , a.vendor_name
        , a.start_date
        , a.end_date
        , a.currency
        , a.ctr_item_type
        , c.item_code
        , c.long_description
        , c.price
        , c.qty
        , c.contract_item_id
        , c.uom", FALSE);

        $where = "a.start_date is  NOT NULL";
        $this->db->from('ctr_contract_header as a')
            ->join('prc_tender_main as b', 'a.ptm_number = b.ptm_number', 'left')
            ->join('ctr_contract_item as c', 'c.contract_id = a.contract_id')
            ->where($where);

        $query = $this->db->get();

        return $query->result();
    }

    public function get_all_data_role()
    {
        $this->db->select("*");
        $query = $this->db->get('adm_pos');

        return $query->result();
    }

    public function get_all_data_smbd()
    {
        $this->db->select("*");
        $query = $this->db->get('adm_catalogue');

        return $query->result();
    }

    public function get_all_data_pg()
    {
        $this->db->select("*");
        $this->db->order_by("id", "asc");
        $query = $this->db->get('adm_purchasing_group');

        return $query->result();
    }

    public function get_all_data_tax()
    {
        $this->db->select("*");
        $this->db->order_by("id", "asc");
        $query = $this->db->get('adm_tax_code');

        return $query->result();
    }

    public function get_all_data_incoterm()
    {
        $this->db->select("*");
        $this->db->order_by("id", "asc");
        $query = $this->db->get('adm_incoterm');

        return $query->result();
    }

    private function _get_last_sync_history($sync_code)
    {
        return $this->db->limit(1)
        ->order_by('id', 'desc')
        ->where('sync_code_id', $sync_code)
        ->get('sync_history');
    }

    public function get_all_pr()
    {       
        $this->db->join('vw_adm_cm_dept ac', 'ac.adm_code_sub = vw_prc_pr_sap.code_sub', 'left');
        $this->db->order_by('vw_prc_pr_sap.ppi_update_at', 'desc');
        $this->db->limit(30);
        $query = $this->db->get('vw_prc_pr_sap');

        return $query->result_array();
    }

    public function get_all_item_pr($ppm_id)
    {       
        $this->db->distinct();
        $this->db->select('prc_plan_item.*')
        ->from('prc_plan_main')
        ->join('prc_plan_item', 'prc_plan_item.ppm_id = prc_plan_main.ppm_id', 'left')
        ->where('prc_plan_item.ppm_id', $ppm_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_data_users()
    {       
        $this->db->distinct();
        $this->db->select('*')
        ->from('adm_user a')
        ->join('adm_employee b', 'a.employeeid = b.id')
        ->join('adm_employee_pos c', "c.employee_id = b.id AND c.is_main_job = '1'")
        ->join('adm_dept d', 'c.dept_id = d.dept_id');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_user_proyek($id)
    {       
        $this->db->select('ppm_id, ppm_project_id, ppm_project_name, ppm_dept_id, ppm_dept_name')
        ->from('adm_employee emp')
        ->join('adm_employee_proyek empp', 'emp.id = empp.employee_id', 'left')
        ->where('empp.employee_id', $id)
        ->order_by('empp.id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_data_kontrak()
    {        
        $this->db->select("*");        
        $query = $this->db->get('ctr_contract_header');

        return $query->result();
    }

    public function get_all_data_amandemen()
    {
        $this->db->select("*");
        $query = $this->db->get('ctr_ammend_header');

        return $query->result();
    }
    
    public function get_all_data_project()
    {
        $this->db->select("*");
        $query = $this->db->get('project_info');

        return $query->result();
    }
    
    public function get_all_data_prc_plan($page)
    {   
        $limit = 1000;
        $offset = $page;
        $this->db->select("*");
        $this->db->order_by('id', 'ASC');
        $this->db->limit($limit,$offset);
        $query = $this->db->get('prc_plan_integrasi');

        return $query->result();
    }
    
    public function get_all_data_prc_plan2()
    {       
        return $this->db->count_all('prc_plan_integrasi');
    }

    public function get_all_data_grses()
    {       
        $this->db->select("*");
        $query = $this->db->get('ctr_gr_ses');

        return $query->result();
    }

    public function get_all_data_vpi()
    {
        $this->db->select('a.vk_id, a.vvh_id, a.vk_score_total , b.vvh_vendor_id, c.vendor_name, b.vvh_date')
        ->from('vnd_vpi_kompilasi a')
        ->join('vnd_vpi_header b', 'a.vvh_id = b.vvh_id', 'left')
        ->join('vnd_header c', 'c.vendor_id = b.vvh_vendor_id', 'left')
        ->order_by('a.vk_id', 'asc');        
        $query = $this->db->get();
        return $query->result();
    }

    public function get_all_contract($id=0, $ptm_number="", $start_date="", $end_date="", $divisi="", $status=0, $year="", $limit=0, $offset=0)
    {
        $this->db->select('
            vnd_header.is_3pl_ins, 
            vnd_header.fin_class, 
            vnd_header.address_street, 
            vnd_header.addres_prop, 
            vnd_header.address_postcode, 
            vnd_header.address_country, 
            vnd_alamat.country, 
            vnd_alamat.province_name, 
            vnd_alamat.city_name, 
            vnd_alamat.alamat, 
            ctr_contract_header.contract_id,
            ctr_contract_header.ctr_spe_pos_name,
            ctr_contract_header.ptm_number,
            ctr_contract_header.contract_number,
            ctr_contract_header.vendor_id,
            ctr_contract_header.vendor_name,
            ctr_contract_header.sign_date,
            ctr_contract_header.start_date,
            ctr_contract_header.end_date,
            ctr_contract_header.created_date,
            ctr_contract_header.subject_work,
            ctr_contract_header.scope_work,
            ctr_contract_header.contract_type,
            ctr_contract_header.currency,            
            ctr_contract_header.ctr_po_number,            
            ctr_contract_header.contract_amount,
            ctr_contract_header.kategori_pekerjaan,
            ctr_contract_header.status,
            ctr_contract_header.notes,
            ctr_contract_header.ctr_jenis,
            ctr_contract_header.ctr_item_type,
            ctr_contract_header.type_of_plan,
            ctr_contract_header.type_winner,
            ctr_contract_header.amandemen_number,
            project_info.kode_spk, 
            project_info.nama_spk, 
            adm_dept.dept_name, 
            adm_dept.dep_code, 
            adm_dept.dept_id, 
            prc_tender_main.ptm_buyer,
            adm_wkf_activity.awa_name, 
            sum(subtotal_rab) as subtotal_rab
        ');
        $this->db->join('adm_wkf_activity', 'ctr_contract_header.status = adm_wkf_activity.awa_id', 'left');
        $this->db->join('project_info', 'ctr_contract_header.spk_code = project_info.kode_spk', 'left');
        $this->db->join('vnd_header', 'ctr_contract_header.vendor_id = vnd_header.vendor_id', 'left');
        $this->db->join('prc_tender_main', 'ctr_contract_header.ptm_number = prc_tender_main.ptm_number', 'left');
        $this->db->join('adm_dept', 'ctr_contract_header.dept_id = adm_dept.dept_id', 'left');
        $this->db->join('vw_smbd_sum_rab', 'ctr_contract_header.contract_id = vw_smbd_sum_rab.contract_id', 'left');
        $this->db->join('vnd_alamat', 'vnd_header.vendor_id = vnd_alamat.vendor_id', 'left');
        $this->db->order_by('contract_id', 'desc');

        if ($id > 0) {
            $this->db->where('ctr_contract_header.contract_id', $id);
        }
        
        if ($status > 0) {
            $this->db->where('ctr_contract_header.status', $status);
        }

        if (!empty($ptm_number)) {
            $this->db->like('ctr_contract_header.ptm_number', strtoupper($ptm_number));
        }
        
        if (!empty($year)) {
            $this->db->where("date_part('year', start_date) =", $year);
        }
        
        if (!empty($start_date) && empty($end_date)) {
            $this->db->where('ctr_contract_header.start_date', $start_date);
        }

        if (!empty($end_date) && empty($start_date)) {
            $this->db->where('ctr_contract_header.end_date', $end_date);
        }
        
        if (!empty($divisi)) {
            $this->db->where('adm_dept.dept_name', $divisi);
        }

        // start range date 

            if (!empty($start_date) && empty($end_date)) {
                $this->db->where('ctr_contract_header.start_date >=', $start_date);
                $this->db->where('ctr_contract_header.start_date <=', $end_date);
            }   

        // end range date 
        
        if($limit > 0 || $offset > 0) {
            $this->db->limit($limit,$offset);
        }

        // $this->db->where('vnd_alamat.type', 'PUSAT');
        $this->db->where('ctr_contract_header.status', 2901);

        $this->db->group_by('
            vnd_header.is_3pl_ins, 
            vnd_header.fin_class, 
            vnd_header.address_street, 
            vnd_header.addres_prop, 
            vnd_header.address_postcode, 
            vnd_header.address_country, 
            vnd_alamat.country, 
            vnd_alamat.province_name, 
            vnd_alamat.city_name, 
            vnd_alamat.alamat, 
            ctr_contract_header.contract_id,
            ctr_contract_header.ctr_spe_pos_name,
            ctr_contract_header.ptm_number,
            ctr_contract_header.contract_number,
            ctr_contract_header.vendor_id,
            ctr_contract_header.vendor_name,
            ctr_contract_header.sign_date,
            ctr_contract_header.start_date,
            ctr_contract_header.end_date,
            ctr_contract_header.created_date,
            ctr_contract_header.subject_work,
            ctr_contract_header.scope_work,
            ctr_contract_header.contract_type,
            ctr_contract_header.currency,
            ctr_contract_header.ctr_po_number,
            ctr_contract_header.contract_amount,
            ctr_contract_header.kategori_pekerjaan,
            ctr_contract_header.status,
            ctr_contract_header.notes,
            ctr_contract_header.ctr_jenis,
            ctr_contract_header.ctr_item_type,
            ctr_contract_header.type_of_plan,
            ctr_contract_header.type_winner,
            ctr_contract_header.amandemen_number,
            project_info.kode_spk, 
            project_info.nama_spk, 
            adm_dept.dept_name, 
            adm_dept.dep_code, 
            adm_dept.dept_id, 
            prc_tender_main.ptm_buyer,
            adm_wkf_activity.awa_name
        ');

        return $query = $this->db->get('ctr_contract_header');
    }

    public function get_contract_item($id)
    {        
        $this->db->where('contract_id', $id);
        return $query = $this->db->get('ctr_contract_item');
    }

    public function get_contract_dokumen($id)
    {        
        $this->db->where('contract_id', $id);
        return $query = $this->db->get('ctr_contract_doc');
    }

    public function get_contract_jaminan($id)
    {        
        $this->db->where('cj_contract_id', $id);
        $query = $this->db->get('ctr_jaminan');

        return $query->result_array();
    }

    public function get_contract_jaminan_api($id)
    {        
        $this->db->where('cj_contract_id', $id);
        $query = $this->db->get('ctr_jaminan');

        return $query;
    }

    public function get_contract_risiko($id)
    {        
        $this->db->join('prc_tender_main', 'ctr_contract_header.ptm_number = prc_tender_main.ptm_number','left');
        $this->db->join('prc_risiko', 'prc_tender_main.pr_number = prc_risiko.pr_number','left');
        $this->db->where('contract_id', $id);
        $query = $this->db->get('ctr_contract_header');

        return $query;
    }

    public function get_contract_opportunity($id)
    {        
        $this->db->join('prc_tender_main', 'ctr_contract_header.ptm_number = prc_tender_main.ptm_number','left');
        $this->db->join('prc_opportunity', 'prc_tender_main.pr_number = prc_opportunity.pr_number','left');
        $this->db->where('contract_id', $id);
        $query = $this->db->get('ctr_contract_header');

        return $query;
    }

    public function get_contract_milestone($id)
    {        
        $this->db->where('contract_id', $id);
        $query = $this->db->get('ctr_contract_milestone');

        return $query->result_array();
    }

    public function get_contract_milestone_api($id)
    {        
        $this->db->where('contract_id', $id);
        $query = $this->db->get('ctr_contract_milestone');

        return $query;
    }

    public function get_contract_person($id)
    {        
        $this->db->where('cp_contract_id', $id);
        $query = $this->db->get('ctr_person_in_charge');

        return $query->result_array();
    }

    public function get_contract_person_api($id)
    {        
        $this->db->where('cp_contract_id', $id);
        $query = $this->db->get('ctr_person_in_charge');

        return $query;
    }

    public function get_contract_catatan($id)
    {        
        $this->db->where('cad_contract_id', $id);
        $query = $this->db->get('ctr_comment_all_div');

        return $query;
    }

    public function get_contract_aktivitas($id)
    {        
        $this->db->join('adm_wkf_activity', 'ctr_contract_comment.ccc_activity = adm_wkf_activity.awa_id','left');
        $this->db->join('adm_user', 'ctr_contract_comment.ccc_user = adm_user.id','left');
        $this->db->where('contract_id', $id);
        $query = $this->db->get('ctr_contract_comment');

        return $query;
    }

    public function get_contract_vpi($id, $vendor)
    {        
        $this->db->distinct();
        $this->db->select('contract_id, vendor_id, vendor_name, vpi_date, vpi_month, vpi_year, vpi_score, start_date, end_date');
        $this->db->where('contract_id', $id);
        $this->db->where('vendor_id', $vendor);
        $query = $this->db->get('vw_vpi_score_per_bulan');

        return $query->result_array();
    }
}
