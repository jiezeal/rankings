@extends('web.app')
@section('content')
    <div class="container forum-create mt-15">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" role="main">
                @if($errors->any())
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                {!! Form::open(['url'=>'/web/index']) !!}
                    @include('web.forum.form')
                    {!! Form::submit('发表帖子',['class'=>'btn btn-primary pull-right']) !!}
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop