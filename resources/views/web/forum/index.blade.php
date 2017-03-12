@extends('web.app')
@section('content')
    <div class="jumbotron">
        <div class="container">
            <h2>欢迎来到Laravel App社区！<a class="btn btn-primary btn-lg pull-right" href="/web/index/create" role="button">发表新帖子</a></h2>
        </div>
    </div>
    <div class="container forum-index">
        <div class="row">
            <div class="col-md-9" role="main">
                @foreach($discussions as $discussion)
                    <div class="media">
                    <div class="media-left">
                    <a href="#">
                      <img class="media-object img-circle avatar" src="{{ $discussion->user->avatar }}" alt="">
                    </a>
                    </div>
                    <div class="media-body">
                    <h4 class="media-heading">
                        <a href="/web/index/{{ $discussion->id }}">{{ $discussion->title }}</a>
                        <small class="pull-right">
                            <i class="fa fa-heart-o rankings-btn"></i>
                            <a href="#" class="rankings"> 点赞排行</a>
                        </small>
                    </h4>
                    {{ $discussion->user->name }}
                    </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{ asset('web/js/forum/index.js') }}"></script>
@stop