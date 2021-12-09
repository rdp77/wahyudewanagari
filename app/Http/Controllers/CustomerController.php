<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Template\MainController;
use App\Models\Category;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
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
            $data = Customer::all();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('customer.edit', $row->id) . '" ';
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

        return view('pages.backend.data.customer.indexCustomer');
    }

    public function create()
    {
        $category = Category::all();
        return view('pages.backend.data.customer.createCustomer', [
            'category' => $category
        ]);
    }

    public function store(Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required'],
            'tlp' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'desc' => ['required', 'string'],
        ]);

        $validator = $this->MainController
            ->validator($validator->errors()->all());

        if (count($validator) != 0) {
            return Response::json([
                'status' => 'error',
                'data' => $validator
            ]);
        }

        Customer::create([
            'name' => $req->name,
            'category_id' => $req->category,
            'tlp' => $req->tlp,
            'email' => $req->email,
            'address' => $req->address,
            'desc' => $req->desc,
            'created_by' => Auth::user()->name,
            'updated_by' => '',
            'deleted_by' => ''
        ]);

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' membuat customer baru'
        );

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil membuat customer baru'
        ]);
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        $category = Category::all();
        return view('pages.backend.data.customer.updateCustomer', [
            'customer' => $customer,
            'category' => $category
        ]);
    }

    public function update($id, Request $req)
    {
        $validator = Validator::make($req->all(), [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['required'],
            'tlp' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'desc' => ['required', 'string'],
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
            Auth::user()->name . ' mengubah customer'
        );

        Customer::where('id', $id)
            ->update([
                'name' => $req->name,
                'category_id' => $req->category,
                'tlp' => $req->tlp,
                'email' => $req->email,
                'address' => $req->address,
                'desc' => $req->desc,
                'updated_by' => Auth::user()->name
            ]);

        return Response::json([
            'status' => 'success',
            'data' => 'Berhasil mengubah customer'
        ]);
    }

    public function destroy(Request $req, $id)
    {
        $customer = Customer::find($id);
        $customer->deleted_by = Auth::user()->name;
        $customer->save();

        Customer::destroy($id);

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' menghapus data customer ke recycle bin'
        );

        return Response::json(['status' => 'success']);
    }

    public function recycle(Request $req)
    {
        if ($req->ajax()) {
            $data = Customer::onlyTrashed()->get();
            return Datatables::of($data)
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
        return view('pages.backend.data.customer.recycleCustomer');
    }

    public function restore($id, Request $req)
    {
        Customer::onlyTrashed()
            ->where('id', $id)
            ->restore();

        $customer = Customer::find($id);
        $customer->deleted_by = '';
        $customer->save();

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' mengembalikan data customer'
        );

        return Response::json(['status' => 'success']);
    }

    public function delete($id, Request $req)
    {
        Customer::onlyTrashed()
            ->where('id', $id)
            ->forceDelete();

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' menghapus data customer secara permanen'
        );

        return Response::json(['status' => 'success']);
    }

    public function deleteAll(Request $req)
    {
        $customer = Customer::onlyTrashed()
            ->forceDelete();

        if ($customer == 0) {
            return Response::json([
                'status' => 'error',
                'data' => "Tidak ada data di recycle bin"
            ]);
        } else {
            $customer;
        }

        $this->MainController->createLog(
            $req->header('user-agent'),
            $req->ip(),
            Auth::user()->name . ' menghapus semua data customer secara permanen'
        );

        return Response::json(['status' => 'success']);
    }
}