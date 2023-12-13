@extends('layout')

@section('content')
<div class="content">
    
    <div class="row justify-content-center py-5">

        <div class="col-6">
            <div class="text-center h4 pb-3">CONTACT US</div>

                <form class="mb-5" method="post" action="/contactformsubmit">
					@csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput"
                            placeholder="Name" name="user_name" required>
                        <label for="floatingInput">Name</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="floatingInput1"
                            placeholder="name@example.com" name="user_email" required>
                        <label for="floatingInput1">Email Address</label>
                    </div>
                    
                    <div class="form-floating mb-3">
                        <textarea class="form-control" placeholder="Leave a comment here"
                            id="floatingTextarea" style="height: 150px;" name="user_message" required></textarea>
                        <label for="floatingTextarea">Your Message</label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-default">Submit</button>
                    </div>
                </form>

        </div>

    </div>
</div>       
@endsection