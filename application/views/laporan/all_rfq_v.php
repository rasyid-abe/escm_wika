<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins">
        <div class="card-title">
          <h5><?php echo $judula ?> : <?php echo $jumlah?></h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

         <div class="table-responsive">

           <table id="datatables-ss" class="table table-bordered table-striped">
             <thead>
              <tr>
                <th width="10px" style="text-align:center;font-size: 1.2em;text-align: center">No</th>
                <?php if($tipe == 'vendor_id')  { ?>
                <th style="text-align:center;font-size: 1.2em;"><?php echo $headTable ?></th>

                <?php } elseif($tipe == 'contract') { ?>
                
                <th width="90%" style="text-align:center;font-size: 1.2em;"><?php echo $headTable ?></th>
                <th width="90%" style="text-align:center;font-size: 1.2em;"><?php echo $namaPenjelasan ?></th>

                <?php } else { ?>
                
                <th width="90%" style="text-align:center;font-size: 1.2em;"><?php echo $headTable ?></th>
                <th width="90%" style="text-align:center;font-size: 1.2em;"><?php echo $namaPenjelasan ?></th>
                
                <?php } ?>
                
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 0;
              foreach($rfq as $key => $value) { $no++?>
              <tr>
                <td style="text-align: center"><?php echo $no ?></td>

                <?php if($tipe == 'vendor_id')  { ?>
                <td>
                  <a target="_blank" class="btn btn-primary btn-xs action" href="<?php echo base_url()?>index.php/vendor/daftar_vendor/lihat_detail_vendor/<?php echo $value['vendor_id']?>"><?php echo $value['ptm_number'] ?></a> </td>
                  <?php } elseif($tipe == 'contract') { ?>
                  <td width="40%">
                    <a href="<?php echo base_url()?>index.php/contract/monitor/monitor_kontrak/lihat/<?php echo $value['contract_id'] ?> " target="_blank">
                      <?php echo $value['ptm_number'] ?> 
                    </a>
                  </td>
                  <td width="50%"><?php echo $value['penjelasan'] ?></td>

                  <?php } else { ?>
                  <td width="20%">
                    <a href="<?php echo base_url()?>index.php/procurement/procurement_tools/monitor_pengadaan/lihat/<?php echo $value['ptm_number'] ?>" target="_blank"><?php echo $value['ptm_number'] ?></a>
                  </td> 
                  <td width ="50%"><?php echo $value['penjelasan'] ?></td>
                  <?php } ?>
                </tr>
                <?php } ?> 
              </tbody> 
            </table>

          </div>

        </div>
      </div>

    </div>
    <div class="col-md-12">
      <div style="padding-bottom:50px;">
        <a onclick="history.back(-1)" target="_self" class="btn btn-light btn-lg">Kembali</a>
      </div>
    </div>
  </div>
</div>




<script>
 $(document).ready(function() {
  $('#datatables-ss').DataTable();
});

</script>
