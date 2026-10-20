
@extends('layout')

@section('title', 'Student Details | Student Management System')

@section('content')
    <div class="card">
        <div class="topbar">
            <div>
                <h2>Student Details</h2>
                <p class="muted">View the complete student record.</p>
            </div>
            <a class="btn btn-secondary" href="{{ route('students.index') }}">Back to Students</a>
        </div>

        <table>
            <tbody>
                <tr><th>Student ID</th><td>{{ $student->student_id }}</td></tr>
                <tr><th>Full Name</th><td>{{ $student->name }}</td></tr>
                <tr><th>Email</th><td>{{ $student->email }}</td></tr>
                <tr><th>Department</th><td>{{ $student->department }}</td></tr>
                <tr><th>Semester</th><td>{{ $student->semester }}</td></tr>
                <tr><th>Created</th><td>{{ $student->created_at->format('d M Y, h:i A') }}</td></tr>
                <tr><th>Last Updated</th><td>{{ $student->updated_at->format('d M Y, h:i A') }}</td></tr>
            </tbody>
        </table>

        <div style="margin-top: 20px;">
            <a class="btn" href="{{ route('students.edit', $student) }}">Edit Student</a>
        </div>
    </div>
@endsection
