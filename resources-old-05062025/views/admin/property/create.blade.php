@extends('admin.template.layout')
@section('header')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" />

@stop
@section('content')
    <div class="container-fluid">
        <div class="fade-in">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header"><strong>
                                @if ($id)
                                    Edit
                                @else
                                    Add
                                @endif Property
                            </strong></div>
                        <form method="post" id="admin-form" action="{{ url('admin/save_property') }}"
                            enctype="multipart/form-data" data-parsley-validate="true">
                            <div class="card-body">
                                <input type="hidden" name="id" id="cid" value="{{ $id }}">
                                @csrf()

                                <div class="row">



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name" class="form-control" required
                                                data-parsley-required-message="Enter Name" value="@if($id){{$property->name}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Name Ar<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="name_ar" class="form-control" required
                                                data-parsley-required-message="Enter Arabic Name" value="@if($id){{$property->name_ar}}@endif">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="location" class="form-control" required
                                                data-parsley-required-message="Enter Location" value="@if($id){{$property->location}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location Ar<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="location_ar" class="form-control" required
                                                data-parsley-required-message="Enter Location Name" value="@if($id){{$property->location_ar}}@endif">
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Price<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" data-parsley-type="number" name="price" class="form-control" required
                                                data-parsley-required-message="Enter Price" value="@if($id){{$property->price}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Project<b class="text-danger">&nbsp;</b></label>
                                            <select name="project_id" class="form-control select2" required
                                                data-parsley-required-message="Select Project">
                                                <option  value="">Select</option>
                                                @foreach($projects as $val)
                                                <option <?= ($id && $property->project_id == $val->id) ? 'selected' : '' ?> value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Bedroom Count <b class="text-danger">&nbsp;</b></label>
                                            <input type="text" data-parsley-type="digits" name="bedrooms" class="form-control" required
                                                data-parsley-required-message="Enter Bedroom Count" value="@if($id){{$property->bedrooms}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Bathroom Count<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" data-parsley-type="digits" name="bathrooms" class="form-control" required
                                                data-parsley-required-message="Enter Bathroom Count" value="@if($id){{$property->bathrooms}}@endif">
                                        </div>
                                    </div>
                                    <div class="col-md-6"></div>


                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Balcony</label>
                                            <input type="text" name="parking" class="form-control"
                                            required data-parsley-required-message="Enter Balcony" value="@if($id){{$property->parking}}@endif">
                                        </div>
                                    </div> -->


                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Gross Area<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="gross_area" class="form-control" required
                                                data-parsley-required-message="Enter Gross Area" value="@if($id){{$property->gross_area}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Balcony Size</label>
                                            <input type="text" name="balcony_size" class="form-control"
                                             data-parsley-required-message="Enter Balcony Size" value="@if($id){{$property->balcony_size}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Net Area<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="area" data-parsley-type="number" class="form-control" required
                                                data-parsley-required-message="Enter Net Area" value="@if($id){{$property->area}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Location Google Map Embed Link<b class="text-danger">&nbsp;</b></label>
                                            <input type="text" name="location_link" class="form-control" required
                                                data-parsley-required-message="Enter Link" value="@if($id){{$property->location_link}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Sale Type<b class="text-danger">&nbsp;</b></label>
                                            <select name="sale_type" class="form-control select2" required
                                                data-parsley-required-message="Select Sale Type">
                                                <option  value="">Select</option>
                                                <option <?= ($id && $property->sale_type == 1) ? 'selected' : '' ?>  value="1">Buy</option>
                                                <option <?= ($id && $property->sale_type == 2) ? 'selected' : '' ?>  value="2">Rent</option>

                                                <option <?= ($id && $property->sale_type == 3) ? 'selected' : '' ?>  value="3">Buy & Rent</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Property Type<b class="text-danger">&nbsp;</b></label>
                                            <select name="category" class="form-control" required
                                                data-parsley-required-message="Select Property Type">
                                                <option  value="">Select</option>
                                                @foreach($categories as $val)
                                                <option <?= ($id && $property->category == $val->id) ? 'selected' : '' ?> value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>



                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select name="active" class="form-control">
                                                <option <?= ($id && $property->active == 1) ? 'selected' : '' ?> value="1">Active</option>
                                                <option <?= ($id && $property->active == 0) ? 'selected' : '' ?> value="0">Inactive
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Unit Number</label>
                                            <input type="text" name="apartment_no" class="form-control"  value="@if($id){{$property->apartment_no}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Floor Number</label>
                                            <input required data-parsley-required-message="Enter Floor Number" data-parsley-type="integer" data-parsley-type-message="Enter a valid floor number" type="text" name="floor_no" class="form-control"  value="@if($id){{$property->floor_no}}@endif">
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="is_recommended">Is Recommended <small class="text-info">To Show In Home Page</small></label> <br>
                                            <input type="checkbox" id="is_recommended" name="is_recommended" @if($id && $property->is_recommended) checked @endif>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Similar Properties <small class="text-info">Select properties that are similar to this one</small></label>
                                            <select name="similar_properties[]" class="form-control select2" multiple>
                                                @foreach($properties as $prop)
                                                    @if(!$id || $prop->id != $property->id)
                                                        <option value="{{$prop->id}}" @if($id && in_array($prop->id, explode(',', $property->similar_properties))) selected @endif>
                                                            {{$prop->name}} ({{$prop->apartment_no}})
                                                        </option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Order</label>
                                            <input required data-parsley-required-message="Enter Order " data-parsley-type="integer" data-parsley-type-message="Enter a valid order" type="text" name="order" class="form-control"  value="@if($id){{$property->order}}@endif" >
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Short Description<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="short_description" class="form-control" required data-parsley-required-message="Enter Short Description">@if($id){{$property->short_description}}@endif</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Short Description Ar<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="short_description_ar" class="form-control" required data-parsley-required-message="Enter Arabic Short Description">@if($id){{$property->short_description_ar}}@endif</textarea>
                                        </div>
                                    </div>


                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="description" class="form-control editor" required data-parsley-required-message="Enter Description">@if($id){{$property->description}}@endif</textarea>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Description Ar<b class="text-danger">&nbsp;</b></label>
                                            <textarea name="description_ar" class="form-control editor" required data-parsley-required-message="Enter Arabic Description">@if($id){{$property->description_ar}}@endif</textarea>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Amenities<b class="text-danger">&nbsp;</b></label>
                                            <select name="amenities[]" multiple class="form-control select2" required
                                                data-parsley-required-message="Select Amneties">
                                                <option value="All">Select All</option>
                                                @foreach($amenities as $val)
                                                <option <?= ($id && $property->amenities->contains('amenity_id', $val->id)) ? 'selected' : '' ?> value="{{$val->id}}">{{$val->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Broucher</label>
                                            <input
                                                type="file" name="broucher" class="form-control"
                                                data-parsley-trigger="change"
                                                data-parsley-fileextension="pdf"
                                                data-parsley-fileextension-message="Only files with type pdf are supported"
                                                data-parsley-max-file-size="5120"
                                                data-parsley-max-file-size-message="Max file size should be 5MB"
                                                data-parsley-imagedimensionss="300x300" accept="application/pdf">
                                                @if($id && $property->broucher) <a href=" {{aws_asset_path($property->broucher) }}" target="_blank" rel="noopener noreferrer">View Broucher</a> @endif
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Floor Plan</label>
                                            <input
                                                type="file" name="floor_plan" class="form-control"
                                                data-parsley-trigger="change"
                                                data-parsley-fileextension="jpg,png,gif,jpeg"
                                                data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                data-parsley-max-file-size="5120"
                                                data-parsley-max-file-size-message="Max file size should be 5MB"
                                                data-parsley-imagedimensionss="300x300" accept="image/*">
                                                @if($id && $property->floor_plan) <a href="{{aws_asset_path($property->floor_plan) }}" target="_blank" rel="noopener noreferrer">View Plan</a> @endif
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Video<b class="text-danger">&nbsp;</b></label>
                                            <input <?=!$id ? 'required' : '' ?>
                                                data-parsley-required-message="Select Video"
                                                type="file" name="video" class="form-control"
                                                data-parsley-trigger="change"accept="video/*">
                                                @if($id && $property->video) <a href=" {{aws_asset_path($property->video) }}" target="_blank" rel="noopener noreferrer">View Video</a> @endif
                                        </div>
                                    </div> -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Video <small>Youtube Embed Link</small><b class="text-danger">&nbsp;</b></label>
                                            <input type="url" name="video_link" class="form-control" required    data-parsley-pattern="^https:\/\/www\.youtube\.com\/embed\/([a-zA-Z0-9_-]{11})(\?[\w=&]*)?$"
                                            data-parsley-pattern-message="Please enter a valid YouTube embed URL."
                                                data-parsley-required-message="Enter Embed Link" value="@if($id){{ $property->video_link }} @endif">
                                        </div>
                                    </div>

                                    <!-- <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Video Thumbnail<b class="text-danger">&nbsp;</b></label>
                                            <input <?=!$id ? 'required' : '' ?>
                                                data-parsley-required-message="Select Video Thumbnail"
                                                type="file" name="video_thumbnail" class="form-control"
                                                data-parsley-trigger="change "accept="image/*">
                                                @if($id && $property->video_thumbnail) <a href="{{aws_asset_path($property->video_thumbnail) }}" target="_blank" rel="noopener noreferrer">View Thumbnail </a> @endif
                                        </div>
                                    </div> -->

                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>360 Link</label>
                                            <input type="url" name="link_360" class="form-control"  value="@if($id){{$property->link_360}}@endif" data-parsley-required-message="Enter 360 Link">
                                        </div>
                                    </div>

                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Unit Layout</label>
                                            <input type="url" name="unit_layout" class="form-control"  value="@if($id){{$property->unit_layout}}@endif" data-parsley-required-message="Enter Unit Layout">
                                        </div>
                                    </div>



                                    <!-- <div class="col-md-6"></div> -->

                                    <div class="col-md-6 form-group">
                                        <label>Meta Title<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="meta_title" class="form-control jqv-input" value="@if($id){{ $property->meta_title }}@endif" placeholder="Meta Title">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Meta Title Ar<b class="text-danger">&nbsp;</b></label>
                                        <input type="text" name="meta_title_ar" class="form-control jqv-input" value="@if($id){{ $property->meta_title_ar }}@endif" placeholder="Meta Title Arabic">
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Meta Description<b class="text-danger">&nbsp;</b></label>
                                        <textarea name="meta_description" class="form-control jqv-input" placeholder="Meta Description">@if($id){{$property->meta_description}}@endif</textarea>
                                    </div>

                                    <div class="col-md-6 form-group">
                                        <label>Meta Description Ar<b class="text-danger">&nbsp;</b></label>
                                        <textarea name="meta_description_ar" class="form-control jqv-input" placeholder="Meta Description Arabic">@if($id){{$property->meta_description_ar}}@endif</textarea>
                                    </div>




                                    @if (count($images) > 0)
                                        <div class="col-md-12">
                                            <label>
                                                <h5>Uploaded Property Images:</h5>
                                            </label>
                                        </div>

                                        <div class="row col-md-12">

                                            @foreach ($images as $img)
                                                <div class="col-md-2">
                                                    <div style="float: left;margin-top: 30px;">
                                                        <img src="{{aws_asset_path($img->image) }}" style="max-width:75%;">
                                                        <a class="remove deleteListItem" data-role="unlink"
                                                            data-message="Do you want to remove this image?"
                                                            title="Delete"
                                                            href="{{ url('admin/property/delete_image/' . $img->id) }}">
                                                            <i class="fa fa-trash removeThis" style="color: red;"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                    @endif

                                    <div class="col-md-6 mt-2">
                                        <div class="form-group">
                                            <label>Property Images (gif,jpg,png,jpeg) </label>
                                            <input
                                                @if (!$id) data-parsley-required-message="Select Property Images" @endif
                                                type="file" name="images[]" class="form-control"
                                                data-role="file-image" data-preview="image-preview"
                                                data-parsley-trigger="change"
                                                data-parsley-fileextension="jpg,png,gif,jpeg"
                                                data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported"
                                                data-parsley-max-file-size="5120"
                                                data-parsley-max-file-size-message="Max file size should be 5MB"
                                                data-parsley-imagedimensionss="300x300" accept="image/*" multiple>
                                        </div>
                                    </div>




                                    <!-- <div class=" col-md-12 mt-3">
                                        <h5>Faq Details</h5>
                                    </div>

                                    <div class="itinerary col-md-12 mb-5" style="background-color: lightgray">
                                        @if (!count($faq))
                                            <div class="row">



                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label>Faq<b class="text-danger">&nbsp;</b></label>
                                                        <input type="text" name="faq_title[0]" class="form-control"
                                                            required data-parsley-required-message="Enter Faq"
                                                            value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Faq Ar<b class="text-danger">&nbsp;</b></label>
                                                        <input type="text" name="faq_title_ar[0]" class="form-control"
                                                            required data-parsley-required-message="Enter Arabic Faq"
                                                            value="">
                                                    </div>
                                                </div>

                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>Action</label>
                                                        <br>
                                                        <button type="button"
                                                            class="btn btn-primary add_new_itinerary">+</button>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Details<b class="text-danger">&nbsp;</b></label>
                                                        <textarea name="faq_description[0]" rows="3" class="form-control editor" required
                                                            data-parsley-required-message="Enter Details"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Details Ar<b class="text-danger">&nbsp;</b></label>
                                                            <textarea name="faq_description_ar[0]" rows="3" class="form-control editor" required
                                                                data-parsley-required-message="Enter Arabic Details"></textarea>
                                                        </div>
                                                    </div>
                                            </div>
                                        @else
                                            @foreach ($faq as $key => $val)
                                                <div class="row">


                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Faq<b class="text-danger">&nbsp;</b></label>
                                                            <input type="text" name="faq_title[{{ $key }}]"
                                                                class="form-control" required
                                                                data-parsley-required-message="Enter Faq"
                                                                value="{{ $val->title }}">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Faq Ar<b class="text-danger">&nbsp;</b></label>
                                                            <input type="text" name="faq_title_ar[{{ $key }}]" class="form-control"
                                                                required data-parsley-required-message="Enter Arabic Faq"
                                                                value="{{ $val->title_ar }}">
                                                        </div>
                                                    </div>






                                                    <div class="col-md-1">
                                                        <div class="form-group">
                                                            @if ($key == 0)
                                                                <label>Action</label><br>
                                                                <button type="button"
                                                                    class="btn btn-primary add_new_itinerary">+</button>
                                                            @else
                                                                <label></label>
                                                                <button type="button" style="margin-top: 30px"
                                                                    class="btn btn-danger remove_itinerary">-</button>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Details<b class="text-danger">&nbsp;</b></label>
                                                            <textarea name="faq_description[{{ $key }}]" rows="3" class="form-control editor" required
                                                                data-parsley-required-message="Enter Details">{{ $val->description }}</textarea>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label>Details Ar<b class="text-danger">&nbsp;</b></label>
                                                            <textarea name="faq_description_ar[{{ $key }}]" rows="3" class="form-control editor" required
                                                                data-parsley-required-message="Enter Arabic Details">{{ $val->description_ar }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div> -->


                                    <div class="col-md-12 mt-2">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /.col-->
            </div>
            <!-- /.row-->
        </div>
    </div>

@stop
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.5/tinymce.min.js"></script>

    <script>
        $(".select2").select2();
        $(document).ready(function() {
            var selectElement = $('select[name="amenities[]"]');
            selectElement.on('change', function() {
                var selectedValues = $(this).val();
                if (selectedValues && selectedValues.includes("All")) {
                    $(this).find('option').not('[value="All"]').prop('selected', true);
                    $(this).find('option[value="All"]').prop('selected', false);
                }
            });
            selectElement.select2();
        });

        var editor_config = {
            selector: '.editor',
            directionality: document.dir,
            path_absolute: "/",
            menubar: 'edit insert view format table image',
            plugins: [
                "advlist autolink lists link image charmap preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media save table contextmenu directionality",
                "paste textcolor colorpicker textpattern"
            ],
            toolbar: "insertfile undo redo | formatselect styleselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen code",
            relative_urls: false,
            language: document.documentElement.lang,
            height: 300,
        }
        tinymce.init(editor_config);
    </script>
    <script>
        $('body').off('submit', '#admin-form');
        $('body').on('submit', '#admin-form', function(e) {
            e.preventDefault();
            var $form = $(this);
            var formData = new FormData(this);
            $(".invalid-feedback").remove();

            $form.find('button[type="submit"]')
                .text('Saving')
                .attr('disabled', true);

            var parent_tree = $('option:selected', "#parent_id").attr('data-tree');
            formData.append("parent_tree", parent_tree);

            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: $form.attr('action'),
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                dataType: 'json',
                success: function(res) {

                    if (res['status'] == 0) {
                        if (typeof res['errors'] !== 'undefined' && res['errors']) {
                            var error_def = $.Deferred();
                            var error_index = 0;
                            jQuery.each(res['errors'], function(e_field, e_message) {
                                if (e_message != '') {
                                    $('[name="' + e_field + '"]').eq(0).addClass('is-invalid');
                                    $('<div class="invalid-feedback">' + e_message + '</div>')
                                        .insertAfter($('[name="' + e_field + '"]').eq(0));
                                    if (error_index == 0) {
                                        error_def.resolve();
                                    }
                                    error_index++;
                                }
                            });
                            error_def.done(function() {
                                var error = $form.find('.is-invalid').eq(0);
                                $('html, body').animate({
                                    scrollTop: (error.offset().top - 100),
                                }, 500);
                            });
                        } else {
                            var m = res['message'] ||
                                'Unable to save property. Please try again later.';
                            show_msg(0, m)
                        }
                    } else {
                        var m = res['message'];
                        show_msg(1, m)
                        setTimeout(function() {
                            window.location.href = "{{ url('/admin/properties') }}";
                        }, 1500);

                    }

                    $form.find('button[type="submit"]')
                        .text('Save')
                        .attr('disabled', false);
                },
                error: function(e) {

                    $form.find('button[type="submit"]')
                        .text('Save')
                        .attr('disabled', false);
                    show_msg(0, e.responseText)
                }
            });
        });
        faq_index = "<?= count($faq) ?>";
        $(document).on('click', '.add_new_itinerary', function(e) {
            faq_index++;
            _html =
                `<div class="row">
                    <div class="col-md-5">
                    <div class="form-group"><label>Faq<b class="text-danger">&nbsp;</b></label><input type="text" name="faq_title[${faq_index }]" class="form-control" required data-parsley-required-message="Enter Faq" value=""></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group"><label>Faq Ar<b class="text-danger">&nbsp;</b></label><input type="text" name="faq_title_ar[${faq_index }]" class="form-control" required data-parsley-required-message="Enter ArabicFaq" value="">
                        </div>
                    </div>

                    <div class="col-md-1">
                    <div class="form-group"><label>Action</label><br><button type="button"
                        class="btn btn-danger remove_itinerary">-</button></div>
                    </div>

                    <div class="col-md-12">
                    <div class="form-group"><label>Details<b class="text-danger">&nbsp;</b></label><textarea name="faq_description[${faq_index }]" rows="3" class="form-control editor" required
                        data-parsley-required-message="Enter Details"></textarea></div>
                    </div>
                    <div class="col-md-12">
                    <div class="form-group"><label>Details Ar<b class="text-danger">&nbsp;</b></label><textarea name="faq_description_ar[${faq_index }]" rows="3" class="form-control editor" required
                        data-parsley-required-message="Enter Arabic Details"></textarea></div>
                    </div>
                </div>`;

            $(".itinerary").append(_html);


            var editor_config = {
                selector: '.editor',
                directionality: document.dir,
                path_absolute: "/",
                menubar: 'edit insert view format table image',
                plugins: [
                    "advlist autolink lists link image charmap preview hr anchor pagebreak",
                    "searchreplace wordcount visualblocks visualchars code fullscreen",
                    "insertdatetime media save table contextmenu directionality",
                    "paste textcolor colorpicker textpattern"
                ],
                toolbar: "insertfile undo redo | formatselect styleselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link | fullscreen code",
                relative_urls: false,
                language: document.documentElement.lang,
                height: 300,
            }
            tinymce.init(editor_config);

        });
        $(document).on('click', '.remove_itinerary', function(e) {
            $(this).parent().parent().parent().remove();
        });
    </script>

@stop
