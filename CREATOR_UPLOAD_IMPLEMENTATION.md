# 📸 IMPLEMENTASI FITUR: Upload Foto Portfolio untuk Kreator

## 🎯 Overview

Fitur ini memungkinkan kreator untuk upload portfolio mereka dengan **dua pilihan**:

1. **Upload Foto Langsung** ☁️
   - File disimpan di server (storage/app/public/portfolios/)
   - Support: JPEG, PNG, GIF, WebP
   - Max size: 5MB

2. **Gunakan Link Gambar** 🔗
   - URL gambar eksternal (misal: dari CDN, Instagram, dll)
   - Tidak perlu storage di server
   - Hanya perlu URL yang valid

---

## 📝 Ringkasan Perubahan

### ✅ Database
**File:** `database/migrations/2026_01_02_000000_add_image_upload_to_portfolios_table.php`

Tambah 2 kolom ke tabel `portfolios`:
```sql
-- Menentukan tipe image (uploaded file atau URL)
image_type ENUM('uploaded', 'url') DEFAULT 'url'

-- Path file jika image_type = 'uploaded'
image_path VARCHAR(255) NULLABLE
```

**Run Migration:**
```bash
php artisan migrate
```

### ✅ Model: Portfolio
**File:** `app/Models/Portfolio.php`

**Perubahan:**
1. Tambah `image_type` dan `image_path` ke `$fillable`
2. Method `getImageAttribute()` - Return URL berdasarkan tipe image
3. Method `boot()` - Event deleting untuk hapus file otomatis

**Penggunaan:**
```php
// Di view, bisa langsung akses
{{ $portfolio->image }}  // Otomatis return URL yang benar

// Atau manual
if ($portfolio->image_type === 'uploaded') {
    $url = asset('storage/' . $portfolio->image_path);
}
```

### ✅ Controller: PortfolioController
**File:** `app/Http/Controllers/PortfolioController.php`

**Method store() - Create Portfolio**
```php
// Validasi input
'image_type' => 'required|in:uploaded,url'
'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120'
'image_url' => 'nullable|url'

// Handle upload
if (image_type === 'uploaded') {
    // Simpan file ke storage/app/public/portfolios/
    $path = $request->file('image_file')->store('portfolios', 'public');
    image_path = $path
    image_url = null
} else {
    // Simpan URL eksternal
    image_url = $validated['image_url']
    image_path = null
}
```

**Method update() - Edit Portfolio**
```php
// Bisa ganti tipe image!
// Misal: dari uploaded foto -> URL eksternal

// Jika tipe berubah:
// - Hapus file lama (jika ada)
// - Simpan file/URL baru
```

**Method destroy() - Delete Portfolio**
```php
// File otomatis terhapus via model boot() event
// Tidak perlu code tambahan
$portfolio->delete(); // ✅ File juga terhapus
```

### ✅ Helper: PortfolioImageHelper
**File:** `app/Helpers/PortfolioImageHelper.php` (NEW)

**Methods:**
```php
// Get image URL (uploaded atau external)
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

### ✅ Views: Form & Display
**Files:** 
- `resources/views/portfolio/upload-image-form.blade.php` (CONTOH)
- `resources/views/portfolio/display-portfolio.blade.php` (CONTOH)

---

## 🚀 Setup & Installation

### Step 1: Run Migration
```bash
cd d:\laragon\www\Aplikasi\ LMS\ Portofolio
php artisan migrate
```

### Step 2: Create Storage Symlink
```bash
php artisan storage:link
```

Ini membuat symlink dari `public/storage` ke `storage/app/public`.

### Step 3: Set Folder Permissions
```bash
# Windows (PowerShell as Admin)
icacls "storage/app/public" /grant Everyone:F /T

# Linux/Mac
chmod -R 755 storage/app/public
```

### Step 4: Verify Setup
```bash
# Check symlink
ls -la public/storage

# Check folder writable
touch storage/app/public/test.txt && rm storage/app/public/test.txt
```

---

## 📊 Data Structure

### Tabel: portfolios

```
id              | PK
user_id         | FK users
title           | string
description     | text
category        | string
image_type      | enum('uploaded', 'url')  [NEW]
image_path      | string nullable          [NEW]
image_url       | string nullable          [EXISTING]
project_url     | string nullable
technologies    | text nullable
created_at      | timestamp
updated_at      | timestamp
...
```

### Contoh Data

**Portfolio dengan Upload Foto:**
```
id: 1
title: "Website Design"
image_type: "uploaded"
image_path: "portfolios/abc123def456.jpg"
image_url: NULL
```

**Portfolio dengan Link URL:**
```
id: 2
title: "Mobile App"
image_type: "url"
image_path: NULL
image_url: "https://example.com/image.jpg"
```

---

## 💻 API/Controller Workflow

### CREATE Portfolio

```
POST /portfolio/store

Request:
{
  "title": "Website Design",
  "description": "Modern website...",
  "category": "web_design",
  "image_type": "uploaded",        // atau "url"
  "image_file": <file>,            // jika uploaded
  "image_url": "https://...",      // jika url
  "technologies": "React, Laravel",
  "project_url": "https://..."
}

Controller (store method):
1. Validate input
2. if (image_type === 'uploaded')
     Upload file → storage/app/public/portfolios/
     image_path = generated path
     image_url = null
   else
     image_url = provided URL
     image_path = null
3. Create portfolio record
4. Return redirect with success

Response:
✅ Portfolio created
File disimpan di: storage/app/public/portfolios/
```

### UPDATE Portfolio

```
PATCH /portfolio/1/update

Request:
{
  "title": "Updated Title",
  "image_type": "url",             // Change from 'uploaded'
  "image_url": "https://new-url.com/image.jpg"
}

Controller (update method):
1. Validate input
2. if (image_type changed)
     if (old was 'uploaded')
       Delete old file from storage
     if (new is 'uploaded')
       Upload new file
     if (new is 'url')
       Save new URL
3. Update portfolio record

Response:
✅ Portfolio updated
Old file deleted (if applicable)
```

### DELETE Portfolio

```
DELETE /portfolio/1

Controller (destroy method):
1. Check authorization
2. Delete portfolio record
3. Model boot() event triggers:
   if (image_type === 'uploaded' && image_path exists)
     Delete file from storage

Response:
✅ Portfolio deleted
File automatically deleted
```

---

## 🖼️ Frontend Integration

### Form Template

```html
<!-- Radio untuk pilih tipe -->
<fieldset>
  <legend>Sumber Gambar</legend>
  
  <input type="radio" 
         name="image_type" 
         value="uploaded"
         id="upload_photo">
  <label for="upload_photo">Upload Foto</label>
  
  <input type="radio" 
         name="image_type" 
         value="url"
         id="upload_link">
  <label for="upload_link">Link Gambar</label>
</fieldset>

<!-- File input -->
<div id="file-section" style="display: none;">
  <input type="file" 
         name="image_file"
         accept="image/jpeg,image/png,image/gif,image/webp">
  <small>JPG, PNG, GIF, WebP - Max 5MB</small>
</div>

<!-- URL input -->
<div id="url-section" style="display: none;">
  <input type="url" 
         name="image_url"
         placeholder="https://example.com/image.jpg">
</div>
```

### JavaScript untuk Show/Hide

```javascript
const uploadedRadio = document.getElementById('upload_photo');
const urlRadio = document.getElementById('upload_link');
const fileSection = document.getElementById('file-section');
const urlSection = document.getElementById('url-section');

function toggleSections() {
  if (uploadedRadio.checked) {
    fileSection.style.display = 'block';
    urlSection.style.display = 'none';
  } else {
    fileSection.style.display = 'none';
    urlSection.style.display = 'block';
  }
}

uploadedRadio.addEventListener('change', toggleSections);
urlRadio.addEventListener('change', toggleSections);
toggleSections(); // Initial state
```

### Display Image di View

```blade
@use('App\Helpers\PortfolioImageHelper')

<!-- Cara 1: Menggunakan Helper (RECOMMENDED) -->
<img src="{{ PortfolioImageHelper::getImageUrl($portfolio) }}"
     alt="{{ PortfolioImageHelper::getImageAlt($portfolio) }}">

<!-- Tambah badge -->
@if(PortfolioImageHelper::isUploadedImage($portfolio))
  <span class="badge bg-success">📤 Upload</span>
@endif

<!-- Cara 2: Menggunakan Accessor -->
<img src="{{ $portfolio->image }}"
     alt="{{ $portfolio->title }}">

<!-- Cara 3: Manual -->
@if($portfolio->image_type === 'uploaded')
  <img src="{{ asset('storage/' . $portfolio->image_path) }}">
@else
  <img src="{{ $portfolio->image_url }}">
@endif
```

---

## ✅ Testing Checklist

### Test 1: Upload File Photo
```
GIVEN: Kreator di halaman create portfolio
WHEN: Pilih "Upload Foto" & upload JPG file
AND: Submit form
THEN: ✅ Portfolio created
      ✅ File disimpan di storage/app/public/portfolios/
      ✅ image_type = 'uploaded'
      ✅ image_path = 'portfolios/...'
      ✅ image_url = NULL
```

### Test 2: Upload External URL
```
GIVEN: Kreator di halaman create portfolio
WHEN: Pilih "Link Gambar" & masukkan URL
AND: Submit form
THEN: ✅ Portfolio created
      ✅ image_type = 'url'
      ✅ image_path = NULL
      ✅ image_url = 'https://...'
      ✅ File tidak disimpan di server
```

### Test 3: File Validation
```
GIVEN: User upload file
WHEN: File size > 5MB
OR:   File format = PDF
THEN: ❌ Error validation
      ❌ Form tidak submit
      ❌ File tidak disimpan
```

### Test 4: Edit - Change Type
```
GIVEN: Portfolio existing dengan uploaded photo
WHEN: Edit & ubah ke "Link Gambar"
AND: Masukkan URL baru
AND: Submit form
THEN: ✅ Portfolio updated
      ✅ File lama dihapus dari storage
      ✅ image_type = 'url'
      ✅ image_path = NULL
      ✅ image_url = new URL
```

### Test 5: Edit - Same Type New File
```
GIVEN: Portfolio existing dengan uploaded photo
WHEN: Edit & upload file baru (stay 'uploaded')
AND: Submit form
THEN: ✅ Portfolio updated
      ✅ File lama dihapus
      ✅ File baru disimpan
      ✅ image_path = new path
```

### Test 6: Delete - File Cleanup
```
GIVEN: Portfolio dengan uploaded photo
WHEN: Click delete
AND: Confirm delete
THEN: ✅ Portfolio deleted dari DB
      ✅ File dihapus dari storage
      ✅ No orphaned files
```

### Test 7: Display Image
```
GIVEN: Portfolio di halaman show
WHEN: Image type = 'uploaded'
THEN: ✅ Image muncul dari asset('storage/...')

WHEN: Image type = 'url'
THEN: ✅ Image muncul dari external URL
```

---

## 🛡️ Security Features

### 1. File Type Validation
```php
'image_file' => 'image|mimes:jpeg,png,jpg,gif,webp'
```
- Hanya JPEG, PNG, GIF, WebP
- Mime type checking (bukan hanya extension)

### 2. File Size Limit
```php
'image_file' => 'max:5120'  // 5120 KB = 5 MB
```

### 3. Secure Storage Path
```php
$path = $request->file('image_file')->store('portfolios', 'public');
```
- Laravel otomatis generate random filename
- Tidak vulnerable to path traversal
- File disimpan di public storage

### 4. Automatic Cleanup
```php
// Model boot event
static::deleting(function ($portfolio) {
    if ($portfolio->image_type === 'uploaded' && $portfolio->image_path) {
        Storage::disk('public')->delete($portfolio->image_path);
    }
});
```
- File dihapus saat portfolio dihapus
- File dihapus saat diganti
- Tidak ada orphaned files

### 5. URL Validation
```php
'image_url' => 'url'
```
- URL harus valid format
- Bisa divalidasi lebih ketat jika perlu (SSL, domain whitelist, etc)

---

## 📦 File Locations

```
├── database/
│   └── migrations/
│       └── 2026_01_02_000000_add_image_upload_to_portfolios_table.php
│
├── app/
│   ├── Models/
│   │   └── Portfolio.php (UPDATED)
│   │
│   ├── Http/Controllers/
│   │   └── PortfolioController.php (UPDATED)
│   │
│   └── Helpers/
│       └── PortfolioImageHelper.php (NEW)
│
├── resources/views/portfolio/
│   ├── upload-image-form.blade.php (EXAMPLE)
│   └── display-portfolio.blade.php (EXAMPLE)
│
├── storage/app/public/
│   └── portfolios/  ← File disimpan di sini
│       ├── abc123def456.jpg
│       ├── xyz789pqr123.png
│       └── ...
│
├── public/
│   └── storage/  ← Symlink ke storage/app/public
│
└── Documentation files:
    ├── IMAGE_UPLOAD_FEATURES.md
    ├── PHOTO_UPLOAD_SETUP.md
    ├── QUICK_REFERENCE_IMAGE_UPLOAD.md
    └── CREATOR_UPLOAD_IMPLEMENTATION.md (ini)
```

---

## 🐛 Troubleshooting

### Problem: File tidak tersimpan
```
Solution:
1. php artisan storage:link (buat symlink)
2. chmod -R 755 storage/app/public
3. Check php.ini upload_max_filesize
```

### Problem: Image tidak tampil di view
```
Solution:
1. Verify symlink: ls -la public/storage
2. Check file path: dd($portfolio->image_path)
3. Use absolute path: asset('storage/...') bukan url()
```

### Problem: File tidak terhapus saat delete
```
Solution:
1. Verify model boot() method exists
2. Check Storage facade imported
3. Ensure storage/app/public permissions 755
```

### Problem: Validation error "File must be an image"
```
Solution:
1. Ensure proper file uploaded (bukan corrupted)
2. Check MIME type: file -i filename.jpg
3. Try different file format
```

---

## 📈 Performance Tips

1. **Image Compression**
   ```php
   // Consider adding image optimization
   // Use libraries: Intervention Image, ImageMagick
   ```

2. **Lazy Loading**
   ```blade
   <img src="..." loading="lazy">
   ```

3. **CDN Integration**
   ```php
   // Move uploaded images to CDN in production
   // Set image_url to CDN URL
   ```

4. **Storage Cleanup**
   ```bash
   php artisan storage:cleanup  // Remove old files
   ```

---

## 🎓 Learning Resources

- [Laravel File Storage](https://laravel.com/docs/11.x/filesystem)
- [Laravel Validation](https://laravel.com/docs/11.x/validation#file-uploads)
- [File Uploads Best Practices](https://owasp.org/www-community/vulnerabilities/Unrestricted_File_Upload)

---

## ✨ Summary

### Apa yang sudah diimplementasikan:
- ✅ Database migration untuk image_type dan image_path
- ✅ Model dengan upload/URL handling
- ✅ Controller dengan file upload logic
- ✅ Helper class untuk mudah digunakan di view
- ✅ Security validations
- ✅ Automatic file cleanup
- ✅ Comprehensive documentation

### Siap untuk:
- ✅ Create portfolio dengan upload foto atau URL
- ✅ Edit portfolio dengan ganti tipe image
- ✅ Delete portfolio dengan otomatis hapus file
- ✅ Display image dengan benar di view

### Next Steps (Optional):
- [ ] Image compression/optimization
- [ ] CDN integration
- [ ] Image cropping interface
- [ ] Batch upload
- [ ] Image gallery
- [ ] WEBP conversion

---

**Status:** ✅ READY FOR TESTING
**Last Updated:** January 2, 2026
**Version:** 1.0
