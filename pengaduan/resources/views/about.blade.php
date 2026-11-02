@extends('layouts.app')

@section('title', 'Tentang - Pengaduan')

@section('content')
<div class="w-full max-w-3xl mx-auto px-4 sm:px-6 py-12 sm:py-16">

    <h1 class="font-serif text-4xl sm:text-5xl font-bold leading-tight text-gray-900">Tentang Pengaduan</h1>
    <p class="mt-5 text-lg text-gray-700 leading-relaxed">
        Menjembatani aspirasi masyarakat dengan transparansi penuh untuk menciptakan perubahan positif di lingkungan sekitar.
    </p>

    <section aria-labelledby="misi" class="mt-14">
        <h2 id="misi" class="font-serif text-2xl font-semibold text-gray-900 border-b-2 border-gray-900 pb-2">Misi</h2>
        <p class="mt-4 text-base text-gray-700 leading-relaxed">
            Memberikan wadah penyampaian keluhan dan aspirasi publik secara gratis, aman, dan tanpa hambatan birokrasi yang rumit demi perbaikan sarana pelayanan publik.
        </p>
    </section>

    <section aria-labelledby="alur" class="mt-14">
        <h2 id="alur" class="font-serif text-2xl font-semibold text-gray-900 border-b-2 border-gray-900 pb-2">Alur sebuah aspirasi</h2>
        <ol class="mt-6 space-y-6">
            <li class="grid grid-cols-[2.5rem_1fr] gap-x-2">
                <span class="font-serif text-2xl font-bold text-indigo-700 leading-none">1.</span>
                <div>
                    <h3 class="font-semibold text-gray-900">Daftar dan tulis</h3>
                    <p class="mt-1 text-sm text-gray-700 leading-relaxed">Buat akun, pilih kategori, lalu jelaskan aspirasi Anda. Aspirasi langsung tercatat dengan nomor register dan tampil sebagai Anonim.</p>
                </div>
            </li>
            <li class="grid grid-cols-[2.5rem_1fr] gap-x-2">
                <span class="font-serif text-2xl font-bold text-indigo-700 leading-none">2.</span>
                <div>
                    <h3 class="font-semibold text-gray-900">Warga mendukung dan berdiskusi</h3>
                    <p class="mt-1 text-sm text-gray-700 leading-relaxed">Siapa pun bisa membaca dan menyatakan setuju atau tidak setuju. Untuk berkomentar, warga perlu masuk akun. Anda bisa mengubah atau menghapus aspirasi sendiri dari halaman Aspirasi Saya.</p>
                </div>
            </li>
            <li class="grid grid-cols-[2.5rem_1fr] gap-x-2">
                <span class="font-serif text-2xl font-bold text-indigo-700 leading-none">3.</span>
                <div>
                    <h3 class="font-semibold text-gray-900">Warga melaporkan yang bermasalah</h3>
                    <p class="mt-1 text-sm text-gray-700 leading-relaxed">Aspirasi berisi spam, ujaran kebencian, informasi palsu, atau data pribadi orang lain bisa dilaporkan. Satu akun hanya bisa melapor sekali per aspirasi.</p>
                </div>
            </li>
            <li class="grid grid-cols-[2.5rem_1fr] gap-x-2">
                <span class="font-serif text-2xl font-bold text-indigo-700 leading-none">4.</span>
                <div>
                    <h3 class="font-semibold text-gray-900">Admin meninjau</h3>
                    <p class="mt-1 text-sm text-gray-700 leading-relaxed">Admin baru dapat menghapus sebuah aspirasi setelah menerima {{ config('pengaduan.report_threshold') }} laporan. Admin tidak bisa menghapus aspirasi hanya karena tidak setuju dengan isinya.</p>
                </div>
            </li>
        </ol>
    </section>

    <section id="privasi" aria-labelledby="privasi-title" class="mt-14 scroll-mt-6">
        <h2 id="privasi-title" class="font-serif text-2xl font-semibold text-gray-900 border-b-2 border-gray-900 pb-2">Privasi</h2>
        <dl class="mt-6 space-y-5">
            <div>
                <dt class="font-semibold text-gray-900">Apa yang terlihat oleh publik?</dt>
                <dd class="mt-1 text-sm text-gray-700 leading-relaxed">Judul, isi, kategori, tanggal, jumlah dukungan, dan komentar. Penulis selalu ditampilkan sebagai Anonim.</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-900">Apa yang terlihat oleh admin?</dt>
                <dd class="mt-1 text-sm text-gray-700 leading-relaxed">Hal yang sama dengan publik, ditambah jumlah dan alasan laporan. Admin tidak melihat siapa penulis aspirasi maupun siapa yang melapor.</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-900">Apa yang disimpan tentang akun saya?</dt>
                <dd class="mt-1 text-sm text-gray-700 leading-relaxed">Nama, email, dan kata sandi (disimpan sebagai hash, bukan teks asli) untuk masuk. Aspirasi dan laporan tidak menyimpan akun Anda, hanya kode acak (hash) yang dihitung dengan kunci rahasia server. Tanpa kunci itu, kode tersebut tidak dapat dihubungkan kembali ke akun.</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-900">Bagaimana dengan dukungan dan komentar?</dt>
                <dd class="mt-1 text-sm text-gray-700 leading-relaxed">Dukungan bisa diberikan tanpa masuk akun. Komentar perlu akun, tetapi yang disimpan hanya isi komentar dan kode acak baru untuk setiap komentar, bukan akun Anda. Komentar tampil sebagai Anonim.
            </div>
        </dl>
    </section>
</div>
@endsection
