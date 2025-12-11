<div class="max-w-5xl mx-auto py-12 px-4 space-y-8 font-sans">
    
    <div class="flex flex-col sm:flex-row justify-between items-center gap-4 border-b border-slate-200 pb-6">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Ma Bibliothèque</h1>
            <p class="text-slate-500 mt-1">Gérez vos histoires et vos chapitres</p>
        </div>
        
        @if(!$isCreating && !$editingStoryId)
            <button wire:click="startCreating" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-2 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Écrire une nouvelle histoire
            </button>
        @endif
    </div>

    @if (session()->has('message'))
        <div class="bg-emerald-50 text-emerald-700 p-4 rounded-lg border border-emerald-200 flex items-center gap-2 animate-pulse-once">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
            {{ session('message') }}
        </div>
    @endif

    @if($isCreating)
        <div class="bg-white p-6 rounded-xl border-2 border-indigo-100 shadow-xl mb-8">
            <h3 class="text-lg font-bold mb-4 text-indigo-900 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                Commencer un nouveau livre
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Titre de l'histoire</label>
                    <input wire:model="newTitle" type="text" placeholder="Ex: Les chroniques de..." class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('newTitle') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Contenu du premier chapitre</label>
                    <textarea wire:model="newBody" rows="6" placeholder="Il était une fois..." class="w-full rounded-md border-slate-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    @error('newBody') <span class="text-red-500 text-xs font-bold">{{ $message }}</span> @enderror
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button wire:click="cancelCreating" class="px-4 py-2 text-slate-600 hover:text-slate-800 text-sm font-medium">Annuler</button>
                    <button wire:click="storeManual" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 text-sm font-medium shadow-sm">Créer l'histoire</button>
                </div>
            </div>
        </div>
    @endif

    <div class="grid gap-8">
        @forelse($stories as $story)
            <div wire:key="story-{{ $story->id }}" class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">

                @if($editingStoryId === $story->id)
                    <div class="flex flex-col h-full">
                        <div class="bg-slate-50 p-6 border-b border-slate-200">
                            <div class="flex justify-between items-start mb-4">
                                <h2 class="text-sm font-bold text-slate-400 uppercase tracking-wider">Édition du livre</h2>
                                <button wire:click="cancelEdit" class="text-slate-400 hover:text-slate-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                </button>
                            </div>

                            <div class="flex gap-2 items-end">
                                <div class="w-full">
                                    <label class="text-xs font-bold text-slate-500">Titre</label>
                                    <input wire:model="editTitle" type="text" class="mt-1 w-full rounded-md border-slate-300 focus:border-indigo-500 focus:ring-indigo-500 font-bold text-lg text-slate-800">
                                </div>
                                <button wire:click="update" class="mb-0.5 px-4 py-2.5 bg-slate-800 text-white text-sm rounded-md hover:bg-slate-900 transition">
                                    Renommer
                                </button>
                            </div>
                        </div>

                        <div class="p-6 bg-white">
                            @if($editingChapterId)
                                <div class="mb-8 bg-indigo-50/50 rounded-xl border border-indigo-100 p-6 animate-in fade-in slide-in-from-top-4 duration-300">
                                    <div class="flex justify-between items-center mb-4 border-b border-indigo-100 pb-2">
                                        <h3 class="font-bold text-indigo-900 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-500"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                            Éditer le chapitre
                                        </h3>
                                        <button wire:click="$set('editingChapterId', null)" class="text-xs text-indigo-400 hover:text-indigo-700 font-medium">Fermer sans sauver</button>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <input wire:model="chapterTitle" type="text" placeholder="Titre du chapitre" class="w-full bg-white rounded-md border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 font-bold text-indigo-900">
                                        </div>
                                        <div>
                                            <textarea wire:model="chapterBody" rows="12" placeholder="Écrivez votre chapitre ici..." class="w-full bg-white rounded-md border-indigo-200 focus:border-indigo-500 focus:ring-indigo-500 text-slate-700 leading-relaxed"></textarea>
                                        </div>
                                        <div class="flex justify-end pt-2">
                                            <button wire:click="saveChapter" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md font-medium shadow-sm transition">
                                                Sauvegarder les modifications
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="space-y-4">
                                <div class="flex items-center justify-between">
                                    <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                                        Sommaire du livre
                                    </h3>
                                    <button wire:click="addChapter" class="text-xs font-bold bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded-full hover:bg-emerald-200 transition flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                        Nouveau Chapitre
                                    </button>
                                </div>

                                <div class="bg-white rounded-lg border border-slate-200 divide-y divide-slate-100">
                                    @forelse($chapters as $chapter)
                                        <div class="flex items-center justify-between p-4 hover:bg-slate-50 transition {{ $editingChapterId == $chapter->id ? 'bg-indigo-50 ring-1 ring-inset ring-indigo-200' : '' }}">
                                            <div class="flex items-center gap-4">
                                                <span class="flex-shrink-0 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 text-slate-500 font-bold text-xs">
                                                    {{ $loop->iteration }}
                                                </span>
                                                <div>
                                                    <p class="font-medium text-slate-900">{{ $chapter->title }}</p>
                                                    <p class="text-xs text-slate-400 truncate max-w-xs">{{ Str::limit($chapter->body, 50) }}</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3">
                                                <button wire:click="editChapter({{ $chapter->id }})" class="text-sm font-medium text-indigo-600 hover:text-indigo-800">
                                                    Modifier
                                                </button>
                                                <button wire:click="deleteChapter({{ $chapter->id }})" wire:confirm="Êtes-vous sûr de vouloir supprimer ce chapitre ?" class="text-slate-400 hover:text-red-600 transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="p-8 text-center text-slate-400 italic">
                                            Ce livre n'a pas encore de chapitres.
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>

                @else
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-6">
                                    <div>
                                        <h2 class="text-xl font-bold text-slate-900">{{ $story->title ?? 'Livre sans titre' }}</h2>
                                        <div class="flex items-center gap-3 mt-2 text-xs text-slate-500">
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                                Créé le {{ $story->created_at->format('d/m/Y') }}
                                            </span>
                                            <span>•</span>
                                            <span class="flex items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
                                                {{ $story->chapters->count() }} Chapitre(s)
                                            </span>
                                        </div>
                                    </div>

                                    <button wire:click="toggleStatus({{ $story->id }})" 
                                        class="px-3 py-1 rounded-full text-xs font-bold border transition-all duration-200 flex items-center gap-1.5
                                        {{ $story->status === 'published'
                    ? 'bg-emerald-100 text-emerald-700 border-emerald-200 hover:bg-emerald-200 hover:border-emerald-300'
                    : 'bg-slate-100 text-slate-600 border-slate-200 hover:bg-slate-200 hover:border-slate-300' }}">
                                        <span class="w-1.5 h-1.5 rounded-full {{ $story->status === 'published' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                        {{ $story->status === 'published' ? 'PUBLIÉ' : 'BROUILLON' }}
                                    </button>
                                </div>

                                <div class="bg-slate-50 rounded-lg p-4 mb-6 border border-slate-100">
                                    @if($story->chapters->count() > 0)
                                        <p class="text-sm text-slate-600 line-clamp-3 italic">
                                            "{{ Str::limit($story->chapters->first()->body, 200) }}"
                                        </p>
                                    @else
                                        <p class="text-sm text-slate-400 italic text-center">Aucun contenu disponible pour le moment.</p>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-slate-100">
                                    <button wire:click="edit({{ $story->id }})" class="text-sm font-bold text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 px-3 py-2 rounded-md transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                        Gérer les chapitres
                                    </button>

                                    <button wire:click="delete({{ $story->id }})" wire:confirm="Attention : Cela supprimera le livre ET tous ses chapitres. Continuer ?" class="text-sm font-medium text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-md transition flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        Supprimer le livre
                                    </button>
                                </div>
                            </div>
                @endif
            </div>
        @empty
            <div class="text-center py-16 bg-white rounded-xl border border-dashed border-slate-300">
                <div class="mx-auto h-12 w-12 text-slate-300 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" /></svg>
                </div>
                <p class="text-slate-500 text-lg font-medium">Vous n'avez pas encore écrit d'histoire.</p>
                <button wire:click="startCreating" class="text-indigo-600 font-bold hover:underline mt-2">Commencer votre premier livre</button>
            </div>
        @endforelse
    </div>
</div>