<section>
  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="rks" class="table table-bordered table-striped">
                <!-- <a class="btn btn-info" href="<?php echo site_url('administration/master_data/rks/tambah') ?>" role="button"><i class="ft-plus mr-1"></i>Tambah</a> -->
                <a href="#" class="btn btn-info mr-3 btn-sm" data-toggle="modal" data-target="#rksHeader"><i class="ft ft-file-plus"></i> Header</a>
  							<?php if ($header > 0) { ?>
  								<a href="#" class="btn btn-info mr-3 btn-sm" data-toggle="modal" data-target="#rksSub"><i class="ft ft-file-plus"></i> Sub Header</a>
  								<a href="#" class="btn btn-info btn-sm" data-toggle="modal" data-target="#rksDesc"><i class="ft ft-file-plus"></i> Description</a>
  							<?php } ?>
              </table>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</section>

<div class="modal fade text-left" id="rksHeader" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title modal-judul">Tambah Header RKS</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form action="<?= base_url('administration/submit_add_rks_header'); ?>" method="POST">
				<div class="modal-body">

					<label class="text-bold-700">Header Main <span class="text-danger text-bold-700">(*)</span></label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" maxlength="100" name="header_main" placeholder="Masukan Header" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<input type="reset" class="btn btn-secondary btn-lg" data-dismiss="modal" value="Tutup">
					<input type="submit" onclick="return confirm('Apakah Anda yakin simpan data ini?')" class="btn btn-info btn-lg" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal-add-header-sub -->
<div class="modal fade text-left" id="rksSub" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title modal-judul">Tambah Header Sub RKS</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form action="<?= base_url('administration/submit_add_rks_header_sub'); ?>" method="POST">
				<div class="modal-body">

					<label class="text-bold-700">Header Main <span class="text-danger text-bold-700">(*)</span></label>
					<div class="form-group">
                        <select class="form-control" name="header_main" required>
                            <option value="">Pilih</option>
                            <?php foreach ($rks_header as $v) { ?>
                                <option value="<?php echo $v['header_main']?>"><?php echo $v['header_main']?></option>
                            <?php } ?>
                        </select>
					</div>

					<label class="text-bold-700">Header Sub <span class="text-danger text-bold-700">(*)</span></label>
					<div class="form-group position-relative has-icon-left">
						<input type="text" maxlength="200" name="header_sub" placeholder="Masukan Header Sub" class="form-control" required>
						<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<input type="reset" class="btn btn-secondary btn-lg" data-dismiss="modal" value="Tutup">
					<input type="submit" onclick="return confirm('Apakah Anda yakin simpan data ini?')" class="btn btn-info btn-lg" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal-add-description -->
<div class="modal fade text-left" id="rksDesc" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title modal-judul">Tambah Description RKS</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form action="<?php echo base_url('administration/submit_add_rks_description'); ?>" method="POST">
				<div class="modal-body">

                    <label class="text-bold-700">Header Main <span class="text-danger text-bold-700">(*)</span></label>
					<div class="form-group">
                        <select class="form-control" name="header_main" required>
                            <option value="">Pilih</option>
                            <?php foreach ($rks_header as $v) { ?>
                                <option value="<?php echo $v['header_main']?>"><?php echo $v['header_main']?></option>
                            <?php } ?>
                        </select>
					</div>

                    <label class="text-bold-700">Header Sub <span class="text-danger text-bold-700">(*)</span></label>
					<div class="form-group">
                        <select class="form-control" name="header_sub" required>
                            <option value="">Pilih</option>
                            <?php foreach ($rks_header_sub as $v) { ?>
                                <option value="<?php echo $v['header_sub']?>"><?php echo $v['header_sub']?></option>
                            <?php } ?>
                        </select>
					</div>

					<label class="text-bold-700">Description <span class="text-danger text-bold-700">(*)</span></label>
					<div class="form-group position-relative has-icon-left">
						<textarea rows="6" class="form-control round" name="description" placeholder="Masukan Description" required></textarea>
						<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<input type="reset" class="btn btn-secondary btn-lg" data-dismiss="modal" value="Tutup">
					<input type="submit" onclick="return confirm('Apakah Anda yakin simpan data ini?')" class="btn btn-info btn-lg" value="Simpan">
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal-edit -->
<div class="modal fade text-left" id="editRks" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<label class="modal-title text-bold-700">Edit Data RKS</label>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true"><i class="ft-x font-medium-2 text-bold-700"></i></span>
				</button>
			</div>
			<form action="<?= base_url('administration/master_data/rks/submit_edit_rks'); ?>" method="POST">
				<div class="modal-body">

					<label class="text-bold-700">Header Main <span class="text-danger text-bold-700">(*)</span></label>
					<div class="form-group">
						<input type="hidden" id="id" name="id">
            <select class="form-control" id="header_main" name="header_main" required>
                <option value="">Pilih</option>
                <?php foreach ($rks_header as $v) { ?>
                    <option value="<?php echo $v['header_main']?>"><?php echo $v['header_main']?></option>
                <?php } ?>
            </select>
					</div>

          <label class="text-bold-700">Header Sub <span class="text-danger text-bold-700">(*)</span></label>
					<div class="form-group">
            <select class="form-control" id="header_sub" name="header_sub" required>
                <option value="">Pilih</option>
                <?php foreach ($rks_header_sub as $v) { ?>
                    <option value="<?php echo $v['header_sub']?>"><?php echo $v['header_sub']?></option>
                <?php } ?>
            </select>
					</div>

					<label class="text-bold-700">Description <span class="text-danger text-bold-700">(*)</span></label>
					<div class="form-group position-relative has-icon-left">
						<textarea rows="6" class="form-control round" id="description" name="description" placeholder="Masukan Description" required></textarea>
						<div class="form-control-position">
							<i class="ft-airplay font-medium-2 text-muted"></i>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<input type="reset" class="btn btn-secondary btn-lg" data-dismiss="modal" value="Batal">
					<input type="submit" class="btn btn-info btn-lg" value="Update">
				</div>
			</form>
		</div>
	</div>
</div>

<script type="text/javascript">
  jQuery.extend({
    getCustomJSON: function(url) {
      var result = null;
      $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(data) {
          result = data;
        }
      });
      return result;
    }
  });

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('administration/master_data/rks') ?>";
    return [
      '<div class="btn-group">',
      '<a href="javascript:void(0)" class="btn btn-sm btn-info btn-xs action" data-id="'+ value +'" data-header_main="'+ row['header_main'] +'" data-header_sub="'+ row['header_sub'] +'" data-description="'+ row['description'] +'" data-toggle="modal" data-target="#editRks">',
      // '<a class="btn btn-sm btn-info btn-xs action" href="' + link + '/ubah/' + value + '">',
      '<i class="ft-edit mr-1"></i>Ubah',
      '</a>  ',
      '<a class="btn btn-sm btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="' + link + '/hapus/' + value + '">',
      '<i class="ft-trash mr-1"></i>Hapus',
      '</a></div>',
    ].join('');
  }
</script>

<script type="text/javascript">
  var $rks = $('#rks'),
    selections = [];
</script>

<script type="text/javascript">
  $(function() {

    $rks.bootstrapTable({

      url: "<?php echo site_url('administration/data_rks') ?>",
      cookieIdTable: "rks",
      value: "yes",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          width: '15%',
          formatter: operateFormatter,
        },
        {
          field: 'header_main',
          title: 'Header',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'header_sub',
          title: 'Sub',
          sortable: true,
          order: true,
          searchable: true,
          align: 'left',
          valign: 'middle'
        },
        {
          field: 'description',
          title: 'Description',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'created_at',
          title: 'Date Created',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle'
        }
      ]
    });
    setTimeout(function() {
      $anggaran.bootstrapTable('resetView');
    }, 200);

  });
</script>

<script>
	$(document).ready(function() {
		$('#editRks').on('show.bs.modal', function(event) {
			var div = $(event.relatedTarget)
			var modal = $(this)

			modal.find('#id').attr("value", div.data('id'));
			modal.find('#header_main').val(div.data('header_main'));
			modal.find('#header_sub').val(div.data('header_sub'));
			modal.find('#description').val(div.data('description'));
		});
	});
</script>
