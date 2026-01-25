$(document).on('change', '.toggle_status', function () {
   var ckd = this.checked ? 1 : 0;
   table = '';
   if ($("#dt-tbl").length > 0) {
      var table = $('#dt-tbl').DataTable();
   }
   rdraw = $(this).attr("data-redraw");
   $.ajax({
      method: "get",
      dataType: "json",
      url: $(this).attr("data-href") + '/' + ckd,
      success: function (resp) {
         messageBox(resp);
         if (typeof (rdraw) === 'undefined') {} else {
            if (table) {
               table.draw();
            } else {
               location.reload();
            }
         }
      }
   });
});

$(document).on('click', '.trVOE', function () {
   _url_by_id = $(this).closest('tr').attr('id');
   if (typeof (_url_by_id) === 'undefined') {
      location.href = $(this).closest('tr').attr('data-url');
   } else {
      location.href = _url_by_id;
   }

});
$(document).on('click', '.deleteListItem', function () {
   Swal.fire({
      title: 'Are you sure to delete this record?',
      text: "",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
   }).then((result) => {
      if (result.value) {
         var url = $(this).attr('data-url');
         _row = $(this).closest("tr");
         table = '';
         if ($("#dt-tbl").length > 0) {
            var table = $('#dt-tbl').DataTable();
         }

         $.ajax({
            type: 'post',
            url: url,
            dataType: 'json',
            success: function (resp) {
               if (resp.status == "success") {
                  if (table) {
                     table.row(_row).remove().draw();
                  } else {
                     _row.remove();
                  }
               }
               messageBox(resp);
            }
         });
      }
   })
});
$("#pri_cat").change(function () {
   var url = $(this).attr('data-url');
   _val = $(this).val();
   if (!_val) {
      $("#sec_cat").html('');
      $(".sec_category").addClass("d-none");
   }
   $.ajax({
      type: 'post',
      url: url,
      data: {
         cat_id: _val
      },
      dataType: 'json',
      success: function (resp) {
         if (resp.status == "success") {
            $("#sec_cat").html(resp.html);
            $(".sec_category").removeClass("d-none");
         } else {
            $("#sec_cat").html('');
            $(".sec_category").addClass("d-none");
         }
      }
   });
});

function messageBox(response) {
   if (response.status == 'fail') {
      response.status = 'error';
   }
   const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000,
      timerProgressBar: true,
      onOpen: (toast) => {
         toast.addEventListener('mouseenter', Swal.stopTimer)
         toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
   });
   Toast.fire({
      icon: response.status,
      title: response.msg
   })
}

function showMsg(status, msg) {
   const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000,
      timerProgressBar: true,
      onOpen: (toast) => {
         toast.addEventListener('mouseenter', Swal.stopTimer)
         toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
   });
   Toast.fire({
      icon: status,
      title: msg
   })
}
window.Parsley.addValidator('fileextension', {
   validateString: function (value, requirement) {
      var fileExtension = value.split('.').pop();
      extns = requirement.split(',');
      if (extns.indexOf(fileExtension.toLowerCase()) == -1) {
         return fileExtension === requirement;
      }
   },
});
window.Parsley.addValidator('maxFileSize', {
   validateString: function (_value, maxSize, parsleyInstance) {
      var files = parsleyInstance.$element[0].files;
      return files.length != 1 || files[0].size <= maxSize * 1024;
   },
   requirementType: 'integer',
});
window.Parsley.addValidator('datelessthan', {
   validateString: function (value) {
      if ($('.startDate').val() !== '' && $('.endDate').val() !== '') {
         return Date.parse($('.startDate').val()) <= Date.parse($('.endDate').val());

         // return Date.parse($('.startDate').val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3")) <= Date.parse($('.endDate').val().replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
      }
      return true;
   }
});

if ($(".datepicker").length > 0) {
   $('.datepicker').datepicker({
      orientation: "bottom auto",
      autoclose: true,
      format: 'yyyy-mm-dd',
      todayHighlight: true
   });
   $(".c-body").on('scroll', function () {
      $('.datepicker').datepicker('hide');
      $('.datepicker').blur();
   });
   $(".c-body").resize(function () {
      $('.datepicker').datepicker('hide');
      $('.datepicker').blur();
   });
}

if ($(".editor").length > 0) {
   tinymce.init({
      mode: "specific_textareas",
      editor_selector: "editor",
      plugins: 'image imagetools fullscreen autolink lists media table link',
      toolbar: ' fullscreen fontcolor image code pageembed numlist bullist table link',
      relative_urls: false,
      remove_script_host: false,
      convert_urls: true,
      toolbar_mode: 'floating',
      tinycomments_mode: 'embedded',
      tinycomments_author: 'STEMOTICS',
      images_upload_url: base_url + 'admin/news/editorImageUpload',
      setup: function (editor) {
         editor.on('change', function () {
            tinymce.triggerSave();
         });
      },
      images_upload_handler: function (blobInfo, success, failure) {
         var xhr, formData;
         xhr = new XMLHttpRequest();
         xhr.withCredentials = false;
         xhr.open('POST', base_url + 'admin/news/editorImageUpload');
         xhr.onload = function () {
            var json;

            if (xhr.status != 200) {
               failure(xhr.statusText);
               return;
            }
            json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
               failure('Invalid JSON: ' + xhr.responseText);
               return;
            }
            success(json.location);
         };
         formData = new FormData();
         if (typeof (blobInfo.blob().name) !== undefined)
            fileName = blobInfo.blob().name;
         else
            fileName = blobInfo.filename();
         formData.append('file', blobInfo.blob(), fileName);
         xhr.send(formData);
      }
   });
}

window.Parsley.addValidator('dategttoday', {
   validateString: function(value) {
       if (value !== '') {
           return Date.parse(value) >= Date.parse(today);
       }
       return true;
   },
   messages: {
       en: 'Date should be equal or greater than today'
   }
});

$(document).ready(function () {
   $(".dt_table_filter_button").click(function () {
      dt_id = $(this).attr("data-tid");
      $(dt_id).DataTable().draw();
   })
   $(".dt_tables_filter_button").click(function () {
      if ($(".filter_1").length > 0) {
         $(".filter_1_val").val($('.filter_1').val());
      }

      if ($(".filter_2").length > 0) {
         $(".filter_2_val").val($('.filter_2').val());
      }
      

      dt_id = $(this).attr("data-tid");
      dt_id = dt_id.split(',');
      $.each(dt_id, function (index, value) {
         $('#'+value).DataTable().draw();
      });
   })
   if ($("#dt-tbl").length > 0) {
      makeIt('#dt-tbl');
   }

   if ($("#dt-tbl1").length > 0) {
      makeIt('#dt-tbl1');
   }
   if ($("#dt-tbl2").length > 0) {
      makeIt('#dt-tbl2');
   }
   if ($("#dt-tbl3").length > 0) {
      makeIt('#dt-tbl3');
   }

   if ($("#dt-tbl4").length > 0) {
      makeIt('#dt-tbl4');
   }
   if ($("#dt-tbl5").length > 0) {
      makeIt('#dt-tbl5');
   }
   if ($("#dt-tbl6").length > 0) {
      makeIt('#dt-tbl6');
   }
   if ($("#dt-tbl7").length > 0) {
      makeIt('#dt-tbl7');
   }
 

   function makeIt(_id) {
      url = $(_id).attr('data-ajax-url');
      trvoe = $(_id).attr("data-trvoe");
      if (typeof (trvoe) === 'undefined') {
         trvoe = '';
      }
      trvoe = trvoe.split(',');
      var table = $(_id).DataTable({
         "ordering": false,
         "processing": true,
         "serverSide": true,
         "bAutoWidth": false,
         "ajax": {
            "url": url,
            "type": "POST",
            "data": function (data) {
               if ($(".filter_1").length > 0) {
                  data.searchByFilter_1 = $('.filter_1').val();;
               }
               if ($(".filter_2").length > 0) {
                  data.searchByFilter_2 = $('.filter_2').val();;
               }
               if ($(".filter_3").length > 0) {
                  data.searchByFilter_3 = $('.filter_3').val();;
               }
               if ($(".filter_4").length > 0) {
                  data.searchByFilter_4 = $('.filter_4').val();;
               }
               if ($(".filter_5").length > 0) {
                  data.searchByFilter_5 = $('.filter_5').val();;
               }
            }
         },
         "fnDrawCallback": function (dt) {
            if ($(".toggle_status").length > 0) {
               $('.toggle_status').bootstrapToggle();
            }
         },
         "createdRow": function (row) {
            $.each(trvoe, function (index, value) {
               $('td', row).eq(value).addClass('trVOE');
            });
         }
      });
   }

});


popup_index = parseInt($("#popup_count").val());
$(".add_popup").click(function () {
   html = '<div class="row dlt_field' + popup_index + '">\
   <div class="form-group row  col-md-6">\
      <label class="col-md-2 col-form-label" for="text-input">Title<b class="text-danger">*</b></label>\
      <div class="col-md-10">\
         <input maxlength="255" class="form-control" required data-parsley-required-message="Title required" type="text" name="item_title[]" placeholder="Item Title">\
      </div>\
   </div>\
   <div class="form-group row  col-md-6">\
      <label class="col-md-2 col-form-label" for="text-input">Link</label>\
      <div class="col-md-10">\
         <input maxlength="500" class="form-control" data-parsley-type="url" type="text" name="popup_item_link[]" placeholder="Item Link">\
      </div>\
   </div>\
   <div class="form-group row  col-md-6">\
      <label class="col-md-2 col-form-label" for="text-input">Type</label>\
      <div class="col-md-10">\
         <select class="form-control type_sel" data-id="'+popup_index+'" required data-parsley-required-message="Select Type"  name="popup_item_type[]">\
            <option value="1">Image</option>\
            <option value="2">Video</option>\
         </select>\
      </div>\
   </div>\
   <div class="form-group  row col-md-6">\
      <label class="col-md-2 col-form-label" for="text-input"><span id="type_span'+popup_index+'">Image</span><b class="text-danger">*</b></label>\
      <div class="col-md-10">\
         <input id="type_input'+popup_index+'" required data-parsley-trigger="change" data-parsley-fileextension="jpg,png,gif,jpeg" data-parsley-max-file-size-message="Max file size should be 6MB" data-parsley-max-file-size="6144" data-parsley-fileextension-message="Only files with type jpg,png,gif,jpeg are supported" name="popup_image[]" autocomplete="off" data-parsley-required-message="Select a file" type="file" id="inputFile" class="form-control ppFrm" />\
      </div>\
   </div>\
   <div class="form-group  row col-md-1">\
      <div class="col-md-12">\
         <button type="button" class="btn btn-danger btn_popup_field" data-id="' + popup_index + '"><i class="fa fa-trash"></i></button>\
      </div>\
   </div>\
</div>';
   popup_index++;
   $(".popup_div").append(html);
});
$(document).on('click', '.btn_popup_field', function () {
   _id = $(this).attr("data-id");
   $(".dlt_field" + _id).remove();
});
$(document).on('change', '.type_sel', function () {
   _id = $(this).attr("data-id");
   _val = $(this).val();
   if(_val == 1){
      $("#type_span"+_id).text("Image");
      $("#type_input"+_id).attr("data-parsley-fileextension","jpg,png,gif,jpeg").attr("data-parsley-fileextension-message","Only files with type jpg,png,gif,jpeg are supported");
   }else{
      $("#type_span"+_id).text("Video");
      $("#type_input"+_id).attr("data-parsley-fileextension","mpeg,mov,mpg,3gp,mp4,webm,ogg").attr("data-parsley-fileextension-message","Only files with type mpeg,mov,mpg,3gp,mp4,webm,ogg are supported");
   }
});
$(".video_rad").change(function () {
   vdo = $("#vdo").val();

   if ($(this).val() == "1") {
      $(".youtube_div").addClass("d-none");
      $(".youtube_input").removeAttr("required");

      $(".hosted_div").removeClass("d-none");
      if (typeof (vdo) === 'undefined') {
         $(".hosted_input").attr("required", "");
      } else {
         if (vdo) {
            $(".hosted_input").removeAttr("required");
         } else {
            $(".hosted_input").attr("required", "");
         }
      }

   } else {
      $(".hosted_div").addClass("d-none");
      $(".hosted_input").removeAttr("required");

      $(".youtube_div").removeClass("d-none");
      $(".youtube_input").attr("required", "");
   }
});
$(".social_sel").change(function () {
   _val = $(this).val();

   if ($("#s_div_" + _val).length > 0) {
      return false;
   }
   _valtext = $(".social_sel option:selected").text();
   html = '<div class="form-group row" id="s_div_' + _val + '">\
               <input type="hidden" name="social_id[]" value="' + _val + '">\
               <input type="hidden" name="social_text[' + _val + ']" value="' + _valtext + '">\
               <label  class="col-sm-3 col-form-label">' + _valtext + ' Link<b class="text-danger">*</b></label>\
               <div class="col-sm-7">\
                  <input type="text" class="form-control" required data-parsley-required-message="Enter Url" name="url[' + _val + ']" data-parsley-type="url">\
               </div>\
               <div class="col-sm-2">\
                  <button type="button" class="btn btn-danger remove_s_div" id="' + _val + '">-</button>\
               </div>\
            </div>';
   $(".social_div").append(html);
});
$(document).on('click', '.remove_s_div', function () {
   _id = $(this).attr('id');
   $("#s_div_" + _id).remove();
});