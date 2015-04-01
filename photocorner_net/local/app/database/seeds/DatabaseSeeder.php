<?php

class DatabaseSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Eloquent::unguard();
        User::create(array(
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'fullname' => 'DjordjeS',
            'email' => 'djordjewebdizajn1@gmail.com',
            'confirmed' => '1',
            'avatar' => 'user',
            'permission' => 'admin',
        ));

        DB::table('sitesettings')
            ->insert(array(
                array('option' => 'siteName', 'value' => 'Fotokutak'),
                array('option' => 'description', 'value' => 'Some Description'),
                array('option' => 'favIcon', 'value' => 'favicon.ico'),
                array('option' => 'tos', 'value' => 'add tos here'),
                array('option' => 'privacy', 'value' => 'add privacy policy here'),
                array('option' => 'faq', 'value' => 'add faq here'),
                array('option' => 'about', 'value' => 'add about us here'),
                array('option' => 'autoApprove', 'value' => '1'),
                array('option' => 'numberOfImagesInGallery', 'value' => '20'),
                array('option' => 'limitPerDay', 'value' => '20'),
                array('option' => 'tagsLimit', 'value' => '5'),
                array('option' => 'allowDownloadOriginal', 'value' => '1'),
                array('option' => 'maxImageSize', 'value' => '10'),
            ));

        DB::table('categories')
            ->insert(array(
                array('name' => 'Uncategorized', 'slug' => 'uncategorized'),
            ));

        // $this->call('UserTableSeeder');
    }

}