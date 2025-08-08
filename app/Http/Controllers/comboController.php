<?php

namespace App\Http\Controllers;

use App\Models\comboModel;
use App\Models\cardsModel;
use Illuminate\Http\Request;

use function App\Helpers\is_mobile;

class comboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = comboModel::orderBy('date', 'DESC')->get()->toArray();
        $cards = cardsModel::where(['status' => 1])->get()->toArray();

        $getCardName = array();
        foreach($cards as $key => $value)
        {
            $getCardName[$value['id']] = $value['title'];
        }

        foreach ($data as $key => $value) {
            $data[$key]['card_1'] = $getCardName[$value['card_1']];
            $data[$key]['card_2'] = $getCardName[$value['card_2']];
            $data[$key]['card_3'] = $getCardName[$value['card_3']];
        }

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;
        $res['cards'] = $cards;

        return is_mobile($type, "combo", $res, 'view');
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

        comboModel::insert($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Combo Added successfully";

        return is_mobile($type, "combo.index", $res);
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

        $editData = comboModel::where(['id' => $id])->get()->toArray();
        $cards = cardsModel::where(['status' => 1])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['editData'] = $editData[0];
        $res['cards'] = $cards;

        return is_mobile($type, 'combo', $res, 'view');
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

        comboModel::where(['id' => $id])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Combo Updated successfully";

        return is_mobile($type, "combo.index", $res);
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

        $deleteData = comboModel::where(['id' => $id])->delete();

        $res['status_code'] = 1;
        $res['message'] = "Combo Deleted Successfully";

        return is_mobile($type, 'cipher.index', $res);
    }
}