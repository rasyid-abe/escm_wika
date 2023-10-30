<div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins">
          <div class="card-title">
            <h5>A.2 Data Barang</h5>
            <div class="card-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="card-content">
              <!-- //hlmifzi -->
           <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Produk</th>
              <th>Deskripsi</th>
              <th>Flag</th>
            </tr>
          </thead>

          <tbody>
          <?php foreach ($item as $key => $value){ ?>
          <!-- hlmifzi -->
            <tr>
              <td><?php echo $key+1 ?></td>
              <td><a class="dialog" data-url="<?php echo site_url('vendor/detail_barang_kpi/'.$value['ccp_id_commodity_cat'].'/'.$value['vendor_id']) ?>" href="#"><?php echo $value['group_name'] ?></a></td>
              <td><?php echo $value['group_name'] ?></a></td>
              <td><img src="<?php echo base_url();?>/assets/img/<?php echo $value['flag'] ?>"></a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    <?php if (empty($item)) { ?>
      alert('Belum ada nilai KPI dari pengelola kontrak terkait kontrak dengan vendor ini')
    <?php } ?>
  });
</script>

