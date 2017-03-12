@extends('web.app')
@section('content')
    <div class="jumbotron">
        <div class="container forum-show">
            <div class="media">
                <div class="media-left">
                    <a href="#">
                        <img class="media-object img-circle avatar" src="{{ $discussion->user->avatar }}" alt="">
                    </a>
                </div>
                <div class="media-body">
                    <h4 class="media-heading">{{ $discussion->title }}</h4>
                    {{ $discussion->user->name }}
                </div>
            </div>
        </div>
    </div>
    <div class="container ranking-show">
        <div class="row">
            <div class="col-md-12" role="main">
                @forelse($discussion->rankings as $ranking)
                    <dl>
                        <dt><img class="avatar img-circle" src="{{ $ranking->user->avatar }}" alt=""></dt>
                        <dd>{{ $ranking->user->name }}</dd>
                    </dl>
                @empty
                    暂无数据
                @endforelse
            </div>
        </div>
    </div>
@stop