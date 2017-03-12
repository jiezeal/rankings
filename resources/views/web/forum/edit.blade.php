@extends('web.app')
@section('content')
    <div class="container mt-15">
        <div class="row">
            <div class="col-md-8 col-md-offset-2" role="main">
                @if($errors->any())
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
                {!! Form::model($discussion, ['method'=>'PATCH', 'url'=>'/web/index/'.$discussion->id]) !!}
                @include('web.forum.form')
                <div>
                    {!! Form::submit('更新帖子',['class'=>'btn btn-primary pull-right']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop