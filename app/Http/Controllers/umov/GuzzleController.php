<?php

namespace base\Http\Controllers\umov;

use base\Model\Umov\Login;
use base\Model\Umov\Activity;
use base\Model\Umov\Umov;
use Illuminate\Http\Request;

use base\Http\Requests;
use base\Http\Controllers\Controller;

use GuzzleHttp;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;


class GuzzleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $login = 'master';
        $enviroment = 'formacionjuan';
        $password = 'micrium2016';
        $client = new Client([
            'base_uri' => env('URL_CALLBACK'),
            ]);
        $tipo_dato = 'form_params';
        $response = $client->request('POST','guz',
                [ $tipo_dato => 
                    ['login' => $login ,
                     'enviroment' => $enviroment ,
                     'password' => $password,
                    ]
                ]);
        $body = $response->getBody();
        return $body;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $token = Umov::getToken('master', 'formacionjuan', 'micrium2016');
        $activities = Umov::getAllDataId($token, "activityHistory");// 53471021
        dd($activities);
        return $activities;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
