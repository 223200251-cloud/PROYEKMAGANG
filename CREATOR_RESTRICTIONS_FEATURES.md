# Fitur Pembatasan Akses Kreator

## Deskripsi
Fitur ini membatasi akses kreator (individual) untuk melakukan beberapa aksi tertentu dalam aplikasi LMS Portofolio.

## Batasan Akses Kreator

### ✅ Diizinkan:
1. **Mengunggah Karya (Portfolio)**
   - Kreator bisa membuat portfolio baru
   - Bisa mengedit/mengupdate profil portfolio miliknya sendiri
   - Bisa menghapus portfolio miliknya sendiri

2. **Melihat Komentar**
   - Kreator bisa melihat semua komentar di portfolio
   - Hanya bisa membaca/view, tidak bisa membuat, edit, atau hapus komentar

3. **Menyunting Profil Portofolio**
   - Mengupdate deskripsi, judul, kategori, dan informasi lainnya
   - Mengatur pengaturan portfolio (visibility, display order, highlight)

### ❌ Dilarang:
1. **Mengirim Chat/Pesan**
   - Kreator tidak bisa mengirim pesan ke user manapun
   - Kreator tidak bisa melihat daftar percakapan chat
   - Tidak ada akses ke fitur messaging sama sekali

2. **Membuat Komentar**
   - Kreator tidak bisa menambahkan komentar di portfolio
   - Tidak bisa mengedit komentar mereka sendiri
   - Tidak bisa menghapus komentar

## File yang Dimodifikasi

### 1. Policy Files (Authorization)
- **[app/Policies/ChatPolicy.php](app/Policies/ChatPolicy.php)**
  - Menentukan siapa saja yang bisa mengakses chat
  - Method: `create()`, `viewAny()`, `view()`
  - Kreator otomatis ditolak

- **[app/Policies/CommentPolicy.php](app/Policies/CommentPolicy.php)**
  - Mengatur permission untuk komentar
  - Method: `viewAny()`, `view()` (diizinkan), `create()`, `update()`, `delete()` (ditolak untuk kreator)

- **[app/Policies/PortfolioPolicy.php](app/Policies/PortfolioPolicy.php)**
  - Update: menambahkan method `create()` untuk membatasi akses upload
  - Kreator tetap bisa create, update, dan delete portfolio miliknya sendiri

### 2. Controller Files
- **[app/Http/Controllers/ChatController.php](app/Http/Controllers/ChatController.php)**
  - `sendMessage()`: Cek apakah user adalah kreator sebelum mengirim pesan
  - `conversations()`: Tolak akses kreator ke daftar percakapan
  - Menampilkan error message jelas kepada kreator

- **[app/Http/Controllers/PortfolioController.php](app/Http/Controllers/PortfolioController.php)**
  - `create()`: Menambahkan authorization check
  - `addComment()`: Tolak kreator dari membuat komentar
  - Menampilkan pesan error yang user-friendly

### 3. Service Provider
- **[app/Providers/AppServiceProvider.php](app/Providers/AppServiceProvider.php)**
  - Register semua policies:
    - `Portfolio` → `PortfolioPolicy`
    - `Chat` → `ChatPolicy`
    - `Comment` → `CommentPolicy`

## Cara Kerja

### User Type Detection
Sistem mendeteksi kreator berdasarkan:
```php
$user->user_type === 'individual'  // Kreator
$user->user_type === 'company'     // Perusahaan
```

### Authorization Checks
Setiap action yang sensitive melakukan dua jenis check:

1. **Explicit Check** (di Controller)
   ```php
   if ($currentUser->user_type === 'individual') {
       return response()->json(['message' => 'Kreator tidak diizinkan...'], 403);
   }
   ```

2. **Policy Check** (Laravel Authorization)
   ```php
   $this->authorize('create', Chat::class);
   ```

## Testing

### Test Case 1: Kreator Mengirim Chat
```
1. Login sebagai kreator
2. Buka halaman chat
3. Coba kirim pesan
4. ❌ Sistem menampilkan error: "Kreator tidak diizinkan mengirim pesan chat"
```

### Test Case 2: Kreator Membuat Komentar
```
1. Login sebagai kreator
2. Buka halaman portfolio milik kreator lain
3. Coba tambah komentar
4. ❌ Sistem menampilkan error: "Kreator tidak diizinkan membuat komentar"
```

### Test Case 3: Kreator Upload Karya
```
1. Login sebagai kreator
2. Buka halaman create portfolio
3. Isi form dan submit
4. ✅ Portfolio berhasil dibuat
```

### Test Case 4: Kreator Lihat Komentar
```
1. Login sebagai kreator
2. Buka halaman portfolio (miliknya sendiri atau orang lain)
3. Scroll ke bagian komentar
4. ✅ Bisa melihat daftar komentar
5. ❌ Button "Tambah Komentar" tidak tersedia atau disabled
```

### Test Case 5: Non-Kreator Bisa Chat
```
1. Login sebagai user biasa/company staff
2. Buka halaman chat
3. Kirim pesan ke user lain
4. ✅ Pesan berhasil dikirim
5. ❌ Tidak bisa mengirim pesan ke kreator (error message)
```

## Response Messages

### Chat Restrictions
- **Mengirim pesan**: `"Kreator tidak diizinkan mengirim pesan chat"`
- **Lihat conversations**: `"Kreator tidak diizinkan mengakses pesan chat"`
- **Mengirim ke kreator**: `"Anda tidak bisa mengirim pesan ke kreator"`

### Comment Restrictions
- **Membuat komentar**: `"Kreator tidak diizinkan membuat komentar"`

## Catatan Implementasi

1. **Database**: Tidak perlu migration baru. Menggunakan field `user_type` yang sudah ada.

2. **Frontend**: Disarankan untuk:
   - Menyembunyikan button "Chat" untuk profil kreator
   - Menyembunyikan form komentar jika user adalah kreator
   - Menampilkan badge khusus di profil kreator

3. **Error Handling**: Semua restriction mengembalikan HTTP 403 (Forbidden) dengan pesan yang jelas.

## Ekstensibilitas

Untuk menambah/mengubah batasan:
1. Modify logic di relevant Policy class
2. Update controller jika perlu explicit check
3. Tambah test cases
4. Update dokumentasi ini
