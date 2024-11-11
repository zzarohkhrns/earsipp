<?php

// app/Services/GoogleDriveService.php
namespace App\Services;

use Google\Client;
use Google\Service\Drive;

class GoogleDriveService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google/meta-yen-441002-m9-f04ed1a88012.json'));
        $this->client->addScope(Drive::DRIVE);
    }

    public function uploadFile($filePath, $fileName)
    {
        $driveService = new Drive($this->client);

        $file = new Drive\DriveFile();
        $file->setName($fileName);

        $result = $driveService->files->create($file, [
            'data' => file_get_contents($filePath),
            'mimeType' => mime_content_type($filePath),
            'uploadType' => 'multipart'
        ]);

         // Setelah upload berhasil, atur permission untuk file agar dapat diakses publik
        $permission = new Drive\Permission();
        $permission->setType('anyone');
        $permission->setRole('reader');
        // $permission->setEmailAddress('rayhanaf230905@gmail.com');
        $driveService->permissions->create($result->getId(), $permission);

        // Mengambil link file yang dapat diakses publik
        $fileId = $result->getId();
        $driveFileLink = "https://drive.google.com/file/d/$fileId/view";

        return $driveFileLink;
    }
}
