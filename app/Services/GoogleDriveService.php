<?php

namespace App\Services;

use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class GoogleDriveService
{
    protected $client;
    protected $service;

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig(storage_path('app/credentials/google-drive.json')); // tempat file credentials
        $this->client->addScope(Google_Service_Drive::DRIVE_FILE); // akses terbatas: hanya file yang dibuat oleh app
        $this->service = new Google_Service_Drive($this->client);
    }

    public function uploadFile($localPath, $fileName, $mimeType = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $folderId = null)
    {
        $fileMetadata = new Google_Service_Drive_DriveFile([
            'name' => $fileName,
            'mimeType' => 'application/vnd.google-apps.spreadsheet',
            'parents' => $folderId ? [$folderId] : null,
        ]);

        // dd($localPath);

        $content = file_get_contents($localPath);

        $file = $this->service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id, name, webViewLink'
        ]);

        return $file;
    }

    public function setFilePermission($fileId, $email)
    {
        $permission = new \Google_Service_Drive_Permission([
            'type' => 'anyone',         // Bisa juga 'anyone' untuk publik
            'role' => 'writer',       // 'reader', 'writer', 'commenter'
            // 'emailAddress' => 'mluqnibaehaqi@gmail.com'
        ]);

        return $this->service->permissions->create(
            $fileId,
            $permission,
            ['sendNotificationEmail' => false] // false = jangan kirim email ke user
        );
    }
}
