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
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex border-e border-neutral-200">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-purple-600"></div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                    <div class="flex h-10 w-10 me-3 items-center justify-center rounded-md bg-white/20">
                        <span class="text-white font-bold text-lg">D</span>
                    </div>
                    Deina E-Commerce
                </a>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <flux:heading size="lg">&ldquo;{{ trim($message) }}&rdquo;</flux:heading>
                        <footer><flux:heading>{{ trim($author) }}</flux:heading></footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <div class="flex h-9 w-9 items-center justify-center rounded-md bg-gradient-to-br from-blue-600 to-purple-600">
                            <span class="text-white font-bold text-sm">D</span>
                        </div>
                        <span class="text-lg font-bold text-gray-900">Deina</span>
                        <span class="sr-only">{{ config('app.name', 'Deina') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
