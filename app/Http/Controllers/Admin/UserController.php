<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    // Khởi tạo query chỉ lấy tài khoản khách hàng
    $query = User::where('role', 'user')
                ->withCount('weddingCards');

    // Tìm kiếm theo tên hoặc email
    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%');
        });
    }

    // Phân trang
    $users = $query
                ->latest()
                ->paginate(10)
                ->withQueryString();

    // Thống kê tổng khách hàng
    $totalUsers = User::where('role', 'user')->count();

    $totalVip = User::where('role', 'user')
                    ->where('membership', 'vip')
                    ->count();

    $totalFree = User::where('role', 'user')
                     ->where('membership', 'free')
                     ->count();

    $totalLocked = User::where('role', 'user')
                       ->where('status', 0)
                       ->count();

    return view('admin.users.index', compact(
        'users',
        'totalUsers',
        'totalVip',
        'totalFree',
        'totalLocked'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
{
    return view('admin.users.create');
}

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'role' => 'required',
        'membership' => 'required',
        'status' => 'required',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
        'membership' => $request->membership,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'Thêm người dùng thành công.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
{
    return view('admin.users.edit', compact('user'));
}

    /**
     * Update the specified resource in storage.
     */
   public function update(Request $request, User $user)
{
    $request->validate([
        'name' => 'required|max:255',
        'email' => 'required|email|unique:users,email,' . $user->id,
        'membership' => 'required|in:free,vip',
        'status' => 'required|boolean',
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'membership' => $request->membership,
        'status' => $request->status,
    ]);

    return redirect()
        ->route('admin.users.index')
        ->with('success', 'Cập nhật khách hàng thành công.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
