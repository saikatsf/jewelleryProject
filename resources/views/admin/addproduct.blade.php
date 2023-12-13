<title>Jewellery Admin Add Product</title>
@extends('admin.layout')

@section('content')

    <div class="container">
        <div class="row bg-light rounded mt-3 p-4">
            <h6 class="mb-4">Add New Product</h6>
            <form class="col-12 col-lg-9" method="POST" action="/adminpanel/addProduct" enctype="multipart/form-data">
                @csrf

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Product Name" name="product_name" required>
                    <label for="floatingInput">Product Name</label>
                </div>

                <div class="mb-3">
                    <label for="formFile" class="form-label fw-bold">Image</label>
                    <div class="mb-2 gallery">
                        
                    </div>
                    <input class="form-control gallery-photo-add" type="file" id="formFile" name="product_image[]" multiple required>
                </div>


                <div class="form-floating mb-3">
                    <select class="form-select" id="floatingSelect"
                        aria-label="Floating label select example" name="product_category" required>
                        @foreach ($categories as $item)
                            <option value="{{ $item->category_id }}">{{ $item->category_name }}</option>
                        @endforeach
                            
                    </select>
                    <label for="floatingSelect">Category</label>
                </div>

                <div class="form-floating mb-3">
                    <textarea class="form-control" placeholder="Enter Product Description"
                        id="floatingTextarea" style="height: 150px;" name="description"></textarea>
                    <label for="floatingTextarea">Description</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Price" name="price" required>
                    <label for="floatingInput">Price</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Discount" name="discount" required>
                    <label for="floatingInput">Discount</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Delivery Days Min" name="del_days_min" required>
                    <label for="floatingInput">Delivery Days Min</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="text" class="form-control" id="floatingInput" placeholder="Enter Delivery Days Max" name="del_days_max" required>
                    <label for="floatingInput">Delivery Days Max</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <label class="form-check-label" for="flexSwitchCheckDefault">Delivery Charges</label>
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" name="del_charges">
                </div>

                
                <div class="mb-3">
                    <label class="form-label fw-bold">Collections</label>
                    @foreach ($collections as $item)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $item->collection_id }}" id="flexCheckDefault" name="collection[]">
                            <label class="form-check-label" for="flexCheckDefault">
                                {{ $item->collection }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="mb-3" id="productTypes">
                    <label for="exampleInputEmail1" class="form-label fw-bold">Product Types</label>
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

