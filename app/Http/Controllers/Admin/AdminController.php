<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthAdminRequest;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Menampilkan data statistik order:
     * - Hari ini
     * - Kemarin
     * - Bulan ini
     * - Tahun ini
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil semua order berdasarkan tanggal tertentu
        $todayOrders = Order::whereDay('created_at', Carbon::today())->get(); // Hari ini
        $yesterdayOrders = Order::whereDay('created_at', Carbon::yesterday())->get(); // Kemarin
        $monthOrders = Order::whereMonth('created_at', Carbon::now()->month)->get(); // Bulan ini
        $yearOrders = Order::whereYear('created_at', Carbon::now()->year)->get(); // Tahun ini

        // Kirim data ke view admin.index
        return view('admin.index')->with([
            'todayOrders' => $todayOrders,
            'yesterdayOrders' => $yesterdayOrders,
            'monthOrders' => $monthOrders,
            'yearOrders' => $yearOrders,
        ]);
    }

    /**
     * Menampilkan halaman login jika admin belum login,
     * jika sudah login maka redirect ke dashboard admin.
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function login()
    {
        if (!auth()->guard('admin')->check()) {
            // Jika belum login, tampilkan halaman login
            return view('admin.login');
        }

        // Jika sudah login, langsung ke dashboard
        return redirect()->route('admin.index');
    }

    /**
     * Menangani proses login admin setelah form dikirim.
     * Validasi dari FormRequest (AuthAdminRequest)
     *
     * @param AuthAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function auth(AuthAdminRequest $request)
    {
        // Jika data valid
        if ($request->validated()) {
            // Coba login dengan guard admin
            if (auth()->guard('admin')->attempt([
                'email' => $request->email,
                'password' => $request->password,
            ])) {
                // Jika sukses login, redirect ke dashboard
                $request->session()->regenerate(); // amankan session
                return redirect()->route('admin.index');
            } else {
                // Kalau gagal login, kirim pesan error balik ke login
                return redirect()->route('admin.login')->with([
                    'error' => 'The Credentials do not match on our records'
                ]);
            }
        }
    }

    /**
     * Logout admin dari sistem dan redirect ke halaman utama admin.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        // Logout session guard admin
        auth()->guard('admin')->logout();

        // Redirect ke halaman admin utama (biasanya login lagi)
        return redirect()->route('admin.index');
    }
}
