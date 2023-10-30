<div class="row">
  <div class="col-lg-12">
    <div class="card float-e-margins">
      <div class="card-title">
        <h5>UPDATE PROGRESS MILESTONE</h5>
        <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="card-content">

        <table class="table table-bordered" id="progress_milestone">
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