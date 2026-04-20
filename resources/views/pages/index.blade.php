<?php
use Livewire\Component;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

new #[Layout('layouts.app')] class extends Component
{
    public $weddingDate = '2026-08-15 11:30:00';
    public $sender_name = '';
    public $guests = [['name' => '', 'restriction' => '']];
    public $form_submitted = false;

    public function addGuest()
    {
        $this->guests[] = ['name' => '', 'restriction' => ''];
    }

    public function removeGuest($index)
    {
        unset($this->guests[$index]);
        $this->guests = array_values($this->guests);
    }

    public function submitForm()
    {
        $this->validate([
            'sender_name' => 'required|min:3',
            'guests.*.name' => 'required|min:2',
        ]);

        $zprava = "Odesílatel: " . $this->sender_name . "\n\nOmezení hostů:\n";
        foreach($this->guests as $guest) {
            $zprava .= "- " . $guest['name'] . ": " . ($guest['restriction'] ?: 'není') . "\n";
        }

        try {
            \Illuminate\Support\Facades\Mail::raw($zprava, function($message) {
                $message->to('mikusekvitek@seznam.cz')
                        ->subject('Nové stravovací omezení - Svatba');
            });
            $this->form_submitted = true;
        } catch (\Exception $e) {
            $this->form_submitted = true;
        }
    }

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
        <div class="bg-white/80 backdrop-blur-lg border border-emerald-900/10 shadow-lg rounded-full px-6 py-3 flex justify-around text-[9px] md:text-xs font-bold uppercase tracking-tighter md:tracking-wider text-emerald-900">
            <a href="#uvod" class="hover:text-emerald-600 transition">Úvod</a>
            <a href="#program" class="hover:text-emerald-600 transition px-1">Info</a>
            <a href="#doprava" class="hover:text-emerald-600 transition px-1">Doprava</a>
            <a href="#stravovani" class="hover:text-emerald-600 transition px-1">Stravování</a>
            <a href="#dary" class="hover:text-emerald-600 transition">Dary</a>
            <a href="#kontakt" class="hover:text-emerald-600 transition">Kontakt</a>
        </div>
    </nav>

    <!-- Hero Sekce -->
    <section id="uvod" class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="/hero-beer.jpg" alt="Svatba" class="w-full h-full object-cover brightness-[0.75]">
            <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/80 via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 text-center px-4 -mt-40 md:-mt-48">
            <p class="text-white text-xl md:text-2xl uppercase tracking-[0.4em] font-light mb-4 drop-shadow-lg">Svatba</p>
            <h1 class="text-5xl md:text-8xl mb-12 text-white drop-shadow-[0_4px_16px_rgba(0,0,0,1)] font-playfair font-extrabold tracking-tight flex flex-col md:flex-row items-center justify-center gap-2 md:gap-6">
                <span>Ester</span>
                <span class="relative inline-block">
                    <span class="text-amber-500/80 not-italic font-cormorant italic tracking-normal">&</span>
                    <span class="absolute -bottom-2 left-0 w-full h-1 bg-amber-500/50 rounded-full shadow-sm"></span>
                </span>
                <span>Vítek</span>
            </h1>
        </div>

        <!-- Odpočítávadlo a Info (Posunuto úplně dolů) -->
        <div class="absolute bottom-10 left-0 w-full z-10 px-4 space-y-8">
            <div class="text-center space-y-2">
                <p class="text-2xl md:text-4xl text-white font-bold drop-shadow-[0_2px_10px_rgba(0,0,0,1)] font-playfair">15. srpna 2026</p>
                <p class="text-lg md:text-2xl text-amber-100 font-medium drop-shadow-[0_1px_6px_rgba(0,0,0,1)] italic tracking-wide">Dolany u Olomouce</p>
            </div>

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
                <div class="bg-black/20 backdrop-blur-md p-3 rounded-2xl border border-white/10 min-w-[75px] md:min-w-[85px] shadow-2xl">
                    <span class="block text-3xl md:text-4xl font-black text-amber-500/80" x-text="d">00</span>
                    <span class="text-[9px] uppercase font-bold tracking-widest opacity-80 text-white/90">Dní</span>
                </div>
                <div class="bg-black/20 backdrop-blur-md p-3 rounded-2xl border border-white/10 min-w-[75px] md:min-w-[85px] shadow-2xl">
                    <span class="block text-3xl md:text-4xl font-black text-amber-500/80" x-text="h">00</span>
                    <span class="text-[9px] uppercase font-bold tracking-widest opacity-80 text-white/90">Hodin</span>
                </div>
                <div class="bg-black/20 backdrop-blur-md p-3 rounded-2xl border border-white/10 min-w-[75px] md:min-w-[85px] shadow-2xl">
                    <span class="block text-3xl md:text-4xl font-black text-amber-500/80" x-text="m">00</span>
                    <span class="text-[9px] uppercase font-bold tracking-widest opacity-80 text-white/90">Minut</span>
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
                            <p class="text-lg font-bold text-amber-600/80 mb-4 tracking-wide">11:30 | Kostel sv. Matouše, Dolany</p>
                            <div class="rounded-2xl overflow-hidden shadow-inner border border-stone-200">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2583.3731778201955!2d17.32173271246656!3d49.6472674713309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47124bdeafcaf7f7%3A0xd97c067f768d8edc!2sKostel%20sv.%20Matou%C5%A1e!5e0!3m2!1scs!2scz!4v1776713108103!5m2!1scs!2scz" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            </div>
                         </div>
                    </div>
                </div>

                <!-- Hostina -->
                <div class="space-y-6">
                    <div class="bg-white p-8 rounded-3xl shadow-xl border-t-4 border-amber-500/50 relative overflow-hidden group">
                         <div class="absolute -right-4 -top-4 text-7xl text-amber-50/50 font-extrabold pointer-events-none z-0">13:30</div>
                         <div class="relative z-10">
                            <h3 class="text-2xl font-black text-emerald-900 mb-2 uppercase italic">Svatební hostina</h3>
                            <div class="space-y-6 mb-6">
                                <div>
                                    <h4 class="font-bold text-amber-600/80 tracking-wide uppercase text-sm mb-1">Svatební oběd (Rodina)</h4>
                                    <p class="text-lg font-bold text-emerald-900 leading-tight">13:30 | Kulturní dům, Bohuňovice</p>
                                    <p class="text-xs italic text-stone-500 mt-1">— čas je pouze orientační</p>
                                </div>
                                <div>
                                    <h4 class="font-bold text-emerald-700 tracking-wide uppercase text-sm mb-1">Svatební raut & Párty (Všichni)</h4>
                                    <p class="text-lg font-bold text-emerald-900 leading-tight">16:30 | Kulturní dům, Bohuňovice</p>
                                </div>
                            </div>
                            <div class="rounded-2xl overflow-hidden shadow-inner border border-stone-200">
                                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10331.464202313924!2d17.2873022!3d49.6568231!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x471249aecde78acd%3A0x5478040c105fbf69!2zS3VsdHVybsOtIGTFr20gQm9odcWIb3ZpY2U!5e0!3m2!1scs!2scz!4v1776713013526!5m2!1scs!2scz" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
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
                Svatba bude laděná do <span class="text-amber-400 font-bold">pivních barev</span>. Pokud hledáte inspiraci, doporučujeme formální módní kousky v odstínech pivní palety:
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
                    <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#BA8E23]"></div>
                    <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70">Zlaté</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#9B5211]"></div>
                    <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70">Jantar</span>
                </div>
                <div class="flex flex-col items-center gap-2">
                    <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#5C2F00]"></div>
                    <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70">Tmavé</span>
                </div>
            </div>

            <p class="italic text-emerald-200 border-l-2 border-amber-400 pl-6">
                Je to však zcela dobrovolné – nejdůležitější je, abyste se cítili elegantně a pohodlně.
            </p>
        </section>

        <!-- Sekce Děti -->
        <section id="deti" class="scroll-mt-24 bg-white p-10 md:p-16 rounded-[3rem] shadow-lg border-t-8 border-amber-500/30">
            <div class="flex flex-col md:flex-row items-center gap-10">
                <div class="text-7xl">🧸</div>
                <div class="flex-1">
                    <h2 class="text-4xl font-black mb-6 text-emerald-900 uppercase italic">Děti na svatbě</h2>
                    <p class="text-lg text-stone-600 leading-relaxed mb-6">
                        Naše svatba bude <span class="text-emerald-700 italic whitespace-nowrap">baby friendly</span>. Chceme, aby si den užili i ti nejmenší, proto bude v sále zajištěn dětský koutek.
                    </p>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-stone-50 p-6 rounded-2xl border border-stone-100">
                            <h4 class="font-bold text-emerald-800 uppercase text-xs mb-3 flex items-center gap-2">
                                <span>🎨</span> Dětský koutek
                            </h4>
                            <p class="text-sm text-stone-500">K dispozici bude podložka na hraní, hračky a knížky pro děti.</p>
                        </div>
                        <div class="bg-stone-50 p-6 rounded-2xl border border-stone-100">
                            <h4 class="font-bold text-emerald-800 uppercase text-xs mb-3 flex items-center gap-2">
                                <span>🍼</span> Zázemí pro rodiče
                            </h4>
                            <p class="text-sm text-stone-500">Pro vaše pohodlí je v místě konání k dispozici také přebalovací pult.</p>
                        </div>
                    </div>
                </div>
            </div>
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
                            <p class="text-sm">Vlakem do Olomouce, poté autobusem do Dolan. Pokud potřebujete pomoci s dopravou z Olomouce do Dolan, kontaktujte s předstihem ženicha, který se pokusí dopravu zařídit.</p>
                        </div>
                        <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 italic">
                            <h4 class="font-bold text-amber-800 uppercase text-[10px] mb-1">Přesun na hostinu (cca 5 km)</h4>
                            <p class="text-sm text-amber-900 font-medium">Do Bohuňovic pojedeme společně v koloně. Pokud nemáte vlastní auto, sveze Vás někdo ze svatebčanů – dejte vědět ženichovi.</p>
                        </div>
                    </div>
                </div>

                <!-- Ubytování -->
                <div class="bg-white p-8 rounded-3xl shadow-lg border-l-8 border-amber-500/50">
                    <h3 class="text-xl font-black text-emerald-900 mb-6 uppercase italic">Kde složit hlavu?</h3>
                    <div class="space-y-6 text-stone-600">
                        <p class="text-sm">Ubytování je k dispozici zdarma (či za dobrovolný příspěvek) ve vybavených pokojích farního Domu v Dolanech (Komunita Blahoslavenství).</p>
                        <p class="text-sm font-bold bg-stone-50 p-4 rounded-xl border border-stone-200">
                            Kapacita je omezená, kvůli rezervaci se nám prosím nahlaste do 31. 5.
                        </p>
                        <p class="text-sm leading-relaxed">Jde o systém "kdo dřív přijde,...", v případě vyčerpání kapacity se domluvíme individuálně, případně lze po vlastní ose využít hotely/airbnb v Olomouci.</p>
                    </div>
                </div>
            </div>

            <!-- Noční rozvoz -->
            <div class="bg-stone-900 text-white p-8 rounded-3xl shadow-xl flex flex-col md:flex-row items-center gap-8 border-b-4 border-amber-500/50">
                <div class="text-5xl">🚗</div>
                <div>
                    <h3 class="text-xl font-black mb-2 uppercase italic text-amber-600/80">Večerní odvoz zajištěn</h3>
                    <p class="text-stone-300 leading-relaxed">
                        Nebojte se pořádně oslavovat. Večer i v noci budou k dispozici řidiči, kteří vás odvezou do Olomouce a okolí. Kontakt na ně bude k dispozici přímo na místě.
                    </p>
                </div>
            </div>
        </section>


        <!-- Sekce Stravování -->
        <section id="stravovani" class="scroll-mt-24">
            <div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-xl border-t-8 border-emerald-900">
                <h2 class="text-3xl md:text-4xl font-black text-emerald-900 mb-6 uppercase italic text-center">Stravovací omezení</h2>
                <p class="text-center text-stone-600 mb-10 max-w-xl mx-auto">
                    Dejte nám prosím vědět, pokud máte vy nebo vaši blízcí nějaké alergie či dietní omezení, abychom pro vás mohli zajistit vhodné pohoštění.
                </p>

                @if($form_submitted)
                    <div class="bg-emerald-50 border-2 border-emerald-200 p-8 rounded-3xl text-center" x-data="{}" x-init="setTimeout(() => { $el.classList.add('animate-[bounce_0.5s_ease-in-out_2]') }, 100)">
                        <span class="text-4xl mb-4 block">✅</span>
                        <h3 class="text-2xl font-bold text-emerald-900 mb-2">Děkujeme!</h3>
                        <p class="text-emerald-700 font-medium">Informace byly úspěšně odeslány novomanželům.</p>
                        <button wire:click="$set('form_submitted', false)" class="mt-6 text-emerald-600 font-bold uppercase text-xs hover:underline">Poslat další</button>
                    </div>
                @else
                    <form wire:submit.prevent="submitForm" class="space-y-8 max-w-2xl mx-auto">
                        <div class="space-y-2">
                            <label class="block text-xs font-bold uppercase tracking-widest text-emerald-800 ml-4">Vaše jméno / Rodina</label>
                            <input type="text" wire:model="sender_name" placeholder="Např. Rodina Novákova" class="w-full bg-stone-50 border-2 border-stone-100 rounded-2xl px-6 py-4 focus:border-amber-500 focus:ring-0 transition-colors">
                            @error('sender_name') <span class="text-red-500 text-xs ml-4">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-4">
                            <label class="block text-xs font-bold uppercase tracking-widest text-emerald-800 ml-4">Seznam osob a omezení</label>

                            @foreach($guests as $index => $guest)
                                <div class="flex flex-col md:flex-row gap-3 items-start">
                                    <div class="w-full md:w-1/3">
                                        <input type="text" wire:model="guests.{{ $index }}.name" placeholder="Jméno" class="w-full bg-stone-50 border-2 border-stone-100 rounded-xl px-4 py-3 focus:border-amber-500 focus:ring-0 transition-colors">
                                        @error('guests.'.$index.'.name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-2/3 flex gap-2">
                                        <input type="text" wire:model="guests.{{ $index }}.restriction" placeholder="Např. bez lepku, laktózy, vegetarián..." class="w-full bg-stone-50 border-2 border-stone-100 rounded-xl px-4 py-3 focus:border-amber-500 focus:ring-0 transition-colors">
                                        @if(count($guests) > 1)
                                            <button type="button" wire:click="removeGuest({{ $index }})" class="p-3 text-stone-400 hover:text-red-500 transition-colors">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="flex flex-col md:flex-row justify-between items-center gap-6 pt-4">
                            <button type="button" wire:click="addGuest" class="text-emerald-700 font-bold uppercase text-xs flex items-center gap-2 hover:bg-emerald-50 px-4 py-2 rounded-full transition-colors">
                                <span class="text-xl">+</span> Přidat další osobu
                            </button>

                            <button type="submit" class="w-full md:w-auto bg-emerald-900 text-amber-100 px-12 py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-emerald-800 hover:-translate-y-1 transition-all active:scale-95">
                                Odeslat info
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </section>

        <!-- Sekce Dary -->
        <section id="dary" class="scroll-mt-24 text-center bg-white p-12 md:p-20 rounded-[3rem] border-2 border-dashed border-emerald-200 shadow-inner">
            <h2 class="text-4xl mb-10 text-emerald-900 font-extrabold uppercase">Svatební dary</h2>
            <div class="max-w-2xl mx-auto space-y-8">
                <p class="text-xl leading-relaxed italic text-stone-700">
                    Dobrosrdečnosti se meze nekladou, avšak nejraději budeme za dary ve formě aktiv s vysokou likviditou (tj. snadno přeměnitelných na peníze).
                </p>
                <div class="h-px w-20 bg-amber-400 mx-auto"></div>
                <p class="text-stone-600 leading-relaxed text-sm">
                    Kromě finančních prostředků ve formě peněz s tzv. nuceným oběhem (např. hotovost či pohledávky za bankami) přijmeme s vděkem i kryptoměny či investiční aktiva, jako jsou dluhopisy, směnky, majetkové cenné papíry apod. V aktuálním prostředí geopolitické nejistoty mohou být vhodné i kontrakty ke komoditám, ať už půjde o drahé kovy, ropu či zemědělské komodity s vyšší importní náročností. Zkrátka darovat nám můžete to, co znáte a čemu věříte.
                </p>
                <p class="text-emerald-900 font-bold italic">
                    Prostředky využijeme k založení společného jmění manželů, případně na svatební cestu do New Yorku. 🗽
                </p>
            </div>
        </section>

        <!-- Kontakt & Potvrzení -->
        <section id="kontakt" class="scroll-mt-24 text-center">
            <h2 class="text-4xl mb-12 text-emerald-900 font-extrabold uppercase">Potvrzení účasti</h2>
            <p class="text-lg mb-12 text-stone-600 max-w-lg mx-auto leading-relaxed">
                Dejte nám prosím vědět, zda dorazíte. Kontaktujte ženicha na WhatsAppu nebo telefonicky na čísle níže.
            </p>

            <div class="max-w-md mx-auto">
                <a href="tel:+420731626020" class="group block bg-white p-8 rounded-3xl shadow-lg border border-emerald-100 hover:border-emerald-500 transition-all duration-300">
                    <span class="block text-emerald-600 font-bold uppercase tracking-[0.2em] text-xs mb-4">Ženich</span>
                    <h4 class="text-3xl font-black text-emerald-900 group-hover:text-emerald-600 transition-colors">Vítek</h4>
                    <p class="text-stone-500 font-mono mt-2">+420 731 626 020</p>
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
