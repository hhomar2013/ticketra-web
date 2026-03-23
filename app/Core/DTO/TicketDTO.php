<?php
namespace App\Core\DTO;

use App\Core\Enum\TicketStatus;

class TicketDTO
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $userId,
        public readonly int $categoryId,
        public readonly TicketStatus $status = TicketStatus::New ,
        public readonly ?string $imagePath = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'],
            userId: $data['user_id'],
            categoryId: $data['category_id'],
            status: $data['status'] ?? TicketStatus::New ,
            imagePath: $data['image_path'] ?? null,
        );
    }

}
