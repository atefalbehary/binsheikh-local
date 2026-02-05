@extends('admin.template.layout')

@section('header')
<style>
    .document-btn {
        padding: 5px 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        background: #f8f9fa;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        color: #333;
    }
    .document-btn:hover {
        background: #e9ecef;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> Pending Approvals
                    </div>
                    <div class="card-body">
                        <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Documents</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pending_users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @if($user->role == 3)
                                            <span class="badge badge-info">Agent</span>
                                        @elseif($user->role == 4)
                                            <span class="badge badge-warning">Agency</span>
                                        @endif
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-dark" type="button" data-toggle="modal" data-target="#docsModal{{$user->id}}">
                                            <i class="fas fa-file-alt"></i> View Docs
                                        </button>
                                        
                                        <!-- Documents Modal -->
                                        <div class="modal fade" id="docsModal{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-info modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title">Documents: {{ $user->name }}</h4>
                                                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">×</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            @if($user->role == 4)
                                                                {{-- Agency Docs --}}
                                                                @if($user->trade_license)
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Trade License</label>
                                                                        <div>
                                                                            <button onclick="openPreviewModal('{{ aws_asset_path($user->trade_license) }}', 'Trade License')" class="document-btn">View</button>
                                                                            <a href="{{ aws_asset_path($user->trade_license) }}" download class="document-btn"><i class="fas fa-download"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if($user->professional_practice_certificate)
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Brokerage License</label>
                                                                        <div>
                                                                            <button onclick="openPreviewModal('{{ aws_asset_path($user->professional_practice_certificate) }}', 'Brokerage License')" class="document-btn">View</button>
                                                                            <a href="{{ aws_asset_path($user->professional_practice_certificate) }}" download class="document-btn"><i class="fas fa-download"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                 @if($user->computer_card)
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Establishment Card</label>
                                                                        <div>
                                                                           <button onclick="openPreviewModal('{{ aws_asset_path($user->computer_card) }}', 'Establishment Card')" class="document-btn">View</button>
                                                                           <a href="{{ aws_asset_path($user->computer_card) }}" download class="document-btn"><i class="fas fa-download"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if($user->authorized_signatory)
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Authorized Signatory ID Copy</label>
                                                                        <div>
                                                                            <button onclick="openPreviewModal('{{ aws_asset_path($user->authorized_signatory) }}', 'Authorized Signatory')" class="document-btn">View</button>
                                                                            <a href="{{ aws_asset_path($user->authorized_signatory) }}" download class="document-btn"><i class="fas fa-download"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                 @if($user->cr)
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>Commercial Registration (CR)</label>
                                                                        <div>
                                                                            <button onclick="openPreviewModal('{{ aws_asset_path($user->cr) }}', 'CR')" class="document-btn">View</button>
                                                                            <a href="{{ aws_asset_path($user->cr) }}" download class="document-btn"><i class="fas fa-download"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endif


                                                            @elseif($user->role == 3)
                                                                {{-- Agent Docs --}}
                                                                @if($user->license)
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>License</label>
                                                                        <div>
                                                                            <button onclick="openPreviewModal('{{ aws_asset_path($user->license) }}', 'License')" class="document-btn">View</button>
                                                                             <a href="{{ aws_asset_path($user->license) }}" download class="document-btn"><i class="fas fa-download"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                @if($user->id_card)
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>ID Card</label>
                                                                        <div>
                                                                            <button onclick="openPreviewModal('{{ aws_asset_path($user->id_card) }}', 'ID Card')" class="document-btn">View</button>
                                                                            <a href="{{ aws_asset_path($user->id_card) }}" download class="document-btn"><i class="fas fa-download"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                 @if($user->qid)
                                                                    <div class="col-md-6 mb-3">
                                                                        <label>QID</label>
                                                                        <div>
                                                                            <button onclick="openPreviewModal('{{ aws_asset_path($user->qid) }}', 'QID')" class="document-btn">View</button>
                                                                            <a href="{{ aws_asset_path($user->qid) }}" download class="document-btn"><i class="fas fa-download"></i></a>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->created_at->format('d-M-Y') }}</td>
                                    <td>
                                        @if($user->role == 3)
                                            <a href="{{ url('admin/agent/approve/'.$user->id) }}" class="btn btn-success btn-sm confirm-action" title="Approve" onclick="return confirm('Are you sure you want to approve this agent?')"><i class="fa fa-check"></i></a>
                                            <form action="{{ url('admin/agent/reject') }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to reject/delete this agent?')">
                                                @csrf
                                                <input type="hidden" name="agent_id" value="{{ $user->id }}">
                                                <input type="hidden" name="id" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Reject"><i class="fa fa-times"></i></button>
                                            </form>
                                        @elseif($user->role == 4)
                                             <a href="{{ route('admin.agency.approve', $user->id) }}" class="btn btn-success btn-sm confirm-action" title="Approve" onclick="return confirm('Are you sure you want to approve this agency?')"><i class="fa fa-check"></i></a>
                                              <form action="{{ route('admin.agency.reject') }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to reject/delete this agency?')">
                                                @csrf
                                                <input type="hidden" name="agency_id" value="{{ $user->id }}">
                                                <button type="submit" class="btn btn-danger btn-sm" title="Reject"><i class="fa fa-times"></i></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @if($pending_users->isEmpty())
                        <div class="text-center p-4">No pending approvals found.</div>
                        @else
                        <!-- Pagination Links (if paginated, but currently fetching get() in controller. If list grows, pagination recommended) -->
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Preview Modal -->
<div class="modal fade" id="documentPreviewModal" tabindex="-1" role="dialog" aria-labelledby="previewModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-xl" role="document" style="height: 90vh;">
        <div class="modal-content" style="height: 100%;">
            <div class="modal-header">
                <h5 class="modal-title" id="previewModalLabel">Document Preview</h5>
                <button type="button" class="close" onclick="closePreviewModal()" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <iframe id="previewFrame" src="" style="width: 100%; height: 100%; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    function openPreviewModal(url, title) {
        // Set the title
        document.getElementById('previewModalLabel').textContent = title;
        // Set the source
        document.getElementById('previewFrame').src = url;
        // Show the modal
        $('#documentPreviewModal').modal('show');
    }

    function closePreviewModal() {
        $('#documentPreviewModal').modal('hide');
        // Clear src to stop playing media if any
        document.getElementById('previewFrame').src = '';
    }
    
    // Handle nested modals (Bootstrap 4 issue)
    $(document).on('show.bs.modal', '.modal', function () {
        var zIndex = 1040 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
        setTimeout(function() {
            $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
        }, 0);
    });
</script>
@endsection
