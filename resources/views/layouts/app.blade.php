<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Estoque') }}</title>

        <!-- Fonts -->
        
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <script>
            // On page load or when changing themes, best to add inline in `head` to avoid FOUC
            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark')
            }
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">

  
            @include('layouts.navigation')
     

            <!-- Page Heading -->
            @isset($header)
                
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-3 px-4 sm:px-3 lg:px-4">
                        
                        {{ $header }}

                    </div>   
                   
         
                </header>
                
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
                
            </main>
        </div>

        @if(session('success') || session('warning') || session('danger'))
            @php
                $message = session('success') ?? session('warning') ?? session('danger');
                $type = session('success') ? 'success' : (session('warning') ? 'warning' : 'danger');
                $bgColor = $type === 'success' ? 'bg-green-100 dark:bg-green-800' : ($type === 'warning' ? 'bg-yellow-100 dark:bg-yellow-800' : 'bg-red-100 dark:bg-red-800');
                $textColor = $type === 'success' ? 'text-green-500 dark:text-green-200' : ($type === 'warning' ? 'text-yellow-500 dark:text-yellow-200' : 'text-red-500 dark:text-red-200');
                $iconPath = $type === 'success' 
                    ? 'M10 18a8 8 0 100-16 8 8 0 000 16zm1.707-10.293a1 1 0 00-1.414-1.414L8 8.586 6.707 7.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z'
                    : ($type === 'warning'
                        ? 'M8.257 3.099c.765-1.36 2.758-1.36 3.523 0l7.06 12.58c.72 1.282-.208 2.82-1.762 2.82H2.96c-1.554 0-2.482-1.538-1.762-2.82l7.059-12.58zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-3a1 1 0 01-1-1V7a1 1 0 012 0v3a1 1 0 01-1 1z'
                        : 'M8.257 3.099c.765-1.36 2.758-1.36 3.523 0l7.06 12.58c.72 1.282-.208 2.82-1.762 2.82H2.96c-1.554 0-2.482-1.538-1.762-2.82l7.059-12.58zM11 14a1 1 0 10-2 0 1 1 0 002 0zm-1-3a1 1 0 01-1-1V7a1 1 0 012 0v3a1 1 0 01-1 1z');
            @endphp

            <div id="toast-{{ $type }}" class="fixed bottom-5 right-5 flex items-center p-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800 {{ $bgColor }}" role="alert">
                <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 {{ $textColor }} rounded-lg">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="{{ $iconPath }}" clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">{{ ucfirst($type) }} icon</span>
                </div>
                <div class="ml-3 text-sm font-normal">{{ is_array($message) ? implode(', ', $message) : $message }}
                </div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8 dark:text-gray-500 dark:hover:text-white dark:bg-gray-800 dark:hover:bg-gray-700" data-dismiss-target="#toast-{{ $type }}" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 9.293a1 1 0 011.414 0L10 13.586l4.293-4.293a1 1 0 011.414 1.414l-5 5a1 1 0 01-1.414 0l-5-5a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', (event) => {
                    // Show toast
                    const toast = document.getElementById('toast-{{ $type }}');
                    toast.classList.remove('hidden');
                    setTimeout(() => {
                        toast.classList.add('hidden');
                    }, 3000); // Hide after 3 seconds
                });
            </script>
        @endif

        
       
        <script src="https://unpkg.com/flowbite@1.5.0/dist/flowbite.js"></script>
          
        <script>
            var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
            var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');

            if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                themeToggleLightIcon.classList.remove('hidden');
            } else {
                themeToggleDarkIcon.classList.remove('hidden');
            }
            
            var themeToggleBtn = document.getElementById('theme-toggle');

            themeToggleBtn.addEventListener('click', function() {

                themeToggleDarkIcon.classList.toggle('hidden');
                themeToggleLightIcon.classList.toggle('hidden');

                if (localStorage.getItem('color-theme')) {
                    if (localStorage.getItem('color-theme') === 'light') {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }

                } else {
                    if (document.documentElement.classList.contains('dark')) {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    } else {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    }
                }
                
            });
        </script>

    </body>
</html>
