# Quick Start & Testing Guide - Portfolio Hub LMS

## 🚀 Aplikasi Siap Digunakan

### Fitur Lengkap:
✅ Sistem autentikasi user (register/login)
✅ 2 tipe user (Creator/Individual & Company/Recruiter)
✅ Manajemen portfolio (CRUD)
✅ Like & comment pada portfolio
✅ User profiles (public & private)
✅ Search portfolio & creator
✅ Save/bookmark creator (company feature)
✅ Admin dashboard dengan moderasi
✅ Admin user management
✅ Admin kategori management
✅ Responsive design

---

## 📝 Test Accounts

### 1️⃣ Creator/Individual Account
```
Email: test@example.com
Password: password
Type: Creator
```

### 2️⃣ Company/Recruiter Account
```
Email: recruiter@example.com
Password: password
Type: Company/Recruiter
Name: PT Tech Indonesia
```

### 3️⃣ Additional Creator Accounts
```
Email: andi@example.com (or other seed accounts)
Password: password
Type: Creator
```

### 4️⃣ Admin Account
```
Email: admin@example.com
Password: password
Type: Admin
```

---

## 🎯 Testing Workflow

### Scenario 1: Creator Portfolio Flow
```
1. Login: test@example.com / password
2. Navigate: Click "Buat Portfolio" atau /portfolio/create
3. Create: Fill portfolio form (title, description, etc)
4. View: Click portfolio to see detail
5. Interact: Like button, view count
6. Profile: Go to /my-profile to see your portfolios
7. Edit: Click edit portfolio
8. Delete: Click delete portfolio
```

### Scenario 2: Company Search & Save
```
1. Login: recruiter@example.com / password
2. Home: Search portfolio/creator di home page
   - Type creator name (e.g., "andi", "budi")
   - Type skill (e.g., "web", "design")
3. Save from Card: Click bookmark button on portfolio card
4. Save from Profile: 
   - Click creator name/avatar
   - Click "Simpan Kandidat" button
   - Verify button state changes
5. View Saved: 
   - Go to /company/saved-creators
   - See all saved creators
   - Click remove to unsave
```

### Scenario 3: Admin Panel
```
1. Login: admin@example.com / password
2. Admin Panel: Click "Admin Panel" button in navbar
3. Dashboard: See stats & recent portfolios
4. User Management:
   - Click "Kelola User"
   - View user list with ban toggle
   - Click "View" to see user detail
   - Click "Edit" to edit user
5. Moderation:
   - Click "Moderasi Portfolio"
   - Review flagged portfolios
   - Approve/Reject/Flag/Delete
6. Categories:
   - Manage portfolio categories
   - CRUD operations
```

### Scenario 4: Register as Company
```
1. Go to /register
2. Select "Perusahaan/Recruiter" type
3. Fill company fields:
   - Company name
   - Website (optional)
   - Phone (optional)
   - Description (optional)
4. Set password
5. Create account
6. Auto-login & redirect to home
```

---

## 📍 Key Routes

### Public Routes
```
GET     /                           Home/Portfolio list
GET     /user/{user}                Creator profile
GET     /portfolio/{portfolio}      Portfolio detail
GET     /register                   Register page
GET     /login                      Login page
```

### Authenticated Routes (Creator)
```
POST    /logout                     Logout
GET     /my-profile                 My profile dashboard
GET     /profile/edit               Edit my profile
PUT     /profile/update             Update profile
GET     /portfolio/create           Create portfolio form
POST    /portfolio                  Store portfolio
GET     /portfolio/{id}/edit        Edit portfolio form
PUT     /portfolio/{id}             Update portfolio
DELETE  /portfolio/{id}             Delete portfolio
POST    /portfolio/{id}/like        Toggle like (AJAX)
POST    /portfolio/{id}/comment     Add comment
```

### Company Routes (Authenticated)
```
GET     /company/saved-creators     View saved creators
POST    /company/save-creator/{id}  Save/unsave creator (AJAX)
POST    /company/contact-creator/{id} Contact creator (email)
```

### Admin Routes (Protected with IsAdmin Middleware)
```
GET     /admin/dashboard            Admin dashboard
GET     /admin/users                User management list
GET     /admin/users/{id}           User detail
GET     /admin/users/{id}/edit      Edit user form
PUT     /admin/users/{id}           Update user
DELETE  /admin/users/{id}           Delete user
POST    /admin/users/{id}/toggleBan Ban/unban user
GET     /admin/moderation           Portfolio moderation list
GET     /admin/moderation/{id}      Moderation detail
POST    /admin/moderation/{id}/flag Flag portfolio
POST    /admin/moderation/{id}/unflag Remove flag
POST    /admin/moderation/{id}/approve Approve portfolio
POST    /admin/moderation/{id}/reject Reject portfolio
DELETE  /admin/moderation/{id}      Delete portfolio
GET     /admin/categories           Category management
GET     /admin/categories/create    Create category
POST    /admin/categories           Store category
GET     /admin/categories/{id}/edit Edit category
PUT     /admin/categories/{id}      Update category
DELETE  /admin/categories/{id}      Delete category
```

---

## 🔍 Search Examples

**Type in search bar:**
- `web design` - Search portfolio dengan "web design" di title/description
- `andi` - Search creator dengan nama "andi"
- `react` - Search portfolio dengan skill "react"
- `budi portfolio` - Kombinasi creator & portfolio search

**Results:**
- Portfolio matching title/description
- Creator matching name/username
- Paginated with query preserved

---

## 💾 Database

### Tables
```
users              - User accounts & profiles
portfolios         - Portfolio items
categories         - Portfolio categories
comments           - Portfolio comments
likes              - Portfolio likes
saved_creators     - Company saved creators
sessions           - Auth sessions
```

### Key Fields

**Users Table:**
```
id, name, email, username, password, role, user_type
avatar_url, bio, location, website
company_name, company_website, company_description, company_phone
is_banned, created_at, updated_at
```

**Portfolios Table:**
```
id, user_id, title, description, category
image_url, project_url, technologies
views, likes_count, comments_count
is_flagged, status, rejection_reason
created_at, updated_at
```

**SavedCreators Table:**
```
id, company_id, creator_id, notes
created_at, updated_at
```

---

## 🎨 Features by User Type

### Creator/Individual
- ✅ Create/edit/delete portfolio
- ✅ Like other portfolios
- ✅ Comment on portfolios
- ✅ View/edit personal profile
- ✅ See portfolio stats (views, likes)
- ✅ Search other portfolios & creators

### Company/Recruiter
- ✅ Search portfolios & creators
- ✅ Save/bookmark creators
- ✅ View creator profiles
- ✅ Access saved creators list
- ✅ Contact creator (via email)
- ❌ Cannot create portfolio
- ❌ Cannot like/comment

### Admin
- ✅ Manage all users (view, edit, ban, delete)
- ✅ Moderate portfolios (flag, approve, reject)
- ✅ Manage categories
- ✅ View dashboard & statistics
- ✅ All creator features

---

## 🐛 Troubleshooting

### Issue: 500 Error on /company/saved-creators
**Solution**: Make sure you're logged in and user type is 'company'
```
Check: Auth::user()->user_type === 'company'
```

### Issue: Save button not working
**Solution**: 
- Check if logged in as company
- Check console for AJAX errors
- Verify CSRF token in meta tag

### Issue: Search not returning results
**Solution**: 
- Portfolio might not have matching text
- Check database has portfolio data
- Try different search terms

### Issue: Admin panel not accessible
**Solution**:
- Login with admin account (admin@example.com)
- Check role = 'admin'
- Verify IsAdmin middleware in routes

---

## 📱 Browser Compatibility

- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers

---

## 🚀 Deployment Notes

### Environment Setup
```
.env file needed:
APP_KEY=base64:xxxxx
DB_HOST=localhost
DB_DATABASE=lms_portfolio
DB_USERNAME=root
DB_PASSWORD=
MAIL_MAILER=smtp (if using email)
```

### Before Deploy
```bash
php artisan migrate --force
php artisan db:seed
php artisan optimize
php artisan config:cache
```

### Storage
```
File uploads: storage/app/public
Make sure writable by web server
```

---

## 📚 Documentation Files

- `ADMIN_FEATURES_TESTING.md` - Admin features guide
- `COMPANY_RECRUITER_FEATURES.md` - Company features guide
- `SEARCH_AND_SAVE_FEATURES.md` - Search & save guide

---

## ✅ Checklist Before Production

- [ ] Change APP_KEY in .env
- [ ] Set proper database credentials
- [ ] Configure email (SMTP)
- [ ] Set APP_DEBUG=false
- [ ] Run migrations on production
- [ ] Test all user flows
- [ ] Test admin features
- [ ] Test company features
- [ ] Setup proper SSL/HTTPS
- [ ] Configure file permissions
- [ ] Setup backups
- [ ] Enable rate limiting

---

## 🎓 Pembelajaran

### Model Relationships
- User hasMany Portfolio
- User hasMany Comment
- User hasMany Like
- User hasMany SavedCreator
- Portfolio belongsTo User
- Portfolio hasMany Comment
- Portfolio hasMany Like
- SavedCreator belongsTo Company & Creator

### Authorization
- IsAdmin middleware untuk admin routes
- User type checks (isCreator, isCompany)
- User ID checks untuk own resources

### AJAX
- Like toggle
- Save creator
- Contact forms

---

## 📞 Support

Semua fitur sudah tested dan ready untuk use!

Jika ada pertanyaan, cek documentation files:
- ADMIN_FEATURES_TESTING.md
- COMPANY_RECRUITER_FEATURES.md
- SEARCH_AND_SAVE_FEATURES.md

---

**Happy Testing! 🎉**
