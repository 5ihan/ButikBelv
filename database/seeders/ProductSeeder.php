<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name'=>'Kemeja Lengan Panjang polos ',
                'price'=>40000,
                'category_id'=>Category::where('name', 'Kemeja')->first()->id,
                'size'=>'',
                'stok'=>5,
                'desc'=>'Kemeja katun toyobo premium, dengan kualitas bahan yang lembut dan nyaman untuk digunakan diberbagai kegiatan.',
                'img'=>'product-img/prod1.png',
            ],
            [
                'name'=>'Blouse wanita oversize brukat top casual korean style',
                'price'=>60000,
                'category_id'=>Category::where('name', 'Baju')->first()->id,
                'size'=>'',
                'stok'=>5,
                'desc'=>'blouse wanita oversize, bahan cotton line premium dengan kualitas bahan yang lembut , halus dan tidak panas, serta nyaman untuk digunakan. Mudah dipadukan dengan bawahan rok atau pun celana.',
                'img'=>'product-img/prod2.jpg',
            ],
            [
                'name'=>'Celana kulot highwaits wanita rib premium',
                'price'=>80000,
                'category_id'=>Category::where('name', 'Celana')->first()->id,
                'size'=>'',
                'stok'=>5,
                'desc'=>'kulot highwaits, bahan rib premium lembut, tebal, lentur, anti kusut dan menyerap keringet cocok digunakan untuk sehari – hari',
                'img'=>'product-img/prod3.jpg',
            ],
            [
                'name'=>'Celana wanita jeans boyfriend polos',
                'price'=>80000,
                'category_id'=>Category::where('name', 'Celana')->first()->id,
                'size'=>'',
                'stok'=>5,
                'desc'=>'Celana boyfriend, bahan jeans nonstretch, tebal, dan tidak melar',
                'img'=>'product-img/prod4.jpg',
            ],
            [
                'name'=>'Kaos polos cotton combed 24s premium oversize',
                'price'=>80000,
                'category_id'=>Category::where('name', 'Baju')->first()->id,
                'size'=>'',
                'stok'=>5,
                'desc'=>'Kaos polos , bahan cotton bamboo, ketembalan kain 24 s agak tebal & halus, menyerap keringet, tidak lembab dan nyaman untuk digunakan sehari – hari',
                'img'=>'product-img/prod5.jpg',
            ],
            [
                'name'=>'Baju Long dress tunik crinkle airflow wanita ',
                'price'=>80000,
                'category_id'=>Category::where('name', 'Baju')->first()->id,
                'size'=>'',
                'stok'=>5,
                'desc'=>'Baju tunik, bahan crinkle airflow premium. Bahan lembut, adem, tidak mudah kusut, terdapat tali pinggang dan nyaman saat digunakan di berbagai acara',
                'img'=>'product-img/prod6.jpg',
            ],
            [
                'name'=>'Set kebaya modern brokat, kebaya kutubaru & rok plisket',
                'price'=>80000,
                'category_id'=>Category::where('name', 'Baju')->first()->id,
                'size'=>'',
                'stok'=>5,
                'desc'=>'kebaya kutubaru, bahan brokat full puring dengan desain modern yang memberikan kesan elegan. Sudah dilapisi furing, tidak nerawang dan tidak gatal sehingga nyaman untuk digunakan. Cocok untuk acara wisuda, lamaran dan kondangan',
                'img'=>'product-img/prod7.png',
            ],
            [
                'name'=>'Daster Lengan 3/4 Dress Maura Panjang Rayon Premium',
                'price'=>80000,
                'category_id'=>Category::where('name', 'Baju')->first()->id,
                'size'=>'',
                'stok'=>5,
                'desc'=>'Daster Maura, bahan rayon tebal, halus, tidak panas, tidak nerawang dan gambar tidak mudah luntur sehingga nyaman untuk digunakan',
                'img'=>'product-img/prod8.jpg',
            ],
            [
                'name'=>'Seragam Sekolah SD SMP SMA Kemeja Putih Baju Atasan Lengan Pendek Bet Bordir',
                'price'=>80000,
                'category_id'=>Category::where('name', 'Kemeja')->first()->id,
                'size'=>'',
                'stok'=>5,
                'desc'=>'Baju seragam Sekolah SD SMP SMA, Bahan katun Oxford. Nyaman dan adem saat digunakan, tidak nerawang, tidak panas dan terdapat emblem bordir logo sd dan logo bendera merah putih',
                'img'=>'product-img/prod9.jpg',
            ],
        ];

        foreach($products as $product){
            Product::create($product);
        }
    }
}
