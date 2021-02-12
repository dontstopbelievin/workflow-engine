@extends('layouts.app')
@section('content')
<div class="main-panel">
  <div class="content">
    <div class="container-fluid">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title font-weight-bold text-center">
            Правила информационной безопасности
          </h4>
        </div>
        <div class="card-body">
        <style>
          .w-6 {
            width: 1.5rem;
            float: right;
          }
          .items-center{
            margin-bottom: 0px!important;
          }
        </style>
        <section class="py-12 px-4">
          <div class="list-group col-md-6 offset-md-3">
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/1_Политика_информ_безопасности.pdf">
                <span class="flex-grow">Политика информационной безопасности</span>
                <img class="w-6" src="/images/cloud-computing.svg" alt="">
            </a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/2_Правила_организации_физ_защиты.pdf">
                <span class="flex-grow">Правила организации физической защиты</span>
                <img class="w-6" src="/images/cloud-computing.svg" alt="">
            </a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/3_Правила_использования_моб_устройств.pdf"><span class="flex-grow">Правила использования мобильных устройств</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/4_Регламент_резервного_копирования.pdf"><span class="flex-grow">Регламент резервного копирования</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/5_Правила_использования_крипто_защиты.pdf"><span class="flex-grow">Правила использования крипто защиты</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/6_Правила_организации_аутентификации.pdf"><span class="flex-grow">Правила организации аутентификации</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/7_Правила_организации_антивирусного.pdf"><span class="flex-grow">Правила организации антивирусного</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/8_Инструкция_о_порядке_действий_пользователей.pdf"><span class="flex-grow">Инструкция о порядке действий пользователей</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/9_Методики_оценки_рисков.pdf"><span class="flex-grow">Методики оценки рисков</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/10_Правила_идент_классиф_и_маркировки.pdf"><span class="flex-grow">Правила идентификации, классификации и маркировки активов</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/11_Правила_обеспечения_непрерывной.pdf"><span class="flex-grow">Правила обеспечения непрерывной работы активов</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/12_Правила_инвентаризации_и_паспортизации.pdf"><span class="flex-grow">Правила инвентаризации и паспортизации средств выч.техники</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/13_Правила_проведения_внутреннего_аудита.pdf"><span class="flex-grow">Правила проведения внутреннего аудита</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/14_Правила_использования_сети_и_почты.pdf"><span class="flex-grow">Правила использования сети интернет и эл.почты</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/15_Правила_разгранечения_прав_доступа.pdf"><span class="flex-grow">Правила разграничения прав доступа к эл.ресурсам</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
            <a class="flex items-center w-full p-4 text-left rounded shadow" href="/policydocs/16_Руководство_админ_по_сопровождению.pdf"><span class="flex-grow">Руководство админ. по сопровождению объекта</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
          </div>
        </section>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
