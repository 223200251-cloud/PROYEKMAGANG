<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Portfolio;
use Illuminate\Database\Seeder;

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample users
        $users = [
            [
                'name' => 'Andi Wijaya',
                'email' => 'andi@example.com',
                'username' => 'andiwijaya',
                'password' => bcrypt('password'),
                'role' => 'user',
                'phone' => '+62 812-3456-7890',
                'bio' => 'Full-stack Web Developer dengan pengalaman 5+ tahun. Spesialisasi dalam Laravel dan React.',
                'location' => 'Jakarta, Indonesia',
                'website' => 'https://andiwijaya.dev',
                'avatar_url' => 'https://i.pravatar.cc/300?img=12',
            ],
            [
                'name' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'username' => 'sitinur',
                'password' => bcrypt('password'),
                'role' => 'user',
                'phone' => '+62 821-9876-5432',
                'bio' => 'Mobile App Developer | Flutter Enthusiast | Building beautiful apps for millions of users.',
                'location' => 'Bandung, Indonesia',
                'website' => 'https://sitinur.com',
                'avatar_url' => 'https://i.pravatar.cc/300?img=47',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'username' => 'budisantoso',
                'password' => bcrypt('password'),
                'role' => 'user',
                'phone' => '+62 813-5555-8888',
                'bio' => 'UI/UX Designer passionate about creating intuitive user experiences. Available for freelance projects.',
                'location' => 'Surabaya, Indonesia',
                'avatar_url' => 'https://i.pravatar.cc/300?img=33',
            ],
            [
                'name' => 'Maya Putri',
                'email' => 'maya@example.com',
                'username' => 'mayaputri',
                'password' => bcrypt('password'),
                'role' => 'user',
                'phone' => '+62 856-4321-9876',
                'bio' => 'Backend Developer | API Specialist | Cloud Architecture Enthusiast.',
                'location' => 'Yogyakarta, Indonesia',
                'website' => 'https://mayaputri.tech',
                'avatar_url' => 'https://i.pravatar.cc/300?img=32',
            ],
            [
                'name' => 'Raka Pratama',
                'email' => 'raka@example.com',
                'username' => 'rakapratama',
                'password' => bcrypt('password'),
                'role' => 'user',
                'phone' => '+62 878-1234-5678',
                'bio' => 'DevOps Engineer | Kubernetes & Docker Expert | Open Source Contributor.',
                'location' => 'Bali, Indonesia',
                'avatar_url' => 'https://i.pravatar.cc/300?img=68',
            ],
        ];

        $userIds = [];
        foreach ($users as $user) {
            $userIds[] = User::firstOrCreate(
                ['email' => $user['email']],
                $user
            )->id;
        }

        // Sample portfolios
        $portfolios = [
            [
                'title' => 'Website E-Commerce Modern',
                'description' => 'Platform e-commerce full-stack dengan fitur pembayaran, inventory management, dan admin dashboard yang lengkap.',
                'category' => 'Web Development',
                'image_url' => 'https://images.unsplash.com/photo-1460925895917-adf4e6d993f3?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/ecommerce',
                'technologies' => 'Laravel, React, MySQL, Stripe',
                'views' => 1250,
                'likes_count' => 45,
                'comments_count' => 12,
            ],
            [
                'title' => 'Mobile Banking App',
                'description' => 'Aplikasi mobile banking dengan fitur transfer, pembayaran tagihan, dan investasi yang user-friendly.',
                'category' => 'Mobile Development',
                'image_url' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/banking',
                'technologies' => 'Flutter, Firebase, Provider',
                'views' => 980,
                'likes_count' => 38,
                'comments_count' => 8,
            ],
            [
                'title' => 'UI/UX Design - Travel App',
                'description' => 'Desain lengkap untuk aplikasi travel booking dengan user experience yang intuitif dan modern.',
                'category' => 'UI/UX Design',
                'image_url' => 'https://images.unsplash.com/photo-1581291518857-4e27b48ff24e?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/travelapp',
                'technologies' => 'Figma, Adobe XD, Prototyping',
                'views' => 1560,
                'likes_count' => 62,
                'comments_count' => 15,
            ],
            [
                'title' => 'Content Management System',
                'description' => 'CMS full-featured dengan editor WYSIWYG, multi-user management, dan SEO optimization.',
                'category' => 'Web Development',
                'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/cms',
                'technologies' => 'PHP, Laravel, Vue.js, PostgreSQL',
                'views' => 850,
                'likes_count' => 32,
                'comments_count' => 7,
            ],
            [
                'title' => 'Data Visualization Dashboard',
                'description' => 'Dashboard analytics real-time dengan visualisasi data interaktif untuk business intelligence.',
                'category' => 'Data Science',
                'image_url' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/dashboard',
                'technologies' => 'Python, D3.js, Tableau, SQL',
                'views' => 720,
                'likes_count' => 28,
                'comments_count' => 6,
            ],
            [
                'title' => 'E-Learning Platform',
                'description' => 'Platform pembelajaran online lengkap dengan video streaming, quiz, dan progress tracking.',
                'category' => 'Web Development',
                'image_url' => 'https://images.unsplash.com/photo-1501504905252-473c47e087f8?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/elearning',
                'technologies' => 'Laravel, React, FFmpeg, AWS',
                'views' => 1150,
                'likes_count' => 51,
                'comments_count' => 14,
            ],
            [
                'title' => 'Social Media Clone',
                'description' => 'Aplikasi social media dengan feed, direct messaging, dan notification system real-time.',
                'category' => 'Web Development',
                'image_url' => 'https://images.unsplash.com/photo-1611926653458-09294b3142bf?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/social',
                'technologies' => 'Node.js, Socket.io, MongoDB, React',
                'views' => 1320,
                'likes_count' => 58,
                'comments_count' => 18,
            ],
            [
                'title' => 'Game Development - 2D Platformer',
                'description' => 'Game 2D platformer dengan physics engine, level design, dan multiplayer online functionality.',
                'category' => 'Game Development',
                'image_url' => 'https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/game',
                'technologies' => 'Unity, C#, Photon PUN',
                'views' => 890,
                'likes_count' => 41,
                'comments_count' => 11,
            ],
            [
                'title' => 'AI Image Recognition System',
                'description' => 'Sistem pengenalan gambar menggunakan deep learning untuk deteksi objek dan klassifikasi.',
                'category' => 'Machine Learning',
                'image_url' => 'https://images.unsplash.com/photo-1555255707-c07966088b7b?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/ai',
                'technologies' => 'Python, TensorFlow, OpenCV, FastAPI',
                'views' => 650,
                'likes_count' => 34,
                'comments_count' => 9,
            ],
            [
                'title' => 'Brand Identity Design',
                'description' => 'Desain brand identity lengkap termasuk logo, color palette, typography, dan brand guidelines.',
                'category' => 'Graphic Design',
                'image_url' => 'https://images.unsplash.com/photo-1626785774625-ddcddc3445e9?w=800&h=600&fit=crop',
                'project_url' => 'https://example.com/brand',
                'technologies' => 'Adobe Creative Suite, Illustrator, Photoshop',
                'views' => 520,
                'likes_count' => 25,
                'comments_count' => 5,
            ],
        ];

        // Create portfolios with random users
        foreach ($portfolios as $portfolio) {
            Portfolio::create([
                ...$portfolio,
                'user_id' => $userIds[array_rand($userIds)],
            ]);
        }
    }
}
