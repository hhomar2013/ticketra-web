<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>{{ config('app.name', 'founders') }}</title>

    <!-- Fonts -->

    <link rel="shortcut icon" type="image/png" href="{{ asset('asset/images/logo.png') }}" />
    {{-- <link rel="preconnect" href="https://fonts.bunny.net"> --}}
    {{-- <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200..1000&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Cairo', sans-serif !important;
        }

    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-app-compat.js"></script>
    <script src="https://www.gstatic.com/firebasejs/9.22.0/firebase-messaging-compat.js"></script>

    <script>
        // إعدادات مشروعك من Firebase Console → Project Settings → General
        const firebaseConfig = {
            apiKey: "AIzaSyAQmQ7FXMU4FZBNC_EoHFKd3icZkzhH3Bo"
            , authDomain: "founders-f8027.firebaseapp.com"
            , projectId: "founders-f8027"
            , storageBucket: "founders-f8027.firebasestorage.app"
            , messagingSenderId: "197134318785"
            , appId: "1:197134318785:web:c429307a807512cb25e840"
            , measurementId: "G-SEE99LVJ4W"
        };

        // تهيئة Firebase
        firebase.initializeApp(firebaseConfig);

        const messaging = firebase.messaging();

        // طلب إذن الإشعارات
        function initFirebaseMessagingRegistration() {
            Notification.requestPermission().then((permission) => {
                if (permission === 'granted') {
                    messaging.getToken({
                        vapidKey: 'BMTroG44i3kp0OOXpeVM2uPbbOB7eHlZRu7vXi6-i5FlARZMky8eZ_LkJjVQHdhHAhbjx5U_GEP_OQub1PSTo8k'
                    }).then((currentToken) => {
                        if (currentToken) {
                            console.log("Token:", currentToken);
                            // ابعته للسيرفر
                            fetch('/save-fcm-token', {
                                method: 'POST'
                                , headers: {
                                    'Content-Type': 'application/json'
                                    , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                                , body: JSON.stringify({
                                    token: currentToken
                                })
                            });
                        } else {
                            console.warn('مفيش توكن حالياً.');
                        }
                    }).catch((err) => {
                        console.error('Error getting token:', err);
                    });
                } else {
                    console.warn('تم رفض الإذن بالإشعارات.');
                }
            });
        }

        // استماع للإشعارات لما التطبيق مفتوح
        messaging.onMessage((payload) => {
            console.log('Message received:', payload);
            const notificationTitle = payload.notification.title;
            const notificationOptions = {
                body: payload.notification.body
                , icon: '/logo.png'
            , };
            new Notification(notificationTitle, notificationOptions);
        });

        // استدعاء الدالة أول ما الصفحة تفتح
        initFirebaseMessagingRegistration();

    </script>

    @role('admin')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // طلب إذن الإشعارات أول مرة
            if (Notification.permission !== 'granted') {
                Notification.requestPermission();
            }

            // استماع لأي إشعار من Livewire
            window.addEventListener('new-ticket-detected', event => {
                const data = event.detail;

                // تشغيل الصوت
                const audio = new Audio('asset/sounds/order.mp3');
                audio.play().catch(() => {});

                // عرض الإشعار
                const notification = new Notification(`🎫 Ticket جديد من ${data.user}`, {
                    body: data.subject
                    , icon: '/images/notification-icon.png'
                , });

                // فتح صفحة التيكيت عند الضغط
                notification.onclick = () => {
                    window.open(`/tickets/${data.ticket_id}`, '_blank');
                };
            });
        });

    </script>
    @endrole
</body>
</html>
