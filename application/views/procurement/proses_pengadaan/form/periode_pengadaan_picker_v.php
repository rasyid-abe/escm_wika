<div class="modal fade" id="pp_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document" style="width: 50%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
      </div>
      <div class="modal-body" style="max-height: calc(80vh - 110px);
            overflow-y: auto;">

      <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
          <div class="col-lg-12">
            <div class="card float-e-margins">
              <div class="card-title">
                <h5>Periode Pengadaan</h5>
                <div class="card-tools">
                  <a class="collapse-link">
                    <i class="fa fa-chevron-up"></i>
                  </a>

                </div>
              </div>
              <div class="card-content">

                <div class="table-responsive">

                  <table id="example" class="table table-responsive table-striped table-bordered table-hover table-hover periode_pengadaan_table" width="100%">
                     <thead>
                        <tr>
                           <th><input type="checkbox" name="select_all" value="1" id="select-all"></th>
                           <th>Periode Pengadaan</th>
                        </tr>
                     </thead>
                  </table>

                </div>

              </div>
            </div>


          </div>
        </div>
      </div>

      <script type="text/javascript">

        var url = "<?php echo site_url('Procurement/periode_pengadaan_picker') ?>";

        var table_pp =  $('.periode_pengadaan_table').DataTable({
        "language": {
          "emptyTable": "No data found",
          "sClass": "text-center",
        },
        autoWidth: false,
        pageLength: 10,
        responsive: true,
        ajax: url,
        "processing": true,
        "columnDefs": [   ////define column 1 , make searchable false 
          {
              "searchable": false,
              "targets": 0,
              "width": "6%",
              
          },
          { "width": "10%", "targets": 1 },

        ],
        "columns": [
            { 'data': "pp_id", 'render': function (data, type, full, meta){
             return '<input type="checkbox" class="pp_val" name="pp" value="' + $('<div/>').text(data).html() + '">';
           } },
            { "data": "pp_text"},
        ],
        // dom: '<"html5buttons"B>lTfgitp',
      });

      $('#select-all').on('click', function(){
       // Get all rows with search applied
       var rows = table_pp.rows({ 'search': 'applied' }).nodes();
       // Check/uncheck checkboxes for all rows in the table
       $('input[name="pp"]', rows).prop('checked', this.checked);
    });

      $('#pp_modal').on('hidden.bs.modal', function (e) {
          $('input[name="pp"]').prop('checked', false);
          $('input[name="select_all"]').prop('checked', false);
          table_pp.search('').draw();
      })

      </script>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary save_pp">Save changes</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $('.save_pp').click(function(){
      getChecked();
      $('.delete_pp').click(function(){
        var no_pp = $(this).attr("data-no");
        var deleted_item = moment($('.pp_val_item_'+no_pp).html()).format("YYYY-MM-DD")
        var existing_val = $("[name='periode_pengadaan_list']").val()
        // alert(existing_val)
          var new_val = existing_val.replace(deleted_item,'');
          new_val = new_val.replace(/  /g," ")
          new_val = new_val.replace(/(^[\s]+|[\s]+$)/g, '')
        
        // alert(new_val)
        $("[name='periode_pengadaan_list']").val(new_val)
        $(".pp_tr_"+no_pp).remove();
      })
    })

    function getChecked(){
      /* declare an checkbox array */
      var pp_valArray = [];
      var pp_textArray= [];
      
      /* look for all checkboes that have a class 'chk' attached to it and check if it was checked */
      if ($('#periode_pengadaan_list tr').length == 0) {
        var no_pp = 1;
      }else{
        var no_pp = getMaxDataNo(".delete_pp")+1;
      }
      
      $(".pp_val:checked", table_pp.rows().nodes()).each(function() {
        pp_valArray.push($(this).val());
        pp_textArray.push("<tr class='pp_tr_"+no_pp+"'><td class='pp_val_item_"+no_pp+"' >"+moment($(this).val()).format('DD-MMM-YYYY')+"</td><td><button type='button' class='btn btn-danger btn-xs delete_pp' data-no="+no_pp+"><i class='fa fa-close'></i></button></td></tr>");
        no_pp++
      });
      
      /* we join the array separated by the comma */
      var selected_pp_val;
      selected_pp_val = pp_valArray.join(' ');
      var selected_pp_text;
      selected_pp_text = pp_textArray.join(' ');
      
      /* check if there is selected checkboxes, by default the length is 1 as it contains one single comma */
      if(selected_pp_val.length > 0){
        if ($("[name='periode_pengadaan_list']").val() == '') {
          $("[name='periode_pengadaan_list']").val(selected_pp_val);
        }else{
          $("[name='periode_pengadaan_list']").val($("[name='periode_pengadaan_list']").val()+' '+selected_pp_val)
        }

        if ($('#periode_pengadaan_list').html() == '') {
          $('#periode_pengadaan_list').html(selected_pp_text);          
        }else{
          $('#periode_pengadaan_list tbody').append(selected_pp_text)
        }

        $('#pp_modal').modal('hide')
      }else{
        alert("Silahkan pilih periode pengadaan"); 
      }
  }

  });
</script>


