<title>Jewellery Admin Edit Product</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Edit Product</h6>
            <form class="w-50" method="POST" action="/adminpanel/editProduct" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_id" value="{{$product->product_id}}">

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Product Name" name="product_name" value="{{$product->product_name}}">
                    <label for="floatingInput">Product Name</label>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label fw-bold">Images</label>
                    <div class="my-1 row">
                        @foreach ($product->image as $item)
                            @if ($item->delete_flag == 0)
                                <div class="col-6 col-lg-4 gx-5">
                                    <img src="{{ URL::asset('imageUploads/'.$item->product_img) }}" alt="your image">
                                    <a href="/removeproductimage/{{$item->product_img_id}}" class="btn btn-danger m-2"><i class="fas fa-times me-2"></i> Remove</a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="mb-2 gallery">
                        
                    </div>
                    <input class="form-control gallery-photo-add" type="file" id="formFile" name="product_image[]" multiple>
                
                </div>

                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect"
                        aria-label="Floating label select example" name="product_category">
                        @foreach ($categories as $item)
                            @if ($product->category_id == $item->category_id)
                                <option value="{{ $item->category_id }}" selected>{{ $item->category_name }}</option>
                            @else
                                <option value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                            @endif
                        @endforeach
                            
                    </select>
                    <label for="floatingSelect">Category</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Enter Product Description"
                        id="floatingTextarea" style="height: 150px;" name="description">{{$product->description}}</textarea>
                    <label for="floatingInput">Product Description</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Product Price" name="price" value="{{$product->price}}">
                    <label for="floatingInput">Price</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Product Discount" name="discount" value="{{$product->discount}}">
                    <label for="floatingInput">Discount</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Delivery Days Min" name="del_days_min" value="{{$product->del_days_min}}">
                    <label for="floatingInput">Delivery Days Min</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Delivery Days Max" name="del_days_max" value="{{$product->del_days_max}}">
                    <label for="floatingInput">Delivery Days Max</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Delivery Charges</label>
                    @if ($product->delivery_charges == 1)
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="del_charges" checked>
                    @else
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="del_charges">
                    @endif
                </div>

               
                <div class="mb-3">
                    <label class="form-label fw-bold">Collections</label>
                    @foreach ($collections as $item)

                            <div class="form-check">
                                @if ($product->collections->contains('collection_id',$item->collection_id))
                                    <input class="form-check-input" type="checkbox" value="{{ $item->collection_id }}" id="flexCheckDefault" name="collection[]" checked>
                                @else
                                    <input class="form-check-input" type="checkbox" value="{{ $item->collection_id }}" id="flexCheckDefault" name="collection[]">
                                @endif
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{ $item->collection }}
                                </label>
                            </div>

                    @endforeach
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label fw-bold">Product Types</label>
                    <div class="row text-center py-2">
                        <div class="col">Product Color</div>
                        <div class="col">Product Polish</div>
                        <div class="col">Product Size</div>
                        <div class="col">Quantity</div>
                        <div class="col"></div>
                    </div>
                    @foreach ($product->types as $item)
                            @if ($item->delete_flag == 0)
                                <div class="row">
                                    <div class="col gy-1">
                                        <input class="form-control mb-3" type="text" value="{{ $item->getcolor->color }}" readonly>
                                    </div>
                                    <div class="col gy-1">
                                        <input class="form-control mb-3" type="text" value="{{ $item->getpolish->polish }}" readonly>
                                    </div>
                                    <div class="col gy-1">
                                        @if ($item->product_size == 0)
                                        <input class="form-control mb-3" type="text" value="NA" readonly>
                                        @else
                                            <input class="form-control mb-3" type="text" value="{{ $item->getsize->size }}" readonly>
                                        @endif
                                    </div>
                                    <div class="col gy-1">
                                        <input class="form-control mb-3" type="text" value="{{ $item->quantity }}" readonly>
                                    </div>
                                    <div class="col gy-1">
                                        <a href="/removeproducttype/{{$item->product_type_id}}" class="btn btn-danger"><i class="fas fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            @endif
                    @endforeach
                </div>

                <div class="mb-3" id="productTypes">
                    <div class="row text-center fw-bold py-2">
                        <div class="col">Select Color</div>
                        <div class="col">Select Polish</div>
                        <div class="col">Select Size</div>
                        <div class="col">Enter Quantity</div>
                        <div class="col"></div>
                    </div>
                    <div class="row" id="row_1">
                        <div class="col">
                            <select class="form-select form-select mb-3" name="color[]">
                                @foreach ($colors as $item)
                                    <option value="{{ $item->color_id }}">{{ $item->color }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select form-select mb-3" name="polish[]">
                                @foreach ($polishes as $item)
                                    <option value="{{ $item->polish_id }}">{{ $item->polish }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <select class="form-select form-select mb-3" name="size[]">
                                <option value="0">NA</option>
                                @foreach ($sizes as $item)
                                    <option value="{{ $item->size_id }}">{{ $item->size }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                                <input class="form-control mb-3" type="text" placeholder="Enter Quantity" name="quantity[]" value="0">
                        </div>
                        <div class="col">
                            <button type="button" class="btn btn-success mb-3" id="addrows">Add New</button>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
    <style>
        img{
            max-width:150px;
        }
        input[type=file]{
            padding:10px;
            background:#2d2d2d;
        }
    </style>

    <script>
        $(function() {
            // Multiple images preview in browser
            var imagesPreview = function(input, placeToInsertImagePreview) {

                if (input.files) {
                    var filesAmount = input.files.length;

                    for (i = 0; i < filesAmount; i++) {
                        var reader = new FileReader();

                        reader.onload = function(event) {
                            $($.parseHTML('<img>')).attr('src', event.target.result).attr('class','mx-1').appendTo(placeToInsertImagePreview);
                        }

                        reader.readAsDataURL(input.files[i]);
                    }
                }

            };

            $('.gallery-photo-add').on('change', function() {
                $('div.gallery').empty();
                imagesPreview(this, 'div.gallery');
            });
        });
        $(document).ready(function(){
            var r = 1;
            $("#addrows").click(function(){
                r++;
                var extrarow = '<div class="row" id="row_'+r+'"> <div class="col"> <select class="form-select form-select mb-3" name="color[]"> @foreach ($colors as $item) <option value="{{ $item->color_id }}">{{ $item->color }}</option> @endforeach </select> </div> <div class="col"> <select class="form-select form-select mb-3" name="polish[]"> @foreach ($polishes as $item) <option value="{{ $item->polish_id }}">{{ $item->polish }}</option> @endforeach </select> </div> <div class="col"> <select class="form-select form-select mb-3" name="size[]"> <option value="0">NA</option> @foreach ($sizes as $item) <option value="{{ $item->size_id }}">{{ $item->size }}</option> @endforeach </select> </div> <div class="col"> <input class="form-control mb-3" type="text" placeholder="Enter Quantity" name="quantity[]" value="0"> </div> <div class="col"> <button type="button" class="btn btn-danger mb-3" onclick="removerows('+r+')">Remove</button> </div> </div>';
                $("#productTypes").append(extrarow);

            });
        });
        function removerows(r) {
            $('#row_'+r).remove();
        }

    </script>
@endsection

