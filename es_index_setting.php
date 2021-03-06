<?php

/* The script is used for building the index mapping of elasticsearch,
 * so you need configure the hosts of elasticsearch by yourself. After,
 * I want to integrate this into migration of laravel. So if you have 
 * some advices or want to try this, you can mail to "ggary9424@gmail.com"
 * to have a discussion with me. Thank you so much.
 */

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

/* configure the hosts of elasticsearch here */
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
    print_r('Caught exception: '.$e->getMessage().'\n');
    print_r($response);
}

/* index mapping */
$param = [
    'index' => 'videosharing_index',
    'body' => [
        'settings' => [ 
            'number_of_shards' => 1,
            'number_of_replicas' => 0,
            'analysis' => [ 
                'analyzer' => [
                    'my_icu_analyzer' => [
                        'tokenizer' => 'icu_tokenizer',
                        "filter" => ['icu_normalizer'],
                        "char_filter" => [
                            "icu_normalizer"
                        ]
                    ]
                ]
            ]
        ],
        'mappings' => [ 
            'video' => [  
                'properties' => [
                    'name' => [
                        'type' => 'string',
                        'analyzer' => 'my_icu_analyzer',
                    ],
                    'desc' => [
                        'type' => 'string',
                        'analyzer' => 'my_icu_analyzer'
                    ],
                    'user' => [
                        'type' => 'string',
                        'analyzer' => 'my_icu_analyzer'
                    ],
                    'created_time' =>[
                        'type' => 'date',
                        "format" => "yyyy/mm/dd"
                    ]                                  
                ]
            ]
        ]
    ]
];

try {
    $response = $client->indices()->create($param);
    print_r($response);
}
catch (Exception $e){
    print_r('Caught exception: '.$e->getMessage().'\n');
    print_r($response);
}
?>