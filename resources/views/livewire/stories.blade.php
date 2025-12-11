<main class="flex-1 bg-gray-50/50 py-12">
    <div class="container mx-auto px-4 max-w-7xl space-y-8">

        {{-- Header Section --}}
        <div class="space-y-4 text-center">
            <h1 class="text-4xl font-bold tracking-tight sm:text-5xl text-gray-900">
                Bibliothèque d'histoires
            </h1>
            <p class="text-lg text-gray-500">
                Découvrez les histoires créées par notre communauté
            </p>
        </div>

        {{-- Search Local (Style React adapté) --}}
        <div class="mx-auto max-w-xl">
            <div class="relative">
                {{-- Icône Loupe --}}
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>

                {{-- Input connecté à Livewire --}}
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Rechercher une histoire..."
                    class="w-full h-10 rounded-md border border-gray-300 bg-white px-3 pl-10 py-2 text-sm placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" />
            </div>
        </div>

        {{-- Loading State (Optionnel mais recommandé) --}}
        <div wire:loading.class.remove="hidden" class="hidden text-center py-4">
            <span class="text-gray-500">Chargement...</span>
        </div>

        {{-- Stories Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($stories as $story)
                <div
                    class="bg-white rounded-lg shadow-sm border border-gray-100 p-5 hover:shadow-md transition-shadow duration-200 flex flex-col h-full">

                    {{-- Titre --}}
                    <h2 class="text-xl font-bold mb-2 text-gray-900">
                        {{ $story->title ?: 'Sans titre' }}
                    </h2>

                    {{-- Date --}}
                    <p class="text-gray-500 text-sm mb-3">
                        Publié le {{ $story->created_at->format('d/m/Y') }}
                    </p>

                    {{-- Extrait --}}
                    <p class="text-gray-700 flex-grow">
                        {{ Str::limit($story->summary ?? $story->chapters->first()?->body ?? 'Pas encore de contenu', 150) }}
                    </p>

                    {{-- Bouton "Lire la suite" (Optionnel pour le style) --}}
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <a href="{{ route('story.detail', $story) }}"
                            class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                            Lire l'histoire &rarr;
                        </a>
                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Aucune histoire trouvée pour cette recherche.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $stories->links() }}
        </div>
    </div>
</main>