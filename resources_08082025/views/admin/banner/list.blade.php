@extends('admin.template.layout')

@section('header')

@stop


@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Banners</div>
                        <div class="card-body">
                            <button class="btn btn-primary mb-3" onclick="location.href='{{ url('admin/banner/create') }}'"><i
                                    class="fas fa-plus"></i>
                                Create Banner</button>

                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Banner</th>
                                        <th>Is Active</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = $list->perPage() * ($list->currentPage() - 1); ?>
                                    @foreach ($list as $item)
                                        <?php
                                        $i++;
                                        $checked = $item->active ? 'checked' : '';
                                        ?>
                                        <tr role="row">
                                            <td class="trVOE">{{ $i }}</td>
                                            <td class="trVOE">
                                                <?php if(!empty($item->banner_image)) { ?>
                                                <img src="{{aws_asset_path($item->banner_image) }}"
                                                    width="100"><?php } ?>
                                            </td>

                                            <td>

                                                <input class="toggle_status"
                                                    data-url="{{ url('admin/banner/change_status') }}" type="checkbox"
                                                    {{ $checked }} data-id="{{ $item->id }}" data-toggle="toggle"
                                                    data-on="Yes" data-off="No" data-onstyle="success"
                                                    data-offstyle="danger">

                                            </td>


                                            <td class="trVOE">
                                                {{ web_date_in_timezone($item->created_at, 'd-M-Y h:i A') }}</td>

                                            <td>
                                                <a class="btn btn-outline-info active" title="Edit"
                                                    href="{{ url('admin/banner/edit/' . $item->id) }}"
                                                    aria-hidden="true"><i class="fas fa-edit fa-1x"></i></a>
                                                &nbsp;
                                                <a href="{{ url('admin/banner/delete/' . $item->id) }}"
                                                    class="btn btn-outline-danger active deleteListItem" data-role="unlink"
                                                    data-message="Do you want to remove this banner?" title="Delete"
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

@stop
