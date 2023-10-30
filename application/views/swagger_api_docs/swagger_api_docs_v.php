<!-- HTML for static distribution bundle build -->
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Swagger UI</title>
    <link rel="shortcut icon" href="<?php echo base_url('assets/img/favicon.png') ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/js/plugins/swagger/swagger-ui.css') ?>" >
    <!-- <link rel="icon" type="image/png" href="<?php //echo base_url('assets/js/plugins/swagger/favicon-32x32.png') ?>" sizes="32x32" /> -->
    <!-- <link rel="icon" type="image/png" href="<?php //echo base_url('assets/js/plugins/swagger/favicon-16x16.png') ?>" sizes="16x16" /> -->
    <style>
      html
      {
        box-sizing: border-box;
        overflow: -moz-scrollbars-vertical;
        overflow-y: scroll;
      }

      *,
      *:before,
      *:after
      {
        box-sizing: inherit;
      }

      body
      {
        margin:0;
        background: #fafafa;
      }
    </style>
  </head>

  <body>
    <div id="swagger-ui"></div>

    <script src="<?php echo base_url('assets/js/plugins/swagger/swagger-ui-bundle.js') ?>"> </script>
    <script src="<?php echo base_url('assets/js/plugins/swagger/swagger-ui-standalone-preset.js') ?>"> </script>
    <script>
    window.onload = function() {

      // Build a system
      const ui = SwaggerUIBundle({
        url: "<?php echo site_url('swagger/swagger_json') ?>",
        dom_id: '#swagger-ui',
        deepLinking: true,
        presets: [
          SwaggerUIBundle.presets.apis,
          SwaggerUIStandalonePreset
        ],
        plugins: [
          SwaggerUIBundle.plugins.DownloadUrl
        ],
        layout: "StandaloneLayout"
      })

      window.ui = ui
    }
  </script>
  </body>
</html>
