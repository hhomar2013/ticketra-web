<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') ?? '' }}</title>
    <link rel="shortcut icon" type="image/png" class="rounded-pill" href="{{ asset('asset/images/f.jpg') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('css')
    <link rel="stylesheet" href="{{ asset('assets/css/styles.min.css') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        @livewire('v1.includes.aside')
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper ">
            <!--  Header Start -->
            @livewire('v1.includes.header')
            <!--  Header End -->

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
            {{-- <div class="py-6 px-6 text-center  bg-white ">
                <p class="mb-0 fs-4">Developed by <a href="" target="_blank"
                        class="pe-1 text-primary text-decoration-underline">MahgoubTech</a>Distributed by <a
                        href="" target="_blank" class="pe-1 text-primary text-decoration-underline">IT
                        Department</a></p>
            </div> --}}
        </div>

        <script src="{{ asset('https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js') }}"></script>
        <script src="{{ asset('assets/libs/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/dist/simplebar.js') }}"></script>
        <script src="{{ asset('assets/js/sidebarmenu.js') }}"></script>
        <script src="{{ asset('assets/js/app.min.js') }}"></script>
        <script src="{{ asset('assets/js/dashboard.js') }}"></script>


        @role('it')
            <script type="module">
                document.addEventListener('livewire:init', () => {

                    // 1. طلب إذن الإشعارات فور تحميل Livewire
                    if (window.Notification && Notification.permission !== 'granted') {
                        Notification.requestPermission();
                    }

                    // 2. فحص اتصال Echo (Reverb) بشكل مستمر حتى يعمل
                    let echoCheckCounter = 0;
                    const checkEcho = setInterval(() => {
                        if (window.Echo) {
                            console.log("✅ Reverb Connected Successfully");
                            clearInterval(checkEcho);

                            // الاستماع لقناة التذاكر العامة
                            window.Echo.channel('tickets')
                                .listen('NewTicketEvent', (e) => {
                                    console.log("📡 New Ticket via Reverb:", e);
                                    // نمرر البيانات للأدمن (تأكد أن Event يرسل مصفوفة ticketData)
                                    handleNotification(e.ticketData);
                                });
                        } else {
                            echoCheckCounter++;
                            if (echoCheckCounter > 20) {
                                console.error("❌ Echo failed to load. Check your build (npm run dev)");
                                clearInterval(checkEcho);
                            }
                        }
                    }, 500);

                    // 3. الاستماع لأحداث Livewire المحلية (Dispatch)
                    // عند استخدام $this->dispatch من السيرفر، البيانات تصل كمصفوفة في Livewire 3
                    Livewire.on('new-ticket-detected', (event) => {
                        console.log("📥 Local Dispatch Received:", event);
                        const data = Array.isArray(event) ? event[0] : event;
                        handleNotification(data);
                    });

                    // 4. الوظيفة الشاملة للإشعارات (تعمل مع Reverb و Livewire)
                    function handleNotification(data) {
                        if (!data) return;

                        // أ- تشغيل الصوت
                        // ملاحظة: تأكد أن الملف في public/storage/sounds/order.mp3 أو public/sounds/order.mp3
                        const audioPath = "{{ asset('storage/sounds/order.mp3') }}";
                        const audio = new Audio(audioPath);

                        audio.play().catch(e => {
                            console.warn("🔊 Audio playback was prevented. Click anywhere to enable sound.");
                        });

                        // ب- إشعار المتصفح (Native Notification)
                        if (window.Notification && Notification.permission === 'granted') {
                            const notification = new Notification(`🎫 تذكرة جديدة من ${data.user}`, {
                                body: data.subject,
                                icon: "{{ asset('asset/images/notification-icon.png') }}",
                                dir: 'rtl'
                            });

                            // عند الضغط على الإشعار يفتح الرابط الممرر من السيرفر
                            notification.onclick = (e) => {
                                e.preventDefault();
                                if (data.url) {
                                    window.open(data.url, '_blank');
                                    window.focus();
                                }
                            };
                        }

                        // ج- تنبيه داخلي (SweetAlert Toast)
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'info',
                                title: `تذكرة جديدة: ${data.subject}`,
                                html: `<small>بواسطة: ${data.user}</small><br><a href="${data.url}" style="color: #3085d6; font-size: 12px;">عرض التذكرة</a>`,
                                showConfirmButton: false,
                                timer: 8000, // زيادة الوقت قليلاً ليلحق الأدمن يضغط
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.onmouseenter = Swal.stopTimer;
                                    toast.onmouseleave = Swal.resumeTimer;
                                    // جعل التوست قابل للضغط أيضاً
                                    toast.style.cursor = 'pointer';
                                    toast.onclick = () => {
                                        if (data.url) window.open(data.url, '_blank');
                                    };
                                }
                            });
                        }
                    }
                });
            </script>
        @endrole

        <script src="{{ asset('assets/js/confirmDelete.js') }}"></script>




        {{-- Message Toast --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('show-toast', (event) => {
                    const data = event[0];

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });

                    Toast.fire({
                        icon: data.type, // success, error, warning, info
                        title: data.message
                    });
                });
            });
        </script>

        <script>
            window.userId = {{ auth()->id() }};
        </script>


        @stack('js')



</body>

</html>
