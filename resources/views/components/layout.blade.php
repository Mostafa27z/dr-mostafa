<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'لوحة التحكم - منصة الدكتور مصطفى طنطاوي' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap');
        * { font-family: 'Tajawal', sans-serif; }
        body { direction: rtl; }
        .floating { animation: floating 4s ease-in-out infinite; }
        @keyframes floating { 0%{transform:translateY(0);}50%{transform:translateY(-10px);}100%{transform:translateY(0);} }
        .fade-in { animation: fadeIn 1s ease-in-out forwards; }
        @keyframes fadeIn { from{opacity:0;transform:translateY(30px);} to{opacity:1;transform:translateY(0);} }
        .dashboard-card { transition: all 0.3s ease; }
        .dashboard-card:hover { transform: translateY(-5px) scale(1.02); box-shadow: 0 20px 25px -5px rgba(0,0,0,.1), 0 10px 10px -5px rgba(0,0,0,.04); }
    </style>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800 overflow-x-hidden">

    {{ $slot }}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            if (sidebarToggle && sidebar && overlay) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                });
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                });
            }
        });
    </script>
</body>
</html>
