<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Thresholds') }}</title>

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

    <!-- Google Analytics -->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-100760975-1', 'auto');
    ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->

    <!-- Google Fonts embed code -->
    <script type="text/javascript">
        (function() {
            var link_element = document.createElement("link"),
                s = document.getElementsByTagName("script")[0];
            if (window.location.protocol !== "http:" && window.location.protocol !== "https:") {
                link_element.href = "http:";
            }
            link_element.href += "//fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Slabo+27px";
            link_element.rel = "stylesheet";
            link_element.type = "text/css";
            s.parentNode.insertBefore(link_element, s);
        })();
    </script>

    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

    <!-- bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">

    <!-- iscroll -->
    <script src="/js/iscroll/iscroll-probe.js"></script>

    <!-- custom -->
    <script src="/js/main.js"></script>
    <script src="/js/admin.js"></script>
    <link rel="stylesheet" href="/css/main.css" />

    <!-- flexslider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.6.3/jquery.flexslider-min.js"></script>

    <!-- font awesome -->
    <script src="https://use.fontawesome.com/45fb30cf5a.js"></script>

    <!-- include summernote css/js-->
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.css" rel="stylesheet">
    <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.2/summernote.js"></script>

    <style>
        @yield('styles')
    </style>

</head>
@if(Request::path() == 'about')
    <body class="about">
@else
    <body class=" {{ implode(' ',explode('.',Route::currentRouteName())) }}">
@endif
    <div id="app">

        <nav class="navbar navbar-default" style="height:40px;margin:0;border:none;">
          <div class="container-fluid">
            <div class="navbar-header logo-title">
              <h3>

                  <!-- <a href="/">Thresholds</a> -->
                <a href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>

              </h3>
            </div>
            <div class="navbar-header issue-title">
                <h3><a class="btn btn-default btn-xs" href="/issue/{{ $current_issue_id }}">Current Issue: <em>{{ $current_issue_title }}</em></a></h3>
            </div>
            <ul class="nav navbar-info navbar-right">
              <li class="dropdown">
                <!-- Authentication Links -->
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Contents <span class="caret"></span></a>
                <a class="dropdown-toggle-mobile" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                    @foreach ( $issues as $issue )
                        @if( $issue->is_published || !Auth::guest())
                            <li><a href="/issue/{{ $issue->id }}">{{ $issue->title }}</a></li> 
                        @endif
                    @endforeach
                    @if (Auth::guest())
                        <li><a href="/login">login</a></li>
                    @endif
                    @if (!Auth::guest())
                        @if( !(Auth::user()->email == 'reviewer@openthresholds.org') )
                            <li><a href="/volumes">Manage Content</a></li>
                        @endif
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                                Logout
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    @endif
                </ul>
              </li>
            </ul>
        </nav>

        @yield('content')

    </div>

    <script>
        $(document).ready(function() {
            @yield('scripts')
        });
    </script>
</body>
</html>

