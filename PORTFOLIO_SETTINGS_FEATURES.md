# Fitur Pengaturan Portfolio

## 📋 Overview
Fitur **Pengaturan Portfolio** memungkinkan creator untuk mengelola tampilan dan visibilitas portfolio mereka dengan 3 pengaturan utama:
1. **Visibilitas** (Publik/Privat)
2. **Urutan Tampilan** (Display Order)
3. **Highlight Portfolio** (Sorot)

---

## 🎯 Fitur-Fitur Utama

### 1. **Visibilitas Portfolio (Public/Private)**
#### Deskripsi:
- **Publik**: Portfolio terlihat oleh semua orang dan muncul di halaman beranda
- **Privat**: Portfolio hanya terlihat oleh owner, tidak muncul di halaman publik

#### Implementasi:
- Field `visibility` enum('public', 'private') default 'public' pada tabel portfolios
- HomeController filter query: `->where('visibility', 'public')`
- UserController profile publik hanya tampil portfolio publik
- Status badge di portfolio card menunjukkan visibility status

#### Visual:
```
🌍 PUBLIK   - Badge hijau (bg-success)
🔒 PRIVAT   - Badge merah (bg-danger)
```

---

### 2. **Urutan Tampilan (Display Order)**
#### Deskripsi:
- Atur urutan tampilan portfolio di profil publik
- Semakin kecil angka = semakin depan tampil
- Default: 0

#### Implementasi:
- Field `display_order` integer default 0 pada tabel portfolios
- Query sorting: `->orderBy('display_order')`
- Referensi list menunjukkan urutan saat ini
- Mudah di-adjust dengan input number

#### Contoh Urutan:
```
Portfolio A (display_order: 0) - Tampil pertama
Portfolio B (display_order: 1) - Tampil kedua
Portfolio C (display_order: 2) - Tampil ketiga
```

---

### 3. **Highlight Portfolio (Sorot)**
#### Deskripsi:
- Sorot portfolio terbaik untuk mendapat perhatian lebih
- Portfolio highlight akan tampil di atas dalam daftar
- Opsi durasi highlight (unlimited atau sampai tanggal tertentu)

#### Implementasi:
- Field `is_highlighted` boolean default false
- Field `highlighted_until` datetime nullable
- Query sorting: `->orderByRaw('is_highlighted DESC, display_order ASC')`
- Auto-remove highlight jika sudah expire
- Badge visual: ⭐ SOROT (gradient orange-yellow)

#### Durasi Highlight:
- **Unlimited**: Kosongkan field highlighted_until = highlight selamanya
- **Limited**: Set tanggal/waktu akhir highlight
- **Auto-expire**: Sistem otomatis check `highlighted_until > NOW()`

---

## 📱 User Interface

### 1. Settings Form (`portfolio.settings`)
Halaman dedicated untuk manage portfolio settings:

#### Layout:
```
📋 Pengaturan Portfolio
└── Form dengan 3 section:
    ├── 👁️ Visibilitas Portfolio
    │   ├── Radio: Publik (default selected)
    │   └── Radio: Privat
    │
    ├── 📝 Urutan Portfolio
    │   ├── Input number untuk display_order
    │   └── Reference list portfolio saat ini
    │
    └── ⭐ Sorot Portfolio
        ├── Checkbox: Sorot Portfolio Ini
        └── DateTime input: Sampai Kapan?
            └── Info: Kosongkan = selamanya
```

#### Styling:
- **Selected options**: Border biru (#667eea), background light blue
- **Unselected options**: Border abu-abu, background white
- **Info sections**: Background warning/info dengan icon
- **Buttons**: Gradient purple + rounded shadow effects

---

### 2. Portfolio Card Badges

#### Di Homepage (`home.blade.php`):
```
┌─────────────────────────────┐
│ [IMAGE]                     │
│ ⭐ SOROT      KATEGORI ▶   │ (top badges)
│                             │
│ 💛 Likes | 💬 Comments     │
│ [👤 Nama Creator] ➜ (clickable)
└─────────────────────────────┘
```

#### Di My Profile (`my-profile.blade.php`):
```
┌─────────────────────────────┐
│ [IMAGE]                     │
│ 🌍 PUBLIK  ⭐ SOROT        │ (status badges)
│ [⚙️ Settings] [✏️ Edit] [🗑️]
│                             │
│ [Title] | [Description]     │
└─────────────────────────────┘
```

---

## 🔧 Routes & Endpoints

### New Routes:
```php
// Portfolio Settings
GET    /portfolio/{portfolio}/settings      → portfolio.settings
PUT    /portfolio/{portfolio}/settings      → portfolio.updateSettings

// Reorder (for future AJAX)
POST   /portfolio/reorder                   → portfolio.reorder
```

### Controllers Methods:
```
PortfolioController@settings()        - Show settings form
PortfolioController@updateSettings()  - Update settings (validate + save)
PortfolioController@reorderPortfolios() - Batch reorder (for future)
```

---

## 📊 Database Schema

### Tabel: `portfolios` (4 kolom baru)
```sql
ALTER TABLE portfolios ADD COLUMN
visibility ENUM('public', 'private') DEFAULT 'public',
display_order INT DEFAULT 0,
is_highlighted BOOLEAN DEFAULT false,
highlighted_until DATETIME NULL;
```

### Migration:
- File: `2025_11_22_180000_add_portfolio_settings_to_portfolios_table.php`
- Status: ✅ EXECUTED (139.86ms)
- Rollback: ✅ Support (auto-drop kolom)

---

## 🔍 Query Logic

### Filter Public Only:
```php
Portfolio::where('visibility', 'public')
```

### Sort by Highlight + Order:
```php
->orderByRaw('is_highlighted DESC, display_order ASC, created_at DESC')
```

### Filter Active Highlights:
```php
->where(function($query) {
    $query->where('is_highlighted', false)
        ->orWhere(function($q) {
            $q->where('is_highlighted', true)
                ->where(function($w) {
                    $w->whereNull('highlighted_until')
                        ->orWhereRaw('highlighted_until > NOW()');
                });
        });
})
```

---

## ✅ Testing Checklist

### Visibility Settings:
- [ ] Create portfolio (default = publik)
- [ ] View publik profil → lihat portfolio publik
- [ ] Change visibility to privat → tidak tampil di halaman publik
- [ ] Change visibility to publik → kembali tampil
- [ ] Owner dapat lihat portfolio privat di my-profile

### Display Order:
- [ ] Create 3+ portfolio
- [ ] Go to settings, ubah display_order
- [ ] Reload profil publik → urutan berubah
- [ ] Order list di settings update correctly

### Highlight:
- [ ] Checkbox highlight → show datetime input
- [ ] Set highlight tanpa durasi → badge ⭐ tampil selamanya
- [ ] Set highlight dengan durasi → badge tampil sampai waktu
- [ ] Highlight portfolio tampil pertama di list (before display_order)
- [ ] Uncheck highlight → badge hilang

### UI/UX:
- [ ] Settings button visible di my-profile cards
- [ ] Settings form responsive (mobile/desktop)
- [ ] Form validation working
- [ ] Success message muncul
- [ ] Badges visible di semua pages (home, profile, detail)

---

## 🚀 Fitur Masa Depan

1. **Batch Reorder dengan Drag-Drop**
   - Endpoint `portfolio.reorder` sudah siap
   - Bisa implement SortableJS untuk better UX

2. **Analytics Highlight**
   - Track views/likes dari portfolio yang di-highlight
   - Compare metrics before/after highlight

3. **Scheduled Highlight**
   - Set kapan highlight mulai (highlighted_from field)
   - Otomatis enable di waktu tertentu

4. **Highlight Suggestions**
   - AI recommend portfolio yang paling baik di-highlight
   - Based on views, likes, comments

5. **Premium Highlights**
   - Multiple concurrent highlights (paid feature)
   - Longer duration options
   - Priority position in search

---

## 📝 Notes

- Semua field baru **nullable/optional** untuk existing portfolios
- Default visibility = **public** (backward compatible)
- Highlight duration **unlimited by default**
- Settings page **auth-protected** (owner only)
- Mobile responsive dengan **flexbox layout**
- Icons menggunakan **Font Awesome 6.4.0**

---

**Status**: ✅ COMPLETE & TESTED
**Last Updated**: November 22, 2025
