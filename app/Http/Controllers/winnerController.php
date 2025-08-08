<?php

namespace App\Http\Controllers;

use App\Models\winnerModel;
use App\Models\usersModel;
use Illuminate\Http\Request;

use function App\Helpers\is_mobile;

class winnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = winnerModel::selectRaw("winner.*, users.name, users.chat_id")->join('users', 'users.chat_id', '=', 'winner.user_id')->orderBy("winner.id", 'desc')->get()->toArray();
        $users = usersModel::where(['status' => 1])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;
        $res['users'] = $users;

        return is_mobile($type, "winner", $res, 'view');
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
        $user_id = $request->session()->get('user_id');
        $updateData = $request->except('_method','_token','submit');
        
        $type = $request->input('type');
        
        winnerModel::insert($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Winner Added successfully";

        return is_mobile($type, "winner.index", $res);
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
    public function edit(Request $request, $id)
    {
        $type = $request->input('type');

        $editData = winnerModel::where(['id' => $id])->get()->toArray();
        $users = usersModel::where(['status' => 1])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['editData'] = $editData[0];
        $res['users'] = $users;

        return is_mobile($type, 'winner', $res, 'view');
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
        $updateData = $request->except('_method','_token','submit');
        
        $type = $request->input('type');

        winnerModel::where(['id' => $id])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Winner Updated successfully";

        return is_mobile($type, "winner.index", $res);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $type = $request->input('type');

        $deleteData = winnerModel::where(['id' => $id])->delete();

        $res['status_code'] = 1;
        $res['message'] = "Winner Deleted Successfully";

        return is_mobile($type, 'ads.index', $res);
    }
}