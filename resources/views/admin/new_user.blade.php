@extends('layouts.app')

@section('title')
    Добавить пользователя
@endsection
<style type="text/css">
  .table td{
    font-size: 16px!important;
  }
</style>
@section('content')
    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
          <div class="card">
            <div class="card-header">
              <div class="row">
                <div class="col-md-12">
                  <h4 class="page-title text-center">Добавить пользователя</h4>
                </div>
              </div>
              @if(session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
              @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
@endsection