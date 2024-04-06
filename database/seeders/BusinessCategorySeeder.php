<?php

namespace Database\Seeders;

use App\Models\BusinessCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => [
                    'en' => 'Restaurants',
                    'fr' => 'Restaurants',
                ],
                'slug' => [
                    'en' => 'restaurants',
                    'fr' => 'restaurants',
                ],
                'description' => [
                    'en' => 'Explore diverse dining options and culinary experiences.',
                    'fr' => 'Découvrez diverses options de restauration et expériences culinaires.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Cafes',
                    'fr' => 'Cafés',
                ],
                'slug' => [
                    'en' => 'cafes',
                    'fr' => 'cafes',
                ],
                'description' => [
                    'en' => 'Discover cozy cafes offering a variety of beverages and light bites.',
                    'fr' => 'Découvrez des cafés confortables proposant une variété de boissons et de petites bouchées.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Bakeries',
                    'fr' => 'Boulangeries',
                ],
                'slug' => [
                    'en' => 'bakeries',
                    'fr' => 'boulangeries',
                ],
                'description' => [
                    'en' => 'Find freshly baked bread, pastries, and other bakery delights.',
                    'fr' => 'Trouvez du pain frais, des pâtisseries et d\'autres délices de la boulangerie.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Food Trucks',
                    'fr' => 'Camions de nourriture',
                ],
                'slug' => [
                    'en' => 'food-trucks',
                    'fr' => 'camions-nourriture',
                ],
                'description' => [
                    'en' => 'Experience mobile food vendors offering a variety of cuisines on wheels.',
                    'fr' => 'Découvrez des vendeurs de nourriture mobiles proposant une variété de cuisines sur roues.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Grocery Stores',
                    'fr' => 'Épiceries',
                ],
                'slug' => [
                    'en' => 'grocery-stores',
                    'fr' => 'epiceries',
                ],
                'description' => [
                    'en' => 'Find a wide range of food products and household essentials.',
                    'fr' => 'Trouvez une large gamme de produits alimentaires et d\'articles essentiels pour la maison.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Catering Services',
                    'fr' => 'Services de restauration',
                ],
                'slug' => [
                    'en' => 'catering-services',
                    'fr' => 'services-restauration',
                ],
                'description' => [
                    'en' => 'Discover professional catering services for events and special occasions.',
                    'fr' => 'Découvrez des services de restauration professionnels pour les événements et les occasions spéciales.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Ice Cream Parlors',
                    'fr' => 'Salons de crème glacée',
                ],
                'slug' => [
                    'en' => 'ice-cream-parlors',
                    'fr' => 'salons-creme-glacee',
                ],
                'description' => [
                    'en' => 'Indulge in delicious ice cream flavors and frozen treats.',
                    'fr' => 'Dégustez des saveurs de crème glacée délicieuses et des friandises glacées.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Gourmet Food',
                    'fr' => 'Aliments gastronomiques',
                ],
                'slug' => [
                    'en' => 'gourmet-food',
                    'fr' => 'aliments-gastronomiques',
                ],
                'description' => [
                    'en' => 'Explore premium and high-quality gourmet food products.',
                    'fr' => 'Découvrez des produits alimentaires gastronomiques de qualité supérieure.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Food Delivery Services',
                    'fr' => 'Services de livraison de nourriture',
                ],
                'slug' => [
                    'en' => 'food-delivery-services',
                    'fr' => 'services-livraison-nourriture',
                ],
                'description' => [
                    'en' => 'Discover convenient food delivery services for enjoying meals at home or the office.',
                    'fr' => 'Découvrez des services pratiques de livraison de nourriture pour savourer des repas à la maison ou au bureau.',
                ],
            ],
            [
                'name' => [
                    'en' => 'Organic Food',
                    'fr' => 'Aliments biologiques',
                ],
                'slug' => [
                    'en' => 'organic-food',
                    'fr' => 'aliments-biologiques',
                ],
                'description' => [
                    'en' => 'Explore organic and natural food products for a healthier lifestyle.',
                    'fr' => 'Découvrez des produits alimentaires biologiques et naturels pour un mode de vie plus sain.',
                ],
            ],
        ];

        foreach ($categories as $category) {
            BusinessCategory::updateOrCreate([
                'code' => str()->replace('-', '', strtoupper($category['slug']['en']))
            ], [
                ...collect($category)->except('slug')
            ]);
        }
    }
}
