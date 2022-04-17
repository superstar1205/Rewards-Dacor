@extends('layouts.app')

@section('content')
<div class="row" style="margin-left: 0px; margin-right:0px;">
    <div class="col-lg-6 d-flex justify-content-center align-items-center py-5"  style="margin-left: 0px; margin-right:0px;">
        <form class="row justify-content-center align-items-center" method="POST" action="{{ route('home') }}">
            @csrf
            <div class="row justify-content-center align-items-center">
                <div class="col-10 col-sm-9 col-md-8 col-lg-7">
                    <p class="f4">Please login with your Member ID and Password provided in your welcome email.</p>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-10 col-sm-9 col-md-8 col-lg-7">
                    <div class="fm-group">
                        <label class="fm-label text-start" for="memberid">Member ID</label>
                        <input id="memberid" type="text" class="fm-input @error('memberid') is-invalid @enderror" placeholder="Member ID" name="memberid" value="{{ old('memberid') }}" required autocomplete="memberid" autofocus>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <div class="col-10 col-sm-9 col-md-8 col-lg-7">
                    <div class="fm-group">
                        <label class="fm-label text-start" for="password">Password</label>
                        <input id="password" type="password" class="fm-input @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <button type="submit" class="col-10 col-sm-9 col-md-8 col-lg-7 btn btn-secondary" style="font-size: 24px;">log in</button>
            </div>
        </form>
    </div>
    <div class="col-lg-6"  style="margin-left: 0px; margin-right:0px;">
        <img style="width: 100%; height: 100vh" src="{{ asset('img/background.jpg') }}">
    </div>
</div>
@endsection
