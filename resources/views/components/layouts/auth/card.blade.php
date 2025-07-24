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
    <body class="min-h-screen bg-neutral-100 antialiased">
        <div class="bg-muted flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-md flex-col gap-6">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <div class="flex h-12 w-12 mb-1 items-center justify-center rounded-xl bg-gradient-to-br from-blue-600 to-purple-600">
                        <span class="text-white font-bold text-lg">D</span>
                    </div>
                    <span class="text-xl font-bold text-gray-900">Deina</span>
                    <span class="sr-only">{{ config('app.name', 'Deina') }}</span>
                </a>

                <div class="flex flex-col gap-6">
                    <div class="rounded-xl border bg-white text-stone-800 shadow-xs">
                        <div class="px-10 py-8">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
