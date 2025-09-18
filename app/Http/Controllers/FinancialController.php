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

        // Costs
        $teacherCostPerEnrollment = 100; // example
        $marketingPerStudent = 500;       // example
        $platformCost = 20000;            // fixed

        $totalTeacherCost = $totalEnrollments * $teacherCostPerEnrollment;
        $totalMarketing = count($students) * $marketingPerStudent;

        $totalCosts = $totalTeacherCost + $totalMarketing + $platformCost;

        // Profit
        $profit = $totalRevenue - $totalCosts;

        // Pass all data to the view
        return view('financial.index', compact(
            'students',
            'totalEnrollments',
            'totalRevenue',
            'totalCosts',
            'profit'
        ));
    }
}
