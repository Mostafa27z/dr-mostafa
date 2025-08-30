@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">📚 إدارة الكورسات</h2>

    <!-- Add Course Form -->
    <div class="card mb-4">
        <div class="card-header">➕ إضافة كورس جديد</div>
        <div class="card-body">
            <form>
                <div class="mb-3">
                    <label class="form-label">عنوان الكورس</label>
                    <input type="text" class="form-control" placeholder="مثال: كورس Laravel">
                </div>
                <div class="mb-3">
                    <label class="form-label">وصف الكورس</label>
                    <textarea class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">سعر الكورس</label>
                    <input type="number" class="form-control" placeholder="100">
                </div>
                <div class="mb-3">
                    <label class="form-label">صورة الكورس</label>
                    <input type="file" class="form-control">
                </div>
                <button type="submit" class="btn btn-success">إضافة</button>
            </form>
        </div>
    </div>

    <!-- Courses List -->
    <h4 class="mb-3">📖 الكورسات الموجودة</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>الصورة</th>
                <th>العنوان</th>
                <th>الوصف</th>
                <th>السعر</th>
                <th>الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><img src="https://via.placeholder.com/80" class="img-thumbnail"></td>
                <td>كورس Laravel</td>
                <td>شرح كامل للـ Laravel</td>
                <td>200</td>
                <td>
                    <button class="btn btn-primary btn-sm">✏️ تعديل</button>
                    <button class="btn btn-danger btn-sm">🗑️ حذف</button>
                </td>
            </tr>
            <tr>
                <td><img src="https://via.placeholder.com/80" class="img-thumbnail"></td>
                <td>كورس Angular</td>
                <td>أساسيات Angular</td>
                <td>150</td>
                <td>
                    <button class="btn btn-primary btn-sm">✏️ تعديل</button>
                    <button class="btn btn-danger btn-sm">🗑️ حذف</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
