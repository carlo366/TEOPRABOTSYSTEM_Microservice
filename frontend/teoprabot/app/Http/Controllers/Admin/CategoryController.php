<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;


class CategoryController extends Controller
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


    public function index()
    {
        $client = new Client();
        $url = "http://localhost:9090/api/categories/";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.categori.allcategori', ['data' => $data]);

    }


    public function storeKategori(Request $request)
    {
        $name = $request->name;
        $image = $request->file('image');

        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('uploads/category'), $imageName);

        $paramater = [
            'name' => $name,
            'image' => $imageName
          ];


        $client = new Client();
        $url = "http://localhost:9090/api/categories/";
        $response = $client->request('POST', $url, [
           'headers' => ['Content-Type' => 'application/json'],
           'body' => json_encode($paramater)
        ]);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if (isset($contentArray['status']) && $contentArray['status'] == false) {
            return redirect()->back()->with('error', $contentArray['message']);
        }

        $data = $contentArray['data'];

        return redirect()->route('adminallkategori')->with('message', 'Tambah Kategori Berhasil');
    }

    public function deleteCategory($id)
    {
     $client = new Client();
     $url = "http://localhost:9090/api/categories/$id";
     $response = $client->request('DELETE', $url);
     $content = $response->getBody()->getContents();
     $contentArray = json_decode($content, true);
     return redirect()->route('adminallfaq')->with('success', 'Berhasil melakukan hapus data');
    }
    public function EditCategory( string $id){
        $client = new Client();
        $url = "http://localhost:9090/api/categories/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.categori.editcategori', ['data' => $data]);
    }

    public function UpdateCategory(Request $request, string $id){
        $name = $request->name;
        $image = $request->file('image');
        $imageName = $request->old_image;

        // Jika ada gambar baru yang diunggah, gunakan gambar baru
        if ($image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/category'), $imageName);
        }

        // Persiapkan parameter untuk dikirim ke API
        $parameter = [
            'id' => (int) $id, // Konversi id ke tipe integer untuk mencocokkan dengan tipe uint64 di Golang
            'name' => $name,
            'image' => $imageName,
        ];

        // Mengirim request ke API
        $client = new Client();
        $url = "http://localhost:9090/api/categories/$id";
        $response = $client->request('PUT', $url, [
            'headers' => ['Content-Type' => 'application/json'],
            'body' => json_encode($parameter)
        ]);

        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);

        if ($contentArray['status'] != true) {
            $error = $contentArray['data'];
            return redirect()->route('adminallkategori')->withErrors($error)->withInput();
        } else {
            return redirect()->route('adminallkategori')->with('message', 'Kategori berhasil diperbarui!');
        }
    }

    public function indexfaq(){
        $client = new Client();
        $url = "http://localhost:9093/api/faq/";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.faq.allfaq', ['data' => $data]);
    }

    public function Storefaq(Request $request){
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:9093/api/faq/";

        $parameters = [
            'name' => $request->name,
            'description' => $request->description,
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

            return redirect()->route('adminallfaq')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }


    }
    public function editfaq(string $id){
        $client = new Client();
        $url = "http://localhost:9093/api/faq/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.faq.editfaq', ['data' => $data]);
    }

    public function updatefaq(Request $request, string $id){
        $client = new Client();
        $url = "http://localhost:9093/api/faq/$id";

        $parameters = [
            'id' => (int) $id,
            'name' => $request->name,
            'description' => $request->description,
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

            return redirect()->route('adminallfaq')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }


    }

    public function Deletefaq($id){
        $client = new Client();
        $url = "http://localhost:9093/api/faq/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
           return redirect()->route('adminallfaq')->with('success', 'Berhasil melakukan hapus data');
    }


}
