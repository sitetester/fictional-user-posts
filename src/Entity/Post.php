<?php
declare(strict_types=1);

namespace App\Entity;

class Post
{
    /** @var string */
    private $id;

    /** @var string */
    private $fromName;

    /** @var string */
    private $fromId;

    /** @var string */
    private $message;

    /** @var string */
    private $type;

    /** @var \DateTimeInterface */
    private $createdTime;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): Post
    {
        $this->id = $id;

        return $this;
    }

    public function getFromName(): string
    {
        return $this->fromName;
    }

    public function setFromName(string $fromName): Post
    {
        $this->fromName = $fromName;

        return $this;
    }

    public function getFromId(): string
    {
        return $this->fromId;
    }

    public function setFromId(string $fromId): Post
    {
        $this->fromId = $fromId;

        return $this;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): Post
    {
        $this->message = $message;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type): Post
    {
        $this->type = $type;

        return $this;
    }

    public function getCreatedTime(): \DateTimeInterface
    {
        return $this->createdTime;
    }

    public function setCreatedTime(\DateTimeInterface $createdTime): Post
    {
        $this->createdTime = $createdTime;

        return $this;
    }


}
