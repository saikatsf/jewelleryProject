<title>Jewellery Admin Colors</title>
@extends('admin.layout')

@section('content')

<div class="container">
    <div class="rounded h-100 p-4">
        <div class="bg-light rounded p-3 row">
            <div class="h3 col-6">Colors</div>
            <div class="col-6 text-end">
                <a href="/adminpanel/addcolorpage" class="btn btn-success p-2">Add Colors</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="colors">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Color</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($colors as $item)
                        
                        <tr class="align-middle"> 
                            <th scope="row">{{ $i++; }}</th>
                            <td class="w-25">{{$item->color}}</td>
                            <td>
                                <div class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Action</a>
                                    <div class="dropdown-menu">
                                        <a href="/adminpanel/editColor/{{$item->color_id}}" class="dropdown-item">Edit</a>
                                        <a href="/adminpanel/deleteColor/{{$item->color_id}}" class="dropdown-item">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#colors').DataTable({
            searching: false
        });
    });
</script>
@endsection

