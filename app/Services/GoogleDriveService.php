<?php

// app/Services/GoogleDriveService.php
namespace App\Services;

use Google\Client;
use Google\Service\Drive;

class GoogleDriveService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google/earsip-dokumen-aa9a4a8a683f.json'));
        $this->client->addScope(Drive::DRIVE);
        $this->service = new Drive($this->client);
    }

    public function uploadFile($filePath, $fileName, $folderId = null)
    {
        $driveService = new Drive($this->client);

        $file = new Drive\DriveFile();
        $file->setName($fileName);

        // Tambahkan folder sebagai parent jika diberikan
        if ($folderId) {
            $file->setParents([$folderId]);
        }

        $result = $driveService->files->create($file, [
            'data' => file_get_contents($filePath),
            'mimeType' => mime_content_type($filePath),
            'uploadType' => 'multipart'
        ]);

        // Setelah upload berhasil, atur permission untuk file agar dapat diakses publik
        $permission = new Drive\Permission();
        $permission->setType('anyone');
        $permission->setRole('reader');
        $driveService->permissions->create($result->getId(), $permission);

        // Mengambil link file yang dapat diakses publik
        $fileId = $result->getId();
        $driveFileLink = "https://drive.google.com/file/d/$fileId/view";

        return $driveFileLink;
    }

    // Hapus file di Google Drive menggunakan file ID
    public function deleteFile($fileId)
    {
        try {
            $this->service->files->delete($fileId);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    // /**
    //  * Extract Google Drive File ID from the provided URL.
    //  *
    //  * @param string $url
    //  * @return string|null
    //  */
    // private function getGoogleDriveFileId($url)
    // {
    //     preg_match('/id=([^&]+)/', $url, $matches);
    //     return $matches[1] ?? null;
    // }

}

