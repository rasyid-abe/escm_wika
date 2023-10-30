<style>
    .btn-trash {
        border-radius: 0 8px 8px 0 !important;
        background-color: rgb(36 36 36 / 22%);
        right: 0%;
        position: absolute;
    }

    .btn-plus {
        padding: 0.25rem 2rem !important;
        border-radius: 8px 0 0 8px !important;
        right: 30px;
        position: absolute;
    }

    .btn-action-edit {
        border-radius: 8px 0 0 8px;
        width: 100px;
    }

    .btn-action-delete {
        border-radius: 0 8px 8px 0;
        background-color: rgb(36 36 36 / 22%);
        position: relative;
        left: 0px;
    }

    .form-control {
        border: 2px solid #29a7de;
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-radius: 15px;
        padding: 6px;
        background-color: transparent;
    }

    .pull-right {
        margin-right: 20px;
    }

    .fixed-table-container {
        border: none !important;
    }

    .fixed-table-toolbar .bars,
    .fixed-table-toolbar .columns,
    .fixed-table-toolbar .search {
        margin-right: 10rem;
    }

    .custom-button-position {
        position: absolute;
        right: 2rem;
        top: 4.4rem;
    }

    .btn-export {
        background-color: transparent;
        /* border: none; */
        border: 2px solid #29a7de;
        border-top: 0;
        border-left: 0;
        border-right: 0;
        border-radius: 15px;
        padding: 6px;
        background-color: transparent;
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <a href="<?= base_url() ?>procurement/proses_pengadaan/pembuatan_rencana_pengadaan" class="btn btn-info" style="border-radius: 10px;">
                        <i class="ft ft-plus"></i>Tambah
                    </a>

                    <button class="btn btn-export ml-1 rounded custom-button-position" id="exportTable">
                        <img width="20" class="mr-1" src="<?= base_url('assets/img/icons/printer.png') ?>" alt="printer-icon">
                        Export <i class=" fa fa-angle-down fa-lg"></i>
                    </button>
                    <table id="table_rencana_pengadaan" class="table table-striped table-hover table-borderless">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://unpkg.com/tableexport.jquery.plugin/tableExport.min.js"></script>
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

    function detailFormatter(index, row, url) {
        var mydata = $.getCustomJSON("<?php echo site_url('Procurement') ?>/" + url);
        var html = [];

        $.each(row, function(key, value) {
            var data = $.grep(mydata, function(e) {
                return e.field == key;
            });

            if (typeof data[0] !== 'undefined') {
                html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
            }
        });
        return html.join('');
    }

    function operateFormatter(value, row, index) {
        var link = "<?php echo site_url('procurement/proses_pengadaan/daftar_rencana_pengadaan') ?>";
        return [
            '<a href="' + link + '/lihat/' + value + '" class="btn btn-sm btn-info btn-action-edit">Lihat</a>',
        ].join('');
    }

    function indexFormatter(value, row, index) {
        return index + 1
    }
    function toUpperCased(value, row, index) {
        if (row.pr_type_pengadaan) {
            return row.pr_type_pengadaan.toUpperCase()
        } else {
            return "-"
        }
        // return row.pr_type_pengadaan.toUpperCase()
    }
    window.operateEvents = {
        'click .approval': function(e, value, row, index) {},
    };

    function totalTextFormatter(data) {
        return 'Total';
    }

    function totalNameFormatter(data) {
        return data.length;
    }

    function totalPriceFormatter(data) {
        var total = 0;
        $.each(data, function(i, row) {
            total += +(row.price.substring(1));
        });
        return '$' + total;
    }
</script>

<script type="text/javascript">
    var $table_rencana_pengadaan = $('#table_rencana_pengadaan'),
    selections = [];
</script>

<script type="text/javascript">
    $("#exportTable").click(function() {
        $('#table_rencana_pengadaan').tableExport({
            type: 'excel'
        });
    })
    $(function() {

        $table_rencana_pengadaan.bootstrapTable({
            url: "<?php echo site_url('Procurement/data_rencana_pengadaan') ?>",
            cookieIdTable: "rencana_pengadaan",
            idField: "id",
            striped: false,
            sidePagination: 'server',
            smartDisplay: true,
            cookie: true,
            cookieExpire: '1h',
            showFilter: true,
            flat: false,
            keyEvents: false,
            showMultiSort: false,
            reorderableColumns: false,
            resizable: false,
            pagination: true,
            cardView: false,
            detailView: false,
            search: true,
            columns: [{
                field: 'id',
                title: 'No',
                order: true,
                searchable: true,
                align: 'center',
                valign: 'middle',
                formatter: indexFormatter
            },
            {
                field: 'smbd_code',
                title: 'Kode Sumberdaya',
                order: true,
                searchable: true,
                align: 'left',
                valign: 'middle',
            },
            {
                field: 'smbd_name',
                title: 'Nama Sumberdaya',
                order: true,
                searchable: true,
                align: 'left',
                valign: 'middle',
                width: '15%',
            },
            {
                field: 'project_name',
                title: 'Nama Proyek',
                order: true,
                searchable: true,
                valign: 'middle',
                align: 'left',
            },
            {
                field: 'unit',
                title: 'Satuan',
                order: true,
                searchable: true,
                align: 'left',
                valign: 'middle',
            },
            {
                field: 'sbmd_quantity',
                title: 'Volume',
                order: true,
                searchable: true,
                align: 'left',
                valign: 'middle',
            },
            {
                field: 'price',
                title: 'Harga Satuan',
                order: true,
                searchable: true,
                align: 'left',
                valign: 'middle',
            },
            {
                field: 'total',
                title: 'Total Harga',
                order: true,
                searchable: true,
                align: 'left',
                valign: 'middle',
            },
            {
                field: 'user_name',
                title: 'Kasie Pengadaan',
                order: true,
                searchable: true,
                align: 'left',
                valign: 'middle',
            },
            {
                field: 'id',
                title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
                align: 'center',
                valign: 'middle',
                width: '14%',
                events: operateEvents,
                formatter: operateFormatter,
            },
        ]

    });
    setTimeout(function() {
        $table_rencana_pengadaan.bootstrapTable('resetView');
    }, 200);

    $table_rencana_pengadaan.on('expand-row.bs.table', function(e, index, row, $detail) {
        $detail.html(detailFormatter(index, row, "alias_rencana_pengadaan"));
    });

});
</script>
