<?php

namespace App\Service;

use App\Entity\Post;
use App\Entity\User;
use App\Repository\Interfaces\PostRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;

class PostService
{
    private $duplicateService;
    private $fileUploaderService;
    private $postRepository;


    public function  __construct(DuplicateService $duplicateService,
                                 FileUploaderService $fileUploaderService,
                                 PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
        $this->duplicateService = $duplicateService;
        $this->fileUploaderService = $fileUploaderService;
    }

    public function addPost(Post $post,
                            $imgDirectory, User $user)
    {
        $post = $this->fileUploaderService->UploadFile($post, $imgDirectory);
        $this->duplicateService->checkExistingTags($post);
        $post->setPublishedAt(new \DateTime("now"));
        $post->setUser($user);
        $this->postRepository->save($post);
    }

    public function updatePost(Post $post,
                               $imgDirectory)
    {
        $post = $this->fileUploaderService->UploadFile($post, $imgDirectory);
        $this->duplicateService->checkExistingTags($post);
        $post->setUpdatedDate(new \DateTime("now"));
        $this->postRepository->save($post);
    }

    public function deletePost(Post $post)
    {
        $this->postRepository->delete($post);
    }

    public function getAllPosts()
    {
        return $this->postRepository->findAllByPublishedDate();
    }

    public function getPost($id)
    {
        return $this->postRepository->find($id);
    }

    public function getPostsByUserId($id)
    {
        return $this->postRepository->findByUser($id);
    }
}