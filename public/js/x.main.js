var breakpoint = '800';
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
var scrollers = {};
var scroller_count = 0;

function setDataTop(article) {
  // align related elements
  var markers = article.find('.fragment_id');
  markers.each(function(){
    var marker = $(this);
    marker.removeClass('fragment_id');
    var m = $(this).attr('class');
    var top = article.find('.'+m).offset().top;
    top = top - $('.navbar').eq(0).height();
    top = top - $('.panel-body').eq(0).css('padding-top').replace('px','') - $('.panel-body').eq(0).css('margin-top').replace('px','');
    top = top - parseInt(article.find('.article-right').css('padding-top'));
    article.find('#'+m).css('top',top);
    article.find('#'+m).attr('data-top',top);
  });
}

function pageRender(article,index) {
  if (scrollers[index]['Article']) {
    setTimeout(function () {
      scrollers[index]['Article'].refresh();
    }, 1);
  }
}

function setInitArticleHeight(article_height,article) {
  if( $(window).width() > breakpoint ) {
    // set left/right heights to window height
    article.find('.article-left').css('min-height',article_height);
    article.find('.article-right').css('height',article_height);
    article.css('height',article_height);
  } else {
    // set left/right heights to window height
    article.css('height',article_height);
    article.find('.article-left').css('height',article_height/2 );
    article.find('.article-right').css('height',article_height/2);
  }
  article.find('.article-right').addClass('with_bg');
  var width = $(window).width();
  if( $(window).width() <= breakpoint ) {
    article.find('.article-left,.article-right').css('width',width);
  } else {
    article.find('.article-left,.article-right').css('width',width/2);
  }
}

// Listen for orientation changes
window.addEventListener("orientationchange", function() {
  // Announce the new orientation number
  // alert(screen.orientation);
  // reload the page
  window.location.reload();
}, false);

window.addEventListener("resize", function() {
    // Get screen size (inner/outerWidth, inner/outerHeight)

  window.location.reload();
}, false);

function initScrollingArticleWithFragments(article,index) {

  // var article_height = $(window).height()-40;
  var article_height = $(window).height();
  setInitArticleHeight(article_height,article);
  setDataTop(article);

  // sanity check -- make sure no fragments are off-screen
  if( $(window).width() > breakpoint ) {
    var article_wrapper_height = article.find('.article-left').height();
    var last_fragment = article.find('.article-right div.fragment').eq(article.find('.article-right div.fragment').length-1);
    if( last_fragment.data('top') + last_fragment.height() > article_height ) {
      var offset = last_fragment.data('top') + last_fragment.height() - article.find('.article-left').height();
      article_wrapper_height += offset;
      article_wrapper_height += 50;
      article.find('.article-right-wrapper').height(article_wrapper_height);
    }
  }

  // Initialize scrolling
  var Article = false;
  if( article.get(0) ) {
    if( $(window).width() > breakpoint ) {
      var Article = new IScroll( article.get(0), {
        mouseWheel: true,
        scrollbars: true,
        interactiveScrollbars: true,
        probeType: 3,
        // snap: 'p',
      });
    } 
    else {
      var Article = new IScroll( article.find('.article-left').get(0), {
        // mouseWheel: true,
        scrollbars: true,
        interactiveScrollbars: true,
        probeType: 3,
        disablePointer: true, // important to disable the pointer events that causes the issues
        disableTouch: false, // false if you want the slider to be usable with touch devices
        disableMouse: false, // false if you want the slider to be usable with a mouse (desktop)

      });
    }
  }

  var ArticleRight = false;
  if( article.find('.article-right').length ) {

    // setup the left and ride sides so that the DOM elements are in same order
    var all_fragments = article.find('.fragment');
    all_fragments.each(function(){
      var fragment = $(this);
      var trigger = article.find('.' + fragment.attr('id'));
      trigger.addClass('fragment_id_trigger');
    });
    var all_triggers = article.find('.fragment_id_trigger');
    all_triggers.each(function(){
      var trigger = $(this);
      var fragment = article.find('#fragment_id_' + trigger.attr('rel'));
      fragment.parent().append(fragment);
    });

    var ArticleRight = new IScroll( article.find('.article-right').get(0), {});
    Article.on('scroll', function () {
      // get the current scroll position
      var this_y = this.y;

      ArticleRight.scrollTo(0, this.y);

      var article_title = article.find('.article-title');
      if( this_y < -400 ) {
        if( article_title.is(':visible') ) {
          article_title.slideUp(200);
        }
      } else {
        if( article_title.is(':visible') ) {
        } else {
          article.find('.article-title').slideDown(100);
        }
      }

      positionFragments(article,this_y);

      // prevent collisions
      var all_fragments = article.find('.fragment');
      all_fragments.each(function(){
        var fragment = $(this);
        var prev_fragment = fragment.prev('div.fragment');
        if( prev_fragment.length > 0 ) {
          var prev_fragment_height = prev_fragment.height() + parseInt(prev_fragment.css('padding-top')) + parseInt(prev_fragment.css('padding-bottom'));
          if ( parseInt(fragment.css('top')) <= parseInt(prev_fragment.css('top')) + prev_fragment_height ) {
            // console.log( parseInt(fragment.css('top')) );
            // console.log( parseInt(prev_fragment.css('top')) );
            // console.log( prev_fragment_height );
            // console.log('hi');
            if( prev_fragment.is('.fixedforever') ) {
              prev_fragment.css('opacity','.85');
            }
            else {
              var offset = parseInt(prev_fragment.css('top')) + prev_fragment_height + 10;
              fragment.attr('style','top:' + offset + 'px;');
              // console.log('collide');
            }
          }
        }
      });

    });
    ArticleRight.disable();
  }

  var article_set = {};
  article_set['Article'] = Article;
  scrollers[index] = article_set;

  pageRender(article,index);

}

function positionFragments(article,this_y) {
    // align related elements
    var fixed_markers = article.find('.fixed');
    fixed_markers.each(function(){
      var marker = $(this);
      var trigger = article.find('.' + marker.attr('id'));
      trigger_top = trigger.position().top;
      var article_right_padding_top = article.find('.article-right').css('padding-top');
      var fixed_fragment_offset = parseInt(article_right_padding_top);
      var marker_height = marker.height() + parseInt(marker.css('padding-top')) + parseInt(marker.css('padding-bottom'));

      // console.log('a');
      if( (Math.abs(this_y) - trigger_top) >= 0 - fixed_fragment_offset ) {
        // console.log('b');
        if( marker.is('.fixedforever') ) {
          // console.log('c');
          var top = Math.abs(this_y) + 'px';
          marker.attr('style','top:' + top + ';');
        } 
        else {
          // console.log('c2');
          var next_fragment = marker.next('div.fragment');
          if ( (marker.position().top + marker_height) + 10 >= next_fragment.data('top') ) {
            if ( (Math.abs(this_y) + marker_height ) <=  next_fragment.data('top') ) {
              marker.attr('style','top:' + Math.abs(this_y) + 'px;');
              marker.removeClass('pinned');
            } else {
              var top = next_fragment.data('top') - marker_height - 10 + 'px';
              marker.attr('style','top:' + top + ';');
            }
          } else {
            if( !marker.is('.pinned')) {
              marker.attr('style','top:' + Math.abs(this_y) + 'px;');
            }
          }
        }
      } else {
          // console.log('d');
        // console.log('avoid duplication bug i\'m seeing');
        // var top = marker.data('top');
        // marker.css('top',top);
        marker.removeClass('pinned');
      }

    });  
}

function refreshScrollingArticleWithFragments(index) {
  var article = $('.article').eq(index);
  if ( !article.is('.rendered') && scrollers[index] ) {
    article.addClass('rendered');
    pageRender(article,index);
  }
}

$(window).load(function(){
});

$('document').ready(function(){

  if( $('body').is('.home') || $('body').is('.about') ) {
    return;
  }

  // prevent race conditions
  $('#main .panel-body .article').each(function(){
    var article = $(this);
    article.attr('id',scroller_count);
    scroller_count++;
  });

  $('#main .panel-body').flexslider({
    selector: '.article',
    animation: 'fade',
    // animation: 'slide',
    animationSpeed: 0,
    slideshow: false,
    useCSS: true,
    maxItems: 0,
    // smoothHeight: true,
    // before: function(slider) {
    //   alert(slider.currentSlide);      
    // },
    after: function(slider){
      refreshScrollingArticleWithFragments(slider.currentSlide);
      for( var i = 0; i <= $('#main .panel-body .article').length; i++ ) {
        $('.article_toc_bottom li').removeClass('active');
        $('.article_toc_bottom li').eq(slider.currentSlide).addClass('active');
      }
    },
    start: function(slider){
      hideHomepageRightChevron(slider.currentSlide);
      refreshScrollingArticleWithFragments(slider.currentSlide);
      // TOC
      var article_toc_bottom = $('.article_toc_bottom');
      article_toc_bottom.append($('.flex-control-nav').html());

      // adjust heights
      article_toc_bottom.find('li').eq(0).addClass('active');
      // article_toc_bottom.css('height',$(window).height()-50);

      // Convert individual slide links into a navigation
      $('.article_toc_bottom li a,.article_toc_left li a').each(function(){
        var a = $(this);
        a.click(function(e){
          $('.half').removeClass('half');
          if( $('.prev_left').length ) {
            $('.prev_left').removeClass('prev_left');
            $('.prev_right').removeClass('prev_right');
          }
          if( $('.next_left').length ) {
            $('.next_left').removeClass('next_left');
            $('.next_right').removeClass('next_right');
          }
          var link = $(this).parent();
          var position = link.index();
          $('.flex-control-nav li').eq(position).find('a').click();
          bodywidthRender();

          var obj = {};
          var articles = {};
          for (var i = 0; i < Object.keys(scrollers).length; i++) {
            let scroller = scrollers[i];
            let article = {};
            article['y'] = Math.abs(scroller.Article.y);
            $('.article').each(function(){
              var a = $(this);
              if(a.attr('id') == i) {
                var url = a.data('url');
                var title = a.find('.article-title span').text();
                article['url'] = url;
                article['title'] = title;
              }
            });
            articles[article['url']] = article;
          }
          obj.articles = articles;

          $('.article').each(function(){
            var a = $(this);
            if(a.attr('id') == position) {
              obj.url = a.data('url');
              obj.title = a.find('.article-title span').text();
            }
          });
          // console.log(obj);

          let objJsonStr = JSON.stringify(obj);
          let encodedString = Base64.encode(objJsonStr);
          history_url = window.location.pathname + '?state=' + encodedString;
          history.pushState(obj, obj.title, history_url);
          e.preventDefault();

        });
      });
      // Convert prev/next into a half-step transition
      // DOM
      $('body').append( '<div class="half_slide_controls">' + $('.flex-direction-nav').html() + '</div>' );
      $('.flex-nav-prev .flex-prev').html('<i class="fa fa-chevron-left" aria-hidden="true"></i>');
      $('.flex-nav-next .flex-next').html('<i class="fa fa-chevron-right" aria-hidden="true"></i>');
      // NEXT
      $('.flex-nav-next .flex-next').unbind('click').click(function(){
        bodywidthRender();
        var active = $('.flex-active-slide');
        var next = active.parent().find('.article').length-1 == active.index() ? active.parent().find('.article').eq(0) : active.next();
        var nav_item = $('.article_toc_bottom li').eq( next.index() );
        // remove "prev" behavior
        $('.half').removeClass('half');
        if( $('.prev_left').length ) {
          $('.prev_left').removeClass('prev_left');
          $('.prev_right').removeClass('prev_right');
        } else {
          // manage classes for sliding left and right
          if( active.is('.next_left') ) {
            active.removeClass('next_left');
            next.removeClass('next_right');
            slider.flexslider('next');
          } else {
            if( nav_item.index() == 0 ) {
              $('.article_toc_bottom li').removeClass('active');
            }
            nav_item.addClass('half');
            $('li.active').removeClass('active').addClass('half');

            active.addClass('next_left');
            next.addClass('next_right');
          }
        }
        hideHomepageRightChevronClick(nav_item);
        hideHomepageLeftChevronClick(nav_item);
        return false;
      });
      // PREV
      $('.flex-nav-prev .flex-prev').unbind('click').click(function(){
        bodywidthRender();
        var active = $('.flex-active-slide');
        var prev = active.index() == 0 ? active.parent().find('.article').eq(active.parent().find('.article').length-1) : active.prev();
        var nav_item = $('.article_toc_bottom li').eq( active.index() - 1 );
        // remove "next" behavior
        $('li.half').removeClass('half');
        if( $('.next_left').length ) {
          $('.next_left').removeClass('next_left');
          $('.next_right').removeClass('next_right');
        } else {
          // manage classes for sliding left and right
          if( active.is('.prev_right') ) {
            active.removeClass('prev_right');
            prev.removeClass('prev_left');
            slider.flexslider('prev');
          } else {
            nav_item.addClass('half');
            $('li.active').removeClass('active').addClass('half');

            active.addClass('prev_right');
            prev.addClass('prev_left');
          }
        }
        hideHomepageRightChevronClick(nav_item);
        hideHomepageLeftChevronClick(nav_item);
        return false;
      });

      bodywidthRender();
    
      // loadpagefrombase64
      var encodedString = getParameterByName('state');
      if( encodedString ) {
        var decodedString = Base64.decode(encodedString);
        var obj = JSON.parse(decodedString);
        var load_article = $('.article[data-url="' + obj.url + '"]');
        var position = load_article.index();
        $('.article_toc_bottom a').eq(position).trigger('click');
        for (var i = 0; i < Object.keys(scrollers).length; i++) {
          var scroller = scrollers[i];
          if( position == i ) {
            var articles = obj.articles;
            // console.log(articles);
            var article = articles[obj.url];
            // console.log(article);
            scroller.Article.scrollTo(0,-article.y);
            scroller.Article.refresh();
            // scroller.Article.scroll();
          }
        }
      }
    },
  });

});

var prevIndx = 0;
function hideHomepageRightChevronClick(target) {
  if( $('body').is('.issue_home') ) {
    // console.log(target);
    // console.log(target.index());
    if( target.is('.half') ) {
      $('.flex-next').show();
    } else {
      if( target.is('.active') ) {
        if( target.index() == 1 ) {
          $('.flex-next').show();
        } else {
          $('.flex-next').hide();
        }
      } else {
        if( target.index() == 1 && prevIndx == target.index() ) {
          $('.flex-next').hide();
        } else {
          $('.flex-next').show();
        }
      }
    }
  }
  prevIndx = target.index();
}

function hideHomepageLeftChevronClick(target) {
  if( $('body').is('.issue_home') ) {
    // console.log(target);
    // console.log(target.index());
    if( target.is('.half') ) {
      $('.flex-prev').show();
    } else {
      if( target.is('.active') ) {
        if( target.index() == 0 ) {
          $('.flex-prev').show();
        } else {
          $('.flex-prev').hide();
        }
      } else {
        if( target.index() == 0 && prevIndx == target.index() ) {
          $('.flex-prev').hide();
        } else {
          $('.flex-prev').show();
        }
      }
    }
  }
  prevIndx = target.index();
}


function hideHomepageRightChevron(target) {
  if( $('body').is('.issue_home') ) {
    if( target === 0 ) {
      $('.flex-next').hide();
    }
  }
}

function bodywidthRender() {
  $('#main .panel-body').css('overflow','hidden');
  $('#app').css('opacity',1);
}


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

