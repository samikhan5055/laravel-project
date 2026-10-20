
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Management System')</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f6fb;
            color: #1f2937;
        }
        header {
            background: #163b65;
            color: white;
            padding: 20px 6%;
        }
        header h1 { margin: 0 0 8px; font-size: 24px; }
        header p { margin: 0; color: #dbeafe; }
        nav { margin-top: 15px; }
        nav a {
            color: white;
            margin-right: 18px;
            text-decoration: none;
        }
        main {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 18px;
        }
        .card {
            background: white;
            padding: 24px;
            border-radius: 10px;
            box-shadow: 0 2px 10px #0000000d;
            margin-bottom: 20px;
        }
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 20px;
        }
        h2 { margin-top: 0; }
        .btn {
            display: inline-block;
            border: 0;
            border-radius: 6px;
            padding: 10px 15px;
            background: #1769aa;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }
        .btn-danger { background: #c0392b; }
        .btn-secondary { background: #64748b; }
        .actions { display: flex; gap: 8px; align-items: center; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            text-align: left;
            padding: 13px 10px;
            border-bottom: 1px solid #e5e7eb;
        }
        th { background: #f8fafc; }
        .form-group { margin-bottom: 17px; }
        label { display: block; margin-bottom: 7px; font-weight: bold; }
        input, select {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 15px;
        }
        .alert { padding: 13px; border-radius: 6px; margin-bottom: 18px; }
        .success { background: #dcfce7; color: #166534; }
        .error { background: #fee2e2; color: #991b1b; }
        .muted { color: #64748b; }
        .pagination { margin-top: 20px; }
        footer { text-align: center; color: #64748b; padding: 20px; }
        @media (max-width: 700px) {
            .topbar { align-items: flex-start; flex-direction: column; }
            .table-wrap { overflow-x: auto; }
            th, td { white-space: nowrap; }
        }
    </style>
</head>
<body>
    <header>
        <h1>Student Management System</h1>
        <p>Manage student records in one place</p>
        <nav>
            <a href="{{ route('students.index') }}">Students</a>
            <a href="{{ route('students.create') }}">Add Student</a>
        </nav>
    </header>

    <main>
        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert error">
                <strong>Please correct the following errors:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>Student Management System &mdash; Laravel and MySQL</footer>
</body>
</html>
