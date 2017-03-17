<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laravel App</title>
    {{--<link rel="stylesheet" href="{{ asset('web/css/all.css') }}">--}}
    <link rel="stylesheet" href="{{ elixir('web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('web/css/font-awesome.css') }}">
</head>
<body>
    <nav class="navbar navbar-default navbar-static-top navbar-index">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/web/index">Laravel App</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="{{ Request::getPathInfo() == '/web/index' ? 'active' : '' }}"><a href="/web/index">首页</a></li>
                    <li class="{{ Request::getPathInfo() == '/web/ranking_list' ? 'active' : '' }}"><a href="/web/ranking_list">点赞排行</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    @if(Auth::user())
                        <li><a href="#">{{ Auth::user()->name }}</a></li>
                        <li><a href="/web/logout">退出登录</a></li>
                    @else
                        <li class="{{ Request::getPathInfo() == '/web/user/create' ? 'active' : '' }}"><a href="/web/user/create">注册</a></li>
                        <li class="{{ Request::getPathInfo() == '/web/login_interface' ? 'active' : '' }}"><a href="/web/login_interface">登录</a></li>
                    @endif
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>
    @yield('content')
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    <span>Copyright © <a href="#">朱林杰</a></span>
                </div>
            </div>
        </div>
    </div>
    <script src="http://cdn.bootcss.com/jquery/1.11.0-rc1/jquery.min.js"></script>
    <script src="{{ asset('lib/layer/layer.js') }}"></script>
    <script>
        $(function(){
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
            });
        });
    </script>
    @yield('script')
</body>
</html>