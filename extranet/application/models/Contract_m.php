<?php if (!defined('BASEPATH')) {
  exit('No direct script access allowed');
}

class Contract_m extends CI_Model
{
  public function number_exist($table, $number)
  {
    switch ($table) {
      case 'ctr_wo_header':
      $this->db->where('wo_number', $number);
      break;
      case 'ctr_do_header':
      $this->db->where('do_number', $number);
      break;
      case 'ctr_sj_header':
      $this->db->where('sj_number', $number);
      break;
      case 'ctr_bapb_header':
      $this->db->where('bapb_number', $number);
      break;
      case 'ctr_inv_header':
      $this->db->where('inv_number', $number);
      break;
      default:
      $this->db->where('id', $id);
      break;
    }
    $hsl = $this->db->get($table);
    //echo $this->db->last_query();die;
    if ($hsl->num_rows() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function get_po_matgis_approve($vendorId)
  {
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
    "public".ctr_wo_header.spk_name,
    "public".ctr_contract_header.contract_number
    FROM
    ctr_wo_header
    INNER JOIN ctr_contract_header ON ctr_wo_header.contract_id = ctr_contract_header.contract_id
    Where ctr_wo_header.status=2038 AND ctr_wo_header.vendor_id='.$vendorId;
    $sql = $this->db->query($qry)->result_array();
    //echo $this->db->last_query();die;
    return $sql;
  }

  public function get_wo_matgis($vendorId = "")
  {
    $qry = 'SELECT
    "public".ctr_wo_header.wo_id,
    "public".ctr_wo_header.wo_number,
    "public".ctr_wo_header.vendor_id,
    "public".ctr_wo_header.vendor_name,
    "public".ctr_wo_header.currency,
    "public".ctr_wo_header.start_date,
    "public".ctr_wo_header.end_date,
    "public".ctr_wo_header.created_date,
    "public".ctr_wo_header.wo_notes,
    "public".ctr_contract_header.contract_number,
    "public".ctr_wo_comment.cwo_end_date,
    "public".ctr_wo_comment.cwo_position,
    "public".ctr_wo_comment.cwo_name,
    "public".ctr_wo_comment.cwo_activity,
    "public".ctr_wo_comment.cwo_start_date,
    "public".ctr_wo_comment.cwo_response,
    "public".ctr_contract_header.contract_type,
    "public".adm_wkf_activity.awa_name AS activity
    FROM
    "public".ctr_wo_header
    INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id
    INNER JOIN "public".ctr_wo_comment ON "public".ctr_wo_header.wo_id = "public".ctr_wo_comment.wo_id
    INNER JOIN "public".adm_wkf_activity ON "public".ctr_wo_comment.cwo_activity = "public".adm_wkf_activity.awa_id
    WHERE
    "public".ctr_wo_comment.cwo_activity = (SELECT val_num FROM adm_settings WHERE identifier="_ACT_WO_MATGIS_ACTIVE")';
    $sql = $this->db->query($qry)->result_array();
    return $sql;
  }

  public function get_si_matgis($transporterId = '', $activity = 2042)
  {
    $qry = 'SELECT
    "public".ctr_si_header.creator_employee,
    "public".ctr_si_header.creator_pos,
    "public".ctr_si_header.contract_id,
    "public".ctr_si_header.vendor_id,
    "public".ctr_si_header.vendor_name,
    "public".ctr_si_header.currency,
    "public".ctr_si_header.created_date,
    "public".ctr_si_header.status,
    "public".ctr_si_header.si_id,
    "public".ctr_si_header.si_number,
    "public".ctr_si_header.delivery_address,
    "public".ctr_si_header.wo_id,
    "public".ctr_si_header.si_notes,
    "public".ctr_si_header.vendor_pic,
    "public".ctr_si_header.delivery_name,
    "public".ctr_si_header.delivery_pic,
    "public".ctr_si_header.transporter_name,
    "public".ctr_si_header.transporter_id,
    "public".ctr_si_header.transporter_pic,
    "public".ctr_si_header.transporter_address,
    "public".ctr_si_header.vendor_address,
    "public".ctr_si_header.delivery_date,
    "public".ctr_si_header.active,
    "public".ctr_si_comment.cwo_id,
    "public".ctr_si_comment.cwo_pos_code,
    "public".ctr_si_comment.cwo_position,
    "public".ctr_si_comment.cwo_name,
    "public".ctr_si_comment.cwo_activity,
    "public".ctr_si_comment.cwo_start_date,
    "public".ctr_si_comment.cwo_end_date,
    "public".ctr_si_comment.cwo_response,
    "public".ctr_si_comment.cwo_comment,
    "public".ctr_si_comment.cwo_attachment,
    "public".ctr_si_comment.cwo_user,
    "public".ctr_contract_header.contract_number
    FROM
    "public".ctr_si_header
    INNER JOIN "public".ctr_si_comment ON "public".ctr_si_comment.si_id = "public".ctr_si_header.si_id
    INNER JOIN "public".ctr_contract_header ON "public".ctr_si_header.contract_id = "public".ctr_contract_header.contract_id
    WHERE cwo_activity=' . $activity . '
    AND transporter_id=' . $transporterId;
    $sql = $this->db->query($qry)->result_array();
    return $sql;
  }
  public function get_sppm_matgis($vendorId = "", $out=2)
  {
    $qry = ' SELECT ctr_contract_header.ptm_number,
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
    vw_sum_per_wo.total_qty AS wo_qty,
    vw_sum_per_wo.total_price AS wo_price,
    (vw_sum_per_wo.total_qty - vw_sum_sppm.total_qty) AS remain,
    ctr_wo_header.wo_notes,
    ctr_sppm_header.status,
    adm_wkf_activity.awa_name,
    COALESCE(vw_sum_sppm_do.qty_do, vw_sum_sppm_do.qty_do, (0)::numeric) AS do_qty,
    (vw_sum_sppm.total_qty - COALESCE(vw_sum_sppm_do.qty_do, vw_sum_sppm_do.qty_do, (0)::numeric)) AS do_remain
    FROM ((((((ctr_contract_header
      JOIN ctr_sppm_header ON ((ctr_sppm_header.contract_id = ctr_contract_header.contract_id)))
      JOIN ctr_wo_header ON ((ctr_sppm_header.wo_id = ctr_wo_header.wo_id)))
      JOIN vw_sum_sppm ON ((vw_sum_sppm.sppm_id = ctr_sppm_header.sppm_id)))
      JOIN vw_sum_per_wo ON ((vw_sum_sppm.wo_id = vw_sum_per_wo.wo_id)))
      JOIN adm_wkf_activity ON ((ctr_sppm_header.status = adm_wkf_activity.awa_id)))
      LEFT JOIN vw_sum_sppm_do ON (((vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id) AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id) AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id) AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id) AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id) AND (vw_sum_sppm_do.sppm_id = ctr_sppm_header.sppm_id))))
      WHERE ctr_wo_header.vendor_id='.$vendorId.' AND (vw_sum_sppm.total_qty - COALESCE(vw_sum_sppm_do.qty_do, vw_sum_sppm_do.qty_do, (0)::numeric))>0
      AND ctr_sppm_header.status<>2053';
      if ($out == 2) {
        //echo "here" ;
        $sql= $this->db->query($qry)->result_array();
      } else {
        $sql= $this->db->query($qry)->num_rows();
      }


      return $sql;
    }

    public function get_do_matgis($vendorId = "", $out = "data")
    {
      $qry = 'SELECT
      "public".ctr_do_header.do_id,
      "public".ctr_do_header.do_number,
      "public".ctr_do_header.do_title,
      "public".ctr_do_header.created_date,
      "public".ctr_contract_header.contract_number,
      "public".ctr_sppm_header.tgl_expected_delivery,
      "public".adm_wkf_activity.awa_name,
      "public".ctr_wo_header.wo_number,
      "public".vw_sum_do.total_qty,
      "public".vw_sum_do.total_price,
      "public".ctr_sppm_header.sppm_number,
      SUM(COALESCE("public".vw_sum_sj.total_qty,0)) AS qty_sj,
      SUM("public".vw_sum_sj.total_price) AS price_sj,
      "public".vw_sum_do.total_qty-SUM(COALESCE("public".vw_sum_sj.total_qty,0)) remain
      FROM
      "public".ctr_do_header
      LEFT JOIN "public".ctr_contract_header ON "public".ctr_do_header.contract_id = "public".ctr_contract_header.contract_id
      LEFT JOIN "public".ctr_sppm_header ON "public".ctr_do_header.sppm_id = "public".ctr_sppm_header.sppm_id
      LEFT JOIN "public".adm_wkf_activity ON "public".ctr_do_header.status = "public".adm_wkf_activity.awa_id
      LEFT JOIN "public".ctr_wo_header ON "public".ctr_do_header.wo_id = "public".ctr_wo_header.wo_id
      LEFT JOIN "public".vw_sum_do ON "public".vw_sum_do.do_id = "public".ctr_do_header.do_id
      LEFT JOIN "public".vw_sum_sj ON "public".vw_sum_sj.do_id = "public".ctr_do_header.do_id
      WHERE ctr_do_header.status =2062
      AND ctr_do_header.vendor_id='.$vendorId.'
      GROUP BY
      "public".ctr_do_header.do_id,
      "public".ctr_do_header.do_number,
      "public".ctr_do_header.do_title,
      "public".ctr_do_header.created_date,
      "public".ctr_contract_header.contract_number,
      "public".ctr_sppm_header.tgl_expected_delivery,
      "public".adm_wkf_activity.awa_name,
      "public".ctr_wo_header.wo_number,
      "public".vw_sum_do.total_qty,
      "public".vw_sum_do.total_price,
      "public".ctr_sppm_header.sppm_number
      HAVING "public".vw_sum_do.total_qty-SUM(COALESCE("public".vw_sum_sj.total_qty,0))>0
      ';

      if ($out == 'data') {
        $sql = $this->db->query($qry)->result_array();
      } elseif ($out = 'total') {
        $sql = $this->db->query($qry)->num_rows();
      }
      //echo $this->db->last_query();die;
      return $sql;
    }

    public function get_sj_matgis($vendorId = "", $out = "data")
    {
      $qry = 'SELECT
      "public".ctr_sj_header.sj_number,
      "public".ctr_sj_header.creator_employee,
      "public".ctr_sj_header.creator_pos,
      "public".ctr_sj_header.contract_id,
      "public".ctr_sj_header.vendor_id,
      "public".ctr_sj_header.vendor_name,
      "public".ctr_sj_header.currency,
      "public".ctr_sj_header.start_date,
      "public".ctr_sj_header.end_date,
      "public".ctr_sj_header.created_date,
      "public".ctr_sj_header.sj_notes,
      "public".ctr_sj_header.sj_id,
      "public".ctr_sj_header.wo_id,
      "public".ctr_sj_header.do_id,
      "public".ctr_sj_header.transporter_id,
      "public".ctr_sj_header.si_id,
      "public".ctr_sj_header.tgl_pembuatan_sj,
      "public".ctr_sj_header.tgl_pengiriman_sj,
      "public".ctr_sj_header.judul_sj,
      "public".ctr_sj_header.status,
      "public".ctr_sj_header.no_mobil,
      "public".ctr_sj_header.sj_total,
      "public".ctr_sj_header.sppm_id,
      "public".ctr_wo_header.wo_number,
      "public".ctr_do_header.do_number,
      "public".ctr_sppm_header.sppm_number,
      "public".adm_wkf_activity.awa_name,
      "public".ctr_do_header.do_title,
      "public".ctr_contract_header.contract_number
      FROM
      "public".ctr_sj_header
      INNER JOIN "public".ctr_wo_header ON "public".ctr_sj_header.wo_id = "public".ctr_wo_header.wo_id
      INNER JOIN "public".ctr_do_header ON "public".ctr_sj_header.do_id = "public".ctr_do_header.do_id
      INNER JOIN "public".ctr_sppm_header ON "public".ctr_do_header.sppm_id = "public".ctr_sppm_header.sppm_id
      INNER JOIN "public".adm_wkf_activity ON "public".ctr_sj_header.status = "public".adm_wkf_activity.awa_id
      INNER JOIN "public".ctr_contract_header ON "public".ctr_wo_header.contract_id = "public".ctr_contract_header.contract_id

      ';

      if ($out == 'data') {
        $sql = $this->db->query($qry)->result_array();
      } elseif ($out = 'total') {
        $sql = $this->db->query($qry)->num_rows();
      }
      //echo $this->db->last_query();die;
      return $sql;
    }

    public function get_bapb_matgis($vendorId = "", $out = "data", $activity = 2083)
    {
      $qry = 'SELECT
      "public".ctr_bapb_header.creator_employee,
      "public".ctr_bapb_header.creator_pos,
      "public".ctr_bapb_header.contract_id,
      "public".ctr_bapb_header.vendor_id,
      "public".ctr_bapb_header.vendor_name,
      "public".ctr_bapb_header.currency,
      "public".ctr_bapb_header.created_date,
      "public".ctr_bapb_header.bapb_notes,
      "public".ctr_bapb_header.wo_id,
      "public".ctr_bapb_header.bapb_id,
      "public".ctr_bapb_header.bapb_title,
      "public".ctr_bapb_header.tgl_pembuatan_bapb,
      "public".ctr_bapb_header.tgl_penerimaan_bapb,
      "public".ctr_bapb_header.status,
      "public".ctr_bapb_header.bapb_number,
      "public".ctr_wo_header.wo_number,
      "public".ctr_contract_header.contract_number
      FROM
      "public".ctr_bapb_header
      INNER JOIN "public".ctr_wo_header ON "public".ctr_bapb_header.wo_id = "public".ctr_wo_header.wo_id
      INNER JOIN "public".ctr_contract_header ON "public".ctr_bapb_header.contract_id = "public".ctr_contract_header.contract_id
      INNER JOIN "public".ctr_bapb_comment ON "public".ctr_bapb_comment.bapb_id = "public".ctr_bapb_header.bapb_id
      WHERE cwo_activity=' . $activity . '
      AND ctr_bapb_header.vendor_id=' . $vendorId;
      if ($out == 'data') {
        $sql = $this->db->query($qry)->result_array();
      } elseif ($out = 'total') {
        $sql = $this->db->query($qry)->num_rows();
      }
      return $sql;
    }
    public function get_bapb_invoice_matgis($vendorId = "", $out = "data", $activity = 2082)
    {
      $qry = 'SELECT
      "public".ctr_bapb_header.creator_employee,
      "public".ctr_bapb_header.creator_pos,
      "public".ctr_bapb_header.contract_id,
      "public".ctr_bapb_header.vendor_id,
      "public".ctr_bapb_header.vendor_name,
      "public".ctr_bapb_header.currency,
      "public".ctr_bapb_header.created_date,
      "public".ctr_bapb_header.bapb_notes,
      "public".ctr_bapb_header.wo_id,
      "public".ctr_bapb_header.bapb_id,
      "public".ctr_bapb_header.bapb_title,
      "public".ctr_bapb_header.tgl_pembuatan_bapb,
      "public".ctr_bapb_header.tgl_penerimaan_bapb,
      "public".ctr_bapb_header.status,
      "public".ctr_bapb_header.sj_id,
      "public".ctr_bapb_header.bapb_number,
      "public".ctr_wo_header.wo_number,
      "public".ctr_contract_header.contract_number,
      "public".ctr_sj_header.sj_number,
      "public".adm_wkf_activity.awa_name
      FROM
      "public".ctr_bapb_header
      INNER JOIN "public".ctr_wo_header ON "public".ctr_bapb_header.wo_id = "public".ctr_wo_header.wo_id
      INNER JOIN "public".ctr_contract_header ON "public".ctr_bapb_header.contract_id = "public".ctr_contract_header.contract_id
      INNER JOIN "public".ctr_bapb_comment ON "public".ctr_bapb_comment.bapb_id = "public".ctr_bapb_header.bapb_id
      INNER JOIN "public".ctr_sj_header ON "public".ctr_sj_header.sj_id = ctr_bapb_header.sj_id
      INNER JOIN "public".adm_wkf_activity ON "public".ctr_bapb_header.status = "public".adm_wkf_activity.awa_id
      WHERE cwo_activity=' . $activity . '
      AND ctr_bapb_header.vendor_id=' . $vendorId.' AND ctr_bapb_header.inv_id is null';
      if ($out == 'data') {
        $sql = $this->db->query($qry)->result_array();
      } elseif ($out = 'total') {
        $sql = $this->db->query($qry)->num_rows();
      }
      return $sql;
    }
    public function duplicate_item_bapb_to_inv($bapb_id, $inv_id)
    {
      $qry = 'INSERT INTO "ctr_inv_item" (
        "inv_id",
        "item_code",
        "short_description",
        "long_description",
        "price",
        "qty",
        "uom",
        "sub_total",
        "ppn",
        "pph" ) SELECT
        ' . $inv_id . ',
        "item_code",
        "short_description",
        "long_description",
        "price",
        "qty",
        "uom",
        "sub_total",
        "ppn",
        "pph"
        FROM
        "ctr_bapb_item"
        WHERE
        bapb_id =' . $bapb_id;
        $sql = $this->db->query($qry);
        return ($this->db->affected_rows() > 0);
      }


    }
