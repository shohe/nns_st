<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $faker = \Faker\Factory::create();

        // UsersTable : cx -> x6 ppl, stylist -> x6ppl
        $salons_info = [
            ['salon_name' => 'HAIR SALON M 川越店', 'salon_address' => '埼玉県川越市脇田町２７−８', 'lat' => 35.909536, 'lng' => 139.481316],
            ['salon_name' => '美容室 WE BE PARSLEY', 'salon_address' => '埼玉県川越市脇田町１０５', 'lat' => 35.908425, 'lng' => 139.482950],
            ['salon_name' => 'salon de craft', 'salon_address' => '埼玉県川越市脇田本町２９−１ トーア川越', 'lat' => 35.908538, 'lng' => 139.479854]
        ];

        for ($i=0; $i < 12; $i++) {
            $user = new \App\Users();
            $user->last_name = $faker->lastName;
            $user->first_name = $faker->firstName;
            $user->email = $faker->unique()->safeEmail;
            $user->password = bcrypt('password');
            $user->charity_id = mt_rand(1, 3);
            $user->image_url = 'https://www.atomix.com.au/media/2015/06/atomix_user31.png';
            if ($i%2) {
                $t = mt_rand(0, 2);
                $user->is_stylist = true;
                $user->salon_name = $salons_info[$t]['salon_name'];
                $user->salon_address = $salons_info[$t]['salon_address'];
                $user->salon_location = $salons_info[$t]['lat'];
                $user->setLocationAttribute(['lat' => $salons_info[$t]['lat'],'lng' => $salons_info[$t]['lng']]);
                $user->status_comment = $faker->text();
            }
            $user->save();
        }

        // CharitiesTable : x3
        $charities_info = [
            ['title' => 'ラブ ウォーク', 'short_detail' => '思い思いのペースで歩いた汗が、ユニセフを通じて開発途上の子ども達に役立てられるユニセフ・ラブウォーク。'],
            ['title' => 'ハンド・イン・ハンド', 'short_detail' => '1979年（国際児童年）に始まったボランティアが市民にユニセフ募金を呼びかけるユニークなキャンペーン。'],
            ['title' => 'チャリティバザー', 'short_detail' => '各地域において、ボランティアグループや団体などがユニセフ支援のチャリティバザーを開催しています。'],
        ];

        for ($i=0; $i < 3; $i++) {
            $charity = new \App\Charities();
            $charity->title = $charities_info[$i]['title'];
            $charity->short_detail = $charities_info[$i]['short_detail'];
            $charity->detail_url = "https://www.unicef.or.jp";
            $charity->thumbnail_url = "https://www.easyjet.com/ejcms/cache/medialibrary/Images/Content/UNICEF/2016/corporate-partners.jpg?h=1964&la=en&w=3724&hash=9CE531BA8E6AA2057BEA740ECBABF07D1A4BCD68";
            $charity->save();
        }

        // ReviewsTable : x6
        for ($i=0; $i < 6; $i++) {
            $review = new \App\Reviews();
            $review->deal_user_id = mt_rand(1, 6)*2; // 1 ~ 12 even numbers => stylists
            $review->write_user_id = mt_rand(1, 6)*2-1; // 1 ~ 12 odd numbers => customers
            $review->evaluate_star = mt_rand(1, 5);
            $review->review = $faker->text();
            $review->save();
        }

        // OffersTable : x6
        for ($i=0; $i < 6; $i++) {
            $offer = new \App\Offers();
            $offer->cx_id = mt_rand(1, 6)*2-1;
            $offer->menu = "カット";
            $offer->price = 4500;
            $offer->date_time = $faker->dateTime();
            $offer->distance_range = mt_rand(1, 5);
            $offer->setLocationAttribute(['lat' => 37.6835528,'lng' => 125.4976681]);
            $offer->hair_type = mt_rand(1, 5);
            $offer->comment = $faker->text();
            $offer->charity_id = mt_rand(1, 3);
            $offer->save();
        }

        // RequestsTable : x6
        for ($i=0; $i < 6; $i++) {
            $request = new \App\Requests();
            $request->offer_id = mt_rand(1, 6);
            $request->stylist_id = mt_rand(1, 6)*2;
            $request->price = 4500;
            $request->comment = $faker->text();
            $request->save();
        }

    }
}
