<?php
/**
 * Created by IntelliJ IDEA.
 * User: KD
 * Date: 2019-02-01
 * Time: 23:35
 */


use Illuminate\Database\Seeder;


class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // create 10 users using the user factory
        factory(App\User::class, 10)->create();
    }
}