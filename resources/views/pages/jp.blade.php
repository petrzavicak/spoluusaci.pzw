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
    public $mail_error = false;

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
        ], [
            'sender_name.required' => 'お名前を入力してください。',
            'sender_name.min' => '3文字以上で入力してください。',
            'guests.*.name.required' => 'お名前は必須です。',
        ]);

        $this->mail_error = false;

        $zprava = "Odesílatel (JP): " . $this->sender_name . "\n\nOmezení hostů:\n";
        foreach($this->guests as $guest) {
            $zprava .= "- " . $guest['name'] . ": " . ($guest['restriction'] ?: 'なし') . "\n";
        }

        try {
            \Illuminate\Support\Facades\Mail::raw($zprava, function($message) {
                $message->to('mikusekvitek@seznam.cz')
                        ->subject('Nové stravovací omezení (JP) - Svatba');
            });
            $this->form_submitted = true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error sending JP wedding email: ' . $e->getMessage());
            $this->mail_error = true;
        }
    }
};
?>

<div class="bg-stone-50 text-stone-900 min-h-screen font-sans selection:bg-emerald-700 selection:text-white">
    <!-- Moderní Plovoucí Navigace -->
    <nav class="fixed top-6 left-1/2 -translate-x-1/2 z-50 w-[95%] max-w-lg">
        <div class="bg-white/80 backdrop-blur-lg border border-emerald-900/10 shadow-lg rounded-full px-6 py-3 flex justify-around items-center text-[9px] md:text-xs font-bold uppercase tracking-tighter md:tracking-wider text-emerald-900">
            <a href="#info" class="hover:text-emerald-600 transition px-1">情報 (Info)</a>
            <a href="#stravovani" class="hover:text-emerald-600 transition px-1">食事 (Menu)</a>
            <a href="#dary" class="hover:text-emerald-600 transition px-1">贈り物 (Gifts)</a>
            <a href="#foto" class="hover:text-emerald-600 transition px-1">写真 (Photo)</a>
            <a href="#kontakt" class="hover:text-emerald-600 transition">連絡先 (Contact)</a>
            <a href="/" class="text-emerald-600 hover:text-emerald-700 transition font-black">CZ</a>
            <div class="h-4 w-px bg-emerald-900/20 mx-1"></div>
            <span class="text-red-600 font-black">JP</span>
        </div>
    </nav>

    <!-- Hero Sekce -->
    <section id="uvod" class="relative h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0 z-0">
            <img src="/hero-beer.jpg?v={{ file_exists(public_path('hero-beer.jpg')) ? filemtime(public_path('hero-beer.jpg')) : time() }}" alt="Wedding" class="w-full h-full object-cover brightness-[0.75]">
            <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/80 via-transparent to-transparent"></div>
        </div>

        <div class="relative z-10 text-center px-4 -mt-40 md:-mt-48">
            <p class="text-white text-xl md:text-2xl mb-4 drop-shadow-lg font-playfair tracking-tight">Wedding</p>
            <h1 class="text-5xl md:text-8xl mb-12 text-white drop-shadow-[0_4px_16px_rgba(0,0,0,1)] font-playfair font-extrabold tracking-tight flex flex-col md:flex-row items-center justify-center gap-2 md:gap-6">
                <span>Ester</span>
                <span class="relative inline-block">
                    <span class="text-amber-500/80 not-italic font-cormorant italic tracking-normal">&</span>
                    <span class="absolute -bottom-2 left-0 w-full h-1 bg-amber-500/50 rounded-full shadow-sm"></span>
                </span>
                <span>Vít</span>
            </h1>
        </div>

        <!-- Odpočítávadlo a Info -->
        <div class="absolute bottom-10 left-0 w-full z-10 px-4 space-y-8">
            <div class="text-center space-y-2">
                <p class="text-2xl md:text-4xl text-white font-bold drop-shadow-[0_2px_10px_rgba(0,0,0,1)] font-playfair">2026年8月15日</p>
                <p class="text-lg md:text-2xl text-amber-100 font-medium drop-shadow-[0_1px_6px_rgba(0,0,0,1)] italic tracking-wide">ドラニ・ウ・オロモウツェ (Dolany)</p>
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
                    <span class="text-[9px] uppercase font-bold tracking-widest opacity-80 text-white/90">日 (Days)</span>
                </div>
                <div class="bg-black/20 backdrop-blur-md p-3 rounded-2xl border border-white/10 min-w-[75px] md:min-w-[85px] shadow-2xl">
                    <span class="block text-3xl md:text-4xl font-black text-amber-500/80" x-text="h">00</span>
                    <span class="text-[9px] uppercase font-bold tracking-widest opacity-80 text-white/90">時間 (Hrs)</span>
                </div>
                <div class="bg-black/20 backdrop-blur-md p-3 rounded-2xl border border-white/10 min-w-[75px] md:min-w-[85px] shadow-2xl">
                    <span class="block text-3xl md:text-4xl font-black text-amber-500/80" x-text="m">00</span>
                    <span class="text-[9px] uppercase font-bold tracking-widest opacity-80 text-white/90">分 (Mins)</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto px-6 py-20 space-y-32">

        <!-- Info Section (Schedule, Transportation, Dresscode, Kids) -->
        <div id="info" class="scroll-mt-24 space-y-32">

            <!-- Schedule -->
            <section id="program">
                <h2 class="text-4xl md:text-5xl text-center mb-16 text-emerald-900 font-extrabold uppercase tracking-tighter">結婚式のスケジュール</h2>

                <div class="grid md:grid-cols-2 gap-12">
                    <!-- Ceremony -->
                    <div class="space-y-6">
                        <div class="bg-white p-8 rounded-3xl shadow-xl border-t-4 border-emerald-700 relative overflow-hidden group">
                             <div class="absolute -right-4 -top-4 text-7xl text-emerald-50/50 font-extrabold pointer-events-none z-0">11:30</div>
                             <div class="relative z-10">
                                <h3 class="text-2xl font-black text-emerald-900 mb-2 uppercase italic">結婚式 (挙式)</h3>
                                <p class="text-lg font-bold text-amber-600/80 mb-4 tracking-wide">11:30 | 聖マタイ教会 (ドラニ)</p>
                                <div class="rounded-2xl overflow-hidden shadow-inner border border-stone-200">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2583.3731778201955!2d17.32173271246656!3d49.6472674713309!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47124bdeafcaf7f7%3A0xd97c067f768d8edc!2sKostel%20sv.%20Matou%C5%A1e!5e0!3m2!1scs!2scz!4v1776713108103!5m2!1scs!2scz" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
                             </div>
                        </div>
                    </div>

                    <!-- Reception -->
                    <div class="space-y-6">
                        <div class="bg-white p-8 rounded-3xl shadow-xl border-t-4 border-amber-500/50 relative overflow-hidden group">
                             <div class="absolute -right-4 -top-4 text-7xl text-amber-50/50 font-extrabold pointer-events-none z-0">13:30</div>
                             <div class="relative z-10">
                                <h3 class="text-2xl font-black text-emerald-900 mb-2 uppercase italic">披露宴 & パーティー</h3>
                                <div class="space-y-6 mb-6">
                                    <div>
                                        <h4 class="font-bold text-amber-600/80 tracking-wide uppercase text-sm mb-1">ウェディングランチ</h4>
                                        <p class="text-lg font-bold text-emerald-900 leading-tight">13:30 | ボフニョヴィツェ文化会館</p>
                                        <p class="text-xs italic text-stone-500 mt-1">時間は目安です</p>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-emerald-700 tracking-wide uppercase text-sm mb-1">パーティー</h4>
                                        <p class="text-lg font-bold text-emerald-900 leading-tight">16:30 | ボフニョヴィツェ文化会館</p>
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

            <!-- Transportation & Accommodation -->
            <section id="doprava" class="scroll-mt-24 space-y-12">
                <h2 class="text-4xl md:text-5xl text-center mb-16 text-emerald-900 font-extrabold uppercase tracking-tighter">交通手段 & 宿泊について</h2>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Transportation -->
                    <div class="bg-white p-8 rounded-3xl shadow-lg border-l-8 border-emerald-700">
                        <h3 class="text-xl font-black text-emerald-900 mb-6 uppercase italic">アクセス</h3>
                        <div class="space-y-6 text-stone-600">
                            <div>
                                <h4 class="font-bold text-emerald-800 uppercase text-xs mb-2">プラハからの移動</h4>
                                <p class="text-sm">プラハ駅から鉄道（レイルジェット等）でオロモウツ駅（Olomouc hl.n.）までお越しください（約2時間〜2時間半）。</p>
                            </div>
                            <div>
                                <h4 class="font-bold text-emerald-800 uppercase text-xs mb-2">挙式会場（ドラニ）への移動</h4>
                                <p class="text-sm">オロモウツ駅から挙式会場までは、私たちが車での送迎を手配いたします。事前に到着時間をご連絡ください。</p>
                            </div>
                            <div class="bg-amber-50 p-4 rounded-xl border border-amber-100 italic">
                                <h4 class="font-bold text-amber-800 uppercase text-[10px] mb-1">披露宴会場への移動 (約5km)</h4>
                                <p class="text-sm text-amber-900 font-medium">チェコの伝統的な「ウェディング・コンボイ（車列）」を組んで、皆で一斉にクラクションを鳴らしながら移動します。日本からの皆様も車に分乗して移動できるよう手配いたしますのでご安心ください。</p>
                            </div>
                        </div>
                    </div>

                    <!-- Accommodation -->
                    <div class="bg-white p-8 rounded-3xl shadow-lg border-l-8 border-amber-500/50">
                        <h3 class="text-xl font-black text-emerald-900 mb-6 uppercase italic">宿泊のおすすめ</h3>
                        <div class="space-y-6 text-stone-600 text-sm leading-relaxed">
                            <p>日本からの皆様には、近隣のオロモウツ（Olomouc）市内のホテルをお勧めしています。</p>
                            <p>オロモウツは世界遺産の「聖三位一体柱」がある歴史的な美しい街で、英語が通じるホテルも多く快適に滞在いただけます。観光も兼ねてぜひお楽しみください。</p>
                            <p class="font-bold bg-stone-50 p-4 rounded-xl border border-stone-200">
                                夜の披露宴終了後には、オロモウツ市内のホテルまで無料のシャトル車を用意しております。
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Dresscode -->
            <section id="dresscode" class="bg-emerald-900 p-10 md:p-16 rounded-[3rem] text-white shadow-2xl relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-amber-400 opacity-10 rounded-full -mr-16 -mt-16"></div>
                <h2 class="text-4xl font-black mb-8 uppercase italic">ドレスコード</h2>
                <p class="text-xl leading-relaxed mb-10 text-emerald-50">
                    私たちはビールが大好きで、ビールを通じた縁も大切にしています。そこで、今回の結婚式のテーマカラーは「<span class="text-amber-400 font-bold">ビール・パレット</span>」に決めました。もしよろしければ、ビールの色合いを意識したフォーマルな装いでお越しください：
                </p>

                <div class="flex flex-wrap gap-6 mb-10">
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#F2C14E]"></div>
                        <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70 italic">Pale</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#D48F1A]"></div>
                        <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70 italic">Lager</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#BA8E23]"></div>
                        <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70 italic">Gold</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#9B5211]"></div>
                        <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70 italic">Amber</span>
                    </div>
                    <div class="flex flex-col items-center gap-2">
                        <div class="w-16 h-16 rounded-2xl shadow-lg border-2 border-white/20 bg-[#5C2F00]"></div>
                        <span class="text-[10px] font-bold uppercase tracking-tighter opacity-70 italic">Dark</span>
                    </div>
                </div>

                <p class="italic text-emerald-200 border-l-2 border-amber-400 pl-6">
                    服装の指定は決して強制ではありません。一番大切なのは、皆様がリラックスして一日を楽しんでくださることです。
                </p>
            </section>

            <!-- Kids Section -->
            <section id="deti" class="scroll-mt-24 bg-white p-10 md:p-16 rounded-[3rem] shadow-lg border-t-8 border-amber-500/30">
                <div class="flex flex-col md:flex-row items-center gap-10">
                    <div class="text-7xl">🧸</div>
                    <div class="flex-1">
                        <h2 class="text-4xl font-black mb-6 text-emerald-900 uppercase italic">お子様連れのゲストへ</h2>
                        <p class="text-lg text-stone-600 leading-relaxed mb-6">
                            私たちの結婚式は、お子様も歓迎の「<span class="text-emerald-700 italic">baby friendly</span>」な一日です。披露宴会場にはキッズコーナーを用意しております。
                        </p>
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-stone-50 p-6 rounded-2xl border border-stone-100">
                                <h4 class="font-bold text-emerald-800 uppercase text-xs mb-3 flex items-center gap-2">
                                    <span>🎨</span> キッズコーナー
                                </h4>
                                <p class="text-sm text-stone-500">プレイマットやおもちゃ、絵本などを用意しております。</p>
                            </div>
                            <div class="bg-stone-50 p-6 rounded-2xl border border-stone-100">
                                <h4 class="font-bold text-emerald-800 uppercase text-xs mb-3 flex items-center gap-2">
                                    <span>🍼</span> 親御様へのサポート
                                </h4>
                                <p class="text-sm text-stone-500">会場内にはおむつ替えのスペースも完備しております。</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        <!-- Dietary Restrictions Section -->
        <section id="stravovani" class="scroll-mt-24">
            <div class="bg-white p-8 md:p-12 rounded-[3rem] shadow-xl border-t-8 border-emerald-900">
                <h2 class="text-3xl md:text-4xl font-black text-emerald-900 mb-6 uppercase italic text-center">お食事に関するご要望</h2>
                <p class="text-center text-stone-600 mb-10 max-w-xl mx-auto">
                    アレルギーや苦手な食材、食事制限（ベジタリアン、グルテンフリー等）がございましたら、事前にこちらからお知らせください。
                </p>

                @if($form_submitted)
                    <div class="bg-emerald-50 border-2 border-emerald-200 p-8 rounded-3xl text-center" x-data="{}" x-init="setTimeout(() => { $el.classList.add('animate-[bounce_0.5s_ease-in-out_2]') }, 100)">
                        <span class="text-4xl mb-4 block">✅</span>
                        <h3 class="text-2xl font-bold text-emerald-900 mb-2">送信完了</h3>
                        <p class="text-emerald-700 font-medium">新郎新婦へ情報が送信されました。ありがとうございます！</p>
                        <button wire:click="$set('form_submitted', false)" class="mt-6 text-emerald-600 font-bold uppercase text-xs hover:underline">追加で送信する</button>
                    </div>
                @else
                    <form wire:submit.prevent="submitForm" class="space-y-8 max-w-2xl mx-auto">
                        @if($mail_error)
                            <div class="bg-red-50 border-2 border-red-200 p-6 rounded-2xl text-center mb-6">
                                <p class="text-red-700 font-bold">エラーが発生しました。</p>
                                <p class="text-red-600 text-sm mt-1">時間をおいて再度お試しいただくか、直接ご連絡ください。</p>
                            </div>
                        @endif
                        <div class="space-y-2">
                            <label class="block text-xs font-bold uppercase tracking-widest text-emerald-800 ml-4">代表者のお名前 / ご家族名</label>
                            <input type="text" wire:model="sender_name" placeholder="例：山田 太郎 / 山田家" class="w-full bg-stone-50 border-2 border-stone-100 rounded-2xl px-6 py-4 focus:border-amber-500 focus:ring-0 transition-colors">
                            @error('sender_name') <span class="text-red-500 text-xs ml-4">{{ $message }}</span> @enderror
                        </div>

                        <div class="space-y-4">
                            <label class="block text-xs font-bold uppercase tracking-widest text-emerald-800 ml-4">ご出席者と制限の内容</label>

                            @foreach($guests as $index => $guest)
                                <div class="flex flex-col md:flex-row gap-3 items-start">
                                    <div class="w-full md:w-1/3">
                                        <input type="text" wire:model="guests.{{ $index }}.name" placeholder="お名前" class="w-full bg-stone-50 border-2 border-stone-100 rounded-xl px-4 py-3 focus:border-amber-500 focus:ring-0 transition-colors">
                                        @error('guests.'.$index.'.name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="w-full md:w-2/3 flex gap-2">
                                        <input type="text" wire:model="guests.{{ $index }}.restriction" placeholder="例：小麦アレルギー、ベジタリアン等..." class="w-full bg-stone-50 border-2 border-stone-100 rounded-xl px-4 py-3 focus:border-amber-500 focus:ring-0 transition-colors">
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
                                <span class="text-xl">+</span> 行を追加する
                            </button>

                            <button type="submit" class="w-full md:w-auto bg-emerald-900 text-amber-100 px-12 py-4 rounded-2xl font-black uppercase tracking-widest shadow-xl hover:bg-emerald-800 hover:-translate-y-1 transition-all active:scale-95">
                                送信する
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </section>

        <!-- Gifts Section (Adapted for Japanese) -->
        <section id="dary" class="text-center bg-white p-12 md:p-20 rounded-[3rem] shadow-lg border-t-8 border-amber-500/30 scroll-mt-24">
            <h2 class="text-4xl mb-10 text-emerald-900 font-extrabold uppercase tracking-tight">お祝い（贈り物）について</h2>
            <div class="max-w-2xl mx-auto space-y-8 leading-relaxed">
                <p class="text-xl italic text-stone-700">
                    「皆様のご出席こそが、私たちにとって最大の贈り物です」
                </p>
                <div class="h-px w-20 bg-amber-400 mx-auto"></div>
                <div class="text-stone-600 text-sm space-y-4 text-left">
                    <p>チェコの結婚式では、日本のような形式的な「ご祝儀」のルールはございません。当日はお祝いの言葉と共に、カードやささやかな贈り物をいただくことが一般的です。</p>
                    <p>もし、お祝いの気持ちとして贈り物を検討いただける場合は、新生活の準備やニューヨークへの新婚旅行の足しになるよう、金銭でのご祝儀をいただければ大変ありがたく存じます。</p>
                    <p>形式や金額には一切決まりはございません。皆様の温かいお気持ちだけで十分ですので、どうぞお気になさらないでください。</p>
                </div>
            </div>
        </section>

        <!-- Gallery -->
        <section id="foto" class="scroll-mt-24">
            <h2 class="text-4xl md:text-5xl text-center mb-16 text-emerald-900 font-extrabold uppercase tracking-tighter">フォトギャラリー</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @for ($i = 1; $i <= 6; $i++)
                <div class="aspect-square overflow-hidden rounded-2xl shadow-md group">
                    <img src="/photos/photo{{ $i }}.jpg?v={{ file_exists(public_path('photos/photo' . $i . '.jpg')) ? filemtime(public_path('photos/photo' . $i . '.jpg')) : time() }}" alt="Photo {{ $i }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                </div>
                @endfor
            </div>
            <p class="text-center text-stone-400 text-xs mt-6 italic">私たちの思い出の一部です...</p>
        </section>

        <!-- Contact Section -->
        <section id="kontakt" class="scroll-mt-24 text-center">
            <h2 class="text-4xl mb-12 text-emerald-900 font-extrabold uppercase">お問い合わせ (RSVP)</h2>
            <p class="text-lg mb-12 text-stone-600 max-w-lg mx-auto leading-relaxed">
                ご不明な点やご欠席のご連絡は、新郎のヴィートまで、WhatsAppまたは直接お電話にてご連絡ください。
            </p>

            <div class="max-w-md mx-auto">
                <div class="group block bg-white p-8 rounded-3xl shadow-lg border border-emerald-100 transition-all duration-300">
                    <span class="block text-emerald-600 font-bold uppercase tracking-[0.2em] text-xs mb-4">Groom (新郎)</span>
                    <h4 class="text-3xl font-black text-emerald-900 transition-colors">ヴィート</h4>
                    <p class="text-stone-500 font-mono mt-2">+420 731 626 020</p>
                    <p class="text-xs text-stone-400 mt-4 italic font-sans uppercase">WhatsApp Available</p>
                </div>
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
        <p class="font-bold uppercase tracking-[0.3em] text-[10px] font-playfair">&copy; 2026 ESTER & VÍT</p>
        <div class="mt-4 h-1 w-12 bg-emerald-700 mx-auto rounded-full"></div>
    </footer>
</div>
