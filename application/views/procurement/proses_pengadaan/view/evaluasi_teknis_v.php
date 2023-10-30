<div class="row">
   <div class="col-12">
      <div class="card">

         <div class="card-header border-bottom pb-2">
            <h4 class="card-title">EVALUASI TEKNIS</h4>            
         </div>

         <div class="card-content">
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="evaluasi_teknis_table">
                  <thead>
                    <tr>
                      <th rowspan="2">#</th>
                      <th rowspan="2">Nilai Total</th>
                      <th rowspan="2">Nama Vendor</th>
                      <th rowspan="2">Administrasi</th>
                      <th colspan="5">Teknis</th>

                    </tr>
                    <tr>
                      <th>Bobot</th>
                      <th>Nilai</th>
                      <th>Minimum</th>
                      <th>Hasil</th>
                      <th>Catatan</th>
                    </tr>
                  </thead>

                  <tbody></tbody>

                </table>
              </div>
            </div>
         </div>

      </div>
   </div>
</div>

<script type="text/javascript">

  reloadeval();
  
  function reloadeval(){
    $("#vendor_verifikasi_view").bootstrapTable("refresh");
    $("#evaluasi_teknis_table tbody").load("<?php echo site_url('procurement/load_evaluation') ?>/view/teknis");
  }

  $(document).ready(function(){

    $(document.body).on("click",".reloadeval",function(){
      $("#dialog").modal("hide");
    });

    $('#dialog').on('hidden.bs.modal', function (e) {
      reloadeval();
    });

  });

</script>