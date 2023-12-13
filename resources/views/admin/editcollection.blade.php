<title>Jewellery Admin Edit Collection</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Edit Collection</h6>
            <form class="w-50" method="POST" action="/adminpanel/editCollection">
                @csrf
                <input type="hidden" name="collection_id" value="{{$collection->collection_id}}">
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Collection" name="collection" value="{{$collection->collection}}">
                    <label for="floatingInput">Collection</label>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    
@endsection

