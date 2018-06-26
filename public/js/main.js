var breakpoint = '800';
var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
var scrollers = {};
var scroller_count = 0;
var IssueArticles = null

// Listen for orientation changes
window.addEventListener("orientationchange", function() {
  window.location.reload();
}, false);
// Listen for resize changes
window.addEventListener("resize", function() {
  window.location.reload();
}, false);

$('document').ready(function(){
  var body = $('body');
  // if( body.is('.about') ) {
  //   return;
  // }

  IssueArticles = $('#main .panel-body .article');
  IssueArticles.each(function(){
    var article = $(this);
    var url = article.data('url');
    var index = scroller_count;
    article.attr('id',index);
    scroller_count++;
  });

  var main_panel_body = $('#main .panel-body');
  main_panel_body.flexslider({
    selector: '.article',
    animation: 'fade',
    animationSpeed: 0,
    slideshow: false,
    useCSS: true,
    maxItems: 0,
    touch: false,
    after: function(slider){
      refreshScrollingArticleWithFragments(slider.currentSlide);
      var bottom_links = $('.article_toc_bottom li');
      bottom_links.removeClass('active');
      bottom_links.eq(slider.currentSlide).addClass('active');
    },
    start: function(slider){
      hideHomepageRightChevron(slider.currentSlide);
      refreshScrollingArticleWithFragments(slider.currentSlide);
      renderIssueTOC(slider);
      renderSlideArrows(slider,body);

      // bring app into the viewport
      $('#app').css('left',0);

      bodywidthRender();

      // load page from init_article classname
      var load_article = $('.article.init_article');
      var position = load_article.index();
      $('.article_toc_bottom a').eq(position).trigger('click');

      if ($('body').is('.issue_single')) {
        clientSideArticleManagement(position);
      }

      preventHomepageLazyLoading();

    },
  });
});

function setDataTop(article) {
  // align related elements
  var markers = article.find('.fragment_id');
  markers.each(function(){
    var marker = $(this);
    marker.removeClass('fragment_id');
    var m = marker.attr('class');
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
  var width = $(window).width();
  article_left = article.find('.article-left');
  article_right = article.find('.article-right');
  article.css('height',article_height);
  if( width > breakpoint ) {
    // set left/right heights to window height
    article_left.css('min-height',article_height).css('width',width/2);
    article_right.css('height',article_height).css('width',width/2);
  } else {
    // set left/right heights to window height
    article.css('height',article_height);
    article_left.css('height',article_height/2 ).css('width',width);
    article_right.css('height',article_height/2).css('width',width);
  }
  article_right.addClass('with_bg');
}

function initScrollingArticleWithFragments(article,index) {

  // var article_height = $(window).height()-40;
  var article_height = $(window).height();
  setInitArticleHeight(article_height,article);
  setDataTop(article);
  var width = $(window).width();
  article_left = article.find('.article-left');
  article_right = article.find('.article-right');

  // sanity check -- make sure no fragments are off-screen
  if( width > breakpoint ) {
    var article_wrapper_height = article_left.height();
    var last_fragment = article.find('.article-right div.fragment').eq(article.find('.article-right div.fragment').length-1);
    if( last_fragment.data('top') + last_fragment.height() > article_height ) {
      var offset = last_fragment.data('top') + last_fragment.height() - article_left.height();
      article_wrapper_height += offset;
      article_wrapper_height += 50;
      article.find('.article-right-wrapper').height(article_wrapper_height);
    }
  }

  // Initialize scrolling
  var Article = false;
  if( article.get(0) ) {

    var _probeType = 2;
    if( width > breakpoint ) {
      if (
        navigator.userAgent.toLowerCase().match(/(ipad|iphone)/)
        && navigator.userAgent.indexOf('Safari') != -1 
        && navigator.userAgent.indexOf('Chrome') == -1 
        && navigator.userAgent.indexOf('Android') == -1
        ) {
          // this is a mobile safari browser. force CPU optimization
          _probeType = 2;
      } else {
        // this is a regular desktop we hope. go full CPU
        _probeType = 3;
      }
      var Article = new IScroll( article.get(0), {
        mouseWheel: true,
        scrollbars: true,
        interactiveScrollbars: true,
        probeType: _probeType,
        click: true,
        // snap: 'p',
      });
    } 
    else {
      var Article = new IScroll( article_left.get(0), {
        // mouseWheel: true,
        scrollbars: true,
        interactiveScrollbars: true,
        probeType: _probeType,
        disablePointer: true, // important to disable the pointer events that causes the issues
        disableTouch: false, // false if you want the slider to be usable with touch devices
        disableMouse: false, // false if you want the slider to be usable with a mouse (desktop)
        click: true,
      });
    }
  }

  var ArticleRight = false;
  if( article_right.length ) {

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

      if( (Math.abs(this_y) - trigger_top) >= 0 - fixed_fragment_offset ) {
        if( marker.is('.fixedforever') ) {
          var top = Math.abs(this_y) + 'px';
          marker.attr('style','top:' + top + ';');
        } 
        else {
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
        // console.log('avoid duplication bug');
        // var top = marker.data('top');
        // marker.css('top',top);
        marker.removeClass('pinned');
      }

    });  

    // prevent collisions
    var all_fragments = article.find('.fragment');
    all_fragments.each(function(){
      var fragment = $(this);
      var prev_fragment = fragment.prev('div.fragment');
      if( prev_fragment.length > 0 ) {
        var prev_fragment_height = prev_fragment.height() + parseInt(prev_fragment.css('padding-top')) + parseInt(prev_fragment.css('padding-bottom'));
        if ( parseInt(fragment.css('top')) <= parseInt(prev_fragment.css('top')) + prev_fragment_height ) {
          if( prev_fragment.is('.fixedforever') ) {
            prev_fragment.css('opacity','.85');
          }
          else {
            var offset = parseInt(prev_fragment.css('top')) + prev_fragment_height + 10;
            fragment.attr('style','top:' + offset + 'px;');
          }
        }
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

function clientSideArticleManagement(position) {
  IssueArticles.each(function(){
    var a = $(this);
    var alias = a.data('alias');

    if(a.attr('id') == position) {
      history.pushState(null, null, alias);
      clientSideArticle(a,position);

      var position_left = position - 1;
      if(position === 0) {
        position_left = scroller_count-1;
      }
      var a_left = IssueArticles.eq(position_left);
      clientSideArticle(a_left,position_left);

      var position_right = position + 1;
      if(position === scroller_count-1) {
        position_right = 0;
      }
      var a_right = IssueArticles.eq(position_right);
      clientSideArticle(a_right,position_right);

      IssueArticles.each(function(){
        var art = $(this);
        var art_id = parseInt(art.attr('id'),10);
        var save = [position_left,position,position_right];
        if( $.inArray(art_id,save) === -1 ) {
          art.css('background-image','');
          var left = art.find('.article-left-wrapper');
          var right = art.find('.article-right-wrapper');
          left.html('');
          right.html('');
        }
      });

    }
  });
}

function clientSideArticle(article, position) {
  var a = article;
  a.css('background-image', a.attr('data-background')); // hotswap the background image to improve load times
  var left = a.find('.article-left-wrapper');
  var right = a.find('.article-right-wrapper');
  // 
  left.html(IssueArticlesCache[a.attr('id')]['left']);
  right.html(IssueArticlesCache[a.attr('id')]['right']);
  // 
  if( IssueArticlesCache[a.attr('id')]['active'] === 0 ) {
    initScrollingArticleWithFragments( a, position );
    $(function () {
      a.tooltip({ selector: '[data-toggle=tooltip]', trigger: "click" });
    });
  } else {
    setDataTop(article);
    positionFragments(a,scrollers[position]['Article'].y);
    pageRender(a,position);
  }
  IssueArticlesCache[a.attr('id')]['active'] = 1;
  $(function() {
      function imageLoaded() {
          counter--; 
          if( counter === 0 ) {
            setTimeout(function () {
              scrollers[position]['Article'].refresh();
            }, 200);
            IssueArticlesCache[a.attr('id')]['left'] = left.html();
            IssueArticlesCache[a.attr('id')]['right'] = right.html();
          }
      }
      var imgs = a.find('[data-lazyload="true"]');
      var counter = imgs.length;
      imgs.each(function(){
        var img = $(this);
        img.attr('src',img.attr('data-original'));
        img.removeClass('.lazyload');
        if( this.complete ) {
            imageLoaded.call( this );
        } else {
            $(this).one('load', imageLoaded);
        }
      });
  });
}

function renderIssueTOC(slider) {
  // TOC
  var article_toc_bottom = $('.article_toc_bottom');
  article_toc_bottom.append($('.flex-control-nav').html());
  article_toc_bottom.find('li').eq(0).addClass('active');
  // Convert individual slide links into a navigation
  $('.article_toc_bottom li a,.article_toc_left li a').each(function(){
    var a = $(this);
    a.click(function(e){
      var prev_left = $('.prev_left');
      var prev_right = $('.prev_right');
      var next_left = $('.next_left');
      var next_right = $('.next_right');
      $('.half').removeClass('half');
      if( prev_left.length ) {
        prev_left.removeClass('prev_left');
        prev_right.removeClass('prev_right');
      }
      if( next_left.length ) {
        next_left.removeClass('next_left');
        next_right.removeClass('next_right');
      }
      var link = $(this).parent();
      var position = link.index();
      $('.flex-control-nav li').eq(position).find('a').click();
      
      bodywidthRender();
      clientSideArticleManagement(position);
      e.preventDefault();
    });
  });
}

function renderSlideArrows(slider,body) {
  // Convert prev/next into a half-step transition
  body.append( '<div class="half_slide_controls">' + $('.flex-direction-nav').html() + '</div>' );
  var flex_prev = $('.flex-nav-prev .flex-prev');
  var flex_next = $('.flex-nav-next .flex-next');
  flex_prev.html('<i class="fa fa-chevron-left" aria-hidden="true"></i>');
  flex_next.html('<i class="fa fa-chevron-right" aria-hidden="true"></i>');
  renderNextArrow(slider,flex_next);
  renderPreviousArrow(slider,flex_prev);
}

function renderNextArrow(slider,flex_next) {
  flex_next.unbind('click').click(function(){
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
    clientSideArticleManagement(next.index());
    hideHomepageRightChevronClick(nav_item);
    hideHomepageLeftChevronClick(nav_item);
    return false;
  });
}

function renderPreviousArrow(slider,flex_prev) {
  flex_prev.unbind('click').click(function(){
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
    clientSideArticleManagement(prev.index());
    hideHomepageRightChevronClick(nav_item);
    hideHomepageLeftChevronClick(nav_item);
    return false;
  });
}

function preventHomepageLazyLoading() {
  if( $('body').is('.issue_home') ) {
    $(function() {
        function imageLoaded() {
            counter--; 
            if( counter === 0 ) {
              scrollers[position]['Article'].refresh();
            }
        }
        var imgs = $('.lazyload');
        var counter = imgs.length;
        imgs.each(function(){
          var img = $(this);
          img.attr('src',img.attr('data-original'));
          img.removeClass('.lazyload');
          if( this.complete ) {
              imageLoaded.call( this );
          } else {
              $(this).one('load', imageLoaded);
          }
        });
    });
  }
}

var prevIndx = 0;
function hideHomepageRightChevronClick(target) {
  if( $('body').is('.issue_home') ) {
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
