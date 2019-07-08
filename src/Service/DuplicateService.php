<?php

namespace App\Service;

use App\Repository\TagRepository;
use App\Entity\Post;

class DuplicateService
{
    public function checkExistingTags(TagRepository $tagRepository,
                                      Post $post) : Post
    {
            $tags = $tagRepository->findAll();

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