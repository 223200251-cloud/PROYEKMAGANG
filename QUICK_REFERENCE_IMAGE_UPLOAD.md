# Quick Reference: Image Upload Features

## 🎯 Tujuan
Kreator bisa upload foto portfolio mereka dengan dua pilihan:
1. **Upload File** - Foto disimpan di server
2. **Link URL** - Foto dari link eksternal

---

## 🚀 Quick Setup (5 menit)

```bash
# 1. Run migration
php artisan migrate

# 2. Create symlink (jika belum ada)
php artisan storage:link

# 3. Set permission
chmod -R 755 storage/app/public
```

---

## 📋 Database Schema

| Column | Type | Default | Notes |
|--------|------|---------|-------|
| `image_type` | enum('uploaded', 'url') | 'url' | Tipe image |
| `image_path` | varchar(255) | NULL | Path file (upload) |
| `image_url` | varchar(255) | NULL | URL eksternal (link) |

---

## 💻 Controller Methods

### store() - Create Portfolio
```php
// Input dari form
[
    'image_type' => 'uploaded',     // atau 'url'
    'image_file' => <file>,         // jika uploaded
    'image_url' => 'https://...',   // jika url
]

// Proses
if (uploaded) {
    file disimpan ke storage/app/public/portfolios/
    image_path = path file
    image_url = null
}

// Output
Portfolio created dengan image stored
```

### update() - Edit Portfolio  
```php
// Bisa ganti tipe!
if (image_type_berubah) {
    hapus file lama (jika ada)
    simpan file baru
}
```

### destroy() - Delete Portfolio
```php
// File otomatis terhapus via model boot event
$portfolio->delete(); // ✅ File juga ikut terhapus
```

---

## 🖼️ Menampilkan Image di View

### Cara Termudah (Using Helper)
```blade
@use('App\Helpers\PortfolioImageHelper')

<img src="{{ PortfolioImageHelper::getImageUrl($portfolio) }}"
     alt="{{ PortfolioImageHelper::getImageAlt($portfolio) }}">

@if(PortfolioImageHelper::isUploadedImage($portfolio))
    <span class="badge">📤 Upload</span>
@endif
```

### Cara Langsung
```blade
@if($portfolio->image_type === 'uploaded')
    <img src="{{ asset('storage/' . $portfolio->image_path) }}">
@else
    <img src="{{ $portfolio->image_url }}">
@endif
```

---

## 📝 Form Upload Template

```html
<!-- Radio untuk pilih tipe -->
<input type="radio" name="image_type" value="uploaded">
<label>Upload Foto</label>

<input type="radio" name="image_type" value="url">
<label>Link Gambar</label>

<!-- File input (show/hide pake JS) -->
<input type="file" name="image_file" accept="image/*">

<!-- URL input (show/hide pake JS) -->
<input type="url" name="image_url">

<!-- Submit -->
<button type="submit">Upload Portfolio</button>
```

---

## ✅ Validasi Request

```php
$request->validate([
    'image_type' => 'required|in:uploaded,url',
    'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
    'image_url' => 'nullable|url',
]);

// Logic tambahan
if ($image_type === 'uploaded' && !$request->hasFile('image_file')) {
    return error('File harus diupload');
}

if ($image_type === 'url' && !$image_url) {
    return error('URL harus diisi');
}
```

---

## 🔄 Alur Kerja

### Create Portfolio
```
User submit form
    ↓
Validasi (file/URL ada?)
    ↓
[Uploaded] Upload file → storage/app/public/portfolios/
[URL]      Simpan URL langsung
    ↓
Simpan ke database
    ↓
Portfolio created ✅
```

### Update Portfolio
```
User edit portfolio & ubah image
    ↓
Cek: Apakah tipe berubah?
    ↓
[Berubah] Hapus file/URL lama → Simpan yg baru
[Sama]    Update jika ada file baru
    ↓
Portfolio updated ✅
```

### Delete Portfolio
```
User delete portfolio
    ↓
Model boot() event triggered
    ↓
Cek: Apakah image_type = 'uploaded'?
    ↓
[Ya] Hapus file dari storage
[Tidak] Skip
    ↓
Portfolio deleted ✅
```

---

## 📦 File Locations

```
database/
  migrations/
    2026_01_02_000000_add_image_upload_to_portfolios_table.php

app/
  Models/
    Portfolio.php (UPDATED)
  
  Http/Controllers/
    PortfolioController.php (UPDATED)
  
  Helpers/
    PortfolioImageHelper.php (NEW)

resources/
  views/portfolio/
    upload-image-form.blade.php (EXAMPLE)
    display-portfolio.blade.php (EXAMPLE)

storage/
  app/public/
    portfolios/         ← File disimpan di sini
      file1.jpg
      file2.png
      ...

public/
  storage/              ← Symlink ke storage/app/public
```

---

## 🧪 Testing Checklist

- [ ] Upload file JPG (< 5MB) → berhasil simpan ke storage
- [ ] Upload file > 5MB → error validation
- [ ] Upload file PDF → error (format tidak didukung)
- [ ] Link URL eksternal → berhasil simpan tanpa file
- [ ] Edit: Upload → Link → file lama terhapus ✓
- [ ] Edit: Link → Upload → URL lama hilang ✓
- [ ] Delete portfolio → file otomatis terhapus ✓
- [ ] Display portfolio → image muncul dengan benar

---

## 🛠️ Troubleshooting

| Problem | Solution |
|---------|----------|
| File tidak tersimpan | `chmod -R 755 storage/app/public` |
| Image tidak tampil | Cek symlink: `php artisan storage:link` |
| File tidak terhapus | Verify boot() event di model Portfolio |
| Upload size error | Check `php.ini` upload_max_filesize |

---

## 📚 Full Documentation

- [IMAGE_UPLOAD_FEATURES.md](IMAGE_UPLOAD_FEATURES.md) - Dokumentasi lengkap
- [PHOTO_UPLOAD_SETUP.md](PHOTO_UPLOAD_SETUP.md) - Setup guide detail
- [CREATOR_RESTRICTIONS_FEATURES.md](CREATOR_RESTRICTIONS_FEATURES.md) - Pembatasan kreator

---

## 🎓 Helper Methods

```php
// Get image URL
PortfolioImageHelper::getImageUrl($portfolio)

// Get alt text
PortfolioImageHelper::getImageAlt($portfolio)

// Check if uploaded file
PortfolioImageHelper::isUploadedImage($portfolio)

// Check if external URL
PortfolioImageHelper::isExternalImage($portfolio)

// Delete file manually
PortfolioImageHelper::deleteImageFile($portfolio)
```

---

## 💡 Tips

1. **Always create symlink** after fresh install
2. **Set folder permissions** untuk upload berfungsi
3. **Use helper methods** untuk view lebih clean
4. **Test file upload** dengan berbagai ukuran
5. **Monitor storage usage** secara berkala
6. **Backup database** sebelum migration

---

Last Updated: January 2, 2026
