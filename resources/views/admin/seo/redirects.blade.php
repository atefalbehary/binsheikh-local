@extends('admin.template.layout')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Manage Redirects
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('admin.seo_redirect_store') }}" method="POST" class="mb-4">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="text" name="old_url" class="form-control"
                                            placeholder="Old URL (e.g. /old-page)" required>
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" name="new_url" class="form-control"
                                            placeholder="New URL (e.g. /new-page)" required>
                                    </div>
                                    <div class="col-md-2">
                                        <select name="status_code" class="form-control">
                                            <option value="301">301 (Permanent)</option>
                                            <option value="302">302 (Temporary)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-success btn-block">Add Redirect</button>
                                    </div>
                                </div>
                            </form>

                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Old URL</th>
                                        <th>New URL</th>
                                        <th>Status Code</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($redirects as $redirect)
                                        <tr>
                                            <td>{{ $redirect->old_url }}</td>
                                            <td>{{ $redirect->new_url }}</td>
                                            <td><span class="badge badge-info">{{ $redirect->status_code }}</span></td>
                                            <td>
                                                <a href="{{ route('admin.seo_redirect_delete', $redirect->id) }}"
                                                    class="btn btn-danger btn-sm" data-role="unlink">Delete</a>
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
@endsection