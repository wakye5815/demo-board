<?php

use Illuminate\Database\Seeder;
use App\Models\Badge;

class MasterBadgesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Badge::insert([
            [
                'badge_id' => Badge::BADGE_ID['TOP_USER'],
                'name' => 'トップユーザー',
                'description' => 'この掲示板の中で発言回数の一番多いユーザーです。',
                'priority' => 2
            ],
            [
                'badge_id' => Badge::BADGE_ID['ACTIVE_USER'],
                'name' => 'アクティブユーザー',
                'description' => 'この掲示板の中で活発に発言をしているユーザーです。',
                'priority' => 4
            ],
            [
                'badge_id' => Badge::BADGE_ID['POPULAR_USER'],
                'name' =>'人気者', 
                'description' => 'この掲示板のみんなから人気なユーザーです。',
                'priority' => 3
            ],
            [
                'badge_id' => Badge::BADGE_ID['LONELY_USER'],
                'name' => 'ひとりぼっち',
                'description' => 'この掲示板のみんなからあまり相手にしてもらえないユーザーです。',
                'priority' => 1
            ],
            [
                'badge_id' => Badge::BADGE_ID['BEGINNER'],
                'name' => '初心者',
                'description' => 'この掲示板をこれから盛り上げてくれるユーザーです。',
                'priority' => 0
            ]
        ]);
    }
}
