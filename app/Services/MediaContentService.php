<?php
/**
 * Created by PhpStorm.
 * User: snusnumr1996
 * Date: 20.12.19
 * Time: 15:23
 */

namespace App\Services;

use App\Http\Requests\DocumentUploadRequest;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Storage;

/** Сервис-класс для работы с медиа-контентом */
class MediaContentService
{
    private $file_name, $tmp_path;

    public function upload(DocumentUploadRequest $request)
    {
        $doc = $request->file('file');

        $this->file_name = $doc->getClientOriginalName();
        $this->tmp_path = '/public/docs/tmp/';

        if (! Storage::disk('local')->exists($this->tmp_path . $this->file_name)) {
           $url = Storage::disk('local')->put($this->tmp_path, $doc);
        }

        return response()->json([
            'url' => $url
        ]);
    }

    public function move(string $url)
    {
        try {
            $destination = str_replace('/public', '/', str_replace('/tmp/', '', $url));

            if (! Storage::exists($url)) {
                throw new \Exception('Файл не найден');
            }

            if (! Storage::move($url, $destination)) {
                throw new \Exception('Перемещение файла завершилось ошибкой');
            }

            return $destination;
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'msg' => $error->getMessage()
            ]);
        }
    }

    public function remove(string $url) {
        if (! Storage::exists($url)) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Файл не найден'
            ]);
        }

        Storage::delete($url);
    }

    public function download(string $url)
    {
        try {
            if (! Storage::disk('local')->exists($url)) {
                throw new \Exception('Файл не найден!');
            }

            return Storage::disk('local')->download($url);
        } catch (\Exception $error) {
            return response()->json([
                'status' => 'error',
                'msg' => $error->getMessage()
            ], 500);
        }
    }
}