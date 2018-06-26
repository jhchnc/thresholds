<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Thresholds') }}</title>
</head>

@if(Request::path() == 'about')
    <body class="about">
@else
    <body class=" {{ $classname }} {{ implode(' ',explode('.',Route::currentRouteName())) }}">
@endif
    <div id="app" style="position:relative;left:-9999px;">

        <div class="navbar-simple">
            <!-- <a class="btn-issue btn btn-default btn-xs" href="/issue/{{ $current_issue_id }}">{{ $current_issue_title }}</a> -->
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
        </div>

        @yield('content')

    </div>

    <script src="/js/all.js"></script>
    <script>
        $(document).ready(function() {
            @yield('scripts')
        });
    </script>

    <!-- Google Fonts embed code -->
    <script type="text/javascript" async>
        (function() {
            var link_element = document.createElement("link"),
                s = document.getElementsByTagName("script")[0];
            if (window.location.protocol !== "http:" && window.location.protocol !== "https:") {
                link_element.href = "http:";
            }
            link_element.href += "//fonts.googleapis.com/css?family=Roboto+Slab:100,300,400,700|Slabo+27px|Permanent+Marker";
            link_element.rel = "stylesheet";
            link_element.type = "text/css";
            s.parentNode.insertBefore(link_element, s);
        })();
    </script>

    <!-- Google Analytics -->
    <script async>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-100760975-1', 'auto');
    ga('send', 'pageview');
    </script>
    <!-- End Google Analytics -->

    <link href="https://use.fontawesome.com/releases/v5.0.4/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/all.css" />
    <style>
        @yield('styles')
    </style>

</body>
</html>

