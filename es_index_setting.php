<?php

require 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

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

/* index setting */
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