<?php

namespace Core\Domain\Entities;

use Core\Domain\Validators\DomainValidator;
use Core\Domain\ValueObjects\CategoryId;
use DateTime;

class Category
{
    public function __construct(
        public string $name,
        public ?CategoryId $id = null,
        public ?string $description = null,
        public bool $isActive = true,
        public ?DateTime $createdAt = null,
    ) {
        $this->id = $this->id ?? CategoryId::generate();
        $this->createdAt = $this->createdAt ?? new DateTime();

        $this->validate();
    }

    public function activate()
    {
        $this->isActive = true;

        $this->validate();
    }

    public function deactivate()
    {
        $this->isActive = false;

        $this->validate();
    }

    private function validate()
    {
        DomainValidator::notNull($this->name);
        DomainValidator::minLength($this->name, 3);
        DomainValidator::maxLength($this->name, 255);
        DomainValidator::maxLength($this->name, 255);

        if ($this->description) {
            DomainValidator::maxLength($this->description, 1000);
        }
    }
}
