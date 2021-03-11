@extends('layouts.app')

@section('title')
    Данные
@endsection

@section('content')
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Данные</h4>
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            {{--{{dd($aEgknRaws)}}--}}
                            @if (isset($aEgknRaws) && count($aEgknRaws)>0)
                                <h4>Данные для полей</h4>
                                <br> <label for="id">id</label> {{$aEgknRaws['id']}}
                                <br> <label for="request_number">request_number</label> {{$aEgknRaws['request_number']}}
                                <br> <label for="request_number">request_number</label> {{$aEgknRaws['request_number']}}
                                <br> <label for="IIN">IIN</label> {{$aEgknRaws['IIN']}}
                                <br> <label for="egkn_status">egkn_status</label> {{$aEgknRaws['egkn_status'] == 'Заявка создана' ? 'свободный ЗУ' : 'аукцион/торги'}}
                            @endif
                            <hr />
                        </div>
                        <div class="form-group">
                            <label for="inputType">Выберите Тип Вводимого</label>
                            <select id="storageSelect" name="inputType" class="form-control">
                                <option value="PKCS12" selected>PKCS12</option>
                            </select>
                            <hr />
                        </div>


                        <div class="form-group">
                            <label for="inputType">XML</label>
                            <div>
                                <textarea class="form-control" id="xmlToSign" readonly placeholder="<xml>...</xml>" rows="3">{{$aEgknXmlRows}}</textarea>
                            </div>
                            <hr />
                            <div>
                                <input value="Подписать XML" id='notsignedXml' onclick="signXmlCall();" type="button"  />
                            </div>
                        </div>

                        <form action="/saveXmlAsFile" method="POST">
                            @csrf
                            <label for="inputType">Подписанный XML</label>
                            <div>
                                <textarea class="form-control" id="signedXml" rows="6" readonly></textarea>
                            </div>
                            <button id='signedXmlSave' disabled type="Submit">Сохранить XML</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
