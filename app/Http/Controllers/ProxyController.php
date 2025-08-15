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
}
