require('./bootstrap')
require('summernote/dist/summernote-bs4')
import {JSONEditor} from '@json-editor/json-editor'
window.JSONEditor = JSONEditor

require('bootstrap')
require('select2')

jQuery( function(){

  $('.js-summernote').summernote({
    height: 300,
    toolbar: [
      ['style', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
      ['para', ['ul', 'ol', 'paragraph']]
    ]
  });

  $('.js-select2').select2({
    'theme': 'bootstrap4'
  })

    $('.custom-file-img__input').change(function(){
        var preview = $(this).parents('.custom-file-img').find('.custom-file-img__preview img');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                //console.log(preview);
                preview.attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    $('.js-img-preview').change(function(){
        var target = $(this).data('target');
        var preview = $(target);
        preview.removeClass('show');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                //console.log(preview);
                preview.find('img').attr('src', e.target.result);
                preview.addClass('show');
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    $('.side-menu').on('click', '.has-sub' ,function(){
        console.log('toggle click');
        $(this).siblings('.collapse').collapse('toggle');
        $(this).toggleClass('active');
    });
    $(".js-toggle").click(function(event) {
        var target = $(this).data('target');
        var classes = $(this).data('class');
        $(target).toggleClass(classes);
    });

    $('.input-image-preview-input').on('change',function(element) {
      console.log('loading');

      let container = $(this).parents('.input-image-preview')
      let preview = container.find('.input-image-preview-image');
      let input = container.find('.input-image-preview-text');

        if (this.files && this.files[0]) {
          var reader = new FileReader();
          var file = this.files[0];
          reader.onload = function (e) {
            var img = document.createElement("img");
            img.src = e.target.result;
            img.onload = function(e) {
              var canvas = document.createElement("canvas");
              var ctx = canvas.getContext("2d");
              ctx.drawImage(img, 0, 0);

              var MAX_WIDTH = 1200;
              var MAX_HEIGHT = 1200;
              var width = img.width;
              var height = img.height;

              if (width > height) {
                  if (width > MAX_WIDTH) {
                      height *= MAX_WIDTH / width;
                      width = MAX_WIDTH;
                  }
              } else {
                  if (height > MAX_HEIGHT) {
                      width *= MAX_HEIGHT / height;
                      height = MAX_HEIGHT;
                  }
              }
              canvas.width = width;
              canvas.height = height;
              var ctx = canvas.getContext("2d");
              ctx.drawImage(img, 0, 0, width, height);

              var dataurl = canvas.toDataURL(file.type);
              preview.attr('src', dataurl);
              input.attr('value', dataurl);
              console.log('done');
              container.addClass('show');

            }
          }
          reader.readAsDataURL(this.files[0]);
        }
    });
});
