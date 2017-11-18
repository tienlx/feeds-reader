@extends('layouts.app')

@section('content')

    <div class="container">
        <h1><a href="{!! URL::action('RssFeedController@index') !!}">Feeds List</a></h1>
        <a class="btn btn-default" href="{!! URL::action('RssFeedController@create') !!}" role="button">Create</a>
        <hr>
        @if (session('message-success'))
            <div class="alert alert-success">
                {{ session('message-success') }}
            </div>
        @endif
        <form class="form-inline" method="GET" action="{!! URL::action('RssFeedController@index') !!}">
            <div class="form-group">
                <input type="text" class="form-control" name="search_category" id="search_category" placeholder="Category Name" value="{{ $search_category }}">
            </div>
            <button type="submit" class="btn btn-default">Search</button>
        </form>
        <hr>
        @foreach ($models as $model)
        <div class="model-item panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">{{ $model->title }}</h3>
            </div>
            <div class="panel-body">
                <p>Link: {{ $model->link }}</p>
                <p>Categories: {{ $model->categories }}</p>
                <p>Publish Date: {{ $model->pub_date }}</p>
                <p>GUID: {{ $model->guid }}</p>
            </div>
            <div class="panel-footer">
                <div class="text-right">
                    <a class="btn btn-default" href="{!! URL::action('RssFeedController@show', $model->id) !!}" role="button">Edit</a>
                    <a class="btn btn-default delete-button" href="#" data-delete-url="{!! URL::action('RssFeedController@destroy', $model->id) !!}" role="button">Delete</a>
                </div>
            </div>
        </div>
        @endforeach
        @if (isset($search_category))
            {{ $models->appends(['search_category' => $search_category])->links() }}
        @else
            {{ $models->links() }}
        @endif
    </div>
@stop