<?php

namespace App\Service;

use App\Entity\Post;
use App\Repository\PostRepository;
use App\Repository\TagRepository;
use App\Service\FileUploaderService;
use Doctrine\ORM\EntityManagerInterface;
use PhpParser\Node\Scalar\MagicConst\File;

class PostService
{
    private $duplicateService;
    private $fileUploaderService;
    private $entityManager;
    private $tagRepository;

    public function  __construct(DuplicateService $duplicateService,
                                 FileUploaderService $fileUploaderService,
                                 EntityManagerInterface $entityManager,
                                 TagRepository $tagRepository)
    {
        $this->duplicateService = $duplicateService;
        $this->fileUploaderService = $fileUploaderService;
        $this->entityManager = $entityManager;
        $this->tagRepository = $tagRepository;
    }
    public function addPost(Post $post,
                            $imgDirectory)
    {
        $post = $this->fileUploaderService->UploadFile($post, $imgDirectory);
        $this->duplicateService->checkExistingTags($post);
        $post->setPublishedAt(new \DateTime("now"));
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }
    public function  editPost(Post $post,
                              $imgDirectory)
    {
        $post = $this->fileUploaderService->UploadFile($post, $imgDirectory);
        $this->duplicateService->checkExistingTags($post);
        $post->setUpdatedDate(new \DateTime("now"));
        $this->entityManager->flush();
    }
}