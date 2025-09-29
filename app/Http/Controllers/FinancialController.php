<?php

namespace Vanguard\Http\Controllers;

use Illuminate\Http\Request;
use Vanguard\Student;

class FinancialController extends Controller
{
     public function index()
    {
        // Get all students with their courses
        $students = Student::with('courses')->get();

        // Total enrollments (sum of courses per student)
        $totalEnrollments = $students->sum(fn($student) => $student->courses->count());

        // Total revenue = sum of all enrolled course fees
        $totalRevenue = $students->sum(fn($student) => $student->courses->sum('course_fee'));

         $expenses = [
    (object) ['name' => 'Rent for Classroom', 'amount' => 10000],
    (object) ['name' => 'Staff Payment', 'amount' => 20000],
    (object) ['name' => 'Electricity Bill', 'amount' => 3000],
    (object) ['name' => 'Internet Bill', 'amount' => 1500],
];
$totalExpenses = 0;
foreach ($expenses as $expense) {
    $totalExpenses += $expense->amount; // add each expense amount
}






        // Pass all data to the view
        return view('financial.index', compact(
            'students',
            'totalEnrollments',
            'totalRevenue',
            'totalExpenses',
            'expenses',
        ));
    }
}
