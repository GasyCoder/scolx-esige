@if(Session::has('error'))
        <!-- Toasts -->
        <div id="toasts-container"
            class="toasts-container top-auto lg:top-0 bottom-0 lg:bottom-auto right-0 left-0 lg:ltr:left-auto lg:rtl:right-auto">
            <div class="toast mb-4">
                <div class="toast-header alert alert_danger">
                     {{ Session::get('error') }}
                    <small class="text-gray-500"></small>
                    <button type="button" class="close" data-dismiss="toast">&times;</button>
                </div>
            </div>
        </div>
@endif    
@if(Session::has('success'))
        <!-- Toasts -->
        <div id="toasts-container"
            class="toasts-container top-auto lg:top-0 bottom-0 lg:bottom-auto right-0 left-0 lg:ltr:left-auto lg:rtl:right-auto">
            <div class="toast mb-4">
                <div class="toast-header alert alert_success">
                     {{ Session::get('success') }}
                    <small class="text-gray-500"></small>
                    <button type="button" class="close" data-dismiss="toast">&times;</button>
                </div>
            </div>
        </div>
@endif