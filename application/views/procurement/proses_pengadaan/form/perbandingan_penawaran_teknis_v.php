<div class="row">
  <div class="col-lg-12">

    <form class="form-horizontal" id="eval_tech_form">

        <div class="card-title">
          <h5>PERBANDINGAN PENAWARAN TEKNIS</h5>

        </div>

        <div class="card-content">

          <div class="row">

            <div class="col-xs-5">
              <p>Template Evaluasi : <strong><?php echo $evaltemp['evt_name'] ?></strong></p>
            </div>

            <div class="col-xs-2">
              <p>Bobot Teknis : <strong><?php echo $evaltemp['evt_tech_weight'] ?></strong></p>
            </div>

            <div class="col-xs-2">
              <p>Passing Grade : <strong><?php echo $evaltemp['evt_passing_grade'] ?></strong></p>
            </div>

          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-sm table-bordered">
              <thead>
                <tr>
                  <th class="align-middle text-center" rowspan="2">No</th>
                  <th class="align-middle" rowspan="2">Item & Parameter</th>
                  <th class="align-middle text-center" rowspan="2">Bobot</th>
                  <?php foreach ($vendor as $key => $value) { ?>
                  <th class="text-center" colspan="3"><?php echo $value['vendor_name'] ?></th>
                  <?php } ?>
                </tr>
                <tr>
                  <?php foreach ($vendor as $key => $value) { ?>
                   <th class="text-center col-2">Bobot * Nilai</th>
                   <th class="text-center">Deskripsi</th>
                   <th class="text-center">Lampiran</th>
                   <?php } ?>
                 </tr>
               </thead>

               <tbody>

                <?php
                $i = 0;
                $n = 1;
                foreach ($teknis as $key => $value) { ?>

                  <tr>
                    <td class="text-center text-bold-700"><?php echo $n ?></td>
                    <td class="text-bold-700"><?php echo $value['item'] ?></td>
                    <td class="text-center text-bold-700"><?php echo $value['weight'] ?>%</td>

                    <?php foreach ($value['child'] as $k => $v) { ?>
                      <td class="text-center text-bold-700">
                        <?php //echo ($value['weight']/100) * $v['value'] ?>
                        <?php if($act == "edit"){ ?>
                          <input class="form-control money col-sm-12 text-center" data-v-min="0" data-v-max="100" maxlength="5" name="eval_tech[<?php echo $v['id'] ?>]" value="<?php echo $v['value'] ?>">
                        <?php } else { ?>
                        <?php echo ($value['weight']/100) * $v['value'] ?>
                        <?php } ?>  
                      </td>
                      <td class="text-center text-bold-700"><?php echo $v['desc'] ?></td>
                      <td class="text-right" style="display:none;">
                      <?php if($act == "edit"){ ?>                        
                      <?php } else { ?>
                      <?php echo $v['value'] ?>
                      <?php } ?>
                    </td>
                    <td>
                    <?php if(!empty($v['file'])){ ?>                    
                      <!-- haqim -->
                      <a target="_blank" href="<?php echo site_url('log/download_attachment_extranet/teknis/'.$v['vendor_id'].'/'.$v['file']); ?>">Download<a/>
                      <!-- end -->
                      <?php } ?>
                    </td>
                    <?php } ?>
                  </tr>

                  <?php $i = 0; foreach ($value['lists_parameter_score'] as $kes_param => $value_param) :?>
                    <tr>
                      <td>&nbsp;</td>
                      <td class="align-middle">-- <?php echo $value_param['deskripsi']?> </td>
                      <td class="text-center align-middle p-2"><?php echo $value_param['bobot']?> </td>
                      <?php $c = 1; foreach ($value['child'] as $k => $v2) { ?>
                        <td class="text-center" rowspan="1" colspan="1">                          
                          <?php if($act == "edit") { ?>                          
                          <?php } else { ?>
                          <?php echo $v2['value'] ?>
                          <?php } ?>
                        </td>
                        <td></td>
                        <td></td>
                      <?php $c++; } ?>
                    </tr>

                  <?php endforeach; ?> 
                
                <?php $n++; } ?>

                </tbody>
              </table>
            </div>
          </div>
        

        <hr/>

        
          <div class="card-title">
            <h5>NILAI TEKNIS</h5>
          </div>

          <div class="card-content">
            <div class="table-responsive">
              <table class="table table-sm table-bordered">
                <thead>
                  <tr>
                    <th class="text-center">No</th>
                    <th>Nama Vendor</th>
                    <th class="text-center">Nilai Teknis</th>
                    <th>Catatan</th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($nilai as $key => $value) { ?>
                  <tr>
                    <td class="text-center"><?php echo $key+1 ?></td>
                    <td><?php echo $value['vendor_name'] ?></td>
                    <td class="vendor_tech_value text-center" data-id="<?php echo $value['ptv_vendor_code'] ?>"><?php echo $value['pte_technical_value'] ?></td>
                    <td>
                      <?php if($act == "edit"){ ?>
                      <input class="form-control" name="eval_note[<?php echo $value['pte_id'] ?>]" value="<?php echo $value['pte_technical_remark'] ?>">
                      <?php } else { ?>
                      <?php echo $value['pte_technical_remark'] ?>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php if($act == "edit"){ ?>
          <div class="text-center">            
            <a href="#" class="btn btn-info pl-3 pr-3" id="calculate_tech">Hitung Nilai Teknis</a>
            <hr/>
          </div>
          <?php } ?>
        

      </form>

        <div class="card-title">
          <h5>KOMENTAR EVALUASI TEKNIS</h5>

        </div>

        <div class="card-content">

          <?php if($act == "edit"){ ?>

          <form class="form-horizontal" id="eval_com_form">

            <div class="row form-group">
              <label class="col-sm-2 control-label">Vendor</label>
              <div class="col-sm-5">
                <select class="form-control select2 vendor" style="width:100%;" name="vendor_eval_inp">
                  <?php foreach ($nilai as $kx => $vx) { ?>
                  <option value="<?php echo $vx['ptv_vendor_code'] ?>"><?php echo $vx['vendor_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-sm-2 control-label"><?php echo lang('comment') ?> *</label>
              <div class="col-sm-8">
                <textarea name="comment_eval_inp" id="comment_eval_inp" maxlength="1000" required class="form-control"></textarea>
              </div>
            </div>

            <div class="row form-group">
              <label class="col-sm-2 control-label"> </label>
              <div class="col-sm-10">
                <input type="hidden" name="type_eval_inp" value="T">
                <a href="#" class="btn btn-info" id="eval_com_btn">Simpan</a>
              </div>
            </div>

          </form>

          <br/>

          <?php } ?>

          <table id="eval_com_table" class="table table-bordered table-striped"></table>

        </div>
      

      <hr/>
      <div class="text-center">
        <button type="button" class="btn btn-info reloadeval">Kembali</button>
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

  </script>

  <script type="text/javascript">

    var $eval_com_table = $('#eval_com_table'),
    selections = [];

  </script>

  <script type="text/javascript">

    $(function () {

      $eval_com_table.bootstrapTable({

        url: "<?php echo site_url('Procurement/data_eval_com') ?>/T",

        cookieIdTable:"eval_com",

        idField:"pec_id",

        <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

        columns: [
        {
          field: 'pec_datetime',
          title: 'Tanggal & Waktu',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'pec_name',
          title: 'Nama',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle'
        },
        {
          field: 'pec_vendor_name',
          title: 'Nama Vendor',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle'
        },

        {
          field: 'pec_comment',
          title: 'Komentar',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },

        ]

      });

      setTimeout(function () {
        $eval_com_table.bootstrapTable('resetView');
      }, 200);

      $("#eval_com_btn").on("click",function(){
        var comment = $("#comment_eval_inp").val();
        if(comment == ""){
          alert("Isi komentar");
        } else {
          var data = $("#eval_com_form").serialize();
          $.ajax({
            url:"index.php/procurement/save_eval_com",
            data:data,
            type:"post",
            success:function(x){
              $("#comment_eval_inp").val("");
              $("#eval_com_table").bootstrapTable('refresh');
            }
          });
        }
        return false;
      });

      $("#calculate_tech").on("click",function(){
        var data = $("#eval_tech_form").serialize();
        $.ajax({
          url:"index.php/procurement/calculate_eval_tech",
          data:data,
          type:"post",
          dataType:"json",
          success:function(x){
            $(".vendor_tech_value").each(function(i,val){
              var id = $(this).attr("data-id");
              $(this).html(x[id]);
            });
            alert("Berhasil kalkulasi nilai teknis");
          }
        });
        return false;
      });

    });

  </script>
