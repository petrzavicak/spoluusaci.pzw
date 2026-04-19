<?php
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

new #[Layout('layouts.app')] class extends Component
{
    public $weddingDate = '2026-08-15 11:30:00';

    public function placeholder()
    {
        return <<<'HTML'
            <div class="h-screen flex items-center justify-center bg-emerald-900 text-amber-200">
                <div class="animate-pulse text-2xl font-serif">Načítání...</div>
            </div>
        HTML;
    }
};
?>

<div class="bg-stone-50 text-stone-900 min-h-screen font-sans selection:bg-emerald-700 selection:text-white">
    <!-- Moderní Plovoucí Navigace (Styl z verze 2) -->
    <nav class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-md">
        <div class="bg-white/80 backdrop-blur-lg border border-emerald-900/10 shadow-lg rounded-full px-6 py-3 flex justify-around text-[10px] md:text-xs font-bold uppercase tracking-wider text-emerald-900">
            <a href="#uvod" class="hover:text-emerald-600 transition">Úvod</a>
            <a href="#program" class="hover:text-emerald-600 transition">Harmonogram</a>
            <a href="#doprava" class="hover:text-emerald-600 transition">Doprava</a>
            <a href="#dary" class="hover:text-emerald-600 transition">Dary</a>
            <a href="#kontakt" class="hover:text-emerald-600 transition">Kontakt</a>
        </div>
    </nav>

    <!-- Hero Sekce -->
    <section id="uvod" class="relative h-screen flex items-center justify-center overflow-hidden pb-10">
        <div class="absolute inset-0 z-0">
            <img src="/hero-beer.jpg" alt="Svatba" class="w-full h-full object-cover brightness-[0.75]">
            <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/80 via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 text-center px-4 -mt-32 md:-mt-40">
            <h1 class="text-6xl md:text-8xl mb-4 text-white drop-shadow-[0_4px_16px_rgba(0,0,0,1)] font-montserrat font-extrabold tracking-tight">
                Ester <span class="text-amber-400 not-italic font-cormorant italic tracking-normal mx-2">&</span> Vítek
            </h1>
            <div class="w-24 h-1.5 bg-amber-500 mx-auto mb-8 rounded-full shadow-lg"></div>
            <p class="text-2xl md:text-4xl text-white font-bold drop-shadow-[0_2px_10px_rgba(0,0,0,1)] mb-2">15. srpna 2026</p>
            <p class="text-lg md:text-2xl text-amber-100 font-medium drop-shadow-[0_1px_6px_rgba(0,0,0,1)] italic">Dolany u Olomouce</p>
        </div>

        <!-- Odpočítávadlo (Posunuto úplně dolů) -->
        <div class="absolute bottom-6 left-0 w-full z-10 px-4">
            <div x-data="{
                d: '00', h: '00', m: '00',
                init() {
                    const target = new Date('2026-08-15T11:30:00').getTime();
                    const update = () => {
                        const now = new Date().getTime();
                        const diff = target - now;
                        if (diff <= 0) return;
                        this.d = Math.floor(diff / (1000 * 60 * 60 * 24)).toString().padStart(2, '0');
                        this.h = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)).toString().padStart(2, '0');
                        this.m = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60)).toString().padStart(2, '0');
                    };
                    update();
                    setInterval(update, 1000);
                }
            }" class="flex justify-center gap-3 text-white max-w-sm mx-auto">
                <div class="bg-black/20 backdrop-blur-md p-3 rounded-2xl border border-white/10 min-w-[70px] shadow-2xl">
                    <span class="block text-2xl md:text-3xl font-black text-amber-400" x-text="d">00</span>
                    <span class="text-[9px] uppercase font-bold tracking-widest opacity-80">Dní</span>
                </div>
                <div class="bg-black/20 backdrop-blur-md p-3 rounded-2xl border border-white/10 min-w-[70px] shadow-2xl">
                    <span class="block text-2xl md:text-3xl font-black text-amber-400" x-text="h">00</span>
                    <span class="text-[9px] uppercase font-bold tracking-widest opacity-80">Hodin</span>
                </div>
                <div class="bg-black/20 backdrop-blur-md p-3 rounded-2xl border border-white/10 min-w-[70px] shadow-2xl">
                    <span class="block text-2xl md:text-3xl font-black text-amber-400" x-text="m">00</span>
                    <span class="text-[9px] uppercase font-bold tracking-widest opacity-80">Minut</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Obsah -->
    <main class="max-w-4xl mx-auto px-6 py-20 space-y-32">

        <!-- Sekce Program & Mapy -->
        <section id="program" class="scroll-mt-24">
            <h2 class="text-4xl md:text-5xl text-center mb-16 text-emerald-900 font-extrabold uppercase tracking-tighter">Svatební harmonogram</h2>

            <div class="grid md:grid-cols-2 gap-12">
                <!-- Obřad -->
                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border-t-4 border-emerald-700 relative overflow-hidden group">
                         <div class="absolute -right-4 -top-4 text-7xl text-emerald-50/50 font-extrabold pointer-events-none z-0">11:30</div>
                         <div class="relative z-10">
                            <h3 class="text-2xl font-black text-emerald-900 mb-2 uppercase italic">Svatební obřad</h3>
                            <p class="font-bold text-amber-700 mb-4 tracking-wide">11:30 | Kostel sv. Matouše, Dolany</p>
                            <div class="rounded-2xl overflow-hidden shadow-inner border border-stone-200">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2583.94!2d17.3218!3d49.6371!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4712537f8f700001%3A0xc6c4f9a0d1e3d43d!2zS29zdGVsIHN2LiBNYXRvdZFl!5e0!3m2!1scs!2scz!4v1713554400000" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                         </div>
                    </div>
                </div>

                <!-- Hostina -->
                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border-t-4 border-amber-600 relative overflow-hidden group">
                         <div class="absolute -right-4 -top-4 text-7xl text-amber-50/50 font-extrabold pointer-events-none z-0">13:30</div>
                         <div class="relative z-10">
                            <h3 class="text-2xl font-black text-emerald-900 mb-2 uppercase italic">Svatební hostina</h3>
                            <div class="space-y-4 mb-6">
                                <div>
                                    <p class="font-bold text-amber-700 tracking-wide uppercase text-xs">Oběd (Rodina)</p>
                                    <p class="text-lg font-bold">13:30 | Kulturní dům, Bohuňovice</p>
                                </div>
                                <div>
                                    <p class="font-bold text-emerald-700 tracking-wide uppercase text-xs">Svatební raut & Párty (Všichni)</p>
                                    <p class="text-lg font-bold text-emerald-900">od 16:30 | Bohuňovice</p>
                                </div>
                            </div>
                            <div class="rounded-2xl overflow-hidden shadow-inner border border-stone-200">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2581.65!2d17.2825!3d49.6601!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47125470d24f0001%3A0xb6c7d9760086c91a!2zS3VsdHVybsOtIGTFrW0gQm9odcWIb3ZpY2U!5e0!3m2!1scs!2scz!4v1713554500000" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                            </div>
                         </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dresscode s barevnou paletou -->
        <section id="dresscode" class="bg-emerald-900 p-10 md:p-16 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-amber-400 opacity-10 rounded-full -mr-16 -mt-16"></div>
            <h2 class="text-4xl font-black mb-8 uppercase italic">Dresscode</h2>
            <p class="text-xl leading-relaxed mb-10 text-emerald-50">
                Svatba bude laděná do <span class="text-amber-400 font-bold">pivních barev</span>. Pokud hledáte inspiraci, doporučujeme elegantní módní kousky v odstínech pivní palety:
            </p>

            <div class="flex flex-wrap gap-6 mb-10">
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#F2C14E]"></div>
                    <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70">Světlé</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#D48F1A]"></div>
                    <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70">Ležák</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#9B5211]"></div>
                    <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70">Jantar</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#5C2F00]"></div>
                    <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70">Tmavé</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#FFFDF5]"></div>
                    <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70">Pěna</span>
                </div>
            </div>

            <p class="italic text-emerald-200 border-l-2 border-amber-400 pl-6">
                Je to však zcela dobrovolné – nejdůležitější je, abyste se cítili elegantně a pohodlně.
            </p>
        </section>

        <!-- Doprava a Ubytování -->
        <section id="doprava" class="scroll-mt-24 space-y-12">
            <h2 class="text-4xl md:text-5xl text-center mb-16 text-emerald-900 font-extrabold uppercase tracking-tighter">Doprava & Ubytování</h2>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Doprava -->
                <div class="bg-white p-8 rounded-3xl shadow-lg border-l-8 border-emerald-700">
                    <h3 class="text-xl font-black text-emerald-900 mb-6 uppercase italic">Jak se k nám dostat?</h3>
                    <div class="space-y-6 text-stone-600">
                        <div>
                            <h4 class="font-bold text-emerald-800 uppercase text-xs mb-2">Vlastním autem</h4>
                            <p class="text-sm">Sraz v 11:00 u kostela v Dolanech – budeme zdobit auta! Parkování u kostela je omezené, využijte parkoviště u ZŠ a MŠ Aloise Štěpánka přímo přes cestu.</p>
                        </div>
                        <div>
                            <h4 class="font-bold text-emerald-800 uppercase text-xs mb-2">Veřejnou dopravou</h4>
                            <p class="text-sm">Vlakem do Olomouce, poté autobusem do Dolan. Pokud potřebujete pomoci s dopravou z Olomouce do Dolan, kontaktujte s předstihem ženicha.</p>
                        </div>
                        <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 italic">
                            <h4 class="font-bold text-amber-800 uppercase text-[10px] mb-1">Přesun na hostinu</h4>
                            <p class="text-sm text-amber-900 font-medium">Do Bohuňovic pojedeme společně v koloně. Kdo nemáte vlastní auto, sveze Vás někdo ze svatebčanů – dejte vědět ženichovi.</p>
                        </div>
                    </div>
                </div>

                <!-- Ubytování -->
                <div class="bg-white p-8 rounded-3xl shadow-lg border-l-8 border-amber-600">
                    <h3 class="text-xl font-black text-emerald-900 mb-6 uppercase italic">Kde složit hlavu?</h3>
                    <div class="space-y-6 text-stone-600">
                        <p class="text-sm">Ubytování je k dispozici ve vybavených pokojích farního Domu v Dolanech (Komunita Blahoslavenství).</p>
                        <p class="text-sm font-bold bg-stone-50 p-4 rounded-xl border border-stone-200">
                            Kapacita je omezená (systém "kdo dřív přijde,..."), dejte prosím vědět ženichovi co nejdříve kvůli rezervaci.
                        </p>
                        <p class="text-sm">Po vyčerpání kapacity bude případně domluvena možnost přespání ve vlastním stanu na zahradě fary v Dolanech, případně lze po vlastní ose v hotelech/airbnb v Olomouci.</p>
                    </div>
                </div>
            </div>

            <!-- Noční rozvoz -->
            <div class="bg-stone-900 text-white p-8 rounded-3xl shadow-xl flex flex-col md:flex-row items-center gap-8 border-b-4 border-amber-500">
                <div class="text-5xl">🚗</div>
                <div>
                    <h3 class="text-xl font-black mb-2 uppercase italic text-amber-400">Večerní odvoz zajištěn</h3>
                    <p class="text-stone-300 leading-relaxed">
                        Nebojte se pořádně oslavovat. Večer i v noci budou k dispozici řidiči, kteří vás odvezou do Olomouce a okolí. Kontakt na ně bude k dispozici přímo na místě.
                    </p>
                </div>
            </div>
        </section>

        <!-- Sekce Dary -->
        <section id="dary" class="scroll-mt-24 text-center bg-white p-12 md:p-20 rounded-[3rem] border-2 border-dashed border-emerald-200 shadow-inner">
            <h2 class="text-4xl mb-10 text-emerald-900 font-extrabold uppercase">Svatební dary</h2>
            <div class="max-w-2xl mx-auto space-y-8">
                <p class="text-xl leading-relaxed italic text-stone-700">
                    Dobrosrdečnosti se meze nekladou, avšak nejraději budeme za dary ve formě aktiv s vysokou likviditou (tj. snadno přeměnitelné na peníze).
                </p>
                <div class="h-px w-20 bg-amber-400 mx-auto"></div>
                <p class="text-stone-600 leading-relaxed text-sm">
                    Kromě finančních prostředků ve formě peněz s tzv. nuceným oběhem (např. hotovost či pohledávky za bankami) přijmeme s vděkem i kryptoměny či investiční aktiva, jako jsou dluhopisy, směnky, majetkové cenné papíry apod. V aktuálním prostředí geopolitické nejistoty mohou být vhodné i kontrakty ke komoditám, ať už půjde o drahé kovy, ropu či zemědělské komodity s vyšší importní náročností. Zkrátka darovat nám můžete to, co znáte a čemu věříte.
                </p>
                <p class="text-emerald-900 font-bold italic">
                    Prostředky využijeme k založení společného jmění manželů a na svatební cestu do New Yorku. 🗽
                </p>
            </div>
        </section>

        <!-- Kontakt & Potvrzení -->
        <section id="kontakt" class="scroll-mt-24 text-center">
            <h2 class="text-4xl mb-12 text-emerald-900 font-extrabold uppercase">Potvrzení účasti</h2>
            <p class="text-lg mb-12 text-stone-600 max-w-lg mx-auto leading-relaxed">
                Dejte nám prosím vědět, zda dorazíte. Kontaktujte nás na WhatsAppu nebo telefonicky na číslech níže.
            </p>

            <div class="grid md:grid-cols-2 gap-8">
                <a href="tel:+420731626020" class="group bg-white p-8 rounded-3xl shadow-lg border border-emerald-100 hover:border-emerald-500 transition-all duration-300">
                    <span class="block text-emerald-600 font-bold uppercase tracking-[0.2em] text-xs mb-4">Ženich</span>
                    <h4 class="text-3xl font-black text-emerald-900 group-hover:text-emerald-600 transition-colors">Vítek</h4>
                    <p class="text-stone-500 font-mono mt-2">+420 731 626 020</p>
                </a>
                <a href="tel:+420730180967" class="group bg-white p-8 rounded-3xl shadow-lg border border-emerald-100 hover:border-emerald-500 transition-all duration-300">
                    <span class="block text-emerald-600 font-bold uppercase tracking-[0.2em] text-xs mb-4">Nevěsta</span>
                    <h4 class="text-3xl font-black text-emerald-900 group-hover:text-emerald-600 transition-colors">Ester</h4>
                    <p class="text-stone-500 font-mono mt-2">+420 730 180 967</p>
                </a>
            </div>
        </section>

    </main>

    <!-- Footer -->
    <footer class="bg-stone-900 text-stone-400 py-16 text-center text-sm border-t-8 border-emerald-950">
        <div class="mb-8 flex justify-center gap-6 text-3xl">
            <span>🍻</span>
            <span>💍</span>
            <span>🗽</span>
        </div>
        <p class="font-bold uppercase tracking-[0.3em] text-[10px]">&copy; 2026 Ester & Vítek</p>
        <div class="mt-4 h-1 w-12 bg-emerald-700 mx-auto rounded-full"></div>
    </footer>
</div>

<script>
// Funkce už není potřeba, logika je přímo v x-data
</script>
