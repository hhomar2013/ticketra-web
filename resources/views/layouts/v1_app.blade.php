<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') ?? '' }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/f.jpg') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    @stack('styles') {{-- ✅ بدل @stack('css') --}}
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

        @livewire('v1.includes.aside')

        <div class="body-wrapper">
            @livewire('v1.includes.header')

            <div class="container-fluid" style="height: 94vh;">
                @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
                @endif
                {{ $slot }}
            </div>
        </div>
    </div>

    {{-- ✅ SweetAlert أول حاجة قبل أي script يستخدمه --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- Assets --}}
    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script> {{-- ✅ بدون asset() --}}
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/confirmDelete.js') }}"></script>

    {{-- ✅ userId متاح لكل الـ scripts --}}
    <script>
        window.userId = {{auth()->id() }};

    </script>

    {{-- ✅ livewire:init مرة واحدة بس --}}
    <script>
        document.addEventListener('livewire:init', () => {

            // ── Toast ──────────────────────────────────────────────────
            Livewire.on('show-toast', (event) => {
                const data = event[0];
                Swal.mixin({
                    toast: true
                    , position: 'top-end'
                    , showConfirmButton: false
                    , timer: 3000
                    , timerProgressBar: true
                    , didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                }).fire({
                    icon: data.type
                    , title: data.message
                });
            });

            // ── Notification للـ IT فقط ────────────────────────────────
            @role('it')
            if (window.Notification && Notification.permission !== 'granted') {
                Notification.requestPermission();
            }

            function handleNotification(data) {
                if (!data) return;

                // صوت
                new Audio("{{ asset('storage/sounds/order.mp3') }}")
                    .play()
                    .catch(() => {});

                // Browser notification
                if (window.Notification && Notification.permission === 'granted') {
                    const n = new Notification(`🎫 New Ticket From : ${data.user}`, {
                        body: data.subject
                        , icon: "{{ asset('asset/images/notification-icon.png') }}"
                        , dir: 'rtl'
                    });
                    n.onclick = (e) => {
                        e.preventDefault();
                        if (data.url) window.open(data.url, '_blank');
                    };
                }

                // SweetAlert Toast
                Swal.fire({
                    toast: true
                    , position: 'top-end'
                    , icon: 'info'
                    , title: `New Ticket: ${data.subject}`
                    , html: `<small>from: ${data.user}</small><br>
                           <a href="${data.url}" style="color:#3085d6;font-size:12px;">Show Ticket</a>`
                    , showConfirmButton: false
                    , timer: 8000
                    , timerProgressBar: true
                    , didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                        toast.style.cursor = 'pointer';
                        toast.onclick = () => {
                            if (data.url) window.open(data.url, '_blank');
                        };
                    }
                });
            }

            // Echo listener
            if (window.Echo) {
                window.Echo.channel('tickets')
                    .listen('NewTicketEvent', (e) => handleNotification(e.ticketData));
            }

            // Livewire dispatch listener
            Livewire.on('new-ticket-detected', (event) => {
                const data = Array.isArray(event) ? event[0] : event;
                handleNotification(data);
            });
            @endrole

        });

    </script>

    @stack('js')

</body>
</html>
