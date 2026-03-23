<?php

namespace App\Core\Repositories;

use App\Core\DTO\TicketDTO;
use App\Core\Enum\TicketStatus;
use App\Core\Repositories\Contracts\TicketRepositoryInterface;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketRepository implements TicketRepositoryInterface
{
    public function create(TicketDTO $dto): Ticket
    {
        return Ticket::create([
            'title'       => $dto->title,
            'description' => $dto->description,
            'user_id'     => $dto->userId,
            'category_id' => $dto->categoryId,
            'status'      => $dto->status,
        ]);
    }

    public function findById(int $id): ?Ticket
    {
        return Ticket::with('user', 'category', 'assignedUser', 'replies.user')
            ->find($id);
    }

    public function getByUser(int $userId): Collection
    {
        return Ticket::with('category', 'replies')
            ->where('user_id', $userId)
            ->latest()
            ->get();
    }

    public function updateStatus(Ticket $ticket, TicketStatus $status): bool
    {
        return $ticket->update(['status' => $status]);
    }

    public function assign(Ticket $ticket, int $agentId): bool
    {
        return $ticket->update(['assigned_to' => $agentId]);
    }

    public function addReply(Ticket $ticket, int $userId, string $body): void
    {
        $ticket->replies()->create([
            'user_id' => $userId,
            'body'    => $body,
        ]);
    }

    public function delete(int $id): bool
    {
        return Ticket::destroy($id) > 0;
    }

    public function getAllPaginated(
        int           $perPage = 10,
        ?TicketStatus $status  = null,
        ?string       $search  = null,
    ): LengthAwarePaginator {
        return Ticket::with('user', 'category', 'assignedUser')
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($search, fn($q) => $q->where('title', 'like', "%{$search}%"))
            ->latest()
            ->paginate($perPage);
    }
}
