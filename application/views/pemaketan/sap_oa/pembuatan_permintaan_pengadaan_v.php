<style>
  .scroll-lam {
    position: fixed;
    z-index: 2000;
    bottom: 17%;
    right: 2rem;
    padding: 0.4rem 0.8rem;
    display: block !important;
  }
  .scroll-ris {
    position: fixed;
    z-index: 2000;
    bottom: 13%;
    right: 2rem;
    padding: 0.4rem 0.8rem;
    display: block !important;
  }
  .scroll-opp {
    position: fixed;
    z-index: 2000;
    bottom: 9%;
    right: 2rem;
    padding: 0.4rem 0.8rem;
    display: block !important;
  }
</style>

<div class="wrapper wrapper-content animated fadeInRight">
  <?php if (isset($_GET["edit_data_pr"])) {?>
      <form method="post" action="<?php echo site_url($controller_name . "/paket_sap_oa/submit_ubah_permintaan"); ?>" class="form-horizontal ajaxform">
  <?php } else { ?>
      <form method="post" action="<?php echo site_url($controller_name . "/paket_sap_oa/submit_sap"); ?>" class="form-horizontal ajaxform">
  <?php }?>

    <?php
      foreach ($content as $key => $value) {
        include(VIEWPATH . "pemaketan/sap_oa/" . $value['awc_type'] . "/" . $value['awc_file'] . ".php");
      }
    ?>

    <?php
    $i = 0;
    include(VIEWPATH . "/comment_workflow_attachment_v.php") ?>

    <div class="card">
      <div class="card-content">
        <div class="card-body">
          <?php echo buttonsubmit('paket_pengadaan/paket_sap_oa', lang('back'), lang('save')) ?>
        </div>
      </div>
    </div>

  </form>

</div>

<script>
  $(document).ready(function() {
    tipePengadaan()
  });

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

  function lamFunct() {
    var x = document.getElementById("sec-lam");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }

  function risFunct() {
    var x = document.getElementById("sec-ris");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }

  function oppFunct() {
    var x = document.getElementById("sec-opp");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }
</script>
