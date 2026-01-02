# Fitur Upload Foto Portfolio untuk Kreator

## Deskripsi
Fitur ini memungkinkan kreator untuk mengunggah foto langsung ke server atau menggunakan link gambar eksternal saat membuat/mengedit portfolio.

## Tipe Upload

### 1. **Upload Foto** (Type: `uploaded`)
- Kreator mengunggah file foto dari komputer mereka
- File disimpan di storage public (`storage/app/public/portfolios/`)
- Tipe file yang didukung: JPEG, PNG, JPG, GIF, WebP
- Ukuran maksimal: 5 MB

### 2. **Upload Link Gambar** (Type: `url`)
- Kreator memberikan URL gambar eksternal
- URL harus valid dan accessible
- Tidak memerlukan storage di server

## Perubahan Database

### Migration Baru
File: [database/migrations/2026_01_02_000000_add_image_upload_to_portfolios_table.php](database/migrations/2026_01_02_000000_add_image_upload_to_portfolios_table.php)

Kolom yang ditambahkan di tabel `portfolios`:
```php
$table->enum('image_type', ['uploaded', 'url'])->default('url');
$table->string('image_path')->nullable();
```

- `image_type`: Menentukan tipe gambar (uploaded/url)
- `image_path`: Menyimpan path file yang diupload (misal: `portfolios/abc123.jpg`)

## Perubahan Model

### [app/Models/Portfolio.php](app/Models/Portfolio.php)

1. **Update `$fillable`**
   - Tambah: `image_type`, `image_path`

2. **Method `getImageAttribute()`**
   - Mengembalikan URL gambar sesuai tipe
   - Jika `uploaded`: mengembalikan `asset('storage/' . path)`
   - Jika `url`: mengembalikan `image_url` langsung

3. **Method `boot()`**
   - Event `deleting`: Otomatis menghapus file foto saat portfolio dihapus

## Perubahan Controller

### [app/Http/Controllers/PortfolioController.php](app/Http/Controllers/PortfolioController.php)

#### Method `store()` - Create Portfolio
```php
// Validasi input:
- image_type: required, in:uploaded,url
- image_file: nullable, image, mimes:jpeg,png,jpg,gif,webp, max:5120
- image_url: nullable, url

// Logic:
if (image_type === 'uploaded') {
    Simpan file -> image_path
    image_url = null
} else {
    Simpan URL -> image_url
    image_path = null
}
```

#### Method `update()` - Edit Portfolio
```php
// Validasi input sama dengan store, tapi image_type nullable

// Logic:
- Jika tipe berubah dari uploaded ke url:
  Hapus file lama -> Simpan URL baru

- Jika tipe berubah dari url ke uploaded:
  Upload file baru -> Hapus URL lama

- Jika upload file baru (tipe sama):
  Hapus file lama -> Simpan file baru
```

#### Method `destroy()` - Delete Portfolio
```php
// Otomatis menghapus file via model's boot() event
// Tidak perlu kode tambahan
```

## Alur Upload Foto

### Create Portfolio (store)
```
User upload form dengan image_type="uploaded" + file
    ↓
Validasi: file harus ada, harus image, max 5MB
    ↓
Upload ke storage/public/portfolios/
    ↓
Simpan data ke DB:
  - image_type: "uploaded"
  - image_path: "portfolios/nama-file.jpg"
  - image_url: null
    ↓
Portfolio berhasil dibuat ✅
```

### Update Portfolio (update)
```
User edit form dengan image_type="uploaded" + file baru
    ↓
Cek apakah file ada dan valid
    ↓
Jika ada file baru:
  - Hapus file lama (jika ada)
  - Upload file baru ke storage
  - Update image_path
    ↓
Update data di DB
    ↓
Portfolio berhasil diupdate ✅
```

### Delete Portfolio (destroy)
```
User klik delete
    ↓
Laravel trigger deleting event di model
    ↓
Model's boot() method:
  - Cek apakah image_type === "uploaded"
  - Jika ya: hapus file dari storage
    ↓
Portfolio dihapus dari DB ✅
```

## Fitur Keamanan

1. **Validasi File**
   - Hanya tipe MIME tertentu yang diizinkan
   - Ukuran maksimal 5 MB
   - Disimpan di folder publik dengan organized path

2. **Path Traversal Protection**
   - Laravel `store()` method otomatis aman dari path traversal
   - File disimpan dengan nama random

3. **Cleanup Otomatis**
   - File lama dihapus saat diupdate/dihapus
   - Tidak ada orphaned files di server

## Struktur Folder Storage

```
storage/app/public/portfolios/
├── abc123def456.jpg
├── xyz789pqr123.png
├── ...
```

## Contoh Validation Request

### Create Portfolio
```json
{
  "title": "Website Design Project",
  "description": "A modern website design",
  "category": "web_design",
  "image_type": "uploaded",  // atau "url"
  "image_file": <file>,      // hanya jika uploaded
  "image_url": null,         // hanya jika url type
  "project_url": "https://example.com",
  "technologies": "HTML, CSS, JavaScript"
}
```

### Update Portfolio
```json
{
  "title": "Updated Title",
  "description": "Updated description",
  "category": "web_design",
  "image_type": "url",       // Ubah tipe dari uploaded ke url
  "image_url": "https://example.com/image.jpg",
  "image_file": null,
  "technologies": "HTML, CSS, Tailwind"
}
```

## Response Messages

### Sukses
- Create: `"Portfolio berhasil dibuat!"`
- Update: `"Portfolio berhasil diupdate!"`
- Delete: `"Portfolio berhasil dihapus!"`

### Error
- File tidak valid: `"File foto harus diunggah"`
- URL tidak diisi: `"URL gambar harus diisi"`
- File terlalu besar: `"uploaded file exceeds maximum size of 5MB"`

## Testing Checklist

### ✅ Upload Foto
- [ ] Buka create portfolio
- [ ] Pilih image_type = "uploaded"
- [ ] Upload file JPG/PNG < 5MB
- [ ] Submit form
- [ ] Foto muncul di portfolio page
- [ ] File tersimpan di `/storage/app/public/portfolios/`

### ✅ Upload Link Gambar
- [ ] Buka create portfolio
- [ ] Pilih image_type = "url"
- [ ] Masukkan URL gambar valid
- [ ] Submit form
- [ ] Gambar dari link muncul di portfolio page

### ✅ Edit Portfolio - Ganti Tipe
- [ ] Portfolio dengan upload foto
- [ ] Edit, ubah ke image_type = "url"
- [ ] Masukkan URL baru
- [ ] Submit
- [ ] File lama dihapus dari storage ✓
- [ ] Gambar dari URL tampil ✓

### ✅ Delete Portfolio
- [ ] Portfolio dengan upload foto
- [ ] Klik delete
- [ ] Portfolio dihapus dari DB ✓
- [ ] File foto otomatis dihapus ✓

## Frontend Integration

Pastikan form di view memiliki:

```html
<!-- Radio button untuk pilih tipe -->
<input type="radio" name="image_type" value="uploaded">
<input type="radio" name="image_type" value="url">

<!-- File input (show/hide based on selection) -->
<input type="file" name="image_file" accept="image/*">

<!-- URL input (show/hide based on selection) -->
<input type="url" name="image_url">
```

JavaScript untuk show/hide:
```javascript
document.querySelectorAll('input[name="image_type"]').forEach(el => {
  el.addEventListener('change', function() {
    document.getElementById('file-section').style.display = 
      this.value === 'uploaded' ? 'block' : 'none';
    document.getElementById('url-section').style.display = 
      this.value === 'url' ? 'block' : 'none';
  });
});
```

## Catatan Penting

1. **Storage Symlink**
   - Pastikan symlink sudah dibuat:
   ```bash
   php artisan storage:link
   ```

2. **File Permissions**
   - Folder `storage/app/public/` harus writable
   - ```bash
     chmod -R 755 storage/app/public
     ```

3. **Cleanup Periodic**
   - Jalankan cleanup untuk orphaned files:
   ```bash
   php artisan storage:cleanup
   ```
