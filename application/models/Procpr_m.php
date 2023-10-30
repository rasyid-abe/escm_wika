<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Procpr_m extends CI_Model
{

	public function __construct()
	{

		parent::__construct();
	}

	public function query_pmcs_hisoty($filter, $limit, $offset)
    {
        $page = '';
        if ($limit != '') {
            $page = 'LIMIT '.$limit.' OFFSET '.$offset;
        }

        $where_a = '';
        $where_b = '';
        if (count($filter) > 1) {
            if ($filter['dd'] != '') {
                $bb = explode("-",$filter['dd']);
                $where_a .= "(prc_plan_volume.created_datetime BETWEEN '".$bb[0]."' AND '".$bb[1]."') AND";
                $where_b .= "(updatedate BETWEEN '".$bb[0]."' AND '".$bb[1]."') AND";
            }

            if ($filter['search'] != '') {
                $where_a .= "(
                    vw_prc_plan_integrasi.lokasi LIKE '%".$filter['search']."%' OR
                    vw_prc_plan_integrasi.project_name LIKE '%".$filter['search']."%' OR
                    vw_prc_plan_integrasi.user_name LIKE '%".$filter['search']."%' OR
                    prc_plan_volume.ppv_no LIKE '%".$filter['search']."%'
                    ) AND ";
                    $where_b .= "(
                        lokasi LIKE '%".$filter['search']."%' OR
                        nama_spk LIKE '%".$filter['search']."%' OR
                        kasie_pengadaan LIKE '%".$filter['search']."%' OR
                        prc_plan_history.desc LIKE '%".$filter['search']."%'
                        ) AND ";
                    }
        }

        $sql = "
        SELECT
        	vw_prc_plan_integrasi.lokasi,
        	vw_prc_plan_integrasi.project_name,
        	vw_prc_plan_integrasi.user_name,
        	concat('Sudah digunakan (', prc_plan_volume.ppv_no, ')') ppv_no,
        	prc_plan_volume.ppv_remain :: FLOAT,
        	prc_plan_volume.created_datetime
        FROM
        	prc_plan_volume
        	JOIN vw_prc_plan_integrasi ON prc_plan_volume.ppv_smbd_code = vw_prc_plan_integrasi.smbd_code
        WHERE ".$where_a." ppv_no IS NOT NULL
            AND prc_plan_volume.ppv_smbd_code = '".$filter['smbd']."'
        UNION
        SELECT
            lokasi,
            nama_spk,
            kasie_pengadaan,
            prc_plan_history.desc,
            sisa_volume,
            updatedate
        FROM prc_plan_history
        WHERE ".$where_b." smbd = '".$filter['smbd']."'
        ORDER BY created_datetime desc
        $page
        ";

        return $this->db->query($sql);
    }

	public function get_prcplanintegrasi($filter, $limit, $offset)
	{
		$page = '';
        if ($limit != '') {
            $page = 'LIMIT '.$limit.' OFFSET '.$offset;
        }

		$where = '';
		if (count($filter) > 0) {
			if ($filter['divisi'] != '') {
				$where .= "project_info.kddivisi = '".$filter['divisi']."' AND ";
			}
			if ($filter['b_date'] != '') {
				$bb = explode("-",$filter['b_date']);
				$where .= "(prc_plan_integrasi.updated_date BETWEEN '".$bb[0]."' AND '".$bb[1]."') AND ";
			}
			if ($filter['period'] != '') {
				$where .= "periode_pengadaan = '".$filter['period']."-01' AND ";
			}
			if ($filter['free_text'] != '') {
				$where .= "(
					prc_plan_integrasi.smbd_code LIKE '%".$filter['free_text']."%' OR
					prc_plan_integrasi.smbd_name LIKE '%".$filter['free_text']."%' OR
					prc_plan_integrasi.project_name LIKE '%".$filter['free_text']."%' OR
					prc_plan_integrasi.unit LIKE '%".$filter['free_text']."%' OR
					prc_plan_integrasi.user_name LIKE '%".$filter['free_text']."%' OR
					project_info.sbu LIKE '%".$filter['free_text']."%' OR
					project_info.lokasi LIKE '%".$filter['free_text']."%' OR
					project_info.divisiname LIKE '%".$filter['free_text']."%'
				) AND ";
			}
		}
		// vw_prc_plan_remain.ppv_remain LIKE '%".$filter['free_text']."%' OR
		// vw_prc_plan_remain.ppv_main LIKE '%".$filter['free_text']."%' OR

		$sql = "
		select
			prc_plan_integrasi.smbd_code,
			prc_plan_integrasi.smbd_name,
			prc_plan_integrasi.project_name,
			prc_plan_integrasi.unit,
			SUM (prc_plan_integrasi.smbd_quantity)::float as smbd_quantity,
			SUM (prc_plan_integrasi.price)::float as price,
			SUM (prc_plan_integrasi.smbd_quantity)::float * SUM (prc_plan_integrasi.price)::float as total,
			vw_prc_plan_remain.ppv_remain,
			vw_prc_plan_remain.ppv_main,
			prc_plan_integrasi.spk_code,
			prc_plan_integrasi.user_name,
			prc_plan_integrasi.updated_date,
			project_info.sbu,
			project_info.lokasi,
			project_info.divisiname,
			project_info.kddivisi,
			concat ( to_char( MIN ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ), 'Mon' ),
			' ',
			extract ( year from MIN ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ),
			' - ',
			to_char( MAX ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ), 'Mon' ),
			' ',
			extract ( year from MAX ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ) ) as periode_pengadaan
		from prc_plan_main
		join prc_plan_integrasi on prc_plan_main.ppm_project_id = prc_plan_integrasi.spk_code
		join vw_prc_plan_remain on prc_plan_integrasi.smbd_code = vw_prc_plan_remain.ppv_smbd_code
		join project_info on prc_plan_integrasi.spk_code = project_info.kode_spk
		where ".$where." 1=1
		group by
			prc_plan_integrasi.smbd_code,
			prc_plan_integrasi.smbd_name,
			prc_plan_integrasi.project_name,
			prc_plan_integrasi.unit,
			prc_plan_integrasi.spk_code,
			prc_plan_integrasi.user_name,
			prc_plan_integrasi.updated_date,
			project_info.sbu,
			project_info.lokasi,
			project_info.divisiname,
			project_info.kddivisi,
			vw_prc_plan_remain.ppv_remain,
			vw_prc_plan_remain.ppv_main
		order by prc_plan_integrasi.smbd_code
		$page
		";

		return $this->db->query($sql);
	}

	public function get_prcplanintegrasi_matgis($filter, $limit, $offset)
	{
		$page = '';
        if ($limit != '') {
            $page = 'LIMIT '.$limit.' OFFSET '.$offset;
        }

		$where = '';
		if (count($filter) > 0) {
			if ($filter['divisi'] != '') {
				$where .= "project_info.kddivisi = '".$filter['divisi']."' AND ";
			}
			if ($filter['b_date'] != '') {
				$bb = explode("-",$filter['b_date']);
				$where .= "(prc_plan_integrasi.updated_date BETWEEN '".$bb[0]."' AND '".$bb[1]."') AND ";
			}
			if ($filter['period'] != '') {
				$where .= "periode_pengadaan = '".$filter['period']."-01' AND ";
			}
			if ($filter['free_text'] != '') {
				$where .= "(
					prc_plan_integrasi.smbd_code LIKE '%".$filter['free_text']."%' OR
					prc_plan_integrasi.smbd_name LIKE '%".$filter['free_text']."%' OR
					prc_plan_integrasi.project_name LIKE '%".$filter['free_text']."%' OR
					prc_plan_integrasi.unit LIKE '%".$filter['free_text']."%' OR
					prc_plan_integrasi.user_name LIKE '%".$filter['free_text']."%' OR
					project_info.sbu LIKE '%".$filter['free_text']."%' OR
					project_info.lokasi LIKE '%".$filter['free_text']."%' OR
					project_info.divisiname LIKE '%".$filter['free_text']."%'
				) AND ";
			}
		}
		// vw_prc_plan_remain.ppv_remain LIKE '%".$filter['free_text']."%' OR
		// vw_prc_plan_remain.ppv_main LIKE '%".$filter['free_text']."%' OR

		$sql = "
		select
			prc_plan_integrasi.smbd_code,
			prc_plan_integrasi.smbd_name,
			prc_plan_integrasi.project_name,
			prc_plan_integrasi.unit,
			SUM (prc_plan_integrasi.smbd_quantity)::float as smbd_quantity,
			SUM (prc_plan_integrasi.price)::float as price,
			SUM (prc_plan_integrasi.smbd_quantity)::float * SUM (prc_plan_integrasi.price)::float as total,
			vw_prc_plan_remain.ppv_remain,
			vw_prc_plan_remain.ppv_main,
			prc_plan_integrasi.spk_code,
			prc_plan_integrasi.user_name,
			prc_plan_integrasi.updated_date,
			project_info.sbu,
			project_info.lokasi,
			project_info.divisiname,
			project_info.kddivisi,
			concat ( to_char( MIN ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ), 'Mon' ),
			' ',
			extract ( year from MIN ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ),
			' - ',
			to_char( MAX ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ), 'Mon' ),
			' ',
			extract ( year from MAX ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ) ) as periode_pengadaan
		from prc_plan_main
		join prc_plan_integrasi on prc_plan_main.ppm_project_id = prc_plan_integrasi.spk_code
		join vw_prc_plan_remain on prc_plan_integrasi.smbd_code = vw_prc_plan_remain.ppv_smbd_code
		join project_info on prc_plan_integrasi.spk_code = project_info.kode_spk
		where prc_plan_integrasi.is_matgis = 't' AND ".$where." 1=1
		group by
			prc_plan_integrasi.smbd_code,
			prc_plan_integrasi.smbd_name,
			prc_plan_integrasi.project_name,
			prc_plan_integrasi.unit,
			prc_plan_integrasi.spk_code,
			prc_plan_integrasi.user_name,
			prc_plan_integrasi.updated_date,
			project_info.sbu,
			project_info.lokasi,
			project_info.divisiname,
			project_info.kddivisi,
			vw_prc_plan_remain.ppv_remain,
			vw_prc_plan_remain.ppv_main
		order by prc_plan_integrasi.smbd_code
		$page
		";

		return $this->db->query($sql);
	}

	public function get_prcplanintegrasismbd($smbd = "")
	{
		$this->db->select("
		prc_plan_integrasi.smbd_code,
		prc_plan_integrasi.smbd_name,
		prc_plan_integrasi.project_name,
		prc_plan_integrasi.unit,
		SUM ( prc_plan_integrasi.smbd_quantity )::float AS smbd_quantity,
		SUM ( prc_plan_integrasi.price )::float AS price,
		SUM ( prc_plan_integrasi.smbd_quantity )::float  * SUM ( prc_plan_integrasi.price )::float AS total,
		vw_prc_plan_remain.ppv_remain,
		vw_prc_plan_remain.ppv_main,
		prc_plan_integrasi.spk_code,
		prc_plan_integrasi.user_name,
		prc_plan_integrasi.updated_date,
		project_info.sbu,
		project_info.lokasi,
		concat (
				to_char( MIN ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ), 'Mon' ),
				' ',
				EXTRACT ( YEAR FROM MIN ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) ) ,
				' - ',
				to_char( MAX ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ), 'Mon' ),
				' ',
				EXTRACT ( YEAR FROM MAX ( TO_DATE( periode_pengadaan, 'YYYY-MM-DD' ) ) )
			) AS periode_pengadaan
		");
		$this->db->from('prc_plan_main');
		$this->db->join('prc_plan_integrasi', 'prc_plan_main.ppm_project_id = prc_plan_integrasi.spk_code');
		$this->db->join('vw_prc_plan_remain', 'prc_plan_integrasi.smbd_code = vw_prc_plan_remain.ppv_smbd_code');
		$this->db->join('project_info', 'prc_plan_integrasi.spk_code = project_info.kode_spk');
		$this->db->group_by([
			'prc_plan_integrasi.smbd_code',
			'prc_plan_integrasi.smbd_name',
			'prc_plan_integrasi.project_name',
			'prc_plan_integrasi.unit',
			'prc_plan_integrasi.spk_code',
			'prc_plan_integrasi.user_name',
			'prc_plan_integrasi.updated_date',
			'project_info.sbu',
			'project_info.lokasi',
			'vw_prc_plan_remain.ppv_remain',
			'vw_prc_plan_remain.ppv_main'
		]);

		if (!empty($smbd)) {

			$this->db->where("prc_plan_integrasi.smbd_code", $smbd);
		}
		return $this->db->get();
	}

	public function getPR($id = "")
	{
		if (!empty($id)) {
			$this->db->where("pr_number", $id);
		}
		
		return $this->db->get("vw_daftar_pekerjaan_sppbj");
	}

	public function getPR_Sap($id = "")
	{
		if (!empty($id)) {
			$this->db->where("pr_number", $id);
		}
		
		return $this->db->get("vw_daftar_pekerjaan_sppbj_sap");
	}

	public function getPRNonPmcs($id = "")
	{
		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}
		$this->db->where("pr_type_of_plan", "rkp_np");
		return $this->db->get("vw_daftar_pekerjaan_sppbj");
	}

	public function getPRMatgis($id = "")
	{
		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}
		$this->db->where("pr_type_of_plan", "rkp_matgis");
		return $this->db->get("vw_daftar_pekerjaan_sppbj");
	}

	public function getPrDRUP($id = "")
	{
		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}
		$this->db->where("pr_type_of_plan", "rkap");
		return $this->db->get("vw_daftar_pekerjaan_sppbj");
	}

	public function getPRCMain($id = "")
	{
		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}

		return $this->db->get("prc_pr_main");
	}

	public function getPrRisiko($id = "")
	{
		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}

		return $this->db->get("prc_risiko");
	}

	public function getPrNilaiRisiko($id = "")
	{
		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}

		return $this->db->get("prc_penilaian_risiko");
	}

	public function getPrRisikoDetail($tender = "")
	{
		// if (!empty($code)) {

		// 	$this->db->where("id", $code);
		// }

		if (!empty($tender)) {

			$this->db->where("pr_number", $tender);
		}

		$this->db->order_by("id", "asc");

		return $this->db->get("prc_risiko_detail");
	}

	public function getPrOpportunity($id = "")
	{
		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}

		return $this->db->get("prc_opportunity");
	}

	public function getProjectCost($id)
	{
		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}
		$this->db->select('ppm_id');
		$data = $this->db->get("vw_daftar_pekerjaan_sppbj")->row_array();

		$this->db->select('a.spk_code,a.coa_code,a.coa_name');
		$this->db->where('d.ppm_id', $data['ppm_id']);
		$this->db->join('prc_plan_main d', 'd.ppm_project_id = a.spk_code');
		return $this->db->get('prc_plan_project_cost a');
	}


	//y add func
	public function getJoinPR($id = "", $rfq = "")
	{

		if (!empty($id)) {

			$this->db->where("a.pr_number", $id);
		}

		$this->db->distinct();
		$this->db->select("regexp_replace(c.mat_group_code, '\s+$', '') AS mat_group_code, a.pr_number, a.pr_requester_name, a.pr_subject_of_work, a.pr_dept_name, a.nilai, a.pr_packet, a.pr_buyer_id");
		$this->db->join("prc_pr_item b", "b.pr_number = a.pr_number", "left");
		$this->db->join("vw_grouping_catalog c", "regexp_replace(c.mat_catalog_code, '\s+$', '') = regexp_replace(b.ppi_code, '\s+$', '')", "left");

		return $this->db->get("vw_daftar_pekerjaan_sppbj a");
	}	//end

	public function getMonitorPR($id = "")
	{

		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}

		return $this->db->get("vw_prc_pr_monitor");
	}

	public function getUrutPR($tahun = "")
	{

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if (!empty($tahun)) {
			$this->db->where("EXTRACT(YEAR FROM pr_created_date) =", $tahun, false);
		}

		$this->db->select("COUNT(pr_number) as urut");

		$get = $this->db->get("prc_pr_main")->row()->urut;

		return "PR." . date("Ym") . "." . urut_id($get + 1, 5);
	}

	public function insertDataPR($input = array())
	{

		if (!empty($input)) {

			$this->db->insert("prc_pr_main", $input);

			return $this->db->affected_rows();
		}
	}

	public function insertItemPR($input = array())
	{

		if (!empty($input)) {

			unset($input['ppi_id']);

			$this->db->insert("prc_pr_item", $input);

			return $this->db->affected_rows();
		}
	}

	public function insertRisiko($input = array())
	{
		if (!empty($input)) {
			$this->db->insert("prc_risiko", $input);

			return $this->db->affected_rows();
		}
	}

	public function insertRisikoDetail($input = array())
	{
		if (!empty($input)) {

			unset($input['id']);
			$this->db->insert("prc_risiko_detail", $input);

			return $this->db->affected_rows();
		}
	}

	public function insertNilaiRisiko($input = array())
	{
		if (!empty($input)) {
			$this->db->insert("prc_penilaian_risiko", $input);
			return $this->db->affected_rows();
		}
	}

	public function insertOpportunity($input = array())
	{
		if (!empty($input)) {

			$this->db->insert("prc_opportunity", $input);

			return $this->db->affected_rows();
		}
	}

	public function updateItemPR($id, $input = array())
	{

		if (!empty($id) && !empty($input)) {

			$this->db->where('ppi_id', $id)->update('prc_pr_item', $input);

			return $this->db->affected_rows();
		}
	}

	public function updateDataPR($id, $input = array())
	{

		if (!empty($id) && !empty($input)) {

			$this->db->where('pr_number', $id)->update('prc_pr_main', $input);

			return $this->db->affected_rows();
		}
	}

	public function getViewPekerjaanPR($id = "")
	{

		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}


		return $this->db->get('vw_daftar_pekerjaan_pr');
	}

	public function getViewPekerjaanPRNew($id = "")
	{

		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}


		return $this->db->get('vw_daftar_pekerjaan_pr_new');
	}

	public function getPekerjaanPR($id = "")
	{

		if (!empty($id)) {

			$this->db->where("A.pr_number", $id);
		}

		$this->db->join("prc_pr_main B", "B.pr_number = A.pr_number", "left");

		$this->db->join("adm_wkf_activity C", "C.awa_id = A.ppc_activity", "left");

		$this->db->where(array("A.ppc_name" => null, "A.ppc_end_date" => null));

		$this->db->where_not_in("A.ppc_activity", array(1904));

		return $this->db->get("prc_pr_comment A");
	}

	public function getDokumenPR($code = "", $tender = "")
	{

		if (!empty($code)) {

			$this->db->where("ppd_id", $code);
		}

		if (!empty($tender)) {

			$this->db->where("pr_number", $tender);
		}

		$this->db->order_by("ppd_id", "asc");

		return $this->db->get("prc_pr_doc");
	}

	public function getPenilaianRisiko($code = "", $tender = "")
	{

		if (!empty($code)) {

			$this->db->where("id", $code);
		}

		if (!empty($tender)) {

			$this->db->where("pr_number", $tender);
		}

		$this->db->order_by("id", "asc");

		return $this->db->get("prc_penilaian_risiko");
	}

	// new get document only pr_number
	public function getDocumentPr($id = "")
	{

		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}

		$this->db->order_by("ppd_id", "asc");

		return $this->db->get("prc_pr_doc");
	}

	public function getVendorPr($id = "")
	{

		$this->db->select("vnd_header.*, prc_pr_vendor.pr_number");

		if (!empty($id)) {

			$this->db->where("pr_number", $id);
		}

		$this->db->join("vnd_header", "vnd_header.vendor_id = prc_pr_vendor.vendor_id");

		return $this->db->get("prc_pr_vendor");
	}


	public function getItemPR($code = "", $tender = "")
	{

		if (!empty($code)) {

			$this->db->where("ppi_id", $code);
		}

		if (!empty($tender)) {

			$this->db->where("pr_number", $tender);
		}

		$this->db->order_by("ppi_id", "asc");

		return $this->db->get("prc_pr_item");
	}

	public function getItemPRNew($tender = "")
	{
		if (!empty($tender)) {

			$this->db->where("pr_number", $tender);
		}

		$this->db->order_by("ppi_id", "asc");

		return $this->db->get("prc_pr_item");
	}

	public function getRisikoPR($code = "", $tender = "")
	{

		if (!empty($code)) {

			$this->db->where("id", $code);
		}

		if (!empty($tender)) {

			$this->db->where("pr_number", $tender);
		}

		$this->db->order_by("id", "asc");

		return $this->db->get("prc_risiko");
	}

	public function replaceItemPR($id, $input)
	{

		if (!empty($input)) {

			if (!empty($id)) {

				$this->db->where(array("pr_number" => $input['pr_number'], "ppi_id" => $id));
				$check = $this->getItemPR()->row_array();
				if (!empty($check)) {
					$last_id = $check['ppi_id'];
					$this->updateItemPR($last_id, $input);
				} else {
					$this->insertItemPR($input);
					$last_id = $this->db->insert_id();
				}
			} else {
				$this->insertItemPR($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;
		}
	}

	public function deleteIfNotExistItemPR($id, $deleted)
	{
		if (!empty($id) && !empty($deleted)) {
			$this->db->where_not_in("ppi_id", $deleted)->where("pr_number", $id)->delete("prc_pr_item");
			return $this->db->affected_rows();
		}
	}

	public function insertDokumenPR($input)
	{
		if (!empty($input)) {
			unset($input['ppd_id']);
			$this->db->insert("prc_pr_doc", $input);
			return $this->db->affected_rows();
		}
	}

	public function replaceDokumenPR($id, $input)
	{

		if (!empty($input)) {

			if (!empty($id)) {

				$this->db->where(array("pr_number" => $input['pr_number'], "ppd_id" => $id));
				$check = $this->getDokumenPR()->row_array();
				if (!empty($check)) {
					$last_id = $id;
					$this->updateDokumenPR($last_id, $input);
				} else {
					$this->insertDokumenPR($input);
					$last_id = $this->db->insert_id();
				}
			} else {
				$this->insertDokumenPR($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;
		}
	}

	public function deleteIfNotExistDokumenPR($id, $deleted)
	{
		if (!empty($id) && !empty($deleted)) {
			$this->db->where_not_in("ppd_id", $deleted)->where("pr_number", $id)->delete("prc_pr_doc");
			return $this->db->affected_rows();
		}
	}

	public function updateDokumenPR($id, $input = array())
	{

		if (!empty($id) && !empty($input)) {

			$this->db->where('ppd_id', $id)->update('prc_pr_doc', $input);

			return $this->db->affected_rows();
		}
	}

	public function replaceNilaiRisiko($id, $input)
	{

		if (!empty($input)) {

			if (!empty($id)) {

				$this->db->where(array("pr_number" => $input['pr_number'], "id_risiko" => $id));
				$check = $this->getPenilaianRisiko()->row_array();
				if (!empty($check)) {
					$this->updateNilaiRisiko($id, $input);
				} else {
					return $last_id = $this->insertNilaiRisiko($input);
				}
			} else {
				return $this->insertNilaiRisiko($input);				
			}
		}
	}

	public function deleteIfNotExistNilaiRisiko($id, $deleted)
	{
		if (!empty($id) && !empty($deleted)) {
			$this->db->where_not_in("id", $deleted)->where("pr_number", $id)->delete("prc_penilaian_risiko");
			return $this->db->affected_rows();
		}
	}

	public function updateNilaiRisiko($id, $input = array())
	{

		if (!empty($id) && !empty($input)) {

			$this->db->where(array('id_risiko' => $id, 'pr_number' => $input['pr_number']))->update('prc_penilaian_risiko', $input);

			return $this->db->affected_rows();
		}
	}

	public function replaceOpportunity($id, $input)
	{

		if (!empty($input)) {

			if (!empty($id)) {

				$this->db->where(array("pr_number" => $input['pr_number'], "id" => $id));
				$check = $this->getPrOpportunity()->row_array();
				if (!empty($check)) {
					$last_id = $id;
					$this->updatePrOpportunity($last_id, $input);
				} else {
					$this->insertOpportunity($input);
					$last_id = $this->db->insert_id();
				}
			} else {
				$this->insertOpportunity($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;
		}
	}

	public function deleteIfNotExistOpportunity($id, $deleted)
	{
		if (!empty($id) && !empty($deleted)) {
			$this->db->where_not_in("id", $deleted)->where("pr_number", $id)->delete("prc_opportunity");
			return $this->db->affected_rows();
		}
	}

	public function updatePrOpportunity($id, $input = array())
	{

		if (!empty($id) && !empty($input)) {

			$this->db->where('id', $id)->update('prc_opportunity', $input);

			return $this->db->affected_rows();
		}
	}

	public function replaceRisikoDetail($id, $input)
	{

		if (!empty($input)) {

			if (!empty($id)) {

				$this->db->where(array("pr_number" => $input['pr_number'], "id" => $id));
				$check = $this->getRisikoPR()->row_array();
				if (!empty($check)) {
					$last_id = $id;
					$this->updateDetailItem($last_id, $input);
				} else {
					$this->insertRisikoDetail($input);
					$last_id = $this->db->insert_id();
				}
			} else {
				$this->insertRisikoDetail($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;
		}
	}

	public function deleteIfNotExistRisikoDetail($id, $deleted)
	{
		if (!empty($id) && !empty($deleted)) {
			$this->db->where_not_in("id", $deleted)->where("pr_number", $id)->delete("prc_risiko_detail");
			return $this->db->affected_rows();
		}
	}

	public function updateDetailItem($id, $input = array())
	{

		if (!empty($id) && !empty($input)) {

			$this->db->where('id', $id)->update('prc_risiko_detail', $input);

			return $this->db->affected_rows();
		}
	}



	public function do_upload($name)
	{

		/*
			menggunakan config upload di construct controller
        */

		if (!$this->upload->do_upload($name)) //upload and validate
		{

			$this->upload->display_errors(); //show ajax error

		}
		return $this->upload->data('file_name');
	}

	//haqim
	public function submit_chat_pr($data)
	{
		$this->db->insert('prc_chat_pr', $data);
		return $this->db->affected_rows();
	}

	public function chat_pr($pr_number, $ybs)
	{

		$this->db->select('pr_number,employee_from,employee_to,employee_cc,pesan,date,attach');
		$this->db->where('pr_number', $pr_number);
		$this->db->group_start();
		$this->db->like('employee_from', $ybs);
		$this->db->or_like('employee_to', $ybs);
		$this->db->or_like('employee_cc', $ybs);
		$this->db->group_end();
		$this->db->order_by('status', 'desc');
		$this->db->order_by('date', 'desc');

		return $this->db->get('prc_chat_pr')->result_array();
	}
	//end

	public function getPerson($id = null)
	{
		if($id != null) $this->db->where('ptm_number', $id);

		$this->db->order_by('id', 'asc');
		return $this->db->get('prc_person_in_charge')->result_array();
	}

}
