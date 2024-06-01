<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return view('user.index');
    }

    public function data()
    {
        $users = $this->userService->getAllNonAdminUsers();

        return datatables()
            ->of($users)
            ->addIndexColumn()
            ->addColumn('action', function ($user) {
                return '
                <div class="d-flex justify-content-center">
                    <div class="dropdown no-arrow">
                        <a class="btn btn-sm dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="true">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a onclick="editForm(`' . route('user.update', $user->id) . '`)" class="dropdown-item" href="#">Perbarui</a></li>
                            <li><a onclick="deleteData(`' . route('user.destroy', $user->id) . '`)" class="dropdown-item" href="#">Hapus</a></li>
                        </ul>
                    </div>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $this->userService->createUser($validatedData);

        return response()->json('Data berhasil disimpan', 200);
    }

    public function show($id)
    {
        $user = User::findOrFail($id);

        return response()->json($user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->userService->updateUser($user, $request->validated());

        return response()->json('Data berhasil diperbarui', 200);
    }

    public function destroy($id)
    {
        $this->userService->deleteUser($id);

        return response(null, 204);
    }
}
