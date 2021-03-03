<?php

namespace Database\Seeders;

use App\Models\Staff;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class CreateAdminUserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => 'Vedyalay Super Admin',
            'email' => 'superadmin@vedyalay.com',
            'password' => Hash::make('#machinelearning5'),
            'type' => 'superadmin',
        ]);

        $role = Role::create(['name' => 'Super Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);

        $adminuser = User::create([
            'name' => 'Vedyalay Admin',
            'email' => 'admin@vedyalay.com',
            'password' => Hash::make('admin123'),
            'type' => 'admin',
        ]);
        $roleadmin = Role::create(['name' => 'Admin']);
        $adminuser->assignRole([$roleadmin->id]);

        $teacheruser = User::create([
            'name' => 'Vedyalay Teacher',
            'email' => 'teacher@vedyalay.com',
            'password' => Hash::make('teacher123'),
            'type' => 'teacher',
        ]);
        Teacher::create([
            'user_id' => $teacheruser->id,
            'image' => null,
            'phone' => '1234567890',
            'short_name' => 'VT',
            'salary' => '10000',
            'subject' => ['1','2','3','4','5'],
            'dob' => null,
            'aadhar_number' => null,
            'gender' => 'male',
            'current_address' => 'Mars',
            'permanent_address' => 'Jupiter',
            'created_by' => 2,
        ]);
        $roleteacher = Role::create(['name' => 'Teacher']);
        $teacherpermissions = ['73', '74', '75', '76'];
        $roleteacher->syncPermissions($teacherpermissions);
        $teacheruser->assignRole([$roleteacher->id]);

        $staffuser = User::create([
            'name' => 'Vedyalay Staff',
            'email' => 'staff@vedyalay.com',
            'password' => Hash::make('staff123'),
            'type' => 'staff',
        ]);
        Staff::create([
            'user_id' => $staffuser->id,
            'image' => null,
            'phone' => '1234567890',
            'dob' => null,
            'position' => 'Receptionist',
            'salary' => 10000,
            'aadhar_number' => null,
            'gender' => 'female',
            'current_address' => 'Mars',
            'permanent_address' => 'Titan',
            'created_by' => 2,
        ]);
        $rolestaff = Role::create(['name' => 'Staff']);
        $staffuser->assignRole([$rolestaff->id]);

        $studentuser = User::create([
            'name' => 'Vedyalay Student',
            'email' => 'student@vedyalay.com',
            'password' => Hash::make('student123'),
            'type' => 'student',
        ]);
        Student::create([
            'user_id' => $studentuser->id,
            'image' => null,
            'phone' => '1234567890',
            'dob' => null,
            'level_id' => 1,
            'session' => 1,
            'aadhar_number' => null,
            'blood_group' => 'A+',
            'gender' => 'female',
            'caste_category' => 'OBC',
            'disability' => '0',
            'fathername' => 'Mr. ABC',
            'fatheroccupation' => 'Father Occupation',
            'fatherincome' => 20000,
            'mothername' => 'Mrs. ABC',
            'motheroccupation' => 'Mother Occupation',
            'motherincome' => 30000,
            'guardian_name' => 'Mr. XYZ',
            'guardian_phone' => '1234567891',
            'current_address' => 'Mars',
            'permanent_address' => 'Jupiter',
            'created_by' => 2,
        ]);
        $rolestudent = Role::create(['name' => 'Student']);
        $studentpermissions = ['97'];
        $rolestudent->syncPermissions($studentpermissions);
        $studentuser->assignRole([$rolestudent->id]);
        // Role::create(['name' => 'Student']);
    }
}
