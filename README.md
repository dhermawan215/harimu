# Harimu

**Platform undangan pernikahan digital.**

Harimu membantu pasangan membuat, mempublikasikan, dan membagikan undangan pernikahan digital, lengkap dengan daftar tamu, RSVP, buku tamu, dan amplop digital.

> **Harimu** adalah produk dari **HansSuite**, dikembangkan oleh **Nusantara Innovation Technology**.

## Teknologi

- PHP 8.2 atau lebih baru, Laravel 12
- MySQL (SQLite juga didukung untuk pengembangan)
- Vite, Bootstrap 5, dan Tailwind CSS 4
- HansCrypt (`hanssuite/hanscrypt`) untuk token berbasis AES-256-GCM

## Instalasi

```bash
git clone <url-repository> harimu
cd harimu

composer install
cp .env.example .env
php artisan key:generate
```

Atur koneksi database dan email di `.env`, lalu jalankan:

```bash
php artisan migrate
npm install
npm run build
```

Untuk pengembangan lokal, satu perintah ini menjalankan server, queue, log, dan Vite sekaligus:

```bash
composer run dev
```

## Konfigurasi

| Variabel           | Keterangan                                                                                                                |
| ------------------ | ------------------------------------------------------------------------------------------------------------------------- |
| `APP_URL`          | URL publik aplikasi. Dipakai untuk tautan di email verifikasi dan atur ulang kata sandi.                                  |
| `DB_*`             | Koneksi database.                                                                                                         |
| `MAIL_*`           | Pengaturan SMTP untuk email verifikasi dan atur ulang kata sandi.                                                         |
| `HANSCRYPT_KEY`    | Kunci enkripsi token. Jika kosong, `APP_KEY` dipakai.                                                                     |
| `QUEUE_CONNECTION` | Antrean bawaan memakai `database`, jadi worker perlu berjalan (`php artisan queue:work`) jika ada proses yang diantrekan. |

## Pengujian

```bash
php artisan test
```

Konfigurasi pengujian memakai SQLite in-memory, sehingga ekstensi PHP `pdo_sqlite` harus terpasang. Tanpa ekstensi itu, jalankan pengujian ke database MySQL khusus test:

## Dukungan

Butuh bantuan atau ingin melaporkan masalah? Hubungi tim kami di [support@nusainnotech.com](mailto:support@nusainnotech.com).

Untuk kerentanan keamanan, mohon kirim laporan ke alamat yang sama dan jangan dipublikasikan sebelum ditangani.

## Hak Cipta

&copy; Nusantara Innovation Technology. Harimu adalah produk dari HansSuite. Seluruh hak dilindungi.
