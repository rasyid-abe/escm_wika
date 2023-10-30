<div class="row">
    <div class="col-12">
        <div class="card">

            <div class="card-header border-bottom pb-2">
                <h4 class="card-title">Daftar Pekerjaan Kontrak SAP</h4>
            </div>

            <div class="card-content">
                <div class="card-body">
                    <div class="table-responsive">

                        <table id="table_pekerjaan_kontrak_sap" class="table table-bordered table-striped"></table>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">

function kontrak_act_sap(value, row, index) {
    var link = "<?php echo site_url('contract/daftar_pekerjaan') ?>";

    // if ((row.ctr_po_number == null) && (row.ctr_is_manual == "YES")) {
    //     return [
    //         '<a class="btn btn-warning btn-xs action" href="'+link+'/edit/'+value+'">',
    //         'Edit',
    //         '</a>  ',
    //     ].join('');
    //
    // } else {
        return [
            '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_kontrak/'+value+'">',
            'Proses',
            '</a>  ',
        ].join('');

    // }
}

var $table_pekerjaan_kontrak_sap = $('#table_pekerjaan_kontrak_sap');
var selections = [];

$(function () {

    $table_pekerjaan_kontrak_sap.bootstrapTable({

        url: "<?php echo site_url('contract/data_pekerjaan_kontrak_sap') ?>",
        cookieIdTable:"daftar_pekerjaan_kontrak",
        idField:"ccc_id",
        <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
        columns: [
            {
                field: "ccc_id",
                title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
                align: 'center',
                width:'8%',
                valign: 'middle',
                formatter: kontrak_act_sap,
            },
            {
                field: 'ptm_number',
                title: 'Nomor Pengadaan',
                sortable:true,
                order:true,
                searchable:true,
                align: 'center',
                valign: 'middle',
                width:'14%',
            },
            {
                field: 'contract_number',
                title: 'Nomor Kontrak',
                sortable:true,
                order:true,
                searchable:true,
                align: 'center',
                valign: 'middle',
                width:'14%',
            },
            {
                field: 'subject_work',
                title: 'Deskripsi Pekerjaan',
                sortable:true,
                order:true,
                searchable:true,
                align: 'center',
                valign: 'middle',
                width:'30%',
            },
            {
                field: 'vendor_name',
                title: 'Vendor',
                sortable:true,
                order:true,
                searchable:true,
                align: 'left',
                valign: 'middle',

            },
            {
                field: 'contract_type',
                title: 'Tipe',
                sortable:true,
                order:true,
                searchable:true,
                align: 'left',
                valign: 'middle',

            },
            {
                field: 'activity',
                title: 'Activity',
                sortable:true,
                order:true,
                searchable:true,
                align: 'left',
                valign: 'middle',
                width:'20%',
            // },
            // {
            //     field: 'is_sap',
            //     title: 'SAP',
            //     sortable:true,
            //     order:true,
            //     searchable:true,
            //     align: 'center',
            //     valign: 'middle',
            //     width:'5%',
            },
            {
                field: 'status_po',
                title: 'Status',
                sortable:true,
                order:true,
                searchable:true,
                align: 'left',
                valign: 'middle',
                width:'20%',
            },
            {
                field: 'waktu',
                title: 'Waktu',
                sortable:true,
                order:true,
                searchable:true,
                align: 'center',
                valign: 'middle',
                width:'15%',
            },
        ]

    });
    setTimeout(function () {
        $table_pekerjaan_kontrak_sap.bootstrapTable('resetView');
    }, 200);

    $table_pekerjaan_kontrak_sap.on('expand-row.bs.table', function (e, index, row, $detail) {
        $detail.html(detailFormatter(index,row,"alias_kontrak"));
    });

});

</script>
