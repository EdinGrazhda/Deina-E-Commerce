<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light" data-flux-appearance="light">
    <head>
        @include('partials.head')
        <script>
            // Force light mode for auth pages
            (function() {
                document.documentElement.setAttribute('data-flux-appearance', 'light');
                document.documentElement.classList.remove('dark');
                document.documentElement.classList.add('light');
                localStorage.setItem('flux.appearance', 'light');
            })();
        </script>
    </head>
    <body class="min-h-screen bg-white antialiased">
        <div class="bg-background flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <div class="flex h-12 w-12 mb-2 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-purple-600">
                        <span class="text-white font-bold text-xl">D</span>
                    </div>
                    <span class="text-2xl font-bold text-gray-900 dark:text-white">Deina</span>
                    <span class="text-sm text-gray-500 dark:text-gray-400">E-Commerce Platform</span>
                </a>
                <div class="flex flex-col gap-6">
                    {{ $slot }}
            </div>
        </div>
        @fluxScripts
    </body>
</html>
