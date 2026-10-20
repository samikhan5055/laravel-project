
@extends('layout')

@section('title', 'Edit Student | Student Management System')

@section('content')
    <div class="card">
        <h2>Edit Student</h2>
        <p class="muted">Update the information for {{ $student->name }}.</p>

        <form method="POST" action="{{ route('students.update', $student) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input id="student_id" name="student_id"
                       value="{{ old('student_id', $student->student_id) }}"
                       required maxlength="50">
            </div>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input id="name" name="name"
                       value="{{ old('name', $student->name) }}"
                       required maxlength="255">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email"
                       value="{{ old('email', $student->email) }}"
                       required maxlength="255">
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input id="department" name="department"
                       value="{{ old('department', $student->department) }}"
                       required maxlength="255">
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester" required>
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}"
                            @selected(old('semester', $student->semester) == $i)>
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <button class="btn" type="submit">Update Student</button>
            <a class="btn btn-secondary" href="{{ route('students.index') }}">Cancel</a>
        </form>
    </div>
@endsection
