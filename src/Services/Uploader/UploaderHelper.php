<?php


namespace App\Services\Uploader;


use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploaderHelper
{
    private $uploadsPath;

    public function __construct(string $uploadsPath)
    {

        $this->uploadsPath = $uploadsPath;
    }

    public function uploadFile(UploadedFile $uploadedFile, string $path) :string
    {
        $destination = $this->uploadsPath.$path;
        $originalFileName = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $newFileName = $originalFileName.'-'.uniqid().'.'.$uploadedFile->guessExtension();
        $uploadedFile->move(
            $destination,
            $newFileName
        );
        return $newFileName;
    }

    public function deleteUploadFile(Filesystem $fs, string $path, string $file)
    {
        $destination = $this->uploadsPath.$path.$file;
        $fs->remove([$destination]);
    }
}