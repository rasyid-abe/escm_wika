<?php 
  $view = 'procurement/procurement_tools/monitor_rfq_v';
  $data = array();
  $data['export'] = '<div class="row">
  <div class="col-md-12">
        <btn data-url="'.site_url().'/laporan/laporanPdfDetail" data-tipe="detail"
          class="btn btn-sm pull-right btnExport" data-toggle="tooltip" title="Export Laporan PDF" target="_blank"
          style="background-color:red;color:white;margin-right:5px">
          <i class="fa fa-file-pdf-o"></i> Export PDF
        </btn>

        <btn data-url="'.site_url().'/laporan/laporanExcelDetail" data-tipe="detail"
          class="btn btn-sm pull-right btnExport" data-toggle="tooltip" title="Export Laporan Excel" target="_blank"
          style="background-color:green;color:white;margin-right:5px">
          <i class="fa fa-file-excel-o"></i> Export Excel
        </btn>
    </div>
  </div>';
  $this->template($view,"Laporan RFQ",$data);
?>