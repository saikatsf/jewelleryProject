<title>Jewellery Admin Sizes</title>
@extends('admin.layout')

@section('content')

<div class="container">
    <div class="rounded h-100 p-4">
        <div class="bg-light rounded p-3 row">
            <div class="h3 col-6">Sizes</div>
            <div class="col-6 text-end">
                <a href="/adminpanel/addsizepage" class="btn btn-success p-2">Add Sizes</a>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover" id="sizes">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Sizes</th>
                        <th scope="col">Edit</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($sizes as $item)
                        
                        <tr class="align-middle"> 
                            <th scope="row">{{ $i++; }}</th>
                            <td class="w-25">{{$item->size}}</td>
                            <td>
                                <a href="/adminpanel/editSize/{{$item->size_id}}" class="btn btn-primary">Edit</a>
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
        $('#sizes').DataTable({
            searching: false
        });
    });
</script>
@endsection

