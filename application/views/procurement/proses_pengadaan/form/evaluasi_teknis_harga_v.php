<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
          <h4 class="card-title">EVALUASI TEKNIS &amp; HARGA</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="evaluasi_teknis_harga_table">
                <thead>
                  <tr>
                    <th rowspan="2">#</th>
                    <th rowspan="2">Nilai Total</th>
                    <th rowspan="2">Nama Vendor</th>
                    <th rowspan="2">Administrasi</th>
                    <th colspan="5">Teknis</th>
                    <th colspan="6">Harga</th>
                  </tr>
                  <tr>
                    <th>Bobot</th>
                    <th>Nilai</th>
                    <th>Minimum</th>
                    <th>Hasil</th>
                    <th>Catatan</th>
                    <th>Bobot</th>
                    <th>Nilai</th>
                    <th>Hasil</th>
                    <th>Catatan</th>
                    <th>Penawaran</th>
                    <th>Setelah Nego</th>
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
    $("#evaluasi_teknis_harga_table tbody").load("<?php echo site_url('procurement/load_evaluation') ?>/edit/teknis_harga");
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
