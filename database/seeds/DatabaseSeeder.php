<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::unguard();
        /* delete Elasticsearch index */
        $hosts = [
            'localhost:9200',
        ];
        $client = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        $param = ['index' => 'videosharing_index'];
        try {
            $response = $client->indices()->delete($param);
            print_r($response);
        }
        catch (Exception $e){
            print_r('Caught exception: '.$e->getMessage().PHP_EOL);
        }

        $this->call(UserTableSeeder::class);
        $this->call(VideoTableSeeder::class);

        User::reguard();
    }
}
