<?php $this->load->view('devextreme'); ?>

<div class="row">
  <div class="col-12">
    <div class="card">
      
      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">Lampiran</h4>
      </div>

      <div class="card-content">
        <div class="card-body">

          <table class="table table-bordered default">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Kategori</th>
              <th class="text-center">Deskripsi</th>
              <th class="text-center">Lampiran</th>
              <th class="text-center">Tipe</th>
              <th class="text-center">Tipe</th>
            </tr>
          </thead>

          <tbody>
          <?php 
            $sisa = 5;
            if(isset($document) && !empty($document)){
              foreach ($document as $k => $v) {
                if(!empty($v['ptd_file_name'])){
          ?>
              <tr>
                <td class="text-center"><?php echo $k+1 ?></td>
                <td class="text-center"><?php echo $v["ptd_category"] ?></td>
                <td class="text-center"><?php echo $v['ptd_description'] ?></td>
                <td class="text-center">
                <?php if($v['ptd_category'] == 'PENGUMUMAN PEMENANG') { ?>
                  <a onclick="showModalDoc(1)">
                <?php echo $v['ptd_file_name'] ?></a>
              <?php } elseif($v['ptd_category'] == 'PENUNJUK PELAKSANA') { ?>
                <!-- <a href="<?php echo base_url()."index.php/procurement/surat_penunjuk_penyedia/".$tender['ptm_number']; ?>" target="_blank"> -->
                <a onclick="showModalDoc(2)">

                <?php echo $v['ptd_file_name'] ?></a>                <?php }else{ ?>
                  <a href="<?php echo site_url('log/download_attachment/procurement/tender/'.$v['ptd_file_name']) ?>" target="_blank">
                <?php echo $v['ptd_file_name'] ?></a>
                  <?php } ?>
                  
              </td>
                <td class="text-center"><?php echo ($v['ptd_type'] == 0) ? "Dokumen Internal" : "Dokumen Vendor" ?></td>
                <td class="text-center">
                <?php if($v['ptd_category'] == 'PENGUMUMAN PEMENANG') { ?>
                  <?php 
                    $urlPemenang = "";
                    $this->db->where('rfq_no', $tender['ptm_number']);
                    $this->db->where('tipe', '1');
                    $dataDocs = $this->db->get('prc_doc_pengumuman')->row_array();
                    if($dataDocs!= null && $dataDocs['is_generated_pemenang'] == null) $urlPemenang = base_url()."uploads/surat_pemenang/".$dataDocs['filename'];
                    if($dataDocs!= null && $dataDocs['is_generated_pemenang'] != null) $urlPemenang = base_url()."uploads/surat_pemenang/".$dataDocs['filename_generate_pemenang'];

                    
                  ?>
                  <a href="<?php echo $urlPemenang ?>" target="_blank" class="btn btn-info btn-sm" style="margin: 5px;font-size:11px;"><i class="ft ft-file"></i></a>
                  
                  <!-- <a class="btn btn-warning btn-sm" id="btnUploadPemenang" style="margin: 5px;font-size:11px;"><i class="ft ft-upload"></i></a> -->

              <?php } elseif($v['ptd_category'] == 'PENUNJUK PELAKSANA') { ?>
                <?php 
                    $urlPemenang = "";
                    $this->db->where('rfq_no', $tender['ptm_number']);
                    $this->db->where('tipe', '2');
                    $dataDocs = $this->db->get('prc_doc_pengumuman')->row_array();
                    if($dataDocs!= null && $dataDocs['is_generated_penunjuk'] == null) $urlPemenang = base_url()."uploads/surat_penunjuk/".$dataDocs['filename'];
                    if($dataDocs!= null&& $dataDocs['is_generated_penunjuk'] == null) $urlPemenang = base_url()."uploads/surat_penunjuk/".$dataDocs['filename_generate_penunjuk'];

                    
                  ?>

                <a href="<?php echo $urlPemenang ?>" target="_blank" class="btn btn-info btn-sm" style="margin: 5px;font-size:11px;"><i class="ft ft-file"></i></a>
                <!-- <a class="btn btn-warning btn-sm" style="margin: 5px;font-size:11px;"><i class="ft ft-upload"></i></a> -->
                <?php }else{ ?>
                  <a class="btn btn-info btn-sm" href="<?php echo site_url('log/download_attachment/procurement/permintaan/'.$v['ptd_file_name']) ?>" style="margin: 5px;font-size:11px;" target="_blank"><i class="ft ft-file"></i></a>
                  <?php } ?>
                </td>
              </tr>

              <?php } } } ?>
            </tbody>
          </table>
          <?php if($permintaan['ptm_status'] >= 1160) : ?>
            <?php 
                    $urlPemenang = "";
                    $this->db->where('rfq_no', $tender['ptm_number']);
                    $this->db->where('tipe', '1');
                    $datapermintaan = $this->db->get('prc_doc_pengumuman')->row_array();      
                    if($datapermintaan == null) {

                  ?>

            <?php } ?>
            <div class="col-lg-6"><div id="file-uploader-pemenang" style="font-size:11px;"></div></div>

        <?php endif; ?>
        <?php if($permintaan['ptm_status'] >= 1180) : ?>
          <?php 
                    $urlPemenang = "";
                    $this->db->where('rfq_no', $tender['ptm_number']);
                    $this->db->where('tipe', '2');
                    $datapermintaan = $this->db->get('prc_doc_pengumuman')->row_array();     
                    
                    if($datapermintaan == null) {
                  ?>
          <?php } ?>
          <div class="col-lg-6"><div id="file-uploader-penunjuk" style="font-size:11px;"></div></div>

        <?php endif; ?>
        </div>
      </div>

    </div>
  </div>
</div>


<script>
  $(document).ready(function () {
    var urlUpload = '<?= base_url() ?>/Documents/Uploads_Doc/1/<?=$tender['ptm_number']; ?>';
    var urlUploadPenunjuk = '<?= base_url() ?>/Documents/Uploads_Doc/2/<?=$tender['ptm_number']; ?>';

    const fileUploader = $('#file-uploader-pemenang').dxFileUploader({
    multiple: false,
    accept: 'pdf',
    labelText :'',
    name:'file_pemenang',
    selectButtonText: ' Upload Dokumen Pemenang',
    uploadMode: 'instantly',
    uploadUrl: urlUpload,
    onContentReady: function(e) {
          var button = e.element.find(".dx-fileuploader-button").dxButton('instance');
          if (button) {
            button.option('icon', 'runner');
            button.element().find("i")
              .replaceWith($("<i class='ft ft-upload'></i>"));
          }
      },
      onFilesUploaded: function(e) {
            // Your code goes here
            location.reload();
            //window.location.href = window.location.href;

        }
  }).dxFileUploader('instance');  

  const fileUploaderPenunjuk = $('#file-uploader-penunjuk').dxFileUploader({
      multiple: false,
    accept: 'pdf',
    labelText :'',
    selectButtonText: ' Upload Dokumen Penunjukan',
    uploadMode: 'instantly',
    name:'file_pemenang',
    uploadUrl: urlUploadPenunjuk,
    onContentReady: function(e) {
          var button = e.element.find(".dx-fileuploader-button").dxButton('instance');
          if (button) {
            button.option('icon', 'runner');
            button.element().find("i")
              .replaceWith($("<i class='ft ft-upload'></i>"));
          }
      },
      onFilesUploaded: function(e) {
            // Your code goes here
            location.reload();
            //window.location.href = window.location.href;

        }
  }).dxFileUploader('instance');  

  });


function showModalDoc(param) {

  if(param == 1){
    $('#formModalDocRFQ').attr('action', "<?php echo base_url()."index.php/procurement/surat_pengumuman_pemenang/".$tender['ptm_number']; ?>")
  } else {
    $('#formModalDocRFQ').attr('action', "<?php echo base_url()."index.php/procurement/surat_penunjuk_penyedia/".$tender['ptm_number']; ?>")

  }
$("#DocRfqPenunjuk-modal").modal("show");
}
</script>
