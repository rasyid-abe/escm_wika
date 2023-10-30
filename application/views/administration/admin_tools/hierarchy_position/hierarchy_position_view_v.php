<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <?php
        $hirarki = array("rkp"=>0,"rkap"=>1,"pr proyek"=>2,"pr non-proyek"=>3,"rfq proyek"=>4,"rfq non-proyek"=>5,"pemenang proyek"=>6,"pemenang non-proyek"=>7,"kontrak proyek"=>8,"kontrak non-proyek"=>9);      
        foreach ($hieMenu as $key => $value) { 
      ?>

      <div class="card collapse-icon accordion-icon-rotate left">
        <div class="card-content">     
          <div id="<?php echo 'heading'.str_replace(' ', '', strtolower($value['title'])); ?>" class="card-header border-bottom pb-3">
            <a data-toggle="collapse" href="#<?php echo str_replace(' ', '', strtolower($value['title'])); ?>" class="card-title collapsed"> Hirarki <?php echo strtoupper($value['title']); ?></a>     
          </div>  
          <div id="<?php echo str_replace(' ', '', strtolower($value['title'])); ?>" role="tabpanel" aria-labelledby="<?php echo str_replace(' ', '', strtolower($value['title'])); ?>" class="collapse">
              <div class="card-content">
                  <div class="card-body">
                    <div class="btn-group" role="group" aria-label="...">
                      <button type="button" onclick="action_tree('add','<?php echo $value['url'] ?>')" class="btn btn-info btn-sm"><i class="ft-plus mr-1"></i>Tambah</button>
                      <button type="button" onclick="action_tree('edit','<?php echo $value['url'] ?>')" class="btn btn-light btn-sm"><i class="ft-edit mr-1"></i>Ubah</button>
                      <button type="button" onclick="action_tree('delete','<?php echo $value['url'] ?>')" class="btn btn-danger btn-sm"><i class="ft-trash mr-1"></i>Hapus</button>
                    </div>
                    <a class="btn btn-success btn-sm pull-right refresh_hie" data-type="<?php echo $value['url'] ?>" href="#" role="button"><i class="ft-refresh-cw mr-1"></i>Refresh</a>
                    <div data-type="<?php echo $value['url'] ?>" class="tree_hie"></div>
                  </div>
              </div>
          </div>  
        </div>
      </div>

      <?php } ?>

    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/plugins/jstree/dist/jstree.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/jstree/dist/themes/default/style.min.css') ?>">

<script type="text/javascript">

  $.jstree.defaults.core.themes.icons = false;
  var url = "<?php echo site_url('administration/admin_tools/hierarchy_position') ?>";
     <?php
     // foreach ($hirarki as $key => $value) {
     foreach ($hieMenu as $key => $value) { ?>
        $(".tree_hie[data-type='<?php echo $value['url'] ?>']").jstree({
        'core' : {
          "check_callback" : true,
          'data' : {
            "url" : "<?php echo site_url('administration/data_hierarchy_position/'.$value['url']) ?>",
            "data" : function (node) {
            return { "id" : node.id };
          }
        }
      },
      "plugins" : [ "search","state", "types", "wholerow"],
    });
  <?php } ?>

  function action_tree(path,type) {

    var ref = $(".tree_hie[data-type='"+type+"']").jstree(true),
    sel = ref.get_selected();
    if(!sel.length) {
      if (path != 'add') {
        return false;
      }

    }
    // sel = sel[0];
    if(typeof sel[0] != 'undefined'){
      sel = sel[0]
    }else{
      if(path == "add"){
        sel = "tambah"
      }else{
        sel = ""
      }
    }

    var conf = true;
    if(path == 'delete'){
      conf = confirm("Apakah anda yakin ingin menghapus data?");
    }
    if(conf){
      if(path == "add"){
        if(sel == ""){
          alert("Pilih data");
        } else if(sel == "tambah"){
          window.location = url+"/"+path+"/"+sel+"/"+type;
        } else {
          window.location = url+"/"+path+"/"+sel+"/"+type;
        }
      }else{
        if (sel == "") {
          alert("Pilih data");
        }else {
          window.location = url+"/"+path+"/"+sel+"/"+type;
        }

      }
    }
  };

  $('.refresh_hie').on("click", function () {
    var type = $(this).data('type');
    var instance = $('.tree_hie[data-type="'+type+'"]').jstree(true);
    instance.refresh(false);
    return false;
  });

</script>
