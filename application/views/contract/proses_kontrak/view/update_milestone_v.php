<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header">
        <h4 class="card-title">Monitoring Pembayaran (Progress)</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
            <table class="table" id="progress_milestone">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Deskripsi Milestone</th>
                  <th>Tanggal Target</th>
                  <th>Bobot (%)</th>
                  <th>Progress (%)</th>
                  <th>Keterangan Progress</th>
                </tr>
              </thead>

              <tbody></tbody>

            </table>
        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  reloadeval();

  function reloadeval(){
    $("#progress_milestone tbody").load("<?php echo site_url('contract/load_progress_milestone') ?>/view");
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
