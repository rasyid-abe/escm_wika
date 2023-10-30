 <?php $contract_type = (isset($addendum['contract_type'])) ? $addendum["contract_type"] : "";
if($contract_type != "HARGA SATUAN"){ ?>

<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>MILESTONE</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="card-content">

       <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Deskripsi</th>
            <th>Target Tanggal</th>
            <th>Bobot (%)</th>
          </tr>
        </thead>

        <tbody>
          <?php 
          $subtotal = 0;
          if(isset($milestone) && !empty($milestone)){
            foreach ($milestone as $key => $value) { ?>

            <tr>
             <td><?php echo $key+1 ?></td>
             <td>

              <?php echo $value['description'] ?>
            </td>
            <td>
              <?php echo date(DEFAULT_FORMAT_DATE,strtotime($value['target_date'])) ?>
            </td>
            <td class="text-right">
              
              <?php echo $value['percentage'] ?>
            </td>
          </tr>

          <?php } } ?>
        </tbody>
      </table>

    </div>
  </div>
</div>
</div>

<?php } ?>