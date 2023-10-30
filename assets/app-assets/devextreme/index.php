<!DOCTYPE html>
<html>
<head>
	<title></title>


<link rel="stylesheet" href="css/devextreme/bootstrap.min.css" type="text/css"  />
<link rel="stylesheet" href="css/devextreme/dx.light.css" type="text/css"  />
<link rel="stylesheet" href="css/devextreme/dx.common.css" type="text/css"  />

<script src="js/devextreme/jquery-3.2.1.min.js"></script>
<script src="js/devextreme/dx.all.js"></script>
<script src="js/devextreme/globalize.min.js"></script>
<script src="js/devextreme/jszip.js"></script>
</head>
<body>
	<?php
		$data[0]['name'] = "adip";
		$data[0]['phone'] = "08389423232";
		$data[1]['name'] = "joko";
		$data[1]['phone'] = "1233333333";

	$result = json_encode($data);

	?>
	<div id="grid"></div>
</body>
<script type="text/javascript">
	jQuery(function($) {
		// body...
		 $("#grid").dxDataGrid({
                            dataSource: <?php echo $result ?>,
                            showBorders: true,
                            filterRow: {
				            visible: true,
				            applyFilter: "auto"
				        },
				        searchPanel: {
				            visible: true,
				            placeholder: "Search..."
				        },
                            paging: {
                                pageSize: 10
                            },
                            pager: {
                                showPageSizeSelector: true,
                                allowedPageSizes: [5, 10, 20],
                                showInfo: true
                            },

                            columns: [
                                
                                {
                                    caption: "Name",
                                    dataField: "name"
                                },
                                {
                                    caption: "phone",
                                    dataField: "phone"
                                }
                            ]
                        });
	});
</script>
</html>