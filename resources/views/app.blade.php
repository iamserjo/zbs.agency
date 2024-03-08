<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
    <div id="app">
        <app></app>
        <user-list></user-list>
        <ul class="nav nav-tabs">
            <li class="nav-item" @click="switchTab('user-list')">
                <a class="nav-link" :class="{ active: activeTab === 'user-list' }" href="#">User List</a>
            </li>
            <li class="nav-item" @click="switchTab('user-registration')">
                <a class="nav-link" :class="{ active: activeTab === 'user-registration' }" href="#">User Registration</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane" :class="{ active: activeTab === 'user-list' }">
{{--                <user-list></user-list>--}}
            </div>
            <div class="tab-pane" :class="{ active: activeTab === 'user-registration' }">
                <user-registration></user-registration>
            </div>
        </div>
    </div>
    </body>
</html>
