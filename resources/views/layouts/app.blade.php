<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laracsts Voting') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans text-grey-900 text-sm bg-grey-background">
       <header class="flex items-center justify-between px-8 py-4">
        <a href="#">
            <img src="{{ asset('images/logos/laracasts.svg') }}" alt="Laracasts logo" />
        </a>
        <div class="flex items-center">
            @if (Route::has('login'))
            <div class="right-0 px-6 py-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    @auth
                    <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </a>
                </form>
                    @else
                    <a href="{{ route('login') }}" class="text-sm text-gray-700 underline">Log in</a>

                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 underline">Register</a>
                    @endif
                @endauth
            </div>
            @endif
            <a href="#">
                <img src="https://gravatar.com/avatar/0000000000000000000000?d=mp" 
                alt="avatar" class="w-10 h-10 rounded-full"/>
            </a>
        </div>
       </header>
       <main class="container mx-auto flex max-w-custom">
            <div class="w-70 mr-5">
                <div class="bg-white border-2 border-blue rounded-xl mt-16 px-3 py-3">
                    <div class="text-center px-6 py-2 pt-6">
                        <h3 class="font-semibold text-base">Add an idea</h3>
                        <p class="text-xs mt-4">Let us know what you would like and we'll take a look.</p>
                    </div>
                    <form action="#" method="POST" class="space-y-4 px-4 py-6">
                        <div>
                            <input type="text" class="w-full bg-gray-100 rounded-xl placeholder-gray-900 border-none text-sm" placeholder="Your idea">
                        </div>
                        <div>
                            <select name="category" id="category" class="w-full rounded-xl px-4 py-2 border-none bg-gray-100 text-sm">
                                <option value="category-one">Category One</option>
                                <option value="category-twp">Category Two</option>
                                <option value="category-three">Category Three</option>
                                <option value="category-four">Category Four</option>
                            </select>
                        </div>
                        <div>
                            <textarea name="idea" id="idea" cols="30" rows="4" class="w-full bg-grey-100 rounded-xl placeholder-gray-900 text-sm border-none"></textarea>
                        </div>
                    </form>
                 </div>
            </div>
            <div class="w-175">
                <nav class="flex justify-between items-center text-xs">
                    <ul class="flex uppercase font-semibold space-x-10 border-b-4 pb-3">
                        <li><a href="#" class="border-b-4 pb-3 border-blue">All ideas (87)</a></li>
                        <li><a href="#" class="text-gray-400 transition duration-150 ease-in pb-3 border-b-4 hover:border-blue">Considering (6)</a></li>
                        <li><a href="#" class="text-gray-400 transition duration-150 ease-in pb-3 border-b-4 hover:border-blue">In Progress (1)</a></li>
                    </ul>
                    <ul class="flex uppercase font-semibold space-x-10 border-b-4 pb-3">
                         <li><a href="#" class="text-gray-400 transition duration-150 ease-in pb-3 border-b-4 hover:border-blue">Implemented (10)</a></li>
                        <li><a href="#" class="text-gray-400 transition duration-150 ease-in pb-3 border-b-4 hover:border-blue"> Closed (55)</a></li>
                    </ul>
                </nav>
                <div class="mt-8">
                    {{ $slot }}
                </div>
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quibusdam deserunt at ex repudiandae? Accusamus accusantium optio delectus explicabo sequi odit a, molestias suscipit voluptatibus mollitia totam ullam laudantium at non?
            </div>
        </main>
    </body>
</html>
