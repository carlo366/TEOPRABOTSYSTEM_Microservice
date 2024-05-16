<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    public function keranjang()
    {
        $client = new Client();
        $user_id = Auth::id(); // Assuming the user is authenticated and you are using Laravel's auth system
        $url = "http://localhost:8082/api/carts?user_id={$user_id}";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);



        // Assuming the data is in 'data' key
        $carts = $contentArray['data'];

        $url = "http://localhost:8081/api/products/";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $product_detil = $contentArray['data'];


        return view('costumers.cart', ['carts' => $carts,
    'product_detil' => $product_detil]);
    }


    public function deletecart($id){
        $client = new Client();
        $url = "http://localhost:8082/api/carts/$id";

        try {
            $response = $client->request('DELETE', $url);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);

            return redirect()->route('keranjang')->with('success', 'Berhasil melakukan hapus data');
        } catch (\Exception $e) {
            return redirect()->route('keranjang')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
