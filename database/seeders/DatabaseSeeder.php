<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'geoffroy.riou.pro@gmail.com',
            'password' => bcrypt('secret'),
            'role' => 'admin',
        ]);

        $homePage = Page::make([
            'is_home' => true,
            'published' => true,
            'slug' => 'home',
        ]);
        foreach (config('app.locales', []) as $locale) {
            $homePage->setTranslation('title', $locale, __('Home'));
        }
        $homePage->save();
    }
}
