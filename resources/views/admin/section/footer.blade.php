</div>
<script src="{{ asset('js/manifest.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/vendor.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/admin.js') }}" type="text/javascript"></script>
{{-- <script src="//{{ Request::getHost() }}:{{env('LARAVEL_ECHO_PORT')}}/socket.io/socket.io.js"></script> --}}
@if(app()->env == 'local')
 <script>
     var  socketHost = 'https://shreevahan.com.np'
 </script>
 @else 
 <script>
     var socketHost = window.location.hostname;
 </script>
 @endif 
@stack('scripts')
</body>
</html>