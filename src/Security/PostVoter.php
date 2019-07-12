<?php

namespace App\Security;

use App\Entity\Post;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class PostVoter extends Voter
{
    const EDIT = 'edit';

    public function supports($attribute, $subject)
    {
        if(!in_array($attribute, [self::EDIT])) {
            return false;
        }

        elseif (!$subject instanceof Post)
        {
            return false;
        }

        return true;
    }

    public function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        /** @var $user */
        $user = $token->getUser();

        if(!$user instanceof User)
        {
            return false;
        }

        /** @var Post $post */
        $post = $subject;

        switch ($attribute) {
                case self::EDIT:
                    return $this->canEdit($post, $user);
            }

        throw new \LogicException('access denied!!! ');
    }

    public function canEdit(Post $post, User $user)
    {
        return $user === $post->getUser();
    }
}