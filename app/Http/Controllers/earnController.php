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
use App\Models\winnerModel;
use App\Models\tasksModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use function App\Helpers\is_mobile;
use function App\Helpers\updateReverseSize;

class earnController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');

        $res['status_code'] = 1;
        $res['message'] = "Success";

        return is_mobile($type, "report-referral", $res, 'view');
    }

    public function store(Request $request)
    {
        $type = $request->input('type');
        $from_date = $request->input('from_date');
        $to_date = $request->input('to_date');
        $isExport = $request->input('export') === 'yes';
        $from = Carbon::parse($request->input('from_date'));
        $to = Carbon::parse($request->input('to_date'));
        $diff = $to->diffInDays($from);
        // if($diff>9){
        //     $res['from_date'] = $from_date;
        //     $res['to_date'] = $to_date;
        //     $res['status_code'] = 1;
        //     $res['message'] = "Please Select Date with difference of 9 days";
        //     return is_mobile($type, "report-referral", $res, 'view');

        // }

        $query = "SELECT u.name, u.email, u.telegram_username, u.character, u.chat_id,u.wallet_address, u.pph, u.coin, u.my_direct, u.my_team, COUNT(e.id) as friend FROM `users` u inner join earn e on u.chat_id = e.user_id and e.tag = 'FRIEND'";

        if(!empty($from_date) && !empty($to_date))
        {
            $query .= "  and date_format(e.created_on, '%Y-%m-%d') BETWEEN '".date('Y-m-d', strtotime($from_date))."' and '".date('Y-m-d', strtotime($to_date))."' ";
        }else
        {
            $query .= "  and date_format(e.created_on, '%Y-%m-%d') = '".date('Y-m-d', strtotime($from_date))."'";
        }

        $query .= " GROUP by u.id order by friend desc";

        $data = DB::select($query);

        $data = array_map(function ($value) {
            return (array) $value;
        }, $data);
        if ($isExport) {
            $list = [
                ['Name','Telegram Username','Coin', 'PPH','My Direct','Friends']
            ];
            
            $filePath = '/var/www/html/exports/referralreport.csv';
            $fp = fopen($filePath, 'w');
            
            foreach ($list as $fields) {
                fputcsv($fp, $fields);
            }

            foreach ($data as $value) {
                $dataRows = [
                    $value['name'],
                    $value['telegram_username'],
                    $value['coin'],
                    $value['pph'],
                    $value['my_direct'],
                    $value['friend'],
                ];
                fputcsv($fp, $dataRows);
            }
        
            // Close file
            fclose($fp);
            return response()->download($filePath)->deleteFileAfterSend(true);
        }

        $res['status_code'] = 1;
        $res['message'] = "Report fetched successfully";
        $res['data'] = $data;
        $res['from_date'] = $from_date;
        $res['to_date'] = $to_date;

        return is_mobile($type, "report-referral", $res, 'view');
    }
}
