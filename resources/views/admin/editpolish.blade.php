<title>Jewellery Admin Edit Polish</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Edit Polish</h6>
            <form class="w-50" method="POST" action="/adminpanel/editPolish">
                @csrf
                <input type="hidden" name="polish_id" value="{{$polish->polish_id}}">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Polish" name="polish" value="{{$polish->polish}}">
                    <label for="floatingInput">Polish</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
@endsection

