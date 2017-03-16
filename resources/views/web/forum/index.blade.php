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
                @forelse($discussions as $discussion)
                    <div class="media">
                    <div class="media-left">
                    <a href="#">
                      <img class="media-object img-circle avatar" src="{{ $discussion->user->avatar }}" alt="">
                    </a>
                    </div>
                    <div class="media-body">
                    <h4 class="media-heading">
                        <a href="/web/index/{{ $discussion->id }}">{{ $discussion->title }}</a>
                        @inject('discussionPresenter', 'App\Presenters\DiscussionPresenter')
                        @if(Auth::user())
                            <small class="pull-right">
                                <i class="fa {{ $discussionPresenter->is_ranking($discussion->rankings, Auth::user()->id) ? 'fa-heart' : 'fa-heart-o' }} rankings-btn" data-uid='{{ Auth::user()->id }}' data-did="{{ $discussion->id }}"></i>
                            </small>
                        @endif
                    </h4>
                    {{ $discussion->user->name }}
                    </div>
                    </div>
                @empty
                    暂无数据
                @endforelse

                <div class="page pull-right mt-30">
                    {{ $discussions->render() }}
                </div>
            </div>
        </div>
    </div>
@stop

@section('script')
    <script src="{{ asset('web/js/forum/index.js') }}"></script>
@stop