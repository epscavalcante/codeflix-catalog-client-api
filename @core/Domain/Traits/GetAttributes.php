<?php

namespace Core\Domain\Traits;

trait GetAttributes
{
    public function __get($key)
    {
        var_dump($this);
        return $this->{$key};
    }

    public function createdAt(): string
    {
        return (string) $this->createdAt->format('Y-m-d H:i:s');
    }

    public function id(): string
    {
        return (string) $this->id;
    }
}
