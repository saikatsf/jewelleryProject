@extends('layout')

@section('content')
    <div class="container h2 p-3 text-center">
        Forgot Password
    </div>

    <div class="row justify-content-evenly p-3">

        <div class="col-6 col-md-4">

            <form method="post" action="/forgotpasswordchange">

                @csrf

                @if(isset($forgotpasswordmessage))
                    <p class="alert alert-info mt-1">{{ $forgotpasswordmessage }}</p>
                @endif

                
                <input type="hidden" value="{{$useremail}}" name="user_email">
                

                <div class="form-group m-1">
                    <label for="pass1">New Password:</label>
                    <input type="password" class="form-control" name="password">
                    @error('password')
                        <p class="alert alert-succeess mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div class="form-group m-1">
                    <label for="pass2">Confirm New Password:</label>
                    <input type="password" class="form-control" name="password_confirmation">
                    @error('password_confirmation')
                        <p class="alert alert-succeess mt-1">{{$message}}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn btn-default m-2">Change</button>
                </div>
              </form>
        </div>
        
    </div>
@endsection