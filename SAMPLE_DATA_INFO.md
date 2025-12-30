# Informasi Data Sample Portfolio

Database telah diisi dengan data sample untuk testing fitur portfolio. Berikut adalah detailnya:

## User Sample

### Pengguna Individual (Creator):
1. **Andi Wijaya** (andi@example.com)
   - Username: andiwijaya
   - Role: User
   - Bio: Full-stack Web Developer dengan pengalaman 5+ tahun. Spesialisasi dalam Laravel dan React.
   - Location: Jakarta, Indonesia
   - Portfolio: Web Development projects

2. **Siti Nurhaliza** (siti@example.com)
   - Username: sitinur
   - Role: User
   - Bio: Mobile App Developer | Flutter Enthusiast | Building beautiful apps for millions of users.
   - Location: Bandung, Indonesia
   - Portfolio: Mobile Development projects

3. **Budi Santoso** (budi@example.com)
   - Username: budisantoso
   - Role: User
   - Bio: UI/UX Designer passionate about creating intuitive user experiences. Available for freelance projects.
   - Location: Surabaya, Indonesia
   - Portfolio: UI/UX Design projects

4. **Maya Putri** (maya@example.com)
   - Username: mayaputri
   - Role: User
   - Bio: Backend Developer | API Specialist | Cloud Architecture Enthusiast.
   - Location: Yogyakarta, Indonesia
   - Portfolio: Backend & API projects

5. **Raka Pratama** (raka@example.com)
   - Username: rakapratama
   - Role: User
   - Bio: DevOps Engineer | Kubernetes & Docker Expert | Open Source Contributor.
   - Location: Bali, Indonesia
   - Portfolio: DevOps & Infrastructure projects

### Pengguna System:
- **Admin** (admin@example.com)
  - Username: admin
  - Role: Admin
  - Password: password

- **Test User** (test@example.com)
  - Username: testuser
  - Role: User
  - Password: password

- **PT Tech Indonesia** (recruiter@example.com)
  - Username: pt_tech
  - Role: User
  - User Type: Company
  - Password: password

## Portfolio Sample

Total 10 portfolio projects dengan berbagai kategori:

1. **Website E-Commerce Modern** - Web Development
   - Views: 1,250 | Likes: 45 | Comments: 12
   - Technologies: Laravel, React, MySQL, Stripe

2. **Mobile Banking App** - Mobile Development
   - Views: 980 | Likes: 38 | Comments: 8
   - Technologies: Flutter, Firebase, Provider

3. **UI/UX Design - Travel App** - UI/UX Design
   - Views: 1,560 | Likes: 62 | Comments: 15
   - Technologies: Figma, Adobe XD, Prototyping

4. **Content Management System** - Web Development
   - Views: 850 | Likes: 32 | Comments: 7
   - Technologies: PHP, Laravel, Vue.js, PostgreSQL

5. **Data Visualization Dashboard** - Data Science
   - Views: 720 | Likes: 28 | Comments: 6
   - Technologies: Python, D3.js, Tableau, SQL

6. **E-Learning Platform** - Web Development
   - Views: 1,150 | Likes: 51 | Comments: 14
   - Technologies: Laravel, React, FFmpeg, AWS

7. **Social Media Clone** - Web Development
   - Views: 1,320 | Likes: 58 | Comments: 18
   - Technologies: Node.js, Socket.io, MongoDB, React

8. **Game Development - 2D Platformer** - Game Development
   - Views: 890 | Likes: 41 | Comments: 11
   - Technologies: Unity, C#, Photon PUN

9. **AI Image Recognition System** - Machine Learning
   - Views: 650 | Likes: 34 | Comments: 9
   - Technologies: Python, TensorFlow, OpenCV, FastAPI

10. **Brand Identity Design** - Graphic Design
    - Views: 520 | Likes: 25 | Comments: 5
    - Technologies: Adobe Creative Suite, Illustrator, Photoshop

## Categories

10 kategori portfolio telah dibuat:
- Web Development
- Mobile Development
- UI/UX Design
- Graphic Design
- Game Development
- Data Science
- Machine Learning
- Video Production
- 3D Modeling
- Content Creation

## Cara Testing

### Login & Test
- Gunakan email pengguna di atas dengan password: **password**
- Setiap user memiliki portfolio projects yang berbeda
- Test fitur seperti:
  - Lihat detail portfolio orang lain
  - Like/Unlike portfolio
  - Komentar di portfolio
  - Save creator
  - Search portfolio by category
  - Filter by technology/category

### Catatan
- Semua data adalah sample/demo
- Password untuk semua user: `password`
- Silakan delete atau modify data sesuai kebutuhan testing
- Database dapat di-reset dengan: `php artisan migrate:fresh --seed`
