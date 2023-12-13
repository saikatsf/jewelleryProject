<title>Jewellery Admin Edit Color</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Edit Color</h6>
            <form class="w-50" method="POST" action="/adminpanel/editColor">
                @csrf
                <input type="hidden" name="color_id" value="{{$color->color_id}}">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Color" name="color" value="{{$color->color}}">
                    <label for="floatingInput">Color</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
@endsection

