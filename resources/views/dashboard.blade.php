<x-layout>
    <div class="flex">
        <x-sidebar/>
        <div class="flex-1 overflow-hidden">
            <x-navbar/>
            <div class="p-6">
                <x-welcome-card/>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <x-stat-card 
                        color="sky" 
                        icon="fa-book" 
                        :number="$stats['active_lessons']" 
                        label="درس نشط"
                    />
                    <x-stat-card 
                        color="green" 
                        icon="fa-users" 
                        :number="$stats['enrolled_students']" 
                        label="طالب مسجل"
                    />
                    <x-stat-card 
                        color="yellow" 
                        icon="fa-file-alt" 
                        :number="$stats['active_exams']" 
                        label="اختبار نشط"
                    />
                    <x-stat-card 
                        color="purple" 
                        icon="fa-tasks" 
                        :number="$stats['pending_assignments']" 
                        label="واجب معلق"
                    />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    <!-- الدورات الأخيرة -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">أحدث الدورات</h3>
                        <div class="space-y-4">
                            @foreach($recent_courses as $course)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <div class="flex items-center">
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-800">{{ $course->title }}</h4>
                                        <p class="text-xs text-gray-500">بواسطة: {{ $course->teacher->name }}</p>
                                    </div>
                                </div>
                                <span class="text-sm text-green-600">{{ $course->price }} جنيه</span>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('courses.index') }}" class="block text-center mt-4 text-blue-600 hover:text-blue-800 text-sm">
                            عرض جميع الدورات →
                        </a>
                    </div>

                    <!-- الطلاب الجدد -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">أحدث الطلاب</h3>
                        <div class="space-y-4">
                            @foreach($new_students as $student)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-800">{{ $student->name }}</h4>
                                        <p class="text-xs text-gray-500">{{ $student->email }}</p>
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $student->created_at->diffForHumans() }}</span>
                            </div>
                            @endforeach
                        </div>
                        <a href="{{ route('students.index') }}" class="block text-center mt-4 text-blue-600 hover:text-blue-800 text-sm">
                            عرض جميع الطلاب →
                        </a>
                    </div>
                </div>

                <!-- الواجبات التي تحتاج تصحيح -->
                <div class="bg-white rounded-lg shadow p-6 mb-8">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">الواجبات التي تحتاج تصحيح</h3>
                    @if($assignments_to_grade->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2">الطالب</th>
                                    <th class="px-4 py-2">الواجب</th>
                                    <th class="px-4 py-2">التاريخ</th>
                                    <th class="px-4 py-2">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignments_to_grade as $assignment)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-4 py-2 font-medium text-gray-900">{{ $assignment->student_name }}</td>
                                    <td class="px-4 py-2">{{ $assignment->assignment_title }}</td>
                                    <td class="px-4 py-2">{{ \Carbon\Carbon::parse($assignment->created_at)->diffForHumans() }}</td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('assignments.answers.grade', $assignment->id) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                            تصحيح الواجب
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">لا توجد واجبات تحتاج تصحيح</p>
                    @endif
                </div>

                <x-quick-access>
                    <x-quick-link icon="fa-plus" label="إضافة درس جديد" url="{{ route('lessons.create') }}" />
                    <x-quick-link icon="fa-book" label="إدارة الدورات" url="{{ route('courses.index') }}" />
                    <x-quick-link icon="fa-users" label="إدارة الطلاب" url="{{ route('students.index') }}" />
                    <x-quick-link icon="fa-file-alt" label="إنشاء اختبار" url="{{ route('exams.create') }}" />
                    <x-quick-link icon="fa-users" label="إدارة المجموعات" url="{{ route('teacher.groups.index') }}" />
                    <x-quick-link icon="fa-video" label="الجلسات" url="{{ route('sessions.index') }}" />
                    <x-quick-link icon="fa-tasks" label="الواجبات" url="{{ route('assignments.index') }}" />
                    <x-quick-link icon="fa-graduation-cap" label="التسجيلات" url="{{ route('enrollments.index') }}" />
                </x-quick-access>
            </div>
        </div>
    </div>
</x-layout>