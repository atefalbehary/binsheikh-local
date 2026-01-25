@extends('admin.template.layout')

@section('header')
@stop

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><i class="fa fa-align-justify"></i> Popups</div>
                        <div class="card-body">
                            <button class="btn btn-primary mb-3" onclick="location.href='{{ url('admin/popups/create') }}'"><i
                                    class="fas fa-plus"></i>
                                Create Popup</button>

                            <table class="table table-responsive-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Subtitle</th>
                                        <th>Link</th>
                                        <th>Button Text</th>
                                        <th>Is Active</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $i = 0; @endphp
                                    @foreach ($popups as $popup)
                                        @php
                                            $i++;
                                            $checked = $popup->is_active ? 'checked' : '';
                                        @endphp
                                        <tr role="row">
                                            <td>{{ $i }}</td>
                                            <td>
                                                @if(!empty($popup->image))
                                                    <img src="{{aws_asset_path($popup->image) }}"
                                                         width="100">
                                                @endif
                                            </td>
                                            <td>{{ $popup->title }}</td>
                                            <td>{{ $popup->subtitle }}</td>
                                            <td>{{ $popup->link }}</td>
                                            <td>{{ $popup->button_text }}</td>
                                            <td>
                                                <input class="toggle_status"
                                                    data-url="{{ url('admin/popups/change_status') }}" type="checkbox"
                                                    {{ $checked }} data-id="{{ $popup->id }}" data-toggle="toggle"
                                                    data-on="Yes" data-off="No" data-onstyle="success"
                                                    data-offstyle="danger">
                                            </td>
                                            <td>
                                                {{ web_date_in_timezone($popup->created_at, 'd-M-Y h:i A') }}
                                            </td>
                                            <td>
                                                <a class="btn btn-outline-info active" title="Edit"
                                                    href="{{ url('admin/popups/' . $popup->id . '/edit') }}"
                                                    aria-hidden="true"><i class="fas fa-edit fa-1x"></i></a>
                                                &nbsp;
                                                <form action="{{ url('admin/popups/' . $popup->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger active deleteListItem"
                                                        data-message="Do you want to remove this popup?" title="Delete"
                                                        aria-hidden="true"><i class="fas fa-trash-alt fa-1x"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
@stop
