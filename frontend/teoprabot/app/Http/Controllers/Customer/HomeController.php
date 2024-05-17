<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Carts;
use App\Models\Images_Products;
use App\Models\Products;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    protected $apiUrl;
    private $messages;
    private $client;

    public function __construct()
    {
        // Tentukan URL API Go CRUD
        $this->apiUrl = 'http://localhost:9090/api/categories'; // Ganti dengan URL API Go Anda

        // Initialize $this->messages with an array of validation messages
        $this->messages = [
            'required' => 'The :attribute field is required.',
            'image' => 'The :attribute must be an image.',
            'mimes' => 'The :attribute must be a file of type: :values.',
            'max' => 'The :attribute may not be greater than :max kilobytes.',
        ];

        // Initialize the Guzzle client
        $this->client = new Client();
    }

    private function setMeta(string $title)
    {
        SEOMeta::setTitle($title);
        OpenGraph::setTitle(SEOMeta::getTitle());
        JsonLd::setTitle(SEOMeta::getTitle());
    }
    // public function dashboard(){
    //     $products = Products::latest()->get();

    //     // Ambil gambar pertama untuk setiap produk
    //     foreach ($products as $product) {
    //         // Ambil gambar pertama yang terkait dengan produk ini, jika ada
    //         $image = Images_Products::where('product_id', $product->id_products)->first();
    //         // Gunakan path gambar atau placeholder tergantung pada keberadaan gambar
    //         $product->image = $image ? asset('uploads/products/' . $image->image) : asset('placeholder-image.jpg');
    //     }

    //     // Kirim data produk dan gambar ke tampilan
    //     return view('costumers.dasboard', compact('products', 'image'));
    // }

    public function dashboard(){

    $client = new Client();

        $urlProduct = "http://192.168.20.71:8081/api/products/";
        $responseProduct = $client->request('GET', $urlProduct);
        $content = $responseProduct->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $products = $contentArray['data'];


    $url = "http://localhost:9090/api/categories/";
    $response = $client->request('GET', $url);
    $content = $response->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $data = $contentArray['data'];


    $urlimagep = "http://localhost:9091/api/imagep/";
    $responseimagep = $client->request('GET', $urlimagep);
    $content = $responseimagep->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $images = $contentArray['data'];


    $client = new Client();
    $url = "http://localhost:9093/api/faq/";
    $response = $client->request('GET', $url);
    $content = $response->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $datafaq = $contentArray['data'];

    foreach ($products as &$product) {
        $product['image'] = null;
        foreach ($images as $image) {
            if ($image['product_id'] == $product['ID']) {
                $product['image'] = $image['image'];
                break; // Stop after finding the first image
            }
        }
    }


    $urlislider = "http://localhost:9092/api/slider/";
    $responseislider = $client->request('GET', $urlislider);
    $content = $responseislider->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $slider = $contentArray['data'];


    return view('costumers.dasboard', [
        'products' => $products,
        'data' =>  $data,
        'slider' => $slider,
        // 'imagep' => $imagep
        'datafaq' => $datafaq
    ]);
    }



public function ProdukDetil(string $id) {
 $client = new Client();

    // Fetch product details
    $url = "http://localhost:8081/api/products/$id";
    $response = $client->request('GET', $url);
    $content = $response->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $product_detil = $contentArray['data'];

    $url = "http://localhost:9090/api/categories/";
    $response = $client->request('GET', $url);
    $content = $response->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $data = $contentArray['data'];

    // Fetch all images
    $url = "http://localhost:9091/api/imagep/";
    $response = $client->request('GET', $url);
    $content = $response->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $allProductImages = $contentArray['data'];

    $productImages = array_filter($allProductImages, function ($image) use ($id) {
        return $image['product_id'] == $id;
    });

    return view('costumers.product_detail',[
    'product_detil' => $product_detil,
    'productImages' => $productImages,
'data' => $data]);
}


public function AddProductToCart(Request $request)
{
    $client = new Client();
    $url = "http://localhost:8082/api/carts";

    $user_id = Auth::id();
    $product_id = (int) $request->product_id;

    $parameters = [
        'product_id' => $product_id,
        'quantity' => (int) $request->quantity,
        'price' => (int) $request->price,
        'user_id' => (int) $user_id,
    ];

    // Log the parameters for debugging

    try {
        $response = $client->request('POST', $url, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($parameters)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if (isset($contentArray['status']) && $contentArray['status'] == false) {
            return redirect()->back()->with('error', $contentArray['message']);
        }

        return redirect()->back()->with('message', 'Product added to cart successfully!');
    } catch (\Exception $e) {
        // Log the error message for debugging
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}
    public function jual(){
        $client = new Client();
        $url = "http://localhost:9097/api/kondisi/";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        $url = "http://192.168.20.71:9090/api/categories/";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $categories = $contentArray['data'];



        return view('costumers.jual',['data' => $data, 'categories' => $categories]);
    }


    public function tambahjual(Request $request){
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:8089/api/juals";

        $user_id = Auth::id();
        $image = $request->file('image');


        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads/jual'), $imageName);


        $parameters = [
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => (int)$request->category_id,
            'saran_price' => (int)$request->saran_price,
            'kondisi_id' => (int)$request->kondisi_id,
            'user_id' => (int) $user_id,
            'image' => $imageName
        ];



        try {
            $response = $client->request('POST', $url, [
                'headers' => ['Content-Type' => 'application/json'],
                'body' => json_encode($parameters)
            ]);

            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);


            if (isset($contentArray['status']) && $contentArray['status'] == false) {
                return redirect()->back()->with('error', $contentArray['message']);
            }

            return redirect()->route('jual')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}

