<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">
    <div class="col-lg-12">
      <div class="card float-e-margins">
        <div class="card-title">
          <h5>Analisa Statistik Vendor</h5>
          <div class="card-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="card-content">

          <div class="table-responsive">

             <table id="datatables-ss3" class="table table-bordered table-striped" width="100%">
               <thead>
                 <tr>
                   <th style="text-align:center;font-size: 1.1em;width: 5%;"><b>No<b></th>
                   <th style="text-align:center;font-size: 1.1em;width: 20%"><b>Kode UNPSC <b></th>
                   <th style="text-align:center;font-size: 1.1em;width: 65%"><b>Kualifikasi<b></th>
                   <th style="text-align:center;font-size: 1.1em;width: 10%"><b>Jumlah<b></th>

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



<form id="form-field">
    <!-- Modal -->
    <div class="modal fade" id="myModal" role="dialog">
      <div class="modal-dialog modal-lg">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Modal Header</h4>
          </div>
          <div class="modal-body">
            <div class="table-responsive">

             <table id="datatables-ss2" class="table table-bordered table-striped" width="100%">
               <thead>
                 <tr>
                   <th style="text-align:center;font-size: 1.1em;width: 30px;"><b>No<b></th>
                   <th style="text-align:center;font-size: 1.1em;width: 40px"><b>Klasifikasi<b></th>
                   <th style="text-align:center;font-size: 1.1em;width: 40px"><b>Jumlah<b></th>

                 </tr>
               </thead>
               <tbody>
               
               </tbody>
             </table>

            </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
    </div>
</form>


<script type="text/javascript">

        var kode_group = '';

    $(document).on('click', ".action", function() {   
        nama       = $(this).closest("tr").find("td:eq(2)").text();
        kode_group = $(this).attr('data-kode_group');
        $('#myModal').find('.modal-title').text("Klasifikasi Commodity "+nama);
        $('#myModal').modal('show');

    /*    alert(aset_id);*/
        table1.ajax.reload(null, false); 

  })


  var   urlDb2   = "<?php echo site_url('laporan/data_table_statistik_vendor/utama') ?>";
  var   totalClmn2;
  var   table2;
  $(document).ready(function() {
    totalClmn2 = parseInt($("#datatables-ss3").find('tr:nth-child(1) th').length);
    table2  = $('#datatables-ss3').DataTable({ 
        
        "PaginationType": "bootstrap",
        responsive: true,

        "processing": true, 
        "serverSide": true, 
        "deferRender": true,
        "order": [], 

        "ajax": {
            "url": urlDb2,
            "type": "POST",
            "data" : function(param) {
              param.kode_group = 0;

            }
        },
        "columnDefs": [ 
          { 
              "targets": [ 0 ], 
              "orderable": false 
          }, { 
              "targets": [ totalClmn2-1 ], 
              "orderable": true,
          }
        ],
        "fnDrawCallback": function( oSettings ) {
           // $('select[name="id_satuan"]').selectpicker('refresh');
        }
    });
  });




var   urlDb   = "<?php echo site_url('laporan/data_table_statistik_vendor/detail')?>";
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
             param.kode_group = kode_group;

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


