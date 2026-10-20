
@extends('layout')

@section('title', 'Add Student | Student Management System')

@section('content')
    <div class="card">
        <h2>Add Student</h2>
        <p class="muted">Enter the student's information below.</p>

        <form method="POST" action="{{ route('students.store') }}">
            @csrf

            <div class="form-group">
                <label for="student_id">Student ID</label>
                <input id="student_id" name="student_id" value="{{ old('student_id') }}"
                       required maxlength="50" placeholder="e.g. FA23-BSE-001">
            </div>

            <div class="form-group">
                <label for="name">Full Name</label>
                <input id="name" name="name" value="{{ old('name') }}"
                       required maxlength="255" placeholder="Enter full name">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required maxlength="255" placeholder="student@example.com">
            </div>

            <div class="form-group">
                <label for="department">Department</label>
                <input id="department" name="department" value="{{ old('department') }}"
                       required maxlength="255" placeholder="e.g. Software Engineering">
            </div>

            <div class="form-group">
                <label for="semester">Semester</label>
                <select id="semester" name="semester" required>
                    <option value="">Select semester</option>
                    @for($i = 1; $i <= 8; $i++)
                        <option value="{{ $i }}" @selected(old('semester') == $i)>
                            Semester {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <button class="btn" type="submit">Save Student</button>
            <a class="btn btn-secondary" href="{{ route('students.index') }}">Cancel</a>
        </form>
    </div>
@endsection
