# 🚛 Azizah Diesel - Product Management System

Azizah Diesel adalah aplikasi web sederhana yang dibuat untuk membantu mengelola data produk pada usaha yang menjual sparepart diesel.

Project ini dibuat menggunakan **PHP dan MySQL**. Di dalamnya terdapat fitur CRUD, yaitu menambahkan data produk, melihat data produk, mengubah data produk, dan menghapus data produk.

Selain fitur CRUD, project ini juga menerapkan beberapa dasar keamanan dalam pengembangan aplikasi web, seperti **validasi input, prepared statement, output escaping, dan CSRF protection**.

Dengan adanya aplikasi ini, pengelolaan data produk menjadi lebih teratur karena data dapat disimpan dan dikelola melalui satu sistem.

---

## 📌 Daftar Isi

- [Tentang Project](#-tentang-project)
- [Tujuan Project](#-tujuan-project)
- [Fitur Utama](#-fitur-utama)
- [Teknologi yang Digunakan](#-teknologi-yang-digunakan)
- [Struktur Project](#-struktur-project)
- [Database](#-database)
- [Alur Sistem](#-alur-sistem)
- [Validasi Data](#-validasi-data)
- [Keamanan](#-keamanan)
- [Cara Menjalankan Project](#-cara-menjalankan-project)
- [Cara Menggunakan Aplikasi](#-cara-menggunakan-aplikasi)
- [Pengembangan Selanjutnya](#-pengembangan-selanjutnya)
- [Pengembang](#-pengembang)

---

# 📖 Tentang Project

**Azizah Diesel - Product Management System** merupakan aplikasi yang digunakan untuk mengelola informasi produk sparepart diesel.

Data yang disimpan dalam sistem meliputi:

- ID produk
- Nama produk
- Kategori
- Harga
- Stok

Pada halaman utama, produk ditampilkan dalam bentuk **card** agar informasi setiap produk lebih mudah dilihat. Tampilan juga dibuat responsif sehingga card dapat menyesuaikan dengan ukuran layar.

Pengguna dapat melakukan beberapa hal melalui aplikasi, seperti menambahkan produk baru, melihat daftar produk, mengubah informasi produk, dan menghapus produk yang sudah tidak diperlukan.

---

# 🎯 Tujuan Project

Project ini dibuat sebagai latihan untuk menerapkan beberapa konsep dasar dalam pembuatan aplikasi web.

Tujuan dari project ini antara lain:

1. Belajar membuat aplikasi web menggunakan PHP.
2. Menghubungkan aplikasi PHP dengan database MySQL.
3. Menerapkan konsep CRUD pada pengelolaan data produk.
4. Membuat validasi agar data yang masuk sesuai dengan aturan yang ditentukan.
5. Belajar menggunakan prepared statement ketika menjalankan query database.
6. Menerapkan dasar keamanan web, salah satunya menggunakan CSRF token pada proses penghapusan data.
7. Membuat tampilan data produk dalam bentuk card yang responsif.
8. Belajar menggunakan Git dan GitHub untuk menyimpan serta mengelola source code.

---

# ✨ Fitur Utama

## 1. ➕ Menambahkan Produk

Pengguna dapat menambahkan produk baru melalui halaman **Tambah Produk**.

Informasi yang perlu diisi adalah:

- Nama produk
- Kategori
- Harga
- Stok

Sebelum data disimpan, sistem akan melakukan pengecekan terlebih dahulu. Hal ini dilakukan agar data yang masuk ke database sesuai dengan aturan yang sudah ditentukan.

---

## 2. 👀 Melihat Produk

Setelah produk berhasil ditambahkan, data akan ditampilkan pada halaman utama.

Produk tidak ditampilkan dalam bentuk tabel, tetapi menggunakan **card**.

Setiap card berisi:

- Nama produk
- Kategori
- Harga
- Stok
- Tombol Edit
- Tombol Hapus

Tampilan card menggunakan CSS Grid sehingga jumlah dan posisi card dapat menyesuaikan ukuran layar.

---

## 3. ✏️ Mengedit Produk

Pengguna dapat mengubah informasi produk yang sudah tersimpan.

Data yang dapat diubah meliputi:

- Nama produk
- Kategori
- Harga
- Stok

Saat pengguna memilih tombol **Edit**, sistem akan mengambil produk berdasarkan ID. Setelah itu, data produk akan ditampilkan pada form dan dapat diubah.

Setelah perubahan disimpan, data yang ada di database akan diperbarui.

---

## 4. 🗑️ Menghapus Produk

Pengguna juga dapat menghapus produk yang sudah tidak diperlukan.

Sebelum produk dihapus, sistem akan menampilkan konfirmasi untuk memastikan pengguna benar-benar ingin menghapus data tersebut.

Proses penghapusan menggunakan:

- `POST`
- CSRF token
- Prepared statement

Penggunaan CSRF token dilakukan untuk memberikan perlindungan tambahan pada proses penghapusan data.

---

# 🛠️ Teknologi yang Digunakan

| Teknologi | Penggunaan |
|---|---|
| PHP | Digunakan untuk membuat logika dan proses pada aplikasi |
| MySQL | Digunakan untuk menyimpan data produk |
| PDO | Digunakan untuk menghubungkan PHP dengan database |
| HTML | Digunakan untuk membuat struktur halaman |
| CSS | Digunakan untuk mengatur tampilan aplikasi |
| XAMPP | Digunakan untuk menjalankan PHP dan MySQL secara lokal |
| Git | Digunakan untuk mencatat perubahan pada project |
| GitHub | Digunakan untuk menyimpan source code secara online |

---

# 📁 Struktur Project

```text
azizah-diesel/
│
├── assets/
│
├── config/
│   └── database.php
│
├── create.php
├── delete.php
├── edit.php
├── index.php
├── style.css
└── README.md
