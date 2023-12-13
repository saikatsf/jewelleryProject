@extends('layout')

@section('content')
    <div class="container h2 p-3 text-center">
        Forgot Password
    </div>

    <div class="row justify-content-evenly p-3">

        <div class="col-6 col-md-4">

            <form method="post" action="/forgotpasswordotpverify">

                @csrf

                @if(isset($forgototpmessage))
                    <p class="alert alert-info mt-1">{{ $forgototpmessage }}</p>
                @endif

                
                <input type="hidden" value="{{$verifyemail}}" name="user_email_forgot">
                

                <div class="form-group m-1">
                    <label for="email">Enter Your OTP :</label>
                    <input type="text" class="form-control" name="user_otp_forgot">
                    @error('user_otp_forgot')
                        <p class="alert alert-succeess mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-default m-2">Verify</button>
                </div>
              </form>
        </div>
        
    </div>
@endsection