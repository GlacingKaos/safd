@extends('safd.template.main')

@section('title','Alumno')

@section('name')
    Instituto Tecnologico de Morelia
@endsection

@section('content')
    <div class="container">
        
    </div>
@endsection

@section('script')
<script type="text/javascript">
var token = "{{csrf_token()}}";
$(document).ready(function(){
    
});
</script>
@endsection