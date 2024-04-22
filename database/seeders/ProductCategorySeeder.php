<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Electronics',
                    'fr' => 'Électronique',
                ],
                'slug' => [
                    'en' => 'electronics',
                    'fr' => 'electronique',
                ],
                'description' => [
                    'en' => 'Explore our wide range of electronic products.',
                    'fr' => 'Découvrez notre large gamme de produits électroniques.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Clothing',
                    'fr' => 'Vêtements',
                ],
                'slug' => [
                    'en' => 'clothing',
                    'fr' => 'vetements',
                ],
                'description' => [
                    'en' => 'Discover the latest trends in fashion.',
                    'fr' => 'Découvrez les dernières tendances de la mode.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Home & Kitchen',
                    'fr' => 'Maison et cuisine',
                ],
                'slug' => [
                    'en' => 'home-kitchen',
                    'fr' => 'maison-cuisine',
                ],
                'description' => [
                    'en' => 'Find everything you need for your home and kitchen.',
                    'fr' => 'Trouvez tout ce dont vous avez besoin pour votre maison et votre cuisine.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Books',
                    'fr' => 'Livres',
                ],
                'slug' => [
                    'en' => 'books',
                    'fr' => 'livres',
                ],
                'description' => [
                    'en' => 'Browse our extensive collection of books.',
                    'fr' => 'Parcourez notre vaste collection de livres.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Beauty & Personal Care',
                    'fr' => 'Beauté et soins personnels',
                ],
                'slug' => [
                    'en' => 'beauty-personal-care',
                    'fr' => 'beaute-soins-personnels',
                ],
                'description' => [
                    'en' => 'Discover a wide range of beauty and personal care products.',
                    'fr' => 'Découvrez une large gamme de produits de beauté et de soins personnels.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Toys & Games',
                    'fr' => 'Jouets et jeux',
                ],
                'slug' => [
                    'en' => 'toys-games',
                    'fr' => 'jouets-jeux',
                ],
                'description' => [
                    'en' => 'Explore our collection of toys and games for all ages.',
                    'fr' => 'Explorez notre collection de jouets et de jeux pour tous les âges.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Sports & Outdoors',
                    'fr' => 'Sports et plein air',
                ],
                'slug' => [
                    'en' => 'sports-outdoors',
                    'fr' => 'sports-plein-air',
                ],
                'description' => [
                    'en' => 'Find sports equipment and outdoor gear for your adventures.',
                    'fr' => 'Trouvez du matériel de sport et des équipements de plein air pour vos aventures.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Health & Wellness',
                    'fr' => 'Santé et bien-être',
                ],
                'slug' => [
                    'en' => 'health-wellness',
                    'fr' => 'sante-bien-etre',
                ],
                'description' => [
                    'en' => 'Discover products to support your health and well-being.',
                    'fr' => 'Découvrez des produits pour soutenir votre santé et votre bien-être.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Automotive',
                    'fr' => 'Automobile',
                ],
                'slug' => [
                    'en' => 'automotive',
                    'fr' => 'automobile',
                ],
                'description' => [
                    'en' => 'Explore automotive parts, accessories, and more.',
                    'fr' => 'Explorez des pièces automobiles, des accessoires et plus encore.',
                ],
            ]
        ];

        foreach ($categories as $category) {
            ProductCategory::updateOrCreate([
                'code' => str()->replace('-', '', strtoupper($category['slug']['en']))
            ], [
                ...collect($category)->except('slug'),
            ]);
        }
    }
}
