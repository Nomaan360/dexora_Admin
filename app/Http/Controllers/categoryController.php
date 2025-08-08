<?php

namespace App\Http\Controllers;

use App\Models\categoryModel;
use Illuminate\Http\Request;

use function App\Helpers\is_mobile;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type = $request->input('type');

        $data = categoryModel::get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['data'] = $data;

        return is_mobile($type, "category", $res, 'view');
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

        $file_name = "";
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalname = $file->getClientOriginalName();
            $name = "category-image" . '_' . date('YmdHis');
            $ext = \File::extension($originalname);
            $file_name = $name . '.' . $ext;
            $path = $file->storeAs('public/', $file_name);
            $updateData['image'] = $file_name;
        }

        categoryModel::insert($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Category Added successfully";

        return is_mobile($type, "category.index", $res);
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

        $editData = categoryModel::where(['id' => $id])->get()->toArray();

        $res['status_code'] = 1;
        $res['message'] = "Success";
        $res['editData'] = $editData[0];

        return is_mobile($type, 'category', $res, 'view');
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

        $file_name = "";
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $originalname = $file->getClientOriginalName();
            $name = "category-image" . '_' . date('YmdHis');
            $ext = \File::extension($originalname);
            $file_name = $name . '.' . $ext;
            $path = $file->storeAs('public/', $file_name);
            $updateData['image'] = $file_name;
        }

        categoryModel::where(['id' => $id])->update($updateData);

        $res['status_code'] = 1;
        $res['message'] = "Category Updated successfully";

        return is_mobile($type, "category.index", $res);
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

        $deleteData = categoryModel::where(['id' => $id])->delete();

        $res['status_code'] = 1;
        $res['message'] = "Category Deleted Successfully";

        return is_mobile($type, 'category.index', $res);
    }
}
