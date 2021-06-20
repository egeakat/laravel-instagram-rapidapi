<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class InstagramApiController extends Controller
{
    //

    public function engagementRatio(Request $request){
        $apiResponse = Http::withHeaders(['x-rapidapi-key' => env('X_RAPID_API_KEY'),
        'x-rapidapi-host' => 'instagram28.p.rapidapi.com', "useQueryString"=> true])->get('https://instagram28.p.rapidapi.com/user_info', [
            'user_name' => $request->get('username')
        ]);

        $totalLikes = 0;
        foreach($apiResponse['data']['user']['edge_owner_to_timeline_media']['edges'] as $node){

            $totalLikes += (int)$node['node']['edge_liked_by']['count'];
        }

        return view('instagram.engagement', [
            'engagement_ratio'=> (int)$apiResponse['data']['user']['edge_followed_by'] / $totalLikes,
            'username' => $apiResponse['data']['user']['username']
        ]); 


        
        
    }
}
