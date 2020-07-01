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
            return response()->json([
                'status' => 'error',
                'pesan' => $exc->getMessage(),
            ]);
        }
        
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function datatables(Request $request)
    {
        $data = User::query();
        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($field) {
                $btn = '<button data-id="'.$field->id.'" type="button" class="btn btn-success btn-xs" title="Edit"><i class="fas fa-pencil-alt"></i></button> ';
                $btn .= '<button data-id="'.$field->id.'" type="button" class="btn btn-danger btn-xs" title="Hapus"><i class="fas fa-trash"></i></button> ';
                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
