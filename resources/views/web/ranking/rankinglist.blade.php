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
                @inject('rankingPresenter', 'App\Presenters\RankingPresenter')
                @forelse($rankingPresenter->rankingSort($discussions) as $key => $value)
                    @foreach($value as $v)
                        <div class="media">
                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object img-circle avatar" src="{{ $v->user->avatar }}" alt="">
                                </a>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="/web/index/{{ $v->id }}">{{ $v->title }}</a>
                                    <small class="pull-right">
                                        <i class="fa fa-heart rankings-btn"></i>
                                        <a href="/web/ranking/{{ $v->id }}" class="rankings"><span class="ranking-count">{{ $key }}</span>次</a>
                                    </small>
                                </h4>
                                {{ $v->user->name }}
                            </div>
                        </div>
                    @endforeach
                @empty
                    暂无数据
                @endforelse
            </div>
        </div>
    </div>
@stop