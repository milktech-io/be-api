@extends('layout.template')
@section('content')

<div style="text-align: center;">
    <img src="{{url('user-phone.png')}}" alt=""/>
    <p>{{$message}}</p>
     <a  href="{{$url}}" class="btn-cool">
        {{$btn_text}}
    </a>
</div>

<script>

document.addEventListener("DOMContentLoaded", function(event) {
    setTimeout(()=>{
        window.location.href = {{$url}};
    }, 1000)
});

</script>

@endsection
