<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\LookUp;
use App\User;
use DB;
use Exception;
use Illuminate\Http\Request;

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
    public function store(UserStoreRequest $request)
    {
        try {
            DB::beginTransaction();
            User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'username' => $request->input('username'),
                'password'  => bcrypt($request->input('password')),
                'privilege_code'  => $request->input('privilege_code'),
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::findOrFail($id);
        $users->privilege_text = $users->privilegeText();

        return response()->json([
            'users' => $users
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
    public function update(UserUpdateRequest $request, $id)
    {
        try {
            DB::beginTransaction();
            if ($request->input('password') === null) {
                User::findOrFail($id)->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'username' => $request->input('username'),
                    'privilege_code'  => $request->input('privilege_code'),
                    'is_active'  => $request->input('is_active'),
                ]);
            } else {
                User::findOrFail($id)->update([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'username' => $request->input('username'),
                    'password'  => bcrypt($request->input('password')),
                    'privilege_code'  => $request->input('privilege_code'),
                    'is_active'  => $request->input('is_active'),
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

    /**
     * Display a listing of the resource in form of datatable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function datatables(Request $request)
    {
        $users = User::query();
        return datatables()
            ->of($users)
            ->addIndexColumn()
            ->editColumn('is_active', function ($user) {
                return $user->isActiveBadge();
            })
            ->editColumn('privilege_code', function ($user) {
                return $user->privilegeText();
            })
            ->addColumn('action', function ($user) {
                $btn = '';
                // $btn = '<button data-remote_destroy="' . route('user.destroy', $user->id) . '" type="button" class="btn btn-danger btn-sm btnDelete" title="Hapus"><i class="fas fa-trash fa-fw"></i></button> ';
                $btn .= '<button data-remote_show="' . route('user.show', $user->id) . '" data-remote_update="' . route('user.update', $user->id) . '" type="button" class="btn btn-warning btn-sm btnEdit" title="Edit"><i class="fas fa-pencil-alt fa-fw"></i></button> ';
                return $btn;
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Display a listing of previlege code in form of select2.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPrivilegeCode(Request $request)
    {
        $page = $request->page;
        $search = $request->term;
        $limit = 25;
        $offset = ($page - 1) * $limit;

        $lookUps = LookUp::select('*')
            ->where('group_code', 'PRIV_CODE')
            ->where(function($query) use ($search){
                $query->where('label', 'like', "%$search%");
            })
            ->orderby('key', 'asc')
            ->skip($offset)->take($limit)
            ->get();

        $results = [];
        foreach ($lookUps as $i => $lookUp) {
            $results[] = array(
                'id' => $lookUp->key,
                'text' => "$lookUp->label",
            );
        }

        if (count($results) < $limit) {
            $more_pages = false;
        } else {
            $more_pages = true;
        }

        return response()->json([
            "results" => $results,
            "pagination" => [
                "more" => $more_pages,
            ],
        ]);
    }
}
