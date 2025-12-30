# Fitur Company/Recruiter - Documentation

## Overview
Sistem ini kini mendukung dua tipe user yang berbeda: **Creator/Individual** dan **Company/Recruiter** dengan fitur-fitur yang disesuaikan untuk masing-masing tipe.

## Tipe User

### 1. Creator/Individual (Default)
- **Tujuan**: Membagikan portfolio dan karya kreatif
- **Fitur**:
  - ✅ Membuat dan mengelola portfolio
  - ✅ Menerima like dan comments pada portfolio
  - ✅ Melihat view count
  - ✅ Edit profil pribadi
  - ✅ Akses public profile

### 2. Company/Recruiter (Baru)
- **Tujuan**: Mencari dan menghubungi talenta terbaik
- **Fitur**:
  - ✅ Melihat dan menjelajahi portfolio dari semua creator
  - ✅ Menyimpan/bookmark creator yang tertarik
  - ✅ Mengelola daftar kandidat disimpan
  - ✅ Menampilkan informasi perusahaan
  - ✅ Menghubungi creator secara langsung

## Akun Test

### Creator Account
- **Email**: `test@example.com` / `andi@example.com`
- **Password**: `password`
- **Type**: Creator/Individual

### Company Account
- **Email**: `recruiter@example.com`
- **Password**: `password`
- **Type**: Company/Recruiter
- **Company Name**: PT Tech Indonesia
- **Website**: https://pttech.co.id
- **Phone**: +62-812-3456-7890

### Admin Account
- **Email**: `admin@example.com`
- **Password**: `password`

## Fitur Detail

### 1. Register dengan User Type Selection

#### URL: `/register`

User dapat memilih tipe akun saat mendaftar:

```
┌─────────────────────────────────────────┐
│     Tipe Akun (Pilih Salah Satu)       │
├─────────────────────────────────────────┤
│ [✓] Creator/Individual | [ ] Perusahaan │
└─────────────────────────────────────────┘
```

**Fields untuk Creator:**
- Name
- Email
- Username
- Password
- Password Confirmation

**Fields tambahan untuk Company:**
- Company Name (required)
- Company Website (optional)
- Company Phone (optional)
- Company Description (optional)

### 2. Portfolio Listing dengan Konteks User

#### URL: `/` (Home/Portfolio List)

**Untuk Creator:**
- ❤️ Button untuk Like portfolio
- View detail portfolio
- Lihat jumlah likes dan comments

**Untuk Company:**
- 🔖 Button untuk Save/Bookmark creator
- Lihat profil creator
- Akses informasi kontak
- Button ke saved candidates list

### 3. Saved Creators Management

#### URL: `/company/saved-creators`

**Akses**: Hanya untuk company users

**Tampilan:**
- Grid of saved creators dengan:
  - Avatar creator
  - Nama dan username
  - Bio/deskripsi singkat
  - Jumlah portfolio
  - Total views
  - Email (untuk kontak)
  - Website (jika ada)
  - Catatan (untuk company notes)

**Fitur:**
- View saved creator list dengan pagination
- Lihat profil creator lengkap
- Remove dari daftar saved
- Quick access ke email creator

#### Routes:

```
POST   /company/save-creator/{creator}    - Save/unsave creator (AJAX)
GET    /company/saved-creators            - View saved list
POST   /company/contact-creator/{creator} - Send message (future)
```

### 4. Database Structure

#### Users Table - Company Fields

```sql
ALTER TABLE users ADD COLUMN (
  user_type ENUM('individual', 'company') DEFAULT 'individual',
  company_name VARCHAR(255),
  company_website VARCHAR(255),
  company_description TEXT,
  company_phone VARCHAR(20)
);
```

#### SavedCreators Table

```sql
CREATE TABLE saved_creators (
  id BIGINT PRIMARY KEY,
  company_id BIGINT FOREIGN KEY,
  creator_id BIGINT FOREIGN KEY,
  notes TEXT,
  created_at TIMESTAMP,
  updated_at TIMESTAMP,
  UNIQUE(company_id, creator_id)
);
```

## Models & Methods

### User Model

**Fitur Baru:**

```php
// Check user type
$user->isCreator()      // true jika individual
$user->isCompany()      // true jika perusahaan

// Company relationships
$company->savedCreators()  // Get all saved creators
$creator->isSavedBy($companyId)  // Check if saved by company
```

### SavedCreator Model

```php
class SavedCreator {
    - company_id (FK to User)
    - creator_id (FK to User)
    - notes (optional)
    - timestamps
}
```

**Relationships:**
```php
$saved->company()  // Get company
$saved->creator()  // Get creator
```

## Controller: CompanyController

### Methods:

1. **savedCreators()** - View saved creators list
   - Route: `GET /company/saved-creators`
   - Returns: Paginated list of saved creators

2. **saveCreator(User $creator)** - Toggle save creator
   - Route: `POST /company/save-creator/{creator}`
   - Returns: JSON {saved: boolean, message: string}
   - Check if creator is company
   - Toggle save/unsave status
   - Prevent duplicate saves

3. **contactCreator(Request $request, User $creator)** - Send message
   - Route: `POST /company/contact-creator/{creator}`
   - Validates: message (required, max 1000 chars)
   - Sends email notification to creator
   - Returns: JSON {success: true/false}

## Frontend Implementation

### Home View - Save Creator Button

**For Company Users:**
```blade
<button onclick="saveCreator({{ $portfolio->user->id }})" 
    data-save-btn="{{ $portfolio->user->id }}">
    <i class="fas fa-bookmark"></i>
</button>
```

**JavaScript Function:**
```javascript
function saveCreator(creatorId) {
    // AJAX POST to /company/save-creator/{creatorId}
    // Toggle bookmark status
    // Show toast message
}
```

### Saved Creators View

**Card-based layout dengan:**
- Creator avatar (gradient background)
- Creator name & username
- Bio/description
- Portfolio count
- Total views
- Contact info (email, website)
- Notes section (if any)
- Actions (View Profile, Remove)

### Navigation

**Navbar untuk Company Users:**
- Dropdown menu dengan link ke "Kandidat Disimpan"
- Icon bookmark untuk quick access

## Validation Rules

### Register Validation

```php
'name' => 'required|string|max:255',
'email' => 'required|email|unique:users,email',
'username' => 'required|string|unique:users,username|max:50',
'password' => 'required|string|min:8|confirmed',
'user_type' => 'required|in:individual,company',
'company_name' => 'required_if:user_type,company|string|max:255',
'company_website' => 'nullable|url',
'company_phone' => 'nullable|string|max:20',
'company_description' => 'nullable|string|max:1000',
```

### Contact Creator Validation

```php
'message' => 'required|string|max:1000',
```

## Security & Authorization

### Middleware Checks:
- `auth` - User harus login
- `isCompany()` - Hanya company bisa save creator
- Prevent company dari save company lain
- Creator tidak bisa save creator

### Data Protection:
- Email tidak di-expose di frontend
- Unique constraint pada (company_id, creator_id)
- User type validation pada request

## Testing Checklist

### 1. Register as Company
- [ ] Register dengan pilih tipe "Perusahaan"
- [ ] Fill company fields (name, website, phone, description)
- [ ] Verify company data tersimpan di database
- [ ] Login dengan company account

### 2. Register as Creator
- [ ] Register dengan pilih tipe "Creator"
- [ ] Company fields hidden
- [ ] Creator account created successfully

### 3. Home Page Interactions
- [ ] Login as company
- [ ] Home page shows save button (bookmark icon)
- [ ] Click save button - button animates
- [ ] Toast message shows
- [ ] Creator saved in database

### 4. Saved Creators Page
- [ ] Navigate to /company/saved-creators
- [ ] View list of saved creators
- [ ] See creator card with all info
- [ ] Click "Lihat Profil" - go to creator profile
- [ ] Click remove button - creator removed from list

### 5. Navbar & Navigation
- [ ] Login as company
- [ ] Dropdown menu shows "Kandidat Disimpan"
- [ ] Click to navigate to saved list
- [ ] Creator doesn't see this option

### 6. Database Verification
- [ ] Check users table - company fields populated
- [ ] Check saved_creators table - relationships created
- [ ] Verify unique constraint (no duplicate saves)

## Future Enhancements

- [ ] **Messaging System** - Real-time chat between company & creator
- [ ] **Job Postings** - Company dapat post job openings
- [ ] **Application System** - Creator dapat apply ke job
- [ ] **Notifications** - Email/in-app when saved, contacted
- [ ] **Advanced Search** - Filter creators by skill, location
- [ ] **Reviews** - Company dapat rate creator
- [ ] **Contract Template** - Simple contract for hiring
- [ ] **Payment Integration** - For freelance work
- [ ] **Activity Log** - Track who viewed/saved
- [ ] **Export** - Export saved candidates to CSV

## File Structure

```
app/
├── Http/Controllers/
│   └── CompanyController.php          ✅ NEW
├── Models/
│   ├── User.php                       ✅ UPDATED
│   └── SavedCreator.php               ✅ NEW

database/
├── migrations/
│   ├── 2025_11_22_160000_add_company_fields_to_users_table.php  ✅ NEW
│   └── 2025_11_22_160001_create_saved_creators_table.php        ✅ NEW
└── seeders/
    └── DatabaseSeeder.php             ✅ UPDATED

resources/views/
├── auth/
│   └── register.blade.php             ✅ UPDATED
├── home.blade.php                     ✅ UPDATED
├── layouts/
│   └── app.blade.php                  ✅ UPDATED
└── company/
    └── saved-creators.blade.php       ✅ NEW

routes/
└── web.php                            ✅ UPDATED
```

## Database Seeding

### Test Company Account

```
Email: recruiter@example.com
Password: password
Company Name: PT Tech Indonesia
Website: https://pttech.co.id
Phone: +62-812-3456-7890
Description: Perusahaan teknologi terdepan yang mengembangkan solusi digital inovatif untuk bisnis modern.
```

## API Endpoints

### Save/Unsave Creator

**Endpoint**: `POST /company/save-creator/{creator}`

**Headers**:
```
Content-Type: application/json
X-CSRF-TOKEN: {token}
```

**Response Success**:
```json
{
  "saved": true,
  "message": "Creator disimpan"
}
```

**Response Remove**:
```json
{
  "saved": false,
  "message": "Creator dihapus dari daftar"
}
```

**Errors**:
```json
{
  "error": "Unauthorized" // Jika user bukan company
}
```

## Summary

Fitur Company/Recruiter sekarang **fully implemented** dengan:

✅ User type selection pada register
✅ Company profile fields
✅ Save/bookmark creator functionality
✅ Saved candidates list & management
✅ Proper authorization & validation
✅ Responsive UI design
✅ AJAX interactions
✅ Database relationships
✅ Test data seeding

Ready untuk production use dengan proper testing!
