<?php

namespace App\Http\Controllers;

use App\Models\afiliateTask;
use Illuminate\Http\Request;

use function App\Helpers\is_mobile;

class afilliateTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = afiliateTask::get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;

        return is_mobile($type, "affiliate_tasks", $res, 'view');
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
        $file_name = "";
        if ($request->hasFile('task_logo')) {
            $file = $request->file('task_logo');
            $originalname = $file->getClientOriginalName();
            $name = "affiliate-task" . '_' . date('YmdHis');
            $ext = \File::extension($originalname);
            $file_name = $name . '.' . $ext;
            $path = $file->storeAs('public/', $file_name);
            $updateData['task_logo'] = $file_name;
        }
        
        afiliateTask::insert($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Tasks Added successfully";

        return is_mobile($type, "affiliatetask.index", $res);
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

        $editData = afiliateTask::where(['id' => $id])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['editData'] = $editData[0];

        return is_mobile($type, 'affiliate_tasks', $res, 'view');
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
        $file_name = "";
        if ($request->hasFile('task_logo')) {
            $file = $request->file('task_logo');
            $originalname = $file->getClientOriginalName();
            $name = "cards-image" . '_' . date('YmdHis');
            $ext = \File::extension($originalname);
            $file_name = $name . '.' . $ext;
            $path = $file->storeAs('public/', $file_name);
            $updateData['task_logo'] = $file_name;
        }

        afiliateTask::where(['id' => $id])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Tasks Updated successfully";

        return is_mobile($type, "affiliatetask.index", $res);
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

        $deleteData = afiliateTask::where(['id' => $id])->delete();

        $res['status_code'] = 1;
        $res['message'] = "Tasks Deleted Successfully";

        return is_mobile($type, 'affiliatetask.index', $res);
    }
}
