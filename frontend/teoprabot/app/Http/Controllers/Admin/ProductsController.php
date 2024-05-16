<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Images_Products;
use App\Models\Products;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ProductsController extends Controller
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

    public function slider(){
        $client = new Client();

        $urlislider = "http://localhost:9092/api/slider/";
        $responseislider = $client->request('GET', $urlislider);
        $content = $responseislider->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $slider = $contentArray['data'];

        return view('admin.slider.allslider',['slider' => $slider]);
    }

    public function index()
    {
        $client = new Client();

        $url = "http://localhost:9090/api/categories/";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        // Panggil API produk
        $urlProduct = "http://localhost:8081/api/products/";
        $responseProduct = $client->get($urlProduct);
        $products = json_decode($responseProduct->getBody()->getContents(), true);


        return view('admin.produk.allproduk', [
            'data' =>  $data,
            'products' => $products,
        ]);
    }
    public function addSlider(Request $request) {
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:9092/api/slider";

        try {
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'name' => $request->input('name'),
                    'image' => $request->input('image')
                ]
            ]);

            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);

            return redirect()->route('slider')->with('success', 'Berhasil menambah data slider');
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $response = $e->getResponse();
            $responseBodyAsString = $response->getBody()->getContents();
            $responseArray = json_decode($responseBodyAsString, true);

            if ($response->getStatusCode() == 400 && isset($responseArray['message'])) {
                return redirect()->route('slider')->with('error', 'Gagal menambah slider melebihin batas maimum (3): ' . $responseArray['message']);
            }

            return redirect()->route('slider')->with('error', 'Gagal menambah slider: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('slider')->with('error', 'Gagal menambah slider: ' . $e->getMessage());
        }
    }


    public function editSlider(string $id){
        $client = new Client();
        $url = "http://localhost:9092/api/slider/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.slider.editslider', ['data' => $data]);
    }


  public function HapusGambar($id_images)
  {
      $product_image = Images_Products::where('images_id', $id_images)->firstOrFail();
      $product_image->delete();
      return redirect()->back()->with('status', 'Hapus Kategori Berhasil');
  }

    public function Deleteslider($id){
        $client = new Client();
        $url = "http://localhost:9092/api/slider/$id";
        try {
            $response = $client->request('DELETE', $url);
            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);

            return redirect()->route('slider')->with('success', 'Berhasil melakukan hapus data');
        } catch (\Exception $e) {
            return redirect()->route('slider')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

  public function EditProduk( string $id){
    $client = new Client();


    $url = "http://localhost:9090/api/categories/";
    $response = $client->request('GET', $url);
    $content = $response->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $categories = $contentArray['data'];


    $url = "http://localhost:8081/api/products/$id";
    $response = $client->request('GET', $url);
    $content = $response->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $data = $contentArray['data'];

    return view('admin.produk.tambahproduk', ['data' => $data,
'categories' => $categories]);
  }


  public function indexgambar(string $id) {
    $client = new Client();

    // Fetch product details
    $url = "http://localhost:8081/api/products/$id";
    $response = $client->request('GET', $url);
    $content = $response->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $product = $contentArray['data'];

    // Fetch all images
    $url = "http://localhost:9091/api/imagep/";
    $response = $client->request('GET', $url);
    $content = $response->getBody()->getContents();
    $contentArray = json_decode($content, true);
    $allProductImages = $contentArray['data'];

    // Filter images by product ID
    $productImages = array_filter($allProductImages, function ($image) use ($id) {
        return $image['product_id'] == $id;
    });

    return view('admin.produk.imageproduk.semuagambar', [
        'product' => $product,
        'productImages' => $productImages
    ]);
}



  public function UpdateProduk(Request $request, string $id){
    $client = new Client();
    $url = "http://localhost:8081/api/products/{$id}"; // Perhatikan penempatan ID di URL

    $parameters = [
        'name' => $request->name,
        'description' => $request->description,
        'category_id' => (int) $request->category_id,
        'price' => (float) $request->price,
        'quantity' => (int) $request->quantity,
        'length' => (float) $request->length,
        'width' => (float) $request->width,
        'color' => $request->color,
    ];

    try {
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($parameters)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if (isset($contentArray['status']) && $contentArray['status'] == false) {
            return redirect()->back()->with('error', $contentArray['message']);
        }

        return redirect()->route('adminallproduk')->with('success', 'Product updated successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }

  }
  public function StoreGambar(Request $request)
  {
      $product_id = (int) $request->product_id; // Ensure product_id is an integer

      // Validate if image was uploaded
      if (!$request->hasFile('image')) {
          return redirect()->back()->with('error', 'No image was uploaded.');
      }

      try {
          $image = $request->file('image');
          $imageName = time() . '_' . $image->getClientOriginalName();
          $image->move(public_path('uploads/product'), $imageName);

          $parameters = [
              'product_id' => $product_id, // Corrected parameter key
              'image' => $imageName
          ];

          $client = new Client();
          $url = "http://localhost:9091/api/imagep/";

          $response = $client->request('POST', $url, [
              'headers' => ['Content-Type' => 'application/json'],
              'body' => json_encode($parameters) // Ensure parameters are encoded correctly
          ]);

          $content = $response->getBody()->getContents();
          $contentArray = json_decode($content, true);

          if (isset($contentArray['status']) && $contentArray['status'] == false) {
              return redirect()->back()->with('error', $contentArray['message']);
          }

          return redirect()->route('adminallkategori')->with('message', 'Image uploaded successfully!');
      } catch (\Exception $e) {
          return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
      }
  }






  public function StoreProduct(Request $request)
{
    $client = new \GuzzleHttp\Client();
    $url = "http://localhost:8081/api/products/";

    $parameters = [
        'name' => $request->name,
        'description' => $request->description,
        'category_id' => (int)$request->category_id,
        'price' => (float)$request->price,
        'quantity' => (int)$request->quantity,
        'length' => (float)$request->length,
        'width' => (float)$request->width,
        'color' => $request->color,
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

        return redirect()->route('adminallproduk')->with('success', 'Product added successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}

public function DeleteProduk($id){
    $client = new Client();
    $url = "http://localhost:8081/api/products/$id";

    try {
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        return redirect()->route('adminallproduk')->with('success', 'Berhasil melakukan hapus data');
    } catch (\Exception $e) {
        return redirect()->route('adminallproduk')->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}
}
