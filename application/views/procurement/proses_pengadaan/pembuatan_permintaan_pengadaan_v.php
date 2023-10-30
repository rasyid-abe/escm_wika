<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name . "/submit_pembuatan_permintaan_pengadaan"); ?>" class="form-horizontal ajaxform">

    <?php
    foreach ($content as $key => $value) {
      include(VIEWPATH . "procurement/proses_pengadaan/" . $value['awc_type'] . "/" . $value['awc_file'] . ".php");
    }

    ?>

    <?php
    $i = 0;
    include(VIEWPATH . "/comment_workflow_attachment_v.php") ?>

    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <?php echo buttonsubmit('procurement/proses_pengadaan/daftar_permintaan_pengadaan', lang('back'), lang('save')) ?>
        </div>
      </div>
    </div>

  </form>

</div>

<script>
  function tipePengadaan() {
    let jasa = document.getElementById('jenis_nilai_resiko_jasa')
    jasa.style = "display: flex";
    var params_type = $("#tipe_pengadaan").val()

    $("#onSkalaResiko").val(params_type);
    $('#onSkalaResiko').attr('value', params_type);

    if (params_type == 'barang') {
      $('#jenis_nilai_resiko_barang').css('display', 'block')
      $('#jenis_nilai_resiko_jasa').css('display', 'none')
      $('#get_tipe_header').text("Barang")
    } else {
      $('#get_tipe_header').text("Jasa")
      $('#jenis_nilai_resiko_barang').css('display', 'none')
      $('#jenis_nilai_resiko_jasa').css('display', 'block')
    }
  }
</script>