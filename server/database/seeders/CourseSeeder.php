<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    private array $courses = [
        [
            'course_id' => '616811aad34afe06c5f63f58',
            'name' => '1:1 JSA',
            'short_name' => '1:1 JSA',
        ],
        [
            'course_id' => '5f476b749f8d4a3fe9dd3158',
            'name' => 'Web Intensive',
            'short_name' => 'JSI',
        ],
        [
            'course_id' => '5f476b619f8d4a3fe9dd3151',
            'name' => 'Web Advance',
            'short_name' => 'JSA',
        ],
        [
            'course_id' => '5f4771b59f8d4a3fe9dd3226',
            'name' => 'ONL-JSA',
            'short_name' => 'ONL-JSA',
        ],
        [
            'course_id' => '5f4769d69f8d4a3fe9dd311f',
            'name' => 'Code for kids - Mobile App Basic',
            'short_name' => 'C4K-MB',
        ],
        [
            'course_id' => '5f476b469f8d4a3fe9dd314a',
            'name' => 'Web Basic',
            'short_name' => 'JSB',
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->courses as $course) {
            Course::create($course);
        }
    }
}
