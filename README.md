<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

# Fruitables - Laravel + Filament + RajaOngkir API + Midtrans + Google Login

Ini adalah project web toko buah dan sayur berbasis Laravel. Project ini menggunakan beberapa teknologi dan integrasi berikut:

- **Laravel**: Framework utama backend dan frontend.
- **Filament**: Admin panel modern berbasis Laravel untuk manajemen data produk, kategori, dsb.
- **RajaOngkir API**: Untuk cek ongkos kirim otomatis ke seluruh Indonesia.
- **Midtrans**: Integrasi pembayaran online (payment gateway) untuk transaksi yang aman.
- **Google Login**: Fitur login/register menggunakan akun Google (OAuth).

## Fitur Utama

- Manajemen produk, kategori, promo, dsb. via Filament Admin Panel.
- Cek ongkir otomatis menggunakan API RajaOngkir.
- Pembayaran online terintegrasi Midtrans (snap).
- Login dan register dengan Google.
- Tampilan frontend modern dan responsif.

## Instalasi

1. Clone repo ini.
2. `composer install`
3. `cp .env.example .env` lalu atur konfigurasi database, RajaOngkir, Midtrans, dan Google OAuth.
4. `php artisan key:generate`
5. `php artisan migrate --seed`
6. `npm install && npm run dev` (opsional, jika ingin mengubah asset frontend)
7. Jalankan server: `php artisan serve`

## Konfigurasi API

- **RajaOngkir**: Dapatkan API key di [rajaongkir.com](https://rajaongkir.com/) dan masukkan ke `.env`.
- **Midtrans**: Daftar di [midtrans.com](https://midtrans.com/) dan masukkan server key ke `.env`.
- **Google Login**: Buat credential OAuth di [Google Cloud Console](https://console.developers.google.com/) dan masukkan client ID & secret ke `.env`.

## Kontribusi

Pull request dan issue sangat diterima! Silakan fork repo ini dan buat PR jika ingin menambah fitur atau memperbaiki bug.

## Lisensi

Project ini menggunakan lisensi MIT.

---

> Project ini dibangun dengan Laravel, Filament, RajaOngkir API, Midtrans, dan Google Login untuk kebutuhan toko buah & sayur online yang modern dan lengkap.
