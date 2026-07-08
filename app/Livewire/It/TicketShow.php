<?php
namespace App\Livewire\It;

use App\Core\Enum\TicketStatus;
use App\Models\Ticket;
use App\Models\TicketFeedback;
use App\Models\TicketReply;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class TicketShow extends Component
{
    public Ticket $ticket; // ✅ Type hint بدل #[Validate]
    public $message;
    public $status;
    public $image;

    public $rating            = 0;
    public $comment           = '';
    public $feedbackSubmitted = false;
    public $statuses;
    public function mount($id)
    {
        $this->ticket   = Ticket::with('replies.user', 'feedback')->findOrFail($id);
        $this->statuses = TicketStatus::cases();

        if (Auth::user()->hasRole('it') && is_null($this->ticket->assigned_to)) {
            $this->ticket->update(['assigned_to' => Auth::id()]);
            $this->ticket->refresh();
        }
        if ($this->ticket->image) {
            $this->image = $this->ticket->image->file_path;
        }

        $this->status = in_array($this->ticket->status, ['open', 'in_progress', 'closed'])
            ? $this->ticket->status
            : null;

        if ($this->ticket->feedback) {
            $this->feedbackSubmitted = true;
            $this->rating            = $this->ticket->feedback->rating;
            $this->comment           = $this->ticket->feedback->comment;
        }
    }

    public function setRating(int $value): void
    {
        $this->rating = $value;
    }
    public function addReply()
    {
        $this->validate(['message' => 'required|string|max:2000']);

        $reply = TicketReply::create([
            'ticket_id' => $this->ticket->id,
            'user_id'   => Auth::id(),
            'message'   => $this->message,
        ]);

        // ✅ Broadcast للتاني عبر Pusher (toOthers = مش بيبعت لنفسه)
        broadcast(new \App\Events\NewTicketReply($reply->load('user')))->toOthers();

        // ✅ إظهار الرسالة لصاحبها فوراً (لأن toOthers مش بيبعتهاله)
        $this->dispatch('reply-added', [
            'message'    => $this->message,
            'user_id'    => Auth::id(),
            'user_name'  => Auth::user()->name,
            'created_at' => now()->format('h:i A'),
        ]);

        // ✅ إرسال الإشعار للطرف الآخر
        $recipient = (Auth::id() === $this->ticket->user_id)
            ? $this->ticket->assignedUser
            : $this->ticket->user;

        $recipient?->notify(new \App\Notifications\TicketUpdatedNotification([
            'ticket_id' => $this->ticket->id,
            'title'     => "رد جديد على تذكرة: " . $this->ticket->title,
            'message'   => $this->message,
            'user_name' => Auth::user()->name,
            'type'      => 'reply',
        ]));

        $this->dispatch('refreshNotifications');
        $this->ticket->load('replies.user');
        $this->message = '';
    }

    public function update_Status()
    {
        // 1. التحويل من String لـ Enum لضمان صحة البيانات
        $newStatus = TicketStatus::tryFrom($this->status);
        if (! $newStatus) {
            $this->dispatch('show-toast', ['message' => 'Invalid Status', 'type' => 'error']);
            return;
        }

        // 2. تحديث التذكرة باستخدام الـ Enum
        $this->ticket->update([
            'status' => $newStatus->value,
        ]);

        // 3. استخدام ميثود الـ label() من الـ Enum بدل الـ match اليدوي
        $displayStatus = $newStatus->label();

        // 4. إنشاء الرد (Reply)
        $reply = TicketReply::create([
            'ticket_id' => $this->ticket->id,
            'user_id'   => Auth::id(),
            'message'   => "changed to: " . $displayStatus,
        ]);

        // ✅ Broadcast (للطرف الآخر)
        broadcast(new \App\Events\NewTicketReply($reply->load('user')))->toOthers();

        // ✅ إظهار الرسالة في نفس اللحظة (Current User)
        $this->dispatch('reply-added', [
            'message'       => $reply->message,
            'user_id'       => Auth::id(),
            'user_name'     => Auth::user()->name,
            'created_at'    => now()->format('h:i A'),
            'ticket_status' => $newStatus->value,
        ]);

        // 5. إرسال الإشعار لصاحب التذكرة
        if ($this->ticket->user) {
            $this->ticket->user->notify(new \App\Notifications\TicketUpdatedNotification([
                'ticket_id' => $this->ticket->id,
                'title'     => "Status update: " . $this->ticket->title,
                'message'   => "Ticket status changed to " . $displayStatus,
                'user_name' => Auth::user()->name,
                'type'      => 'status_change',
            ]));
        }

        // 6. التحديثات النهائية للـ UI
        $this->dispatch('refreshNotifications');
        $this->dispatch('show-toast', [
            'message' => 'Status has been updated to ' . $displayStatus,
            'type'    => 'success',
        ]);

        // إعادة تحميل البيانات للتحديث
        $this->ticket->load('replies.user');
    }

    // public function update_Status()
    // {
    //     if ($this->status == 'new') {
    //         $this->ticket->update(['status' => 'new']);
    //         $displayStatus = 'New';
    //     } else {
    //         $this->validate(['status' => 'required|in:open,in_progress,closed']);
    //         $this->ticket->update(['status' => $this->status]);

    //         $displayStatus = match ($this->status) {
    //             'open'        => 'Opened',
    //             'in_progress' => 'In Progress',
    //             'closed'      => 'Closed',
    //             default       => $this->status
    //         };
    //     }

    //     $reply = TicketReply::create([
    //         'ticket_id' => $this->ticket->id,
    //         'user_id'   => Auth::id(),
    //         'message'   => "Your Ticket status has been changed to: " . $displayStatus,
    //     ]);

    //     // ✅ Broadcast للتاني
    //     broadcast(new \App\Events\NewTicketReply($reply->load('user')))->toOthers();

    //     // ✅ إظهار الرسالة لصاحبها فوراً
    //     $this->dispatch('reply-added', [
    //         'message'       => $reply->message,
    //         'user_id'       => Auth::id(),
    //         'user_name'     => Auth::user()->name,
    //         'created_at'    => now()->format('h:i A'),
    //         'ticket_status' => $this->status,
    //     ]);

    //     $this->ticket->user?->notify(new \App\Notifications\TicketUpdatedNotification([
    //         'ticket_id' => $this->ticket->id,
    //         'title'     => "Status update : " . $this->ticket->title,
    //         'message'   => $displayStatus,
    //         'user_name' => Auth::user()->name,
    //         'type'      => 'status_change',
    //     ]));

    //     $this->dispatch('refreshNotifications');
    //     // $this->dispatch('ticket-status-updated', status: $this->status);
    //     $this->dispatch('show-toast', ['message' => 'Status has been updated', 'type' => 'success']);
    //     $this->ticket->load('replies.user');
    // }

    #[On('deleteReply')] // ✅ Livewire 3 syntax
    public function deleteReply($id)
    {
        $reply = TicketReply::findOrFail($id);

        // ✅ تأكد إن المستخدم يملك الرد أو عنده صلاحية
        abort_unless(
            Auth::id() === $reply->user_id || Auth::user()->can('manage tickets'),
            403
        );

        $reply->delete();
        $this->ticket->load('replies.user');
    }

    public function typing()
    {
        Cache::put(
            'typing_ticket_' . $this->ticket->id . '_' . Auth::id(),
            Auth::user()->name,
            now()->addSeconds(4)
        );
    }

    public function getTypingUserProperty()
    {
        $userIds = $this->ticket->replies->pluck('user_id')
            ->push($this->ticket->user_id)
            ->unique();

        foreach ($userIds as $userId) {
            if ($userId != Auth::id()) {
                $name = Cache::get('typing_ticket_' . $this->ticket->id . '_' . $userId);
                if ($name) {
                    return $name;
                }

            }
        }
        return null;
    }

    public function submitFeedback()
    {
        $this->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:500',
        ]);

        TicketFeedback::query()->create(
            ['ticket_id' => $this->ticket->id,
                'user_id'    => Auth::id(),
                'rating'     => $this->rating,
                'comment'    => $this->comment,
            ]
        );

        $this->feedbackSubmitted = true;

        $this->dispatch('show-toast', [
            'message' => 'Thanks for your rating!',
            'type'    => 'success',
        ]);
    }

    #[On('refreshTicket')]
    public function refreshTicket(): void
    {
        $this->ticket->refresh();
        $this->status = $this->ticket->status;
    }

    public function render()
    {

        return view('livewire.it.ticket-show');
    }
}
