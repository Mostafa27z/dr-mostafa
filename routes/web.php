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
Route::middleware(['auth', 'role:student'])->group(function () {
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

// Assignments Routes
Route::prefix('assignments')->name('assignments.')->group(function () {
    Route::get('/', [AssignmentController::class, 'index'])->name('index');
    Route::get('/create', [AssignmentController::class, 'create'])->name('create');
    Route::post('/', [AssignmentController::class, 'store'])->name('store');
    Route::get('/{assignment}', [AssignmentController::class, 'show'])->name('show');
    Route::get('/{assignment}/edit', [AssignmentController::class, 'edit'])->name('edit');
    Route::put('/{assignment}', [AssignmentController::class, 'update'])->name('update');
    Route::delete('/{assignment}', [AssignmentController::class, 'destroy'])->name('destroy');
    
    // Assignment Answers Routes
    Route::get('/{assignment}/answers', [AssignmentController::class, 'answers'])->name('answers');
    Route::get('/answers/{answer}/grade', [AssignmentController::class, 'showGrade'])->name('answers.grade');
    Route::post('/answers/{answer}/grade', [AssignmentController::class, 'grade'])->name('answers.submit-grade');
});

// Exams Routes
Route::prefix('exams')->name('exams.')->group(function () {
    Route::get('/', [ExamController::class, 'index'])->name('index');
    Route::get('/create', [ExamController::class, 'create'])->name('create');
    Route::post('/', [ExamController::class, 'store'])->name('store');
    Route::get('/{exam}', [ExamController::class, 'show'])->name('show');
    Route::get('/{exam}/edit', [ExamController::class, 'edit'])->name('edit');
    Route::put('/{exam}', [ExamController::class, 'update'])->name('update');
    Route::delete('/{exam}', [ExamController::class, 'destroy'])->name('destroy');
    
    // Exam Questions Routes
    Route::get('/{exam}/questions', [ExamController::class, 'questions'])->name('questions');
    Route::post('/{exam}/questions', [ExamController::class, 'storeQuestion'])->name('questions.store');
    Route::delete('/questions/{question}', [ExamController::class, 'destroyQuestion'])->name('questions.destroy');
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

require __DIR__.'/auth.php';