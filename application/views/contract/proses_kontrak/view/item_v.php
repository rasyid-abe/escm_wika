<?php 
if($kontrak['status'] != 2901) :
?>
<?php $ctr_type = (isset($kontrak['contract_type'])) ? $kontrak["contract_type"] : ""; ?>
 <div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header">
        <h4 class="card-title float-left">Daftar Sumberdaya</h4>
      </div>

      <div class="card-content">
        <div class="card-body">

          <div class="table-responsive">
              <table class="table">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kode</th>
                      <th>Nama Sumberdaya</th>
                      <?php if ($is_sap == 1): ?>
                          <th>Item PO</th>
                      <?php endif; ?>
                      <th>Volume</th>
                      <th>Satuan</th>
                      <th>RAB</th>
                      <th>Subtotal</th>
                      <th>Incoterm</th>
                      <th>Lokasi Incoterm</th>
                      <th>Harga Satuan Kontrak</th>
                      <th>Subtotal Kontrak</th>
                      <th style="display: none;">Pajak</th>
                      <?php if ($is_sap == 1): ?>
                          <th>No Asset</th>
                          <th>Sub Number</th>
                          <th>Tax Code</th>
                      <?php endif; ?>
                    </tr>

                  </thead>

                  <tbody>

                    <?php
                    $subtotal = 0;
                    $subtotal_ppn = 0;
                    $subtotal_pph = 0;
                    foreach ($item as $key => $value) {
                        $co = $value['item_code'];
                        if ((int)$value['item_code'] != 0) {
                            $co = (int)$value['item_code'];
                        }

                        $ta = $this->db->get_where('adm_tax_code', ['tax_code' => $value['tax_code']])->row('description');
                    ?>
                    <tr>
                      <td class="align-middle"><?php echo $key+1 ?></td>
                      <td class="align-middle"><?php echo $co ?></td>
                      <td class="align-middle"><?php echo $value['long_description'] ?></td>
                      <?php if ($is_sap == 1): ?>
                          <td class="align-middle"><?php echo ($key+1) * 10 ?></td>
                      <?php endif; ?>
                      <td class="text-right align-middle"><?php echo inttomoney($value['qty']) ?></td>
                      <td class="align-middle"><?php echo $value['uom'] ?></td>
                      <td class="text-right align-middle"><?php echo inttomoney($value['price']) ?>
                        <input type="hidden" class="form-control price" value="<?php echo $value['price'] ?>">
                      </td>
                      <td class="text-right align-middle"><?php echo inttomoney($value['qty'] * $value['price']) ?></td>
                      <td class="align-middle"><?= $value['incoterm'] ?></td>
                      <td class="align-middle"><?= $value['lokasi_incoterm'] ?></td>
                      <td class="align-middle"><?= inttomoney($value['hps']) ?></td>
                      <td class="align-middle"><?= inttomoney($value['qty'] * $value['hps'] ) ?></td>
                      <td style="display: none;">
                        <?php echo (!empty($value['ppn'])) ? " PPN (".$value['ppn']."%) " : "" ?>
                        <?php echo (!empty($value['pph'])) ? " PPH (".$value['pph']."%)" : "" ?>
                      </td>
                      <?php if ($is_sap == 1): ?>
                          <td class="align-middle"><?php echo $value['no_asset'] ?></td>
                          <td class="align-middle"><?php echo $value['sub_number'] ?></td>
                          <td class="align-middle"><?php echo $ta ?></td>
                      <?php endif; ?>
                    </tr>
                    <?php
                    $subtotal += $value['price']*$value['qty'];
                    if(!empty($value['ppn'])){
                      $subtotal_ppn += $value['price']*$value['qty']*($value['ppn']/100);
                    }
                    if(!empty($value['pph'])){
                    $subtotal_pph += $value['price']*$value['qty']*($value['pph']/100);
                  }
                } ?>

              </tbody>

            </table> <hr/>
          </div>

          <div class="row form-group mt-3">
            <div class="col-sm-5"></div>
            <label class="col-sm-5 control-label text-right text-bold-700">Nilai Kontrak</label>
            <div class="col-sm-2">
              <?php $nilai_kontrak = (isset($kontrak['contract_amount'])) ? inttomoney($kontrak['contract_amount']) : 0; ?>
              <p class="form-control-static text-right text-bold-700"> <?php echo $nilai_kontrak ?></p>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-5"></div>
            <label class="col-sm-5 control-label text-right text-bold-700">Total RAB</label>
            <div class="col-sm-2">
              <p class="form-control-static text-right text-bold-700"> <?php echo inttomoney($rab) ?></p>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-5"></div>
            <label class="col-sm-5 control-label text-right text-bold-700">Efisiensi/Inefisiensi</label>
            <div class="col-sm-2">
              <p class="form-control-static text-right text-bold-700"> <?php echo inttomoney($rab - $kontrak['contract_amount']); ?></p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
<?php else : ?>
  <div class="row">
  <div class="col-12">
    <div class="card">

      <div class="card-header">
        <h4 class="card-title float-left">Daftar Sumberdaya</h4>
      </div>

      <div class="card-content">
        <div class="card-body">
          <div id="itemGrid"></div>
           <div class="row form-group mt-3">
            <div class="col-sm-5"></div>
            <label class="col-sm-5 control-label text-right text-bold-700">Nilai Kontrak</label>
            <div class="col-sm-2">
              <?php $nilai_kontrak = (isset($kontrak['contract_amount'])) ? inttomoney($kontrak['contract_amount']) : 0; ?>
              <p class="form-control-static text-right text-bold-700"> <?php echo $nilai_kontrak ?></p>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-5"></div>
            <label class="col-sm-5 control-label text-right text-bold-700">Total RAB</label>
            <div class="col-sm-2">
              <p class="form-control-static text-right text-bold-700"> <?php echo inttomoney($rab) ?></p>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-sm-5"></div>
            <label class="col-sm-5 control-label text-right text-bold-700">Efisiensi/Inefisiensi</label>
            <div class="col-sm-2">
              <p class="form-control-static text-right text-bold-700"> <?php echo inttomoney($rab - $kontrak['contract_amount']); ?></p>
            </div>
          </div>

        </div>
      </div>

    </div>
  </div>
</div>
<?php $this->load->view('devextreme'); ?>

<script>
  $(document).ready(function () {

    const URL = '<?= site_url() ?>/Sap';
    const ordersStore = new DevExpress.data.CustomStore({
    key: 'contract_item_id',
    load() {
      //var data = [];
      //d.resolve(data);
      var d = $.Deferred();
				$.ajax({
					type: "GET",
					url: URL + '/get_item_contract_po/' + <?= $contract_id ?>,
					//data: "data",
					dataType: "json",
					success: function(response) {
            d.resolve(response.data);
            //return d.promise();
					}
				});
				return d.promise();
    },
 
    update(key, values) {
      var d = $.Deferred();
      $.ajax({
					type: "POST",
					url: URL + '/update_contract_item_po/' + <?= $contract_id ?>,
					data: {key: key, values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						//d.resolve();
            if(response.code == 200)
            {
              d.resolve(response.data);
              $('#itemGrid').dxDataGrid("instance").refresh();
              
            }

            //location.reload();
					}
				});
				return d.promise();
      // return sendRequest(`${URL}/update_score`, 'POST', {
      //   key,
      //   values: JSON.stringify(values),
      // });
    },

    insert: function (values) {
        // ...
        var d = $.Deferred();
      $.ajax({
					type: "POST",
					url: URL + '/insert_contract_item_po/' + <?= $contract_id ?>,
					data: {values : JSON.stringify(values)},
					dataType: "json",
					success: function(response) {
						//d.resolve();
            if(response.code == 200)
            {
              d.resolve(response.data);
              $('#itemGrid').dxDataGrid("instance").refresh();
              
            }

            //location.reload();
					}
				});
				return d.promise();
    },
    remove: function (key) {
        // ...
        var d = $.Deferred();
      $.ajax({
					type: "POST",
					url: URL + '/remove_contract_item_po/' + <?= $contract_id ?>,
					data: {key: key},
					dataType: "json",
					success: function(response) {
						//d.resolve();
            if(response.code == 200)
            {
              d.resolve(response.data);
              $('#itemGrid').dxDataGrid("instance").refresh();
              
            }

            //location.reload();
					}
				});
				return d.promise();
    }
  });

  const dataGrid = $('#itemGrid').dxDataGrid({
    dataSource: ordersStore,
    showBorders: true,
    //  remoteOperations: true,
    editing: {
      mode: 'row',
      allowAdding: true,
      allowUpdating: true,
      allowDeleting: true,
    },
    scrolling: {
      mode: 'virtual',
    },
    columns: [
    
    {
      dataField: 'item_code',
      caption: 'Kode',
      weight: 450,
      //allowEditing: false,
      lookup: {
                                dataSource: new DevExpress.data.CustomStore({
                                    cacheRawData: false,
                                    loadMode: "raw",
                                    load: function () {
                                        return $.getJSON(URL + "/get_item_pr_dropdown/"+ "<?= $ptm_number ?>");
                                    }
                                }),
                                valueExpr: "code",
                                displayExpr: "dropdown_name"
                            }
    },
    {
      dataField: 'long_description',
      caption: 'Nama Sumber Daya',
      allowEditing: false,
    },
    {
      dataField: 'qty',
      caption: 'Volume',
      dataType: "number",
      format: '#,##0.00;(#,##0.00)',
      editorOptions: {
                                min: 1,
                            },
      validationRules: [{ type: "numeric" }],
    },
    {
      dataField: 'uom',
      caption: 'Satuan',
      allowEditing: false,
    },
    {
      dataField: 'price',
      caption: 'Harga Satuan',
      dataType: "number",
      format: '#,##0.00;(#,##0.00)',
      editorOptions: {
                                min: 1,
                            },
      validationRules: [{ type: "numeric" }],
    },

    {
      //dataField: 'price',
      caption: 'Sub Total',
      allowEditing: false,
      dataType: "number",
      format: '#,##0.00;(#,##0.00)',
      calculateCellValue: function (rowData) {
                      
                        var Equal = parseFloat(rowData.qty) * parseFloat(rowData.price);

                        return parseFloat(Equal);
                        //return 0;

      }

    },
    {
      dataField: 'incoterm',
      caption: 'Inconterm',
      validationRules: [{ type: "required" }],

      lookup: {
                                dataSource: new DevExpress.data.CustomStore({
                                    cacheRawData: false,
                                    loadMode: "raw",
                                    load: function () {
                                        return $.getJSON(URL + "/get_incoterm/");
                                    }
                                }),
                                valueExpr: "description",
                                displayExpr: "description"
                            }
      // allowEditing: false,
    },
    {
      dataField: 'lokasi_incoterm',
      caption: 'Lokasi Inconterm',
      validationRules: [{ type: "required" }],

      // allowEditing: false,
    },
    {
      dataField: 'hps',
      caption: 'Harga Satuan Kontrak',
      dataType: "number",
      format: '#,##0.00;(#,##0.00)',
      validationRules: [{ type: "numeric" }],
      //allowEditing: false,
    },
     {
      //dataField: 'hps',
      caption: 'SubTotal Kontrak',
      dataType: "number",
      format: '#,##0.00;(#,##0.00)',
      allowEditing: false,
      calculateCellValue: function (rowData) {
                      
                      var Equal = parseFloat(rowData.qty) * parseFloat(rowData.hps);

                      return parseFloat(Equal);
                      //return 0;

    }
    },
    ],
    onToolbarPreparing: function (e) {
                        let toolbarItems = e.toolbarOptions.items;

                        toolbarItems.forEach(function (item) {
                           
                        });

                        // Adds a new item
                        toolbarItems.push({
                            widget: "dxButton",
                            name: "cutStatementBtn",
                            options: {
                                hint: "PUSH SAP",
                                icon: "save",
                                text: "PUSH SAP",
                                onClick: function (e) {
                                    PUSH_SAP();
                                },
                                elementAttr: { id: 'cutStatementBtn' },
                                //disabled: true
                            },
                            location: "after"
                        });

                        toolbarItems.push({
                            widget: "dxButton",
                            name: "GenerateBAKPK",
                            options: {
                                hint: "Generate BAKPK",
                                icon: "save",
                                text: "Generate BAKPK",
                                onClick: function (e) {
                                  GenerateBAKPK();
                                },
                                elementAttr: { id: 'cutStatementBtn' },
                                //disabled: true
                            },
                            location: "after"
                        });

                        toolbarItems.push({
                            widget: "dxButton",
                            location: "after",
                            options: {
                                icon: "refresh", onClick: function () {
                                    $("#itemGrid").dxDataGrid("instance").refresh();
                                }
                            }
                        });
      },
    
    
  }).dxDataGrid('instance');

  });

 
  function PUSH_SAP() {
    var contract_id = <?= $contract_id ?>;

    var result = DevExpress.ui.dialog.confirm("<i>Are you sure?</i>", "Confirm Push");
                                result.done(function (dialogResult) {
                                    if (dialogResult) {
                                      var URL = '<?= site_url() ?>/Sap';

                                      $.ajax({

                                        type: "GET",
                                        url: URL + "/push_edit_po_sap/" + contract_id,
                                        dataType: "json",
                                        success: function (response) {
                                            if (response.code == 200) {
                                                DevExpress.ui.notify(response.message, "success", 2600);

                                            } else {
                                                DevExpress.ui.notify(response.message, "error", 2600);
                                            }
                                        }
                                        });

                                    }
      });

  }


  function GenerateBAKPK() {
    var contract_id = <?= $contract_id ?>;

    var result = DevExpress.ui.dialog.confirm("<i>Are you sure?</i>", "Confirm Push");
                                result.done(function (dialogResult) {
                                    if (dialogResult) {
                                      var URL = '<?= site_url() ?>/Sap';

                                      $.ajax({

                                        type: "GET",
                                        url: URL + "/push_edit_po_sap/" + contract_id,
                                        dataType: "json",
                                        success: function (response) {
                                            if (response.code == 200) {
                                                DevExpress.ui.notify(response.message, "success", 2600);

                                            } else {
                                                DevExpress.ui.notify(response.message, "error", 2600);
                                            }
                                        }
                                        });

                                    }
      });

  }

</script>
<?php endif; ?>