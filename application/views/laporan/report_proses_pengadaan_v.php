<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
         <h5>Jumlah Paket Pengadaan</h5>
         <div class="card-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
          <ul class="dropdown-menu dropdown-user">
            <li><a href="#">Config option 1</a>
            </li>
            <li><a href="#">Config option 2</a>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-content" style="">
        <form id="form-field">
         <div class="form-group">

           <label class="col-sm-2 control-label">Tanggal Mulai RFQ</label>
           <div class="col-lg-3">
             <input type="date" class="form-control money" name="mulai" id="mulai" onchange="getTanggalMulai(this)">
           </div>

           <div class="col-sm-1"><p class="form-control-static" align="center">S/D</p></div>

           <label class="col-sm-2 control-label">Tanggal Selesai RFQ</label>
           <div class="col-lg-3">
             <input type="date" class="form-control money" name="akhir" id="akhir" onchange="getTanggalAkhir(this)">
           </div>

           <a data-tglMulai="1998" data-tglAkhir="2000" class="btn btn-primary submit btn-md" value="Kirim">Kirim</a>


         </div>          
       </form>
     </div>
   </div>


   <div class="row">
    <div class="col-lg-12">

      <div class="card float-e-margins">
        <div class="card-title">
          <h5><p id="tullisann" data-kosong="1">Jumlah Paket Pengadaan</p></h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="card-content">

         <div class="table-responsive">

         <!--  <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td>Metode Pengadaan</td>
                <td>Jumlah</td>
              </tr>
            </thead>
            <tbody>
              <?php
              foreach($top_proc_method as $key => $value) {

                $isi = $value['ptp_tender_method'];
              ?>
            
              <tr>
                <td><?php echo $value['label'] ?></td>
                <td><a href="index.php/laporan/detail_rfq/lap_proc_value/<?php echo $isi ?>"><?php echo $value['total'] ?></a></td>
              </tr>
              <?php } ?> 
            </tbody> 
          </table> -->
          <table id="datatables-ss2" class="table table-bordered table-striped">
            <thead>
              <tr>
                <th style="text-align:center;font-size: 1.2em;width:5%">No</th>
                <th style="text-align:center;font-size: 1.2em;">Metode Pengadaan</th>
                <th style="text-align:center;font-size: 1.2em;">Jumlah</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
          </table>


        </div>

      </div>
    </div>

  </div>
</div>
</div>
</div>
</div>


<!-- 
  hlmifzi -->


  <!-- DataTables -->
  <script src="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.js"></script>

  <!-- Bootstrap-select -->
  <script src="<?php echo base_url();?>assets/plugins/bootstrap-select/js/bootstrap-select.min.js" type="text/javascript"></script>



  <script type="text/javascript">
    var tglMulai = '';
    var tglAkhir = '';

    $(document).on('click', '.submit', function() { 
      tglMulai = $(this).attr('data-tglMulai');
      tglAkhir = $(this).attr('data-tglAkhir');

      cekkosong = $('#tullisann').attr('data-kosong');
      if (cekkosong == '1') {
        $("#tullisann").append(
          " <b>Tahun <label class=\"btn btn-xs btn-primary cektglMulai\">"+tglMulai+"</label> s.d. Tahun <label class=\"btn btn-xs btn-primary cektglAkhir\">"+tglAkhir+"</label></b>"
          );
        $('#tullisann').attr("data-kosong","2");
      } else if (cekkosong == '2') {

       $(".cektglMulai").text(tglMulai);
       $(".cektglAkhir").text(tglAkhir);
     }

     table1.ajax.reload(null, false); 

     $('#form-field')[0].reset();
   })

    function getTanggalMulai(e) {
      tglMulai = $(e).val();
      $(".submit").attr("data-tglMulai",tglMulai);
    // alert(tglMulai);
  }
  function getTanggalAkhir(e) {
    tglAkhir = $(e).val();
    $(".submit").attr("data-tglAkhir",tglAkhir);
    // alert(tglMulai);
  }
</script>

<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });

  var   urlDb   = "<?php echo site_url('laporan/data_table_ss_report_proses_pengadaan') ?>";
  var   totalClmn;
  var   table1;
  $(document).ready(function() {
    totalClmn = parseInt($("#datatables-ss2").find('tr:nth-child(1) th').length);
    table1  = $('#datatables-ss2').DataTable({ 

      "PaginationType": "bootstrap",
      responsive: true,

      "processing": true, 
      "serverSide": true, 
      "deferRender": true,
      "order": [], 

      "ajax": {
        "url": urlDb,
        "type": "POST",
        "data" : function(param) {
          param.tglMulai = tglMulai;
          param.tglAkhir = tglAkhir;
        }
      },
      "columnDefs": [ 
      { 
        "targets": [ 0 ], 
        "orderable": false 
      }, { 
        "targets": [ totalClmn-1 ], 
        "orderable": true,
      }
      ],
      "fnDrawCallback": function( oSettings ) {
         // $('select[name="id_satuan"]').selectpicker('refresh');
       }
     });
  });
</script>