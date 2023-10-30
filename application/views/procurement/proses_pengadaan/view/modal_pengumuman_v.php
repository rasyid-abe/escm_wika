<div id="DocRfqPemenang-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="docRfq-modal-title">Lampiran Surat Pemenang</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="" target="_blank" method="POST">
      <div class="modal-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Nomor Doc</label>
        <input type="text" class="form-control" id="" name="nomor_surat" aria-describedby="emailHelp" placeholder="Nomor Surat">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Nomor Surat</label>
        <input type="text" class="form-control" id="" name="nomor_surat_2" aria-describedby="emailHelp" placeholder="Nomor Surat">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Nomor Rev</label>
        <input type="text" class="form-control" id="" name="nomor_rev" aria-describedby="emailHelp" placeholder="Nomor Rev">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Nomor Lampiran</label>
        <input type="text" class="form-control" name="nomor_lampiran" id="exampleInputPassword1" placeholder="Nomor Lampiran">
      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Generate</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div id="DocRfqPenunjuk-modal" class="modal" tabindex="-1" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="docRfq-modal-title">Lampiran Surat</h5>
        <button class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formModalDocRFQ" action="<?php echo base_url()."index.php/procurement/surat_penunjuk_penyedia/".$tender['ptm_number']; ?>" target="_blank" method="POST">
      <div class="modal-body">
      <div class="form-group">
        <label for="exampleInputEmail1">Tempat</label>
        <input type="text" class="form-control" id="" name="tempat" aria-describedby="emailHelp" placeholder="Tempat">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Tanggal</label>
        <input type="text" class="form-control" id="" name="tanggal" aria-describedby="emailHelp" placeholder="Tanggal Surat">
      </div>
      <div class="form-group">
        <label for="exampleInputEmail1">Nomor Surat</label>
        <input type="text" class="form-control" id="" name="nomor_surat_2" aria-describedby="emailHelp" placeholder="Nomor Surat">
      </div>
      <!-- <div class="form-group">
        <label for="exampleInputEmail1">Nomor Rev</label>
        <input type="text" class="form-control" id="" name="nomor_rev" aria-describedby="emailHelp" placeholder="Nomor Rev">
      </div> -->
      <div class="form-group">
        <label for="exampleInputPassword1">Nomor Lampiran</label>
        <input type="text" class="form-control" name="nomor_lampiran" id="exampleInputPassword1" placeholder="Nomor Lampiran">
      </div>
      </div>
      <div class="modal-footer">
      <button type="submit" class="btn btn-primary">Generate</button>
      </div>
      </form>
    </div>
  </div>
</div>