
 @extends('layouts.app')


@section('content')
    <body class="bg-white h-screen">

        <div class="w-full flex flex-wrap">

            <!-- Register Section -->
            <div class="w-full md:w-2/5 flex flex-col">

                <div class="flex justify-center md:justify-start pt-12 md:pl-12 md:-mb-12">
                    <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                </div>

                <div class="flex flex-col justify-center md:justify-start my-auto pt-8 md:pt-0 px-8 md:px-24 lg:px-32">
                    <p class="text-center text-3xl">Электронные услуги</p>
                    <form class="flex flex-col pt-3 md:pt-8" action="/register" method="POST">
                        @csrf
                        <div class="flex flex-col pt-4">
                            <label for="name" class="text-lg">ФИО</label>
                            <input type="text" id="name" name="name" placeholder="Кайсаров Кайсар Кайсарулы"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex flex-col pt-4">
                            <label for="name" class="text-lg">Телефон</label>
                            <input type="text" id="phone" name="phone" placeholder="87777777777"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex flex-col pt-4">
                            <label for="iin" class="text-lg">ИИН</label>
                            <input type="text" id="iin" name="iin" placeholder="950206886596"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>
                        <div class="flex flex-col pt-4">
                            <label for="bin" class="text-lg">БИН</label>
                            <input type="text" id="bin" name="bin" placeholder="950206886596"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex flex-col pt-4">
                            <label for="email" class="text-lg">Ваш email</label>
                            <input type="email" id="email" name="email" placeholder="your@email.com"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex flex-col pt-4">
                            <label for="password" class="text-lg">Придумайте пароль</label>
                            <input type="password" id="password" name="password" placeholder="Ваш пароль"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <div class="flex flex-col pt-4">
                            <label for="confirm-password" class="text-lg">Повторите пароль</label>
                            <input type="password" id="confirm-password"  name="password_confirmation" placeholder="Ваш пароль"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mt-1 leading-tight focus:outline-none focus:shadow-outline">
                        </div>

                        <button type="submit"
                            class="btn btn-primary bg-indigo-500 text-white font-bold text-lg hover:bg-indigo-600 p-2 mt-8">
                            {{ __('Зарегистрироваться') }}
                        </button>
                    </form>
                    <div class="text-center pt-12 pb-12">
                        <p>Уже зарегистрированы? <a href="{{ route('login') }}" class="underline font-semibold">Авторизоваться</a>
                        </p>
                    </div>
                </div>

            </div>

            <!-- Image Section -->
            <div class="w-1/2">
                <img class="object-contain w-full h-screen hidden md:block" src="/images/shutterstock_1124764481.jpg">
            </div>
        </div>

    </body>
@endsection
