@if(session()->has('success') || session()->has('error') || session()->has('info'))
    <script type="text/javascript">
        $(document).ready(function() {
            @if(session()->has('success'))
                toastr.success("{!! session('success') !!}", "Succès");
            @elseif(session()->has('error')) 
   		        toastr.error("{!! session('error') !!}", "Erreur");		   
   		    @elseif(session()->has('info')) 
   		        toastr.info("{!! session('info') !!}", "Information");		 
	        @endif
        });
    </script>
@endif
