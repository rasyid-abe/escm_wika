<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Locations extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
	}

	public function get_regency()
    {
        $name = $this->input->post('prop', true);
        $data = $this->db->get_where('adm_ref_locations', ['province_name' => $name, 'stereotype' => 'REGENCY', 'row_status' => 'ACTIVE'])->result_array();
        echo json_encode($data);
    }

	public function get_district()
    {
        $name = $this->input->post('city', true);
        $data = $this->db->get_where('adm_ref_locations', ['regency_name' => $name, 'stereotype' => 'DISTRICT', 'row_status' => 'ACTIVE'])->result_array();
        echo json_encode($data);
    }

	public function get_village()
    {
        $name = $this->input->post('district', true);
        $data = $this->db->get_where('adm_ref_locations', ['district_name' => $name, 'stereotype' => 'VILLAGE', 'row_status' => 'ACTIVE'])->result_array();
        echo json_encode($data);
    }
}
