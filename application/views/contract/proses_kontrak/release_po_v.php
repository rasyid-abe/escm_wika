<div style="display: none;" class="alert alert-notif mt-2" role="alert">
  <span id="alert-text"></span>
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>



<script>

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;

        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');

            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
    };

    if(getUrlParameter('status') != typeof undefined){

        if (getUrlParameter('status') == 'success') {

            $('.alert-notif').addClass('bg-light-info').css('display','block')
            $('#alert-text').html(getUrlParameter('msg'))

        } else if (getUrlParameter('status') == 'fail'){

            $('.alert-notif').addClass('bg-light-warning').css('display','block')
            $('#alert-text').html(getUrlParameter('msg'))

        } else if (getUrlParameter('status') == 'not_found'){

            $('.alert-notif').addClass('bg-light-danger').css('display','block')
            $('#alert-text').html(getUrlParameter('msg'))

        } else if (getUrlParameter('status') == 'error_ws'){

            $('.alert-notif').addClass('bg-light-danger').css('display','block')
            $('#alert-text').html(getUrlParameter('msg'))
        }

    }

</script>