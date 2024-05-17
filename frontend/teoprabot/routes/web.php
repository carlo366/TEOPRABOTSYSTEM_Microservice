a<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\galery;
use App\Http\Controllers\Admin\Kondisi;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\CartsController;
use App\Http\Controllers\Customer\CartsController as CustomerCartsController;
use App\Http\Controllers\Customer\HomeController;
use App\Http\Controllers\DependantDropdownController;
use App\Http\Controllers\galery as ControllersGalery;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\galeryController;
use App\Models\Products;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::middleware(['auth', 'role:costumer', 'verified'])->group(function () {
    Route::controller(HomeController::class)->group(function(){
        Route::get('/', 'dashboard')->name('dashboard');
        Route::get('/produk-detil/{id}', 'ProdukDetil')->name('produkdetail');
        Route::post('/add-product-to-cart','AddProductToCart')->name('addproducttocart');
        Route::post('/addslider','addslider')->name('addslider');
        Route::post('/jual', 'tambahjual')->name('tambahjual');
        Route::get('/jual', 'jual')->name('jual');
    });
    Route::controller(CustomerCartsController::class)->group(function(){
        Route::get('/keranjang','keranjang')->name('keranjang');
        Route::get('/checkout','checkout')->name('checkout');
        Route::get('/checkout','Checkout')->name('checkout');
        Route::get('/deletecart/{id}','deletecart')->name('deletecart');
    });
// });

Route::controller(ControllersGalery::class)->group(function(){
    Route::get('/galery','galery')->name('galery');
});




// Route::middleware(['auth','role:admin','verified'])->group(function () {
    Route::get('/dasboard-admin',function () {

        return view('admin.dasboard');
    })->name('admindasboard');
    Route::get('admin/semua-produk',function(){
        return view('admin.produk.allproduk');
    })->name('adminallproduk');
    Route::controller(CategoryController::class)->group(function(){
        Route::get('admin/semua-kategori','index')->name('adminallkategori');
        Route::post('admin/store-kategori','StoreKategori')->name('storekategori');
        Route::get('admin/delete-kategori/{id_categories}','DeleteCategory')->name('deletecategori');
        Route::post('admin/update-kategori','UpdateCategory')->name('updatecategory');
        Route::get('admin/edit-kategori/{id_categories}','EditCategory')->name('editcategory');
        Route::post('admin/update-kategori/{id}','UpdateCategory')->name('updatecategory');



        Route::get('admin/semua-faq','indexfaq')->name('adminallfaq');
        Route::post('admin/store-faq','Storefaq')->name('storefaq');
        Route::get('admin/delete-faq/{id}','Deletefaq')->name('deletefaq');
        Route::get('admin/edit-faq/{id}','Editfaq')->name('editfaq');
        Route::post('admin/update-faq/{id}','Updatefaq')->name('updatefaq');

    });

    Route::controller(ProductsController::class)->group(function(){
        Route::get('admin/semua-produk','index')->name('adminallproduk');
        Route::get('admin/tambah_gambar/{id_product}/kirim','indexgambar')->name('indexgambar');
        Route::post('admin/tambah_gambar/{id_product}/kirim','StoreGambar')->name('storegambar');
        Route::get('/admin/delete/{images_id}/hapus','HapusGambar')->name('hapusgambar');
        Route::get('admin/edit-produk{id}','EditProduk')->name('editproduk');
        Route::post('admin/tambah-produk','StoreProduct')->name('storeproduk');
        Route::post('admin/update-prodcut/{id}','UpdateProduk')->name('updateProduk');
        Route::get('admin/delete-produk/{id}','DeleteProduk')->name('deleteproduct');
        Route::get('admin/semuaslider', 'slider')->name('slider');
        Route::post('admin/addsemuaslider', 'addslider')->name('addslider');
        Route::get('admin/delete-slider/{id}','Deleteslider')->name('deleteslider');
        Route::get('admin/edit-slider/{id}','EditSlider')->name('editSlider');
        Route::post('admin/update-slider/{id}','UpdateSlider')->name('updateSlider');


    });

    Route::controller(Kondisi::class)->group(function(){
        Route::get('admin/semua-kondisi','indexkondisi')->name('adminallkondisi');
        Route::post('admin/store-kondisi','Storekondisi')->name('storekondisi');
        Route::get('admin/delete-kondisi/{id}','Deletekondisi')->name('deletekondisi');
        Route::get('admin/edit-kondisi/{id}','Editkondisi')->name('editkondisi');
        Route::post('admin/update-kondisi/{id}','Updatekondisi')->name('updatekondisi');


    });

// });


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::controller(DependantDropdownController::class)->group(function(){
Route::get('/provinces', 'provinces')->name('provinces');
Route::get('/cities', 'cities')->name('cities');
Route::get('/districts', 'districts')->name('districts');
Route::get('/villages', 'villages')->name('villages');
Route::get('/dependent-dropdown','index')->name('dependent.dropdown.index');

});
require __DIR__.'/auth.php';
