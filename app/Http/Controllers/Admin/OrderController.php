<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua order.
     * Method ini akan mengambil semua data order dari database
     * beserta relasi: products, user, dan coupon
     * lalu melemparnya ke view 'admin.orders.index'.
     */
    public function index()
    {
        $orders = Order::with(['products', 'user', 'coupon'])->latest()->get();
        return view('admin.orders.index')->with([
            'orders' => $orders
        ]);
    }

    /**
     * Update field delivered_at untuk menandai bahwa order sudah dikirim.
     * Biasanya dipanggil saat admin klik tombol "Mark as Delivered".
     */
    public function updateDeliveredAtDate(Order $order)
    {
        $order->update([
            'delivered_at' => Carbon::now() // waktu saat ini (sekarang)
        ]);

        return redirect()->route('admin.orders.index')->with([
            'success' => 'Order Berhasil Diedit' // pesan sukses
        ]);
    }

    /**
     * Menghapus data order dari database.
     * Biasanya dipanggil saat admin ingin menghapus order tertentu.
     */
    public function delete(Order $order)
    {
        $order->delete(); // hapus dari database
        return redirect()->route('admin.orders.index')->with([
            'success' => 'Order deleted successfully' // pesan sukses
        ]);
    }
}
