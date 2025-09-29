@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Financial Model</h2>
    <hr>

    <p><strong>Total Students:</strong> {{ count($students) }}</p>
    <p><strong>Total Course Enrollments:</strong> {{ $totalEnrollments }}</p>
    <p><strong>Total Revenue:</strong> ₹{{ number_format($totalRevenue, 2) }}</p>
    <p><strong>Total Expense:</strong> ₹{{ number_format($totalExpenses, 2) }}</p>


    <hr>
    <h4>Student-wise Enrollment & Fees</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Courses Enrolled</th>
                <th>Total Fees</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->full_name }}</td>
                    <td>
                        @foreach($student->courses as $course)
                            {{ $course->course_name }} (₹{{ $course->course_fee }})<br>
                        @endforeach
                    </td>
                    <td>₹{{ $student->courses->sum('course_fee') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

      <hr>
    <h4>Financial Expenses</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Expense Item</th>
                <th>Amount (₹)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->name }}</td>
                    <td>₹{{ number_format($expense->amount, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
