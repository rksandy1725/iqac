<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Criterion;
use App\Models\KeyIndicator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class NaacCriteriaSeeder extends Seeder
{
    public function run(): void
    {
        // Create default admin user
        User::firstOrCreate(
            ['email' => 'admin@iqac.edu'],
            [
                'name' => 'IQAC Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'coordinator@iqac.edu'],
            [
                'name' => 'IQAC Coordinator',
                'password' => Hash::make('password'),
                'role' => 'coordinator',
                'email_verified_at' => now(),
            ]
        );

        // NAAC 7 Criteria
        $criteriaData = [
            1 => ['Curricular Aspects', 'Design and development of curriculum, prescription of courses, teaching-learning plan, and academic flexibility.'],
            2 => ['Teaching-Learning and Evaluation', 'Student enrollment, teaching-learning processes, teacher quality, and evaluation mechanisms.'],
            3 => ['Research, Innovations and Extension', 'Research promotion, innovation ecosystem, extension activities, and consultancy.'],
            4 => ['Infrastructure and Learning Resources', 'Physical facilities, library, IT infrastructure, and maintenance.'],
            5 => ['Student Support and Progression', 'Student support mechanisms, progression, and alumni engagement.'],
            6 => ['Governance, Leadership and Management', 'Vision and governance, leadership, management practices, and quality assurance.'],
            7 => ['Institutional Values and Best Practices', 'Institutional values, social responsibilities, environmental consciousness, and best practices.'],
        ];

        $keyIndicatorsData = [
            1 => [
                ['1.1', 'Curriculum Design and Development'],
                ['1.2', 'Academic Flexibility'],
                ['1.3', 'Curriculum Enrichment'],
                ['1.4', 'Feedback System'],
            ],
            2 => [
                ['2.1', 'Student Enrolment and Profile'],
                ['2.2', 'Student Teacher Ratio'],
                ['2.3', 'Teaching-Learning Process'],
                ['2.4', 'Teacher Quality'],
                ['2.5', 'Evaluation Process'],
                ['2.6', 'Student Performance and Learning Outcomes'],
                ['2.7', 'Student Satisfaction Survey'],
            ],
            3 => [
                ['3.1', 'Research Policy and Initiatives'],
                ['3.2', 'Research Funding and Grants'],
                ['3.3', 'Research Publications'],
                ['3.4', 'Extension Activities'],
                ['3.5', 'Consultancy'],
                ['3.6', 'Innovation Ecosystem'],
            ],
            4 => [
                ['4.1', 'Physical Facilities'],
                ['4.2', 'Library as Learning Resource'],
                ['4.3', 'IT Infrastructure'],
                ['4.4', 'Maintenance of Campus Infrastructure'],
            ],
            5 => [
                ['5.1', 'Student Support Mechanisms'],
                ['5.2', 'Progression to Higher Education'],
                ['5.3', 'Participation in Sports and Cultural Activities'],
                ['5.4', 'Alumni Engagement'],
            ],
            6 => [
                ['6.1', 'Vision and Leadership'],
                ['6.2', 'Governance Structure and Decision Making'],
                ['6.3', 'Management Practices'],
                ['6.4', 'Faculty Development Programme'],
                ['6.5', 'Financial Management and Resource Mobilization'],
                ['6.6', 'Internal Quality Assurance System'],
            ],
            7 => [
                ['7.1', 'Institutional Values and Social Responsibilities'],
                ['7.2', 'Good Governance Practices'],
                ['7.3', 'Environmental Sustainability'],
                ['7.4', 'Best Practices'],
                ['7.5', 'Distinctiveness'],
            ],
        ];

        foreach ($criteriaData as $number => [$name, $description]) {
            $criterion = Criterion::updateOrCreate(
                ['criterion_number' => $number],
                ['name' => $name, 'description' => $description, 'weightage' => 100 / 7]
            );

            foreach ($keyIndicatorsData[$number] as [$code, $kiName]) {
                KeyIndicator::updateOrCreate(
                    ['ki_code' => $code, 'criterion_id' => $criterion->id],
                    ['ki_name' => $kiName]
                );
            }
        }
    }
}
