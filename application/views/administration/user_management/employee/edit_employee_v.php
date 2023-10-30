<div class="wrapper wrapper-content">
  <form method="post" action="<?php echo site_url($controller_name . "/submit_edit_employee"); ?>" class="form-horizontal">

    <input type="hidden" name="id" value="<?php echo $id ?>">

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins p-3">
          <div class="card-title">
            <h5>Ubah Employee</h5>
          </div>

          <div class="card-content">
            <div class="form-group row">
              <div class="col-md-6">
                <?php $curval = $data['npp']; ?>
                <label class="col-sm-4 control-label">NPP</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="npp_employee_inp" maxlength="10" name="npp_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <div class="col-md-6">
                <?php $curval = $data["adm_salutation_id"]; ?>
                <label class="col-sm-4 control-label">Salutation</label>
                <div class="col-sm-8">
                  <select required class="form-control" name="salutation_employee_inp">
                    <option value="">Pilih</option>
                    <?php
                    foreach ($salutation as $key => $val) {
                      $selected = ($val['adm_salutation_id'] == $curval) ? "selected" : "";
                    ?>
                      <option <?php echo $selected ?> value="<?php echo $val['adm_salutation_id'] ?>"><?php echo $val['adm_salutation_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <?php $curval = $data["firstname"]; ?>
                <label class="col-sm-4 control-label">Nama Depan</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" required name="firstname_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <div class="col-md-6">
                <?php $curval = $data["lastname"]; ?>
                <label class="col-sm-4 control-label">Nama Belakang</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="lastname_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <?php $curval = $data["phone"]; ?>
                <label class="col-sm-4 control-label">Telepon</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="phone_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <div class="col-md-6">
                <?php $curval = $data['employee_type_id']; ?>
                <label class="col-sm-4 control-label">Tipe</label>
                <div class="col-sm-8">
                  <select required class="form-control" name="type_employee_inp">
                    <option value="">Pilih</option>
                    <?php
                    foreach ($type as $key => $val) {
                      $selected = ($val['employee_type_id'] == $curval) ? "selected" : "";
                    ?>
                      <option <?php echo $selected ?> value="<?php echo $val['employee_type_id'] ?>"><?php echo $val['employee_type_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-md-6">
                <?php $curval = $data["status"]; ?>
                <label class="col-sm-4 control-label">Status</label>
                <div class="col-sm-8">
                  <select required class="form-control" name="status_inp">
                    <?php $selected = ($curval == 1) ? "selected" : ""; ?>
                    <option <?php echo $selected ?> value="1">Aktif</option>
                    <?php $selected = ($curval == 0) ? "selected" : ""; ?>
                    <option <?php echo $selected ?> value="0">Nonaktif</option>
                  </select>
                </div>
              </div>

              <div class="col-md-6">
                <?php $curval = $data["type_proyek"]; ?>
                <label class="col-sm-4 control-label">Jenis Proyek</label>
                <div class="col-sm-8">
                  <select required class="form-control" name="type_proyek_inp">
                    <option value="">Pilih</option>
                    <option value="Proyek" <?php echo $curval == 'Proyek' ? 'selected' : '' ?> >Proyek</option>                      
                    <option value="Matgis" <?php echo $curval == 'Matgis' ? 'selected' : '' ?>>Matgis</option>                      
                  </select>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <br>

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins p-3">
          <div class="card-title">
            <h5>Company Information</h5>
          </div>

          <div class="card-content">
            <div class="form-group row">
              <div class="col-md-6">
                <?php $curval = $data["email"]; ?>
                <label class="col-sm-4 control-label">Email Address</label>
                <div class="col-sm-8">
                  <input type="email" class="form-control" id="email_employee_inp" name="email_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <div class="col-md-6">
                <?php $curval = $data["officeextension"]; ?>
                <label class="col-sm-4 control-label">Office Extention</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" id="offc_ext_employee_inp" name="offc_ext_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins p-3">
          <div class="card-title">
            <h5>Job Position</h5>
          </div>

          <div class="card-content">
            <div class="table-responsive">
              <a class="btn btn-primary" href="<?php echo site_url('administration/user_management/employee/add_job_post/' . $id) ?>" role="button">Tambah</a>
              <table id="job_post" class="table table-bordered table-striped"></table>
            </div>

          </div>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins p-3">
          <div class="card-title">
            <h5>Proyek</h5>
          </div>

          <div class="card-content">
            <div class="table-responsive">
              <a class="btn btn-primary" href="<?php echo site_url('administration/user_management/employee/add_proyek_post/' . $id) ?>" role="button">Tambah</a>
              <table id="proyek_post" class="table table-bordered table-striped"></table>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-lg-12">
        <div class="card float-e-margins p-3">
          <div class="card-title">
            <h5>Kategori</h5>
          </div>

          <div class="card-content">
            <div class="table-responsive">
              <a class="btn btn-primary" href="<?php echo site_url('administration/user_management/employee/add_category_post/' . $id) ?>" role="button">Tambah</a>
              <table id="category_post" class="table table-bordered table-striped"></table>
            </div>
          </div>
        </div>

      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div>
          <?php echo buttonsubmit('administration/user_management/employee', lang('back'), lang('save')) ?>
        </div>
      </div>
    </div>
</div>
</form>


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

  function detailFormatter(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('administration') ?>/" + url);

    var html = [];
    $.each(row, function(key, value) {
      var data = $.grep(mydata, function(e) {
        return e.field == key;
      });

      if (typeof data[0] !== 'undefined') {

        html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
      }
    });

    return html.join('');

  }

  function detailFormatter2(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('administration') ?>/" + url);

    var html = [];
    $.each(row, function(key, value) {
      var data = $.grep(mydata, function(e) {
        return e.field == key;
      });

      if (typeof data[0] !== 'undefined') {

        html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
      }
    });

    return html.join('');

  }

  function detailFormatter3(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('administration') ?>/" + url);

    var html = [];
    $.each(row, function(key, value) {
      var data = $.grep(mydata, function(e) {
        return e.field == key;
      });

      if (typeof data[0] !== 'undefined') {

        html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
      }
    });

    return html.join('');

  }

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('administration/user_management/employee') ?>";
    return [
      '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="' + link + '/hapus_job_post/' + value + '">',
      'Hapus',
      '</a>  ',
    ].join('');
  }

  function operateFormatter2(value, row, index) {
    var link = "<?php echo site_url('administration/user_management/employee') ?>";
    return [
      '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="' + link + '/hapus_proyek_post/' + value + '">',
      'Hapus',
      '</a>  ',
    ].join('');
  }

  function operateFormatter3(value, row, index) {
    var link = "<?php echo site_url('administration/user_management/employee') ?>";
    return [
      '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="' + link + '/hapus_category_post/' + value + '">',
      'Hapus',
      '</a>  ',
    ].join('');
  }

  function totalTextFormatter(data) {
    return 'Total';
  }

  function totalNameFormatter(data) {
    return data.length;
  }

  function totalPriceFormatter(data) {
    var total = 0;
    $.each(data, function(i, row) {
      total += +(row.price.substring(1));
    });
    return '$' + total;
  }
</script>

<script type="text/javascript">
  var $job_post = $('#job_post'),
    selections = [];
</script>

<script type="text/javascript">
  var $proyek_post = $('#proyek_post'),
    selections2 = [];
</script>

<script type="text/javascript">
  var $category_post = $('#category_post'),
    selections3 = [];
</script>

<script type="text/javascript">
  $(function() {

    $job_post.bootstrapTable({

      url: "<?php echo site_url('administration/data_job_post/' . $id) ?>",
      cookieIdTable: "adm_employee_pos",
      idField: "employee_pos_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'employee_pos_id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          formatter: operateFormatter,
        },
        {
          field: 'pos_name',
          title: 'Posisi',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'dept_name',
          title: 'Departemen',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'district_name',
          title: 'Kantor',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'is_active',
          title: 'Aktif ',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'is_main_job',
          title: 'Posisi Utama',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
      ]

    });
    setTimeout(function() {
      $job_post.bootstrapTable('resetView');
    }, 200);

    $job_post.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter(index, row, "alias_employee"));
    });

  });
</script>

<script type="text/javascript">
  $(function() {

    $proyek_post.bootstrapTable({

      url: "<?php echo site_url('administration/data_proyek_post/' . $id) ?>",
      cookieIdTable: "adm_employee_proyek",
      idField: "id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          formatter: operateFormatter2,
        },
        {
          field: 'ppm_project_id',
          title: 'Project ID',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'ppm_project_name',
          title: 'Project Name',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'ppm_dept_id',
          title: 'Dept ID',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'ppm_dept_name',
          title: 'Dept Name',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        }
      ]

    });
    setTimeout(function() {
      $proyek_post.bootstrapTable('resetView');
    }, 200);

    $proyek_post.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter2(index, row, "alias_employee"));
    });

  });
</script>

<script type="text/javascript">
  $(function() {

    $category_post.bootstrapTable({

      url: "<?php echo site_url('administration/data_category_post/' . $id) ?>",
      cookieIdTable: "adm_employee_cat",
      idField: "id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [{
          field: 'id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          formatter: operateFormatter3,
        },
        {
          field: 'category',
          title: 'Kategori',
          sortable: true,
          order: true,
          searchable: true,
          align: 'center',
          valign: 'middle'
        }
      ]

    });
    setTimeout(function() {
      $category_post.bootstrapTable('resetView');
    }, 200);

    $category_post.on('expand-row.bs.table', function(e, index, row, $detail) {
      $detail.html(detailFormatter3(index, row, "alias_employee"));
    });

  });
</script>