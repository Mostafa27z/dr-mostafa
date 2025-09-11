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
use App\Http\Middleware\Role as role;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard Routes
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->name('home');

// Authentication Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Courses Routes
Route::prefix('courses')->name('courses.')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('index');
    Route::get('/create', [CourseController::class, 'create'])->name('create');
    Route::post('/', [CourseController::class, 'store'])->name('store');
    Route::get('/{course}', [CourseController::class, 'show'])->name('show');
    Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('edit');
    Route::put('/{course}', [CourseController::class, 'update'])->name('update');
    Route::delete('/{course}', [CourseController::class, 'destroy'])->name('destroy');
});

// Lessons Routes
Route::prefix('lessons')->name('lessons.')->group(function () {
    Route::get('/', [LessonController::class, 'index'])->name('index');
    Route::get('/create', [LessonController::class, 'create'])->name('create');
    Route::post('/', [LessonController::class, 'store'])->name('store');
    Route::get('/{lesson}', [LessonController::class, 'show'])->name('show');
    Route::get('/{lesson}/edit', [LessonController::class, 'edit'])->name('edit');
    Route::put('/{lesson}', [LessonController::class, 'update'])->name('update');
    Route::delete('/{lesson}', [LessonController::class, 'destroy'])->name('destroy');
});






// Teacher Group Management Routes
Route::middleware(['auth'])->prefix('teacher')->name('teacher.')->group(function () {

    // Group CRUD operations
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::get('/groups/{group}', [GroupController::class, 'show'])->name('groups.show');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');

    // Group member management
    Route::post('/groups/add-student', [GroupController::class, 'addStudent'])->name('groups.add-student');
    Route::patch('/groups/requests/{groupMember}/approve', [GroupController::class, 'approveRequest'])->name('groups.approve-request');
    Route::patch('/groups/requests/{groupMember}/reject', [GroupController::class, 'rejectRequest'])->name('groups.reject-request');
    Route::delete('/groups/{group}/members/{member}', [GroupController::class, 'removeMember'])->name('groups.remove-member');

    // Group statistics
    Route::get('/groups/{group}/stats', [GroupController::class, 'getGroupStats'])->name('groups.stats');

    // AJAX routes
    Route::get('/groups/search/students', [GroupController::class, 'searchStudents'])->name('groups.search-students');
});


// Student Group Routes (for joining groups)
Route::middleware(['auth'])->group(function () {
    Route::post('/groups/{group}/join', [GroupController::class, 'joinGroup'])->name('groups.join');
    Route::get('/my-groups', [GroupController::class, 'myGroups'])->name('student.groups');
});

// Sessions Routes
Route::prefix('sessions')->name('sessions.')->group(function () {
    Route::get('/', [SessionController::class, 'index'])->name('index');
    Route::get('/create', [SessionController::class, 'create'])->name('create');
    Route::post('/', [SessionController::class, 'store'])->name('store');
    Route::get('/{session}', [SessionController::class, 'show'])->name('show');
    Route::get('/{session}/edit', [SessionController::class, 'edit'])->name('edit');
    Route::put('/{session}', [SessionController::class, 'update'])->name('update');
    Route::delete('/{session}', [SessionController::class, 'destroy'])->name('destroy');
});


Route::middleware(['auth'])->group(function () {
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
    Route::get('/answers/{id}', [AssignmentAnswerController::class, 'show'])->name('answers.show');
    Route::put('/answers/{id}', [AssignmentAnswerController::class, 'update'])->name('answers.update');
});

// Exams Routes
// Exams Routes
Route::middleware(['auth'])->group(function () {
    // الامتحانات
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');     // عرض كل الامتحانات
    Route::get('/exams/create', [ExamController::class, 'index'])->name('exams.create'); // فورم إنشاء امتحان
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store');   // حفظ امتحان جديد

    Route::get('/exams/{id}', [ExamController::class, 'show'])->name('exams.show'); // عرض امتحان
    Route::get('/exams/{id}/edit', [ExamController::class, 'edit'])->name('exams.edit'); // تعديل امتحان
    Route::put('/exams/{id}', [ExamController::class, 'update'])->name('exams.update');  // تحديث امتحان
    Route::delete('/exams/{id}', [ExamController::class, 'destroy'])->name('exams.destroy'); // حذف امتحان

    // الأسئلة
    Route::post('/exams/{exam}/add-question', [ExamController::class, 'addQuestion'])->name('exams.addQuestion');
    Route::get('/questions/{id}/edit', [ExamController::class, 'quesEdit'])->name('questions.edit');
    Route::put('/questions/{id}', [ExamController::class, 'quesUpdate'])->name('questions.update');
    Route::delete('/questions/{id}', [ExamController::class, 'quesDestroy'])->name('questions.destroy');

    // الطالب
    Route::get('/student/exams', [ExamController::class, 'availableExams'])->name('student.exams');
});



// Students Routes
Route::prefix('students')->name('students.')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('index');
    Route::get('/{student}', [StudentController::class, 'show'])->name('show');
    Route::get('/{student}/edit', [StudentController::class, 'edit'])->name('edit');
    Route::put('/{student}', [StudentController::class, 'update'])->name('update');
});

// Enrollments Routes
Route::prefix('enrollments')->name('enrollments.')->group(function () {
    Route::get('/', [EnrollmentController::class, 'index'])->name('index');
    Route::post('/{course}', [EnrollmentController::class, 'store'])->name('store');
    Route::put('/{enrollment}/approve', [EnrollmentController::class, 'approve'])->name('approve');
    Route::put('/{enrollment}/reject', [EnrollmentController::class, 'reject'])->name('reject');
    Route::put('/{enrollment}/complete', [EnrollmentController::class, 'complete'])->name('complete');
    Route::delete('/{enrollment}', [EnrollmentController::class, 'destroy'])->name('destroy');
});


Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/home', [DashboardController::class, 'home'])->name('home');
    Route::get('/groups', [DashboardController::class, 'groups'])->name('groups');
    Route::get('/sessions', [DashboardController::class, 'sessions'])->name('sessions');
});

Route::prefix('student')->middleware(['auth'])->group(function () {
    Route::get('/home', [StudentController::class, 'home'])->name('student.home');
    Route::get('/groups', [StudentController::class, 'groups'])->name('student.groups');
    Route::post('/groups/{id}/join', [StudentController::class, 'requestJoin'])->name('student.groups.join');
    Route::get('/sessions', [StudentController::class, 'sessions'])->name('student.sessions');
});
Route::middleware(['auth'])->prefix('student')->name('student.')->group(function () {
    Route::get('/courses', [StudentController::class, 'courses'])->name('courses');
    Route::get('/courses/{course}', [StudentController::class, 'showCourse'])->name('courses.show');
     Route::get('/courses/{course}/lessons/{lesson}', [\App\Http\Controllers\StudentController::class, 'showLesson'])->name('lessons.show');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/lessons/{lesson}/video', [LessonController::class, 'streamVideo'])
        ->name('lessons.video');
});
require __DIR__.'/auth.php';