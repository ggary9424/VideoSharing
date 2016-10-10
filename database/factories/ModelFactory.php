<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

require_once "./vendor/elasticsearch/elasticsearch/src/Elasticsearch/ClientBuilder.php";

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => '$2y$10$VCGqOoyE05bQxTHjPe8rB.NRZl0efPmfyL7MylbbhcAlfuepbkG6m',
        //'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Video::class, function (Faker\Generator $faker) {
    static $id = 1;
    /* your existed videos path array*/
    $videos_path = [
        'ff56159ad3a6658856c6164b085666aa.mp4', 
        '235c246582939260480017b7082ce991.mp4', 
        '5486ce2f9e66baced1da36f8a2118498.mp4'
    ];

    /* get faker time, type is Faker\Provider\DateTime */
    $datetime_obj = $faker->dateTimeBetween($startDate = '-30 days');
    $fake_data = [
        'id' => $id,
        'name' => $faker->word,
        'user_id' => App\Models\User::all()->random()->id,
        'type' => 'video/mp4',
        'path' => $videos_path[rand(0,2)],
        'desc' => $faker->realText($maxNbChars = 500, $indexSize = rand(1,5)),
        'views' => rand(200,200000),
        'created_at' => $datetime_obj->getTimeStamp()
    ];

    try {
        $es_response = null;
        /* set hosts */
        $hosts = [
            'localhost:9200',
        ];
        /* create client */;
        $es_client = Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build();
        $es_params = [
            'index' => 'videosharing_index',
            'type' => 'video',
            'id' => $id,
            'body' => [
                'name' => $fake_data['name'],
                'desc' => $fake_data['desc'],
                'user' => App\Models\User::where('id', $fake_data['user_id'])
                                        -> get()[0]['name'],
                'created_time' => $datetime_obj->format('Y/m/d')
            ]
        ];
        $es_response = $es_client->index($es_params);
        print_r($es_response);
    }
    catch (Exception $e){
        print_r('Caught exception: '.$e->getMessage().PHP_EOL);
    }
    $id += 1;
    return $fake_data;
});
