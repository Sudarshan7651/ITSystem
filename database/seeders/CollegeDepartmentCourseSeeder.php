<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Course;
use App\Models\Department;
use Illuminate\Database\Seeder;

class CollegeDepartmentCourseSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name'       => 'ABC Engineering College',
                'short_name' => 'ABCEC',
                'location'   => 'Mumbai',
                'departments' => [
                    [
                        'name'       => 'Computer Science & Engineering',
                        'short_name' => 'CSE',
                        'courses' => [
                            ['name' => 'B.Tech Computer Science & Engineering', 'short_name' => 'B.Tech CSE', 'duration_years' => 4],
                            ['name' => 'M.Tech Computer Science & Engineering', 'short_name' => 'M.Tech CSE', 'duration_years' => 2],
                            ['name' => 'MCA (Master of Computer Applications)',  'short_name' => 'MCA',       'duration_years' => 2],
                        ],
                    ],
                    [
                        'name'       => 'Electronics & Communication Engineering',
                        'short_name' => 'ECE',
                        'courses' => [
                            ['name' => 'B.Tech Electronics & Communication',     'short_name' => 'B.Tech ECE',  'duration_years' => 4],
                            ['name' => 'M.Tech VLSI Design',                     'short_name' => 'M.Tech VLSI', 'duration_years' => 2],
                        ],
                    ],
                    [
                        'name'       => 'Mechanical Engineering',
                        'short_name' => 'ME',
                        'courses' => [
                            ['name' => 'B.Tech Mechanical Engineering',  'short_name' => 'B.Tech ME',  'duration_years' => 4],
                            ['name' => 'M.Tech Thermal Engineering',     'short_name' => 'M.Tech TE',  'duration_years' => 2],
                        ],
                    ],
                    [
                        'name'       => 'Civil Engineering',
                        'short_name' => 'CE',
                        'courses' => [
                            ['name' => 'B.Tech Civil Engineering',       'short_name' => 'B.Tech CE',  'duration_years' => 4],
                        ],
                    ],
                ],
            ],
            [
                'name'       => 'XYZ Institute of Technology',
                'short_name' => 'XYZIT',
                'location'   => 'Pune',
                'departments' => [
                    [
                        'name'       => 'Information Technology',
                        'short_name' => 'IT',
                        'courses' => [
                            ['name' => 'B.Tech Information Technology', 'short_name' => 'B.Tech IT', 'duration_years' => 4],
                            ['name' => 'M.Tech Information Security',   'short_name' => 'M.Tech IS', 'duration_years' => 2],
                        ],
                    ],
                    [
                        'name'       => 'Computer Science & Engineering',
                        'short_name' => 'CSE',
                        'courses' => [
                            ['name' => 'B.Tech Computer Science & Engineering', 'short_name' => 'B.Tech CSE', 'duration_years' => 4],
                            ['name' => 'BCA (Bachelor of Computer Applications)', 'short_name' => 'BCA',      'duration_years' => 3],
                        ],
                    ],
                    [
                        'name'       => 'Electrical Engineering',
                        'short_name' => 'EE',
                        'courses' => [
                            ['name' => 'B.Tech Electrical Engineering', 'short_name' => 'B.Tech EE', 'duration_years' => 4],
                        ],
                    ],
                ],
            ],
            [
                'name'       => 'PQR College of Science',
                'short_name' => 'PQRCS',
                'location'   => 'Bangalore',
                'departments' => [
                    [
                        'name'       => 'Computer Science',
                        'short_name' => 'CS',
                        'courses' => [
                            ['name' => 'B.Sc Computer Science',  'short_name' => 'B.Sc CS',  'duration_years' => 3],
                            ['name' => 'M.Sc Computer Science',  'short_name' => 'M.Sc CS',  'duration_years' => 2],
                        ],
                    ],
                    [
                        'name'       => 'Data Science & AI',
                        'short_name' => 'DS&AI',
                        'courses' => [
                            ['name' => 'B.Sc Data Science',           'short_name' => 'B.Sc DS',  'duration_years' => 3],
                            ['name' => 'M.Sc Artificial Intelligence', 'short_name' => 'M.Sc AI', 'duration_years' => 2],
                        ],
                    ],
                    [
                        'name'       => 'Mathematics & Statistics',
                        'short_name' => 'Math',
                        'courses' => [
                            ['name' => 'B.Sc Mathematics',   'short_name' => 'B.Sc Math',  'duration_years' => 3],
                            ['name' => 'M.Sc Statistics',    'short_name' => 'M.Sc Stats', 'duration_years' => 2],
                        ],
                    ],
                ],
            ],
        ];

        foreach ($data as $collegeData) {
            $college = College::create([
                'name'       => $collegeData['name'],
                'short_name' => $collegeData['short_name'],
                'location'   => $collegeData['location'],
                'status'     => 'active',
            ]);

            foreach ($collegeData['departments'] as $deptData) {
                $department = Department::create([
                    'college_id' => $college->id,
                    'name'       => $deptData['name'],
                    'short_name' => $deptData['short_name'],
                    'status'     => 'active',
                ]);

                foreach ($deptData['courses'] as $courseData) {
                    Course::create([
                        'department_id' => $department->id,
                        'name'          => $courseData['name'],
                        'short_name'    => $courseData['short_name'],
                        'duration_years'=> $courseData['duration_years'],
                        'status'        => 'active',
                    ]);
                }
            }
        }

        $this->command->info('✅ Colleges, Departments, and Courses seeded successfully!');
        $this->command->info('   📍 3 Colleges | 10 Departments | 21 Courses');
    }
}
