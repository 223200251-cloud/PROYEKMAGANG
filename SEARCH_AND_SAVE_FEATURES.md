# Update: Pencarian & Save Kandidat dari Profil

## ✅ Fixed Issues

### 1. CompanyController Middleware Error
**Problem**: Constructor middleware tidak kompatibel dengan Laravel 12
```php
// ❌ BEFORE
public function __construct() {
    $this->middleware('auth');
}
```

**Solution**: Middleware dipindahkan ke routes/web.php
```php
// ✅ AFTER
// Route middleware defined in web.php
Route::middleware('auth')->group(function () {
    Route::get('/company/saved-creators', ...);
    ...
});
```

---

## ✅ Fitur Baru

### 1. Search Portfolio & Creator
**URL**: `/` (Home dengan query parameter)

#### Search Bar Features:
- 🔍 Real-time search untuk portfolio title
- 🔍 Search dalam portfolio description
- 🔍 Search creator name & username
- 📊 Hasil ditampilkan dengan pagination
- ✨ Clean button untuk clear search
- 🎯 Query preserved dalam pagination

#### Implementation:
```blade
<form method="GET" action="{{ route('home') }}">
    <input type="text" name="q" placeholder="Cari portfolio, creator...">
    <button type="submit">Cari</button>
    @if($search)
        <a href="{{ route('home') }}">Bersihkan</a>
    @endif
</form>
```

#### Controller Logic:
```php
public function index(Request $request)
{
    $search = $request->get('q');
    
    if ($search) {
        $portfolios = Portfolio::with(['user', 'comments', 'likes'])
            ->where('title', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhereHas('user', function($query) use ($search) {
                $query->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('username', 'LIKE', "%{$search}%");
            })
            ->paginate(6)
            ->appends($request->query());
    } else {
        $portfolios = Portfolio::with(['user', 'comments', 'likes'])
            ->inRandomOrder()
            ->paginate(6);
    }
    
    return view('home', compact('portfolios', 'search'));
}
```

---

### 2. Save Kandidat dari Profil Creator

**URL**: `/user/{user}` (Profile Creator)

#### Features:
- 📌 Button "Simpan Kandidat" untuk company users
- 📌 Button "Hapus dari Kandidat" jika sudah disimpan
- ✨ Smooth button state transitions
- 🎯 Check apakah creator sudah disimpan
- ⚡ AJAX save/unsave tanpa reload page

#### Profile View Implementation:
```blade
@auth
    @if(Auth::user()->isCompany())
        <button onclick="saveCreator({{ $user->id }})" 
            class="btn btn-primary"
            data-save-profile="{{ $user->id }}">
            <i class="fas fa-bookmark"></i> 
            <span id="save-text-{{ $user->id }}">
                @if($user->isSavedBy(Auth::id()))
                    Hapus dari Kandidat
                @else
                    Simpan Kandidat
                @endif
            </span>
        </button>
    @endif
@endauth
```

#### JavaScript Function:
```javascript
function saveCreator(creatorId) {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const btn = document.querySelector(`[data-save-profile="${creatorId}"]`);
    const textEl = document.getElementById(`save-text-${creatorId}`);
    
    fetch(`/company/save-creator/${creatorId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.saved) {
            textEl.textContent = 'Hapus dari Kandidat';
            btn.style.background = 'linear-gradient(135deg, #667eea, #764ba2)';
        } else {
            textEl.textContent = 'Simpan Kandidat';
            btn.style.background = '#f0f2f5';
        }
        showToast(data.message);
    });
}
```

---

## Testing Guide

### Test 1: Search Portfolio
1. Go to home page `/`
2. Type search query di search bar (contoh: "web design", "andi")
3. Press "Cari" button
4. Verify hasil sesuai
5. Click "Bersihkan" untuk reset

**Expected Results**:
- Search results menampilkan portfolio dengan matching title/description
- Creator dengan matching name/username ditampilkan
- Pagination appends query parameter
- "Bersihkan" button mengembalikan ke home

### Test 2: Save from Profile (Company)
1. Login dengan company account (`recruiter@example.com`)
2. Go to creator profile (click creator name di portfolio card)
3. See button "Simpan Kandidat"
4. Click button - animated & toast message
5. Button text berubah ke "Hapus dari Kandidat"
6. Click again - removed from saved

**Expected Results**:
- Button only shows untuk company users
- Creator tidak show button
- Button state updates correctly
- Toast notification shows
- Data saved ke database

### Test 3: View Saved from Profile
1. Company sudah save beberapa creator
2. Go to creator profile
3. Button shows "Hapus dari Kandidat" dengan styling berbeda
4. Click to remove
5. Go to `/company/saved-creators`
6. Verify creator tidak lagi di list

**Expected Results**:
- Button state reflects saved status
- Remove works properly
- Saved list updated

---

## Database Queries

### Check Saved Creators
```sql
SELECT * FROM saved_creators WHERE company_id = {company_id};
```

### Check if Creator is Saved
```sql
SELECT * FROM saved_creators 
WHERE company_id = {company_id} 
AND creator_id = {creator_id};
```

---

## User Model Methods

```php
// Check if creator is saved by company
$creator->isSavedBy($companyId)

// Get all saved creators for company
$company->savedCreators()

// Check if user is company
$user->isCompany()

// Check if user is creator
$user->isCreator()
```

---

## Routes Summary

```
# Search (GET)
GET     /                           home@index      (with ?q=search)

# Company Routes (Protected with auth)
GET     /company/saved-creators     company@savedCreators
POST    /company/save-creator/{id}  company@saveCreator
POST    /company/contact/{id}       company@contactCreator

# User Profile
GET     /user/{user}                user@show       (public view)
```

---

## Modified Files

```
✅ app/Http/Controllers/CompanyController.php
   - Removed constructor middleware
   - Fixed middleware incompatibility

✅ app/Http/Controllers/HomeController.php
   - Added search functionality
   - Handle ?q parameter

✅ resources/views/home.blade.php
   - Added search bar
   - Search form styling
   - Display search results

✅ resources/views/profile/show.blade.php
   - Added save button untuk company
   - JavaScript untuk save/unsave
   - Check if already saved
```

---

## Testing Accounts

### Company Account (untuk test save)
- Email: `recruiter@example.com`
- Password: `password`
- User Type: Company

### Creator Accounts (untuk test save dari profil)
- Email: `test@example.com` atau `andi@example.com`
- Password: `password`
- User Type: Creator/Individual

---

## Future Enhancements

- [ ] Advanced filter (category, skills, location)
- [ ] Sort options (newest, popular, trending)
- [ ] Save search queries
- [ ] Recently viewed creators
- [ ] Recommended creators
- [ ] Company to creator messaging
- [ ] Batch operations (add multiple)
- [ ] Export saved list as CSV
- [ ] Activity notifications
- [ ] Advanced search filters

---

## Summary

✅ **Semua fitur selesai dan tested**:
- Search portfolio & creator
- Save kandidat dari profil creator
- Button state management
- Toast notifications
- AJAX interactions
- Proper authorization

Aplikasi kini memiliki **2 tipe user yang fully functional** dengan fitur pencarian dan save kandidat! 🚀
