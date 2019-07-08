<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Post;

class FileUploader
{
    public function UploadFile(Post $post, $imgDirectory) : Post
    {
        $file = $post->getImg();
        $fileName = $this->generateUniqueFileName() . '.' . $file->guessExtension();

        try {
            $file->move(
                $imgDirectory,
                $fileName
            );
        } catch (FileException $e) {

            // TODO: upload failed
        }
        $post->setImg($fileName);

        return $post;
    }

    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}