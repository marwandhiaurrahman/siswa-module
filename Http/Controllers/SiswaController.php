<?php

namespace Modules\Siswa\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class SiswaController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:siswa-show', ['only' => ['index', 'show']]);
        $this->middleware('permission:siswa-manage||siswa-show', ['only' => ['create', 'store', 'edit', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $data = User::role('Siswa')->latest()->get();
        return view('siswa::admin.siswa.index', compact('data'))->with('i', 0);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('siswa::admin.siswa.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'telp' => 'required|numeric',
            'username' => 'required|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            // 'roles' => 'required',
            // 'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // if (!empty($request->foto)) {
        //     $imageName = $request->name. '-' . $request->foto->getClientOriginalName();
        //     $request->foto->move(public_path('storage/profile-image'), $imageName);
        // }
        // $input['foto'] = $imageName;

        $request['password'] = Hash::make($request['password']);
        $request['roles'] = 'Siswa';


        $user = User::create($request->all());
        $user->assignRole($request->input('roles'));

        Alert::success('Success Information', 'User created successfully');
        return redirect()->route('siswa.index');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('siswa::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('siswa::admin.siswa.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'username' => 'required|unique:users,username,' . $id,
            'telp' => 'required|numeric',
            'password' => 'same:confirm-password',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);

        $user = User::find($id);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        if (!empty($request->foto)) {
            $imageName = $request->foto->getClientOriginalName();
            $request->foto->move(public_path('storage/profile-image'), $imageName);
            $input['foto'] = $imageName;
            if (File::exists(public_path('storage/profile-image/' . $user->foto))) {
                File::delete(public_path('storage/profile-image/' . $user->foto));
            }
        }

        $user->update($input);

        Alert::success('Success Information', 'User updated successfully');
        return redirect()->route('siswa.index');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();

        Alert::success('Success Information', 'User deleted successfully');
        return redirect()->route('siswa.index');
    }
}
