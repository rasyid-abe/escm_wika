<?php if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Contract_matgis_m extends CI_Model
{

  public function __construct()
  {
    parent::__construct();
    $this->load->model("Administration_m");

  }

  public function get_dept($contract_id)
  {
    $qry='SELECT DISTINCT
    "p".pr_dept_id AS dept_id,
    "public".adm_dept.dept_name,
    "public".adm_dept.dep_code
    FROM
    ((((((("public".ctr_contract_header AS "a"
      JOIN "public".ctr_contract_item AS b ON (("a".contract_id = b.contract_id)))
      JOIN "public".prc_tender_item AS i ON ((b.tit_id = i.tit_id)))
      JOIN "public".prc_tender_main AS "m" ON (((i.ptm_number)::text= (m.ptm_number)::text)))
      JOIN "public".prc_pr_main AS "p" ON (((m.pr_number)::text= (p.pr_number)::text)))
      JOIN "public".vw_sum_contract ON (("public".vw_sum_contract.contract_id = "a".contract_id)))
      LEFT JOIN "public".vw_sum_wo ON (("public".vw_sum_wo.contract_id = "a".contract_id)))
      JOIN "public".adm_wkf_activity ON (("a".status = "public".adm_wkf_activity.awa_id)))
      INNER JOIN "public".adm_dept ON "p".pr_dept_id = "public".adm_dept.dept_id
      WHERE ((a.status = 2901) AND (a.ctr_is_matgis = 1)
      AND a.contract_id='.$contract_id.')';
      $hsl=$this->db->query($qry)->row_array();
      return $hsl;
    }

    public function get_rkp_position_by_title($where = array())
    {
      $qry=' SELECT DISTINCT adm_auth_hie_rkp.pos_id AS hap_pos_code,
      adm_pos.pos_name AS hap_pos_name,
      a.pos_id AS hap_pos_parent,
      adm_auth_hie_rkp.max_amount AS hap_amount,
      adm_auth_hie_rkp.currency AS hap_currency,
      adm_pos.district_id AS hap_district,
      adm_pos_1.pos_name AS hap_pos_parent_name,
      adm_pos.job_title,
      adm_pos.dept_id,
      adm_dept.dept_name
      FROM ((((adm_auth_hie_rkp
        LEFT JOIN adm_pos ON ((adm_auth_hie_rkp.pos_id = adm_pos.pos_id)))
        LEFT JOIN adm_auth_hie_rkp a ON ((adm_auth_hie_rkp.parent_id = a.auth_hie_id)))
        LEFT JOIN adm_pos adm_pos_1 ON ((a.pos_id = adm_pos_1.pos_id)))
        JOIN adm_dept ON ((adm_pos.dept_id = adm_dept.dept_id))) WHERE adm_pos.pos_name is not null';
        foreach ($where as $value) {
          $qry.=' AND '.$value;
        }
        $qry.=' ORDER BY adm_auth_hie_rkp.pos_id';
        return $this->db->query($qry)->row_array();
      }
      public function get_smallest_rkp_position($dept)
      {
        $qry='SELECT MIN(adm_auth_hie_rkp.pos_id) AS hap_pos_code
        FROM ((((adm_auth_hie_rkp
          LEFT JOIN adm_pos ON ((adm_auth_hie_rkp.pos_id = adm_pos.pos_id)))
          LEFT JOIN adm_auth_hie_rkp a ON ((adm_auth_hie_rkp.parent_id = a.auth_hie_id)))
          LEFT JOIN adm_pos adm_pos_1 ON ((a.pos_id = adm_pos_1.pos_id)))
          JOIN adm_dept ON ((adm_pos.dept_id = adm_dept.dept_id)))
          WHERE adm_pos.dept_id='.$dept;
          return $this->db->query($qry)->row_array();
        }

        public function get_data($mod,$params,$source='task',$order="",$userdata="")
        {
          $qry="";
          include APPPATH.'controllers/shared/declared.php';
          switch ($mod) {
            case 'monev':
            $qry='SELECT * FROM vw_monev WHERE dept_id is not null';
            break;

            case 'contract':
            if($source='task'){
              $qry='SELECT contract_id,dept_id,ptm_number,contract_number,scope_work,vendor_name,qty_contract,sum(qty_wo)qty_wo,qty_contract-sum(qty_wo) remain,awa_name
              FROM (SELECT DISTINCT A
                .contract_id,
                A.contract_number,
                A.status,
                A.vendor_id,
                A.vendor_name,
                P.pr_dept_id AS dept_id,
                P.pr_dept_name,
                A.ptm_number,
                A.subject_work,
                A.scope_work,
                A.contract_amount,

                COALESCE ( vw_sum_contract.total_qty, ( 0 ) :: NUMERIC ) AS qty_contract,
                COALESCE ( vw_sum_contract.total_price, ( 0 ) :: NUMERIC ) AS price_contract,
                COALESCE ( vw_sum_wo.total_qty, ( 0 ) :: NUMERIC ) AS qty_wo,
                COALESCE ( vw_sum_wo.total_price, ( 0 ) :: NUMERIC ) AS price_wo,
                (
                  COALESCE ( vw_sum_contract.total_qty, ( 0 ) :: NUMERIC ) - COALESCE ( vw_sum_wo.total_qty, ( 0 ) :: NUMERIC )) AS remain,
                  adm_wkf_activity.awa_name
                  FROM
                  (((((((
                    ctr_contract_header
                    A JOIN ctr_contract_item b ON ((
                      A.contract_id = b.contract_id
                    )))
                    JOIN prc_tender_item i ON ((
                      b.tit_id = i.tit_id
                    )))
                    JOIN prc_tender_main M ON (((
                      i.ptm_number
                    ) :: TEXT = ( M.ptm_number ) :: TEXT
                  )))
                  JOIN prc_pr_main P ON (((
                    M.pr_number
                  ) :: TEXT = ( P.pr_number ) :: TEXT
                )))
                JOIN vw_sum_contract ON ((
                  vw_sum_contract.contract_id = A.contract_id
                )))
                LEFT JOIN vw_sum_wo ON ((
                  vw_sum_wo.contract_id = A.contract_id
                )))
                JOIN adm_wkf_activity ON ((
                  A.status = adm_wkf_activity.awa_id
                )))
                WHERE
                ((
                  A.status = 2901 AND COALESCE ( vw_sum_contract.total_qty, ( 0 ) :: NUMERIC ) - COALESCE ( vw_sum_wo.total_qty, ( 0 ) :: NUMERIC )>0
                )
                AND ( A.ctr_is_matgis = 1 ))) wo_stat
                GROUP BY contract_id,dept_id,ptm_number,contract_number,scope_work,vendor_name,qty_contract,awa_name HAVING dept_id is not null
                ';
              }

              case 'po':
              if($source=='create'){
                $qry='SELECT contract_id,dept_id,ptm_number,contract_number,scope_work,vendor_name,qty_contract,sum(qty_wo)qty_wo,qty_contract-sum(qty_wo) remain,awa_name
                FROM (SELECT DISTINCT A
                  .contract_id,
                  A.contract_number,
                  A.status,
                  A.vendor_id,
                  A.vendor_name,
                  P.pr_dept_id AS dept_id,
                  P.pr_dept_name,
                  A.ptm_number,
                  A.subject_work,
                  A.scope_work,
                  A.contract_amount,

                  COALESCE ( vw_sum_contract.total_qty, ( 0 ) :: NUMERIC ) AS qty_contract,
                  COALESCE ( vw_sum_contract.total_price, ( 0 ) :: NUMERIC ) AS price_contract,
                  COALESCE ( vw_sum_wo.total_qty, ( 0 ) :: NUMERIC ) AS qty_wo,
                  COALESCE ( vw_sum_wo.total_price, ( 0 ) :: NUMERIC ) AS price_wo,
                  (
                    COALESCE ( vw_sum_contract.total_qty, ( 0 ) :: NUMERIC ) - COALESCE ( vw_sum_wo.total_qty, ( 0 ) :: NUMERIC )) AS remain,
                    adm_wkf_activity.awa_name
                    FROM
                    (((((((
                      ctr_contract_header
                      A JOIN ctr_contract_item b ON ((
                        A.contract_id = b.contract_id
                      )))
                      JOIN prc_tender_item i ON ((
                        b.tit_id = i.tit_id
                      )))
                      JOIN prc_tender_main M ON (((
                        i.ptm_number
                      ) :: TEXT = ( M.ptm_number ) :: TEXT
                    )))
                    JOIN prc_pr_main P ON (((
                      M.pr_number
                    ) :: TEXT = ( P.pr_number ) :: TEXT
                  )))
                  JOIN vw_sum_contract ON ((
                    vw_sum_contract.contract_id = A.contract_id
                  )))
                  LEFT JOIN vw_sum_wo ON ((
                    vw_sum_wo.contract_id = A.contract_id
                  )))
                  JOIN adm_wkf_activity ON ((
                    A.status = adm_wkf_activity.awa_id
                  )))
                  WHERE
                  ((
                    A.status = 2901 AND COALESCE ( vw_sum_contract.total_qty, ( 0 ) :: NUMERIC ) - COALESCE ( vw_sum_wo.total_qty, ( 0 ) :: NUMERIC )>0
                  )
                  AND ( A.ctr_is_matgis = 1 ))) wo_stat
                  GROUP BY contract_id,dept_id,ptm_number,contract_number,scope_work,vendor_name,qty_contract,awa_name HAVING dept_id is not null
                  ';
                  //die;
                }elseif($source=='monitor'){
                  $qry='SELECT * FROM vw_mon_wo Where cwo_name is null AND cwo_activity<>2062';
                }elseif($source=='task'){
                  $qry=' SELECT
                  "public".ctr_wo_header.wo_id,
                  "public".ctr_wo_header.wo_number,
                  "public".ctr_wo_header.creator_employee,
                  "public".ctr_wo_header.creator_pos,
                  "public".ctr_wo_header.contract_id,
                  "public".ctr_wo_header.vendor_id,
                  "public".ctr_wo_header.vendor_name,
                  "public".ctr_wo_header.currency,
                  "public".ctr_wo_header.start_date,
                  "public".ctr_wo_header.end_date,
                  "public".ctr_wo_header.created_date,
                  "public".ctr_wo_header.wo_notes,
                  "public".ctr_wo_header.approved_date,
                  "public".ctr_wo_header.status,
                  "public".ctr_wo_header.current_approver_pos,
                  "public".ctr_wo_header.current_approver_level,
                  "public".ctr_wo_header.current_approver_id,
                  "public".ctr_wo_header.dept_code,
                  "public".ctr_wo_header.ctr_doc,
                  "public".ctr_wo_header.ctr_amount,
                  "public".ctr_wo_header.ctr_skbdn_no,
                  "public".ctr_wo_header.ctr_skbdn_penerbit,
                  "public".ctr_wo_header.ctr_skbdn_tanggal_terbit,
                  "public".ctr_wo_header.active,
                  "public".ctr_wo_header.wo_total,
                  "public".ctr_wo_header.si_total,
                  "public".ctr_wo_header.sppm_total,
                  "public".ctr_wo_header.do_total,
                  "public".ctr_wo_header.sj_total,
                  "public".ctr_wo_header.bapb_total,
                  "public".ctr_wo_header.invoice_total,
                  "public".ctr_contract_header.ptm_number,
                  "public".ctr_contract_header.contract_number,
                  "public".adm_wkf_activity.awa_name,
                  COALESCE("public".vw_sum_per_wo.total_qty,0) AS qty_wo,
                  COALESCE("public".vw_sum_per_wo.total_price,0) AS price_wo
                  FROM
                  (("public".ctr_wo_header
                    JOIN "public".ctr_contract_header ON (("public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id)))
                    JOIN "public".adm_wkf_activity ON (("public".ctr_wo_header.status = "public".adm_wkf_activity.awa_id)))
                    INNER JOIN "public".vw_sum_per_wo ON "public".vw_sum_per_wo.wo_id = "public".ctr_wo_header.wo_id
                    WHERE "public".ctr_wo_header.wo_id is not null  AND "public".ctr_wo_header.status not in(2037,2033)';

                  }
                  break;
                  case 'skbdn':
                  if($source=='task'){
                    $qry='SELECT
                    "public".ctr_wo_header.wo_id,
                    "public".ctr_wo_header.wo_number,
                    "public".ctr_wo_header.creator_employee,
                    "public".ctr_wo_header.creator_pos,
                    "public".ctr_wo_header.contract_id,
                    "public".ctr_wo_header.vendor_id,
                    "public".ctr_wo_header.vendor_name,
                    "public".ctr_wo_header.currency,
                    "public".ctr_wo_header.start_date,
                    "public".ctr_wo_header.end_date,
                    "public".ctr_wo_header.created_date,
                    "public".ctr_wo_header.wo_notes,
                    "public".ctr_wo_header.approved_date,
                    "public".ctr_wo_header.status,
                    "public".ctr_wo_header.current_approver_pos,
                    "public".ctr_wo_header.current_approver_level,
                    "public".ctr_wo_header.current_approver_id,
                    "public".ctr_wo_header.dept_code,
                    "public".ctr_wo_header.ctr_doc,
                    "public".ctr_wo_header.ctr_amount,
                    "public".ctr_wo_header.ctr_skbdn_no,
                    "public".ctr_wo_header.ctr_skbdn_penerbit,
                    "public".ctr_wo_header.ctr_skbdn_tanggal_terbit,
                    "public".ctr_wo_header.active,
                    "public".ctr_wo_header.wo_total,
                    "public".ctr_wo_header.si_total,
                    "public".ctr_wo_header.sppm_total,
                    "public".ctr_wo_header.do_total,
                    "public".ctr_wo_header.sj_total,
                    "public".ctr_wo_header.bapb_total,
                    "public".ctr_wo_header.invoice_total,
                    "public".ctr_wo_header.dept_id,
                    "public".ctr_wo_header.spk_number,
                    "public".ctr_contract_header.ptm_number,
                    "public".ctr_contract_header.contract_number,
                    "public".adm_wkf_activity.awa_name
                    FROM
                    "public".ctr_wo_header
                    INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id
                    INNER JOIN "public".adm_wkf_activity ON "public".ctr_wo_header.status = "public".adm_wkf_activity.awa_id
                    WHERE
                    "public".ctr_wo_header.wo_number IS NOT null ';
                  }elseif($source=='monitor'){
                    $qry='SELECT
                    "public".ctr_wo_header.wo_id,
                    "public".ctr_wo_header.wo_number,
                    "public".ctr_wo_header.creator_employee,
                    "public".ctr_wo_header.creator_pos,
                    "public".ctr_wo_header.contract_id,
                    "public".ctr_wo_header.vendor_id,
                    "public".ctr_wo_header.vendor_name,
                    "public".ctr_wo_header.currency,
                    "public".ctr_wo_header.start_date,
                    "public".ctr_wo_header.end_date,
                    "public".ctr_wo_header.created_date,
                    "public".ctr_wo_header.wo_notes,
                    "public".ctr_wo_header.approved_date,
                    "public".ctr_wo_header.status,
                    "public".ctr_wo_header.current_approver_pos,
                    "public".ctr_wo_header.current_approver_level,
                    "public".ctr_wo_header.current_approver_id,
                    "public".ctr_wo_header.dept_code,
                    "public".ctr_wo_header.ctr_doc,
                    "public".ctr_wo_header.ctr_amount,
                    "public".ctr_wo_header.ctr_skbdn_no,
                    "public".ctr_wo_header.ctr_skbdn_penerbit,
                    "public".ctr_wo_header.ctr_skbdn_tanggal_terbit,
                    "public".ctr_wo_header.active,
                    "public".ctr_wo_header.wo_total,
                    "public".ctr_wo_header.si_total,
                    "public".ctr_wo_header.sppm_total,
                    "public".ctr_wo_header.do_total,
                    "public".ctr_wo_header.sj_total,
                    "public".ctr_wo_header.bapb_total,
                    "public".ctr_wo_header.invoice_total,
                    "public".ctr_wo_header.dept_id,
                    "public".ctr_wo_header.spk_number,
                    "public".ctr_contract_header.ptm_number,
                    "public".ctr_contract_header.contract_number,
                    "public".adm_wkf_activity.awa_name
                    FROM
                    "public".ctr_wo_header
                    INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id
                    INNER JOIN "public".adm_wkf_activity ON "public".ctr_wo_header.status = "public".adm_wkf_activity.awa_id
                    WHERE
                    "public".ctr_wo_header.wo_number IS NOT null and ctr_skbdn_no is not null';
                  }
                  break;

                  case 'si':
                  if($source=='create'){
                    $qry='SELECT DISTINCT
                    "public".ctr_wo_header.wo_id,
                    "public".ctr_wo_header.wo_number,
                    "public".ctr_wo_header.creator_employee,
                    "public".ctr_wo_header.creator_pos,
                    "public".ctr_wo_header.contract_id,
                    "public".ctr_wo_header.vendor_id,
                    "public".ctr_wo_header.vendor_name,
                    "public".ctr_wo_header.currency,
                    "public".ctr_wo_header.start_date,
                    "public".ctr_wo_header.end_date,
                    "public".ctr_wo_header.created_date,
                    "public".ctr_wo_header.wo_notes,
                    "public".ctr_wo_header.approved_date,
                    "public".ctr_wo_header.status,
                    "public".ctr_wo_header.current_approver_pos,
                    "public".ctr_wo_header.current_approver_level,
                    "public".ctr_wo_header.current_approver_id,
                    "public".ctr_wo_header.dept_code,
                    "public".ctr_wo_header.ctr_doc,
                    "public".ctr_wo_header.ctr_amount,
                    "public".ctr_wo_header.ctr_skbdn_no,
                    "public".ctr_wo_header.ctr_skbdn_penerbit,
                    "public".ctr_wo_header.ctr_skbdn_tanggal_terbit,
                    "public".ctr_wo_header.active,
                    "public".ctr_contract_header.ptm_number,
                    "public".ctr_contract_header.contract_number,
                    "public".adm_wkf_activity.awa_name,
                    COALESCE("public".vw_sum_per_wo.total_qty,0) AS qty_wo,
                    COALESCE("public".vw_sum_per_wo.total_price,0) AS price_wo,
                    COALESCE("public".vw_sum_per_wo.total_qty,0)-COALESCE("public".vw_sum_si.total_qty,0) AS remain,
                    "public".ctr_wo_header.dept_id
                    FROM
                    (("public".ctr_wo_header
                      JOIN "public".ctr_contract_header ON (("public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id)))
                      JOIN "public".adm_wkf_activity ON (("public".ctr_wo_header.status = "public".adm_wkf_activity.awa_id)))
                      INNER JOIN "public".vw_sum_per_wo ON "public".vw_sum_per_wo.wo_id = "public".ctr_wo_header.wo_id
                      LEFT JOIN "public".vw_sum_si ON "public".vw_sum_si.wo_id = "public".ctr_wo_header.wo_id
                      WHERE COALESCE("public".vw_sum_per_wo.total_qty,0)-COALESCE("public".vw_sum_si.total_qty,0) >0  AND ctr_wo_header.status=2033';
                    }if($source=='task'){
                      $qry='SELECT
                      "public".ctr_wo_header.wo_number,
                      "public".ctr_wo_header.dept_id,
                      "public".adm_wkf_activity.awa_name,
                      "public".ctr_contract_header.contract_number,
                      "public".ctr_si_header.si_number,
                      "public".ctr_wo_header.wo_notes,
                      "public".ctr_wo_header.vendor_name,
                      "public".ctr_wo_header.created_date,
                      "public".ctr_wo_header.wo_id,
                      "public".ctr_si_header.si_id,
                      "public".ctr_si_header.status
                      FROM
                      "public".ctr_wo_header
                      INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id
                      LEFT JOIN "public".ctr_si_header ON "public".ctr_si_header.wo_id = "public".ctr_wo_header.wo_id
                      LEFT JOIN "public".adm_wkf_activity ON "public".ctr_si_header.status = "public".adm_wkf_activity.awa_id
                      WHERE ctr_wo_header.wo_number is not null AND "public".ctr_si_header.status<>2042 OR ctr_si_header.status is null';

                    }elseif($source=='monitor'){
                      $qry='SELECT
                      "public".adm_wkf_activity.awa_name,
                      "public".ctr_wo_header.wo_id,
                      "public".ctr_wo_header.wo_number,
                      "public".ctr_wo_header.dept_id,
                      "public".ctr_si_header.vendor_name,
                      "public".ctr_si_header.si_number,
                      "public".ctr_si_header.current_approver_pos,
                      "public".ctr_si_header.si_id,
                      "public".ctr_contract_header.contract_number,
                      "public".ctr_si_header.created_date ,
                      cwo_name
                      FROM
                      "public".ctr_si_header
                      INNER JOIN "public".adm_wkf_activity ON "public".ctr_si_header.status = "public".adm_wkf_activity.awa_id
                      INNER JOIN "public".ctr_wo_header ON "public".ctr_si_header.wo_id = "public".ctr_wo_header.wo_id
                      INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id
                      LEFT JOIN vw_last_activity_si ON ctr_si_header.si_id=vw_last_activity_si.si_id
                      WHERE
                      "public".ctr_wo_header.wo_id IS NOT NULL ';
                    }
                    break;

                    case 'sppm':
                    if($source=='create'){
                      $qry='SELECT
                      "public".ctr_si_header.vendor_name,
                      "public".ctr_si_header.si_notes,
                      "public".ctr_si_header.si_id,
                      "public".ctr_si_header.si_number,
                      "public".adm_wkf_activity.awa_name,
                      "public".ctr_wo_header.wo_number,
                      "public".ctr_contract_header.ptm_number,
                      "public".ctr_contract_header.contract_number,
                      "public".ctr_contract_header.contract_amount,
                      "public".ctr_wo_header.wo_total,
                      "public".ctr_contract_header.dept_id,
                      "public".vw_sum_si.total_qty AS qty_si,
                      Sum(COALESCE("public".vw_sum_sppm.total_qty,0)) AS qty_sppm,
                      Sum(COALESCE("public".vw_sum_sppm.total_price,0)) AS price_sppm,
                      "public".vw_sum_si.total_qty - Sum(COALESCE("public".vw_sum_sppm.total_qty,0)) AS remain
                      FROM
                      ((((("public".adm_wkf_activity
                        JOIN "public".ctr_si_header ON (("public".ctr_si_header.status = "public".adm_wkf_activity.awa_id)))
                        LEFT JOIN "public".ctr_wo_header ON (("public".ctr_si_header.wo_id = "public".ctr_wo_header.wo_id)))
                        JOIN "public".ctr_contract_header ON (("public".ctr_si_header.contract_id = "public".ctr_contract_header.contract_id)))))
                        LEFT JOIN "public".vw_sum_sppm ON "public".ctr_si_header.wo_id = "public".vw_sum_sppm.wo_id
                        LEFT JOIN "public".vw_sum_si ON "public".vw_sum_si.wo_id = "public".ctr_wo_header.wo_id
                        WHERE "public".ctr_si_header.wo_id IS NOT NULL
                        GROUP BY
                        "public".ctr_si_header.vendor_name,
                        "public".ctr_si_header.si_notes,
                        "public".adm_wkf_activity.awa_name,
                        "public".ctr_si_header.si_id,
                        "public".ctr_si_header.si_number,
                        "public".ctr_wo_header.wo_number,
                        "public".ctr_contract_header.ptm_number,
                        "public".ctr_contract_header.contract_number,
                        "public".ctr_contract_header.contract_amount,
                        "public".ctr_wo_header.wo_total,
                        "public".ctr_contract_header.dept_id,
                        "public".vw_sum_si.total_qty
                        HAVING "public".vw_sum_si.total_qty - Sum(COALESCE("public".vw_sum_sppm.total_qty,0))>0
                        ';
                      }elseif($source=='task'  ){
                        $qry='SELECT
                        "public".ctr_wo_header.wo_number,
                        "public".ctr_si_header.si_number,
                        null as sppm_number,
                        "public".ctr_si_header.vendor_name,
                        null AS awa_name,
                        "public".ctr_si_header.created_date,
                        "public".ctr_contract_header.contract_number,
                        "public".ctr_si_header.si_id AS id,
                        "public".ctr_si_header.status,
                        1 as ord
                        FROM
                        ((((("public".ctr_si_comment
                          JOIN "public".ctr_si_header ON (("public".ctr_si_comment.si_id = "public".ctr_si_header.si_id)))
                          JOIN "public".ctr_wo_header ON (("public".ctr_si_header.wo_id = "public".ctr_wo_header.wo_id)))))
                          JOIN "public".ctr_contract_header ON (("public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id)))
                          WHERE
                          ("public".ctr_si_comment.cwo_name IS NULL
                            AND ctr_si_header.current_approver_id='.$userdata.'
                          )
                          UNION
                          SELECT ctr_wo_header.wo_number,
                          ctr_si_header.si_number,
                          ctr_sppm_header.sppm_number,
                          ctr_wo_header.vendor_name,
                          adm_wkf_activity.awa_name,
                          ctr_si_header.created_date,
                          ctr_contract_header.contract_number,
                          ctr_sppm_header.sppm_id AS id,
                          ctr_sppm_header.status,
                          0 as ord
                          FROM ((((ctr_wo_header
                            JOIN ctr_contract_header ON ((ctr_wo_header.contract_id = ctr_contract_header.contract_id)))
                            LEFT JOIN ctr_si_header ON ((ctr_si_header.wo_id = ctr_wo_header.wo_id)))
                            LEFT JOIN ctr_sppm_header ON ((ctr_sppm_header.wo_id = ctr_si_header.wo_id)))
                            LEFT JOIN adm_wkf_activity ON ((ctr_sppm_header.status = adm_wkf_activity.awa_id)))
                            WHERE ((ctr_wo_header.wo_number IS NOT NULL) AND (ctr_sppm_header.status <> ALL (ARRAY[2051, 2052,2053])))
                            AND ctr_sppm_header.current_approver_id='.$userdata;

                          }elseif($source=='monitor'  ){
                            $qry='SELECT
                            "public".ctr_wo_header.wo_number,
                            "public".ctr_wo_header.dept_id,
                            "public".adm_wkf_activity.awa_name,
                            "public".ctr_contract_header.contract_number,
                            "public".ctr_si_header.si_number,
                            "public".ctr_sppm_header.current_approver_pos,
                            "public".ctr_wo_header.wo_notes,
                            "public".ctr_wo_header.vendor_name,
                            "public".ctr_sppm_header.created_date,
                            "public".ctr_wo_header.wo_id,
                            "public".ctr_si_header.si_id,
                            "public".ctr_sppm_header.sppm_number,
                            "public".ctr_sppm_header.sppm_id,
                            "public".ctr_sppm_header.status
                            FROM

                            "public".ctr_wo_header
                            INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id
                            LEFT JOIN "public".ctr_si_header ON "public".ctr_si_header.wo_id = "public".ctr_wo_header.wo_id
                            LEFT JOIN "public".ctr_sppm_header ON "public".ctr_sppm_header.wo_id = "public".ctr_si_header.wo_id
                            LEFT JOIN "public".adm_wkf_activity ON "public".ctr_sppm_header.status = "public".adm_wkf_activity.awa_id
                            WHERE
                            "public".ctr_wo_header.wo_number IS NOT null
                            AND sppm_number is not null';
                          }
                          break;

                          case 'approval_sppm':
                          if($source=='monitor' || $source=='task'  ){
                            $qry=' SELECT ctr_contract_header.ptm_number,
                            ctr_contract_header.contract_number,
                            ctr_contract_header.contract_amount,
                            ctr_sppm_header.sppm_number,
                            ctr_sppm_header.creator_employee,
                            ctr_sppm_header.creator_pos,
                            ctr_sppm_header.contract_id,
                            ctr_sppm_header.vendor_id,
                            ctr_sppm_header.created_date,
                            ctr_sppm_header.sppm_notes,
                            ctr_sppm_header.sppm_id,
                            ctr_sppm_header.sppm_date,
                            ctr_sppm_header.wo_id,
                            ctr_sppm_header.tgl_expected_delivery,
                            ctr_sppm_header.sppm_title,
                            ctr_sppm_header.sppm_total,
                            ctr_wo_header.wo_number,
                            ctr_wo_header.dept_id,
                            ctr_contract_header.vendor_name,
                            vw_sum_sppm.total_qty AS sppm_qty,
                            vw_sum_sppm.total_price AS sppm_price,
                            vw_sum_si.total_qty AS wo_qty,
                            vw_sum_si.total_price AS wo_price,
                            vw_sum_si.si_number,
                            (vw_sum_si.total_qty - vw_sum_sppm.total_qty) AS remain,
                            ctr_wo_header.wo_notes,
                            ctr_sppm_header.status,
                            adm_wkf_activity.awa_name,
                            COALESCE(vw_sum_sppm_do.qty_do, vw_sum_sppm_do.qty_do, (0)::numeric) AS do_qty,
                            (vw_sum_sppm.total_qty - COALESCE(vw_sum_sppm_do.qty_do, vw_sum_sppm_do.qty_do, (0)::numeric)) AS do_remain
                            FROM ((((((ctr_contract_header
                              JOIN ctr_sppm_header ON ((ctr_sppm_header.contract_id = ctr_contract_header.contract_id)))
                              JOIN ctr_wo_header ON ((ctr_sppm_header.wo_id = ctr_wo_header.wo_id)))
                              JOIN vw_sum_sppm ON ((vw_sum_sppm.sppm_id = ctr_sppm_header.sppm_id)))
                              JOIN vw_sum_si ON ((vw_sum_sppm.wo_id = vw_sum_si.wo_id)))
                              JOIN adm_wkf_activity ON ((ctr_sppm_header.status = adm_wkf_activity.awa_id)))
                              LEFT JOIN vw_sum_sppm_do ON (((vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id)
                              AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id)
                              AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id)
                              AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id)
                              AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id)
                              AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id)))) WHERE ctr_sppm_header.wo_id is not null';
                            };
                            break;

                            case 'do':
                            if($source=='monitor' ){
                              $qry='SELECT
                              "public".ctr_do_header.do_number,
                              "public".ctr_do_header.creator_employee,
                              "public".ctr_do_header.creator_pos,
                              "public".ctr_do_header.contract_id,
                              "public".ctr_do_header.vendor_id,
                              "public".ctr_do_header.currency,
                              "public".ctr_do_header.created_date,
                              "public".ctr_do_header.do_notes,
                              "public".ctr_do_header.sppm_id,
                              "public".ctr_do_header.wo_id,
                              "public".ctr_do_header.do_id,
                              "public".ctr_do_header.do_title,
                              "public".ctr_do_header.status,
                              "public".ctr_do_header.do_total,
                              "public".adm_wkf_activity.awa_name,
                              "public".vw_sum_do.total_qty,
                              "public".vw_sum_do.total_price,
                              "public".ctr_contract_header.contract_number,
                              "public".ctr_wo_header.wo_number,
                              "public".ctr_wo_header.vendor_name,
                              "public".ctr_do_header.current_approver_pos,
                              "public".ctr_sppm_header.sppm_number,
                              "public".ctr_si_header.si_number
                              FROM
                              (((("public".ctr_do_header
                                JOIN "public".adm_wkf_activity ON (("public".ctr_do_header.status = "public".adm_wkf_activity.awa_id)))
                                JOIN "public".vw_sum_do ON (("public".vw_sum_do.do_id = "public".ctr_do_header.do_id)))
                                JOIN "public".ctr_contract_header ON (("public".ctr_do_header.contract_id = "public".ctr_contract_header.contract_id)))
                                JOIN "public".ctr_wo_header ON (("public".ctr_do_header.wo_id = "public".ctr_wo_header.wo_id)))
                                INNER JOIN "public".ctr_sppm_header ON "public".vw_sum_do.sppm_id = "public".ctr_sppm_header.sppm_id
                                INNER JOIN "public".ctr_si_header ON "public".ctr_sppm_header.si_id = "public".ctr_si_header.si_id
                                WHERE
                                "public".ctr_wo_header.wo_id IS NOT NULL
                                ';
                              }
                              break;

                              case 'sj':
                              if($source=='monitor' ){
                                $qry='SELECT
                                ctr_sj_header.sj_number,
                                ctr_sj_header.creator_employee,
                                ctr_sj_header.creator_pos,
                                ctr_sj_header.contract_id,
                                ctr_sj_header.vendor_id,
                                ctr_sj_header.currency,
                                ctr_sj_header.created_date,
                                ctr_sj_header.sj_notes,
                                ctr_sj_header.sj_id,
                                ctr_sj_header.wo_id,
                                ctr_sj_header.do_id,
                                ctr_sj_header.transporter_id,
                                ctr_sj_header.si_id,
                                ctr_sj_header.tgl_pembuatan_sj,
                                ctr_sj_header.tgl_pengiriman_sj,
                                ctr_sj_header.judul_sj,
                                ctr_sj_header.status,
                                ctr_sj_header.no_mobil,
                                ctr_sj_header.sj_total,
                                adm_wkf_activity.awa_name,
                                ctr_contract_header.contract_number,
                                ctr_do_header.do_number,
                                vnd_header.vendor_name AS transporter_name,
                                vw_sum_sj.total_qty AS qty_sj,
                                vw_sum_sj.total_price AS price_sj,
                                ctr_wo_header.wo_number,
                                ctr_wo_header.vendor_name,
                                ctr_sj_header.current_approver_pos,
                                ctr_sppm_header.sppm_number,
                                ctr_si_header.si_number
                                FROM
                                ((((((((
                                  ctr_sj_header
                                  JOIN adm_wkf_activity ON ((
                                    ctr_sj_header.status = adm_wkf_activity.awa_id
                                  )))
                                  LEFT JOIN ctr_contract_header ON ((
                                    ctr_sj_header.contract_id = ctr_contract_header.contract_id
                                  )))
                                  LEFT JOIN ctr_do_header ON ((
                                    ctr_sj_header.do_id = ctr_do_header.do_id
                                  )))
                                  LEFT JOIN ctr_sppm_header ON ((
                                    ctr_sppm_header.sppm_id = ctr_do_header.sppm_id
                                  )))
                                  LEFT JOIN ctr_si_header ON ((
                                    ctr_sppm_header.si_id = ctr_si_header.si_id
                                  )))
                                  LEFT JOIN vnd_header ON ((
                                    ctr_sj_header.transporter_id = vnd_header.vendor_id
                                  )))
                                  JOIN vw_sum_sj ON ((
                                    ctr_sj_header.sj_id = vw_sum_sj.sj_id
                                  )))
                                  JOIN ctr_wo_header ON ((
                                    ctr_sj_header.wo_id = ctr_wo_header.wo_id
                                  )))
                                  WHERE
                                  ctr_wo_header.wo_id IS NOT NULL';
                                }
                                break;

                                case 'bapb':
                                if($source=='create'){
                                  $qry='SELECT DISTINCT
                                  "public".ctr_contract_header.ptm_number,
                                  "public".ctr_contract_header.contract_number,
                                  "public".ctr_contract_header.vendor_name,
                                  "public".ctr_wo_header.wo_number,
                                  "public".ctr_wo_header.wo_id,
                                  "public".ctr_wo_header.wo_notes,
                                  "public".vw_sum_sj_total.total_qty AS qty_sj,
                                  "public".vw_sum_sj_total.total_price AS price_sj,
                                  "public".adm_wkf_activity.awa_name,
                                  "public".ctr_contract_header.subject_work,
                                  "public".vw_sum_bapb.total_qty AS qty_bapb,
                                  COALESCE("public".vw_sum_bapb.total_price,0) AS qty_price,
                                  COALESCE("public".vw_sum_sj_total.total_qty,0)- COALESCE("public".vw_sum_bapb.total_qty,0) AS remain
                                  FROM
                                  "public".ctr_sj_header
                                  INNER JOIN "public".ctr_contract_header ON "public".ctr_sj_header.contract_id = "public".ctr_contract_header.contract_id
                                  INNER JOIN "public".ctr_wo_header ON "public".ctr_sj_header.wo_id = "public".ctr_wo_header.wo_id
                                  INNER JOIN "public".vw_sum_sj_total ON "public".ctr_sj_header.wo_id = "public".vw_sum_sj_total.wo_id
                                  INNER JOIN "public".adm_wkf_activity ON "public".ctr_sj_header.status = "public".adm_wkf_activity.awa_id
                                  LEFT JOIN "public".vw_sum_bapb ON "public".vw_sum_bapb.wo_id = "public".ctr_wo_header.wo_id
                                  WHERE
                                  "public".ctr_wo_header.wo_id IS NOT NULL
                                  ';
                                }elseif($source=='monitor'){
                                  $qry='SELECT
                                  "public".ctr_bapb_header.bapb_number,
                                  "public".ctr_bapb_header.creator_employee,
                                  "public".ctr_bapb_header.creator_pos,
                                  "public".ctr_bapb_header.contract_id,
                                  "public".ctr_bapb_header.vendor_id,
                                  "public".ctr_bapb_header.currency,
                                  "public".ctr_bapb_header.created_date,
                                  "public".ctr_bapb_header.bapb_notes,
                                  "public".ctr_bapb_header.status,
                                  "public".ctr_bapb_header.wo_id,
                                  "public".ctr_bapb_header.bapb_id,
                                  "public".ctr_bapb_header.bapb_title,
                                  "public".ctr_bapb_header.tgl_pembuatan_bapb,
                                  "public".ctr_bapb_header.tgl_penerimaan_bapb,
                                  "public".ctr_contract_header.contract_number,
                                  "public".ctr_wo_header.wo_number,
                                  "public".adm_wkf_activity.awa_name,
                                  "public".ctr_wo_header.vendor_name,
                                  "public".ctr_wo_header.ctr_skbdn_no,
                                  ctr_bapb_header.current_approver_pos,
                                  ctr_si_header.si_number,
                                  ctr_sppm_header.sppm_number,
                                  ctr_sj_header.sj_number,
                                  ctr_do_header.do_number
                                  FROM
                                  ((((((
                                    "public".ctr_bapb_header
                                    JOIN "public".ctr_contract_header ON ((
                                      "public".ctr_bapb_header.contract_id = "public".ctr_contract_header.contract_id
                                    )))
                                    JOIN "public".ctr_wo_header ON ((
                                      "public".ctr_bapb_header.wo_id = "public".ctr_wo_header.wo_id
                                    )))
                                    JOIN "public".ctr_sj_header ON ((
                                      "public".ctr_bapb_header.sj_id = "public".ctr_sj_header.sj_id
                                    )))
                                    LEFT JOIN ctr_si_header ON ((
                                      ctr_si_header.wo_id = ctr_wo_header.wo_id
                                    )))
                                    LEFT JOIN ctr_sppm_header ON ((
                                      ctr_sppm_header.si_id = ctr_si_header.si_id
                                    )))
                                    LEFT JOIN ctr_do_header ON ((
                                      ctr_do_header.sppm_id = ctr_sppm_header.sppm_id
                                    )))
                                    INNER JOIN "public".adm_wkf_activity ON "public".ctr_bapb_header.status = "public".adm_wkf_activity.awa_id
                                    WHERE
                                    "public".ctr_wo_header.wo_id IS NOT NULL ';
                                  }else{
                                    $qry='SELECT
                                    "public".ctr_bapb_header.bapb_number,
                                    "public".ctr_bapb_header.creator_employee,
                                    "public".ctr_bapb_header.creator_pos,
                                    "public".ctr_bapb_header.contract_id,
                                    "public".ctr_bapb_header.vendor_id,
                                    "public".ctr_bapb_header.currency,
                                    "public".ctr_bapb_header.created_date,
                                    "public".ctr_bapb_header.bapb_notes,
                                    "public".ctr_bapb_header.status,
                                    "public".ctr_bapb_header.wo_id,
                                    "public".ctr_bapb_header.bapb_id,
                                    "public".ctr_bapb_header.bapb_title,
                                    "public".ctr_bapb_header.tgl_pembuatan_bapb,
                                    "public".ctr_bapb_header.tgl_penerimaan_bapb,
                                    "public".ctr_contract_header.contract_number,
                                    "public".ctr_wo_header.wo_number,
                                    "public".adm_wkf_activity.awa_name,
                                    "public".ctr_wo_header.vendor_name,
                                    "public".ctr_wo_header.ctr_skbdn_no
                                    FROM
                                    (("public".ctr_bapb_header
                                      JOIN "public".ctr_contract_header ON (("public".ctr_bapb_header.contract_id = "public".ctr_contract_header.contract_id)))
                                      JOIN "public".ctr_wo_header ON (("public".ctr_bapb_header.wo_id = "public".ctr_wo_header.wo_id)))
                                      INNER JOIN "public".adm_wkf_activity ON "public".ctr_bapb_header.status = "public".adm_wkf_activity.awa_id
                                      WHERE
                                      "public".ctr_wo_header.wo_id IS NOT null';
                                    }
                                    break;

                                    case "inv":
                                    if($source=='task'){
                                      $qry='SELECT
                                      "public".ctr_inv_header.inv_number,
                                      "public".ctr_inv_header.creator_employee,
                                      "public".ctr_inv_header.creator_pos,
                                      "public".ctr_inv_header.contract_id,
                                      "public".ctr_inv_header.currency,
                                      "public".ctr_inv_header.created_date,
                                      "public".ctr_inv_header.inv_notes,
                                      "public".ctr_inv_header.status,
                                      "public".ctr_inv_header.wo_id,
                                      "public".ctr_inv_header.inv_title,
                                      "public".ctr_inv_header.tgl_inv,
                                      "public".ctr_inv_header.inv_total,
                                      "public".ctr_inv_header.bapb_id,
                                      "public".ctr_inv_header.inv_id,
                                      "public".ctr_inv_header.bank,
                                      "public".ctr_inv_header.no_rekening,
                                      "public".ctr_inv_header.vendor_id,
                                      "public".ctr_inv_header.current_approver_id,
                                      "public".ctr_inv_header.current_approver_pos,
                                      "public".ctr_wo_header.wo_number,
                                      "public".ctr_contract_header.contract_number,
                                      "public".ctr_wo_header.ctr_skbdn_no,
                                      "public".ctr_wo_header.vendor_name,
                                      "public".adm_wkf_activity.awa_name
                                      FROM
                                      "public".ctr_inv_header
                                      INNER JOIN "public".ctr_wo_header ON "public".ctr_inv_header.wo_id = "public".ctr_wo_header.wo_id
                                      INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id
                                      INNER JOIN "public".adm_wkf_activity ON "public".ctr_inv_header.status = "public".adm_wkf_activity.awa_id
                                      WHERE "public".ctr_inv_header.inv_number IS NOT null AND "public".ctr_inv_header.status<>2093';
                                    }elseif($source=='monitor'){
                                      $qry='SELECT
                                      "public".ctr_inv_header.inv_number,
                                      "public".ctr_inv_header.creator_employee,
                                      "public".ctr_inv_header.creator_pos,
                                      "public".ctr_inv_header.contract_id,
                                      "public".ctr_inv_header.currency,
                                      "public".ctr_inv_header.created_date,
                                      "public".ctr_inv_header.inv_notes,
                                      "public".ctr_inv_header.status,
                                      "public".ctr_inv_header.wo_id,
                                      "public".ctr_inv_header.inv_title,
                                      "public".ctr_inv_header.tgl_inv,
                                      "public".ctr_inv_header.inv_total,
                                      "public".ctr_inv_header.bapb_id,
                                      "public".ctr_inv_header.inv_id,
                                      "public".ctr_inv_header.bank,
                                      "public".ctr_inv_header.no_rekening,
                                      "public".ctr_inv_header.vendor_id,
                                      "public".ctr_inv_header.current_approver_id,
                                      "public".ctr_inv_header.current_approver_pos,
                                      "public".ctr_wo_header.wo_number,
                                      "public".ctr_contract_header.contract_number,
                                      "public".ctr_wo_header.ctr_skbdn_no,
                                      "public".ctr_wo_header.vendor_name,
                                      "public".adm_wkf_activity.awa_name,
                                      "public".ctr_bapb_header.bapb_number,
                                      "public".ctr_sj_header.sj_number,
                                      "public".ctr_do_header.do_number,
                                      "public".ctr_sppm_header.sppm_number,
                                      "public".ctr_si_header.si_number
                                      FROM
                                      "public".ctr_inv_header
                                      INNER JOIN "public".ctr_wo_header ON "public".ctr_inv_header.wo_id = "public".ctr_wo_header.wo_id
                                      INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id
                                      INNER JOIN "public".adm_wkf_activity ON "public".ctr_inv_header.status = "public".adm_wkf_activity.awa_id
                                      INNER JOIN "public".ctr_bapb_header ON "public".ctr_inv_header.bapb_id = "public".ctr_bapb_header.bapb_id
                                      INNER JOIN "public".ctr_sj_header ON "public".ctr_bapb_header.sj_id = "public".ctr_sj_header.sj_id
                                      INNER JOIN "public".ctr_do_header ON "public".ctr_sj_header.do_id = "public".ctr_do_header.do_id
                                      INNER JOIN "public".ctr_sppm_header ON "public".ctr_do_header.sppm_id = "public".ctr_sppm_header.sppm_id
                                      INNER JOIN "public".ctr_si_header ON "public".ctr_sppm_header.si_id = "public".ctr_si_header.si_id
                                      WHERE
                                      "public".ctr_inv_header.inv_number IS NOT NULL
                                      ';
                                    }else{
                                      $qry='SELECT
                                      "public".ctr_inv_header.inv_number,
                                      "public".ctr_inv_header.creator_employee,
                                      "public".ctr_inv_header.creator_pos,
                                      "public".ctr_inv_header.contract_id,
                                      "public".ctr_inv_header.currency,
                                      "public".ctr_inv_header.created_date,
                                      "public".ctr_inv_header.inv_notes,
                                      "public".ctr_inv_header.status,
                                      "public".ctr_inv_header.wo_id,
                                      "public".ctr_inv_header.inv_title,
                                      "public".ctr_inv_header.tgl_inv,
                                      "public".ctr_inv_header.inv_total,
                                      "public".ctr_inv_header.bapb_id,
                                      "public".ctr_inv_header.inv_id,
                                      "public".ctr_inv_header.bank,
                                      "public".ctr_inv_header.no_rekening,
                                      "public".ctr_inv_header.vendor_id,
                                      "public".ctr_inv_header.current_approver_id,
                                      "public".ctr_inv_header.current_approver_pos,
                                      "public".ctr_wo_header.wo_number,
                                      "public".ctr_contract_header.contract_number,
                                      "public".ctr_wo_header.ctr_skbdn_no,
                                      "public".ctr_wo_header.vendor_name,
                                      "public".adm_wkf_activity.awa_name
                                      FROM
                                      "public".ctr_inv_header
                                      INNER JOIN "public".ctr_wo_header ON "public".ctr_inv_header.wo_id = "public".ctr_wo_header.wo_id
                                      INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id
                                      INNER JOIN "public".adm_wkf_activity ON "public".ctr_inv_header.status = "public".adm_wkf_activity.awa_id
                                      WHERE "public".ctr_inv_header.inv_number IS NOT null';
                                    }
                                    break;


                                    default:
                                    break;
                                  }
                                  foreach ($params as $value) {
                                    $qry.=' AND '.$value;
                                  }
                                  $qry.=$order;
                                  //print_r($qry);die;
                                  return $this->db->query($qry);
                                }

                                function get_spk($department_code){
                                  $qry="SELECT * FROM project_info WHERE kddivisi='".$department_code."'";
                                  return $this->db->query($qry)->result_array();
                                }

                                function get_doc_type(){
                                  return $this->db->get('ctr_doc_matgis_type');
                                }
                              }
