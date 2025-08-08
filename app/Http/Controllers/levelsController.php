<?php

namespace App\Http\Controllers;

use App\Models\cardsModel;
use App\Models\categoryModel;
use App\Models\levelsModel;
use Illuminate\Http\Request;

use function App\Helpers\is_mobile;

class levelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');
        $data = levelsModel::select('levels.*','cards.title')->leftjoin('cards','levels.card_id','=','cards.id')->orderBy('cards.title','ASC')->orderBy('levels.level', 'ASC')->get()->toArray();

        // $data = levelsModel::get()->toArray();
        $category = categoryModel::where(['status' => 1])->get()->toArray();
        $cards = cardsModel::where(['status' => 1])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;
        $res['category'] = $category;
        $res['cards'] = $cards;

        return is_mobile($type, "levels", $res, 'view');
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
        $updateData = $request->except('_method', '_token', 'submit');

        $type = $request->input('type');

        levelsModel::insert($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Level Added successfully";

        return is_mobile($type, "levels.index", $res);
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

        $editData = levelsModel::where(['id' => $id])->get()->toArray();
        $category = categoryModel::where(['status' => 1])->get()->toArray();
        $cards = cardsModel::where(['status' => 1])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['editData'] = $editData[0];
        $res['category'] = $category;
        $res['cards'] = $cards;

        return is_mobile($type, 'levels', $res, 'view');
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
        $updateData = $request->except('_method', '_token', 'submit');

        $type = $request->input('type');

        levelsModel::where(['id' => $id])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Level Updated successfully";

        return is_mobile($type, "levels.index", $res);
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

        $deleteData = levelsModel::where(['id' => $id])->delete();

        $res['status_code'] = 1;
        $res['message'] = "Level Deleted Successfully";

        return is_mobile($type, 'levels.index', $res);
    }
}
