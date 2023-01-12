{{ HTML::script('public/assets/js/jquery-3.6.0.js') }}
{{ HTML::script('public/assets/validator/validator.js') }}
<script type="text/javascript">
      
        $('#myForm').submit(function(event) {

          event.preventDefault();

          $('#resultajax').append('<img src="{{ url() }}/public/assets/images/loader.gif" alt="{{Lang::get($path.'.please_wait')}}" />');

          $('#myForm input.btn').hide();

          
           $.ajax({
            type: 'POST',
            url: '{{ route("keyWords") }}',
            data: $(this).serialize(),

            success: function(data) {
                                
                if(data == 'true') {   
                  $('#resultajax').html("<div id='toasts-container' class='toasts-container top-auto lg:top-0 bottom-0 lg:bottom-auto right-0 left-0 lg:ltr:left-auto lg:rtl:right-auto'><div class='toast mb-4'><div class='toast-header alert alert_success'> {{ Lang::get($path.'.add_successfully') }}<small class='text-gray-500'></small><button type='button' class='close' data-dismiss='toast'>&times;</button></div></div></div>");
                  $('#myForm input.btn').show();
                  setInterval(refresh, 500);
                 }

                if(data == 'false') {
                  $('#resultajax').html("<div id='toasts-container' class='toasts-container top-auto lg:top-0 bottom-0 lg:bottom-auto right-0 left-0 lg:ltr:left-auto lg:rtl:right-auto'><div class='toast mb-4'><div class='toast-header alert alert_danger'> {{ Lang::get($path.'.error_please_try_again') }}<small class='text-gray-500'></small><button type='button' class='close' data-dismiss='toast'>&times;</button></div></div></div>");
                  $('#myForm input.btn').show();
                  setInterval(refresh, 1000);
                }
                                     
              }

            });
                          
          });

          function refresh() {
            // to current URL
            window.location='{{ URL::current() }}';
          }

</script>