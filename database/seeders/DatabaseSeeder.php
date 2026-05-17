<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Users
        $this->call(UserSeeder::class);

        // Get the teachers created by UserSeeder
        $teachers = User::where('role', 'teacher')->get();
        // Get the students created by UserSeeder
        $students = User::where('role', 'student')->get();

        // 2. Seed Courses, Lessons, Exams, Assignments
        foreach ($teachers as $teacher) {
            $courses = \App\Models\Course::factory(rand(1, 2))->create([
                'teacher_id' => $teacher->id
            ]);

            foreach ($courses as $course) {
                $lessons = \App\Models\Lesson::factory(rand(3, 5))->create([
                    'course_id' => $course->id
                ]);

                foreach ($lessons as $lesson) {
                    // Create Assignment
                    \App\Models\Assignment::factory()->create([
                        'lesson_id' => $lesson->id,
                        'group_id' => null,
                        'title' => 'واجب: ' . $lesson->title,
                    ]);

                    // Create Exam
                    $exam = \App\Models\Exam::factory()->create([
                        'lesson_id' => $lesson->id,
                        'teacher_id' => $teacher->id,
                        'title' => 'اختبار: ' . $lesson->title,
                    ]);

                    // Create Questions for this exam
                    $questions = \App\Models\ExamQuestion::factory(5)->create([
                        'exam_id' => $exam->id
                    ]);

                    foreach ($questions as $question) {
                        \App\Models\ExamQuestionOption::factory(4)->create([
                            'exam_question_id' => $question->id
                        ]);
                    }
                }

                // 3. Seed Groups for each course
                $group = \App\Models\Group::factory()->create([
                    'teacher_id' => $teacher->id,
                    'title' => 'مجموعة: ' . $course->title,
                ]);

                \App\Models\GroupSession::factory(rand(2, 3))->create([
                    'group_id' => $group->id
                ]);
            }
        }

        // 4. Enroll Students and generate interaction data
        $courses = \App\Models\Course::all();
        $groups = \App\Models\Group::all();

        foreach ($students as $student) {
            // Enroll in 1-2 random courses
            $enrolledCourses = $courses->random(rand(1, 2));
            foreach ($enrolledCourses as $course) {
                \App\Models\CourseEnrollment::create([
                    'student_id' => $student->id,
                    'course_id' => $course->id,
                    'status' => 'approved',
                    'enrolled_at' => now(),
                    'paid_amount' => 100.00,
                    'payment_method' => 'cash',
                ]);
            }

            // Join 1 random group
            $joinedGroup = $groups->random();
            \App\Models\GroupMember::create([
                'student_id' => $student->id,
                'group_id' => $joinedGroup->id,
                'status' => 'approved',
            ]);
        }

        // 5. Seed Contact Messages
        \App\Models\ContactMessage::factory(5)->create();

        // 6. Seed some chats
        if ($students->isNotEmpty() && $teachers->isNotEmpty()) {
            foreach ($students->random(min(3, $students->count())) as $student) {
                $teacher = $teachers->random();
                \App\Models\Chat::create([
                    'sender_id' => $student->id,
                    'receiver_id' => $teacher->id,
                    'message' => 'السلام عليكم يا دكتور، عندي سؤال بخصوص الدرس الأخير.',
                ]);
                \App\Models\Chat::create([
                    'sender_id' => $teacher->id,
                    'receiver_id' => $student->id,
                    'message' => 'وعليكم السلام، تفضل يا بني.',
                ]);
            }
        }
    }
}
