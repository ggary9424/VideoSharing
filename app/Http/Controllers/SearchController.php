<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Redirect;

class SearchController extends Controller
{
    /* elasticsearch */
    protected $es;

    public function __construct()
    {
        $es = resolve('MyElasticSearch');
        $this->es = $es;
    }

    public function getResult(Request $request) {
        $search_content = $request->input('search_content');
        $search_time_from = $request->input('search_time_from');
        $search_time_to = $request->input('search_time_to');
        $search_user = $request->input('search_user');
        /* if no search_content redirect back */
        if (!$search_content) {
            return Redirect::back();
        }

        /* frontend api */
        $variable_need = ['search_content', 'videos_count', 'videos_data'];

        /* create a document */
        $es_params = [
            'index' => 'videosharing_index',
            'type' => 'video',
            'body' => [
                'query' => [
                    'filtered' => [
                        'query' => [
                            'bool' => [
                                'must' => [
                                    [
                                        'multi_match' => [
                                            'query' => $search_content,
                                            'fields' => ['name^2', 'desc']
                                        ]
                                    ],
                                ]
                            ]
                        ],
                        'filter' => []
                    ]
                ],
                'highlight' => [
                    'order' => 'score',
                    'pre_tags' => ['<strong>'],
                    'post_tags' => ['</strong>'],
                    'fields' => [
                        'name' => [
                            'query' => '$search_content', 
                            'number_of_fragments' => 0
                        ],
                        'desc' => [
                            'query' => '$search_content',
                            'number_of_fragments' => 1, 
                            'fragment_size' => 400
                        ]
                    ]
                ]
            ]
        ];
        /* handle wrong format for time raange */
        try {
            if ($search_time_from && $search_time_to) {
                Carbon::createFromFormat('Y/m/d', $search_time_from);
                Carbon::createFromFormat('Y/m/d', $search_time_to);
                $es_params['body']['query']['filtered']['filter'] = 
                        ['range' => [
                                'created_time' => [
                                    'gte' => trim($search_time_from),
                                    'lte' => trim($search_time_to),
                                ]
                        ]];
            } else if ($search_time_from){
                Carbon::createFromFormat('Y/m/d', $search_time_from);
                $es_params['body']['query']['filtered']['filter'] = 
                        ['range' => [
                                'created_time' => [
                                    'gte' => trim($search_time_from),
                                ]
                        ]];
            }
        } catch (\Exception $e) {
            $msg = 'WRONG  INPUT FORMAT FOR TIME RANGE !';
            return Redirect::back()->with('error_search_format', $msg);
        }
        if ($search_user) {
            array_push($es_params['body']['query']['filtered']['query']['bool']['must'],
                                                        ['match' => ['user' => $search_user]]);
            $es_params['body']['highlight']['fields']['user'] = 
                                    ['query' => '$search_user', 'number_of_fragments' => 0];
        }
        $es_response = $this->es->search($es_params);
        $videos_count = $es_response['hits']['total'];
        $videos_data = $es_response['hits']['hits'];

        return view('search_result', compact($variable_need));
    }
}
