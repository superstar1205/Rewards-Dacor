
@extends('layouts.app')

@section('content')
<div class="fwelcome">
    <div class="w_main">
        <div class="btn_box">
            <form method="POST" action="{{ route('ellogin') }}" class="btn_en">
            @csrf
                <button class="fbtn">English</button>   
            </form>
            <form method="POST" action="{{ route('fllogin') }}" class="btn_fr">
            @csrf
                <button class="fbtn">français</button>
            </form>
        </div>
        <div class="bgimg"><img class="imaggg" src="/img/bgw.png"></div>
    </div>
</div>
@endsection