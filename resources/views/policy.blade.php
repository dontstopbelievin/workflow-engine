@extends('layouts.app')
@if (Route::has('login'))
            <div class="top-right links text-center">
                @auth
                <svg class="inline-flex w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                    <a href="/services" class="mr-16">Вернуться к услугам</a>
                @else
                <!-- This is an example component -->
                <div class="inline-flex md:flex-wrap">
                    <div class="relative inline-flex">
                        <a class="" href="/policydocs/Политика_конфиденциальности.pdf">Политика конфиденциальности</a>
                    </div>
                </div>
                    

                    {{-- @if (Route::has('register'))
                        <a href="{{ route('register') }}">Зарегистрироваться</a>
                    @endif --}}
                @endauth
            </div>
        @endif
@section('content')

    <html :class="{ 'theme-dark': dark } bg-gray-50 dark:bg-gray-900" x-data="data()" lang="en">

    <div class="content">
        <section class="py-12 px-4">
            <div class="max-w-3xl mx-auto">
              <h2 class="text-4xl text-center mb-4 font-heading">Правила информационной безопасности</h2>
              <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/1_Политика_информ_безопасности.pdf"><span class="flex-grow">Политика информационной безопасности</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
              <a class="flex items-center w-full p-4 mb-4 text-left rounded shadow" href="/policydocs/2_Правила_организации_физ_защиты.pdf"><span class="flex-grow">Правила организации физической защиты</span><img class="w-6" src="/images/cloud-computing.svg" alt=""></a>
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
    </html>
@endsection
