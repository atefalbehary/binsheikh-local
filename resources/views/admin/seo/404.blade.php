@extends('admin.template.layout')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            404 Monitor
                        </div>
                        <div class="card-body">
                            <table class="table table-striped datatable">
                                <thead>
                                    <tr>
                                        <th>URL</th>
                                        <th>Hits</th>
                                        <th>Last Hit At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>{{ $log->url }}</td>
                                            <td>{{ $log->hits }}</td>
                                            <td>{{ $log->last_hit_at }}</td>
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