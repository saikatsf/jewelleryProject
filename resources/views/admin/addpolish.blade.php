<title>Jewellery Admin Add Polish</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Add New Polish</h6>
            <form class="w-75" method="POST" action="/adminpanel/addPolish">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Polish Name" name="polish">
                    <label for="floatingInput">Polish</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection

