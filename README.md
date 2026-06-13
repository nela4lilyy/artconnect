# ArtConnect – Portal Informasi Komunitas Seni

Portal berita dan galeri untuk komunitas seni Indonesia, dibangun dengan Laravel 11.

## Persyaratan

- PHP >= 8.2
- Composer
- MySQL 8.0+
- Node.js (opsional, untuk compile assets)

## Instalasi

### 1. Clone / Download Project

```bash
git clone https://github.com/your-repo/artconnect.git
cd artconnect
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Konfigurasi Environment

```bash
cp .env.example .env
php artisan key:generate
```

Edit `.env`, sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=artconnect
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Buat Database

```sql
CREATE DATABASE artconnect CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 5. Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

### 6. Buat Storage Link

```bash
php artisan storage:link
```

### 7. Jalankan Server

```bash
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## Akun Admin Default

| Field    | Value                    |
|----------|--------------------------|
| Email    | admin@artconnect.com     |
| Password | password                 |

URL Admin: **http://localhost:8000/admin/login**

---

## Struktur Routing

### Publik

| Method | URL                  | Halaman              |
|--------|----------------------|----------------------|
| GET    | `/`                  | Beranda              |
| GET    | `/news`              | Daftar Berita        |
| GET    | `/news/{slug}`       | Detail Berita        |
| GET    | `/galleries`         | Daftar Galeri        |
| GET    | `/galleries/{id}`    | Detail Galeri        |
| GET    | `/about`             | Tentang Kami         |

### Admin (Memerlukan Login)

| Method | URL                                              | Fungsi                  |
|--------|--------------------------------------------------|-------------------------|
| GET    | `/admin/login`                                   | Halaman Login           |
| GET    | `/admin/dashboard`                               | Dashboard               |
| GET    | `/admin/categories`                              | Daftar Kategori         |
| POST   | `/admin/categories`                              | Simpan Kategori         |
| PUT    | `/admin/categories/{id}`                         | Update Kategori         |
| DELETE | `/admin/categories/{id}`                         | Hapus Kategori          |
| GET    | `/admin/news`                                    | Daftar Berita           |
| POST   | `/admin/news`                                    | Simpan Berita           |
| PUT    | `/admin/news/{id}`                               | Update Berita           |
| DELETE | `/admin/news/{id}`                               | Hapus Berita            |
| GET    | `/admin/galleries`                               | Daftar Galeri           |
| POST   | `/admin/galleries`                               | Simpan Galeri           |
| PUT    | `/admin/galleries/{id}`                          | Update Galeri           |
| DELETE | `/admin/galleries/{id}`                          | Hapus Galeri            |
| GET    | `/admin/galleries/{id}/images/create`            | Form Upload Foto        |
| POST   | `/admin/galleries/{id}/images`                   | Upload Foto             |
| PUT    | `/admin/galleries/{id}/images/{imgId}`           | Update Caption Foto     |
| DELETE | `/admin/galleries/{id}/images/{imgId}`           | Hapus Foto              |

---

## Fitur

- ✅ Login Admin dengan Laravel Auth
- ✅ Dashboard dengan statistik konten
- ✅ CRUD Kategori (dengan search & pagination)
- ✅ CRUD Berita (dengan slug otomatis, upload gambar, search)
- ✅ CRUD Galeri (dengan upload cover)
- ✅ Upload multi-foto ke galeri
- ✅ Edit caption foto
- ✅ Halaman publik: Beranda, Berita, Galeri, Detail, Tentang
- ✅ Search & filter berita
- ✅ Pagination
- ✅ Lightbox foto galeri
- ✅ Berita terkait di halaman detail
- ✅ Responsive mobile & desktop
- ✅ Validasi file upload (jpg, jpeg, png, webp, max 2MB)
- ✅ Form Request Validation
- ✅ Eloquent Relationships

---

## Struktur Database

```
users
├── id, name, email, password, role

categories
├── id, name

news
├── id, user_id (FK), category_id (FK), title, slug, content, image, publish_date

galleries
├── id, title, description, cover_image

gallery_images
├── id, gallery_id (FK), image, caption
```
