 <?php 

$main = $this->Procpr_m->getPR($id)->row_array();
$acivity = 1040;
$urll = base_url();
//get buyer position
$buyers = $this->Administration_m->getEmployeeJoin($main['pr_requester_id'])->row_array();

$buyer = array(
			'ptm_buyer_id' => $main['pr_requester_id'],
			'ptm_buyer' => $main['pr_requester_name'],
			'ptm_buyer_pos_code' => $buyers['pos_id'],
			'ptm_buyer_pos_name' => $buyers['pos_name']
		);

$this->db->trans_begin();
//hapus comment pr
$del_comment = $this->db->where(array("pr_number"=> $id, "ppc_activity"=>1011))->delete("prc_pr_comment");

//update status pr
$update_status = $this->Procpr_m->updateDataPR($id, array("pr_status"=>$acivity));

//insert rfq
$movetorfq = $this->Procedure_m->movePRtoRFQ($main['pr_number']);


//add buyer rfq
$insert_buyer = $this->db->where('ptm_number', $movetorfq)->update('prc_tender_main', $buyer);

//insert new tender comment
$newcomment = $this->Comment_m->insertProcurementRFQ($movetorfq, $acivity, "", "", "",$buyer['ptm_buyer_pos_code'], $buyer['ptm_buyer_pos_name']);

if ($this->db->trans_status() === FALSE)
{
  $this->setMessage("Gagal mengubah data");
  $this->db->trans_rollback();
}
else
{
  $this->setMessage("Sukses mengubah data");
  $this->db->trans_commit();
  header("Location: $urll");
}

?>