<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Redirect;
use App\Models\usersModel;
use App\Models\myTeamModel;

if (!function_exists('is_mobile')) {

    function is_mobile($type, $url = null, $data = null, $redirect_type = "redirect") {
        if ($type == "API") {
            return json_encode($data);
        } else {
            if ($redirect_type == 'redirect') {
//                return redirect($url)->with(['data' => $data]);
                return redirect()->route($url)->with(['data' => $data]);
//                return redirect()->route( 'clients.show' )->with( [ 'id' => $id ] );
            } else if ($redirect_type == 'route_with_message') {
                return route($url)->with(['data' => $data]);
            } else if ($redirect_type == 'view') {
                return view($url, ['data' => $data]);
            }
        }
    }
}

function updateReverseSize($user_id, $og_user_id)
{
    $data = usersModel::where(['id' => $user_id])->get()->toArray();
    $ogdata = usersModel::where(['id' => $og_user_id])->get()->toArray();
    
    if(count($data) > 0)
    {
        if($data['0']['referral_id'] > 0)
        {
            $getRef = usersModel::where(['chat_id' => $data['0']['referral_id']])->get()->toArray();
            $getSpo = usersModel::where(['chat_id' => $ogdata['0']['referral_id']])->get()->toArray();

            $myTeam = array();
            $myTeam['user_id'] = $getRef['0']['id'];
            $myTeam['team_id'] = $og_user_id;
            $myTeam['sponser_id'] = $getSpo['0']['id'];

            $checkMyTeam = myTeamModel::where($myTeam)->get()->toArray();

                $myTeam['json'] = json_encode($data, true);

                myTeamModel::insert($myTeam);           

                DB::statement("UPDATE users set my_team = (my_team + 1) where id = '".$data['0']['referral_id']."'");




            updateReverseSize($getRef['0']['id'], $og_user_id);
        }
    }
}

?>