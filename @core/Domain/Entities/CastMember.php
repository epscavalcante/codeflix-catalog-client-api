<?php

namespace Core\Domain\Entities;

use Core\Domain\Validators\DomainValidator;
use Core\Domain\ValueObjects\CastMemberId;
use DateTime;

class CastMember
{
    public function __construct(
        public string $name,
        public int $type,
        public ?CastMemberId $id = null,
        public ?DateTime $createdAt = null,
    ) {
        $this->id = $this->id ?? CastMemberId::generate();
        $this->createdAt = $this->createdAt ?? new DateTime();

        $this->validate();
    }

    private function validate()
    {
        DomainValidator::notNull($this->name);
        //validar mais especificamente o type
        DomainValidator::notNull($this->type);
        DomainValidator::isANumber($this->type);
        DomainValidator::minLength($this->name, 3);
        DomainValidator::maxLength($this->name, 255);
    }
}
