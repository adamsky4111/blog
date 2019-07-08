<?php

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\Entity\Post;

class DuplicateService
{
    private $tagRepository;

    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    public function checkExistingTags(Post $post) : Post
    {
            $tags = $this->tagRepository->findAll();

            foreach ($post->getTags() as $tag)
            {
                foreach ($tags as $existingTag)
                    if($tag->getName() == $existingTag->getName())
                        $post->getTags()->removeElement($tag);
                        $post->addTag($existingTag);
            }

            return $post;
    }
}
