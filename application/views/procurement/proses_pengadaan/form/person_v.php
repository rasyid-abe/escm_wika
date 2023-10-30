<div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header border-bottom pb-2">
        <div class="btn-group-sm float-left">
          <span class="card-title text-bold-600 mr-2">Person In Charge</span> <span><a onclick="isShowAddPerson()" class="btn btn-info btn-sm"><i class="ft-plus"></i> Tambah</a></span>
        </div>
        <div class="btn-group-sm float-right position-relative" id="showButtonPerson" style="display: none">
          <a class="btn btn-info action_person btn-plus">Simpan</a>
          <a class="btn btn-sm empty_person btn-trash" title="Hapus"><i class="ft-trash"></i></a>
          <input type="hidden" id="current_person" value="" />
        </div>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="showAddPerson" style="display: none">

            <div class="row mb-2">
              <!-- left-side -->
              <div class="col-sm">
                <div class="row form-group mb-2">
                  <label class="col-sm-4 control-label">Perusahaan <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <select class="form-control select2 bg-select" name="perusahaan_inp" id="perusahaan_inp" style="width: 100%" onchange="typePerusahaan()">
                      <option value="">Pilih Perusahaan</option>
                      <?php foreach ($bidderList as $key => $val) { ?>
                        <option value='<?php echo $val['vendor_name']; ?>'><?php echo $val['vendor_name']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div id="user_wika" style="display: none">
                  <div class="row form-group mb-2">
                    <label class="col-sm-4 control-label">Nama Lengkap <span class="text-danger text-bold-700">*</span> </label>
                    <div class="col-sm-8">
                      <select class="form-control select2" name="user_inp" id="user_inp" style="width: 100%">
                        <option value="">Pilih</option>
                        <?php foreach ($adm_user as $v) { ?>
                          <option value="<?php echo $v['complete_name']; ?>"><?php echo $v['complete_name']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div id="user_manual">
                  <div class="row form-group mb-2">
                    <label class="col-sm-4 control-label">Nama Lengkap <span class="text-danger text-bold-700">*</span> </label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="user_manual_inp" id="user_manual_inp" placeholder="User manual">
                    </div>
                  </div>
                </div>
                <div class="row form-group mb-2">
                  <label class="col-sm-4 control-label">Jabatan <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="jabatan_inp" id="jabatan_inp" placeholder="Jabatan">
                  </div>
                </div>
                <div class="row form-group mb-2">
                  <label class="col-sm-4 control-label">Divisi <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="divisi_inp" id="divisi_inp" placeholder="Nama divisi">
                  </div>
                </div>
              </div>

              <!-- right-side -->
              <div class="col-sm">
                <div class="row form-group mb-2">
                  <label class="col-sm-4 control-label">No. Telpon <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <input type="text" maxlength="13" class="form-control" name="telp_inp" id="telp_inp" placeholder="Nomor telepon">
                  </div>
                </div>
                <div class="row form-group mb-2">
                  <label class="col-sm-4 control-label">Email <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <input type="email" class="form-control" name="email_inp" id="email_inp" placeholder="Email">
                  </div>
                </div>
                <div class="row form-group mb-2">
                  <label class="col-sm-4 control-label">Keterangan <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <textarea class="form-control" name="person_keterangan_inp" id="person_keterangan_inp" placeholder="Keterangan"></textarea>
                  </div>
                </div>
              </div>

            </div>

          </div>

          <div class="table-responsive table-striped">
            <table class="table" id="person_table" style="margin-bottom: 0;">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama</th>
                  <th>Jabatan</th>
                  <th>Divisi</th>
                  <th>Perusahaan</th>
                  <th>No. Telpon</th>
                  <th>Email</th>
                  <th>Keterangan</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $no = 1;
                if (isset($person) && !empty($person)) {
                  foreach ($person as $key => $value) {
                    $myid = $key + 1;
                ?>

                    <tr>
                      <td><?php echo $no++; ?></td>
                      <td>
                        <input type="hidden" value="<?php echo $value['pp_nama_lengkap'] ?>" name="user[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="user">
                        <input type="hidden" value="<?php echo $value['pp_nama_lengkap'] ?>" name="user_manual[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="user_manual">
                        <?php echo $value['pp_nama_lengkap'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['pp_jabatan'] ?>" name="jabatan[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="jabatan">
                        <?php echo $value['pp_jabatan'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['pp_divisi'] ?>" name="divisi[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="divisi">
                        <?php echo $value['pp_divisi'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['pp_nama_perusahaan'] ?>" name="perusahaan[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="perusahaan">
                        <?php echo $value['pp_nama_perusahaan'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['pp_no_telp'] ?>" name="telp[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="telp">
                        <?php echo $value['pp_no_telp'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['pp_email'] ?>" name="email[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="email">
                        <?php echo $value['pp_email'] ?>
                      </td>
                      <td>
                        <input type="hidden" value="<?php echo $value['pp_note'] ?>" name="person_keterangan[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="person_keterangan">
                        <?php echo $value['pp_note'] ?>
                      </td>
                      <td>
                        <?php echo $value['pp_created_date'] ?>
                      </td>
                      <td>
                        <button data-no="<?php echo $myid ?>" class="btn btn-info btn-sm edit_person" type="button">
                          <i class="fa fa-edit"></i>
                          <?php  ?>
                          <input type="hidden" name="person_id[<?php echo $myid ?>]" value="<?php echo $myid ?>" />
                        </button>
                      </td>
                    </tr>

                <?php }
                } ?>
              </tbody>
            </table>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {

    // Basic Select2 select
    $(".select2").select2();

    $(".action_person").click(function() {

      var current_person = $("#current_person").val();
      var no = current_person;
      var user = $("#user_inp").val();
      var user_manual = $("#user_manual_inp").val();
      var jabatan = $("#jabatan_inp").val();
      var divisi = $("#divisi_inp").val();
      var perusahaan = $("#perusahaan_inp").val();
      var telp = $("#telp_inp").val();
      var email = $("#email_inp").val();
      var person_keterangan = $("#person_keterangan_inp").val();

      if (current_person == "") {
        if (getMaxDataNo(".edit_person") == null) {
          no = 1;
        } else {
          no = getMaxDataNo(".edit_person") + 1;
        }

      } else {}

      if (jabatan == "") {

        alert("Jabatan tidak boleh kosong.");

      } else if (user == "" && user_manual == "") {

        alert("User tidak boleh kosong.");

      } else if (divisi == "") {

        alert("Divisi tidak boleh kosong.");

      } else if (perusahaan == "") {

        alert("Perusahaan tidak boleh kosong.");

      } else if (telp == "") {

        alert("Nomor Telepon tidak boleh kosong.");

      } else if (email == "") {

        alert("Email tidak boleh kosong.");

      } else if (person_keterangan == "") {

        alert("Keterangan tidak boleh kosong.");

      } else {

        var html = "<tr>";
        html += "<td>" + no + "</td>";
        if (user == "") {
          html += "<td class='text-center'><input type='hidden' class='user_manual' data-no='" + no + "' name='user_manual[" + no + "]' value='" + user_manual + "'/><input type='hidden' class='user' data-no='" + no + "' name='user[" + no + "]' value='" + user + "'/>" + user_manual + "</td>";
        }
        if (user_manual == "") {
          html += "<td class='text-center'><input type='hidden' class='user' data-no='" + no + "' name='user[" + no + "]' value='" + user + "'/><input type='hidden' class='user_manual' data-no='" + no + "' name='user_manual[" + no + "]' value='" + user_manual + "'/>" + user + "</td>";
        }
        html += "<td class='text-left'><input type='hidden' class='jabatan' data-no='" + no + "' name='jabatan[" + no + "]' value='" + jabatan + "'/>" + jabatan + "</td>";
        html += "<td class='text-left'><input type='hidden' class='divisi' data-no='" + no + "' name='divisi[" + no + "]' value='" + divisi + "'/>" + divisi + "</td>";
        html += "<td class='text-left'><input type='hidden' class='perusahaan' data-no='" + no + "' name='perusahaan[" + no + "]' value='" + perusahaan + "'/>" + perusahaan + "</td>";
        html += "<td class='text-left'><input type='hidden' class='telp' data-no='" + no + "' name='telp[" + no + "]' value='" + telp + "'/>" + telp + "</td>";
        html += "<td class='text-left'><input type='hidden' class='email' data-no='" + no + "' name='email[" + no + "]' value='" + email + "'/>" + email + "</td>";
        html += "<td class='text-left'><input type='hidden' class='person_keterangan' data-no='" + no + "' name='person_keterangan[" + no + "]' value='" + person_keterangan + "'/>" + person_keterangan + "</td>";
        html += "<td class='text-left'>-</td>";
        html += "<td><button type='button' class='btn btn-info btn-sm edit_person' data-no='" + no + "'><i class='fa fa-edit'></i></button></td>";
        html += "</tr>";

        $("#person_table").append(html);
        $("#user_inp").val("");
        $("#user_manual_inp").val("");
        $("#jabatan_inp").val("");
        $("#divisi_inp").val("");
        $("#perusahaan_inp").val("");
        $("#telp_inp").val("");
        $("#email_inp").val("");
        $("#person_keterangan").val("");
        $("#person_keterangan_inp").val("");
      }

    });

    $(document.body).on("click", ".empty_person", function() {
      $("#current_person").val("");
      $("#user_inp").val("");
      $("#user_manual_inp").val("");
      $("#jabatan_inp").val("");
      $("#divisi_inp").val("");
      $("#perusahaan_inp").val("");
      $("#telp_inp").val("");
      $("#email_inp").val("");
      $("#person_keterangan_inp").val("");
    });

    $(document.body).on("click", ".edit_person", function() {
      var no = $(this).attr('data-no');
      var user = $(".user[data-no='" + no + "']").val();
      var user_manual = $(".user_manual[data-no='" + no + "']").val();
      var jabatan = $(".jabatan[data-no='" + no + "']").val();
      var divisi = $(".divisi[data-no='" + no + "']").val();
      var perusahaan = $(".perusahaan[data-no='" + no + "']").val();
      var telp = $(".telp[data-no='" + no + "']").val();
      var email = $(".email[data-no='" + no + "']").val();
      var person_keterangan = $(".person_keterangan[data-no='" + no + "']").val();

      $("#current_person").val(no);
      $("#user_inp").val(user).trigger('change');
      $("#user_manual_inp").val(user_manual);
      $("#jabatan_inp").val(jabatan);
      $("#divisi_inp").val(divisi);
      $("#perusahaan_inp").val(perusahaan).trigger('change');
      $("#telp_inp").val(telp);
      $("#email_inp").val(email);
      $("#person_keterangan_inp").val(person_keterangan);

      $(this).parent().parent().remove();

      return false;

    });

  })

  function isShowAddPerson() {
    var div_add = document.getElementById("showAddPerson");
    var div_btn = document.getElementById("showButtonPerson");
    if (div_add.style.display !== "none") {
      div_add.style.display = "none";
    } else {
      div_add.style.display = "block";
    }

    if (div_btn.style.display !== "none") {
      div_btn.style.display = "none";
    } else {
      div_btn.style.display = "block";
    }
  }

  function isShowAddDok() {
    var div_add = document.getElementById("showAddDok");
    var div_btn = document.getElementById("showButtonDok");
    if (div_add.style.display !== "none") {
      div_add.style.display = "none";
    } else {
      div_add.style.display = "block";
    }

    if (div_btn.style.display !== "none") {
      div_btn.style.display = "none";
    } else {
      div_btn.style.display = "block";
    }
  }

  function typePerusahaan() {
    var x = document.getElementById("perusahaan_inp").value;
    var div_wika = document.getElementById("user_wika");
    var div_manual = document.getElementById("user_manual");

    if (x == 'PT WIJAYA KARYA (Persero) Tbk') {
      div_wika.style.display = "block";
      div_manual.style.display = "none";
      $("#user_manual_inp").val("");
    } else {
      div_wika.style.display = "none";
      div_manual.style.display = "block";
      $("#user_inp").val("");
    }
  }

  // Restricts input for the given textbox to the given inputFilter.
  function setInputFilter(textbox, inputFilter) {
    ["input"].forEach(function(event) {
      textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
          this.oldValue = this.value;
          this.oldSelectionStart = this.selectionStart;
          this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
          this.value = this.oldValue;
          this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        } else {
          this.value = "";
        }
      });
    });
  }

  // Install input filters.
  setInputFilter(document.getElementById("telp_inp"), function(value) {
    return /^-?\d*$/.test(value);
  });

  function getMaxDataNo(selector) {
    var min = null,
        max = null;
    $(selector).each(function() {
        var no_pp = parseInt($(this).attr('data-no'), 10);
        if ((max === null) || (no_pp > max)) {
            max = no_pp;
        }
    });
    return max;
  }
    
</script>