<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $employees = [
            [
                'nama' => 'John Doe',
                'nip' => '198501012010011001',
            ],
            [
                'nama' => 'Jane Doe',
                'nip' => '198601022010012002',
            ],
            // Data test lainnya
        ];

        foreach ($employees as $employee) {
            Employee::create($employee);
        }
    }
} 