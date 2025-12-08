<header
    class="sticky top-0 z-40 w-full bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md border-b border-zinc-200/50 dark:border-zinc-700/50 shadow-sm">
    <div class="container mx-auto flex h-16 items-center px-4">

        {{-- Navigation --}}
        <nav class="flex items-center gap-6 max-lg:hidden">
            {{-- Logo / Home --}}
            <a href="/"
                class="flex items-center gap-2 text-sm font-medium text-zinc-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                {{-- Tu peux mettre une icône SVG ici si tu veux remplacer icon="home" --}}
                InfinityStory
            </a>

            <a href="/story-generate"
                class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                Générer une histoire
            </a>

            <a href="/stories"
                class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                Histoires
            </a>

            @guest
                <a href="/login"
                    class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Connexion
                </a>
            @endguest

            @auth
                <a href="/profile"
                    class="text-sm font-medium text-zinc-700 dark:text-zinc-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                    Mon Profil
                </a>

                {{-- Le composant Livewire Logout reste inchangé --}}
                <livewire:logout />
            @endauth
        </nav>

        {{-- Spacer (remplace
        <flux:spacer />) --}}
        <div class="flex-1"></div>

        {{-- Barre de recherche (remplace <flux:input>) --}}
            <div class="relative w-full max-w-xs">
                {{-- Icône Loupe SVG --}}
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-zinc-500 dark:text-zinc-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>

                <input type="search" wire:model.live.debounce.300ms="search" wire:keydown.enter="performSearch"
                    placeholder="Rechercher..." class="block w-full p-2 pl-10 text-sm ...">
            </div>

    </div>
</header>