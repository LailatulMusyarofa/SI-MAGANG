<?php

namespace App\Http\Controllers;

use App\DataTables\MenusDataTable;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(MenusDataTable $dataTable)
    {
        return $dataTable->render('pages.menu.index');
    }

    public function getDataAll()
    {
        $menus = Menu::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Data menu berhasil diambil.',
            'data' => $menus
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'icon' => 'required',
            'parent_id' => 'nullable',
            'url' => 'nullable',
            'icon' => 'required',
            'order' => 'required',
            'match_segment' => 'nullable',
        ]);

        if ($request->is_active == 'on') {
            $request->merge(['is_active' => true]);
        } else {
            $request->merge(['is_active' => false]);
        }

        unset($request['_token']);
        unset($request['_method']);

        try {
            DB::beginTransaction();

            $menu = Menu::create($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil ditambahkan.',
                'data' => $menu
            ], 201);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Menu gagal ditambahkan.',
                'data' => $th
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        // dd($request->all(), $menu);

        $request->validate([
            'name' => 'required',
            'icon' => 'nullable',
            'parent_id' => 'nullable',
            'url' => 'nullable',
            'icon' => 'required',
            'order' => 'required',
            'match_segment' => 'nullable',
        ]);

        if ($request->is_active == 'on') {
            $request->merge(['is_active' => true]);
        } else {
            $request->merge(['is_active' => false]);
        }

        unset($request['_token']);
        unset($request['_method']);

        try {
            DB::beginTransaction();

            $menu->update($request->all());

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil diubah.',
                'data' => $menu
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Menu gagal diubah.',
                'data' => $th
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        // dd($menu);

        try {
            DB::beginTransaction();

            $menu->delete();

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Menu berhasil dihapus.',
                'data' => $menu
            ], 200);
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Menu gagal dihapus.',
                'data' => $th
            ], 500);
        }
    }
}
