<?php

namespace App\Http\Controllers;

use App\Models\checkInRewardModel;
use App\Models\comboModel;
use App\Models\cipherModel;
use App\Models\adminModel;
use App\Models\earnModel;
use App\Models\userLevelsModel;
use App\Models\usersModel;
use App\Models\categoryModel;
use App\Models\levelsModel;
use App\Models\cardsModel;
use App\Models\myTeamModel;
use App\Models\userExchangeModel;
use App\Models\winnerModel;
use App\Models\tasksModel;
use App\Models\afiliateTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function App\Helpers\is_mobile;
use function App\Helpers\updateReverseSize;

class loginController extends Controller
{
    public function login(Request $request)
    {
        $type = $request->input('type');
        $email = $request->input('email');
        $password = $request->input('password');

        $data = adminModel::where(['email' => $email, 'password' => md5($password)])->get()->toArray();

        if(count($data) == 1){
            $res['status_code'] = 1;
            $res['message'] = "Login successfully";

            $request->session()->put('user_id', $data['0']['id']);        
            $request->session()->put('email', $data['0']['email']);
            $request->session()->put('name', $data['0']['name']);

            return is_mobile($type, "dashboard", $res);
        }else{
            $res['status_code'] = 0;
            $res['message'] = "Email and Password Does Not Match.";

            return is_mobile($type, "index", $res);
        }
    }

    public function logout(Request $request) {
        //logout user
        $request->session()->flush();
        // redirect to homepage
        return redirect()->route('index');
    }

    public function dashboard(Request $request) {
        $type = $request->input('type');
        $user_id = $request->session()->get('user_id');
        $user= usersModel::count();
        $cipher = cipherModel::where(['date' => date('Y-m-d')])->first();
        if($cipher==null){
            $lastCipher = cipherModel::orderBy('date', 'desc')->first();
            if ($lastCipher) {
                $cipher= new cipherModel;
                $cipher->cipher_code=$lastCipher->cipher_code;
                $cipher->date=date('Y-m-d');
                $cipher->amount=$lastCipher->amount;
                $cipher->status=$lastCipher->status;
                $cipher->save();
            }
        }
        $res['cipher']=$cipher;
        $res['user_count']=$user;
        $res['status_code'] = 1;
        $res['message'] = "Login successfully";
        
        return is_mobile($type, "index", $res, "view");
    }

    public function userDetails(Request $request) {
        $type = "API";
        $sponsor = $request->input('sponsor');
        $username = $request->input('username');
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $email = $request->input('email');
        $password = $request->input('password');
        $id = $request->input('id');
        $authtype = $request->input('type');
        $level_id = $request->input('level_id');

        if($id == "undefined" || $id == null)
        {
            $res['status_code'] = 0;
            $res['message'] = "Parameter Missing.";

            return is_mobile($type, "dashboard", $res);
        }

        if(empty($id))
        {
            $res['status_code'] = 0;
            $res['message'] = "Parameter Missing.";

            return is_mobile($type, "dashboard", $res);
        }

        if(!empty($level_id))
        {
            if ($level_id === "DanyWoof") {
                $level_id = 1;
            } else if ($level_id === "TyWagster") {
                $level_id = 2;
            } else if ($level_id === "AryaBark") {
                $level_id = 3;
            } else if ($level_id === "JonSnowdog") {
                $level_id = 4;
            } else if ($level_id === "DaenerysBarkgaryen") {
                $level_id = 1;
            } else if ($level_id === "TyrionLickister") {
                $level_id = 2;
            }
        }

        if(!empty($password) && $password != "undefined")
        {
            $checkUsername = usersModel::where(['chat_id' => $id, 'password' => md5($password)])->get()->toArray();

            $checkUserExist = usersModel::where(['chat_id' => $id])->get()->toArray();

            if(count($checkUsername) == 0 && count($checkUserExist) > 0)
            {
                $res['status_code'] = 0;
                $res['message'] = "Invalid Creds";

                return is_mobile($type, "dashboard", $res);
            }
        }else
        {
            $checkUsername = usersModel::where(['chat_id' => $id])->get()->toArray();

            if($authtype == "auth")
            {
                if(!empty($checkUsername['0']['password']))
                {
                    $res['status_code'] = 0;
                    $res['message'] = "Please enter password.";

                    return is_mobile($type, "dashboard", $res);
                }
            }
        }

        if(count($checkUsername) == 0 && $authtype != "auth")
        {
            if($sponsor == "undefined")
            {
                $sponsor = NULL;
            }
            if($lastName == "undefined")
            {
                $lastName = NULL;
            }
            if($password == "undefined")
            {
                $password = NULL;
            }
            $user = array();
            $user['name'] = $firstName." ".$lastName;
            $user['chat_id'] = $id;
            $user['telegram_username'] = $username  == '' ? $id : $username;
            $user['coin'] = 0;
            $user['pph'] = 0;
            $user['email'] = $email;
            if(!empty($password))
            {
                $user['password'] = md5($password);
            }
            $user['referral_id'] = $sponsor;
            $user['level_id'] = $level_id;
            $user['character'] = $level_id;
            $user['clan_id'] = 0;
            $user['status'] = 1;

            usersModel::insert($user);
            
            $user_id = DB::getPdo()->lastInsertId();

            updateReverseSize($user_id, $user_id);

            usersModel::where(['id' => $user_id])->update(['isCount' => 1]);

            if($sponsor != NULL)
            {
                DB::statement("UPDATE users set my_direct = (my_direct + 1),coin=(coin+5000) where chat_id = '".$sponsor."'");

                $earnLog = array();
                $earnLog['user_id'] = $sponsor;
                $earnLog['amount'] = 5000;
                $earnLog['tag'] = "FRIEND";
                $earnLog['refrence_id'] = $id;
                $earnLog['status'] = 0;
                $earnLog['date'] = date('Y-m-d');

                earnModel::insert($earnLog);
            }
        }

        $data = usersModel::where(['chat_id' => $id])->get()->toArray();
        $category = categoryModel::where(['status' => 1])->get()->toArray();
        $userLevels = userLevelsModel::where(['user_id' => $id])->get()->toArray();

        $friends = usersModel::selectRaw('IFNULL(count(id),0) as ref')->where(['referral_id' => $id])->get()->toArray();
        $getConditionCards = DB::select("SELECT *, COUNT(level_id) as ref FROM `user_levels` where user_id = $id GROUP by card_id");

        $getConditionCards = array_map(function ($value) {
            return (array) $value;
        }, $getConditionCards);

        $conditonMatch = array();
        $conditionName = array();

        $conditonMatch['0'] = $friends['0']['ref'];
        $conditionName['0'] = "Refer";

        $conditonMatch['-1'] = 0;
        $conditionName['-1'] = "You Own This Card";

        foreach($getConditionCards as $key => $value)
        {
            $conditonMatch[$value['card_id']] = $value['ref'];
        }

        $makeQuery = '';

        foreach($userLevels as $key => $value)
        {
            $makeQuery .= $value['level_id']." ,";
        }

        $makeQuery = rtrim($makeQuery, ",");

        $getCards = cardsModel::where(['status' => 1])->get()->toArray();

        foreach($getCards as $kc => $vc)
        {
            $conditionName[$vc['id']] = $vc['title'];
        }

        foreach($category as $key => $value)
        {
            $cards = cardsModel::where(['status' => 1, 'category_id' => $value['id']])->get()->toArray();

            foreach($cards as $k => $v)
            {
                if($makeQuery != '')
                {
                    $levels = levelsModel::where(['status' => 1, 'card_id' => $v['id']])->whereRaw("id not in (".$makeQuery.")")->get()->toArray();
                }else
                {
                    $levels = levelsModel::where(['status' => 1, 'card_id' => $v['id']])->get()->toArray();
                }

                if(count($levels) == 0)
                {
                    $levels = levelsModel::where(['status' => 1, 'card_id' => $v['id']])->get()->toArray();

                    foreach($levels as $levK => $levV)
                    {
                        $levels[$levK]['condition_id'] = "-1";
                    }

                    $cards[$k]['levels'] = $levels;
                }else
                {
                    $cards[$k]['levels'] = $levels;
                }
            }

            foreach($cards as $k => $v)
            {
                foreach($v['levels'] as $l => $p)
                {
                    if($p['condition_id'] != "NULL")
                    {
                        if(isset($conditonMatch[$p['condition_id']]))
                        {
                            if($conditonMatch[$p['condition_id']] >= $p['open'])
                            {
                                $cards[$k]['levels'][$l]['locked'] = 0;
                                $cards[$k]['levels'][$l]['locked_remarks'] = "";
                            }else
                            {
                                $cards[$k]['levels'][$l]['locked'] = 1;
                                if($p['condition_id'] == 0)
                                {
                                    $cards[$k]['levels'][$l]['locked_remarks'] = $conditionName[$p['condition_id']] . " " . $p['open'] . " Friends";
                                }else if($p['condition_id'] == "-1")
                                {
                                    // $cards[$k]['levels'][$l]['locked'] = 0;
                                    $cards[$k]['levels'][$l]['locked_remarks'] = $conditionName[$p['condition_id']];
                                }else
                                {
                                    $cards[$k]['levels'][$l]['locked_remarks'] = $conditionName[$p['condition_id']] . " Lvl " . $p['open'];
                                }
                            }
                        }else
                        {
                            $cards[$k]['levels'][$l]['locked'] = 1;
                            if($p['condition_id'] == 0)
                            {
                                $cards[$k]['levels'][$l]['locked_remarks'] = $conditionName[$p['condition_id']] . " " . $p['open'] . " Friends";
                            }else if($p['condition_id'] == "-1")
                            {
                                // $cards[$k]['levels'][$l]['locked'] = 0;
                                $cards[$k]['levels'][$l]['locked_remarks'] = $conditionName[$p['condition_id']];
                            }else
                            {
                                $cards[$k]['levels'][$l]['locked_remarks'] = $conditionName[$p['condition_id']] . " Lvl " . $p['open'];
                            }
                        }
                    }else
                    {
                        $cards[$k]['levels'][$l]['locked'] = 0;
                        $cards[$k]['levels'][$l]['locked_remarks'] = "";
                    }
                }
            }

            $category[$key]['cards'] = $cards;
        }

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data['0'];
        $res['category'] = $category;

        $checkExist = earnModel::where(['refrence_id' => "0", 'tag' => "CHECK-IN", 'date' => date('Y-m-d'), 'user_id' => $id])->get()->toArray();
        $dayCheckIn = earnModel::where(['refrence_id' => "0", 'tag' => "CHECK-IN", 'user_id' => $id])->orderBy('date','DESC')->get()->toArray();

        $continuous = [];
        $expectedDate = date('Y-m-d', strtotime('-1 day'));

        foreach ($dayCheckIn as $check) {
            if ($check['date'] == $expectedDate) {
                $continuous[] = $check;
                $expectedDate = date('Y-m-d', strtotime($expectedDate . ' -1 day'));
            } else {
                break;
            }
        }

        $dayCheckIn = $continuous;
        // ----------------------

        $lastDate = $dayCheckIn[0]['date'] ?? null;
        $yesterday = date('Y-m-d', strtotime('-1 day'));

        if ($lastDate !== date('Y-m-d') && $lastDate !== $yesterday) {
            $nextDay = 1;
        } else {
            $nextDay = count($dayCheckIn) + 1;
        }

        /*  
        |-----------------------------------------|
        |  FIX: Week reset when 1 day is skipped  |
        |-----------------------------------------|
        */
        if ($nextDay == 1) {

            // total check-ins ever done
            $totalCheckIns = earnModel::where([
                'refrence_id' => "0",
                'tag' => "CHECK-IN",
                'user_id' => $id
            ])->count();

            // completed full weeks (each week = 7 days)
            $previousWeeks = floor($totalCheckIns / 7);

            // so, new week = previous + 1
            $currentWeek = $previousWeeks + 1;

        } else {
            // normal week calculation
            $currentWeek = ceil($nextDay / 7);
        }


        if(count($checkExist) > 0) {
            $res['showCheckIn'] = 0;
            $res['checkInDay'] = $nextDay;
        } else {
            if($authtype != "auth") {
                $res['showCheckIn'] = 1;
                $res['checkInDay'] = $nextDay;
            }else
            {
                $res['showCheckIn'] = 0;
                $res['checkInDay'] = $nextDay;
            }
        }


        // Calculate the day of the week (1 to 7, assuming 1 is Monday)
        $dayOfWeek = $res['checkInDay'] % 7;
        if ($dayOfWeek == 0) {
            $dayOfWeek = 7; // If divisible by 7, it's Sunday (7th day)
        }

        $res['checkInDay'] = $dayOfWeek;
        $res['currentWeek'] = $currentWeek;

        $res['coinUpdate'] = $data['0']['coinUpdate'];

        return is_mobile($type, "dashboard", $res);

    }

    public function pphUpdate(Request $request)
    {
        $type = "API";
        $pph = $request->input('pph');
        $id = $request->input('id');

        $checkUsername = usersModel::where(['chat_id' => $id])->get()->toArray();

        if(count($checkUsername) > 0)
        {
            usersModel::where(['chat_id' => $id])->update(['pph' => $pph]);

            $res['status_code'] = 1;
            $res['message'] = "Success";
        }else
        {
            $res['status_code'] = 0;
            $res['message'] = "No user found";
        }

        return is_mobile($type, "dashboard", $res);
    }

    public function coinUpdate(Request $request)
    {
        $type = "API";
        $coin = $request->input('coin');
        $level_id = $character = $request->input('level_id');
        $id = $request->input('id');
        $wallet_address = $request->input('wallet_address');
        

        $checkUsername = usersModel::where(['chat_id' => $id])->get()->toArray();

        if(count($checkUsername) > 0)
        {
            if ($level_id === "DanyWoof") {
                $level_id = 1;
            } else if ($level_id === "TyWagster") {
                $level_id = 2;
            } else if ($level_id === "AryaBark") {
                $level_id = 3;
            } else if ($level_id === "JonSnowdog") {
                $level_id = 4;
            } else if ($level_id === "DaenerysBarkgaryen") {
                $level_id = 1;
            } else if ($level_id === "TyrionLickister") {
                $level_id = 2;
            }
            
            if(!empty($level_id))
            {
                usersModel::where(['chat_id' => $id])->update(['level_id' => $level_id, 'character' => $character]);
            }

            if(!empty($wallet_address))
            {
                if(empty($checkUsername['0']['wallet_address']))
                {
                    usersModel::where(['chat_id' => $id])->update(['wallet_address' => $wallet_address]);
                }
            }
            
            usersModel::where(['chat_id' => $id])->update(['coin' => $coin, 'coinUpdate' => "0"]);

            $res['status_code'] = 1;
            $res['message'] = "Success";
        }else
        {
            $res['status_code'] = 0;
            $res['message'] = "No user found";
        }

        return is_mobile($type, "dashboard", $res);
    }

    public function fetchFriends(Request $request)
    {
        $type = "API";
        $id = $request->input('id');
        
        $getUserId = usersModel::where(['chat_id' => $id])->get()->toArray();

        $friends = usersModel::where(['referral_id' => $id])->get()->toArray();

        $team = myTeamModel::selectRaw('users.*')->join('users','users.id','=','my_team.team_id')->where(['user_id' => $getUserId['0']['id']])->orderBy('my_team.id', 'desc')->get()->toArray();

        $updateBalance = 0;

        $getFriendEarn = earnModel::where(['tag' => "FRIEND", 'user_id' => $id])->get()->toArray();

        foreach($getFriendEarn as $key => $value)
        {
            if($value['status'] == 0)
            {
                $updateBalance = $updateBalance + $value['amount'];

                // earnModel::where(['id' => $value['id']])->update(['status' => 1]);
            }
        }

        if(count($friends) > 0)
        {
            $res['status_code'] = 1;
            $res['message'] = "Success";
            $res['friends'] = $friends;
            $res['team'] = $team;
            $res['friendAmount'] = $updateBalance;
        }else
        {
            $res['status_code'] = 0;
            $res['message'] = "No friends found";
        }

        return is_mobile($type, "dashboard", $res);
    }

    public function fetchTasks(Request $request)
    {
        $type = "API";
        $id = $request->input('id');

        $tasks = tasksModel::where(['status' => 1])->get()->toArray();

        if(empty($id))
        {
            foreach($tasks as $key => $value)
            {
                $tasks[$key]['status'] = 0;
            }
        }else
        {
            foreach($tasks as $key => $value)
            {
                $checkExist = earnModel::where(['refrence_id' => $value['id'], 'tag' => "TASK", 'user_id' => $id])->get()->toArray();

                if(count($checkExist) > 0)
                {
                    $tasks[$key]['status'] = 1;
                }else
                {
                    $tasks[$key]['status'] = 0;
                }
            }

        }

        if(count($tasks) > 0)
        {
            $res['status_code'] = 1;
            $res['message'] = "Success";
            $res['tasks'] = $tasks;
        }else
        {
            $res['status_code'] = 0;
            $res['message'] = "No tasks found";
        }

        return is_mobile($type, "dashboard", $res);
    }

    public function insertEarnLog(Request $request)
    {
        $type = "API";
        $id = $request->input('id');
        $tag = $request->input('tag');
        $amount = $request->input('amount');
        $refrence_id = $request->input('refrence_id');

        if(empty($id))
        {
            $res['status_code'] = 0;
            $res['message'] = "Parameter Missing.";

            return is_mobile($type, "dashboard", $res);
        }
        if($tag == "CHECK-IN")
        {
            $checkExist = earnModel::where(['refrence_id' => $refrence_id, 'tag' => $tag, 'date' => date('Y-m-d'), 'user_id' => $id])->get()->toArray();
        }else
        {
            $checkExist = earnModel::where(['refrence_id' => $refrence_id, 'tag' => $tag, 'user_id' => $id, 'date' => date('Y-m-d')])->get()->toArray();
        }

        if(count($checkExist) == 0)
        {
            if($tag == "TASK" && ($refrence_id == 7 || $refrence_id == 8))
            {
                // Telegram Bot Token
                $botToken = '8172625290:AAGIDqNWqtCzhQjpI8L-HuoA-Ojwqr5VprI'; // Replace with your bot token
                $apiUrl = "https://api.telegram.org/bot$botToken/getChatMember";
                if($refrence_id == 7)
                {
                    $chatId = "@dexorainc";
                }else
                {
                    $chatId = "@dexoraclan";
                }

                // API URL with parameters
                // $url = "$apiUrl?chat_id=$chatId&user_id=$id";

                $params = [
    'chat_id' => $chatId,
    'user_id' => $id,
];
$url = $apiUrl . "?" . http_build_query($params);



                // Send a GET request to Telegram API
                $response = file_get_contents($url);

                // Decode the JSON response
                $responseData = json_decode($response, true);

                if(isset($responseData['ok']))
                {
                    if ($responseData['result']['status'] == "left" || $responseData['result']['status'] == "kicked") {
                        $res['status_code'] = 0;
                        $res['message'] = "Task Not Completed.";
                    }else
                    {
                        $earnLog = array();
                        $earnLog['user_id'] = $id;
                        $earnLog['amount'] = $amount;
                        $earnLog['tag'] = $tag;
                        $earnLog['refrence_id'] = $refrence_id;
                        $earnLog['date'] = date('Y-m-d');

                        earnModel::insert($earnLog);

                        $res['status_code'] = 1;
                        $res['message'] = "logged successfully.";
                    }

                }else
                {
                    $res['status_code'] = 0;
                    $res['message'] = "Task Not Completed.";
                }
            }else
            {
                $earnLog = array();
                $earnLog['user_id'] = $id;
                $earnLog['amount'] = $amount;
                $earnLog['tag'] = $tag;
                $earnLog['refrence_id'] = $refrence_id;
                $earnLog['date'] = date('Y-m-d');

                earnModel::insert($earnLog);

                $res['status_code'] = 1;
                $res['message'] = "logged successfully.";
            }
            
        }else
        {
            $res['status_code'] = 0;
            $res['message'] = "Already Logged.";
        }
        return is_mobile($type, "dashboard", $res);
    }

    public function mineCard(Request $request)
    {
        $type = "API";
        $id = $request->input('id');
        $level_id = $request->input('level_id');

        if(empty($id) && empty($level_id))
        {
            $res['status_code'] = 0;
            $res['message'] = "Parameter Missing.";

            return is_mobile($type, "dashboard", $res);
        }
        
        $checkExist = userLevelsModel::where(['level_id' => $level_id, 'user_id' => $id])->get()->toArray();

        if(count($checkExist) == 0)
        {
            $getLevel = levelsModel::where(['id' => $level_id])->get()->toArray();

            $category_id = $getLevel['0']['category_id'];
            $card_id = $getLevel['0']['card_id'];
            $pph = $getLevel['0']['income'];

            $levelLog = array();
            $levelLog['user_id'] = $id;
            $levelLog['category_id'] = $category_id;
            $levelLog['card_id'] = $card_id;
            $levelLog['level_id'] = $level_id;
            $levelLog['created_on'] = date('Y-m-d H:i:s');

            userLevelsModel::insert($levelLog);

            DB::statement("UPDATE users set pph = (IFNULL(pph,0) + ($pph)) where chat_id = '".$id."'");

            $res['status_code'] = 1;
            $res['message'] = "logged successfully.";
        }else
        {
            $res['status_code'] = 0;
            $res['message'] = "Already Logged.";
        }

        return is_mobile($type, "dashboard", $res);
    }

    public function checkInReward(Request $request)
    {
        $type = "API";

        $dailyRewards = checkInRewardModel::where(['status' => 1])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['dailyRewards'] = $dailyRewards;

        return is_mobile($type, "dashboard", $res);
    }

    public function getCipher(Request $request)
    {
        $type = "API";

        $cipher = cipherModel::where(['status' => 1, 'date' => date('Y-m-d')])->orderBy('id', 'desc')->get()->toArray();
        if($cipher){
            $res['cipher'] = $cipher['0'];
        }else{
            $cipher = cipherModel::where(['status' => 1])->orderBy('date', 'desc')->get()->toArray();

            $res['cipher'] = $cipher['0'];
        }
        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['cipher'] = $cipher['0'];

        return is_mobile($type, "dashboard", $res);
    }

    public function getCombo(Request $request)
    {
        $type = "API";

        $combo = comboModel::where(['status' => 1, 'date' => date('Y-m-d')])->orderBy('id', 'desc')->get()->toArray();

        if ($combo) {
            $cards = array($combo['0']['card_1'],$combo['0']['card_2'],$combo['0']['card_3']);
    
            $todayCards = cardsModel::whereRaw("id in (".implode(",", $cards).")")->get()->toArray();
            # code...
            $res['combo'] = $combo['0'];
            $res['todayCards'] = $todayCards;
        }else{
            $combo = comboModel::where(['status' => 1])->orderBy('date', 'desc')->get()->toArray();
            $cards = array($combo['0']['card_1'],$combo['0']['card_2'],$combo['0']['card_3']);
    
            $todayCards = cardsModel::whereRaw("id in (".implode(",", $cards).")")->get()->toArray();
            # code...
            $res['combo'] = $combo['0'];
            $res['todayCards'] = $todayCards;
        }


        $res['status_code'] = 1;
        $res['message'] = "Success";
        // $res['combo'] = $combo['0'];
        // $res['todayCards'] = $todayCards;

        return is_mobile($type, "dashboard", $res);
    }

    public function dailyTasks(Request $request)
    {
        $type = "API";
        $id = $request->input('id');

        $dailyReward = earnModel::where(['tag' => 'CHECK-IN', 'user_id' => $id, 'date' => date('Y-m-d')])->orderBy('id', 'desc')->get()->toArray();
        $dailyCombo = earnModel::where(['tag' => 'COMBO', 'user_id' => $id, 'date' => date('Y-m-d')])->orderBy('id', 'desc')->get()->toArray();
        $dailyCipher = earnModel::where(['tag' => 'CIPHER', 'user_id' => $id, 'date' => date('Y-m-d')])->orderBy('id', 'desc')->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['reward'] = count($dailyReward);
        $res['combo'] = count($dailyCombo);
        $res['cipher'] = count($dailyCipher);

        return is_mobile($type, "dashboard", $res);
    }

    public function clanLeadership(Request $request)
    {
        $type = "API";
        $id = $request->input('id');

        $clanLevels = array(1,2,3,4);
        $data = array();
        foreach($clanLevels as $k => $v)
        {
            $userData = array();
            $friendsData = array();
            $getLevelData = usersModel::where(['level_id' => $v])->orderBy('coin', 'desc')->take(100)->get()->toArray();
            $getFriendsData = usersModel::selectRaw("id, name, coin, (select count(id) from my_team where user_id = users.id) as my_direct")->where(['level_id' => $v])->whereRaw("my_direct > 0")->orderBy('my_direct', 'desc')->take(100)->get()->toArray();

            $j=1;
            foreach($getLevelData as $kl => $vl)
            {
                $userData[$vl['id']] = $vl;
                $userData[$vl['id']]['rank'] = $j;
                $j++;
            }

            foreach($getFriendsData as $kl => $vl)
            {
                $j=1;
                $friendsData[$vl['id']] = $vl;
                $friendsData[$vl['id']]['rank'] = $j;
                $j++;
            }

            $data[$v]['coin'] = $getLevelData;
            $data[$v]['friends'] = $getFriendsData;
        }

        $dataClan = array();
        $getLevelData = usersModel::orderBy('coin', 'desc')->take(100)->get()->toArray();
        $getFriendsData = usersModel::selectRaw("id, name, coin, (select count(id) from my_team where user_id = users.id) as my_direct")->whereRaw("my_direct > 0")->orderBy('my_direct', 'desc')->take(100)->get()->toArray();

        $j=1;
        foreach($getLevelData as $kl => $vl)
        {
            $getLevelData[$kl]['rank'] = $j;
            $j++;
        }

        $j=1;
        foreach($getFriendsData as $kl => $vl)
        {
            $getFriendsData[$kl]['rank'] = $j;
            $j++;
        }

        $dataClan['coin'] = $getLevelData;
        $dataClan['friends'] = $getFriendsData;

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;
        $res['dataClan'] = $dataClan;

        return is_mobile($type, "dashboard", $res);
    }

    public function countSetup(Request $request)
    {
        $data = usersModel::where(['isCount' => 0])->orderBy('id', 'asc')->get()->toArray();

        foreach($data as $key => $value)
        {
            updateReverseSize($value['id'],$value['id']);

            usersModel::where(['id' => $value['id']])->update(['isCount' => 1]);
        }
    }

    public function getWinners(Request $request)
    {
        $type = "API";

        $winners = winnerModel::selectRaw("winner.*, users.name, users.chat_id, users.coin, (select count(id) from my_team where user_id = users.id) as my_direct")->join('users', 'users.chat_id', '=', 'winner.user_id')->orderByRaw("CAST(winner.amount AS UNSIGNED) DESC")->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['winners'] = $winners;

        return is_mobile($type, "dashboard", $res);
    }

    function allusers(Request $request){
        $type = $request->input('type');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $isExport = $request->input('export') === 'yes';
        $whereStartDate = '';
        $whereEndDate = '';
        
        // $data = usersModel::get()->toArray();
        $data = usersModel::query();
        if (!empty($from_date)) {
            $data->whereDate('created_on', '>=', date('Y-m-d', strtotime($from_date)));
        }
        
        // Check if `to_date` is provided and append a condition
        if (!empty($to_date)) {
            $data->whereDate('created_on', '<=', date('Y-m-d', strtotime($to_date)));
        }
        $data = $data->get()->toArray();

        if ($isExport) {
            // $data = DB::select($query);
    
            // $data = array_map(function ($value) {
            //     return (array) $value;
            // }, $data);
            $list = [
                ['Name','Email','Telegram Username','Wallet Address','Coin', 'PPH','Character','My Direct','My Team']
            ];
            
            $filePath = '/var/www/html/exports/userlist.csv';
            $fp = fopen($filePath, 'w');
            
            foreach ($list as $fields) {
                fputcsv($fp, $fields);
            }

            foreach ($data as $value) {
                $dataRows = [
                    $value['name'],
                    $value['email'],
                    $value['telegram_username'],
                    $value['wallet_address'],
                    $value['coin'],
                    $value['pph'],
                    $value['character'],
                    $value['my_direct'],
                    $value['my_team'],
                ];
                fputcsv($fp, $dataRows);
            }
        
            // Close file
            fclose($fp);
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;
        $res['from_date'] = $from_date;
        $res['to_date'] = $to_date;
        return is_mobile($type, "users", $res, 'view');
    }

    function update_cipher(Request $request){
        $data = [
            "Meliss", "Mining", "Olenna", "Oracle", "Payout", "Qhorin", "Quarks", "Quorum", "Rickon", "Sandor", "Serena", 
            "Smarty", "Stable", "Stakes", "Stakey", "Storms", "Tokens", "Tokeny", "Tommen", "Trader", "Tyrell", "Tyrion", 
            "Vaulty", "Walder", "Wallet", "Winter", "Wyvern", "Xenith", "Yieldy", "Zcashy", "Zephyr", "Zerion", "GameFi", 
            "Supply", "Access", "Reveal", "Battle", "Throne", "Attack", "Allies", "Traits", "Layer2", "Rollup", "Layer1", 
            "Squire", "Warden", "Maiden", "Banner", "Rivals", "Alert", "Balon", "Batch", "Block", "Burst", "Cerse", "Chain", 
            "Coins", "Curve", "Dashy", "Davos", "Doran", "Dorne", "Drogo", "Eddon", "Ether", "Euron", "Ferry", "Flock", 
            "Gains", "Gared", "Gauge", "Gilly", "Golem", "Greyw", "Guard", "Hacks", "Icosa", "Irons", "Jojen", "Jonas", 
            "Jorah", "Joule", "Kings", "Klays", "Krill", "Lambo", "Loras", "Lumen", "Lyann", "Marga", "Miner", "Nodes", 
            "Nonce", "Nymer", "Oasis", "Petyr", "Pluto", "Proof", "Queen", "Quent", "Quirk", "Rhaeg", "Rhaen", "Sansa", 
            "Sats", "Shill", "Slump", "Smart", "Stake", "Stark", "Syrio", "Token", "Trade", "Tully", "Tywin", "Varys", 
            "Vault", "Venus", "Viser", "Yield", "Zcash", "Zerox", "Unity", "Irony", "Value", "Quest", "Realm", "Power", 
            "dApps", "State", "Layer", "Essos", "Sword", "Crown", "Armor", "Ruler", "Faith", "Honor", "Sigil", "Siege", 
            "Blood", "Trial", "Arya", "Bear", "Bits", "Bitz", "BNB", "Bran", "Bryn", "BTC", "Bull", "Cash", "Coin", "DAO", 
            "DApp", "Dash", "DeFi", "DEX", "Dire", "IDoge", "Doth", "Eddo", "ETH", "Fiat", "FOMO", "Fork", "Frey", "Gend", 
            "Hale", "Hash", "HODL", "ICO", "ICOs", "Iron", "Jeor", "Khal", "Lann", "Lite", "LTC", "Mace", "Mint", "Mono", 
            "NFT", "Node", "Olen", "Osha", "Pike", "Pool", "Pump", "Punk", "Qash", "Rams", "Reek", "Rekt", "Snow", "Swap", 
            "Vale", "Wild", "Wolf", "Yara", "Zane", "NFTs", "Earn", "Drop", "Lore", "Clan", "Rare", "Loot", "Burn", "King", 
            "Gold", "Lord", "Lady", "Oath", "Lion", "Feud", "Sand", "Ary", "Bal", "Edd", "Gas", "Jon", "Jor", "Myr", "Ned", 
            "Rha", "Rob", "Sam", "Tyr", "ROI", "War", "P2P", "IEO", "idocial", "docial", "binance", "coinbase", "kraken", 
            "bybit", "mexc", "memeking", "fortune", "bones", "airdrop", "blockchain", "like", "post", "share", "comment", 
            "follow", "follower", "streak", "popular", "content", "creator", "user", "click", "epoch", "night", "hood", 
            "kingdom", "mighty", "noble", "brave", "wealth", "1usdt", "rider", "host", "blade", "shield", "raven", "frost", 
            "pelt", "glass", "valyrian", "quill", "scales"
        ];

        $checkcipher = DB::table('latest_cipher')->count();

        if ($checkcipher == 0) {
            $newcipher=$data[0];
            DB::table('latest_cipher')->insert([
                'cipher_value' => $data[0], // First cipher value
            ]);
        } else {

            $latestCipher = DB::table('latest_cipher')->latest('id')->first();
            
            $currentIndex = array_search($latestCipher->cipher_value, $data);
            
            $nextIndex = ($currentIndex + 1) % count($data);
            
            DB::table('latest_cipher')->where('cipher_value',$latestCipher->cipher_value)->update([
                'cipher_value' => $data[$nextIndex],
            ]);
            $newcipher=$data[$nextIndex];
        }
        
        $cipher= new cipherModel;
        $cipher->cipher_code=$newcipher;
        $cipher->save();
    }

    public function doReferral(Request $request){
        $type = $request->input('type');
        $chat_id = $request->input('id');
        $link = $request->input('link');

        if(empty($link))
        {
            $res['status_code'] = 0;
            $res['message'] = "Parameter Missing.";
        }

        $getUser = usersModel::where(['chat_id' => $chat_id])->get()->toArray();

        if(count($getUser) > 0)
        {
            if(!empty($getUser['0']['referral_id']))
            {
                $res['status_code'] = 0;
                $res['message'] = "User is already refferaled.";
            }else
            {
                if($getUser['0']['my_direct'] > 0)
                {
                    $res['status_code'] = 0;
                    $res['message'] = "You are not eligible to refferal.";
                }else
                {
                    // Parse the URL to get the query string
                    $queryString = parse_url($link, PHP_URL_QUERY);

                    // Parse the query string into an associative array
                    parse_str($queryString, $params);

                    $startAppValue = $params['startApp'] ?? $params['startapp'];

                    if(!empty($startAppValue))
                    {
                        if($chat_id == $startAppValue)
                        {
                            $res['status_code'] = 0;
                            $res['message'] = "You can't refer yourself.";
                        }else
                        {
                            $checkReferral = usersModel::where(['chat_id' => $startAppValue])->get()->toArray();

                            if(count($checkReferral) > 0)
                            {
                                usersModel::where(['chat_id' => $chat_id])->update(['referral_id' => $startAppValue]);

                                DB::statement("UPDATE users set my_direct = (my_direct + 1) where chat_id = '".$startAppValue."'");

                                $earnLog = array();
                                $earnLog['user_id'] = $startAppValue;
                                $earnLog['amount'] = 5000;
                                $earnLog['tag'] = "FRIEND";
                                $earnLog['refrence_id'] = $chat_id;
                                $earnLog['status'] = 0;
                                $earnLog['date'] = date('Y-m-d');

                                earnModel::insert($earnLog);

                                updateReverseSize($getUser['0']['id'], $getUser['0']['id']);

                                $res['status_code'] = 1;
                                $res['message'] = "Successfully Referral Processed.";
                            }else
                            {
                                $res['status_code'] = 0;
                                $res['message'] = "Invalid Referral URL.";
                            }
                        }

                    }else
                    {
                        $res['status_code'] = 0;
                        $res['message'] = "Invalid Referral URL.";
                    }
                }
            }
        }else
        {
            $res['status_code'] = 0;
            $res['message'] = "No User Found.";
        }

        return is_mobile($type, "users", $res, 'view');
    }



    public function updateWinnerDetails(Request $request)
    {
        $type = "API";
        $wallet_address = $request->input('wallet_address');
        $facebook_story = $request->input('facebook_story');
        $instagram_story = $request->input('instagram_story');
        $x_post = $request->input('x_post');
        $id = $request->input('id');

        $checkUsername = usersModel::where(['chat_id' => $id])->get()->toArray();

        if(count($checkUsername) > 0)
        {
            winnerModel::where(['user_id' => $id])->update(['wallet_address' => $wallet_address, 'facebook_story' => $facebook_story, 'instagram_story' => $instagram_story, 'x_post' => $x_post]);

            $res['status_code'] = 1;
            $res['message'] = "Success";
        }else
        {
            $res['status_code'] = 0;
            $res['message'] = "No user found";
        }

        return is_mobile($type, "dashboard", $res);
    }

    function store_exchange(Request $request){
        $type = "API";
        $user_id = $request->input('user_id');
        $exchange = $request->input('exchange');
        $logo = $request->input('logo');
        $data= userExchangeModel::where('user_id',$user_id)->first();
        if($data){
            userExchangeModel::where('user_id',$user_id)->update([
                'logo'=>$logo,
                'name'=>$exchange
            ]);
        }
        else{
            $userExchangeModel= new userExchangeModel;
            $userExchangeModel->user_id=$user_id;
            $userExchangeModel->name=$exchange;
            $userExchangeModel->logo=$logo;
            $userExchangeModel->save();
        }
        $res['status_code'] = 1;
        $res['message'] = "Added";
        return is_mobile($type, "dashboard", $res);
    }

    function get_exchange(Request $request){
        $type = "API";
        $user_id = $request->input('user_id');
        $data= userExchangeModel::where('user_id',$user_id)->first();
        if($data){
            $res['status_code'] = 1;
            $res['message'] = "Added";
            $res['exchange_name'] = $data;
        }else{
            $res['status_code'] = 1;
            $res['message'] = "Added";
            $res['exchange_name'] = "9INC";
        }
        return is_mobile($type, "dashboard", $res);
    }

    function fetch_affiliate_task(Request $request){
        $type = "API";
        $user_id = $request->input('user_id');
        $data= afiliateTask::get();
        if($data){
            $res['status_code'] = 1;
            $res['message'] = "Added";
            $res['tasks'] = $data;
        }else{
            $res['status_code'] = 1;
            $res['message'] = "Added";
            $res['tasks'] = "";
        }
        return is_mobile($type, "dashboard", $res);
    }
    function insertAffiliatejoin(Request $request){
        $type = "API";
        $telegram = $request->input('telegram');
        $countryCode = $request->input('countryCode');
        $phone = $request->input('phone');
        $email = $request->input('email');
        $user_id = $request->input('user_id');

        DB::table('affiliate_user')->insert([
            'email' => $email,
            'telegram' => $telegram,
            'countryCode' => $countryCode,
            'phone' => $phone,
            'user_id' => $user_id,
        ]);
        
        $res['status_code'] = 1;
        $res['message'] = "We will inform you once Referral Program will be Live";

        return is_mobile($type, "dashboard", $res);
    }

    function checkAffiliatejoin(Request $request){
        $type = "API";
        $user_id = $request->input('user_id');

        $check_user = DB::table('affiliate_user')->where('user_id',$user_id)->first();
        if ($check_user) {
            $res['status_code'] = 1;
            $res['message'] = "We will inform you once Referral Program will be Live";
        }else{
            $res['status_code'] = 0;
            $res['message'] = "Yet To Store";
        }
        return is_mobile($type, "dashboard", $res);
    }
    function get_affilitate_user(Request $request){
        $type = $request->input('type');
        $user_id = $request->session()->get('user_id');
        $users = DB::table('affiliate_user')->join('users','users.chat_id','=','affiliate_user.user_id')->select('users.chat_id','users.wallet_address', 'affiliate_user.*')->get()->toArray();

        $res['status_code'] = 0;
        $res['message'] = "Data Fetched Successfully.";
        $res['data'] = $users;

        return is_mobile($type, "affilitate_users", $res,"view");
    }
}
