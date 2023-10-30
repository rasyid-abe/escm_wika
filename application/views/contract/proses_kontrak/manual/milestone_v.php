<?php $contract_type = (isset($kontrak['contract_type'])) ? $kontrak["contract_type"] : "";
//if($contract_type != "HARGA SATUAN"){ ?>

  <div class="row">
    <div class="col-12">
      <div class="card">

        <div class="card-header border-bottom pb-2">
          <div class="btn-group-sm float-left">
              <span class="card-title text-bold-600 mr-2">Monitor Pembayaran</span> <span><a onclick="isShowAddTermin()" class="btn btn-info btn-sm"><i class="ft-plus"></i> Tambah</a></span>            
            </div>
            <div class="btn-group-sm float-right position-relative">
              <a class="btn btn-info action_milestone btn-plus">Simpan</a>
              <a class="btn btn-sm empty_milestone btn-trash" title="Hapus"><i class="ft-trash"></i></a>            
              <input type="hidden" id="current_milestone" value=""/>   
            </div>
        </div>

        <div class="card-content">
          <div class="card-body">
            <div id="showAddTermin" class="row" style="display: none;">
              <div class="col-md-6 row">
                <div class="form-group col-md-12 mb-1">
                  <label class="col-sm-4 control-label"><strong>Nomor invoice</strong> <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <input class="form-control" name="deskripsi_milestone_inp" id="deskripsi_milestone_inp" placeholder="Pembayaran tahap I" />
                  </div>
                </div>

                <div class="form-group col-md-12">
                  <label class="col-sm-4 control-label"><strong>Progress (%)</strong> <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8 mb-1">
                    <input class="form-control money" name="bobot_milestone_inp" id="bobot_milestone_inp" maxlength="6" placeholder="Maksimal 100%">
                  </div>
                  <label class="col-sm-4 control-label"><strong>Nilai</strong> <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8 mb-2">
                    <input class="form-control money" name="nilai_milestone_inp" id="nilai_milestone_inp" maxlength="15" placeholder="nilai">
                  </div>
                </div>
              </div>
              <div class="col-md-6 row">
                <div class="form-group col-md-12">
                  <label class="col-sm-4 control-label"><strong>Tanggal</strong> <span class="text-danger text-bold-700">*</span></label>
                  <div class="col-sm-8">
                    <div class="input-group date">                        
                      <input type="date" name="tanggal_milestone_inp" id="tanggal_milestone_inp" class="form-control" value="">
                    </div>
                  </div>
                </div>
                
                <?php $curval = set_value("milestone_file_inp"); ?>
                <div class="form-group col-md-12">
                  <label class="col-sm-4 control-label"><strong>Upload Dokumen</strong></label>
                  <div class="col-sm-8">
                    <div class="input-group">
                      <span class="input-group-btn">
                      <button type="button" data-id="milestone_file_inp" data-folder="<?php echo "contract/milestone" ?>" data-preview="preview_file2" class="btn btn-info upload mr-1" title="Upload"><i class="ft-upload"></i></button> 
                      </span> 
                      <input readonly type="text" class="form-control" id="milestone_file_inp" name="milestone_file_inp" value="<?php echo $curval ?>">
                      <span class="btn-group-">
                        <button type="button" data-url="<?php echo site_url("log/download_attachment/contract/milestone/".$curval) ?>" class="btn btn-info preview_upload ml-1" id="preview_file2" title="Preview"><i class="fa fa-share"></i></button> 
                        <button type="button" data-id="milestone_file_inp" data-folder="<?php echo "contract/milestone" ?>" data-preview="preview_file_2" class="btn btn-danger removefile rounded">
                          <i class="fa fa-trash"></i>
                        </button> 
                      </span>                         
                    </div>
                  </div>
                </div>  

              </div> 
            </div>

            <div class="table-responsive">
              <table class="table" id="milestone_table">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Invoice</th>
                    <th>Nilai</th>
                    <th>Progress (%)</th>
                    <th>Tanggal</th>
                    <th>Lampiran</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>    

                  <?php 
                    $no = 1;
                    if(isset($milestone) && !empty($milestone)){
                      foreach ($milestone as $key => $value) { 
                      $myid = $key+1;
                  ?>

                  <tr>   
                    <td><?php echo $no++; ?></td>                      
                    <td>
                      <input type="hidden" value="<?php echo $value['description'] ?>" name="deskripsi_milestone[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="deskripsi_milestone">
                      <?php echo $value['description'] ?>
                    </td>
                    <td class="money">
                      <input type="hidden" value="<?php echo inttomoney($value['nilai']) ?>" name="nilai_milestone[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="nilai_milestone">
                      <?php echo inttomoney($value['nilai']) ?>
                    </td>
                    <td class="money">
                      <input type="hidden" value="<?php echo inttomoney($value['percentage']) ?>" name="bobot_milestone[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="bobot_milestone">
                      <?php echo inttomoney($value['percentage']) ?>
                    </td>
                    <td>
                      <input type="hidden" value="<?php echo date("Y-m-d",strtotime($value['target_date'])) ?>" name="tanggal_milestone[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="tanggal_milestone">
                      <?php echo date("Y-m-d",strtotime($value['target_date'])) ?>
                    </td>
                    <td>
                      <input type="hidden" value="<?php echo $value['milestone_file'] ?>" name="milestone_file[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="milestone_file">
                      <a href='<?php echo site_url("log/download_attachment/contract/milestone/".$value['milestone_file']) ?>' target="_blank"><?php echo $value['milestone_file'] ?></a>                      
                    </td>
                    <td>
                      <button data-no="<?php echo $myid ?>" class="btn btn-info btn-sm edit_milestone" type="button">
                        <i class="fa fa-edit"></i>
                        <?php  ?>
                        <input type="hidden" name="milestone_id[<?php echo $myid ?>]" value="<?php echo $myid ?>"/>
                      </button>
                    </td>
                  </tr>

                  <?php } } ?>    

                </tbody>
              </table>
            </div>

          </div>
        </div>

      </div>
    </div>
  </div>

  <script type="text/javascript">

    $(document).ready(function(){

      $(".action_milestone").click(function(){

        var url_file = '<?php echo site_url("log/download_attachment/contract/milestone/") ?>';
        var current_milestone = $("#current_milestone").val();
        var no = current_milestone;

        if(current_milestone == ""){
          no = ($("#milestone_table tr").length) ? parseInt($("#milestone_table tr").length) : 1;
        }

        var mybobot = 0;

        $("#milestone_table tbody tr").each(function(i,val){
          
          var v = $(this).find(".bobot_milestone_inp").val();
          mybobot += moneytoint(v);

        });

        var deskripsi = $("#deskripsi_milestone_inp").val();
        var nilai_milestone = $("#nilai_milestone_inp").val();
        var tanggal = $("#tanggal_milestone_inp").val();
        var bobot = moneytoint($("#bobot_milestone_inp").val());
        var milestone_file = $("#milestone_file_inp").val();

        if(deskripsi == ""){

          alert("Isi deskripsi milestone");

        } else if(tanggal == ""){

          alert("Isi tanggal milestone");

        } else if(nilai_milestone == ""){

          alert("Isi nilai milestone");

        } else if(bobot == ""){

          alert("Isi progress milestone");

        } else if(parseFloat(mybobot+bobot) > 100){

          alert("Progress harus dibawah 100");

        } else {

          bobot = inttomoney(bobot);

          var html = "<tr>";
          html += "<td>"+no+"</td>";
          html += "<td><input type='hidden' class='deskripsi_milestone' data-no='"+no+"' name='deskripsi_milestone["+no+"]' value='"+deskripsi+"'/>"+deskripsi+"</td>";
          html += "<td class='text-right money'><input type='hidden' class='nilai_milestone' data-no='"+no+"' name='nilai_milestone["+no+"]' value='"+nilai_milestone+"'/>"+nilai_milestone+"</td>";
          html += "<td class='text-right money'><input type='hidden' class='bobot_milestone' data-no='"+no+"' name='bobot_milestone["+no+"]' value='"+bobot+"'/>"+bobot+"</td>";
          html += "<td><input type='hidden' class='tanggal_milestone' data-no='"+no+"' name='tanggal_milestone["+no+"]' value='"+tanggal+"'/>"+tanggal+"</td>";
          html += "<td class='text-right'><input type='hidden' class='milestone_file' data-no='"+no+"' name='milestone_file["+no+"]' value='"+milestone_file+"'/><a href='"+url_file+milestone_file+"'>"+milestone_file+"</a></td>";          
          html += "<td><button type='button' class='btn btn-info btn-sm edit_milestone' data-no='"+no+"'><i class='fa fa-edit'></i></button></td>";
          html += "</tr>";

          $("#milestone_table").append(html);
          $("#deskripsi_milestone_inp").val("");
          $("#tanggal_milestone_inp").val("");
          $("#bobot_milestone_inp").val("");
          $("#milestone_file_inp").val("");
          $("#current_milestone").val("");
          $("#nilai_milestone_inp").val("");
          
        }

      });

      $(document.body).on("click",".empty_milestone",function(){

        $("#deskripsi_milestone_inp").val("");
        $("#tanggal_milestone_inp").val("");
        $("#bobot_milestone_inp").val("");
        $("#milestone_file_inp").val("");
        $("#current_milestone").val("");
        $("#nilai_milestone_inp").val("");

      });

      $(document.body).on("click",".edit_milestone",function(){

        var no = $(this).attr('data-no');
        var deskripsi = $(".deskripsi_milestone[data-no='"+no+"']").val();
        var nilai_milestone = $(".nilai_milestone[data-no='"+no+"']").val();
        var bobot = $(".bobot_milestone[data-no='"+no+"']").val();
        var tanggal = $(".tanggal_milestone[data-no='"+no+"']").val();
        var milestone_file = $(".milestone_file[data-no='"+no+"']").val();

        $("#current_milestone").val(no);
        $("#deskripsi_milestone_inp").val(deskripsi);
        $("#nilai_milestone_inp").val(inttomoney(nilai_milestone));
        $("#tanggal_milestone_inp").val(tanggal);
        $("#bobot_milestone_inp").val(bobot);
        $("#milestone_file_inp").val(milestone_file);

        $(this).parent().parent().remove();

        return false;

      });

    })

    function isShowAddTermin() {
      var div_add = document.getElementById("showAddTermin");
      var div_btn = document.getElementById("showButtonTermin");
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

  </script>

<?php //} ?>