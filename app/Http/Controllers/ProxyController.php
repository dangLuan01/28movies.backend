<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProxyController extends Controller
{
    function proxy(Request $request) {
        $file_id = $request->query('id');

        if (!preg_match('/^[A-Za-z0-9_-]+$/', $file_id)) {
            abort(400, 'Invalid file ID');
        }

        $url = "https://drive.google.com/uc?id={$file_id}";

        // Giới hạn dung lượng (1MB)
        $maxSize = 1 * 1024 * 1024;

        // 2️⃣ GET và stream file nếu đạt yêu cầu
        $response = Http::withOptions(['stream' => true])->get($url);

        if ($response->failed()) {
            abort(404, 'File not found');
        }

        $body = $response->toPsrResponse()->getBody();
        $size = 0;
    
        return response()->stream(function () use ($body, $maxSize, &$size) {
            while (!$body->eof()) {
                $chunk = $body->read(8192); // đọc 8KB mỗi lần
                $size += strlen($chunk);

                if ($size > $maxSize) {
                    exit; // Dừng ngay nếu vượt giới hạn khi đang stream
                }

                echo $chunk;
                flush();
            }
        }, 200, [
            'Content-Type' =>  'application/vnd.apple.mpegurl',
            'Access-Control-Allow-Origin' => '*',
        ]);
    }

    function proxys(Request $request) {
        $url = $request->query('url');
        if (!$url) {
            return response('Missing url', 400);
        }

        $url = urldecode($url);
        $url = str_replace(' ', '+', $url);

        // Giới hạn dung lượng 10MB
        $MAX_SIZE = 10 * 1024 * 1024; // 10MB

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/139.0.0.0 Safari/537.36',
            'Referer'    => 'https://goatembed.com/',
            'Origin'     => 'https://goatembed.com',
            'Accept'     => '*/*',
        ])->withOptions(['stream' => true])->get($url);

        $bodyStream = $response->toPsrResponse()->getBody();

        $data = '';
        $downloaded = 0;

        while (!$bodyStream->eof()) {
            $chunk = $bodyStream->read(8192); // đọc từng chunk ~8KB
            $downloaded += strlen($chunk);

            if ($downloaded > $MAX_SIZE) {
                return response('File too large (limit 10MB)', 413);
            }
            $data .= $chunk;
        }

        return response($data, $response->status())
            ->withHeaders([
                'Content-Type' => $response->header('Content-Type', 'application/octet-stream'),
                'Access-Control-Allow-Origin' => 'https://www.xoailac.top',
        ]);
    }
}
