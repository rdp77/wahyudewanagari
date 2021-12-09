<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Template\MainController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(MainController $MainController)
    {
        $this->middleware('auth');
        $this->MainController = $MainController;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(Request $req)
    {
        if ($req->ajax()) {
            $data = Category::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('category.edit', $row->id) . '" ';
                    $actionBtn .= 'class="btn btn-icon icon-left btn-warning text-white mb-1 mt-1 mr-1" style="cursor:pointer;">';
                    $actionBtn .= '<i class="far fa-edit"></i> Edit</a>';
                    $actionBtn .= '<button onclick="del(' . $row->id . ')" ';
                    $actionBtn .= 'class="btn btn-icon icon-left btn-danger text-white mb-1 mt-1">';
                    $actionBtn .= '<i class="far fa-trash-alt"></i> Hapus</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.backend.data.category.indexCategory');
    }

    public function create()
    {
        return view('pages.backend.data.category.createCategory');
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255']
        ]);

        $validator = $this->MainController
            ->validator($validator->errors()->all());

        if (count($validator) != 0) {
            return Response::json([
                'status' => 'error',
                'data' => $validator
            ]);
        }

        Category::create([
            'name' => $req->name,
            'created_by' => Auth::user()->name,
            'updated_by' => '',
            'deleted_by' => ''
        ]);

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' membuat kategori baru'
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil membuat kategori baru'
        ]);
    }

    public function edit($id)
    {
        $category = Category::find($id);
        return view('pages.backend.data.category.updateCategory', ['category' => $category]);
    }

    public function update($id, Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);

        $validator = $this->MainController
            ->validator($validator->errors()->all());

        if (count($validator) != 0) {
            return Response::json([
                'status' => 'error',
                'data' => $validator
            ]);
        }

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' mengubah kategori'
        );

        Category::where('id', $id)
            ->update([
                'name' => $req->name,
                'updated_by' => Auth::user()->name
            ]);

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil mengubah kategori'
        ]);
    }

    public function destroy(Request $req, $id)
    {
        $category = Category::find($id);
        $category->deleted_by = Auth::user()->name;
        $category->save();

        Category::destroy($id);

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' menghapus kategori pengguna ke recycle bin'
        );

        return Response::json(['status' => 'success']);
    }

    public function recycle(Request $req)
    {
        if ($req->ajax()) {
            $data = Category::onlyTrashed()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button onclick="restore(' . $row->id . ')" ';
                    $actionBtn .= 'class="btn btn-icon icon-left btn-primary text-white mb-1 mt-1 mr-1">';
                    $actionBtn .= '<i class="fas fa-redo"></i> Kembalikan</button>';
                    $actionBtn .= '<button onclick="delRecycle(' . $row->id . ')" ';
                    $actionBtn .= 'class="btn btn-icon icon-left btn-danger text-white mb-1 mt-1">';
                    $actionBtn .= '<i class="far fa-trash-alt"></i> Hapus</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.backend.data.category.recycleCategory');
    }

    public function restore($id, Request $req)
    {
        Category::onlyTrashed()
            ->where('id', $id)
            ->restore();

        $category = Category::find($id);
        $category->deleted_by = '';
        $category->save();

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' mengembalikan data kategori'
        );

        return Response::json(['status' => 'success']);
    }

    public function delete($id, Request $req)
    {
        Category::onlyTrashed()
            ->where('id', $id)
            ->forceDelete();

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' menghapus data kategori secara permanen'
        );

        return Response::json(['status' => 'success']);
    }

    public function deleteAll(Request $req)
    {
        $category = Category::onlyTrashed()
            ->forceDelete();

        if ($category == 0) {
            return Response::json([
                'status' => 'error',
                'data' => "Tidak ada data di recycle bin"
            ]);
        } else {
            $category;
        }

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' menghapus semua data kategori secara permanen'
        );

        return Response::json(['status' => 'success']);
    }
}