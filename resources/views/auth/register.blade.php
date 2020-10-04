{{-- @extends('layouts.app')

@section('content')

    <html :class="{ 'theme-dark': dark } bg-gray-50 dark:bg-gray-900" x-data="data()" lang="en">

    <head>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap"
            rel="stylesheet" />
        <link rel="stylesheet" href="../assets/css/tailwind.output.css" />
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
        <script src="../assets/js/init-alpine.js"></script>
    </head>

    <body class="pt-8">
        <div class="flex items-center min-h-screen p-6">
            <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
                <div class="flex flex-col overflow-y-auto md:flex-row">
                    <div class="h-32 md:h-auto md:w-1/2">
                        <img aria-hidden="true" class="object-cover w-full h-full dark:hidden"
                            src="../assets/img/create-account-office.jpeg" alt="Office" />
                        <img aria-hidden="true" class="hidden object-cover w-full h-full dark:block"
                            src="../assets/img/create-account-office-dark.jpeg" alt="Office" />
                    </div>
                    <div class="flex items-center justify-center p-6 sm:p-12 md:w-1/2">
                        <div class="w-full">
                            <div class="flex justify-center md:justify-start">
                                <a href="#" class="p-4"><img src="/images/astana-logo.png"></a>
                            </div>
                            <h1 class="mb-4 text-center text-xl font-semibold text-gray-700 dark:text-gray-200">
                                Регистрация
                            </h1>
                            <form class="flex flex-col pt-3 md:pt-8" action="/register" method="POST">
                                @csrf
                                <label class="block text-sm">
                                    <span for="name" class="text-gray-700 dark:text-gray-400">ФИО</label>
                                <input type="text" id="name" name="name" placeholder="Кайсаров Кайсар Кайсарулы"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                </label>
                                <label class="block mt-4 text-sm">
                                    <span for="name" class="text-gray-700 dark:text-gray-400">Телефон</label>
                                <input type="text" id="phone" name="phone" pattern="[0-9]{10}" title="Введите 10 цифр вашего номера" placeholder="10 цифр вашего номера. Пример: 77077007777"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input form-control @error('email') border-red-500 @enderror">
                                </label>
                                <label class="block mt-4 text-sm">
                                    <span for="iin" class="text-gray-700 dark:text-gray-400">ИИН</label>
                                <input type="text" id="iin" name="iin" pattern="[0-9]{12}" placeholder="950206886596"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                </label>
                                <label class="block mt-4 text-sm">
                                    <span for="bin" class="text-gray-700 dark:text-gray-400">БИН</label>
                                <input type="text" id="bin" name="bin" pattern="[0-9]{12}" placeholder="950206886596"
                                    class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input">
                                </label>
                                <label for="email" class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Ваш email</span>
                                    <input
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        type="email" id="email" name="email" placeholder="your@email.com" />
                                </label>
                                <label for="password" class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">Придумайте пароль</span>
                                    <input
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="***************" type="password" id="password" name="password" />
                                </label>
                                <label for="confirm-password" class="block mt-4 text-sm">
                                    <span class="text-gray-700 dark:text-gray-400">
                                        Повторите пароль
                                    </span>
                                    <input
                                        class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
                                        placeholder="***************" type="password" id="confirm-password"  name="password_confirmation" />
                                </label>

                                <div class="flex mt-6 text-sm">
                                    <label class="flex items-center dark:text-gray-400">
                                        <input type="checkbox"
                                            class="text-purple-600 form-checkbox focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray" />
                                        <span class="ml-2">
                                            Я согласен
                                            <span class="underline"> с условиями пользования</span>
                                        </span>
                                    </label>
                                </div>

                                <!-- You should use a button here, as the anchor is only used for the example  -->
                                <button type="submit"
                                    class="block w-full px-4 py-2 mt-4 text-sm font-medium leading-5 text-center text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                                    {{ __('Зарегистрироваться') }}
                                </button>
                            </form>

                            <hr class="my-8" />

                            <a class="text-sm font-medium text-purple-600 dark:text-purple-400 hover:underline"
                                href="/login">
                                Уже есть аккаунт? Авторизуйтесь
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>

    </html>
@endsection
