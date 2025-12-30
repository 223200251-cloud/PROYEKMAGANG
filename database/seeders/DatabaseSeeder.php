<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Only create test user if not exists
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'username' => 'testuser',
                'password' => bcrypt('password'),
            ]
        );

        // Create admin user if not exists
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'username' => 'admin',
            ]
        );

        // Create company/recruiter user if not exists
        User::firstOrCreate(
            ['email' => 'recruiter@example.com'],
            [
                'name' => 'PT Tech Indonesia',
                'password' => bcrypt('password'),
                'role' => 'user',
                'user_type' => 'company',
                'username' => 'pt_tech',
                'company_name' => 'PT Tech Indonesia',
                'company_website' => 'https://pttech.co.id',
                'company_phone' => '+62-812-3456-7890',
                'company_description' => 'Perusahaan teknologi terdepan yang mengembangkan solusi digital inovatif untuk bisnis modern.',
            ]
        );

        // Seed categories
        $categories = [
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Pengembangan website dan aplikasi web',
                'icon' => 'fas fa-laptop-code',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'Pengembangan aplikasi mobile untuk iOS dan Android',
                'icon' => 'fas fa-mobile-alt',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'UI/UX Design',
                'slug' => 'ui-ux-design',
                'description' => 'Desain antarmuka dan pengalaman pengguna',
                'icon' => 'fas fa-palette',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Graphic Design',
                'slug' => 'graphic-design',
                'description' => 'Desain grafis dan visual branding',
                'icon' => 'fas fa-pen-fancy',
                'order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Game Development',
                'slug' => 'game-development',
                'description' => 'Pengembangan game dan interactive media',
                'icon' => 'fas fa-gamepad',
                'order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Analisis data dan business intelligence',
                'icon' => 'fas fa-chart-bar',
                'order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Machine Learning',
                'slug' => 'machine-learning',
                'description' => 'Artificial Intelligence dan Machine Learning',
                'icon' => 'fas fa-brain',
                'order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Video Production',
                'slug' => 'video-production',
                'description' => 'Produksi video dan konten multimedia',
                'icon' => 'fas fa-video',
                'order' => 8,
                'is_active' => true,
            ],
            [
                'name' => '3D Modeling',
                'slug' => '3d-modeling',
                'description' => 'Pemodelan 3D dan animasi',
                'icon' => 'fas fa-cube',
                'order' => 9,
                'is_active' => true,
            ],
            [
                'name' => 'Content Creation',
                'slug' => 'content-creation',
                'description' => 'Pembuatan konten digital dan kreatif',
                'icon' => 'fas fa-feather',
                'order' => 10,
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }

        $this->call(PortfolioSeeder::class);
    }
}
