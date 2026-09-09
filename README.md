# Aplikasi Inventaris Barang Berbasis Barcode

Proyek aplikasi web sistem inventaris barang berbasis barcode yang dibangun menggunakan **Laravel**. Aplikasi ini dirancang untuk mempermudah proses pendataan, pencatatan stok masuk/keluar, serta pelacakan barang secara cepat menggunakan pemindai barcode.

## 🚀 Fitur Utama
- **Manajemen Data Barang:** Tambah, ubah, hapus, dan cari data barang inventaris.
- **Sistem Barcode:** Pemindaian barcode otomatis untuk mempercepat proses input dan pencarian data barang.
- **Manajemen Stok Masuk & Keluar:** Pencatatan riwayat transaksi stok secara real-time.
- **Autentikasi & Hak Akses:** Sistem login untuk mengamankan data inventaris dari unauthorized user.
- **Laporan Inventaris:** Rekapitulasi data barang untuk kebutuhan laporan berkala.

## 🛠️ Teknologi yang Digunakan
- **Backend:** PHP / Laravel
- **Frontend:** Blade Templating, Bootstrap / Tailwind CSS, Admin SB2
- **Database:** MySQL
- **Tools:** Git, Composer, Visual Studio Code

---

## ⚙️ Cara Instalasi & Menjalankan Proyek

Bagi Anda (*recruiter* atau *developer*) yang ingin menjalankan proyek ini di komputer lokal, ikuti langkah-langkah di bawah ini:

### 1. Clone Repositori
```bash
git clone [https://github.com/Guapaiz/Inventaris-Barang-Berbasis-Barcode.git](https://github.com/Guapaiz/Inventaris-Barang-Berbasis-Barcode.git)
cd Inventaris-Barang-Berbasis-Barcode
2. Install Dependensi PHP & JavaScript
Bash
composer install
npm install
npm run build
3. Konfigurasi Environment
Duplikat file .env.example menjadi .env:

Bash
cp .env.example .env
Sesuaikan konfigurasi database Anda di dalam file .env:

Code snippet
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_anda
DB_USERNAME=root
DB_PASSWORD=
4. Generate Application Key
Bash
php artisan key:generate
5. Jalankan Migrasi Database
Bash
php artisan migrate --seed
6. Jalankan Server Lokal
Bash
php artisan serve
Akses aplikasi melalui browser di http://127.0.0.1:8000.

👨‍💻 Author
Nama: Guapaiz

GitHub: @Guapaiz


---

Setelah seluruh isi file lama ditimpa dengan teks di atas, simpan file (`Ctrl + S`), lalu jalankan perintah ini di terminal untuk memperbarui GitHub:

```bash
git add README.md
git commit -m "docs: update professional README for portfolio"
git push origin main