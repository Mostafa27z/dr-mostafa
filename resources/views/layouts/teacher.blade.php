<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة تحكم المدرس')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Tahoma', sans-serif;
        }
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: #fff;
        }
        .sidebar a {
            color: #fff;
            text-decoration: none;
            display: block;
            padding: 10px;
        }
        .sidebar a:hover, .sidebar a.active {
            background: #495057;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- القائمة الجانبية -->
        <div class="col-md-3 col-lg-2 sidebar p-0">
            <h3 class="p-3">📘 مدرّس</h3>
            <a href="{{ route('teacher.dashboard') }}" class="{{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">الصفحة الرئيسية</a>
            <a href="{{ route('teacher.courses.index') }}" class="{{ request()->routeIs('teacher.courses.*') ? 'active' : '' }}">📚 الدورات</a>
            <a href="{{ route('teacher.exams.index') }}" class="{{ request()->routeIs('teacher.exams.*') ? 'active' : '' }}">📝 الامتحانات</a>
            <a href="{{ route('teacher.assignments.index') }}" class="{{ request()->routeIs('teacher.assignments.*') ? 'active' : '' }}">📂 الواجبات</a>
            <a href="{{ route('teacher.groups.index') }}" class="{{ request()->routeIs('teacher.groups.*') ? 'active' : '' }}">👥 المجموعات</a>
            <a href="{{ route('teacher.profile') }}" class="{{ request()->routeIs('teacher.profile') ? 'active' : '' }}">⚙️ حسابي</a>
            <a href="{{ route('logout') }}">🚪 تسجيل الخروج</a>
        </div>

        <!-- المحتوى -->
        <div class="col-md-9 col-lg-10 content">
            <h4 class="mb-4">@yield('page-title', 'لوحة التحكم')</h4>
            @yield('content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
