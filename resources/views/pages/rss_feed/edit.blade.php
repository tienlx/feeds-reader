@extends('layouts.app')

@section('content')
    <div class="container">
        @if( $isNew )
            <h2>New</h2>
        @else
            <h2>Edit item {{ $model->id }}</h2>
        @endif
        <a class="btn btn-default" href="{!! URL::action('RssFeedController@index') !!}" role="button">Back</a>
        <hr>
        @if (session('message-success'))
            <div class="alert alert-success">
                {{ session('message-success') }}
            </div>
        @endif
        <form action="@if($isNew) {!! action('RssFeedController@store') !!} @else {!! action('RssFeedController@update', [$model->id]) !!} @endif" method="POST" enctype="multipart/form-data">
            @if( !$isNew ) <input type="hidden" name="_method" value="PUT"> @endif
            {!! csrf_field() !!}
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" class="form-control" id="title" placeholder="Title"
                        value="{{ old('title') ? old('title') : $model->title }}">
            </div>
            <div class="form-group">
                <label for="link">Link</label>
                <input type="text" name="link" class="form-control" id="link" placeholder="Link"
                       value="{{ old('link') ? old('link') : $model->link }}">
            </div>
            <div class="form-group">
                <label for="categories">Categories</label>
                <input type="text" name="categories" class="form-control" id="categories" placeholder="Categories"
                       value="{{ old('categories') ? old('categories') : $model->categories }}">
            </div>
            <div class="form-group">
                <label for="guid">GUID</label>
                <input type="text" name="guid" class="form-control" id="guid" placeholder="GUID"
                       value="{{ old('guid') ? old('guid') : $model->guid }}">
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="pub_date">Publish Date {{ $model->pub_date }}</label>
                    <div class='input-group date' id='pub_date'>
                        <input type='text' class="form-control" name="pub_date" value="{{ old('pub_date') ? old('pub_date') : $model->pub_date }}"/>
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>
@stop

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $('#pub_date').datetimepicker({
                'format': 'YYYY-MM-DD HH:mm:ss'
            });
        });
    </script>
@stop