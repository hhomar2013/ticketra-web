<?php

namespace App\Core\Repositories\Contracts;

use App\Core\DTO\TicketDTO;
use App\Core\Enum\TicketStatus;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TicketRepositoryInterface
{
    public function create(TicketDTO $dto): Ticket;

    public function findById(int $id): ?Ticket;

    public function getByUser(int $userId): Collection;

    public function updateStatus(Ticket $ticket, TicketStatus $status): bool;

    public function assign(Ticket $ticket, int $agentId): bool;

    public function addReply(Ticket $ticket, int $userId, string $body): void;

    public function delete(int $id): bool;

    public function getAllPaginated(
        int           $perPage = 10,
        ?TicketStatus $status  = null,
        ?string       $search  = null,
    ): LengthAwarePaginator;
}
