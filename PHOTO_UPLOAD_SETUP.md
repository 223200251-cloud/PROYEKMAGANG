# Update: Fitur Upload Foto Portfolio

## 📋 Ringkasan Perubahan

Fitur ini memungkinkan kreator untuk upload foto portfolio mereka dengan dua pilihan:
1. **Upload Foto Langsung** - File disimpan di server
2. **Gunakan Link Gambar** - Link eksternal dari URL

## 📁 File yang Dibuat/Diubah

### Database
- ✅ **[database/migrations/2026_01_02_000000_add_image_upload_to_portfolios_table.php](database/migrations/2026_01_02_000000_add_image_upload_to_portfolios_table.php)**
  - Menambahkan kolom `image_type` dan `image_path`
  - Run: `php artisan migrate`

### Models
- ✅ **[app/Models/Portfolio.php](app/Models/Portfolio.php)** (DIUPDATE)
  - Tambah `image_type` dan `image_path` ke `$fillable`
  - Method `getImageAttribute()` - return URL berdasarkan tipe
  - Method `boot()` - hapus file otomatis saat delete

### Controllers
- ✅ **[app/Http/Controllers/PortfolioController.php](app/Http/Controllers/PortfolioController.php)** (DIUPDATE)
  - Import `Storage` facade
  - Method `store()` - handle upload foto
  - Method `update()` - handle update foto dengan ganti tipe
  - Method `destroy()` - otomatis cleanup file

### Helpers (BARU)
- ✅ **[app/Helpers/PortfolioImageHelper.php](app/Helpers/PortfolioImageHelper.php)**
  - `getImageUrl()` - dapatkan URL foto
  - `getImageAlt()` - dapatkan alt text
  - `isUploadedImage()` - cek tipe uploaded
  - `isExternalImage()` - cek tipe URL
  - `deleteImageFile()` - hapus file manual

### Views (TEMPLATE)
- ✅ **[resources/views/portfolio/upload-image-form.blade.php](resources/views/portfolio/upload-image-form.blade.php)** (CONTOH)
  - Form lengkap dengan radio button
  - File input + URL input
  - JavaScript untuk show/hide
  - File preview

- ✅ **[resources/views/portfolio/display-portfolio.blade.php](resources/views/portfolio/display-portfolio.blade.php)** (CONTOH)
  - Menampilkan portfolio dengan image helper
  - Badge untuk tipe image
  - Responsive layout

### Documentation
- ✅ **[IMAGE_UPLOAD_FEATURES.md](IMAGE_UPLOAD_FEATURES.md)** - Dokumentasi lengkap

## 🚀 Setup & Installation

### 1. Run Migration
```bash
php artisan migrate
```

### 2. Create Storage Symlink
```bash
php artisan storage:link
```

### 3. Pastikan Folder Writable
```bash
chmod -R 755 storage/app/public
chmod -R 755 storage/logs
```

## 📊 Database Schema

```sql
-- Kolom baru di tabel portfolios
image_type ENUM('uploaded', 'url') DEFAULT 'url'
image_path VARCHAR(255) NULLABLE
```

### Contoh Data
```sql
-- Portfolio dengan upload foto
image_type: 'uploaded'
image_path: 'portfolios/abc123def456.jpg'
image_url: NULL

-- Portfolio dengan link gambar
image_type: 'url'
image_path: NULL
image_url: 'https://example.com/image.jpg'
```

## 💻 Usage di Controller

### Create Portfolio
```php
// Form kirim:
// image_type: 'uploaded'
// image_file: <file>
// 
// Atau:
// image_type: 'url'
// image_url: 'https://...'

// Controller handle otomatis
$portfolio = Auth::user()->portfolios()->create($portfolioData);
// File disimpan ke storage/app/public/portfolios/
```

### Update Portfolio
```php
// Bisa ganti tipe dari uploaded ke url atau sebaliknya
// File lama otomatis dihapus
// File baru otomatis disimpan

$portfolio->update($portfolioData);
```

### Delete Portfolio
```php
// File otomatis dihapus via model's boot() event
$portfolio->delete();
```

## 📸 Usage di View

### Cara 1: Menggunakan Helper
```blade
@php
    use App\Helpers\PortfolioImageHelper;
@endphp

<img 
    src="{{ PortfolioImageHelper::getImageUrl($portfolio) }}"
    alt="{{ PortfolioImageHelper::getImageAlt($portfolio) }}">

@if(PortfolioImageHelper::isUploadedImage($portfolio))
    <span>Badge: Upload</span>
@endif
```

### Cara 2: Menggunakan Model Accessor
```blade
<img 
    src="{{ $portfolio->image }}"
    alt="{{ $portfolio->title }}">
```

### Cara 3: Manual
```blade
@if($portfolio->image_type === 'uploaded')
    <img src="{{ asset('storage/' . $portfolio->image_path) }}">
@else
    <img src="{{ $portfolio->image_url }}">
@endif
```

## 🔍 Validasi

### Create/Update Request
```php
'image_type' => 'required|in:uploaded,url',
'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
'image_url' => 'nullable|url',
```

### Logic Validasi
```php
if ($image_type === 'uploaded' && !$request->hasFile('image_file')) {
    return error('File foto harus diunggah');
}

if ($image_type === 'url' && empty($image_url)) {
    return error('URL gambar harus diisi');
}
```

## ✅ Testing Scenarios

### Test 1: Create dengan Upload Foto
```
1. Buka /portfolio/create
2. Pilih "Upload Foto"
3. Upload JPG/PNG (< 5MB)
4. Submit
✅ Portfolio created, file di storage/app/public/portfolios/
```

### Test 2: Create dengan URL
```
1. Buka /portfolio/create
2. Pilih "Link Gambar"
3. Masukkan URL: https://example.com/image.jpg
4. Submit
✅ Portfolio created, image_path = null, image_url = URL
```

### Test 3: Update - Upload ke URL
```
1. Edit portfolio (sebelumnya upload foto)
2. Ubah ke "Link Gambar"
3. Masukkan URL baru
4. Submit
✅ File lama dihapus, image_url disimpan
```

### Test 4: Update - URL ke Upload
```
1. Edit portfolio (sebelumnya link URL)
2. Ubah ke "Upload Foto"
3. Upload file baru
4. Submit
✅ File baru disimpan, image_url dihapus
```

### Test 5: Delete
```
1. Delete portfolio dengan upload foto
2. Konfirmasi delete
✅ Portfolio dihapus dari DB
✅ File dihapus dari storage
```

## 📝 Form Integration

Update form create/edit portfolio untuk include:

```html
<!-- Image Type Selection -->
<div class="mb-3">
    <label>Sumber Gambar</label>
    <div>
        <input type="radio" name="image_type" value="uploaded">
        <label>Upload Foto</label>
    </div>
    <div>
        <input type="radio" name="image_type" value="url">
        <label>Link Gambar</label>
    </div>
</div>

<!-- File Upload -->
<div id="file-section" style="display:none">
    <input type="file" name="image_file" accept="image/*">
</div>

<!-- URL Input -->
<div id="url-section" style="display:none">
    <input type="url" name="image_url">
</div>
```

## 🛡️ Security Features

1. **File Validation**
   - Hanya JPEG, PNG, GIF, WebP
   - Max 5MB
   - Mime type check

2. **Path Safety**
   - Laravel `store()` otomatis random filename
   - No path traversal risk

3. **Storage Location**
   - Disimpan di `storage/app/public/portfolios/`
   - Accessible via `asset('storage/...')`

4. **Cleanup**
   - File lama dihapus saat update
   - File dihapus saat delete (via boot event)
   - No orphaned files

## ⚙️ Configuration

Edit `config/filesystems.php` jika perlu custom:

```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
        'throw' => false,
    ],
],
```

## 🐛 Troubleshooting

### File tidak tersimpan
```bash
# Cek folder permission
chmod -R 755 storage/app/public

# Cek symlink
php artisan storage:link

# Verify symlink
ls -la public/storage
```

### File tidak terhapus otomatis
```bash
# Pastikan boot() event berjalan
# Debug:
dd($portfolio->image_type);
dd($portfolio->image_path);
```

### Image tidak tampil
```php
// Pastikan symlink bekerja
{{ asset('storage/portfolios/file.jpg') }}

// Atau manual
{{ url('storage/portfolios/file.jpg') }}
```

## 📦 API Response

### Create Portfolio Success
```json
{
  "success": true,
  "portfolio": {
    "id": 1,
    "title": "Website Design",
    "image_type": "uploaded",
    "image_path": "portfolios/abc123.jpg",
    "image_url": null,
    "created_at": "2026-01-02T10:00:00Z"
  }
}
```

### File Validation Error
```json
{
  "success": false,
  "errors": {
    "image_file": ["File foto harus diunggah"]
  }
}
```

## 🎯 Next Steps

1. **Update existing views** dengan form template
2. **Test semua scenarios** di atas
3. **Monitor storage usage** secara berkala
4. **Implement image optimization** (optional)
5. **Add image compression** (optional)
