<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $judul ?></title>

    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    
    <base href="<?php echo base_url() ?>"/>

    <link rel="manifest" href="<?php echo base_url('manifest.json') ?>">
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/'.$site_favicon) ?>">
    <link rel="stylesheet" href="assets/plugins/jquery-ui/themes/ui-lightness/jquery-ui.min.css"/>
    <link rel="stylesheet" href="assets/plugins/jquery-ui/themes/ui-lightness/theme.css"/>
    <link href="assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/jasny-bootstrap/dist/css/jasny-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/icheck/skins/flat/flat.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/plugins/iCheck/custom.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/morris.js/morris.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/jvectormap/jquery-jvectormap.css" rel="stylesheet" type="text/css" />

    <link href="assets/plugins/bootstrap-daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
    <link href="assets/plugins/bootstrap3-wysihtml5/dist/bootstrap-wysihtml5-0.0.2.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css"/>
    <link rel="stylesheet" href="assets/plugins/bootstrap-table/dist/bootstrap-table.min.css"/>
    <link rel="stylesheet" href="assets/plugins/dragtable/dragtable.css"/>
    <link rel="stylesheet" href="assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css"/>
    <link rel="stylesheet" href="assets/plugins/select2/dist/css/select2.min.css"/>
    <link rel="stylesheet" type="text/css" href="assets/css/plugins/summernote/summernote.css">
    <link rel="stylesheet" type="text/css" href="assets/css/plugins/summernote/summernote-bs3.css">
    <link href="assets/css/animate.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/fonts.css"/>
    <link rel="stylesheet" href="assets/css/plugins/toastr/toastr.min.css"/>
    <link href="assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="assets/app-assets/vendors/js/vendors.min.js"></script>    
    <link rel="stylesheet" type="text/css" href="assets/app-assets/fonts/feather/style.min.css">
    <link rel="stylesheet" type="text/css" href="assets/app-assets/vendors/css/perfect-scrollbar.min.css">
    <link rel="stylesheet" type="text/css" href="assets/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="assets/app-assets/css/toastr/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="assets/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="assets/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="assets/app-assets/css/plugins/switchery.css">    
    <link rel="stylesheet" type="text/css" href="assets/assets/css/style.css">

    <!-- haqim -->
    <link rel="stylesheet" href="assets/css/chosen/chosen.min.css">
    <!-- end -->
    <script src='assets/plugins/fastclick/lib/fastclick.js'></script>
    <script src='assets/plugins/jasny-bootstrap/dist/js/jasny-bootstrap.min.js'></script>
    <script src='assets/plugins/autoNumeric/autoNumeric.js'></script>
    <script src='assets/plugins/numeral/numeral.js'></script>
    <script src='assets/js/lodash.js'></script>

    <link href="assets/css/bootstraptoggle.css" rel="stylesheet">
    <script src="assets/js/bootstraptoggle.js"></script>
    <script src="assets/plugins/slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <script src="assets/plugins/chartjs/Chart.min.js" type="text/javascript"></script>
    <script src="assets/plugins/moment/min/moment.min.js"></script>
    <script src="assets/plugins/tinymce/tinymce.jquery.min.js"></script>
    <script src="assets/plugins/jquery-form/jquery.form.js"></script>
    <script src="assets/plugins/icheck/icheck.min.js"></script>
    <script src="assets/plugins/select2/dist/js/select2.full.min.js"></script>
    <script src="assets/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js"></script>

    <script src="assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="assets/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/plugins/TableDnD/dist/jquery.tablednd.min.js"></script>
    <script src="assets/plugins/colResizable-1.5.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/bootstrap-table.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/cookie/bootstrap-table-cookie.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/editable/bootstrap-table-editable.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/export/bootstrap-table-export.min.js"></script>
    <script src="assets/plugins/bootstrap-table-filter/src/bootstrap-table-filter.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/filter/bootstrap-table-filter.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/filter-control/bootstrap-table-filter-control.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/flat-json/bootstrap-table-flat-json.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/key-events/bootstrap-table-key-events.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/multiple-sort/bootstrap-table-multiple-sort.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/reorder-columns/bootstrap-table-reorder-columns.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/natural-sorting/bootstrap-table-natural-sorting.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/reorder-columns/bootstrap-table-reorder-columns.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/resizable/bootstrap-table-resizable.min.js"></script>
    <script src="assets/plugins/bootstrap-table/dist/extensions/toolbar/bootstrap-table-toolbar.min.js"></script>    

    <?php /*  INSPINIA */ ?>

    <?php /*  Mainly scripts */ ?>

    <script src="assets/js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <?php /*  Flot */ ?>
    <script src="assets/js/plugins/flot/jquery.flot.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.spline.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.resize.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.pie.js"></script>
    <script src="assets/js/plugins/flot/jquery.flot.symbol.js"></script>
    <script src="assets/js/plugins/flot/curvedLines.js"></script>

    <?php /*  Peity */ ?>
    <script src="assets/js/plugins/peity/jquery.peity.min.js"></script>

    <?php /*  Custom and plugin javascript */ ?>
    <script src="assets/js/inspinia.js"></script>
    <script src="assets/js/plugins/pace/pace.min.js"></script>

    <?php /*  Jvectormap */ ?>
    <script src="assets/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

    <?php /*  Sparkline */ ?>
    <script src="assets/js/plugins/sparkline/jquery.sparkline.min.js"></script>

    <?php /*  Sparkline demo data  */ ?>
    <script src="assets/js/plugins/validate/jquery.validate.min.js"></script>
    <script src="assets/plugins/raphael/raphael-min.js"></script>
    <script src="assets/plugins/morris.js/morris.min.js"></script>

    <script src="assets/js/plugins/summernote/summernote.min.js"></script>

    <script src="assets/js/plugins/treetable/javascript.js"></script>

    <script src="assets/plugins/toastr/toastr.min.js"></script>

    <script type="text/javascript" src="assets/plugins/angular/angular.min.js"></script>

    <script type="text/javascript" src="https://cdn.pubnub.com/sdk/javascript/pubnub.4.12.0.min.js"></script>
    <script src='assets/js/custom-messaging.js'></script>

    <script type="text/javascript" src="assets/plugins/angucomplete-alt/angucomplete-alt.js"></script>

    <link rel="stylesheet" type="text/css" href="assets/plugins/angucomplete-alt/angucomplete-alt.css">

    <link rel="stylesheet" href="assets/plugins/angular-ui-tree/dist/angular-ui-tree.min.css">
    <script type="text/javascript" src="assets/plugins/angular-ui-tree/dist/angular-ui-tree.js"></script>

    <script type="text/javascript">
      //y validasi input type number minimal 0
      $(document).ready(function(){
        $('input[type="number"]').attr({
          min:"0",
          oninput:"this.value = Math.abs(this.value)"
        });

        $(".money").keypress( function(e) {
            var chr = String.fromCharCode(e.which);
            if ("0123456789.,".indexOf(chr) < 0)
              return false;
        });

        $(function() {
          $(".money").keyup(function() {
                $(this).val($(this).val().replace(/[-]/g, ""));
          });
        });

      });

      var currenttime = '<?php echo date("F d, Y H:i:s")?>' //PHP method of getting server date

      var montharray=new Array("January","February","March","April","May","June","July","August","September","October","November","December")
      var serverdate=new Date(currenttime)

      function padlength(what){
        var output=(what.toString().length==1)? "0"+what : what
        return output
      }

      function displaytime(){
        serverdate.setSeconds(serverdate.getSeconds()+1)
        var datestring=padlength(serverdate.getDate())+" "+montharray[serverdate.getMonth()]+" "+serverdate.getFullYear()+" - "
        var timestring=padlength(serverdate.getHours())+":"+padlength(serverdate.getMinutes())+":"+padlength(serverdate.getSeconds())
        //document.getElementById("servertime").innerHTML=datestring+" "+timestring+" WIB";
      }

      window.onload=function(){
        setInterval("displaytime()", 1000)
      }

    </script>

    <script src="assets/js/custom.js"></script>

    <script type="text/javascript">
      jQuery.fn.bootstrapTable.defaults.sortOrder = 'desc';
      var uri = "<?php echo $this->uri->uri_string() ?>";
      if(uri == "home"){
        localStorage.setItem("session_id",<?php echo $userdata['employee_id'] ?>);
      }
      var session_id = localStorage.getItem("session_id");
      if(session_id != <?php echo $userdata['employee_id'] ?>){
        window.location = "<?php echo site_url('log/logout') ?>";
      } else {
        localStorage.setItem("session_id",<?php echo $userdata['employee_id'] ?>);
      }
    </script>

    <style>
        .content-header {
            color : #2b71c6;
        }
        th {
            white-space: nowrap;
        }
    </style>

</head>

  <body <?php echo (isset($controller_name) && in_array($controller_name, array("aset","inventory","administration"))) ?
  "ng-app='$controller_name'" : "" ?>class="vertical-layout vertical-menu 2-columns navbar-sticky" data-menu="vertical-menu" data-col="2-columns">

  <?php include("header_v.php") ?>

  <div class="wrapper">

      <?php include("sidebar_v.php") ?>

      <?php include("content_v.php") ?>

      <?php include("dialog_v.php") ?>

      <?php include("picker_v.php") ?>

      <?php
      if(isset($_SERVER['HTTP_REFERER'])) {
        
        if($_SERVER['HTTP_REFERER'].'/proses_kontrak' == site_url($controller_name."/daftar_pekerjaan/proses_kontrak")) {
          include("filemanager_v.php");
        } else {
          include("filemanager_v.php");
        }
      }

        
      ?>

      <?php include("footer_v.php"); ?>

  </div>

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  <script type="text/javascript" src="assets/js/angular/aset.js"></script>
  <script type="text/javascript" src="assets/js/angular/inventory.js"></script>
  <script type="text/javascript" src="assets/js/angular/administration.js"></script>
  <script type="text/javascript" src="assets/js/bottom.js"></script>
  <div id="ajax-modal" class="modal fade" tabindex="-1"></div>

  <script type="text/javascript" src="assets/app-assets/js/core/app-menu.js"></script>
  <script type="text/javascript" src="assets/app-assets/js/toastr/toastr.min.js"></script>
  <script type="text/javascript" src="assets/app-assets/js/toastr/abe-toast.js"></script>
  <script type="text/javascript" src="assets/app-assets/js/core/app.js"></script>
  <script type="text/javascript" src="assets/app-assets/js/customizer.js"></script>
  <script type="text/javascript" src="assets/app-assets/js/scroll-top.js"></script>
  <script type="text/javascript" src="assets/app-assets/js/components-modal.min.js"></script>
  <script type="text/javascript" src="assets/app-assets/vendors/js/sweetalert2.all.min.js"></script>
  <script type="text/javascript" src="assets/assets/js/scripts.js"></script>
  <script type="text/javascript" src="assets/app-assets/js/customizer.js"></script>
  <script type="text/javascript" src="assets/app-assets/vendors/js/switchery.min.js"></script>
	<script type="text/javascript" src="assets/app-assets/js/jquery.mask.min.js"></script>

  <script type="text/javascript" src="assets/js/chosen.jquery.min.js"></script>
  <script type="text/javascript" src="assets/plugins/bootstrap-table/dist/extensions/editable/x-editable.js"></script>

  <script>
      $(".form-horizontal").validate();
  </script>

  <script type="text/javascript">
      $(document).ready(function(){

          $('#npwp_inp').mask('99.999.999.9-999.999');

      })
  </script>

</body>
</html>
