<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function query_efisien_total($dept='', $date='')
	{
		$strwhere = '';
		if ($dept != '') {
			$strwhere .= "ptm_dept_id = ".$dept." AND ";
		}

		if ($date != '') {
			$d = explode(' - ', $date);
			$strwhere .= "(tanggal_penunjukan > '".$d[0]."' AND tanggal_penunjukan <= '".$d[1]."') AND ";
		}


		$sql = "
		SELECT sum(vw_efisiensi_detail.hps) AS hps,
		sum(vw_efisiensi_detail.contract_amount) AS total_contract,
			CASE
				WHEN sum(vw_efisiensi_detail.hps) > sum(vw_efisiensi_detail.contract_amount)::double precision THEN sum(vw_efisiensi_detail.hps) - sum(vw_efisiensi_detail.contract_amount)::double precision
				ELSE 0::double precision
			END AS efisiensi,
			CASE
				WHEN sum(vw_efisiensi_detail.hps) > sum(vw_efisiensi_detail.contract_amount)::double precision THEN (sum(vw_efisiensi_detail.hps) - sum(vw_efisiensi_detail.contract_amount)::double precision) / sum(vw_efisiensi_detail.hps) * 100::double precision
				ELSE 0::double precision
			END AS efisiensi_percent,
			CASE
				WHEN sum(vw_efisiensi_detail.hps) < sum(vw_efisiensi_detail.contract_amount)::double precision THEN sum(vw_efisiensi_detail.contract_amount)::double precision - sum(vw_efisiensi_detail.hps)
				ELSE 0::double precision
			END AS inefisiensi,
			CASE
				WHEN sum(vw_efisiensi_detail.hps) < sum(vw_efisiensi_detail.contract_amount)::double precision THEN (sum(vw_efisiensi_detail.contract_amount)::double precision - sum(vw_efisiensi_detail.hps)) / sum(vw_efisiensi_detail.hps) * 100::double precision
				ELSE 0::double precision
			END AS inefisiensi_percent
		FROM vw_efisiensi_detail
		WHERE $strwhere 1=1
		";

		return $this->db->query($sql)->row_array();
	}

	public function query_rfq($dept='', $date='', $state ='')
	{
		$strwhere = '';
		if ($dept != '') {
			$strwhere .= "ptm_dept_id = ".$dept." AND ";
		}

		if ($date != '') {
			$d = explode(' - ', $date);
			$strwhere .= "(ptm_created_date > '".$d[0]."' AND ptm_created_date <= '".$d[1]."') AND ";
		}

		$stat = $state != 1901 ? '> '. $state : '< '. $state;
		$sql = "
			SELECT count(*)
			FROM vw_prc_monitor
			WHERE ptm_status $stat
			AND $strwhere 1=1
		";

		return $this->db->query($sql)->row_array();
	}

	public function query_vend($date='')
	{
		$strwhere = '';
		if ($date != '') {
			$d = explode(' - ', $date);
			$strwhere .= "(creation_date > '".$d[0]."' AND creation_date <= '".$d[1]."') AND ";
		}

		$sql = "
			SELECT count(*)
			FROM vw_vnd_header
			WHERE status = '9'
			AND $strwhere 1=1
		";

		return $this->db->query($sql)->row_array();
	}

	public function chart_vend_active($date='')
	{
		$strwhere = '';
		if ($date != '') {
			$d = explode(' - ', $date);
			$strwhere .= "(creation_date > '".$d[0]."' AND creation_date <= '".$d[1]."') AND ";
		}

		$sql = "
			SELECT
				vw_vnd_header.reg_status_name as vendor_status,
				count(vw_vnd_header.vendor_id) as jml
			FROM
				vw_vnd_header
			WHERE
				vw_vnd_header.reg_status_name is not null
				AND $strwhere 1=1
			GROUP BY
				vw_vnd_header.reg_status_name
		";

		return $this->db->query($sql)->result_array();
	}

	public function chart_pie_efisiensi($dept='', $date='')
	{
		$strwhere = '';
		if ($dept != '') {
			$strwhere .= "ptm_dept_id = ".$dept." AND ";
		}

		if ($date != '') {
			$d = explode(' - ', $date);
			$strwhere .= "(ptm_created_date > '".$d[0]."' AND ptm_created_date <= '".$d[1]."') AND ";
		}

		$sql = "
			SELECT
				sum(contract_amount) as total_contract,
				sum(hps) as hps,
				sum(efisiensi) as efisiensi,
				sum(inefisiensi) as inefisiensi
			FROM
				vw_efisiensi_new
			WHERE $strwhere 1=1
		";

		return $this->db->query($sql)->result();
	}

	public function query_hari_pengadaan($date='')
	{
		$strwhere = '';
		if ($date != '') {
			$d = explode(' - ', $date);
			$strwhere .= "(ptp_uskep_date > '".$d[0]."' AND ptp_uskep_date <= '".$d[1]."') AND ";
		}

		$chk = "
			SELECT
				prc_tender_prep.ptp_tender_method,
				CASE
					prc_tender_prep.ptp_tender_method
					WHEN 0 THEN 'Penunjukkan Langsung'::text
					WHEN 1 THEN 'Pemilihan Langsung'::text
					WHEN 2 THEN 'Pelelangan'::text
					ELSE '-'::text
				END as metode,
				CONCAT(nullif(round(avg((date_part('day'::text, prc_tender_main.ptm_completed_date - prc_tender_main.ptm_created_date) + 1::double precision)::integer), 0), 0::numeric), ' hari') as av
			FROM
				prc_tender_prep
			LEFT JOIN prc_tender_main on
				prc_tender_prep.ptm_number::text = prc_tender_main.ptm_number::text
			WHERE
				prc_tender_prep.ptp_tender_method is not null
				AND prc_tender_main.ptm_completed_date is not null
				AND prc_tender_main.ptm_status <> 1902
				AND prc_tender_main.ptm_number::text <> 'RFQ.201811.00017'::text
				AND ptp_tender_method = 1
				AND $strwhere 1=1
			GROUP BY
				prc_tender_prep.ptp_tender_method
		";

		if ($this->db->query($chk)->row()) {
			$sql = "
				SELECT
					prc_tender_prep.ptp_tender_method,
					CASE
						prc_tender_prep.ptp_tender_method
						WHEN 0 THEN 'Penunjukkan Langsung'::text
						WHEN 1 THEN 'Pemilihan Langsung'::text
						WHEN 2 THEN 'Pelelangan'::text
						ELSE '-'::text
					END as metode,
					CONCAT(nullif(round(avg((date_part('day'::text, prc_tender_main.ptm_completed_date - prc_tender_main.ptm_created_date) + 1::double precision)::integer), 0), 0::numeric), ' hari') as av
				FROM
					prc_tender_prep
				LEFT JOIN prc_tender_main on
					prc_tender_prep.ptm_number::text = prc_tender_main.ptm_number::text
				WHERE
					prc_tender_prep.ptp_tender_method is not null
					AND prc_tender_main.ptm_completed_date is not null
					AND prc_tender_main.ptm_status <> 1902
					AND prc_tender_main.ptm_number::text <> 'RFQ.201811.00017'::text
					AND $strwhere 1=1
				GROUP BY
					prc_tender_prep.ptp_tender_method
			";

			$av = $this->db->query($sql)->row()->av;
			$ar = explode(' ', $av);

			return $ar[0].' '.ucfirst($ar[1]);
		} else {
			return '';
		}
	}

	public function nilai_kontrak($date='')
	{
		$strwhere = '';
		if ($date != '') {
			$d = explode(' - ', $date);
			$strwhere .= "(sign_date > '".$d[0]."' AND sign_date <= '".$d[1]."') AND ";
		}

		$sql = "
			SELECT SUM(contract_amount) total
			FROM ctr_contract_header
			WHERE $strwhere 1=1
		";

		return $this->db->query($sql)->row('total');
	}

	public function chart_nilai_kontrak($year = '')
	{
		$y = $year != '' ? $year : date('Y');
		$sql = "
			SELECT
				SUM(contract_amount) as amount,
				extract(month from sign_date) as month
			FROM
				ctr_contract_header
			WHERE
				extract(year from sign_date) = $y
			GROUP BY
				month
		";

		return $this->db->query($sql)->result_array();

	}

	public function chart_nilai_kontrak_detail($month, $year)
	{
		$sql = "
			select
				ptm_number,
				sum(contract_amount) nilai,
				sign_date
			from
				ctr_contract_header
			where
				extract(year from sign_date) = '$year' and extract(month from sign_date) = '$month'
			group by
				ptm_number,sign_date
		";

		return $this->db->query($sql)->result_array();
	}

	public function chart_umkm($date)
	{
		$strwhere = '';
		if ($date != '') {
			$d = explode(' - ', $date);
			$strwhere .= "(sign_date > '".$d[0]."' AND sign_date <= '".$d[1]."') AND ";
		}

		$sql = "
			SELECT cch.vendor_id, cch.vendor_name, SUM(contract_amount) nilai , vh.fin_class, vh.status
			FROM ctr_contract_header cch
			JOIN vnd_header vh on cch.vendor_id = vh.vendor_id AND vh.fin_class in ('K','M') AND vh.status = '9'
			WHERE $strwhere 1=1
			GROUP BY cch.vendor_id, cch.vendor_name, vh.fin_class, vh.status
			ORDER BY nilai DESC LIMIT 10
		";

		return $this->db->query($sql)->result_array();
	}

	public function get_umkm_detail($id)
	{
		$sql = "
			SELECT vendor_id, vendor_name, contact_email, contact_name, contact_phone_no, address_street, address_postcode, addres_prop
			FROM vnd_header WHERE vendor_id = $id
		";

		return $this->db->query($sql)->row_array();
	}
}
