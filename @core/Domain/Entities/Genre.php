<?php

namespace Core\Domain\Entities;

use Core\Domain\Validators\DomainValidator;
use Core\Domain\ValueObjects\CategoryId;
use Core\Domain\ValueObjects\GenreId;
use DateTime;

class Genre
{
    /**
     * @param  array<CategoryId>  $categoriesId
     */
    public function __construct(
        public string $name,
        public ?GenreId $id = null,
        public array $categoriesId = [],
        public ?DateTime $createdAt = null,
    ) {
        $this->id = $this->id ?? GenreId::generate();
        $this->createdAt = $this->createdAt ?? new DateTime();

        $this->validate();
    }

    public function addCategory(CategoryId $categoryId): void
    {
        array_push($this->categoriesId, $categoryId);
    }

    public function removeCategory(CategoryId $categoryId): void
    {
        $index = collect($this->categoriesId)
            ->search(fn ($item) => (string) $item === (string) $categoryId);

        unset($this->categoriesId[$index]);
    }

    private function validate()
    {
        DomainValidator::notNull($this->name);
        DomainValidator::minLength($this->name, 3);
        DomainValidator::maxLength($this->name, 255);

        if ($this->categoriesId) {
            collect($this->categoriesId)
                ->each(
                    fn ($item) => DomainValidator::isA($item, CategoryId::class)
                );
        }
    }
}
