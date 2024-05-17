<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\Validator;


class Kondisi extends Controller
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


    public function indexkondisi(){
        $client = new Client();
        $url = "http://localhost:9097/api/kondisi/";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.kondisi.allkondisi', ['data' => $data]);
    }

    public function Storekondisi(Request $request){
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:9097/api/kondisi/";

        $parameters = [
            'name' => $request->name,
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

            return redirect()->route('adminallkondisi')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }


    }
    public function editkondisi(string $id){
        $client = new Client();
        $url = "http://localhost:9097/api/kondisi/$id";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];
        return view('admin.kondisi.editkondisi', ['data' => $data]);
    }

    public function updatekondisi(Request $request, string $id){
        $client = new Client();
        $url = "http://localhost:9097/api/kondisi/$id";

        $parameters = [
            'id' => (int) $id,
            'name' => $request->name,
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

            return redirect()->route('adminallkondisi')->with('success', 'Product added successfully!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }


    }

    public function Deletekondisi($id){
        $client = new Client();
        $url = "http://localhost:9097/api/kondisi/$id";
        $response = $client->request('DELETE', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
           return redirect()->route('adminallkondisi')->with('success', 'Berhasil melakukan hapus data');
    }

}
