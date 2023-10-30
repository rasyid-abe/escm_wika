<?php 

$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

$view = 'procurement/perencanaan_pengadaan/detail_history_car_v';

$data = array();

$id = $this->uri->segment(5, 0);

$data['perencanaan'] = $this->Procplan_m->getHistoryCar($id)->row_array();
$data['document'] = $this->Procplan_m->getDokumenHistoryCar("",$id)->result_array();
$data['progress'] = $this->Procplan_m->getProgressHistoryCar($id)->result_array();

$data['urlpr'] = site_url('procurement/procurement_tools/monitor_pengadaan/lihat_permintaan')."/";

$data['urlrfq'] = site_url('procurement/procurement_tools/monitor_pengadaan/lihat')."/";

$data['urlctr'] = site_url('contract/monitor/monitor_kontrak/lihat')."/";

$this->template($view,"Detail View History CAR",$data);