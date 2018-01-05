<?php

namespace App\Http\Controllers;

use App\Favourite;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function store(Request $request)
    {
        $title = 'Recipe Search Result';
        $url = $request->base_url . 'q=' . urlencode(trim($request->q)) . '&app_id=' . $request->app_id . '&app_key=' . $request->app_key . '&from=' . $request->from . '&to=' . $request->to;

        if($request->has('ingr')){
            $url = $url . '&ingr=' . $request->ingr;
        }

        if($request->has('health')){
            $url .= '&health=';
            $i=1;
            foreach ($request->health as $list){
                $url = $url . $list;
                if($i < count($request->health)){
                    $url .= ',';
                }
                $i++;
            }
        }

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_HEADER,0);
        $response = curl_exec($curl);
        $response = json_decode($response,TRUE);

        if(Auth::guard('web')->check()){
            $favourites = Favourite::whereUserId(Auth::guard('web')->user()->id)->pluck('r')->toArray();
        }else{
            $favourites = [];
        }

        return view('private.common.recipe.search',compact('title','response','favourites'));
    }

    public function details(Request $request){
        $base_id = 'http://www.edamam.com/ontologies/';
        $base = explode('http://www.edamam.com/ontologies/',$request->r);
        $r = $base_id . urlencode($base[1]);

        $url = $request->base_url . 'r=' . $r . '&app_id=' . $request->app_id . '&app_key=' . $request->app_key;

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_HEADER,0);
        $response = curl_exec($curl);
        curl_close($curl);
        
        $response = json_decode($response,TRUE);
        $response = $response[0];
        $title = $response['label'];

        /** Suggestion */
        $url = $request->base_url . 'q=' . urlencode($response['label']) . '&app_id=' . $request->app_id . '&app_key=' . $request->app_key . '&from=1&to=3';

        $curl = curl_init();
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($curl,CURLOPT_HEADER,0);
        $suggestion = curl_exec($curl);
        curl_close($curl);
        
        $suggestion = json_decode($suggestion,TRUE);

        if(Auth::guard('web')->check()){
            $favourites = Favourite::whereUserId(Auth::guard('web')->user()->id)->pluck('r')->toArray();
        }else{
            $favourites = [];
        }
        
        return view('private.common.recipe.details',compact('title','response','suggestion','favourites'));
    }
}
