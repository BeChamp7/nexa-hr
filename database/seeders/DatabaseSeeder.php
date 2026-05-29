<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ---- Admin user -------------------------------------------------
        $admin = User::updateOrCreate(
            ['email' => 'admin@nexahr.test'],
            [
                'name' => 'Sarah Ahmed',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // ---- Departments ------------------------------------------------
        $departments = collect([
            ['name' => 'Engineering',      'code' => 'ENG', 'description' => 'Product development & infrastructure'],
            ['name' => 'Human Resources',  'code' => 'HR',  'description' => 'People operations & recruitment'],
            ['name' => 'Sales',            'code' => 'SAL', 'description' => 'Revenue & client acquisition'],
            ['name' => 'Finance',          'code' => 'FIN', 'description' => 'Accounting, payroll & budgeting'],
            ['name' => 'Marketing',        'code' => 'MKT', 'description' => 'Brand, growth & communications'],
            ['name' => 'Operations',       'code' => 'OPS', 'description' => 'Logistics & internal operations'],
        ])->mapWithKeys(function ($d) {
            $dept = Department::updateOrCreate(['code' => $d['code']], $d);
            return [$d['code'] => $dept];
        });

        // ---- Employees --------------------------------------------------
        $employees = [
            ['Ali', 'Raza', 'ENG', 'Senior Software Engineer', 'full_time', '2021-03-15', 285000, 'active'],
            ['Fatima', 'Khan', 'ENG', 'Frontend Developer', 'full_time', '2022-07-01', 190000, 'active'],
            ['Bilal', 'Hussain', 'ENG', 'DevOps Engineer', 'full_time', '2020-11-20', 240000, 'active'],
            ['Ayesha', 'Siddiqui', 'HR', 'HR Manager', 'full_time', '2019-05-10', 220000, 'active'],
            ['Usman', 'Malik', 'HR', 'Recruiter', 'full_time', '2023-01-09', 130000, 'active'],
            ['Zainab', 'Iqbal', 'SAL', 'Sales Director', 'full_time', '2018-02-25', 320000, 'active'],
            ['Hamza', 'Sheikh', 'SAL', 'Account Executive', 'full_time', '2022-09-12', 160000, 'on_leave'],
            ['Maria', 'Yousaf', 'SAL', 'Sales Associate', 'contract', '2023-06-01', 95000, 'active'],
            ['Omar', 'Farooq', 'FIN', 'Finance Lead', 'full_time', '2019-08-30', 270000, 'active'],
            ['Hina', 'Aslam', 'FIN', 'Accountant', 'full_time', '2021-12-05', 145000, 'active'],
            ['Daniyal', 'Akhtar', 'MKT', 'Marketing Manager', 'full_time', '2020-04-18', 210000, 'active'],
            ['Sana', 'Tariq', 'MKT', 'Content Strategist', 'part_time', '2023-03-22', 85000, 'active'],
            ['Kashif', 'Mehmood', 'OPS', 'Operations Manager', 'full_time', '2019-10-14', 230000, 'active'],
            ['Rabia', 'Nawaz', 'OPS', 'Logistics Coordinator', 'full_time', '2022-02-08', 120000, 'inactive'],
        ];

        $created = collect();
        foreach ($employees as $i => $e) {
            [$first, $last, $deptCode, $position, $type, $hire, $salary, $status] = $e;
            $emp = Employee::updateOrCreate(
                ['email' => strtolower($first . '.' . $last) . '@nexahr.test'],
                [
                    'employee_code' => 'EMP-' . str_pad($i + 1001, 4, '0', STR_PAD_LEFT),
                    'first_name' => $first,
                    'last_name' => $last,
                    'phone' => '+92 3' . rand(0, 4) . rand(0, 9) . ' ' . rand(1000000, 9999999),
                    'department_id' => $departments[$deptCode]->id,
                    'position' => $position,
                    'employment_type' => $type,
                    'hire_date' => $hire,
                    'salary' => $salary,
                    'status' => $status,
                    'address' => rand(1, 99) . ' ' . ['Gulberg', 'DHA Phase 5', 'Bahria Town', 'Clifton', 'F-10 Sector'][rand(0, 4)] . ', ' . ['Lahore', 'Karachi', 'Islamabad'][rand(0, 2)],
                ]
            );
            $created->push($emp);
        }

        // ---- Leave requests --------------------------------------------
        LeaveRequest::query()->delete();

        $leaves = [
            // [employee index, type, start, end, status, reason]
            [6, 'annual', '+2 days', '+6 days', 'approved', 'Family vacation to Northern Areas.'],
            [0, 'sick', '-5 days', '-3 days', 'approved', 'Flu and high fever, advised rest by doctor.'],
            [1, 'casual', '+10 days', '+10 days', 'pending', 'Attending a cousin\'s wedding.'],
            [4, 'annual', '+14 days', '+20 days', 'pending', 'Annual leave – Eid holidays with family.'],
            [9, 'sick', '-1 days', '+1 days', 'pending', 'Medical procedure and recovery.'],
            [11, 'unpaid', '+30 days', '+44 days', 'pending', 'Extended personal leave abroad.'],
            [2, 'casual', '-12 days', '-12 days', 'approved', 'Personal errands.'],
            [7, 'annual', '-20 days', '-15 days', 'rejected', 'Requested during product launch freeze.'],
            [10, 'sick', '+3 days', '+4 days', 'pending', 'Scheduled dental surgery.'],
            [3, 'annual', '+25 days', '+29 days', 'approved', 'Pre-planned holiday.'],
            [12, 'casual', '+1 days', '+2 days', 'pending', 'Home maintenance emergency.'],
        ];

        foreach ($leaves as $l) {
            [$idx, $type, $start, $end, $status, $reason] = $l;
            $startDate = Carbon::parse($start);
            $endDate = Carbon::parse($end);
            $reviewed = $status !== 'pending';

            LeaveRequest::create([
                'employee_id' => $created[$idx]->id,
                'type' => $type,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
                'days' => $startDate->diffInDays($endDate) + 1,
                'reason' => $reason,
                'status' => $status,
                'reviewed_by' => $reviewed ? $admin->id : null,
                'reviewed_at' => $reviewed ? now()->subDays(rand(1, 10)) : null,
                'review_note' => $status === 'rejected' ? 'Cannot be accommodated during this period.' : null,
            ]);
        }
    }
}
