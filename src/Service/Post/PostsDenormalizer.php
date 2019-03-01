<?php
declare(strict_types=1);

namespace App\Service\Post;

use App\Entity\Post;

class PostsDenormalizer
{
    public function denormalize(array $postData): Post
    {
        return (new Post())
            ->setId($postData['id'])
            ->setFromName($postData['from_name'])
            ->setFromId($postData['from_id'])
            ->setMessage($postData['message'])
            ->setType($postData['type'])
            ->setCreatedTime(new \DateTime($postData['created_time']))
            ;
    }
}
