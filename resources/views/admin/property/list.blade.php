@extends('admin.template.layout')

@section('header')

@stop

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Property List</div>
                        <div class="card-body">
                            <form action="" method="get">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Name/Unit Number</label>
                                            <input class="form-control filter_1" name="search_text" value="{{$search_text}}">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Sale Type</label>
                                            <select name="sale_type" class="form-control select2"
                                                data-parsley-required-message="Select Sale Type">
                                                <option  value="">All</option>
                                                <option <?= ($sale_type == 1) ? 'selected' : '' ?>  value="1">Buy</option>
                                                <option <?= ($sale_type == 2) ? 'selected' : '' ?>  value="2">Rent</option>
                                                <option <?= ($sale_type == 3) ? 'selected' : '' ?>  value="3">Buy & Rent</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label class="form-label">Project</label>
                                            <select name="project_id" class="form-control select2"
                                                data-parsley-required-message="Select Project">
                                                <option  value="">All</option>
                                                @foreach($projects as $val)
                                                <option <?= ($project_id == $val->id) ? 'selected' : '' ?> value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-md-3" style="margin-top: 1.8rem !important;">
                                        <button class="btn btn-primary" type="submit">Filter</button>
                                            <a href="{{ url('admin/properties') }}" class="btn btn-success dt_tables_filter_button" data-tid="dt-tbl"
                                            type="button">Reset</a>
                                    </div>
                                </div>
                            </form>
                            <button class="btn btn-primary mb-3"
                                onclick="location.href='{{ url('admin/property/create') }}'"><i class="fas fa-plus"></i>
                                Create Property</button>
                            <div class="float-right col-md-3  mb-2" >
                                <button id="deleteSelected" class="btn btn-danger ">Delete Selected</button>
                            </div>
                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th><input  type="checkbox" class="" id="selectAll"
                                                    onclick="toggleAll(this)">
                                        </th>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Unit Number</th>
                                        <th>Project</th>
                                        <th>Sale Type</th>
                                        <th>Is Active</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $properties->perPage() * ($properties->currentPage() - 1); ?>
                                    @foreach ($properties as $property)
                                        <?php
                                        $i++;
                                        $checked = $property->active ? 'checked' : '';
                                        ?>
                                        <tr role="row">
                                            <td><input type="checkbox" class="box1" value="{{ $property->id }}"></td>
                                            <td class="trVOE">{{ $i }}</td>
                                            <td class="trVOE">{{ $property->name }}</td>
                                            <td class="trVOE">{{ $property->apartment_no }}</td>
                                            <td class="trVOE">{{ $property->project->name??'' }}</td>
                                            <td class="trVOE">
                                                @if($property->sale_type==1)
                                                    Buy
                                                @elseif($property->sale_type==2)
                                                    Rent
                                                @else
                                                    Buy & Rent
                                                @endif
                                            </td>

                                            <td>
                                                <input class="toggle_status"
                                                    data-url="{{ url('admin/property/change_status') }}" type="checkbox"
                                                    {{ $checked }} data-id="{{ $property->id }}" data-toggle="toggle"
                                                    data-on="Yes" data-off="No" data-onstyle="success"
                                                    data-offstyle="danger">

                                            </td>


                                            <td class="trVOE">
                                                {{ web_date_in_timezone($property->created_at, 'd-M-Y h:i A') }}</td>

                                            <td>
                                                <a class="btn btn-outline-info active" title="Edit"
                                                    href="{{ url('admin/property/edit/' . $property->id) }}"
                                                    aria-hidden="true"><i class="fas fa-edit fa-1x"></i></a>
                                                &nbsp;
                                                <a href="{{ url('admin/property/delete/' . $property->id) }}"
                                                    class="btn btn-outline-danger active deleteListItem" data-role="unlink"
                                                    data-message="Do you want to remove this property?" title="Delete"
                                                    aria-hidden="true"><i class="fas fa-trash-alt fa-1x"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-sm-12 col-md-12 pull-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {!! $properties->appends(request()->input())->links('admin.template.pagination') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
<script>
    $(".select2").select2();
</script>
<script>
    function toggleAll(source) {
        document.querySelectorAll('.box1').forEach(checkbox => checkbox.checked = source.checked);
    }


    // Delete Selected Handler
    document.getElementById('deleteSelected').addEventListener('click', function () {
        let selected = [];
        document.querySelectorAll('.box1:checked').forEach(cb => {
            selected.push(cb.value);
        });

        if (selected.length === 0) {
            Swal.fire('No Selection', 'Please select at least one record to delete.', 'warning');
            return;
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "Selected applications will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!'
        }).then((result) => {
            if (result.value) {
                console.log("dd");
                // Send the request via AJAX or create a form
                let form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("admin.properties.deleteAll") }}';

                // Add CSRF token
                let csrf = document.createElement('input');
                csrf.type = 'hidden';
                csrf.name = '_token';
                csrf.value = '{{ csrf_token() }}';
                form.appendChild(csrf);

                // Add _method for DELETE
                let method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                form.appendChild(method);

                // Add selected IDs
                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_all_id';
                input.value = selected.join(',');
                form.appendChild(input);

                document.body.appendChild(form);
                form.submit();
            }
        });
    });
</script>
@stop
