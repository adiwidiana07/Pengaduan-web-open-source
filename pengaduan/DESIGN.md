# DESIGN.md: Pengaduan

Arah desain ditentukan pemilik proyek pada 2 November 2026. Baris bertanda **(pemilik)** adalah jawaban langsung; baris bertanda **(turunan)** diturunkan dari jawaban itu dan boleh diubah pemilik kapan saja.

Dial: ENERGY 1 / RHYTHM 2 / MOTION 1

## Karakter

- **(pemilik)** Layanan publik yang tenang: terpercaya, rapi, mudah dibaca semua umur. Energi rendah, sedikit animasi.
- **(turunan)** Setiap aspirasi diperlakukan seperti dokumen resmi yang tercatat, bukan postingan media sosial.

## Warna

- **(pemilik)** Indigo tetap warna utama.
- **(pemilik)** Gradient indigo ke ungu pada logo dan judul dibuang.
- **(turunan)** Indigo-700 untuk teks/aksen penting, indigo-600 untuk tombol utama, indigo-50 untuk latar label.
- **(turunan)** Hijau (emerald) dan merah (rose) hanya untuk makna: setuju/tidak setuju, sukses/galat, hapus. Bukan dekorasi.
- **(turunan)** Netral: putih untuk permukaan, abu sangat muda (`#f7f7f8`) untuk latar halaman, abu-500 ke atas untuk teks.

## Tipografi

- **(pemilik)** Judul memakai serif (kesan surat resmi/koran warga); isi tetap sans agar mudah dibaca.
- **(turunan)** Serif: Source Serif 4 (600, 700). Dirancang untuk teks layar yang panjang dan resmi, tenang, bukan dekoratif, mendukung huruf Latin bahasa Indonesia.
- **(turunan)** Sans: Instrument Sans (font yang sudah ada; isi tidak diminta diganti).
- **(turunan)** Font di-host sendiri saat build, tidak memanggil server font pihak ketiga dari browser warga (sejalan dengan janji anonimitas).

## Bentuk dan permukaan

- **(turunan)** Kartu: putih, border abu, sudut 8px (`rounded-lg`), tanpa bayangan. Bayangan hanya untuk elemen yang benar-benar melayang: dialog dan panel menu ponsel.
- **(turunan)** Tombol dan input: sudut 6px (`rounded-md`). Label kategori: sudut 4px (`rounded`), bukan pil.

## Motif identitas

- **(turunan)** Nomor register: setiap aspirasi menampilkan nomornya, misalnya `No. 0042`, di atas judul serif, seperti nomor surat. Datanya nyata (ID aspirasi), dipakai di daftar, detail, dan halaman admin.

## Gerak

- **(turunan)** Hanya transisi warna saat hover dan fokus. Tidak ada animasi masuk, melayang, atau parallax.

## Ikon

- **(turunan)** Tidak memakai emoji sebagai ikon di halaman publik. Pakai label teks; ikon SVG hanya bila menambah kejelasan (menu, tutup, kembali).
