<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            /*  'role-list',
               'role-create',
               'role-edit',
               'role-delete',
                */
                ['id'=>1,'name'=> 'user-list'],
                ['id'=>2,'name'=>  'user-create'],
                ['id'=>3,'name'=> 'user-edit'],
                ['id'=>4,'name'=> 'user-delete'],

                ['id'=>5,'name'=> 'menu-list'],
                ['id'=>6,'name'=>  'menu-create'],
                ['id'=>7,'name'=> 'menu-edit'],
                ['id'=>8,'name'=> 'menu-delete'],

                ['id'=>9,'name'=> 'slider-list'],
                ['id'=>10,'name'=> 'slider-create'],
                ['id'=>11,'name'=> 'slider-edit'],
                ['id'=>12,'name'=> 'slider-delete'],

                ['id'=>13,'name'=> 'information-list'],
                ['id'=>14,'name'=> 'information-create'],
                ['id'=>15,'name'=> 'information-edit'],
                ['id'=>16,'name'=> 'information-delete'],

                ['id'=>17,'name'=> 'feature-list'],
                ['id'=>18,'name'=> 'feature-create'],
                ['id'=>19,'name'=> 'feature-edit'],
                ['id'=>20,'name'=> 'feature-delete'],

                ['id'=>21,'name'=> 'testimonial-list'],
                ['id'=>22,'name'=> 'testimonial-create'],
                ['id'=>23,'name'=> 'testimonial-edit'],
                ['id'=>24,'name'=> 'testimonial-delete'],

                ['id'=>25,'name'=> 'faq-list'],
                ['id'=>26,'name'=> 'faq-create'],
                ['id'=>27,'name'=> 'faq-edit'],
                ['id'=>28,'name'=> 'faq-delete'],

                ['id'=>29,'name'=> 'tag-list'],
                ['id'=>30,'name'=> 'tag-create'],
                ['id'=>31,'name'=> 'tag-edit'],
                ['id'=>32,'name'=> 'tag-delete'],

                ['id'=>33,'name'=> 'blog-list'],
                ['id'=>34,'name'=> 'blog-create'],
                ['id'=>35,'name'=> 'blog-edit'],
                ['id'=>36,'name'=> 'blog-delete'],

                ['id'=>37,'name'=> 'contact-list'],
                ['id'=>38,'name'=> 'contact-view'],
                ['id'=>39,'name'=> 'contact-edit'],
                ['id'=>40,'name'=> 'contact-delete'],

                ['id'=>41,'name'=> 'profile-list'],
                ['id'=>42,'name'=> 'profile-view'],
                ['id'=>43,'name'=> 'profile-edit'],
                ['id'=>44,'name'=> 'profile-delete'],

                ['id'=>45,'name'=> 'student-list'],
                ['id'=>46,'name'=> 'student-view'],
                ['id'=>47,'name'=> 'student-edit'],
                ['id'=>48,'name'=> 'student-delete'],

                ['id'=>49,'name'=> 'teacher-list'],
                ['id'=>50,'name'=> 'teacher-view'],
                ['id'=>51,'name'=> 'teacher-edit'],
                ['id'=>52,'name'=> 'teacher-delete'],

                ['id'=>53,'name'=> 'staff-list'],
                ['id'=>54,'name'=> 'staff-view'],
                ['id'=>55,'name'=> 'staff-edit'],
                ['id'=>56,'name'=> 'staff-delete'],

                ['id'=>57,'name'=> 'fee-list'],
                ['id'=>58,'name'=> 'fee-view'],
                ['id'=>59,'name'=> 'fee-edit'],
                ['id'=>60,'name'=> 'fee-delete'],

                ['id'=>61,'name'=> 'subject-list'],
                ['id'=>62,'name'=> 'subject-view'],
                ['id'=>63,'name'=> 'subject-edit'],
                ['id'=>64,'name'=> 'subject-delete'],

           ];
           foreach ($permissions as $permission) {
            $menu = new Permission();
            if ($menu->where('id', $permission['id'])->count() > 0) {
                $menu = $menu->where('id', $permission['id'])->first();
            }
            $menu->fill($permission);
            $menu->save();
        }
    }
}
