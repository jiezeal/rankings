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
                    <h4 class="media-heading">{{ $discussion->title }}</h4>
                    {{ $discussionPresenter->user($discussion)->name }}
                </div>
            </div>
        </div>
    </div>
    <div class="container ranking-show">
        @inject('rankingPresenter', 'App\Presenters\RankingPresenter')
        <div class="row">
            <div class="col-md-12" role="main">
                @forelse($rankingPresenter->rankings($discussion) as $ranking)
                    <dl>
                        <dt><img class="avatar img-circle" src="{{ $ranking->avatar }}" alt=""></dt>
                        <dd>{{ $ranking->name }}</dd>
                    </dl>
                @empty
                    暂无数据
                @endforelse
            </div>
        </div>
    </div>
@stop