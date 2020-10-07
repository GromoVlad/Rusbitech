<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::insert([
            [
                'name'              => 'РБК',
                'rating'            => 4.7,
                'created_at'        => date_create(),
                'updated_at'        => date_create(),
            ],
            [
                'name'              => 'Российская газета',
                'rating'            => 3.8,
                'created_at'        => date_create(),
                'updated_at'        => date_create(),
            ],
            [
                'name'              => 'РИА Новости',
                'rating'            => 4.2,
                'created_at'        => date_create(),
                'updated_at'        => date_create(),
            ],
            [
                'name'              => 'REGNUM',
                'rating'            => 4.5,
                'created_at'        => date_create(),
                'updated_at'        => date_create(),
            ],
            [
                'name'              => 'Ведомости',
                'rating'            => 3.3,
                'created_at'        => date_create(),
                'updated_at'        => date_create(),
            ],
            [
                'name'              => 'Известия',
                'rating'            => 2.9,
                'created_at'        => date_create(),
                'updated_at'        => date_create(),
            ],
            [
                'name'              => 'Лента',
                'rating'            => 5,
                'created_at'        => date_create(),
                'updated_at'        => date_create(),
            ],
            [
                'name'              => 'Вести.РУ',
                'rating'            => 1.1,
                'created_at'        => date_create(),
                'updated_at'        => date_create(),
            ],
            [
                'name'              => 'КоммерсантЪ',
                'rating'            => 2.2,
                'created_at'        => date_create(),
                'updated_at'        => date_create(),
            ],
        ]);
    }
}
