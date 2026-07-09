@extends('layouts.app')

@section('title', $aspiration->judul . ' - Aspirasi')
@section('page_title', 'Detail Aspirasi')

@section('content')

{{-- ======================== TOKEN INPUT MODAL ======================== --}}
<div id="token-modal" role="dialog" aria-modal="true" aria-labelledby="modal-title"
     style="display:none; opacity:0; transition: opacity 0.25s ease;"
     class="fixed inset-0 z-50 flex items-center justify-center p-4">

    {{-- Backdrop --}}
    <div id="modal-backdrop"
         onclick="closeTokenModal()"
         class="absolute inset-0 bg-gray-950/60 backdrop-blur-sm"></div>

    {{-- Modal Panel --}}
    <div id="modal-panel"
         style="transform: scale(0.92) translateY(10px); transition: transform 0.25s ease, opacity 0.25s ease; opacity:0;"
         class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-200 overflow-hidden z-10">

        {{-- Header stripe --}}
        <div class="h-1.5 w-full bg-gradient-to-r from-indigo-500 via-violet-500 to-purple-500"></div>

        <div class="p-6 sm:p-8">

            {{-- Icon & Title --}}
            <div class="flex items-start justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="flex-shrink-0 w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 id="modal-title" class="text-base font-bold text-gray-900">Kelola Aspirasi Saya</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Masukkan token rahasia untuk akses edit / hapus</p>
                    </div>
                </div>
                <button onclick="closeTokenModal()"
                        id="modal-close-btn"
                        aria-label="Tutup modal"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Error Message (from session or inline) --}}
            @if(session('token_error'))
            <div id="token-error-banner"
                 class="mb-4 flex items-start gap-2 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-xs text-rose-700">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <span>{{ session('token_error') }}</span>
            </div>
            @endif

            {{-- Token Input Form --}}
            <form id="token-form"
                  action="{{ route('aspirasi.edit', $aspiration->id) }}"
                  method="GET"
                  onsubmit="return handleTokenSubmit(event)"
                  class="space-y-4">

                <div>
                    <label for="token-input" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        Token Pemilik (UUID)
                    </label>
                    <div class="relative">
                        <input type="text"
                               id="token-input"
                               name="token"
                               required
                               autocomplete="off"
                               spellcheck="false"
                               placeholder="xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx"
                               class="w-full px-4 py-2.5 pr-10 text-sm border border-gray-300 rounded-xl
                                      focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/20
                                      shadow-sm font-mono tracking-wide transition-all placeholder:text-gray-300
                                      invalid:border-rose-400 invalid:ring-rose-400/20">
                        {{-- Paste button --}}
                        <button type="button"
                                id="paste-btn"
                                onclick="pasteToken()"
                                title="Tempel dari clipboard"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 w-6 h-6 flex items-center justify-center
                                       text-gray-400 hover:text-indigo-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </button>
                    </div>
                    <p id="token-hint" class="mt-1.5 text-xs text-gray-400">
                        Token dikirim saat Anda pertama kali membuat aspirasi ini.
                    </p>
                    {{-- Inline validation error --}}
                    <p id="token-error-inline" class="mt-1.5 text-xs text-rose-600 hidden"></p>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-2 pt-1">
                    <button type="button"
                            onclick="closeTokenModal()"
                            class="flex-1 py-2.5 text-sm font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200
                                   rounded-xl transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                            id="verify-btn"
                            class="flex-1 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700
                                   rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                        <svg id="verify-spinner" class="hidden w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
                        </svg>
                        <span id="verify-btn-text">Verifikasi &amp; Lanjutkan</span>
                    </button>
                </div>
            </form>

            {{-- Footer hint --}}
            <p class="mt-5 pt-4 border-t border-gray-100 text-center text-xs text-gray-400">
                🔒 Token hanya diketahui oleh pemilik aspirasi. Data tetap anonim.
            </p>
        </div>
    </div>
</div>
{{-- ================================================================== --}}


<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Flash Messages --}}
    @if(session('success'))
        <div data-flash class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div data-flash class="mb-6 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800 shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Back Link --}}
    <div class="mb-4">
        <a href="{{ route('aspirasi.index') }}"
           class="text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors inline-flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    {{-- ===== Main Aspiration Card ===== --}}
    <article class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden mb-8">
        <div class="p-6 sm:p-8">

            {{-- Meta Info --}}
            <div class="flex flex-wrap items-center justify-between gap-2 mb-6 text-xs text-gray-400 font-semibold">
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700">
                        {{ $aspiration->category->nama_kategori ?? 'Umum' }}
                    </span>
                    <span>•</span>
                    <span>Anonim ({{ substr($aspiration->owner_token, 0, 8) }})</span>
                </div>
                <span>{{ $aspiration->created_at->format('d M Y, H:i') }}</span>
            </div>

            {{-- Title --}}
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight leading-tight">
                {{ $aspiration->judul }}
            </h1>

            {{-- Body --}}
            <div class="mt-6 text-sm sm:text-base text-gray-700 leading-relaxed whitespace-pre-line border-b border-gray-100 pb-8">
                {{ $aspiration->isi }}
            </div>

            {{-- Voting & Actions --}}
            <div class="mt-6 flex flex-wrap items-center justify-between gap-4">

                {{-- Vote Buttons --}}
                <div class="flex items-center gap-2">
                    <form action="{{ route('aspirasi.vote', $aspiration->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="vote_type" value="upvote">
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold
                                       border border-emerald-200 text-emerald-700 bg-emerald-50
                                       hover:bg-emerald-100 transition-colors">
                            👍 Setuju ({{ $aspiration->upvote }})
                        </button>
                    </form>
                    <form action="{{ route('aspirasi.vote', $aspiration->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="vote_type" value="downvote">
                        <button type="submit"
                                class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-sm font-semibold
                                       border border-rose-200 text-rose-700 bg-rose-50
                                       hover:bg-rose-100 transition-colors">
                            👎 Tidak Setuju ({{ $aspiration->downvote }})
                        </button>
                    </form>
                </div>

                {{-- Owner / Manage Actions --}}
                @if($isOwner)
                    <div class="flex items-center gap-2">
                        <a href="{{ route('aspirasi.edit', $aspiration->id) }}"
                           class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-200
                                  text-gray-700 bg-white hover:bg-gray-50 transition-colors inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Edit Aspirasi
                        </a>
                        <form action="{{ route('aspirasi.destroy', $aspiration->id) }}" method="POST"
                              data-confirm="Apakah Anda yakin ingin menghapus aspirasi ini? Tindakan ini tidak dapat dibatalkan.">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-4 py-2 rounded-xl text-sm font-semibold text-white
                                           bg-red-600 hover:bg-red-700 transition-colors inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                                Hapus
                            </button>
                        </form>
                    </div>
                @else
                    {{-- Trigger Token Modal --}}
                    <button onclick="openTokenModal()"
                            id="open-token-modal-btn"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold
                                   border border-indigo-300 text-indigo-600 bg-indigo-50
                                   hover:bg-indigo-100 hover:border-indigo-400 transition-colors shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Kelola Aspirasi Saya
                    </button>
                @endif
            </div>
        </div>
    </article>

    {{-- ===== Comments Section ===== --}}
    <section class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 sm:p-8">
        <h2 class="text-lg font-bold text-gray-900 mb-6">
            Diskusi Publik
            <span class="ml-1 text-sm font-semibold text-gray-400">({{ $aspiration->comments->count() }})</span>
        </h2>

        {{-- New Comment Form --}}
        <form action="{{ route('aspirasi.comment', $aspiration->id) }}" method="POST" class="mb-8" data-loading>
            @csrf
            <div>
                <label for="isi" class="sr-only">Tulis Komentar</label>
                <textarea name="isi" id="isi" rows="3" required maxlength="1000" data-auto-resize
                          placeholder="Tulis komentar/masukan Anda secara anonim di sini..."
                          class="w-full px-4 py-3 text-sm border border-gray-300 rounded-xl
                                 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 shadow-sm resize-none"></textarea>
            </div>
            <div class="mt-2 flex justify-end">
                <button type="submit"
                        class="px-5 py-2 text-sm font-semibold text-white bg-indigo-600
                               hover:bg-indigo-700 transition-colors rounded-xl shadow-sm">
                    Kirim Komentar
                </button>
            </div>
        </form>

        {{-- Comment List --}}
        <div class="space-y-4">
            @forelse($aspiration->comments as $comment)
                <div class="flex flex-col p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-center justify-between text-xs text-gray-400 font-semibold mb-2">
                        <span>Anonim ({{ substr($comment->owner_token, 0, 8) }})</span>
                        <span>{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $comment->isi }}</p>
                </div>
            @empty
                <div class="text-center py-10 text-sm text-gray-400">
                    <p class="text-2xl mb-2">💬</p>
                    Belum ada diskusi. Jadilah yang pertama memberikan masukan!
                </div>
            @endforelse
        </div>
    </section>

</div>

{{-- ======================== TOKEN MODAL JS ======================== --}}
<script>
    const modal      = document.getElementById('token-modal');
    const panel      = document.getElementById('modal-panel');
    const tokenInput = document.getElementById('token-input');

    function openTokenModal() {
        modal.style.display = 'flex';
        // Force reflow
        modal.offsetHeight;
        modal.style.opacity = '1';
        panel.style.opacity = '1';
        panel.style.transform = 'scale(1) translateY(0)';
        document.body.style.overflow = 'hidden';
        setTimeout(() => tokenInput.focus(), 250);
    }

    function closeTokenModal() {
        modal.style.opacity = '0';
        panel.style.opacity = '0';
        panel.style.transform = 'scale(0.92) translateY(10px)';
        document.body.style.overflow = '';
        setTimeout(() => { modal.style.display = 'none'; }, 260);
    }

    // Close with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeTokenModal();
        }
    });

    // Token paste helper
    async function pasteToken() {
        try {
            const text = await navigator.clipboard.readText();
            tokenInput.value = text.trim();
            tokenInput.focus();
            showPasteFeedback();
        } catch {
            tokenInput.focus();
        }
    }

    function showPasteFeedback() {
        const btn = document.getElementById('paste-btn');
        btn.innerHTML = `<svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>`;
        setTimeout(() => {
            btn.innerHTML = `<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>`;
        }, 1800);
    }

    // Basic UUID format validation before submit
    function handleTokenSubmit(e) {
        const val   = tokenInput.value.trim();
        const errEl = document.getElementById('token-error-inline');
        const uuid  = /^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i;

        if (!uuid.test(val)) {
            e.preventDefault();
            errEl.textContent = 'Format token tidak valid. Token berupa UUID (misal: xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx).';
            errEl.classList.remove('hidden');
            tokenInput.classList.add('border-rose-400', 'ring-rose-400/20');
            tokenInput.focus();
            return false;
        }

        errEl.classList.add('hidden');
        tokenInput.classList.remove('border-rose-400', 'ring-rose-400/20');

        // Show loading state
        const btn     = document.getElementById('verify-btn');
        const spinner = document.getElementById('verify-spinner');
        const btnText = document.getElementById('verify-btn-text');
        btn.disabled      = true;
        spinner.classList.remove('hidden');
        btnText.textContent = 'Memverifikasi...';
        return true;
    }

    // Clear inline error on input
    tokenInput && tokenInput.addEventListener('input', function() {
        const errEl = document.getElementById('token-error-inline');
        errEl.classList.add('hidden');
        tokenInput.classList.remove('border-rose-400', 'ring-rose-400/20');
    });

    // Auto-open modal if session has token_error (wrong token submitted)
    @if(session('token_error'))
        window.addEventListener('DOMContentLoaded', () => openTokenModal());
    @endif
</script>
{{-- ================================================================= --}}

@endsection