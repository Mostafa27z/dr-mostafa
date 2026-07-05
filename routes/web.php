<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\AssignmentAnswerController;
// use App\Http\Middleware\Role as role;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard Routes
Route::get('teacher/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'role:teacher', 'subscription'])->name('teacher.dashboard');

// Subscription Expired Route
Route::get('/subscription/expired', function () {
    return view('subscription.expired');
})->middleware('auth')->name('subscription.expired');

// Account Disabled Route
Route::get('/account/disabled', function () {
    return view('auth.disabled');
})->middleware('auth')->name('auth.disabled');

// Authentication Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Courses (Teacher Management) Routes
Route::middleware(['auth', 'role:teacher', 'subscription'])->prefix('teacher/courses')->name('teacher.courses.')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/create', [CourseController::class, 'create'])->name('create');
    Route::post('/', [CourseController::class, 'store'])->name('store');
    Route::get('/{course}', [CourseController::class, 'show'])->name('show');
    Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('edit');
    Route::put('/{course}', [CourseController::class, 'update'])->name('update');
    Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy');
});

// Lessons Routes
Route::prefix('teacher/lessons')->name('teacher.lessons.')->middleware(['auth', 'role:teacher', 'subscription'])->group(function () {
    Route::get('/', [LessonController::class, 'index'])->name('index');
    Route::get('/create', [LessonController::class, 'create'])->name('create');
    Route::post('/', [LessonController::class, 'store'])->name('store');
    Route::get('/{lesson}', [LessonController::class, 'show'])->name('show');
    Route::get('/{lesson}/edit', [LessonController::class, 'edit'])->name('edit');
    Route::put('/{lesson}', [LessonController::class, 'update'])->name('update');
    Route::delete('/{lesson}', [LessonController::class, 'destroy'])->name('destroy');
});






// Teacher Group Management Routes
Route::middleware(['auth', 'subscription'])->prefix('teacher')->name('teacher.')->group(function () {

    // Group CRUD operations
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index')->middleware(['auth', 'role:teacher']);
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store')->middleware(['auth', 'role:teacher']);
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create')->middleware(['auth', 'role:teacher']);
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit')->middleware(['auth', 'role:teacher']);
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update')->middleware(['auth', 'role:teacher']);
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show')->middleware(['auth', 'role:teacher']);
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy')->middleware(['auth', 'role:teacher']);

    // Group member management
    Route::post('/groups/add-student', [GroupController::class, 'addStudent'])->name('groups.add-student')->middleware(['auth', 'role:teacher']);
    Route::patch('/groups/requests/{groupMember}/approve', [GroupController::class, 'approveRequest'])->name('groups.approve-request')->middleware(['auth', 'role:teacher']);
    Route::patch('/groups/requests/{groupMember}/reject', [GroupController::class, 'rejectRequest'])->name('groups.reject-request')->middleware(['auth', 'role:teacher']);
    Route::delete('/groups/{group}/members/{member}', [GroupController::class, 'removeMember'])->name('groups.remove-member')->middleware(['auth', 'role:teacher']);

    // Group statistics
    Route::get('/groups/{group}/stats', [GroupController::class, 'getGroupStats'])->name('groups.stats')->middleware(['auth', 'role:teacher']);

    // AJAX routes
    Route::get('/groups/search/students', [GroupController::class, 'searchStudents'])->name('groups.search-students')->middleware(['auth', 'role:teacher']);

    // Session creation alias for teacher groups
    Route::get('/groups/{group}/sessions/create', [SessionController::class, 'create'])->name('groups.sessions.create');
});


// Student Group Routes (for joining groups)
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::post('/groups/{group}/join', [GroupController::class, 'joinGroup'])->name('groups.join');
    
});

// Sessions Routes
Route::prefix('teacher/sessions')->middleware(['auth', 'role:teacher', 'subscription'])->name('teacher.sessions.')->group(function () {
    Route::get('/', [SessionController::class, 'index'])->name('index');
    Route::get('/create', [SessionController::class, 'create'])->name('create');
    Route::post('/', [SessionController::class, 'store'])->name('store');
    Route::get('/{session}', [SessionController::class, 'show'])->name('show');
    Route::get('/{session}/edit', [SessionController::class, 'edit'])->name('edit');
    Route::put('/{session}', [SessionController::class, 'update'])->name('update');
    Route::delete('/{session}', [SessionController::class, 'destroy'])->name('destroy');
});


Route::middleware(['auth', 'role:teacher', 'subscription'])->prefix('teacher')->name('teacher.')->group(function () {
    // الواجبات
    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/assignments/{id}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/assignments/{id}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/assignments/{id}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/assignments/{id}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::delete('/assignments/{id}/files/{index}', [AssignmentController::class, 'deleteFile'])
    ->name('assignments.deleteFile');
});

Route::middleware(['auth', 'role:teacher', 'subscription'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/answers/{id}', [AssignmentAnswerController::class, 'show'])->name('answers.show');
    Route::put('/answers/{id}', [AssignmentAnswerController::class, 'update'])->name('answers.update');
});
// 🟢 واجبات الطالب
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    // قائمة الواجبات
    Route::get('/assignments', [AssignmentController::class, 'studentIndex'])->name('assignments.index');

    // عرض واجب معين
    Route::get('/assignments/{id}', [AssignmentController::class, 'studentShow'])->name('assignments.show');

    // تسليم الواجب
    Route::post('/assignments/{id}/submit', [AssignmentAnswerController::class, 'submit'])->name('assignments.submit');
    Route::post('/assignments/{id}/resubmit', [AssignmentAnswerController::class, 'resubmit'])
    ->name('assignments.resubmit');

    // عرض النتيجة
    Route::get('/assignments/{id}/result', [AssignmentAnswerController::class, 'result'])->name('assignments.result');
});

// Exams Routes
Route::middleware(['auth', 'role:teacher', 'subscription'])->prefix('teacher')->name('teacher.')->group(function () {
    // الامتحانات
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');     // عرض كل الامتحانات
    Route::get('/exams/create', [ExamController::class, 'index'])->name('exams.create'); // فورم إنشاء امتحان
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');   // حفظ امتحان جديد

    Route::get('/exams/{id}', [ExamController::class, 'show'])->name('exams.show'); // عرض امتحان
    Route::get('/exams/{exam_id}/results/{student_id}', [ExamController::class, 'studentResultDetails'])->name('exams.studentResultDetails');
    Route::get('/exams/{id}/edit', [ExamController::class, 'edit'])->name('exams.edit'); // تعديل امتحان
    Route::put('/exams/{id}', [ExamController::class, 'update'])->name('exams.update');  // تحديث امتحان
    Route::delete('/exams/{id}', [ExamController::class, 'destroy'])->name('exams.destroy'); // حذف امتحان

    // الأسئلة
    Route::post('/exams/{exam}/add-question', [ExamController::class, 'addQuestion'])->name('exams.addQuestion');
    Route::get('/questions/{id}/edit', [ExamController::class, 'quesEdit'])->name('questions.edit');
    Route::put('/questions/{id}', [ExamController::class, 'quesUpdate'])->name('questions.update');
    Route::delete('/questions/{id}', [ExamController::class, 'quesDestroy'])->name('questions.destroy');
});

// ==========================
// 🟢 Student Exams Routes
// ==========================
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.exams.')->group(function () {

    // عرض قائمة الامتحانات المتاحة للطالب
    Route::get('/exams', [ExamController::class, 'availableExams'])->name('index');

    // تفاصيل الامتحان قبل البدء
    Route::get('/exams/{id}', [ExamController::class, 'showExam'])->name('show');

    // شاشة التعليمات قبل البدء
    Route::get('/exams/{id}/start', [ExamController::class, 'start'])->name('start');

    // محاولة الامتحان (عرض الأسئلة + المؤقت)
    Route::get('/exams/{id}/attempt', [ExamController::class, 'start'])->name('attempt');

    // تسليم الامتحان
    Route::post('/exams/{id}/submit', [ExamController::class, 'submit'])->name('submit');

    // عرض النتيجة
    Route::get('/exams/{id}/result', [ExamController::class, 'result'])->name('result');
    // student exam AJAX routes
Route::get('/exams/{id}/attempt-data', [ExamController::class, 'attemptData'])
    ->name('attempt_data');

Route::post('/exams/{id}/save-answer', [ExamController::class, 'saveAnswerAjax'])
    ->name('save_answer');

Route::post('/exams/{id}/auto-submit', [ExamController::class, 'autoSubmitAjax'])
    ->name('auto_submit');

Route::post('/exams/{id}/save-elapsed-time', [ExamController::class, 'saveElapsedTime'])
    ->name('save_elapsed_time');

});


// Students Routes
Route::middleware(['auth', 'role:student'])->prefix('students')->name('students.')->group(function () {
    Route::get('/', [StudentController::class, 'home'])->name('index');
    Route::get('/{student}', [StudentController::class, 'show'])->name('show');
    Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
    Route::put('/{student}', [StudentController::class, 'update'])->name('update');
});

// Enrollments Routes
Route::prefix('enrollments')->name('enrollments.')->group(function () {
    Route::get('/', [EnrollmentController::class, 'index'])->name('index')->middleware(['auth', 'role:teacher', 'subscription']);
    Route::post('/{course}', [EnrollmentController::class, 'store'])->name('store')->middleware(['auth', 'role:student']);;
    Route::put('/{enrollment}/approve', [EnrollmentController::class, 'approve'])->name('approve')->middleware(['auth', 'role:teacher', 'subscription']);
    Route::put('/{enrollment}/reject', [EnrollmentController::class, 'reject'])->name('reject')->middleware(['auth', 'role:teacher', 'subscription']);
    Route::put('/{enrollment}/complete', [EnrollmentController::class, 'complete'])->name('complete')->middleware(['auth', 'role:teacher', 'subscription']);
    Route::delete('/{enrollment}', [EnrollmentController::class, 'destroy'])->name('destroy')->middleware(['auth', 'role:teacher', 'subscription']);
});

// Student Management Routes
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/home', [StudentController::class, 'home'])->name('home');
    Route::get('/groups', [StudentController::class, 'groups'])->name('groups');
    Route::get('/groups/{id}', [StudentController::class, 'showGroup'])->name('groups.show');
    Route::post('/groups/{id}/join', [StudentController::class, 'requestJoin'])->name('groups.join');
    Route::get('/sessions', [StudentController::class, 'sessions'])->name('sessions');
    Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
    Route::get('/courses/{course}', [StudentController::class, 'showCourse'])->name('courses.show');
    Route::get('/courses/{course}/lessons/{lesson}', [StudentController::class, 'showLesson'])->name('lessons.show');
    Route::get('/teachers', [StudentController::class, 'teachers'])->name('teachers');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/lessons/{lesson}/video', [LessonController::class, 'streamVideo'])
        ->name('lessons.video');
});

use App\Http\Controllers\ContactController;
Route::post('/teacher/contact', [ContactController::class, 'store'])->name('contact.store');
Route::prefix('/teacher/contact')->name('teacher.contact.')->middleware(['auth', 'role:teacher', 'subscription'])->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('index');
    Route::get('/{id}', [ContactController::class, 'show'])->name('show');
    Route::delete('/{id}', [ContactController::class, 'destroy'])->name('destroy');
});
use App\Http\Controllers\ChatController;

// Student Management (for Teachers)
Route::middleware(['auth', 'role:teacher', 'subscription'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/students', [\App\Http\Controllers\Teacher\StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student}', [\App\Http\Controllers\Teacher\StudentController::class, 'show'])->name('students.show');
    
    // Teacher Chat
    Route::prefix('chat')->name('chat.')->group(function () {
        Route::get('/', [ChatController::class, 'index'])->name('index');
        Route::get('/{student}', [ChatController::class, 'show'])->name('show');
        Route::post('/{student}', [ChatController::class, 'store'])->name('store');
    });
});

// Student Chat Routes
Route::middleware(['auth', 'role:student'])
    ->prefix('student')
    ->name('student.chat.')
    ->group(function () {
        Route::get('/chat/{teacher_id?}', [ChatController::class, 'index'])->name('index');
        Route::post('/chat/send/{teacher_id}', [ChatController::class, 'store'])->name('store');
    });



// Public Pages
Route::get('/courses', [CourseController::class, 'publicIndex'])->name('pages.courses');
Route::get('/courses/{course}', [CourseController::class, 'publicShow'])->name('pages.courses.show');
Route::view('/how-to-register-teacher', 'pages.how-to-register-teacher')->name('pages.how-to-register-teacher');
Route::view('/features', 'pages.features')->name('pages.features');

// 👑 Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('dashboard');
    
    // Teachers CRUD
    Route::get('/teachers', [App\Http\Controllers\Admin\TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create', [App\Http\Controllers\Admin\TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers', [App\Http\Controllers\Admin\TeacherController::class, 'store'])->name('teachers.store');
    Route::get('/teachers/{teacher}/edit', [App\Http\Controllers\Admin\TeacherController::class, 'edit'])->name('teachers.edit');
    Route::put('/teachers/{teacher}', [App\Http\Controllers\Admin\TeacherController::class, 'update'])->name('teachers.update');
    Route::delete('/teachers/{teacher}', [App\Http\Controllers\Admin\TeacherController::class, 'destroy'])->name('teachers.destroy');
    
    // Account Status
    Route::post('/teachers/{teacher}/toggle-status', [App\Http\Controllers\Admin\AdminController::class, 'toggleStatus'])->name('teachers.toggle-status');
    Route::post('/teachers/{teacher}/disable-until', [App\Http\Controllers\Admin\AdminController::class, 'disableUntil'])->name('teachers.disable-until');

    // Accounting
    Route::get('/accounting', [App\Http\Controllers\Admin\AdminController::class, 'accounting'])->name('accounting.index');
    
    // Teacher Stats
    Route::get('/teachers/{teacher}/stats', [App\Http\Controllers\Admin\TeacherController::class, 'stats'])->name('teachers.stats');
    
    // Subscriptions
    Route::get('/teachers/{teacher}/renew', [App\Http\Controllers\Admin\SubscriptionController::class, 'renew'])->name('teachers.renew');
    Route::post('/teachers/{teacher}/renew', [App\Http\Controllers\Admin\SubscriptionController::class, 'processRenewal'])->name('teachers.process-renewal');
});

// =========================================================================
// 🔄 LEGACY COMPATIBILITY ALIASES (Strictly for Test Suite Compatibility)
// =========================================================================
Route::middleware(['auth', 'role:teacher'])->group(function () {
    
    // Courses Aliases
    Route::get('/teacher/courses{_dummy?}', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/teacher/courses/create{_dummy?}', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/teacher/courses{_dummy?}', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/teacher/courses/{course}{_dummy?}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/teacher/courses/{course}/edit{_dummy?}', [CourseController::class, 'edit'])->name('courses.edit');
    Route::put('/teacher/courses/{course}{_dummy?}', [CourseController::class, 'update'])->name('courses.update');
    Route::delete('/teacher/courses/{course}{_dummy?}', [CourseController::class, 'destroy'])->name('courses.destroy');

    // Lessons Aliases
    Route::get('/teacher/lessons{_dummy?}', [LessonController::class, 'index'])->name('lessons.index');
    Route::get('/teacher/lessons/create{_dummy?}', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/teacher/lessons{_dummy?}', [LessonController::class, 'store'])->name('lessons.store');
    Route::get('/teacher/lessons/{lesson}{_dummy?}', [LessonController::class, 'show'])->name('lessons.show');
    Route::get('/teacher/lessons/{lesson}/edit{_dummy?}', [LessonController::class, 'edit'])->name('lessons.edit');
    Route::put('/teacher/lessons/{lesson}{_dummy?}', [LessonController::class, 'update'])->name('lessons.update');
    Route::delete('/teacher/lessons/{lesson}{_dummy?}', [LessonController::class, 'destroy'])->name('lessons.destroy');

    // Sessions Aliases
    Route::get('/teacher/sessions{_dummy?}', [SessionController::class, 'index'])->name('sessions.index');
    Route::get('/teacher/sessions/create{_dummy?}', [SessionController::class, 'create'])->name('sessions.create');
    Route::post('/teacher/sessions{_dummy?}', [SessionController::class, 'store'])->name('sessions.store');
    Route::get('/teacher/sessions/{session}{_dummy?}', [SessionController::class, 'show'])->name('sessions.show');
    Route::get('/teacher/sessions/{session}/edit{_dummy?}', [SessionController::class, 'edit'])->name('sessions.edit');
    Route::put('/teacher/sessions/{session}{_dummy?}', [SessionController::class, 'update'])->name('sessions.update');
    Route::delete('/teacher/sessions/{session}{_dummy?}', [SessionController::class, 'destroy'])->name('sessions.destroy');

    // Assignments Aliases
    Route::get('/teacher/assignments{_dummy?}', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/teacher/assignments/create{_dummy?}', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/teacher/assignments{_dummy?}', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/teacher/assignments/{id}{_dummy?}', [AssignmentController::class, 'show'])->name('assignments.show');
    Route::get('/teacher/assignments/{id}/edit{_dummy?}', [AssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('/teacher/assignments/{id}{_dummy?}', [AssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('/teacher/assignments/{id}{_dummy?}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::delete('/teacher/assignments/{id}/files/{index}', [AssignmentController::class, 'deleteFile'])
        ->name('assignments.deleteFile');

    // Exams Aliases
    Route::get('/teacher/exams{_dummy?}', [ExamController::class, 'index'])->name('exams.index');
    Route::get('/teacher/exams/create{_dummy?}', [ExamController::class, 'create'])->name('exams.create');
    Route::post('/teacher/exams{_dummy?}', [ExamController::class, 'store'])->name('exams.store');
    Route::get('/teacher/exams/{id}{_dummy?}', [ExamController::class, 'show'])->name('exams.show');
    Route::get('/teacher/exams/{id}/edit{_dummy?}', [ExamController::class, 'edit'])->name('exams.edit');
    Route::put('/teacher/exams/{id}{_dummy?}', [ExamController::class, 'update'])->name('exams.update');
    Route::delete('/teacher/exams/{id}{_dummy?}', [ExamController::class, 'destroy'])->name('exams.destroy');

    // Exam Questions Aliases
    Route::post('/exams/{exam}/add-question', [ExamController::class, 'addQuestion'])->name('exams.addQuestion');
    Route::get('/questions/{id}/edit', [ExamController::class, 'quesEdit'])->name('questions.edit');
    Route::put('/questions/{id}', [ExamController::class, 'quesUpdate'])->name('questions.update');
    Route::delete('/questions/{id}', [ExamController::class, 'quesDestroy'])->name('questions.destroy');
});

// Fallback for legacy views still referencing route('dashboard')
Route::get('/dashboard-legacy', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        if ($role === 'teacher') return redirect()->route('teacher.dashboard');
        if ($role === 'student') return redirect()->route('student.home');
        if ($role === 'admin') return redirect()->route('admin.dashboard');
    }
    return redirect('/');
})->name('dashboard');

require __DIR__.'/auth.php';