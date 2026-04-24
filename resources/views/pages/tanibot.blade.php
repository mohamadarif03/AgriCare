@extends('layouts.app')

@section('content')
<div class="flex flex-1 overflow-hidden">
        <!-- Main Content Area (3 Panels) -->
        <main class="flex-1 flex overflow-hidden bg-surface">
            
            <!-- Panel 1: Lahan Selection (Left Panel) -->
            <aside class="w-72 border-r border-outline-variant bg-surface-container-lowest hidden lg:flex flex-col">
                <div class="p-4 border-b border-outline-variant flex flex-col gap-3">
                    <a href="{{ route('tanibot') }}" class="w-full bg-surface-container hover:bg-surface-container-high text-primary rounded-xl py-3 px-4 font-body font-medium flex justify-start items-center gap-3 border border-outline-variant transition-colors shadow-sm">
                        <span class="material-symbols-outlined" data-icon="add">add</span>
                        Chat Baru
                    </a>
                </div>
                <div class="flex-1 overflow-y-auto px-2 py-4 space-y-2">
                    @foreach($sessions as $s)
                        <a class="block rounded-lg p-3 mx-2 transition-colors border {{ $selectedSession && $selectedSession->id === $s->id ? 'bg-primary-container/20 border-primary shadow-sm' : 'bg-surface border-transparent hover:bg-surface-container' }}"
                            href="{{ route('tanibot', ['session_id' => $s->id]) }}">
                            <p class="font-body text-sm font-semibold {{ $selectedSession && $selectedSession->id === $s->id ? 'text-primary' : 'text-on-surface' }} truncate">{{ $s->judul ?? 'Chat Baru' }}</p>
                            <p class="text-xs text-on-surface-variant mt-1">{{ $s->lahan->nama ?? 'Lahan' }} • {{ $s->updated_at->diffForHumans(null, true, true) }}</p>
                        </a>
                    @endforeach
                </div>
            </aside>

            <!-- Panel 2: Center Chat Area -->
            <section class="flex-1 flex flex-col min-w-0 bg-surface-bright relative">
                <!-- Chat Messages Header (Mobile/Tablet) -->
                <div class="lg:hidden p-4 border-b border-outline-variant flex justify-between items-center bg-surface-container-lowest">
                    <h2 class="font-h3 text-h3 text-on-surface">TaniBot</h2>
                    <a href="{{ route('tanibot') }}" class="p-2 text-primary rounded-full hover:bg-surface-container flex items-center justify-center">
                        <span class="material-symbols-outlined" data-icon="add">add</span>
                    </a>
                </div>

                <!-- Messages -->
                <div id="chat-container" class="flex-1 overflow-y-auto p-4 md:p-gutter flex flex-col gap-6">
                    @if(!$selectedSession)
                        <div id="new-chat-empty-state" class="flex flex-col items-center justify-center h-full text-center px-4">
                            <div class="w-16 h-16 rounded-full bg-primary-container flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-on-primary-container text-3xl" data-icon="add_comment">add_comment</span>
                            </div>
                            <h3 class="font-h3 text-h3 text-on-surface mb-2">Mulai Chat Baru</h3>
                            <p class="text-on-surface-variant text-sm max-w-md mb-6">Pilih lahan Anda di bawah dan ketik pertanyaan pertama untuk memulai.</p>
                            <select id="new-chat-lahan" class="w-full max-w-sm bg-surface-container pl-4 pr-10 py-3 rounded-xl border border-outline-variant focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest font-body text-body text-on-surface transition-all shadow-sm">
                                <option value="">-- Pilih Lahan --</option>
                                @foreach($lahans as $l)
                                    <option value="{{ $l->id }}">{{ $l->nama }} - {{ ucfirst($l->komoditas) }}</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif(count($riwayat) === 0)
                        <div class="flex flex-col items-center justify-center h-full text-center px-4">
                            <div class="w-16 h-16 rounded-full bg-primary-container flex items-center justify-center mb-4">
                                <span class="material-symbols-outlined text-on-primary-container text-3xl" data-icon="psychology">psychology</span>
                            </div>
                            <h3 class="font-h3 text-h3 text-on-surface mb-2">Halo, saya TaniBot!</h3>
                            <p class="text-on-surface-variant text-sm max-w-md">Saya asisten AI Anda untuk lahan <strong>{{ $selectedLahan->nama ?? 'belum dipilih' }}</strong>. Tanyakan apa saja seputar perawatan tanaman, jadwal panen, atau penanganan hama.</p>
                        </div>
                    @else
                        @foreach($riwayat as $chat)
                            <!-- Farmer Message -->
                            <div class="flex flex-col items-end gap-1">
                                <div class="bg-primary text-on-primary rounded-2xl rounded-tr-none px-5 py-3 max-w-[85%] md:max-w-[75%] shadow-[0_2px_8px_rgba(27,94,32,0.08)]">
                                    <p class="font-body text-body whitespace-pre-line">{{ $chat->pertanyaan }}</p>
                                </div>
                            </div>
                            <!-- Bot Message -->
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center flex-shrink-0 mt-1">
                                    <span class="material-symbols-outlined text-on-primary-container text-sm" data-icon="psychology" style="font-variation-settings: 'FILL' 1;">psychology</span>
                                </div>
                                <div class="flex flex-col items-start gap-1 max-w-[85%] md:max-w-[75%]">
                                    <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl rounded-tl-none px-5 py-4 shadow-sm markdown-body">
                                        {!! \Illuminate\Support\Str::markdown($chat->jawaban) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>

                <!-- Input Area -->
                <div class="p-4 bg-surface-container-lowest border-t border-outline-variant">
                    <div class="relative flex items-center">
                        <input id="chat-input"
                            class="w-full bg-surface-container pl-5 pr-14 py-4 rounded-full border-none focus:ring-2 focus:ring-primary focus:bg-surface-container-lowest font-body text-body text-on-surface placeholder-on-surface-variant transition-all shadow-sm"
                            placeholder="{{ $selectedSession ? 'Ketik pesan Anda...' : 'Pilih lahan dan ketik pertanyaan...' }}" type="text"
                            onkeypress="if(event.key === 'Enter') sendChat()" />
                        <button id="send-btn" onclick="sendChat()"
                            class="absolute right-3 p-2 bg-primary text-on-primary rounded-full hover:bg-primary-container transition-colors shadow-sm disabled:opacity-50 flex items-center justify-center h-10 w-10">
                            <span class="material-symbols-outlined text-[20px]" data-icon="send">send</span>
                        </button>
                    </div>
                    <div class="text-center mt-2">
                        <span class="text-[11px] text-on-surface-variant font-body">TaniBot AI dapat membuat kesalahan. Harap verifikasi info penting.</span>
                    </div>
                </div>
            </section>
            <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>

            <!-- Panel 3: Context Panel -->
            @if($selectedLahan)
            <aside class="w-80 border-l border-outline-variant bg-surface-container-lowest hidden xl:flex flex-col overflow-y-auto p-4 gap-4">
                <h3 class="font-h3 text-h3 text-on-surface mb-2">Konteks Lahan</h3>
                
                <!-- Info Basic -->
                <div class="bg-surface-container-high rounded-xl p-4 border border-outline-variant">
                    <h4 class="font-body font-semibold text-on-surface mb-1">{{ $selectedLahan->nama }}</h4>
                    <p class="text-xs text-on-surface-variant flex items-center gap-1 mb-2"><span class="material-symbols-outlined text-[14px]">location_on</span> {{ $selectedLahan->kota }}, {{ $selectedLahan->kecamatan }}</p>
                    
                    <div class="grid grid-cols-2 gap-2 mt-3 pt-3 border-t border-outline-variant/50">
                        <div>
                            <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">Komoditas</p>
                            <p class="text-sm font-medium text-on-surface">{{ ucfirst($selectedLahan->komoditas) }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] text-on-surface-variant uppercase tracking-wider">Luas Area</p>
                            <p class="text-sm font-medium text-on-surface">{{ $selectedLahan->luas }} ha</p>
                        </div>
                    </div>
                </div>

                <!-- Fase Tanam -->
                <div class="bg-surface-container-highest rounded-xl p-4 border border-outline-variant flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center flex-shrink-0">
                        <span class="material-symbols-outlined text-on-primary-container" data-icon="eco">eco</span>
                    </div>
                    <div>
                        <h4 class="font-body font-semibold text-on-surface text-sm">Fase: {{ $selectedLahan->fase_label }}</h4>
                        <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">
                            @if($selectedLahan->tanggal_tanam)
                                {{ \Carbon\Carbon::parse($selectedLahan->tanggal_tanam)->diffInDays(now()) }} HST (Hari Setelah Tanam)
                            @else
                                Belum ada data HST.
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Risk Badge -->
                <div class="bg-surface-container-highest rounded-xl p-4 border border-outline-variant flex items-start gap-3">
                    <div class="w-10 h-10 rounded-full {{ $selectedLahan->risiko_badge_class ?? 'bg-secondary-fixed' }} flex items-center justify-center flex-shrink-0 text-white">
                        <span class="material-symbols-outlined" data-icon="warning">warning</span>
                    </div>
                    <div>
                        <h4 class="font-body font-semibold text-on-surface text-sm">Status Risiko: {{ $selectedLahan->risiko_label ?? 'Menengah' }}</h4>
                        <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">Tanibot akan menggunakan status ini sebagai konteks analisis.</p>
                    </div>
                </div>

                <!-- Field Image Context -->
                <div class="mt-auto pt-4">
                    <div class="relative h-32 rounded-lg overflow-hidden border border-outline-variant shadow-sm">
                        <img alt="Lahan" class="w-full h-full object-cover" src="{{ $selectedLahan->foto_url }}" />
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/60 to-transparent p-2">
                            <span class="text-white text-xs font-medium">{{ $selectedLahan->nama }}</span>
                        </div>
                    </div>
                </div>
            </aside>
            @endif
        </main>
</div>

<script>
    const chatContainer = document.getElementById('chat-container');
    const chatInput = document.getElementById('chat-input');
    const sendBtn = document.getElementById('send-btn');
    let currentSessionId = '{{ $selectedSession->id ?? "" }}';
    let selectedLahanId = '{{ $selectedLahan->id ?? "" }}';

    // Scroll to bottom on load
    if (chatContainer) chatContainer.scrollTop = chatContainer.scrollHeight;

    function formatResponse(text) {
        return marked.parse(text);
    }

    async function sendChat() {
        const text = chatInput.value.trim();
        let lahanId = selectedLahanId;
        if (!currentSessionId) {
            const dropdown = document.getElementById('new-chat-lahan');
            lahanId = dropdown ? dropdown.value : '';
            if (!lahanId) {
                alert('Pilih lahan terlebih dahulu untuk mulai chat baru!');
                return;
            }
        }
        if (!text) return;
        
        const emptyState = document.getElementById('new-chat-empty-state');
        if (emptyState) emptyState.style.display = 'none';

        // Append user message
        const userMsg = `
        <div class="flex flex-col items-end gap-1">
            <div class="bg-primary text-on-primary rounded-2xl rounded-tr-none px-5 py-3 max-w-[85%] md:max-w-[75%] shadow-[0_2px_8px_rgba(27,94,32,0.08)]">
                <p class="font-body text-body whitespace-pre-line">${text}</p>
            </div>
        </div>`;
        chatContainer.insertAdjacentHTML('beforeend', userMsg);
        chatInput.value = '';
        sendBtn.disabled = true;
        chatContainer.scrollTop = chatContainer.scrollHeight;

        // Append loading indicator
        const loadingId = 'loading-' + Date.now();
        const loadingMsg = `
        <div id="${loadingId}" class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center flex-shrink-0">
                <span class="material-symbols-outlined text-on-primary-container text-sm" data-icon="psychology" style="font-variation-settings: 'FILL' 1;">psychology</span>
            </div>
            <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl rounded-tl-none px-4 py-3 shadow-sm flex gap-1 items-center h-10">
                <div class="w-2 h-2 rounded-full bg-outline-variant animate-pulse"></div>
                <div class="w-2 h-2 rounded-full bg-outline-variant animate-pulse" style="animation-delay: 0.2s"></div>
                <div class="w-2 h-2 rounded-full bg-outline-variant animate-pulse" style="animation-delay: 0.4s"></div>
            </div>
        </div>`;
        chatContainer.insertAdjacentHTML('beforeend', loadingMsg);
        chatContainer.scrollTop = chatContainer.scrollHeight;

        try {
            const res = await fetch('{{ route('tanibot.chat') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ pertanyaan: text, lahan_id: lahanId, session_id: currentSessionId })
            });

            const data = await res.json();
            const loadingElMain = document.getElementById(loadingId);
            if (loadingElMain) loadingElMain.remove();

            if (res.ok && data.jawaban) {
                const botMsg = `
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary-container flex items-center justify-center flex-shrink-0 mt-1">
                        <span class="material-symbols-outlined text-on-primary-container text-sm" data-icon="psychology" style="font-variation-settings: 'FILL' 1;">psychology</span>
                    </div>
                    <div class="flex flex-col items-start gap-1 max-w-[85%] md:max-w-[75%]">
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-2xl rounded-tl-none px-5 py-4 shadow-sm markdown-body">
                            ${formatResponse(data.jawaban)}
                        </div>
                    </div>
                </div>`;
                chatContainer.insertAdjacentHTML('beforeend', botMsg);
                if (data.is_new_session) {
                    window.location.href = '{{ route('tanibot') }}?session_id=' + data.session_id;
                }
            } else {
                const errMsg = data.error || 'Terjadi kesalahan saat memproses jawaban.';
                if (data.actual_error) console.error('TaniBot Server Error:', data.actual_error);
                else console.error('TaniBot Error:', data);
                const errorBubble = `
                <div class="flex items-start gap-3">
                    <div class="w-8 h-8 rounded-full bg-error-container flex items-center justify-center flex-shrink-0 mt-1 text-error">
                        <span class="material-symbols-outlined text-on-error-container text-sm" data-icon="warning">warning</span>
                    </div>
                    <div class="flex flex-col items-start gap-1 max-w-[85%] md:max-w-[75%]">
                        <div class="bg-error-container/30 border border-error-container rounded-2xl rounded-tl-none px-5 py-4 shadow-sm">
                            <p class="font-body text-body text-error whitespace-pre-line">${errMsg}</p>
                        </div>
                    </div>
                </div>`;
                chatContainer.insertAdjacentHTML('beforeend', errorBubble);
            }
        } catch (error) {
            const loadingEl = document.getElementById(loadingId);
            if (loadingEl) loadingEl.remove();
            
            console.error('TaniBot Fetch Error:', error);
            
            const errorBubble = `
            <div class="flex items-start gap-3">
                <div class="w-8 h-8 rounded-full bg-error-container flex items-center justify-center flex-shrink-0 mt-1 text-error">
                    <span class="material-symbols-outlined text-on-error-container text-sm" data-icon="wifi_off">wifi_off</span>
                </div>
                <div class="flex flex-col items-start gap-1 max-w-[85%] md:max-w-[75%]">
                    <div class="bg-error-container/30 border border-error-container rounded-2xl rounded-tl-none px-5 py-4 shadow-sm">
                        <p class="font-body text-body text-error">Gagal terhubung ke TaniBot. Periksa koneksi internet Anda.</p>
                    </div>
                </div>
            </div>`;
            chatContainer.insertAdjacentHTML('beforeend', errorBubble);
        } finally {
            sendBtn.disabled = false;
            chatContainer.scrollTop = chatContainer.scrollHeight;
            chatInput.focus();
        }
    }
</script>
@endsection
