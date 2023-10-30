<style>
    .segitiga {
        height: 0px;
        width: 0px;
        border-left: 1.2em solid rgb(42 171 226) !important;
        border-top: solid 2.3em transparent;
        border-bottom: solid 2.3em transparent;
        display: none;
    }
    .bg-info-ch {
        background-color: #fff !important;
    }
    .bg-update {
        background-color: #29a7de !important;
    }
    .step {
        font-size: 11px;
        margin:auto;
        padding-top: 15px;
        padding-bottom: 10px;
        border-radius: 10px;
    }
    .card {
        border-radius: 1.35rem;
    }
    .breadcrumb-escm {
        border: 1px solid #d1d3d4;
    }
    .no-space {
        padding: 0 !important;
        margin: 0 !important;
    }

    .wrapper_letter{
    
    overflow:auto;
}


.c1{
   float:left;

}


.c2{

    float:right;
}

</style>

<?php
    $bgcolor1 = "bg-white";    
    $bgcolor2 = "bg-white";    
    $bgcolor3 = "bg-white";    
    $bgcolor4 = "bg-white";    
    $bgcolor5 = "bg-white";    
    $bgcolor6 = "bg-white";    
    $bgcolor7 = "bg-white";    
    $bgcolor8 = "bg-white";    
    $bgcolor9 = "bg-white";    
    
    if ($awa_id > 1039) { $bgcolor1 = "bg-update text-white"; }    
    if ($awa_id > 1079) { $bgcolor2 = "bg-update text-white"; }    
    if ($awa_id > 1089) { $bgcolor3 = "bg-update text-white"; }    
    if ($awa_id > 1099) { $bgcolor4 = "bg-update text-white"; }    
    if ($awa_id > 1139) { $bgcolor5 = "bg-update text-white"; }    
    if ($awa_id > 1140) { $bgcolor6 = "bg-update text-white"; }    
    if ($awa_id > 1159) { $bgcolor7 = "bg-update text-white"; }    
    if ($awa_id > 1169) { $bgcolor8 = "bg-update text-white"; }    
    if ($awa_id > 1179) { $bgcolor9 = "bg-update text-white"; }        
?>

<div class="row step mb-2">
    <div class="shadow-none rounded-0 mb-1 col-sm-2 no-space">
        <div class="px-2 py-1 breadcrumb-escm <?php echo $bgcolor1;?>" style="border-radius: 10px 0px 0px 10px;">
            <p class="mb-1 font-weight-bold">Pembuatan Dokumen</p>
            <?php if ($awa_id > 1039) { ?>
                <small id="mulai_pendaftaran"></small>
            <?php } else { ?>
                <small>Dalam proses</small>
            <?php } ?>
        </div>
        <div class="segitiga"></div>
    </div>
    <div class="shadow-none rounded-0 mb-1 col-sm-1 no-space">
        <div class="px-2 py-1 breadcrumb-escm <?php echo $bgcolor2;?>">
            <p class="mb-1 font-weight-bold">Aanwijing</p>
            <?php if ($awa_id > 1079) { ?>
                <small id="ptp_prebid_date_"></small>
            <?php } else { ?>
                <small>Dalam proses</small>
            <?php } ?>
        </div>
        <div class="segitiga"></div>
    </div>
    <div class="shadow-none rounded-0 mb-1 col-sm-1 no-space">
        <div class="px-2 py-1 breadcrumb-escm <?php echo $bgcolor3;?>">
            <p class="mb-1 font-weight-bold">Penawaran</p>            
            <?php if ($awa_id > 1089) { ?>
                <small id="ptp_quot_opening_date_"></small>
            <?php } else { ?>
                <small>Dalam proses</small>
            <?php } ?>
        </div>
        <div class="segitiga"></div>
    </div>
    <div class="shadow-none rounded-0 mb-1 col-sm-2 no-space">
        <div class="px-2 py-1 breadcrumb-escm <?php echo $bgcolor4;?>">
            <p class="mb-1 font-weight-bold">Evaluasi</p>            
            <?php if ($awa_id > 1099) { ?>
                <small id="ptp_doc_open_date_"></small>
            <?php } else { ?>
                <small>Dalam proses</small>
            <?php } ?>
        </div>
        <div class="segitiga"></div>
    </div>
    <div class="shadow-none rounded-0 mb-1 col-sm-1 no-space">
        <div class="px-2 py-1 breadcrumb-escm <?php echo $bgcolor5;?>">
            <p class="mb-1 font-weight-bold">Negosiasi</p>
            <?php if ($awa_id > 1139) { ?>
                <small id="ptp_negosiation_date_"></small>
            <?php } else { ?>
                <small>Dalam proses</small>
            <?php } ?>
        </div>
        <div class="segitiga"></div>
    </div>
    <div class="shadow-none rounded-0 mb-1 col-sm-1 no-space">
        <div class="px-2 py-1 breadcrumb-escm <?php echo $bgcolor6;?>">
            <p class="mb-1 font-weight-bold">USKEP</p>            
            <?php if ($awa_id > 1140) { ?>
                <small id="ptp_uskep_date_"></small>
            <?php } else { ?>
                <small>Dalam proses</small>
            <?php } ?>
        </div>
        <div class="segitiga"></div>
    </div>
    <div class="shadow-none rounded-0 mb-1 col-sm-2 no-space">
        <div class="px-2 py-1 breadcrumb-escm <?php echo $bgcolor7;?>">
            <p class="mb-1 font-weight-bold">Pengumuman</p>
            <?php if ($awa_id > 1159) { ?>
                <small id="ptp_announcement_date_"></small>
            <?php } else { ?>
                <small>Dalam proses</small>
            <?php } ?>
        </div>
        <div class="segitiga"></div>
    </div>
    <div class="shadow-none rounded-0 mb-1 col-sm-1 no-space">
        <div class="px-2 py-1 breadcrumb-escm <?php echo $bgcolor8;?>">
            <p class="mb-1 font-weight-bold">Sanggahan</p>            
            <?php if ($awa_id > 1169) { ?>
                <small id="ptp_disclaimer_date_"></small>
            <?php } else { ?>
                <small>Dalam proses</small>
            <?php } ?>
        </div>
        <div class="segitiga"></div>
    </div>
    <div class="shadow-none rounded-0 mb-1 col-sm-1 no-space">
        <div class="px-2 py-1 breadcrumb-escm <?php echo $bgcolor9;?>" style="border-radius: 0px 10px 10px 0px;">
            <p class="mb-1 font-weight-bold">Penunjukan</p>
            <small id="ptp_appointment_date_"></small>
            <?php if ($awa_id > 1179) { ?>
                <small id="ptp_appointment_date_"></small>
            <?php } else { ?>
                <small>Dalam proses</small>
            <?php } ?>
        </div>
        <div class="segitiga"></div>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<form class="form-horizontal ajaxform">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<?php 

		$loaded = array();
		foreach ($content as $key => $value) {
            //print_r($value);
			$str = "view/".$value['awc_file'].".php";
            
			if(!in_array($str, $loaded)){
				include($str);
				$loaded[] = $str;
				//print_r($str);
				
			}
		}
		//exit;
		?>

		<div class="row">
			<div class="col-12">
				<div class="card">        
					<div class="card-header border-bottom pb-2">
						<h4 class="card-title">Daftar RKS</h4>
					</div>

					<div class="card-content">
						<div class="card-body">
							<table class="table comment table-striped">
								<thead>
									<tr>
										<th>No</th>
										<th>Kategori</th>
										<th>Kategori Sub</th>
										<th>Deskripsi</th>
										<th>Tanggal</th>
									</tr>
								</thead>
								<tbody>
								
								<?php 
								if(isset($tenderRks) && !empty($tenderRks)){
								foreach ($tenderRks as $key => $value) { ?>

									<tr>
										<td><?php echo $key+1 ?></td>
										<td><?php echo $value['rks_cat'] ?></td>                    
										<td><?php echo $value['rks_sub_cat'] ?></td>                    
										<td><?php echo $value['rks_desc'] ?></td>                    
										<td><?php echo $value['created_date'] ?></td>                    
									</tr>
								
								<?php } } ?>
								
								</tbody>
							</table>
						</div>
					</div>

				</div>
			</div>
		</div>

		<?php 
		$i = 0;
		include(VIEWPATH."/comment_view_attachment_v.php") ?>

		<div class="card">				
			<div class="card-content">
				<div class="card-body">			      
					<?php echo buttonback($redirect_back,lang('back'),lang('save')) ?>
				</div>
			</div>
		</div>

	</form>

</div>

<script>
	$(document).ready(function(){
		$('.multiselect').select2();
	});        

	const pembukaan = new Date(data["ptp_reg_opening_date"])
	const aawijing = new Date(data["ptp_prebid_date"])
	const penawaran = new Date(data["ptp_quot_opening_date"])
	const evaluasi = new Date(data["ptp_doc_open_date"])
	const negosiasi = new Date(data["ptp_negosiation_date"])
	const uskep = new Date(data["ptp_uskep_date"])
	const pengumuman = new Date(data["ptp_announcement_date"])
	const sanggahan = new Date(data["ptp_disclaimer_date"])
	const penunjukan = new Date(data["ptp_appointment_date"])

	document.getElementById("mulai_pendaftaran").innerHTML = moment(pembukaan).format('DD/MMMM/YYYY')
	document.getElementById("ptp_prebid_date_").innerHTML = moment(aawijing).format('DD/MMMM/YYYY')
	document.getElementById("ptp_quot_opening_date_").innerHTML = moment(penawaran).format('DD/MMMM/YYYY')
	document.getElementById("ptp_doc_open_date_").innerHTML = moment(evaluasi).format('DD/MMMM/YYYY')
	document.getElementById("ptp_negosiation_date_").innerHTML = moment(negosiasi).format('DD/MMMM/YYYY')
	document.getElementById("ptp_uskep_date_").innerHTML = moment(uskep).format('DD/MMMM/YYYY')
	document.getElementById("ptp_announcement_date_").innerHTML = moment(pengumuman).format('DD/MMMM/YYYY')
	document.getElementById("ptp_disclaimer_date_").innerHTML = moment(sanggahan).format('DD/MMMM/YYYY')
	document.getElementById("ptp_appointment_date_").innerHTML = moment(penunjukan).format('DD/MMMM/YYYY')
</script>  

<?php if($is_user){ 
// include(VIEWPATH."/chat_v.php");
} ?>

<?php
  	//haqim
	include VIEWPATH.'procurement/proses_pengadaan/chat_rfq_v.php';
	//end
?>