<footer class="bg-white border-t border-slate-200 mt-auto">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-4 lg:grid-cols-5">

            {{-- COLONNE 1 : LOGO & DESCRIPTION --}}
            <div class="md:col-span-2 lg:col-span-2">
                <div class="flex items-center gap-2 text-slate-900 font-bold text-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="text-emerald-600">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"></path>
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path>
                    </svg>
                    InfinyStory
                </div>
                <p class="mt-4 text-sm text-slate-500 leading-relaxed max-w-xs">
                    Libérez votre imagination avec notre assistant d'écriture propulsé par l'intelligence artificielle.
                    Créez, partagez et lisez des histoires uniques.
                </p>

                {{-- Réseaux Sociaux (Déco) --}}
                <div class="mt-6 flex gap-4">
                    <a href="#" class="text-slate-400 hover:text-emerald-600 transition">
                        <span class="sr-only">GitHub</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="#" class="text-slate-400 hover:text-emerald-600 transition">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                </div>
            </div>

            {{-- COLONNE 2 : NAVIGATION --}}
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Explorer</h3>
                <ul role="list" class="mt-4 space-y-3">
                    <li>
                        <a href="{{ route('story.create') }}"
                            class="text-sm text-slate-500 hover:text-emerald-600 transition">Générateur IA</a>
                    </li>
                    <li>
                        <a href="{{ route('stories') }}"
                            class="text-sm text-slate-500 hover:text-emerald-600 transition">Bibliothèque</a>
                    </li>
                </ul>
            </div>

            {{-- COLONNE 3 : COMPTE --}}
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Mon Espace</h3>
                <ul role="list" class="mt-4 space-y-3">
                    @auth
                        <li>
                            <a href="{{ route('profile') }}"
                                class="text-sm text-slate-500 hover:text-emerald-600 transition">Mon Profil</a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="text-sm text-slate-500 hover:text-emerald-600 transition">Déconnexion</button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}"
                                class="text-sm text-slate-500 hover:text-emerald-600 transition">Se connecter</a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}"
                                class="text-sm text-slate-500 hover:text-emerald-600 transition">S'inscrire</a>
                        </li>
                    @endauth
                </ul>
            </div>

            {{-- COLONNE 4 : LÉGAL --}}
            <div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Légal</h3>
                <ul role="list" class="mt-4 space-y-3">
                    <li>
                        <a href="#" class="text-sm text-slate-500 hover:text-emerald-600 transition">Confidentialité</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-slate-500 hover:text-emerald-600 transition">Conditions
                            (CGU)</a>
                    </li>
                    <li>
                        <a href="#" class="text-sm text-slate-500 hover:text-emerald-600 transition">À propos</a>
                    </li>
                </ul>
            </div>

        </div>

        {{-- BARRE DU BAS --}}
        <div class="mt-12 border-t border-slate-100 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-slate-400">
                &copy; {{ date('Y') }} InfinyStory. Tous droits réservés.
            </p>
            <p class="text-xs text-slate-400 flex items-center gap-1">
                Fait avec <span class="text-red-400">❤</span> et Livewire
            </p>
        </div>
    </div>
</footer>