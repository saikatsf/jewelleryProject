@extends('layout')

@section('content')
    <div class="container h2 p-3 text-center">
        Forgot Password
    </div>

    <div class="row justify-content-evenly p-3">

        <div class="col-6 col-md-4">

            <form method="post" action="/forgotpasswordotp">
                @csrf

                @if(session()->get('forgotmessage'))
                    <p class="alert alert-danger mt-1">{{ session()->get('forgotmessage') }}</p>
                @endif
                
                <div class="form-group m-1">
                    <label for="email">Enter Your Email :</label>
                    <input type="text" class="form-control" name="user_email_forgot">
                    @error('user_email_forgot')
                        <p class="alert alert-danger mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-default m-2">Send OTP</button>
                </div>
            </form>
        </div>
        
    </div>
@endsection