<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ContentTypeSeeder extends Seeder
{
    static $table = 'content_types';
    static $translation_table = 'content_type_translations';


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

        // Content types
        DB::table(static::$table)->insert([
            [
                'has_listing' => 1,
                'sort_order'  => 1,
            ],
            [
                'has_listing' => 1,
                'sort_order'  => 2,
            ],
            [
                'has_listing' => 1,
                'sort_order'  => 3,
            ],
            [
                'has_listing' => 1,
                'sort_order'  => 4,
            ],
        ]);

        // Content type translations
        DB::table(static::$translation_table)->insert([
            [
                'content_type_id' => 1,
                'language_code'   => 'en',
                'title'           => 'Services',
                'description'     => "It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English.",
            ],
            [
                'content_type_id' => 1,
                'language_code'   => 'tr',
                'title'           => 'Hizmetler',
                'description'     => "Lorem Ipsum, dizgi ve baskı endüstrisinde kullanılan mıgır metinlerdir. Lorem Ipsum, adı bilinmeyen bir matbaacının bir hurufat numune kitabı oluşturmak üzere bir yazı galerisini alarak karıştırdığı 1500'lerden beri endüstri standardı sahte metinler olarak kullanılmıştır. Beşyüz yıl boyunca varlığını sürdürmekle kalmamış, aynı zamanda pek değişmeden elektronik dizgiye de sıçramıştır. 1960'larda Lorem Ipsum pasajları da içeren Letraset yapraklarının yayınlanması ile ve yakın zamanda Aldus PageMaker gibi Lorem Ipsum sürümleri içeren masaüstü yayıncılık yazılımları ile popüler olmuştur.",
            ],
            [
                'content_type_id' => 2,
                'language_code'   => 'en',
                'title'           => 'Products',
                'description'     => "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.",
            ],
            [
                'content_type_id' => 2,
                'language_code'   => 'tr',
                'title'           => 'Ürünler',
                'description'     => "Yinelenen bir sayfa içeriğinin okuyucunun dikkatini dağıttığı bilinen bir gerçektir. Lorem Ipsum kullanmanın amacı, sürekli 'buraya metin gelecek, buraya metin gelecek' yazmaya kıyasla daha dengeli bir harf dağılımı sağlayarak okunurluğu artırmasıdır.",
            ],
            [
                'content_type_id' => 3,
                'language_code'   => 'en',
                'title'           => 'References',
                'description'     => "There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.",
            ],
            [
                'content_type_id' => 3,
                'language_code'   => 'tr',
                'title'           => 'Referanslar',
                'description'     => "Lorem Ipsum pasajlarının birçok çeşitlemesi vardır. Ancak bunların büyük bir çoğunluğu mizah katılarak veya rastgele sözcükler eklenerek değiştirilmişlerdir. Eğer bir Lorem Ipsum pasajı kullanacaksanız, metin aralarına utandırıcı sözcükler gizlenmediğinden emin olmanız gerekir.",
            ],
            [
                'content_type_id' => 4,
                'language_code'   => 'en',
                'title'           => 'Blog',
                'description'     => "Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source.",
            ],
            [
                'content_type_id' => 4,
                'language_code'   => 'tr',
                'title'           => 'Blog',
                'description'     => "Yaygın inancın tersine, Lorem Ipsum rastgele sözcüklerden oluşmaz. Kökleri M.Ö. 45 tarihinden bu yana klasik Latin edebiyatına kadar uzanan 2000 yıllık bir geçmişi vardır. Virginia'daki Hampden-Sydney College'dan Latince profesörü Richard McClintock, bir Lorem Ipsum pasajında geçen ve anlaşılması en güç sözcüklerden biri olan 'consectetur' sözcüğünün klasik edebiyattaki örneklerini incelediğinde kesin bir kaynağa ulaşmıştır.",
            ],
        ]);
    }
}
