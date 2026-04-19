<?php
use Livewire\Component;
use Livewire\Attributes\Layout;

new #[Layout('layouts.app')] class extends Component
{
};
?>

<div class="bg-stone-950 text-stone-200 min-h-screen font-sans selection:bg-amber-500 selection:text-white">
    <!-- Moderní Minimalistická Navigace -->
    <nav class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[90%] max-w-md">
        <div class="bg-stone-900/80 backdrop-blur-lg border border-white/10 rounded-full px-6 py-3 flex justify-around text-xs font-medium uppercase tracking-[0.2em]">
            <a href="#uvod" class="hover:text-amber-400 transition">Start</a>
            <a href="#program" class="hover:text-amber-400 transition">Plán</a>
            <a href="#info" class="hover:text-amber-400 transition">Info</a>
            <a href="#dary" class="hover:text-amber-400 transition">Dary</a>
        </div>
    </nav>

    <!-- Fullscreen Hero s Split Designem -->
    <section id="uvod" class="relative h-screen flex flex-col md:flex-row overflow-hidden">
        <div class="h-1/2 md:h-full md:w-1/2 relative group overflow-hidden">
            <img src="/hero-beer.jpg" alt="Svatba" class="w-full h-full object-cover grayscale-[0.3] group-hover:grayscale-0 transition duration-700">
            <div class="absolute inset-0 bg-stone-950/20"></div>
        </div>

        <div class="h-1/2 md:h-full md:w-1/2 bg-stone-900 flex flex-col justify-center px-8 md:px-16 border-t md:border-t-0 md:border-l border-amber-900/30">
            <span class="text-amber-500 font-mono tracking-widest text-sm mb-4 uppercase">Svatební Oznámení</span>
            <h1 class="text-6xl md:text-8xl font-black mb-6 leading-none">Jana<br><span class="text-amber-600">&</span> Petr</h1>
            <p class="text-xl md:text-2xl font-light text-stone-400 mb-8 border-l-2 border-amber-600 pl-6">
                20. června 2026<br>
                <span class="text-sm uppercase tracking-tighter opacity-60">Pivovar u Cesty, Plzeň</span>
            </p>
        </div>
    </section>

    <!-- Kontrastní Obsah -->
    <main class="max-w-4xl mx-auto px-6 py-24">

        <!-- Sekce Program - Brutalistický styl -->
        <section id="program" class="mb-32">
            <div class="flex items-baseline gap-4 mb-16">
                <h2 class="text-5xl font-black italic tracking-tighter uppercase">Program</h2>
                <div class="h-px flex-1 bg-amber-900/50"></div>
            </div>

            <div class="grid gap-1 border-t border-amber-900/30">
                <div class="group grid md:grid-cols-[150px_1fr] py-12 border-b border-amber-900/30 hover:bg-stone-900 transition-colors px-4">
                    <span class="text-3xl font-mono text-amber-600 group-hover:translate-x-2 transition-transform italic">13:00</span>
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Svatební obřad</h3>
                        <p class="text-stone-400 max-w-md">Na nádvoří pivovaru, pod starým dubem, kde začíná náš společný příběh.</p>
                    </div>
                </div>
                <div class="group grid md:grid-cols-[150px_1fr] py-12 border-b border-amber-900/30 hover:bg-stone-900 transition-colors px-4">
                    <span class="text-3xl font-mono text-amber-600 group-hover:translate-x-2 transition-transform italic">15:00</span>
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Hostina & Sud</h3>
                        <p class="text-stone-400 max-w-md">Tradiční české menu a slavnostní narážení prvního svatebního speciálu.</p>
                    </div>
                </div>
                <div class="group grid md:grid-cols-[150px_1fr] py-12 border-b border-amber-900/30 hover:bg-stone-900 transition-colors px-4">
                    <span class="text-3xl font-mono text-amber-600 group-hover:translate-x-2 transition-transform italic">19:00</span>
                    <div>
                        <h3 class="text-2xl font-bold mb-2">Večerní jízda</h3>
                        <p class="text-stone-400 max-w-md">DJ, neomezená degustace a tanec až do ranního kuropění.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sekce Info - Karty s hloubkou -->
        <section id="info" class="grid md:grid-cols-2 gap-6 mb-32">
            <div class="bg-stone-900 border border-white/5 p-10 rounded-3xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 text-9xl text-white/5 font-black uppercase pointer-events-none">Drs</div>
                <h3 class="text-amber-500 font-mono text-xs mb-6 tracking-[0.3em] uppercase">Vzhled</h3>
                <h2 class="text-3xl font-bold mb-4">Dresscode</h2>
                <p class="text-stone-400 leading-relaxed">
                    Svatba je v neformálním stylu. Pánové bez kravat, dámy v pohodlném. Barvy: zlatá, bílá a hnědá – jako správně načepovaná dvanáctka.
                </p>
            </div>

            <div class="bg-amber-600 p-10 rounded-3xl text-stone-950 flex flex-col justify-between group">
                <div>
                    <h3 class="text-stone-950/60 font-mono text-xs mb-6 tracking-[0.3em] uppercase">Logistika</h3>
                    <h2 class="text-3xl font-bold mb-4">Ubytování</h2>
                    <p class="font-medium leading-relaxed mb-8 text-stone-900">
                        Přímo v areálu máme omezenou kapacitu. Pokud plánujete zůstat přes noc, dejte nám vědět co nejdříve.
                    </p>
                </div>
                <a href="#" class="bg-stone-950 text-white px-8 py-4 rounded-full font-bold text-center hover:scale-105 transition active:scale-95">Otevřít Mapu</a>
            </div>
        </section>

        <!-- Sekce Dary - Minimalismus -->
        <section id="dary" class="text-center py-24 border-y border-amber-900/30">
            <h2 class="text-4xl font-black mb-8 uppercase italic tracking-tighter">Svatební dary</h2>
            <div class="max-w-xl mx-auto mb-12">
                <p class="text-xl text-stone-400 italic">
                    "Největším darem pro nás bude vaše přítomnost a plný půllitr v ruce. Pokud byste nás chtěli obdarovat, budeme vděčni za příspěvek na naši svatební cestu."
                </p>
            </div>
            <div class="inline-block bg-stone-900 px-8 py-6 rounded-2xl border border-amber-600/30">
                <span class="block text-amber-500 font-mono text-sm mb-2">Číslo účtu</span>
                <span class="text-2xl font-mono font-bold tracking-widest uppercase">CZK 123456789 / 0100</span>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-black py-20 px-6">
        <div class="max-w-4xl mx-auto flex flex-col items-center gap-8">
            <div class="text-5xl">🍻</div>
            <p class="text-stone-600 font-mono text-xs uppercase tracking-[0.5em]">Jana & Petr — 2026</p>
            <div class="h-12 w-px bg-gradient-to-b from-amber-600 to-transparent"></div>
        </div>
    </footer>
</div>
