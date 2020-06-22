@extends('layouts.master')

@section('title')
   Edit Field Name
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Edit Field {{$fieldValue->field_name}}</h1>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form action="/manual-update/{{$fieldValue->id}}" method="POST">
                                {{ csrf_field( )}}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="field_name" value="{{ $fieldValue->field_name}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">Update</button>
                                    <a href="/manual" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection