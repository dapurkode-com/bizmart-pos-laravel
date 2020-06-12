<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberStoreRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('member.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('member.create');
    }

    /**
     * @param \App\Http\Requests\MemberStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberStoreRequest $request)
    {
        $member = Member::create($request->all());

        $request->session()->flash('member.name', $member->name);

        return redirect()->route('member.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Member $member)
    {
        return view('member.show', compact('member'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Member $member)
    {
        return view('member.edit', compact('member'));
    }

    /**
     * @param \App\Http\Requests\MemberUpdateRequest $request
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public function update(MemberUpdateRequest $request, Member $member)
    {
        $member->update($request->only(['name', 'address', 'phone']));

        $request->session()->flash('member.name', $member->name);

        return redirect()->route('member.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Member $member
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Member $member)
    {
        $request->session()->flash('member.name', $member->name);

        $member->delete();

        return redirect()->route('member.index');
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     **/
    public function datatables(Request $request)
    {
        $data = Member::query();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($member) {
                $btn = "";
                $btn .= "<button data-remote=\"" . route('member.show', $member->slug) . "\" type=\"button\" class=\"btn btn-sm btn-danger\"><i class=\"fa fa-trash\"></i> Hapus</button> ";
                $btn .= " <a href=\"" . route('member.edit', $member->slug) . "\" class=\"edit btn btn-warning btn-sm\"><i class=\"fa fa-edit\"></i> Ubah</a>";

                return $btn;
            })
            ->rawColumns(['action'])
            ->toJson();
    }
}
