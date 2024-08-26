<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;
use GuzzleHttp\Client;
class ImageTextController extends Controller
{
    protected $geminiService;
    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }
    public function extractText(Request $request)
    {
        $request->validate([
            'image' => 'required|image',
            'prompt' => 'required|string'
        ]);
        $path = $request->file('image')->store('uploads', 'public');
        $prompt = $request->input('prompt');
        $text = (new TesseractOCR(storage_path('app/public/' . $path)))
            ->lang('ara', 'eng')
            ->run();
        $textJson = $this->geminiService->generateText($text, $prompt);
        return $textJson;
    }
}


class GeminiService
{
    protected $client;
    protected $apiKey;
    protected $endpoint;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = 'AIzaSyBgclojwVJJL-RXhzK8_oWMMsjsXWG-Ld8';
        $this->endpoint = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key=AIzaSyBgclojwVJJL-RXhzK8_oWMMsjsXWG-Ld8';


    }

    public function generateText($text, $prompt)
    {

        try {
            $response = $this->client->request('POST', $this->endpoint, [
                'headers' => [

                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => 'Extract the ' . $prompt . ' From the following text and replay the output in  format json remove Json word : ' . $text
                                ]
                            ]
                        ]
                    ]
                ]
            ]);

            $body = $response->getBody();
            $data = json_decode($body, true);
            return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'No response text found.';
        } catch (\Exception $e) {
            return 'API request failed: ' . $e->getMessage();
        }
    }
}