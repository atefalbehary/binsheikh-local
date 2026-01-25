@extends('admin.template.layout')

@section('header')

@stop


@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Videos</div>
                        <div class="card-body">
                            <button class="btn btn-primary mb-3" onclick="location.href='{{ url('admin/videos/create') }}'"><i
                                    class="fas fa-plus"></i>
                                Create Video</button>
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
                                        <th>Video</th>
                                        <th>Folder</th>
                                        <th>Is Active</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $list->perPage() * ($list->currentPage() - 1);?>
                                    @foreach ($list as $item)
                                        <?php
                                            $i++;
                                            $checked = $item->active ? 'checked' : '';
                                        ?>
                                        <tr role="row">
                                            <td><input type="checkbox" class="box1" value="{{ $item->id }}"></td>
                                            <td class="trVOE">{{ $i }}</td>
                                            <td class="trVOE">
                                                <?php if (!empty($item->link)) {?>
                                                    <iframe width="200" heightt="315" src="{{$item->link}}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                                <?php }?>
                                            </td>
                                            <td class="trVOE">{{$item->folder->title ?? ''}}</td>
                                            <td>

                                                <input class="toggle_status"
                                                    data-url="{{ url('admin/videos/change_status') }}" type="checkbox"
                                                    {{ $checked }} data-id="{{ $item->id }}" data-toggle="toggle"
                                                    data-on="Yes" data-off="No" data-onstyle="success"
                                                    data-offstyle="danger">

                                            </td>


                                            <td class="trVOE">
                                                {{ web_date_in_timezone($item->created_at, 'd-M-Y h:i A') }}</td>

                                            <td>
                                                <a href="{{ url('admin/videos/delete/' . $item->id) }}"
                                                    class="btn btn-outline-danger active deleteListItem" data-role="unlink"
                                                    data-message="Do you want to remove this photo?" title="Delete"
                                                    aria-hidden="true"><i class="fas fa-trash-alt fa-1x"></i></a>
                                            </td>


                                        </tr>
                                    @endforeach
                                </tbody>

                            </table>
                            <div class="col-sm-12 col-md-12 pull-right">
                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                    {!! $list->links('admin.template.pagination') !!}
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
                    form.action = '{{ route("admin.videos.deleteAll") }}';

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
