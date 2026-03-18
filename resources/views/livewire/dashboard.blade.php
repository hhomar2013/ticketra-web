{{-- <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Dashboard') }}
</h2>
</x-slot> --}}

<div class="py-6" wire:poll.5s="checkTickets">
    <div class="container-fluid">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg ">
            <div class="p-6  text-gray-900">
                @role('admin')
                <div class="row text-center">
                    <div class="col-lg-2">
                        <div class="card rounded-lg bg-primary bg-opacity-75 text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Users</h5>
                                <i class="fas fa-users text-3xl font-bold"></i>
                                <p class="card-text text-3xl font-bold p-3">{{ $total_users }}</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="card rounded-lg bg-dark bg-opacity-75 text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total Tickets</h5>
                                <i class="fas fa-ticket text-3xl font-bold"></i>
                                <p class="card-text text-3xl font-bold p-3">{{ $total_tickets->count() }}</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="card rounded-lg bg-secondary bg-opacity-75 text-white">
                            <div class="card-body">
                                <h5 class="card-title">New Tickets</h5>
                                <i class="fas fa-ticket text-3xl font-bold"></i>
                                <p class="card-text text-3xl font-bold p-3">{{ $total_tickets->where('status','new')->count() }}</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="card rounded-lg bg-success bg-opacity-75 text-white">
                            <div class="card-body">
                                <h5 class="card-title">Opened Tickets</h5>
                                <i class="fas fa-ticket text-3xl font-bold"></i>
                                <p class="card-text text-3xl font-bold p-3">{{ $total_tickets->where('status','open')->count() }}</p>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="card rounded-lg bg-warning bg-opacity-75 text-white">
                            <div class="card-body">
                                <h5 class="card-title">In Progress Tickets</h5>
                                <i class="fas fa-ticket text-3xl font-bold"></i>
                                <p class="card-text text-3xl font-bold p-3">{{ $total_tickets->where('status','in_progress')->count() }}</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="card rounded-lg bg-danger text-white">
                            <div class="card-body">
                                <h5 class="card-title">Closed Tickets</h5>
                                {{-- <i class="fas fa-ticket text-3xl font-bold"></i> --}}
                                {{-- <i class="fa-solid fa-check-double text-3xl font-bold"></i> --}}
                                <i class="fa-solid fa-ticket-simple text-3xl font-bold"></i>
                                <p class="card-text text-3xl font-bold p-3">{{ $total_tickets->where('status','closed')->count() }}</p>
                            </div>

                        </div>
                    </div>
                </div>
                @endrole
                @role('agent')
                {{ __("You're logged in! agent") }}
                @endrole
                @role('user')
                {{ __("You're logged in! user") }}
                @endrole
            </div>
        </div>
    </div>



</div>

@role('admin')

@push('scripts')
<script>
    document.addEventListener('livewire:init', () => {
        if (Notification.permission !== 'granted') {
            Notification.requestPermission();
        }
        Livewire.on('new-ticket-detected', (data) => {
            // تشغيل الصوت
            // console.log('New ticket detected');
            // console.log('📬 Data received:', data);
            const [ticket] = data;
            // console.log(ticket.subject, ticket.user);
            const subject = ticket.subject;
            const user = ticket.user;
            const id = ticket.ticket_id;
            const audio = new Audio('{{ asset("storage/sounds/order.mp3") }}');
            audio.play();

            // إشعار المتصفح
            if (Notification.permission === 'granted') {
                new Notification('🎫 New Ticket!', {
                    body: `${subject} \n From: ${user}`
                    , icon: '{{ asset("asset/images/notification-icon.png") }}'
                });

                notification.onclick = () => {
                    window.open(`/tickets/${id}`, '_blank'); // أو بدون _blank لو عايز نفس الصفحة
                };
            }
        });
    });

</script>
@endpush

@endrole
