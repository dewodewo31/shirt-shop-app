<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Menampilkan semua produk di halaman admin (index).
     */
    public function index()
    {
        return view('admin.products.index')->with([
            'products' => Product::with(['colors', 'sizes'])->latest()->get()
        ]);
    }

    /**
     * Menampilkan form untuk menambahkan produk baru.
     */
    public function create()
    {
        $colors = Color::all(); // Mengambil semua data warna
        $sizes = Size::all();   // Mengambil semua data ukuran
        return view('admin.products.create')->with([
            'colors' => $colors,
            'sizes' => $sizes
        ]);
    }

    /**
     * Menyimpan produk baru ke database setelah validasi.
     */
    public function store(CreateProductRequest $request)
    {
        if ($request->validated()) {
            $data = $request->all();
            $data['thumbnail'] = $this->saveImage($request->file('thumbnail'));

            // Cek & simpan gambar opsional lainnya
            if ($request->has('first_image')) {
                $data['first_image'] = $this->saveImage($request->file('first_image'));
            }
            if ($request->has('second_image')) {
                $data['second_image'] = $this->saveImage($request->file('second_image'));
            }
            if ($request->has('third_image')) {
                $data['third_image'] = $this->saveImage($request->file('third_image'));
            }

            // Generate slug dari nama produk
            $data['slug'] = Str::slug($request->name);

            // Simpan data produk
            $product = Product::create($data);

            // Relasi many-to-many: warna & ukuran
            $product->colors()->sync($request->color_id);
            $product->sizes()->sync($request->size_id);

            return redirect()->route('admin.products.index')->with([
                'success' => 'Product has been added successfully'
            ]);
        }
    }

    /**
     * Menampilkan halaman 404 untuk show karena tidak digunakan.
     */
    public function show(Product $product)
    {
        abort(404);
    }

    /**
     * Menampilkan form edit produk.
     */
    public function edit(Product $product)
    {
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.products.edit')->with([
            'colors' => $colors,
            'sizes' => $sizes,
            'product' => $product
        ]);
    }

    /**
     * Mengupdate produk yang dipilih setelah validasi.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if ($request->validated()) {
            $data = $request->all();

            // Cek dan update thumbnail baru
            if ($request->has('thumbnail')) {
                $this->removeProductImageFromStorage($product->thumbnail);
                $data['thumbnail'] = $this->saveImage($request->file('thumbnail'));
            }

            // Cek dan update gambar opsional lainnya
            if ($request->has('first_image')) {
                $this->removeProductImageFromStorage($product->first_image);
                $data['first_image'] = $this->saveImage($request->file('first_image'));
            }
            if ($request->has('second_image')) {
                $this->removeProductImageFromStorage($product->second_image);
                $data['second_image'] = $this->saveImage($request->file('second_image'));
            }
            if ($request->has('third_image')) {
                $this->removeProductImageFromStorage($product->third_image);
                $data['third_image'] = $this->saveImage($request->file('third_image'));
            }

            // Update slug dan status
            $data['slug'] = Str::slug($request->name);
            $data['status'] = $request->status;

            // Update produk di database
            $product->update($data);

            // Update relasi warna & ukuran
            $product->colors()->sync($request->color_id);
            $product->sizes()->sync($request->size_id);

            return redirect()->route('admin.products.index')->with([
                'success' => 'Product has been updated successfully'
            ]);
        }
    }

    /**
     * Menghapus produk dan gambar-gambarnya dari penyimpanan.
     */
    public function destroy(Product $product)
    {
        $this->removeProductImageFromStorage($product->thumbnail);
        $this->removeProductImageFromStorage($product->first_image);
        $this->removeProductImageFromStorage($product->second_image);
        $this->removeProductImageFromStorage($product->third_image);

        $product->delete();

        return redirect()->route('admin.products.index')->with([
            'success' => 'Product has been deleted successfully'
        ]);
    }

    /**
     * Menyimpan file gambar ke dalam folder storage.
     */
    public function saveImage($file)
    {
        $image_name = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('images/products/', $image_name, 'public');
        return 'storage/images/products/' . $image_name;
    }

    /**
     * Menghapus file gambar dari folder storage.
     */
    public function removeProductImageFromStorage($file)
    {
        $path = public_path($file);
        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
