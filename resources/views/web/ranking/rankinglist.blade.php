@extends('web.app')
@section('content')
    <div class="jumbotron">
        <div class="container">
            <h2>点赞排行榜</h2>
        </div>
    </div>
    <div class="container ranking-rankinglist">
        <div class="row">
            <div class="col-md-9" role="main">
                @forelse($rankings as $key => $ranking)
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="media-object img-circle avatar" src="{{ $ranking->discussion->user->avatar }}" alt="">
                            </a>
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading">
                                <a href="/web/index/{{ $ranking->discussion_id }}">{{ $ranking->discussion->title }}</a>
                                <small class="pull-right">
                                    <i class="fa fa-heart rankings-btn"></i>
                                    <a href="/web/ranking/{{ $ranking->discussion_id }}" class="rankings"><span class="ranking-count">{{ $ranking->count }}</span>次</a>
                                </small>
                            </h4>
                            {{ $ranking->discussion->user->name }}
                        </div>
                    </div>
                @empty
                    暂无数据
                @endforelse

                <div class="page pull-right mt-30">
                    {{ $rankings->render() }}
                </div>
            </div>
        </div>
    </div>
@stop