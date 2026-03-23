<?php

namespace App\Core\Services;

use App\Core\DTO\TicketDTO;
use App\Core\Enum\TicketStatus;
use App\Core\Repositories\Contracts\TicketRepositoryInterface;
use App\Events\TicketCreated;
use App\Events\TicketStatusChanged;
use App\Models\Ticket;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;

class TicketService
{
    public function __construct(
        private readonly TicketRepositoryInterface $repository,
    ) {}

    // ══════════════ إنشاء تيكيت ══════════════
    public function create(TicketDTO $dto, ?UploadedFile $image = null): Ticket
    {
        $ticket = $this->repository->create($dto);

        if ($image) {
            $path = $image->store('tickets', 'public');
            $ticket->image()->create(['file_path' => $path]);
        }

        // إطلاق الـ Event — الـ Listener هيتولى الإشعارات
        TicketCreated::dispatch($ticket);

        return $ticket;
    }

    // ══════════════ تغيير الحالة ══════════════
    public function updateStatus(Ticket $ticket, TicketStatus $newStatus): bool
    {
        $oldStatus = $ticket->status;

        $updated = $this->repository->updateStatus($ticket, $newStatus);

        if ($updated) {
            TicketStatusChanged::dispatch($ticket, $oldStatus, $newStatus);
        }

        return $updated;
    }

    // ══════════════ Assign لموظف ══════════════
    public function assign(Ticket $ticket, int $agentId): bool
    {
        return $this->repository->assign($ticket, $agentId);
    }

    // ══════════════ إضافة Reply ══════════════
    public function addReply(Ticket $ticket, int $userId, string $body): void
    {
        $this->repository->addReply($ticket, $userId, $body);
    }

    // ══════════════ حذف التيكيت ══════════════
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    // ══════════════ جلب تيكيتات المستخدم ══════════════
    public function getUserTickets(int $userId)
    {
        return $this->repository->getByUser($userId);
    }

    // ══════════════ جلب الكل مع Pagination ══════════════
    public function getAllPaginated(
        int           $perPage = 10,
        ?TicketStatus $status  = null,
        ?string       $search  = null,
    ): LengthAwarePaginator {
        return $this->repository->getAllPaginated($perPage, $status, $search);
    }

    // ══════════════ جلب تيكيت بالـ ID ══════════════
    public function findById(int $id): ?Ticket
    {
        return $this->repository->findById($id);
    }
}
