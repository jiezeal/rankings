@extends('web.app')
@section('content')
    <div class="jumbotron">
        @inject('discussionPresenter', 'App\Presenters\DiscussionPresenter')
        <div class="container forum-show">
            <div class="media">
            <div class="media-left">
            <a href="#">
              <img class="media-object img-circle avatar" src="{{ $discussionPresenter->user($discussion)->avatar }}" alt="">
            </a>
            </div>
            <div class="media-body">
            <h4 class="media-heading">{{ $discussion->title }}
                @if(Auth::check() && Auth::user()->id == $discussion->user_id)
                    <a class="btn btn-primary btn-lg pull-right" href="/web/index/{{ $discussion->id }}/edit" role="button">修改帖子</a>
                @endif
            </h4>
            {{ $discussionPresenter->user($discussion)->name }}
            </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-9" role="main">
                @inject('markdown', 'App\MarkDown\MarkDown');
                <div class="blog-post">
                    {!! $markdown->markdown($discussion->body) !!}
                </div>
            </div>
        </div>
    </div>
@stop