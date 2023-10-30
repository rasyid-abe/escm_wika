<?php if($prep['ptp_prequalify'] != 0){ ?>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
          <h5 class="card-title">PRA KUALIFIKASI</h5>
      </div>
      <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
              <div class="table m-0">
                <table>
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Vendor</th>
                      <th style="width: 300px;text-align:center;">Lampiran Prakualifikasi</th>
                      <th>Lulus/Tidak Lulus</th>
                      <th style="width: 500px;text-align:center;">Alasan</th>
                    </tr>
                  </thead>

                  <tbody>
                    <?php
                    if(!empty($vendor_status)){
                      foreach ($vendor_status as $key => $value) { ?>
                      <tr>
                        <td><?php echo $key+1 ?></td>
                        <td><a href="<?php echo site_url('vendor/daftar_vendor/lihat_detail_vendor/'.$value['pvs_vendor_code']) ?>" target="_blank"><?php echo $value['vendor_name'] ?></a></td>
                        <td><a target="_blank" href="<?php echo site_url('log/download_attachment_extranet/prakualifikasi/'.$value['pvs_vendor_code'].'/'.$value["pvs_pq_attachment"]); ?>"><?php echo $value["pvs_pq_attachment"] ?></a></td>
                        <td align="center">
                         <?php echo ($value['pvs_pq_passed'] == 1 ) ? "Ya" : "Tidak" ?>
                       </td>
                       <td><?php echo $value['pvs_pq_reason'] ?></td>
                     </tr>
                     <?php } } ?>
                   </tbody>
                 </table>
               </div>
            </div>
        </div>
      </div>
    </div>
   </div>
 </div>

 <?php } ?>
