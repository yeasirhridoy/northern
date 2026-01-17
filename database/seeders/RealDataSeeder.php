<?php

namespace Database\Seeders;

use App\Models\AdmissionSession;
use App\Models\Application;
use App\Models\ApplicationPreference;
use App\Models\Department;
use App\Models\Subject;
use App\Models\User;
use App\Models\Notice;
use Illuminate\Database\Seeder;

class RealDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Departments & Subjects
        $cse = Department::firstOrCreate(['code' => 'CSE'], [
            'name' => 'Computer Science & Engineering',
            'description' => '<p>The Department of Computer Science and Engineering (CSE) at Northern University is dedicated to being at the forefront of technological innovation and education. We offer a dynamic learning environment where students explore the theoretical foundations of computing and their practical applications in solving real-world problems.</p>
            <p>Our curriculum is designed to industry standards, covering key areas such as Artificial Intelligence, Data Science, Cyber Security, Software Engineering, and Cloud Computing. Students have access to state-of-the-art laboratories and are encouraged to participate in cutting-edge research projects.</p>
            <p><strong>Key Highlights:</strong></p>
            <ul>
                <li>Modern computer labs with high-performance workstations.</li>
                <li>Partnerships with leading tech companies for internships and placement.</li>
                <li>Active student clubs for coding, robotics, and innovation.</li>
            </ul>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '25,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,500 BDT', 'type' => 'Recurring'],
                ['label' => 'Lab Fee', 'amount' => '6,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Library Fee', 'amount' => '2,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Student Activity Fee', 'amount' => '1,500 BDT', 'type' => 'Per Semester'],
            ]
        ]);

        $eee = Department::firstOrCreate(['code' => 'EEE'], [
            'name' => 'Electrical & Electronic Engineering',
            'description' => '<p>The Department of Electrical and Electronic Engineering (EEE) prepares aspiring engineers to power the world. Our program fuses fundamental electrical engineering principles with advanced topics in electronics, telecommunications, and power systems.</p>
            <p>We emphasize hands-on learning through rigorous laboratory work and project-based courses. Our graduates are well-equipped to design, develop, and maintain complex electrical systems, contributing significantly to the energy and technology sectors.</p>
            <p><strong>Facilities:</strong></p>
            <ul>
                <li>Advanced Power Systems Laboratory.</li>
                <li>Digital Electronics & Microprocessor Lab.</li>
                <li>Telecommunications & Signal Processing Lab.</li>
            </ul>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '22,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,000 BDT', 'type' => 'Recurring'],
                ['label' => 'Lab Fee', 'amount' => '7,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Development Fee', 'amount' => '3,000 BDT', 'type' => 'Per Semester'],
            ]
        ]);

        $bba = Department::firstOrCreate(['code' => 'BBA'], [
            'name' => 'Business Administration',
            'description' => '<p>The BBA program at Northern University focuses on molding future business leaders and entrepreneurs. Our comprehensive curriculum covers Management, Marketing, Finance, Accounting, and Human Resource Management.</p>
            <p>We foster a culture of critical thinking, ethical leadership, and strategic decision-making. Through case studies, industry visits, and guest lectures from business moguls, we bridge the gap between academic theory and corporate reality.</p>
            <p><strong>Program Features:</strong></p>
            <ul>
                <li>Industry-driven specialization options.</li>
                <li>Regular seminars and workshops by industry experts.</li>
                <li>Incubation support for student startups.</li>
            </ul>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '20,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '4,500 BDT', 'type' => 'Recurring'],
                ['label' => 'Computer Lab Fee', 'amount' => '2,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Seminar Library Fee', 'amount' => '1,500 BDT', 'type' => 'Per Semester'],
            ]
        ]);

        $eng = Department::firstOrCreate(['code' => 'ENG'], [
            'name' => 'English',
            'description' => '<p>The Department of English offers an immersive journey into English Language and Literature. We aim to cultivate proficiency in the English language and a deep appreciation for its rich literary heritage.</p>
            <p>Our program is ideal for students aspiring to careers in teaching, media, content writing, and civil services. We encourage creative expression and critical analysis of texts from diverse cultural and historical contexts.</p>
            <p><strong>Offerings:</strong></p>
            <ul>
                <li>Courses on ELT (English Language Teaching) & Linguistics.</li>
                <li>Creative Writing Workshops.</li>
                <li>Language Lab for phonetics and pronunciation.</li>
            </ul>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '15,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '3,500 BDT', 'type' => 'Recurring'],
                ['label' => 'Language Lab Fee', 'amount' => '1,500 BDT', 'type' => 'Per Semester'],
            ]
        ]);

        $law = Department::firstOrCreate(['code' => 'LAW'], [
            'name' => 'Law & Justice',
            'description' => '<p>The Department of Law & Justice is committed to legal excellence and social justice. We provide a rigorous legal education that combines the study of substantive law with the development of practical legal skills like mooting, drafting, and advocacy.</p>
            <p>Our graduates serve as competent judges, lawyers, and legal advisors who uphold the rule of law. We actively engage students in legal clinics and community outreach programs.</p>
            <p><strong>Why Study Law Here?</strong></p>
            <ul>
                <li>Moot Court competitions.</li>
                <li>Internships with top law firms and NGOs.</li>
                <li>Seminars on contemporary legal issues.</li>
            </ul>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '25,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '4,800 BDT', 'type' => 'Recurring'],
                ['label' => 'Moot Court Fee', 'amount' => '2,000 BDT', 'type' => 'Per Semester'],
            ]
        ]);

        $textile = Department::firstOrCreate(['code' => 'TEX'], [
            'name' => 'Textile Engineering',
            'description' => '<p>Bangladesh is a global leader in the Ready-Made Garment (RMG) sector, and our Textile Engineering program is designed to produce leaders for this vital industry. We cover the entire value chain from fiber to fashion.</p>
            <p>Students learn about yarn manufacturing, fabric manufacturing, wet processing, and apparel manufacturing. We also emphasize sustainable textile practices and industrial compliance.</p>
            <p><strong>Industry Links:</strong></p>
            <ul>
                <li>Industrial attachments with top BGMEA member factories.</li>
                <li>Labs for dyeing, printing, and quality control.</li>
                <li>Workshops on Merchandising and Supply Chain Management.</li>
            </ul>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '20,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '4,000 BDT', 'type' => 'Recurring'],
                ['label' => 'Textile Lab Fee', 'amount' => '5,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Industrial Tour Fee', 'amount' => '3,000 BDT', 'type' => 'Per Year'],
            ]
        ]);

        $pharm = Department::firstOrCreate(['code' => 'PHARM'], [
            'name' => 'Pharmacy',
            'description' => '<p>The Department of Pharmacy offers a comprehensive education in pharmaceutical sciences, preparing students for careers in the booming pharmaceutical industry of Bangladesh. Our curriculum meets the standards of the Pharmacy Council of Bangladesh.</p>
            <p>We focus on Pharmacology, Pharmaceutical Chemistry, Pharmaceutics, and Clinical Pharmacy. Our graduates are highly sought after by top pharma companies and hospitals.</p>
            <p><strong>Key Features:</strong></p>
            <ul>
                <li>State-of-the-art sterile formulation labs.</li>
                <li>Research opportunities in drug discovery and development.</li>
                <li>Hospital residency programs.</li>
            </ul>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '25,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,500 BDT', 'type' => 'Recurring'],
                ['label' => 'Lab & Chemical Fee', 'amount' => '8,000 BDT', 'type' => 'Per Semester'],
            ]
        ]);

        $ce = Department::firstOrCreate(['code' => 'CE'], [
            'name' => 'Civil Engineering',
            'description' => '<p>As Bangladesh undergoes massive infrastructure development, the demand for skilled Civil Engineers is at an all-time high. Our program equips students to design, build, and maintain the structures that shape our nation.</p>
            <p>We cover Structural Engineering, Geotechnical Engineering, Transportation, and Water Resources Engineering. We emphasize resilience and sustainability in the context of climate change.</p>
            <p><strong>Labs & Facilities:</strong></p>
            <ul>
                <li>Concrete & Materials Testing Lab.</li>
                <li>Soil Mechanics Lab.</li>
                <li>Environmental Engineering Lab.</li>
            </ul>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '22,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '4,800 BDT', 'type' => 'Recurring'],
                ['label' => 'Lab Fee', 'amount' => '6,000 BDT', 'type' => 'Per Semester'],
            ]
        ]);

        $arch = Department::firstOrCreate(['code' => 'ARCH'], [
            'name' => 'Architecture',
            'description' => '<p>The Department of Architecture fosters creativity and technical expertise to create spaces that inspire. We blend art, science, and technology to design sustainable and culturally relevant built environments.</p>
            <p>Our studio-based learning approach encourages experimentation and critical discourse. Students explore urban planning, landscape architecture, and interior design.</p>
            <p><strong>Highlights:</strong></p>
            <ul>
                <li>Design Studios with individual workspaces.</li>
                <li>Model Making Workshop.</li>
                <li>Exhibitions and Juries with renowned architects.</li>
            </ul>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '30,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,000 BDT', 'type' => 'Recurring'],
                ['label' => 'Design Studio Fee', 'amount' => '5,000 BDT', 'type' => 'Per Semester'],
            ]
        ]);

        $subjects = collect([
            Subject::firstOrCreate(['name' => 'Software Engineering', 'department_id' => $cse->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Data Science', 'department_id' => $cse->id], ['capacity' => 50]),
            Subject::firstOrCreate(['name' => 'Power Systems', 'department_id' => $eee->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Electronics', 'department_id' => $eee->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Accounting', 'department_id' => $bba->id], ['capacity' => 80]),
            Subject::firstOrCreate(['name' => 'Marketing', 'department_id' => $bba->id], ['capacity' => 80]),
            Subject::firstOrCreate(['name' => 'Literature', 'department_id' => $eng->id], ['capacity' => 50]),
            Subject::firstOrCreate(['name' => 'Criminal Law', 'department_id' => $law->id], ['capacity' => 40]),
            Subject::firstOrCreate(['name' => 'Apparel Manufacturing', 'department_id' => $textile->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Fabric Engineering', 'department_id' => $textile->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Pharmacology', 'department_id' => $pharm->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Clinical Pharmacy', 'department_id' => $pharm->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Structural Engineering', 'department_id' => $ce->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Geotechnical Engineering', 'department_id' => $ce->id], ['capacity' => 60]),
            Subject::firstOrCreate(['name' => 'Urban Design', 'department_id' => $arch->id], ['capacity' => 40]),
            Subject::firstOrCreate(['name' => 'Interior Architecture', 'department_id' => $arch->id], ['capacity' => 40]),
        ]);

        // 2. Create Two Sessions
        $spring26 = AdmissionSession::firstOrCreate(
            ['name' => 'Spring 2026'],
            ['start_date' => now()->subDays(30), 'end_date' => now()->addDays(30)]
        );

        $summer26 = AdmissionSession::firstOrCreate(
            ['name' => 'Summer 2026'],
            ['start_date' => now()->addMonths(4), 'end_date' => now()->addMonths(6)]
        );

        $sessions = collect([$spring26, $summer26]);

        // 3. Create Applications
        // We want 100 applications total, distributed across sessions
        
        $statuses = ['submitted', 'under_review', 'waitlisted', 'offered', 'rejected', 'admitted'];
        $boards = ['Dhaka', 'Chittagong', 'Rajshahi', 'Sylhet', 'Comilla'];
        $groups = ['Science', 'Commerce', 'Humanities'];

        for ($i = 0; $i < 100; $i++) {
            $session = $sessions->random();
            $status = $statuses[array_rand($statuses)];
            $assignedSubjectId = null;
            $paymentStatus = 'pending';
            $regId = null;

            // Logic for realistic data consistency
            if (in_array($status, ['offered', 'admitted'])) {
                $assignedSubjectId = $subjects->random()->id;
            }

            if ($status === 'admitted') {
                $paymentStatus = 'approved';
                $regId = 'REG-' . date('Y') . '-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
            } elseif ($status === 'offered') {
                 // Some offered students might have paid, some pending
                 $paymentStatus = rand(0, 1) ? 'approved' : 'pending';
                 if ($paymentStatus === 'approved') {
                     $regId = 'REG-' . date('Y') . '-' . str_pad($i + 1, 5, '0', STR_PAD_LEFT);
                 }
            } elseif ($status === 'rejected') {
                 $paymentStatus = 'rejected';
            }

            $user = User::factory()->create([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
            ]);

            $application = Application::factory()->create([
                'user_id' => $user->id,
                'admission_session_id' => $session->id,
                'status' => $status,
                'assigned_subject_id' => $assignedSubjectId,
                'payment_status' => $paymentStatus,
                'registration_id' => $regId,
                'payment_amount' => $paymentStatus === 'approved' ? 15000 : null,
                'payment_method' => $paymentStatus === 'approved' ? fake()->randomElement(['bkash', 'nagad', 'bank']) : null,
                'payment_trx_id' => $paymentStatus === 'approved' ? strtoupper(fake()->bothify('??######')) : null,
                
                // Realistic academic scores
                'ssc_gpa' => fake()->randomFloat(2, 4.0, 5.0),
                'hsc_gpa' => fake()->randomFloat(2, 3.5, 5.0),
                'ssc_board' => fake()->randomElement($boards),
                'hsc_board' => fake()->randomElement($boards),
                'hsc_group' => fake()->randomElement($groups),
            ]);

            // Create preferences
            $numPreferences = rand(1, 3);
            $shuffledSubjects = $subjects->shuffle();
            
            for ($j = 0; $j < $numPreferences; $j++) {
                ApplicationPreference::create([
                    'application_id' => $application->id,
                    'subject_id' => $shuffledSubjects[$j]->id,
                    'priority_order' => $j + 1,
                ]);
            }
        }

        // 4. Create Notices
        Notice::create([
            'title' => 'Admission Open for Spring 2026',
            'content' => 'Applications are now being accepted for the Spring 2026 semester. Apply online by January 30th to secure your spot in our diverse range of programs.',
            'is_active' => true,
        ]);

        Notice::create([
            'title' => 'Convocation 2025 Registration',
            'content' => 'Graduates of 2024 and 2025 are invited to register for the 10th Convocation Ceremony. Registration closes on December 15th.',
            'is_active' => true,
        ]);

        Notice::create([
            'title' => 'Research Grant Awards Announced',
            'content' => 'Northern University is proud to announce the recipients of this year\'s research grants. Congratulations to our faculty and students for their innovative proposals.',
            'is_active' => true,
        ]);
    }
}
