
@extends('layout')

@section('content')
    <div class="container-fluid">
        <div class="row h-100 align-items-center justify-content-center">
            <div class="col-12 col-sm-8 col-md-8 col-lg-6">
                <div class="bg-light rounded p-4 p-sm-5 my-4 mx-3">
                    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h3>Review & Ratings</h3>
                    </div>
                    <form action="/reviewsubmit" method="post" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="order_detail_id" value="{{$order_detail_id}}">
                        <div class="form-floating mb-3">
                            <textarea class="form-control" placeholder="Write Your Review" id="floatingTextarea"
                            style="height: 80px;" name="review" required></textarea>
                            <label for="floatingInput">Write Your Review</label>
                        </div>

                        <div>Give Your Rating</div>

                        <div class="rating">

                          <label>
                            <input type="radio" name="rating" value="1" required/>
                            <span class="icon">★</span>
                          </label>

                          <label>
                            <input type="radio" name="rating" value="2" />
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                          </label>

                          <label>
                            <input type="radio" name="rating" value="3" />
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>   
                          </label>

                          <label>
                            <input type="radio" name="rating" value="4" />
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                          </label>

                          <label>
                            <input type="radio" name="rating" value="5" />
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                            <span class="icon">★</span>
                          </label>

                        </div>

                        <div class="mb-3">
                            <label for="formFile" class="form-label">Upload Image</label>
                            <div class="mb-2 gallery">
                                
                            </div>
                            <input class="form-control gallery-photo-add" type="file" id="formFile" name="review_image[]" multiple>
                        </div>

                        <button type="submit" class="btn btn-default py-1 w-50 mb-4">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <style>
        .rating {
            display: inline-block;
            position: relative;
            height: 50px;
            line-height: 50px;
            font-size: 30px;
        }

        .rating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            cursor: pointer;
        }

        .rating label:last-child {
            position: static;
        }

        .rating label:nth-child(1) {
            z-index: 5;
        }

        .rating label:nth-child(2) {
            z-index: 4;
        }

        .rating label:nth-child(3) {
            z-index: 3;
        }

        .rating label:nth-child(4) {
            z-index: 2;
        }

        .rating label:nth-child(5) {
            z-index: 1;
        }

        .rating label input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .rating label .icon {
            float: left;
            color: transparent;
        }

        .rating label:last-child .icon {
            color: #000;
        }

        .rating:not(:hover) label input:checked ~ .icon,
        .rating:hover label:hover input ~ .icon {
            color: #daa520;
        }

        .rating label input:focus:not(:checked) ~ .icon:last-child {
            color: #000;
            text-shadow: 0 0 5px #daa520;
        }
        img{
            max-width:100px;
        }
    </style>

    <script>
        $(':radio').change(function() {
            console.log('New star rating: ' + this.value);
        });
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
    </script>
@endsection