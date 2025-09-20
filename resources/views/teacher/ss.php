@extends('layouts.app')

@section('title', 'لوحة التحكم - المدرس')

@section('content')
<div class="container mt-4">

    <h2 class="mb-4">👨‍🏫 لوحة تحكم المدرس</h2>

    <div class="row">
        <!-- الكروت الأساسية -->
        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📚 الدروس</h5>
                    <p class="card-text fs-4">{{ $lessonsCount ?? 0 }}</p>
                    <a href="{{ route('teacher.lessons.index') }}" class="btn btn-primary btn-sm">إدارة</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">📝 الامتحانات</h5>
                    <p class="card-text fs-4">{{ $examsCount ?? 0 }}</p>
                    <a href="{{ route('teacher.exams.index') }}" class="btn btn-primary btn-sm">إدارة</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">👥 الطلاب</h5>
                    <p class="card-text fs-4">{{ $studentsCount ?? 0 }}</p>
                    <a href="{{ route('teacher.students.index') }}" class="btn btn-primary btn-sm">عرض</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">💬 المجموعات</h5>
                    <p class="card-text fs-4">{{ $groupsCount ?? 0 }}</p>
                    <a href="{{ route('teacher.groups.index') }}" class="btn btn-primary btn-sm">إدارة</a>
                </div>
            </div>
        </div>
    </div>

    <!-- آخر الأنشطة -->
    <div class="mt-5">
        <h4>🕘 آخر الأنشطة</h4>
        <table class="table table-bordered text-center">
            <thead class="table-light">
                <tr>
                    <th>النشاط</th>
                    <th>التاريخ</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities ?? [] as $activity)
                    <tr>
                        <td>{{ $activity->description }}</td>
                        <td>{{ $activity->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">لا توجد أنشطة حديثة</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
