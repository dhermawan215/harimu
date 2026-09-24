<?php

namespace App\Services\System;

use getID3;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MusicHandlingService
{
    protected string $disk = 'local';
    protected ?string $directory = 'musics/';

    /**
     * method upload music
     * @param \Illuminate\Http\UploadedFile $file
     * @return array
     */
    public function uploadMusic($file, string $pathLocation = '')
    {
        $originalName = pathinfo(
            $file->getClientOriginalName() ?? Str::random(15),
            PATHINFO_FILENAME
        );
        $musicFinalPath = rtrim($this->directory . $pathLocation, '/');
        $extension = $file->getClientOriginalExtension();
        // Replace space → dash
        $fileName = str_replace(' ', '-', $originalName);
        // Hapus karakter aneh
        $fileName = preg_replace('/[^A-Za-z0-9\-_]/', '', $fileName);
        // Normalize dash
        $fileName = preg_replace('/-+/', '-', $fileName);
        $timeStamp = date('Y-m-d');
        $fullName = "{$timeStamp}-{$fileName}-" . Str::random(6) . ".{$extension}";

        try {
            $path = $file->storeAs(
                $musicFinalPath,
                $fullName,
                $this->disk
            );

            return [
                'success' => true,
                'message' => 'File uploaded successfully',
                'path' => $path,
                'music_name' => $fullName,
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Upload failed: ' . $th->getMessage(),
                'path' => null,
                'music_name' => null,
            ];
        }
    }

    /**
     * method read the audio duration (in whole seconds) directly from the file's metadata
     * @param string $musicPath
     * @return int|null
     */
    public function getDuration(string $musicPath): ?int
    {
        $disk = Storage::disk($this->disk);

        if (!$disk->exists($musicPath)) {
            return null;
        }

        $getID3 = new getID3();
        $info = $getID3->analyze($disk->path($musicPath));

        if (empty($info['playtime_seconds'])) {
            return null;
        }

        return (int) round($info['playtime_seconds']);
    }

    /**
     * method delete music
     */
    public function deleteMusic(string $musicPath): bool
    {
        if (Storage::disk($this->disk)->exists($musicPath)) {
            return Storage::disk($this->disk)->delete($musicPath);
        }

        return false;
    }

    /**
     * method stream music with HTTP Range support, so <audio> players can seek
     * and don't need to buffer the whole file before playing.
     * @param string $musicName
     * @param string $musicPath
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function streamMusic(string $musicName, string $musicPath)
    {
        $disk = Storage::disk($this->disk);

        if (!$disk->exists($musicPath)) {
            abort(404, 'File not found');
        }

        $absolutePath = $disk->path($musicPath);
        $mime = Storage::mimeType($musicPath) ?: 'application/octet-stream';
        $size = $disk->size($musicPath);

        $start = 0;
        $end = $size - 1;
        $status = 200;
        $headers = [
            'Content-Type' => $mime,
            'Accept-Ranges' => 'bytes',
            'Content-Disposition' => 'inline; filename="' . $musicName . '"',
            'Cache-Control' => 'private, max-age=3600',
        ];

        $range = request()->header('Range');

        if ($range && preg_match('/bytes=(\d*)-(\d*)/', $range, $matches)) {
            $start = $matches[1] === '' ? $start : (int) $matches[1];
            $end = $matches[2] === '' ? $end : (int) $matches[2];
            $end = min($end, $size - 1);

            if ($start > $end || $start >= $size) {
                return response('', 416, [
                    'Content-Range' => "bytes */{$size}",
                ]);
            }

            $status = 206;
            $headers['Content-Range'] = "bytes {$start}-{$end}/{$size}";
        }

        $length = $end - $start + 1;
        $headers['Content-Length'] = $length;

        return response()->stream(function () use ($absolutePath, $start, $length) {
            $stream = fopen($absolutePath, 'rb');
            fseek($stream, $start);
            $remaining = $length;
            $chunkSize = 8192;

            while (!feof($stream) && $remaining > 0) {
                $read = min($chunkSize, $remaining);
                echo fread($stream, $read);
                $remaining -= $read;
                flush();
            }

            fclose($stream);
        }, $status, $headers);
    }
}
