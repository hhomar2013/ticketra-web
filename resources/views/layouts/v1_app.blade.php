<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') ?? '' }}</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logo.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
    @stack('styles')
    @livewireStyles
</head>

<body>
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
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

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script> {{-- ✅ بدون asset() --}}
    <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <script src="{{ asset('assets/js/confirmDelete.js') }}"></script>

    <script>
        window.userId = {{ auth()->id() }};
    </script>


    <script>
        document.addEventListener('livewire:init', () => {
            const audioTick = new Audio("{{ asset('storage/sounds/order.mp3') }}");
            const audioMsg = new Audio("{{ asset('storage/sounds/message.mp3') }}");

            function playNotificationSound(type = 'ticket') {
                const sound = type === 'ticket' ? audioTick : audioMsg;
                sound.play().catch(e => console.log("Sound interaction required"));
            }

            if (window.Echo) {
                // ── 1. إشعارات التذاكر الجديدة (لـ IT فقط) ──
                @role('it')
                    window.Echo.channel('tickets')
                        .listen('.new-ticket', (e) => { // لاحظ النقطة قبل اسم الـ Event لو استخدمت broadcastAs
                            console.log('New Ticket via Pusher:', e);
                            playNotificationSound('ticket');

                            // استخدام ميثود الـ Swal اللي عندك
                            if (typeof handleNotification === "function") {
                                handleNotification(e.ticketData);
                            }

                            // تحديث الـ Header والـ List فوراً
                            Livewire.dispatch('refreshNotifications');
                            Livewire.dispatch('ticketCreated');
                        });
                @endrole

                // ── 2. إشعارات النظام الخاصة بالمستخدم (Private) ──
                window.Echo.private(`App.Models.User.${window.userId}`)
                    .notification((notification) => {
                        console.log('New Private Notification:', notification);
                        playNotificationSound('message');

                        // تحديث الـ Header
                        Livewire.dispatch('refreshNotifications');

                        // تنبيه Toast سريع
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'info',
                            title: notification.title || 'New Notification',
                            text: notification.message || '',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true
                        });
                    });
            }
        });
    </script>

    {{-- End JS --}}
    @stack('js')
    @livewireScripts
</body>

</html>
