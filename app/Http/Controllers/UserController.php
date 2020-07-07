<?php

namespace App\Http\Controllers;

use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index');
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
        // validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|unique:users|email',
            'username' => 'required|unique:users|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'invalid',
                'validators' => $validator->errors(),
            ]);
        }
        // validate the request

        // store the request
        try {
            DB::beginTransaction();
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'password'  => bcrypt($request->input('password'))
            ]);
            DB::commit();
            
            return response()->json([
                'status' => 'valid',
                'pesan' => 'User berhasil ditambah',
            ]);
        } catch (Exception $exc) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'pesan' => $exc->getMessage(),
            ]);
        }
        // store the request
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json([
            'users' => User::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        // validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                'unique:users,email,'.$id.',id'
            ],
            'username' => [
                'required',
                'string',
                'unique:users,username,'.$id.',id'
            ],
            'password' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'invalid',
                'validators' => $validator->errors(),
            ]);
        }
        // validate the request

        // save the request
        try {
            DB::beginTransaction();
            if($request->input('password') === null) {
                User::findOrFail($id)->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'username' => $request->input('username'),
                ]);
            }
            else {
                User::findOrFail($id)->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'username' => $request->input('username'),
                    'password'  => bcrypt($request->input('password'))
                ]);
            }
            DB::commit();
            
            return response()->json([
                'status' => 'valid',
                'pesan' => 'User berhasil diedit',
            ]);
        } catch (Exception $exc) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'pesan' => $exc->getMessage(),
            ]);
        }
        // save the request
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            User::findOrFail($id)->delete();
            DB::commit();
            
            return response()->json([
                'status' => 'valid',
                'pesan' => 'User berhasil dihapus',
            ]);
        } catch (Exception $exc) {
            DB::rollBack();
            return response()->json([
                'status' => 'error',
                'pesan' => $exc->getMessage(),
            ]);
        }
    }

    public function datatables(Request $request)
    {
        $users = User::query();
        return datatables()
            ->of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                $btn = '<button data-remote_show="'.route('user.show', $user->id).'" data-remote_update="'.route('user.update', $user->id).'" type="button" class="btn btn-success btn-xs btnEdit" title="Edit"><i class="fas fa-pencil-alt"></i></button> ';
                $btn .= '<button data-remote_destroy="'.route('user.destroy', $user->id).'" type="button" class="btn btn-danger btn-xs btnDelete" title="Hapus"><i class="fas fa-trash"></i></button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
