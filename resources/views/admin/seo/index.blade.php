@extends('admin.template.layout')

@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Global SEO Settings
                            <div class="card-header-actions">
                                <form action="{{ route('admin.seo_generate_sitemap') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Generate Sitemap</button>
                                </form>
                                <a href="{{ url('sitemap.xml') }}" target="_blank" class="btn btn-dark btn-sm">View Sitemap</a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('admin.seo_settings_update') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Meta Title</label>
                                            <input type="text" name="meta_title" id="meta_title" class="form-control"
                                                value="{{ $settings['meta_title'] ?? '' }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Meta Description</label>
                                            <textarea name="meta_description" id="meta_description" class="form-control"
                                                rows="3">{{ $settings['meta_description'] ?? '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Canonical URL</label>
                                            <input type="text" name="canonical_url" class="form-control"
                                                value="{{ $settings['canonical_url'] ?? '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label>Keywords</label>
                                            <input type="text" name="keywords" class="form-control"
                                                value="{{ $settings['keywords'] ?? '' }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                         <div class="form-group">
                                            <label>OG Title</label>
                                            <input type="text" name="og_title" id="og_title" class="form-control"
                                                value="{{ $settings['og_title'] ?? '' }}">
                                        </div>
                                        <div class="form-group">
                                            <label>OG Description</label>
                                            <textarea name="og_description" id="og_description" class="form-control"
                                                rows="3">{{ $settings['og_description'] ?? '' }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>OG Image URL</label>
                                            <input type="text" name="og_image" id="og_image" class="form-control"
                                                value="{{ $settings['og_image'] ?? '' }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <h4>SEO Preview</h4>
                                        <div class="row">
                                            <!-- Google Search Preview -->
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header bg-light">Google Search Result Preview</div>
                                                    <div class="card-body">
                                                        <div class="google-preview">
                                                            <div class="google-title" style="color: #1a0dab; font-family: arial,sans-serif; font-size: 18px; line-height: 1.2; cursor: pointer; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" id="preview-meta-title">{{ $settings['meta_title'] ?? 'Meta Title' }}</div>
                                                            <div class="google-url" style="color: #006621; font-family: arial,sans-serif; font-size: 14px; line-height: 1.3;" id="preview-url">{{ url('/') }}</div>
                                                            <div class="google-desc" style="color: #545454; font-family: arial,sans-serif; font-size: 13px; line-height: 1.4; word-wrap: break-word;" id="preview-meta-desc">{{ $settings['meta_description'] ?? 'Meta description will appear here...' }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Social Media Preview -->
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header bg-light">Social Media Share Preview</div>
                                                    <div class="card-body">
                                                        <div class="social-preview" style="border: 1px solid #e1e8ed; border-radius: 5px; overflow: hidden; max-width: 500px;">
                                                            <div class="social-image" style="height: 260px; background-color: #e1e8ed; background-size: cover; background-position: center;" id="preview-og-image" 
                                                                @if(isset($settings['og_image']) && $settings['og_image']) style="background-image: url('{{ $settings['og_image'] }}');" @endif>
                                                            </div>
                                                            <div class="social-content" style="padding: 10px; background: #f5f8fa; border-top: 1px solid #e1e8ed;">
                                                                <div class="social-domain" style="text-transform: uppercase; color: #657786; font-size: 12px; font-weight: bold;">{{ request()->getHost() }}</div>
                                                                <div class="social-title" style="font-weight: bold; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 16px; margin-top: 5px; color: #14171a;" id="preview-og-title">{{ $settings['og_title'] ?? $settings['meta_title'] ?? 'OG Title' }}</div>
                                                                <div class="social-desc" style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #657786; margin-top: 5px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;" id="preview-og-desc">{{ $settings['og_description'] ?? $settings['meta_description'] ?? 'OG Description will appear here...' }}</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-3">Save Settings</button>
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
        var urlBase = "{{ url('/') }}";

        function updatePreview() {
            var metaTitle = $('#meta_title').val();
            var metaDesc = $('#meta_description').val();
            var ogTitle = $('#og_title').val();
            var ogDesc = $('#og_description').val();
            var ogImage = $('#og_image').val();
            
            // Update Google Preview
            $('#preview-meta-title').text(metaTitle || 'Meta Title');
            $('#preview-meta-desc').text(metaDesc || 'Meta description will appear here...');

            // Update Social Preview
            $('#preview-og-title').text(ogTitle || metaTitle || 'OG Title');
            $('#preview-og-desc').text(ogDesc || metaDesc || 'OG Description will appear here...');
            
            if(ogImage) {
                 $('#preview-og-image').css('background-image', 'url(' + ogImage + ')');
            } else {
                 $('#preview-og-image').css('background-image', 'none');
            }
        }

        $('#meta_title, #meta_description, #og_title, #og_description, #og_image').on('keyup change', updatePreview);
    });
</script>
@endsection