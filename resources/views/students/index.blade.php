
@extends('layout')

@section('title', 'Students | Student Management System')

@section('content')
    <div class="topbar">
        <div>
            <h2>Students</h2>
            <p class="muted">View and manage registered students.</p>
        </div>
        <a href="{{ route('students.create') }}" class="btn">+ Add Student</a>
    </div>

    <div class="card">
        @if($students->isEmpty())
            <p>No students have been added yet. Select "Add Student" to create your first record.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Semester</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->student_id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->email }}</td>
                                <td>{{ $student->department }}</td>
                                <td>{{ $student->semester }}</td>
                                <td>
                                    <div class="actions">
                                        <a class="btn" href="{{ route('students.show', $student) }}">View</a>
                                        <a class="btn btn-secondary" href="{{ route('students.edit', $student) }}">Edit</a>
                                        <form method="POST" action="{{ route('students.destroy', $student) }}"
                                              onsubmit="return confirm('Delete this student?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination">{{ $students->links() }}</div>
        @endif
    </div>
@endsection
