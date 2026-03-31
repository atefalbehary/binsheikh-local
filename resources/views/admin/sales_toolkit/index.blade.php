@extends('admin.template.layout')

@section('header')
    <link href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />
    <style>
        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice {
            background-color: #321fdb;
            color: #fff;
            border: none;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__display {
            color: #fff;
        }

        .select2-container--bootstrap-5 .select2-selection--multiple .select2-selection__choice__remove {
            color: #fff;
        }

        /* File drop zone styles */
        .file-drop-zone {
            border: 2px dashed #ccc;
            border-radius: 10px;
            padding: 30px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #fafbfc;
        }

        .file-drop-zone:hover,
        .file-drop-zone.dragover {
            border-color: #321fdb;
            background: #f0f0ff;
        }

        .file-drop-zone i {
            font-size: 40px;
            color: #aaa;
            margin-bottom: 10px;
        }

        .file-drop-zone.dragover i {
            color: #321fdb;
        }

        .file-drop-zone p {
            margin: 0;
            color: #666;
            font-size: 14px;
        }

        .file-drop-zone .browse-link {
            color: #321fdb;
            text-decoration: underline;
            cursor: pointer;
            font-weight: 600;
        }

        .selected-files-list {
            margin-top: 12px;
            max-height: 200px;
            overflow-y: auto;
        }

        .selected-file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 6px 12px;
            background: #f1f3f5;
            border-radius: 6px;
            margin-bottom: 4px;
            font-size: 13px;
        }

        .selected-file-item .file-name {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .selected-file-item .remove-file {
            color: #e55353;
            cursor: pointer;
            margin-left: 10px;
            font-size: 16px;
        }

        /* Default assignment radio group */
        .default-assign-group {
            margin-top: 12px;
            padding: 12px 16px;
            background: #fff8e1;
            border: 1px solid #ffe082;
            border-radius: 8px;
        }
        .default-assign-group label.group-label {
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }
        .default-assign-group .form-check {
            margin-bottom: 4px;
        }
        .default-assign-group .form-check-label {
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    @if(Session::has('success'))
                        <div class="alert alert-success mt-2 mb-2">{{ Session::get('success') }}</div>
                    @endif
                    @if(Session::has('error'))
                        <div class="alert alert-danger mt-2 mb-2">{{ Session::get('error') }}</div>
                    @endif

                    <div class="card">
                        <div class="card-header">
                            <h4>Upload to Sales Toolkit</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.sales_toolkit.store') }}" method="POST"
                                enctype="multipart/form-data" id="uploadForm">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Select Documents <span class="text-danger">*</span></label>
                                            <div class="file-drop-zone" id="fileDropZone">
                                                <i class="fa fa-cloud-upload-alt"></i>
                                                <p>Drag & drop files here or <span class="browse-link">browse</span></p>
                                                <small class="text-muted">pdf, doc, docx, xls, xlsx, ppt, pptx, zip, images
                                                    — Max 20MB each</small>
                                            </div>
                                            <input type="file" name="documents[]" id="fileInput" multiple
                                                accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.jpg,.jpeg,.png"
                                                style="display: none;">
                                            <div class="selected-files-list" id="selectedFilesList"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Assign To Specific Agents / Agencies</label>
                                            <select name="assigned_to[]" id="assignedTo" class="form-control" multiple>
                                                @foreach($agents_agencies as $user)
                                                    <option value="{{ $user->id }}">
                                                        {{ $user->name }} ({{ $user->email }}) —
                                                        {{ $user->role == 3 ? 'Agent' : 'Agency' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <small class="text-muted">Leave empty to use the default assignment below</small>
                                        </div>

                                        {{-- Default assignment radio buttons (visible when no specific users selected) --}}
                                        <div class="default-assign-group" id="defaultAssignGroup">
                                            <label class="group-label">Send to <span class="text-danger">*</span></label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="default_assign" id="assignBoth" value="all" checked>
                                                <label class="form-check-label" for="assignBoth">All Agents & Agencies</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="default_assign" id="assignAgents" value="all_agents">
                                                <label class="form-check-label" for="assignAgents">All Agents only</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="default_assign" id="assignAgencies" value="all_agencies">
                                                <label class="form-check-label" for="assignAgencies">All Agencies only</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-2" id="uploadBtn" disabled>Upload</button>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h4>Sales Toolkit Documents</h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-responsive-sm table-striped table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>File</th>
                                        <th>Assigned To</th>
                                        <th>Uploaded At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $doc)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $doc->title }}</td>
                                            <td><a href="{{ aws_asset_path($doc->file_path) }}" target="_blank">View File</a></td>
                                            <td>
                                                @php
                                                    $assigned = $doc->assigned_to;
                                                @endphp
                                                @if(is_array($assigned) && in_array('all', $assigned))
                                                    <span class="badge badge-success" style="font-size: 12px;">All Agents & Agencies</span>
                                                @elseif(is_array($assigned) && in_array('all_agents', $assigned))
                                                    <span class="badge badge-primary" style="font-size: 12px;">All Agents</span>
                                                @elseif(is_array($assigned) && in_array('all_agencies', $assigned))
                                                    <span class="badge badge-warning" style="font-size: 12px;">All Agencies</span>
                                                @elseif(is_array($assigned) && count($assigned) > 0)
                                                    @php
                                                        $assignedUsers = \App\Models\User::whereIn('id', $assigned)->get(['name', 'role']);
                                                    @endphp
                                                    @foreach($assignedUsers as $u)
                                                        <span class="badge badge-info mb-1" style="font-size: 11px;">{{ $u->name }}
                                                            ({{ $u->role == 3 ? 'Agent' : 'Agency' }})</span><br>
                                                    @endforeach
                                                @else
                                                    <span class="badge badge-secondary">Unassigned</span>
                                                @endif
                                            </td>
                                            <td>{{ $doc->created_at->format('d M Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.sales_toolkit.destroy', $doc->id) }}"
                                                    class="btn btn-danger btn-sm" data-role="unlink"
                                                    data-message="Are you sure you want to delete this document?">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
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

@section('script')
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();

            // Select2 for agent/agency picker
            $('#assignedTo').select2({
                theme: 'bootstrap-5',
                placeholder: 'Search and select specific agents / agencies...',
                allowClear: true,
                width: '100%'
            });

            // Show/hide the default assignment radio group based on Select2 selection
            function toggleDefaultAssign() {
                var selected = $('#assignedTo').val();
                if (selected && selected.length > 0) {
                    $('#defaultAssignGroup').slideUp(200);
                } else {
                    $('#defaultAssignGroup').slideDown(200);
                }
            }

            $('#assignedTo').on('change', toggleDefaultAssign);
            toggleDefaultAssign(); // initial state

            // ---------- Drag & Drop File Picker ----------
            var fileDropZone = document.getElementById('fileDropZone');
            var fileInput = document.getElementById('fileInput');
            var filesList = document.getElementById('selectedFilesList');
            var uploadBtn = document.getElementById('uploadBtn');
            var collectedFiles = new DataTransfer();

            fileDropZone.addEventListener('click', function() {
                fileInput.click();
            });

            fileDropZone.addEventListener('dragover', function(e) {
                e.preventDefault();
                fileDropZone.classList.add('dragover');
            });

            fileDropZone.addEventListener('dragleave', function() {
                fileDropZone.classList.remove('dragover');
            });

            fileDropZone.addEventListener('drop', function(e) {
                e.preventDefault();
                fileDropZone.classList.remove('dragover');
                addFiles(e.dataTransfer.files);
            });

            fileInput.addEventListener('change', function() {
                addFiles(fileInput.files);
            });

            function addFiles(newFiles) {
                for (var i = 0; i < newFiles.length; i++) {
                    collectedFiles.items.add(newFiles[i]);
                }
                fileInput.files = collectedFiles.files;
                renderFileList();
            }

            function removeFile(index) {
                var dt = new DataTransfer();
                for (var i = 0; i < collectedFiles.files.length; i++) {
                    if (i !== index) {
                        dt.items.add(collectedFiles.files[i]);
                    }
                }
                collectedFiles = dt;
                fileInput.files = collectedFiles.files;
                renderFileList();
            }

            function renderFileList() {
                filesList.innerHTML = '';
                var files = collectedFiles.files;
                uploadBtn.disabled = files.length === 0;

                for (var i = 0; i < files.length; i++) {
                    var div = document.createElement('div');
                    div.className = 'selected-file-item';

                    var sizeMB = (files[i].size / 1024 / 1024).toFixed(2);
                    div.innerHTML = '<span class="file-name"><i class="fa fa-file mr-2"></i>' + files[i].name + ' <small class="text-muted">(' + sizeMB + ' MB)</small></span>' +
                        '<span class="remove-file" data-index="' + i + '">&times;</span>';
                    filesList.appendChild(div);
                }

                // Attach remove handlers
                filesList.querySelectorAll('.remove-file').forEach(function(btn) {
                    btn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        removeFile(parseInt(this.dataset.index));
                    });
                });
            }
        });
    </script>
@endsection