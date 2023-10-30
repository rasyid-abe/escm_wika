<style>
   .step {
       font-size: 11px;
       margin: auto;
       /* box-shadow: 0 0 11px rgba(33,33,33,.2); */
       padding-top: 15px;
       padding-bottom: 10px;
       /* padding-left: 10px !important; */
       border-radius: 10px;
   }

   .shadow-none {
       width: 20%;
       border: 1px solid #d1d3d4;
       background-color: white;
   }

   .hide {
       display: none;
   }
</style>
<?php $this->load->view('devextreme'); ?>

<div class="wrapper wrapper-content animated fadeInRight">
   <?php
       $bg_color_1 = '';
       $bg_color_2 = '';
       $bg_color_3 = '';
       $bg_color_4 = '';
       $bg_color_5 = '';
       $color_1 = '';
       $color_2 = '';
       $color_3 = '';
       $color_4 = '';
       $color_5 = '';
       $icon_1 = 'ft-chevrons-right ';
       $icon_2 = 'ft-chevrons-right ';
       $icon_3 = 'ft-chevrons-right ';
       $icon_4 = 'ft-chevrons-right ';
       $icon_5 = '';
       $status_1 = 'Menunggu proses';
       $status_2 = 'Menunggu proses';
       $status_3 = 'Menunggu proses';
       $status_4 = 'Menunggu proses';
       $status_5 = 'Menunggu proses';
   ?>
   <div class="row step" style="margin-bottom: -15px;">
       <div class="shadow-none rounded-0 d-flex flex-row mb-1" style="background-color: #29a7de !important;border-radius: 10px 0px 0px 10px !important;">
           <div class="px-2 py-1">
               <p class="mb-1 font-weight-bold" style="color:#ffffff;">Pembuatan Kontrak</p>
               <small class="text-muted" style="color:#ffffff;"><?php echo $status_1; ?></small>
           </div>
           <div class="segitiga2"></div>
       </div>
       <div class="shadow-none rounded-0 d-flex flex-row mb-1">
           <div class="px-2 py-1">
               <p class="mb-1 font-weight-bold">Approval Kontrak</p>
               <small class="text-muted" style="color:#3f3f3f !important;"><?php echo $status_2; ?></small>
           </div>
           <div class="segitiga2"></div>
       </div>
       <div class="shadow-none rounded-0 d-flex flex-row mb-1">
           <div class="px-2 py-1">
               <p class="mb-1 font-weight-bold">Finalisasi Kontrak</p>
               <small class="text-muted" style="color:#3f3f3f !important;"><?php echo $status_3; ?></small>
           </div>
           <div class="segitiga2"></div>
       </div>
       <div class="shadow-none rounded-0 d-flex flex-row mb-1">
           <div class="px-2 py-1">
               <p class="mb-1 font-weight-bold">Kontrak Aktif</p>
               <small class="text-muted" style="color:#3f3f3f !important;"><?php echo $status_4; ?></small>
           </div>
           <div class="segitiga2"></div>
       </div>
       <div class="shadow-none rounded-0 d-flex flex-row mb-1" style="border-radius: 0px 10px 10px 0px !important;">
           <div class="px-2 py-1">
               <p class="mb-1 font-weight-bold">Kontrak Selesai</p>
               <small class="text-muted" style="color:#3f3f3f !important;"><?php echo $status_5; ?></small>
           </div>
           <div class="segitiga2"></div>
       </div>
   </div>

   <?php if (isset($is_sap)): ?>
       <?php $url = "/submit_proses_kontrak_manual_sap"; ?>
   <?php else: ?>
       <?php $url = "/submit_proses_kontrak_manual"; ?>
   <?php endif; ?>

   <form method="post" action="<?php echo site_url($controller_name . $url);?>" class="form-horizontal ajaxform">

       <?php if (isset($is_sap)): ?>
           <?php if ($pl == ''): ?>
               <?php include("manual/uskep_online_sap_v.php"); ?>
           <?php endif; ?>
           <?php include("manual/header_sap_v.php"); ?>
           <?php if ($bakp != ""): ?>
               <input type="hidden" name="usk" value="1">
           <?php endif; ?>
       <?php else: ?>
           <?php include("manual/uskep_online_v.php"); ?>
           <?php include("manual/header_v.php"); ?>
       <?php endif; ?>

       <?php //include("manual/jaminan_v.php"); ?>

       <?php if (isset($is_sap)): ?>
           <?php if ($bakp != ""): ?>
               <?php include("manual/item_sap_av.php"); ?>
           <?php else: ?>
               <?php include("manual/item_sap_v.php"); ?>
           <?php endif; ?>
       <?php else: ?>
           <?php include("manual/item_v.php"); ?>
       <?php endif; ?>

       <?php //include("manual/milestone_v.php"); ?>
       <?php include("manual/lampiran_v.php"); ?>
       <?php //include("manual/person_v.php"); ?>
       <?php //include("manual/risiko_pr_v.php"); ?>

       <div class="card" id="sbmbtn">
           <div class="card-content">
               <div class="card-body">
                   <?php echo buttonsubmit('contract/monitor/monitor_kontrak', lang('back'), lang('save')) ?>
               </div>
           </div>
       </div>

   </form>

</div>

<script>
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
