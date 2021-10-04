@extends('layouts.app')

@section('title')
    Супер Админ
@endsection

@section('content')

    <div class="main-panel">
      <div class="content">
        <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title font-weight-bold text-center">Передача полномочий супер админа</h3>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body col-md-6" id="items">
                        <form action="{{ url('admin/super_admin') }}" method="POST">
                            @csrf
                            <div class="form-group" style="padding: 0px">
                                <label data-error="wrong" data-success="right" for="email"><b>Введите email нового супер админа</b></label><br/>
                                <input type="email" id="email" name="email" required autocomplete="email" class="form-control"/>
                            </div>
                            <div class="form-group" style="color: red;padding: 0px;">
                                После передачи полномочий, вы теряете возможности супер админа.
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">Передать полномочия</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection