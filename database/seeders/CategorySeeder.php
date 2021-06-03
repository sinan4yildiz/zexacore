<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    static $table = 'categories';
    static $translation_table = 'category_translations';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table(static::$table)->truncate();

        Schema::enableForeignKeyConstraints();

        // Categories
        $categories = [
            // Services
            [
                'content_type_id' => 1,
                'translations'    => [
                    'en' => 'Catering',
                    'tr' => 'Catering'
                ],
            ],
            [
                'content_type_id' => 1,
                'translations'    => [
                    'en' => 'Wholesale',
                    'tr' => 'Toptan Satış'
                ],
            ],
            [
                'content_type_id' => 1,
                'translations'    => [
                    'en' => 'Franchise',
                    'tr' => 'Bayilik'
                ],
            ],

            // Products
            [
                'content_type_id' => 2,
                'translations'    => [
                    'en' => 'Vegetables',
                    'tr' => 'Sebzeler'
                ],
                'sub_categories'  => [
                    [
                        'translations' => [
                            'en' => 'Loose Vegetables',
                            'tr' => 'Tane Sebzeler'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Potatoes & Sweet Potatoes',
                            'tr' => 'Patatesler'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Onions & Garlic',
                            'tr' => 'Soğan & Sarımsak'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Carrots & Aubergines',
                            'tr' => 'Havuçlar & Patlıcanlar'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Peppers & Mushrooms',
                            'tr' => 'Biberler & Mantarlar'
                        ],
                    ],
                    [
                        'translations'   => [
                            'en' => 'Green Vegetables',
                            'tr' => 'Yeşil Sebzeler'
                        ],
                        'sub_categories' => [
                            [
                                'translations' => [
                                    'en' => 'Lettuce & Spinach',
                                    'tr' => 'Marul & Ispanak'
                                ],
                            ],
                            [
                                'translations' => [
                                    'en' => 'Sprouts & Cabbage',
                                    'tr' => 'Lahanalar'
                                ],
                            ],
                        ]
                    ],
                ],
            ],
            [
                'content_type_id' => 2,
                'translations'    => [
                    'en' => 'Fruits',
                    'tr' => 'Meyveler'
                ],
                'sub_categories'  => [
                    [
                        'translations' => [
                            'en' => 'Loose Fruit',
                            'tr' => 'Tane Meyveler'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Bananas & Pineapples',
                            'tr' => 'Muzlar & Ananaslar'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Apples & Pears',
                            'tr' => 'Elmalar & Armutlar'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Grapes & Berries',
                            'tr' => 'Üzümler & Dutgiller'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Citrus Fruits',
                            'tr' => 'Turunçgiller'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Exotic Fruits',
                            'tr' => 'Egzotik Meyveler'
                        ],
                    ],
                    [
                        'translations'   => [
                            'en' => 'Others',
                            'tr' => 'Diğerleri'
                        ],
                        'sub_categories' => [
                            [
                                'translations' => [
                                    'en' => 'Plums, Apricots & Avocados',
                                    'tr' => 'Erik, Kayısı & Avokadolar'
                                ],
                            ],
                            [
                                'translations' => [
                                    'en' => 'Dates & Figs',
                                    'tr' => 'Hurmalar & İncirler'
                                ],
                            ],
                        ]
                    ],
                ],
            ],
            [
                'content_type_id' => 2,
                'translations'    => [
                    'en' => 'Bakery',
                    'tr' => 'Fırın'
                ],
                'sub_categories'  => [
                    [
                        'translations' => [
                            'en' => 'Bread',
                            'tr' => 'Ekmek'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Cakes & Tarts',
                            'tr' => 'Kek, Pasta & Turtalar'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Wraps',
                            'tr' => 'Dürümler'
                        ],
                    ],
                ],
            ],
            [
                'content_type_id' => 2,
                'translations'    => [
                    'en' => 'Dairy & Meat',
                    'tr' => 'Et ve Süt Ürünleri'
                ],
                'sub_categories'  => [
                    [
                        'translations' => [
                            'en' => 'Milk & Cheese',
                            'tr' => 'Süt & Peynir'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Butter & Eggs',
                            'tr' => 'Tereyağı & Yumurtalar'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Meat & Chicken',
                            'tr' => 'Et & Tavuk'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Others',
                            'tr' => 'Diğerleri'
                        ],
                    ],
                ],
            ],
            [
                'content_type_id' => 2,
                'translations'    => [
                    'en' => 'Drinks',
                    'tr' => 'İçecekler'
                ],
                'sub_categories'  => [
                    [
                        'translations' => [
                            'en' => 'Soft Drinks & Juices',
                            'tr' => 'Alkolsüz İçecekler ve Meyve Suları'
                        ],
                    ],
                    [
                        'translations' => [
                            'en' => 'Tea & Coffee',
                            'tr' => 'Çay & Kahveler'
                        ],
                    ],
                    [
                        'translations'   => [
                            'en' => 'Alcoholic Drinks',
                            'tr' => 'Alkollü İçecekler'
                        ],
                        'sub_categories' => [
                            [
                                'translations' => [
                                    'en' => 'Beers & Ciders',
                                    'tr' => 'Biralar'
                                ],
                            ],
                            [
                                'translations' => [
                                    'en' => 'Wine & Champagne',
                                    'tr' => 'Şarap & Şampanyalar'
                                ],
                            ],
                            [
                                'translations' => [
                                    'en' => 'Spirits & Liqueurs',
                                    'tr' => 'Viski, Vodka & Likörler'
                                ],
                            ],
                            [
                                'translations' => [
                                    'en' => 'Tonic & Cocktails',
                                    'tr' => 'Tonik & Kokteyller'
                                ],
                            ],
                        ]
                    ],
                    [
                        'translations' => [
                            'en' => 'Others',
                            'tr' => 'Diğerleri'
                        ],
                    ],
                ],
            ],
        ];

        // Insert data
        foreach ($categories as $category) {
            $this->addCategory($category);
        }
    }

    /**
     * Insert categories recursively
     *
     * @return void
     */
    private function addCategory($category, $parent_id = 0)
    {
        // Category
        $category_id = DB::table(static::$table)->insertGetId([
            'parent_id'       => $parent_id,
            'content_type_id' => $category['content_type_id'],
        ]);

        // Translation
        foreach ($category['translations'] as $language_code => $title) {
            DB::table(static::$translation_table)->insert([
                'category_id'   => $category_id,
                'language_code' => $language_code,
                'title'         => $title,
            ]);
        }

        // Sub categories
        if (isset($category['sub_categories'])) {
            foreach ($category['sub_categories'] as $sub_category) {
                $sub_category['content_type_id'] = $category['content_type_id'];
                $this->addCategory($sub_category, $category_id);
            }
        }
    }
}
