<div class="max-w-4xl mx-auto py-12 px-4 space-y-8">

    <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
        <h1 class="text-3xl font-bold text-slate-900">Ma Bibliothèque</h1>

        @if(!$isCreating)
            <button wire:click="startCreating"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="5" x2="12" y2="19"></line>
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                Écrire une histoire
            </button>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-lg border border-emerald-200">
            {{ session('message') }}
        </div>
    @endif

    @if($isCreating)
        <div class="bg-white p-6 rounded-xl border-2 border-indigo-100 shadow-lg mb-8">
            <h3 class="text-lg font-bold mb-4 text-indigo-900">Nouvelle histoire manuelle</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Titre</label>
                    <input wire:model="newTitle" type="text"
                        class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('newTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Contenu</label>
                    <textarea wire:model="newBody" rows="6"
                        class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('newBody') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end gap-2">
                    <button wire:click="cancelCreating"
                        class="px-4 py-2 text-slate-600 hover:text-slate-800">Annuler</button>
                    <button wire:click="storeManual"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">Enregistrer le
                        brouillon</button>
                </div>
            </div>
        </div>
    @endif

    <div class="grid gap-6">
        @forelse($stories as $story)
            <div wire:key="story-{{ $story->id }}"
                class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition">

                @if($editingStoryId === $story->id)
                    <div class="p-6 space-y-4 bg-slate-50">
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">Modifier le titre</label>
                            <input wire:model="editTitle" type="text"
                                class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-500 focus:ring-emerald-500">
                            @error('editTitle') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="text-xs font-bold text-slate-500 uppercase">Modifier le texte</label>
                            <textarea wire:model="editBody" rows="8"
                                class="mt-1 w-full rounded-md border-slate-300 focus:border-emerald-500 focus:ring-emerald-500"></textarea>
                            @error('editBody') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                        </div>
                        <div class="flex justify-end gap-2 pt-2">
                            <button wire:click="cancelEdit"
                                class="px-3 py-2 text-sm text-slate-600 hover:text-slate-900">Annuler</button>
                            <button wire:click="update"
                                class="px-3 py-2 text-sm bg-emerald-600 text-white rounded-md hover:bg-emerald-700">Sauvegarder
                                les modifications</button>
                        </div>
                    </div>

                @else
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <h2 class="text-xl font-bold text-slate-900">{{ $story->title }}</h2>
                                <p class="text-xs text-slate-500 mt-1">Créer le {{ $story->created_at->format('d/m/Y') }}</p>
                            </div>

                            <button wire:click="toggleStatus({{ $story->id }})" class="px-3 py-1 rounded-full text-xs font-bold border transition-colors cursor-pointer
                                                        {{ $story->status === 'published'
                    ? 'bg-emerald-100 text-emerald-800 border-emerald-200 hover:bg-emerald-200'
                    : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200' }}">
                                {{ $story->status === 'published' ? 'PUBLIÉ' : 'BROUILLON' }}
                            </button>
                        </div>

                        <div class="prose prose-sm text-slate-600 line-clamp-3 mb-6">
                            {{ $story->body }}
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                            <div class="flex gap-4">
                                <button wire:click="edit({{ $story->id }})"
                                    class="text-sm font-medium text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                    Modifier
                                </button>
                                <button wire:click="delete({{ $story->id }})"
                                    wire:confirm="Êtes-vous sûr de vouloir supprimer cette histoire ?"
                                    class="text-sm font-medium text-red-600 hover:text-red-800 flex items-center gap-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"></polyline>
                                        <path
                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                        </path>
                                    </svg>
                                    Supprimer
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @empty
            <div class="text-center py-12 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                <p class="text-slate-500">Vous n'avez pas encore d'histoires.</p>
                <button wire:click="startCreating" class="text-emerald-600 font-bold hover:underline mt-2">En créer une
                    maintenant</button>
            </div>
        @endforelse
    </div>
</div>