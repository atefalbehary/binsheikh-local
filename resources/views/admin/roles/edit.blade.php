@extends('admin.template.layout')

@section('header')
<style>
    .permission-group {
        margin-bottom: 20px;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 5px;
    }
    .permission-header {
        font-weight: bold;
        margin-bottom: 10px;
        text-transform: capitalize;
        border-bottom: 1px solid #eee;
        padding-bottom: 5px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <span class="font-weight-bold">Edit Role: {{ $role->name }}</span>
                    </div>
                    <div class="card-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label>Role Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $role->name) }}" required {{ $role->name == 'Super Admin' ? 'readonly' : '' }}>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control">{{ old('description', $role->description) }}</textarea>
                            </div>

                            <hr>
                            <h4>Permissions</h4>
                            <div class="row">
                                @foreach($permissions as $module => $modulePermissions)
                                <div class="col-md-6">
                                    <div class="permission-group">
                                        <div class="permission-header">
                                            {{ ucfirst($module) }} Module
                                            <div class="float-right">
                                                <input type="checkbox" class="select-all-module" data-module="{{ $module }}"> <small>Select All</small>
                                            </div>
                                        </div>
                                        @foreach($modulePermissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox module-{{ $module }}" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="perm_{{ $permission->id }}" {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                {{ str_replace('_', ' ', $permission->name) }}
                                            </label>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Update Role</button>
                            <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary mt-3">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        $('.select-all-module').change(function() {
            var module = $(this).data('module');
            $('.module-' + module).prop('checked', $(this).prop('checked'));
        });
    });
</script>
@endsection
