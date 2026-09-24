<?php

namespace App\Services\System;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentHandlingService
{
    protected string $disk = 'local';
    protected ?string $directory = 'documents/';
    /**
     * method direct stream document
     * @param string $documentName
     * @param string $documentPath
     * @return \Illuminate\Http\Response 
     */
    public function directStreamDocument(string $documentName, string  $documentPath)
    {
        if (!Storage::disk($this->disk)->exists($documentPath)) {
            return abort(404, 'File not found');
        }

        $mime = Storage::mimeType($documentPath);

        return response()->stream(function () use ($documentPath) {
            echo Storage::disk($this->disk)
                ->get($documentPath);
        }, 200, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . $documentName . '"',
            'Cache-Control'       => 'private, max-age=3600',
        ]);
    }
    /**
     * method delete document
     */
    public function deleteDocument(string $documentPath): bool
    {
        if (Storage::disk($this->disk)->exists($documentPath)) {
            return Storage::disk($this->disk)->delete($documentPath);
        }

        return false;
    }
    /**
     * method upload document
     * @param \Illuminate\Http\UploadedFile $file
     * @return array 
     */
    public function uploadDocument($file, string $pathLocation)
    {
        $originalName = pathinfo(
            $file->getClientOriginalName() ?? Str::random(15),
            PATHINFO_FILENAME
        );
        $documentFinalPath = $this->directory . $pathLocation;
        $extension = $file->getClientOriginalExtension();
        // Replace space → dash
        $fileName = str_replace(' ', '-', $originalName);
        // Hapus karakter aneh
        $fileName = preg_replace('/[^A-Za-z0-9\-_]/', '', $fileName);
        // Normalize dash
        $fileName = preg_replace('/-+/', '-', $fileName);
        $timeStamp = date('Y-m-d');
        $fullName  = "{$timeStamp}-{$fileName}.{$extension}";

        try {
            $path = $file->storeAs(
                $documentFinalPath,
                $fullName,
                $this->disk
            );

            return [
                'success' => true,
                'message' => 'File uploaded successfully',
                'path' => $path,
                'document_name' => $fullName,
            ];
        } catch (\Throwable $th) {
            return [
                'success' => false,
                'message' => 'Upload failed: ' . $th->getMessage(),
                'path' => null,
                'document_name' => null,
            ];
        }
    }
    /**
     * method api stream document
     */
    public function apiStreamDocument(string $documentName, string $documentPath)
    {
        if (!Storage::disk($this->disk)->exists($documentPath)) {
            abort(404, 'File not found');
        }

        $mime = Storage::mimeType($documentPath);
        $stream = Storage::disk($this->disk)->readStream($documentPath);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $documentName . '"',
            'Cache-Control' => 'private, max-age=3600',
        ]);
    }

    public function downloadDocument(string $documentName, string $documentPath)
    {
        if (!Storage::disk($this->disk)->exists($documentPath)) {
            abort(404, 'File not found');
        }

        $mime = Storage::mimeType($documentPath);
        $stream = Storage::disk($this->disk)->readStream($documentPath);

        return response()->stream(function () use ($stream) {
            fpassthru($stream);
        }, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'attachment; filename="' . $documentName . '"',
        ]);
    }
    /**
     * method stream image private storage
     * @param string $imagePath
     * @return \Illuminate\Http\Response
     */
    public function streamImage(string $imagePath)
    {
        if (!Storage::disk($this->disk)->exists($imagePath)) {
            abort(404, 'Image not found');
        }

        $mime = Storage::mimeType($imagePath);

        // validasi hanya image
        if (!str_starts_with($mime, 'image/')) {
            abort(403, 'File is not an image');
        }

        $stream = Storage::disk($this->disk)
            ->readStream($imagePath);

        return response()->stream(function () use ($stream) {

            fpassthru($stream);

            if (is_resource($stream)) {
                fclose($stream);
            }
        }, 200, [
            'Content-Type' => $mime,

            // inline agar browser render image
            'Content-Disposition' => 'inline',

            // cache browser
            'Cache-Control' => 'public, max-age=86400',

            // optional security header
            'X-Content-Type-Options' => 'nosniff',
        ]);
    }

    public function directStreamPicture(string $picturePath, string $pictureName)
    {
        // Validasi ownership jika userId diberika

        if (!Storage::disk($this->disk)->exists($picturePath)) {
            return abort(404, 'File not found');
        }

        $mime = Storage::mimeType($picturePath);

        return response()->stream(function () use ($picturePath) {
            echo Storage::disk($this->disk)->get($picturePath);
        }, 200, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . $pictureName . '"',
            'Cache-Control'       => 'private, max-age=3600',
        ]);
    }
}
