<?php
namespace App\Livewire\It;

use App\Core\Enum\TicketStatus;
use App\Models\Category;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Livewire\Component;
use Livewire\WithFileUploads;

class TicketCreate extends Component
{
    use WithFileUploads;
    public $title, $description, $category_id, $image, $tickets, $content = '';
    public $categories;

    protected $listeners = ['ticketCreated' => 'mount'];

    public function newTicketDetected()
    {
        $ticket = Ticket::latest()->first();
        broadcast(new \App\Events\NewTicketEvent($ticket))->toOthers();
        // $this->dispatch('new-ticket-detected', [
        //     'user'      => Auth::user()->name
        // ]);
    }

    public function mount()
    {
        $this->categories = Category::all();
        $this->refreshTickets();
    }

    public function refreshTickets()
    {
        $this->category_id = Auth::user()->category_id;
        $id                = Auth::user()->id;

        $this->tickets = Ticket::query()->where('user_id', $id)->with('category')->latest()->get();
    }

    public function submit()
    {
        $this->validate([
            'title'       => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        $ticket = Ticket::create([
            'title'       => $this->title,
            'description' => $this->description,
            'user_id'     => Auth::id(),
            'category_id' => $this->category_id,
            'status'      => 'new',
        ]);

        if ($this->image) {
            $path = $this->image->store('tickets', 'public');
            $ticket->image()->create(['file_path' => $path]);
        }

        // تجهيز البيانات الموحدة
        $notificationData = [
            'user'      => Auth::user()->name,
            'subject'   => $this->title,
            'ticket_id' => $ticket->id,
            'url'       => route('it.tickets.show', $ticket->id),
        ];

        // أ- إرسال للمتصفح الحالي (لو محتاج يظهر لصاحب الطلب)
        $this->dispatch('new-ticket-detected', $notificationData);

        // ب- إرسال عبر Reverb (بث مباشر لكل الأدمنز المتصلين)
        // تأكد أن كلاس NewTicketEvent يستقبل التذكرة ويجهز البيانات في خاصية $ticketData
        broadcast(new \App\Events\NewTicketEvent($ticket));

        // ج- إرسال Notification للداتابيز (ليراها الأدمن في قائمة الإشعارات لاحقاً)
        // سنرسلها لكل الأدمنز أو لموظف معين
        $admins = \App\Models\User::where('role', 'admin')->get();
        Notification::send($admins, new \App\Notifications\TicketUpdatedNotification($notificationData));

        $this->dispatch('refresh-summernote');
        $this->dispatch('ticketCreated');
        $this->reset(['title', 'description', 'image']);
    }
    public function deleteTicket($id)
    {
        $ticket_id = $id;
        $q         = Ticket::query()->find($ticket_id);
        $q->delete();
        session()->flash('message', 'Ticket Canceld Successfully.');
        $this->refreshTickets();
    }

    public function render()
    {
        return view('livewire.it.ticket-create',['statuses'=> TicketStatus::cases()]);
    }
}
