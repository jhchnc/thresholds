
function sendFile(file, editor) {
  data = new FormData();
  data.append("file", file);
  data.append("_token", $('#token').val());
  $.ajax({
    data: data,
    type: "POST",
    url: '/upload/image',
    cache: false,
    contentType: false,
    processData: false,
    success: function(url) {
      $(editor).summernote('editor.insertImage', url);
    }
  });
}

function articleEditSummernote(editor_selector) {

  var editLocalStorage = localStorage;
  $('.copy_fragment').each(function(){
      var link = $(this);
      link.click(function(e){
          e.preventDefault();
          var fragment_id = link.attr('rel');
          editLocalStorage.setItem('last_fragment_id', fragment_id);
      });
  });

  var editor = $(editor_selector);
  editor.summernote({
    height: 400,
    focus: false,
    fontNames: ['Arial','Roboto Slab','Slabo 27px'],
    callbacks : {
      onImageUpload: function(files) {
        sendFile(files[0],this);
      },
      onInit: function(){

        var style = $(".note-editable.panel-body").attr('style');
        $(".note-editable.panel-body").attr("style", style + " font-family: 'Slabo 27px', serif;font-size: 17px;");

        // Add "open" - "save" buttons
        var noteBtn = '<button id="makeSnote" type="button" class="btn btn-default btn-sm btn-small" data-event="something" tabindex="-1"><i class="fa fa-file-text "></i></button>';            
        var fileGroup = '<div class="note-file btn-group">' + noteBtn + '</div>';
        $(fileGroup).appendTo($('.note-toolbar'));
        // Button tooltips
        $('#makeSnote').tooltip({container: 'body', placement: 'bottom'});
        // Button events
        $('#makeSnote').click(function(event) {
          var fragment_id = editLocalStorage.getItem('last_fragment_id');

          var range = window.getSelection().getRangeAt(0);
          var node = $(range.commonAncestorContainer);

          if (node.parent().is('span')) {
            node.unwrap();
          }
          
          $('span.fragment_id_' + fragment_id).each(function(){
            $(this).replaceWith(this.childNodes);
          });

          var color = getRandomColor();

          node = $('<span style="color:' + color + '" rel="' + fragment_id + '" class="fragment_id fragment_id_' + fragment_id + '" />')[0];
          $('.copy_fragment_' + fragment_id ).prev().prev().css('background-color', color ).css('font-weight','bold');

          range.surroundContents(node);

          // a hack to force a save event
          editor.summernote('editor.insertText', '');
        });
      }
    }
  });
}

function getRandomColor() {
  var letters = '0123456789ABCDEF';
  var color = '#';
  for (var i = 0; i < 6; i++ ) {
    color += letters[Math.floor(Math.random() * 16)];
  }
  return color;
}

function contentEditSummernote(editor_selector) {
  var editor = $(editor_selector);
  editor.summernote({
    height: 300,
    focus: false,
    fontNames: ['Arial','Roboto Slab','Slabo 27px'],
    callbacks : {
      onInit: function() {
        var style = $(".note-editable.panel-body").attr('style');
        $(".note-editable.panel-body").attr("style", style + " font-family: 'Slabo 27px', serif;font-size: 17px;");
      },
      onImageUpload: function(files) {
        sendFile(files[0],this);
      },
    }
  });
}

function getParameterByName(name) {
    var match = RegExp('[?&]' + name + '=([^&]*)').exec(window.location.search);
    return match && decodeURIComponent(match[1].replace(/\+/g, ' '));
}

