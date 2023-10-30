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

    .step2 {
        font-size: 9px;
        padding-top: 8px;
        /* width: max-content; */
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

    .timeline-steps {
        display: flex;
        justify-content: center;
        flex-wrap: wrap
    }

    .timeline-steps .timeline-step {
        align-items: center;
        display: flex;
        flex-direction: column;
        position: relative;
        margin: 1rem
    }

    @media (min-width:768px) {
        .timeline-steps .timeline-step:not(:last-child):after {
            content: "";
            display: block;
            border-top: .25rem dotted #3b82f6;
            width: 3.46rem;
            position: absolute;
            left: 7.5rem;
            top: .3125rem
        }
        .timeline-steps .timeline-step:not(:first-child):before {
            content: "";
            display: block;
            border-top: .25rem dotted #3b82f6;
            width: 3.8125rem;
            position: absolute;
            right: 7.5rem;
            top: .3125rem
        }
    }

    .timeline-steps .timeline-content {
        width: 10rem;
        text-align: center;
        /* max-width: max-content; */
    }

    .timeline-steps .timeline-content .inner-circle {
        border-radius: 1.5rem;
        height: 1rem;
        width: 1rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #3b82f6
    }

    .timeline-steps .timeline-content .inner-circle:before {
        content: "";
        background-color: #3b82f6;
        display: inline-block;
        height: 3rem;
        width: 3rem;
        min-width: 3rem;
        border-radius: 6.25rem;
        opacity: .5
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

<div class="row step2">
    <div class="timeline-steps aos-init aos-animate" data-aos="fade-up">
        <div class="timeline-step">
            <div class="timeline-content"  data-original-title="2003">
                <div class="inner-circle"></div>
                <p class="h6 mb-1 font-weight-bold">Pembuatan Dokumen</p>
                <?php if ($awa_id > 1039) { ?>
                <p class="h6" id="mulai_pendaftaran"></p>
                <?php } else { ?>
                    <p class="h6">Dalam proses</p>
                <?php } ?>

            </div>
        </div>
        <div class="timeline-step">
            <div class="timeline-content"  data-original-title="2005">
                <div class="inner-circle"></div>
                <p class="h6 mb-1 font-weight-bold">Penawaran</p>
                <?php if ($awa_id > 1089) { ?>
                    <p class="h6" id="ptp_quot_opening_date_"></p>
                <?php } else { ?>
                    <p class="h6">Dalam proses</p>
                <?php } ?>
            </div>
        </div>
        
        <div class="timeline-step mb-0">
            <div class="timeline-content"  data-original-title="2020">
                <div class="inner-circle"></div>
                <p class="h6 mb-1 font-weight-bold">Negosiasi</p>
                <?php if ($awa_id > 1139) { ?>
                    <p class="h6" id="ptp_negosiation_date_"></p>
                <?php } else { ?>
                    <p class="h6">Dalam proses</p>
                <?php } ?>
            </div>
        </div>

        <div class="timeline-step">
            <div class="timeline-content"  data-original-title="2004">
                <div class="inner-circle"></div>
                <p class="h6 mb-1 font-weight-bold">USKEP</p>
                <?php if ($awa_id > 1140) { ?>
                    <p class="h6" id="ptp_uskep_date_"></p>
                <?php } else { ?>
                    <p class="h6">Dalam proses</p>
                <?php } ?>
            </div>
        </div>
        <div class="timeline-step">
            <div class="timeline-content"  data-original-title="2005">
                <div class="inner-circle"></div>
                <p class="h6 mb-1 font-weight-bold">Pengumuman</p>
                <?php if ($awa_id > 1159) { ?>
                    <p class="h6" id="ptp_announcement_date_"></p>
                <?php } else { ?>
                    <p class="h6">Dalam proses</p>
                <?php } ?>
            </div>
        </div>
        <div class="timeline-step">
            <div class="timeline-content"  data-original-title="2010">
                <div class="inner-circle"></div>
                <p class="h6 mb-1 font-weight-bold">Sanggahan</p>
                <?php if ($awa_id > 1169) { ?>
                    <p class="h6" id="ptp_disclaimer_date_"></p>
                <?php } else { ?>
                    <p class="h6">Dalam proses</p>
                <?php } ?>
            </div>
        </div>
        <div class="timeline-step mb-0">
            <div class="timeline-content"  data-original-title="2020">
                <div class="inner-circle"></div>
                <p class="h6 mb-1 font-weight-bold">Penunjukan</p>
                <?php if ($awa_id > 1179) { ?>
                    <p class="h6" id="ptp_appointment_date_"></p>
                <?php } else { ?>
                    <p class="h6">Dalam proses</p>
                <?php } ?>
            </div>
        </div>

    </div>

</div>

<div class="wrapper wrapper-content animated fadeInRight">

	<form id="formtender" method="post" action="<?php echo site_url($controller_name."/submit_ubah_tender_pengadaan");?>"  class="form-horizontal ajaxform">

		<input type="hidden" name="id" value="<?php echo $id ?>">
		<input type="hidden" name="hps" value="<?php echo $permintaan_hide['nilai'] ?>">
		<input type="hidden" name="plan" value="<?php echo $perencanaan['ppm_id'] ?>">
		<input type="hidden" name="remain" value="<?php echo $perencanaan['ppm_sisa_anggaran'] ?>">

		<?php
            foreach ($content as $key => $value) {
                include($value['awc_type']."/".$value['awc_file'].".php");
            }
		?>

        <?php if($awa_id < 1041){ ?>
            <section id="rksForm">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-bottom pb-2">
                                <div class="btn-group-sm float-left">
                                    <h4 class="card-title">Rencana Kerja dan Syarat - Syarat (RKS) <a href="<?php echo site_url('administration/master_data/rks') ?>" target="_blank" aria-expanded="true" class="btn btn-info btn-sm" style="text-transform:capitalize;"><i class="ft-plus"></i> Tambah</a></h4>
                                </div>
                                <div class="btn-group-sm float-right position-relative">
                                    <a onclick="syncRKS()" class="btn btn-success"><i class="ft-refresh-cw"></i> Sync</a>
                                </div>
                            </div>

                            <div class="card-content" style="margin-top: -30px">
                                <div class="card-body">
                                    <div class="col-12">
                                        <div class="card collapse-icon accordion-icon-rotate">
                                            <div class="accordion" id="rksPanel">
                                                <div class="card-body">
                                                    <?php $no_head=1; foreach ($dataHeaderRKS as $rks) { ?>
                                                    <div>
                                                        <div class="card-header border-bottom pb-2" id="headingAccordion<?php echo $no_head; ?>">
                                                            <div class="checkbox checkbox-info" onclick="checkAllSub(<?php echo $no_head; ?>)">
                                                                <input type="checkbox" onclick="checkAllSub(<?php echo $no_head; ?>)" class="head<?php echo $no_head; ?>" id="color-checkbox-<?php echo $no_head; ?>">
                                                                <label for="color-checkbox-<?php echo $no_head; ?>"><span>
                                                                    <a data-toggle="collapse" href="#accordion<?php echo $no_head; ?>" aria-expanded="false" aria-controls="accordion<?php echo $no_head; ?>" class="card-title">
                                                                        <?php echo $rks->header_main; ?>
                                                                    </a>
                                                                </span></label>
                                                            </div>
                                                        </div>

                                                        <div id="accordion<?php echo $no_head; ?>" class="collapse" data-parent="#rksPanel">
                                                            <!-- sub rks -->
                                                            <div class="accordion" id="rksPanelSub">
                                                                <div class="card-body">
                                                                    <?php
                                                                        $no_sub=1;
                                                                        $dataSubRKS = $this->db->query("select distinct header_sub from adm_rks where header_main = '". $rks->header_main ."' and header_sub is not null")->result();
                                                                        foreach ($dataSubRKS as $sub) {
                                                                    ?>

                                                                    <div>
                                                                        <div class="card-header border-bottom pb-2" id="headingAccordion<?php echo $no_head.$no_sub; ?>">
                                                                            <div class="checkbox checkbox-info">
                                                                                <input type="checkbox" class="sub<?php echo $no_head; ?>" id="color-checkbox-<?php echo $no_head.$no_sub; ?>">
                                                                                <label for="color-checkbox-<?php echo $no_head.$no_sub; ?>"><span>
                                                                                    <a data-toggle="collapse" href="#accordion<?php echo $no_head.$no_sub; ?>" aria-expanded="false" aria-controls="accordion<?php echo $no_head.$no_sub; ?>" class="card-title">
                                                                                        <?php echo $sub->header_sub; ?>
                                                                                    </a>
                                                                                </span></label>
                                                                            </div>
                                                                        </div>
                                                                        <div id="accordion<?php echo $no_head.$no_sub; ?>" class="collapse" data-parent="#rksPanelSub">
                                                                            <div class="card-body">
                                                                                <div class="table-responsive">
                                                                                    <table class="table table-striped m-0">
                                                                                        <tbody>
                                                                                            <?php
                                                                                            $no_desc=1;
                                                                                            $dataDesc = $this->db->query("select id, description from adm_rks where header_main = '". $rks->header_main ."' and header_sub = '". $sub->header_sub ."' and description is not null")->result();
                                                                                            foreach ($dataDesc as $desc) { ?>
                                                                                            <tr>
                                                                                                <td>
                                                                                                <div class="checkbox checkbox-info">
                                                                                                    <input type="checkbox" class="subsub<?php echo $no_head; ?>" id="color-checkbox-<?php echo $no_head.$no_sub.$no_desc; ?>" name="rks_desc_inp[]" value="<?php echo $desc->id; ?>">
                                                                                                    <label for="color-checkbox-<?php echo $no_head.$no_sub.$no_desc; ?>"><span>
                                                                                                        <?php echo $desc->description ?>
                                                                                                    </span></label>
                                                                                                </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                            <?php $no_desc++; } ?>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <?php $no_sub++; } ?>
                                                                </div>
                                                            </div>
                                                            <!-- end sub -->
                                                        </div>
                                                    </div>
                                                    <?php $no_head++; } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php } ?>

        <?php if(isset($tenderRks) && !empty($tenderRks)){ ?>
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
                                    foreach ($tenderRks as $key => $value) { ?>

                                        <tr>
                                            <td><?php echo $key+1 ?></td>
                                            <td><?php echo $value['rks_cat'] ?></td>
                                            <td><?php echo $value['rks_sub_cat'] ?></td>
                                            <td><?php echo $value['rks_desc'] ?></td>
                                            <td><?php echo $value['created_date'] ?></td>
                                        </tr>

                                    <?php } ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        <?php } ?>

	    <?php $i = 0; include(VIEWPATH."/comment_workflow_attachment_v.php"); ?>

        <div class="card">
			<div class="card-content">
				<div class="card-body">
					<?php echo buttonsubmit('procurement/daftar_pekerjaan',lang('back'),lang('save')) ?>
				</div>
			</div>
		</div>

	</form>

    <?php if ((int)$awa_id > 1040) { ?>
        <?php include("form/modal_eval_view_v.php"); ?>
    <?php } else { ?>
        <!-- <?php include("form/modal_eval_v.php"); ?> -->
    <?php } ?>

    <?php include("view/modal_pengumuman_v.php"); ?>

	<script type="text/javascript">localStorage.setItem('dialogshow', "");</script>

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

        if(data["ptp_reg_opening_date"] != null) document.getElementById("mulai_pendaftaran").innerHTML = moment(pembukaan).format('DD/MMMM/YYYY')
    
        if(data["ptp_quot_opening_date"] != null && <?php echo $awa_id ?> > 1089)        document.getElementById("ptp_quot_opening_date_").innerHTML = moment(penawaran).format('DD/MMMM/YYYY')

        if(data["ptp_negosiation_date"] != null && <?php echo $awa_id ?> > 1139)         document.getElementById("ptp_negosiation_date_").innerHTML = moment(negosiasi).format('DD/MMMM/YYYY')

        if(data["ptp_uskep_date"] != null && <?php echo $awa_id ?> > 1140)         document.getElementById("ptp_uskep_date_").innerHTML = moment(uskep).format('DD/MMMM/YYYY')

        if(data["ptp_announcement_date"] != null && <?php echo $awa_id ?> > 1159)         document.getElementById("ptp_announcement_date_").innerHTML = moment(pengumuman).format('DD/MMMM/YYYY')

        if(data["ptp_disclaimer_date"] != null && <?php echo $awa_id ?> > 1169)         document.getElementById("ptp_disclaimer_date_").innerHTML = moment(sanggahan).format('DD/MMMM/YYYY')

        if(data["ptp_appointment_date"] != null && <?php echo $awa_id ?> > 1179)         document.getElementById("ptp_appointment_date_").innerHTML = moment(penunjukan).format('DD/MMMM/YYYY')

    </script>

    <script type="text/javascript">
        function syncRKS () {
          $('#rksForm').load(document.URL +  ' #rksForm');
          alert("Form RKS telah diperbarui.");
        };

        function checkAllSub(headid) {
            $(".head"+headid).click(function () {
                $(".sub"+headid).not(this).prop('checked', this.checked);
                $(".subsub"+headid).not(this).prop('checked', this.checked);

            });
        }
    </script>

</div>
