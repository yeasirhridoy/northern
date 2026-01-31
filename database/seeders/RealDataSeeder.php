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
        // 0. Clean old data for a fresh seed
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        ApplicationPreference::truncate();
        Application::truncate();
        Notice::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();

        // 1. Create Departments & Subjects
        $cse = Department::updateOrCreate(['code' => 'CSE'], [
            'name' => 'Computer Science & Engineering',
            'description' => '<h3>Empowering the Future of Technology</h3>
            <p>The Department of Computer Science and Engineering (CSE) at Northern University is a hub for innovation, research, and technical excellence. We prepare our students to solve complex global challenges through cutting-edge technology and theoretical expertise.</p>
            
            <h4>Academic Overview</h4>
            <p>Our curriculum is meticulously designed to align with global industry standards and the latest technological advancements. We cover a broad spectrum of disciplines, from core computing fundamentals to emerging fields like Artificial Intelligence, Quantum Computing, and Blockchain.</p>
            
            <h4>Key Research Areas</h4>
            <ul>
                <li><strong>Artificial Intelligence & Machine Learning:</strong> Developing intelligent systems for healthcare and finance.</li>
                <li><strong>Cybersecurity:</strong> Protecting critical infrastructure from advanced digital threats.</li>
                <li><strong>Data Science & Big Data:</strong> Unlocking insights from massive datasets to drive decision-making.</li>
                <li><strong>Software Engineering:</strong> Modern methodologies for building scalable and robust software systems.</li>
            </ul>
            
            <h4>State-of-the-Art Facilities</h4>
            <p>Students enjoy access to high-performance computing labs, dedicated IoT innovation zones, and collaborative spaces designed for agile development and teamwork.</p>
            
            <h4>Career Prospects</h4>
            <p>Graduates from the CSE department are highly sought after by top-tier tech giants like Google, Meta, and Microsoft, as well as burgeoning startups and government research agencies.</p>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '25,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,500 BDT', 'type' => 'Recurring'],
                ['label' => 'Registration Fee', 'amount' => '5,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Lab Fee', 'amount' => '6,500 BDT', 'type' => 'Per Semester'],
                ['label' => 'Library & Resource Fee', 'amount' => '2,500 BDT', 'type' => 'Per Semester'],
                ['label' => 'Student Insurance', 'amount' => '1,000 BDT', 'type' => 'Per Year'],
            ]
        ]);

        $eee = Department::updateOrCreate(['code' => 'EEE'], [
            'name' => 'Electrical & Electronic Engineering',
            'description' => '<h3>Powering the Modern World</h3>
            <p>The Department of Electrical and Electronic Engineering (EEE) at Northern University is dedicated to excellence in teaching, research, and professional development in the field of electronics and energy systems.</p>
            
            <h4>Philosophy</h4>
            <p>We believe engineering is the bridge between scientific discovery and practical application. Our program emphasizes hands-on learning, ethical responsibility, and sustainable innovation in the energy sector.</p>
            
            <h4>Core Specializations</h4>
            <ul>
                <li><strong>Power Systems & Renewable Energy:</strong> Focusing on smart grids and sustainable power generation.</li>
                <li><strong>Telecommunications & Networking:</strong> Designing the backbone of modern global communication.</li>
                <li><strong>Microelectronics & VLSI:</strong> Miniaturizing technology for the next generation of processors.</li>
                <li><strong>Control Systems & Robotics:</strong> Industrial automation and autonomous vehicle technologies.</li>
            </ul>
            
            <h4>Facilities & Laboratories</h4>
            <p>Our department boasts an <em>Advanced Photovoltaic Lab</em>, a <em>Microprocessor Design Suite</em>, and high-voltage testing facilities that meet international safety standards.</p>
            
            <h4>Industry Impact</h4>
            <p>Our alumni are leaders in power generation companies, telecommunication providers, and aerospace industries worldwide.</p>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '22,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,200 BDT', 'type' => 'Recurring'],
                ['label' => 'Registration Fee', 'amount' => '5,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Laboratory Equipment Fee', 'amount' => '7,500 BDT', 'type' => 'Per Semester'],
                ['label' => 'Workshop Maintenance', 'amount' => '3,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Industrial Internship Program', 'amount' => '10,000 BDT', 'type' => 'One-time'],
            ]
        ]);

        $bba = Department::updateOrCreate(['code' => 'BBA'], [
            'name' => 'Business Administration',
            'description' => '<h3>Developing Future Global Leaders</h3>
            <p>The Northern University Business School (BBA) is committed to providing a transformative business education that combines academic rigor with real-world practicality.</p>
            
            <h4>Vision</h4>
            <p>To be a premier business school known for fostering entrepreneurial spirit, analytical prowess, and ethical leadership in the global marketplace.</p>
            
            <h4>Academic Tracks</h4>
            <ul>
                <li><strong>Finance & Investment:</strong> Master the complexities of global capital markets.</li>
                <li><strong>Strategic Management:</strong> Learn to steer organizations through turbulent economic landscapes.</li>
                <li><strong>Marketing & Branding:</strong> Modern digital marketing strategies and consumer behavior analysis.</li>
                <li><strong>Supply Chain & Logistics:</strong> Optimize the global flow of goods and services.</li>
            </ul>
            
            <h4>The Business Hub</h4>
            <p>BBA students benefit from our <em>Incubation Center</em>, where student startups receive mentorship and seed funding, and the <em>Stock Market Trading Room</em> for real-time finance simulations.</p>
            
            <h4>Career Path</h4>
            <p>Our graduates excel as entrepreneurs, CFOs, marketing directors, and consultants in multinational corporations and international NGOs.</p>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '20,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '4,800 BDT', 'type' => 'Recurring'],
                ['label' => 'Course Material & Case Studies', 'amount' => '3,500 BDT', 'type' => 'Per Semester'],
                ['label' => 'Incubation Hub Access', 'amount' => '2,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Annual Business Seminar', 'amount' => '2,500 BDT', 'type' => 'Per Year'],
            ]
        ]);

        $eng = Department::updateOrCreate(['code' => 'ENG'], [
            'name' => 'English',
            'description' => '<h3>Unlocking the Power of Language and Literature</h3>
            <p>The Department of English at Northern University offers a rich academic experience exploring the intricacies of linguistics and the profound depths of literary masterpieces.</p>
            
            <h4>Mission</h4>
            <p>To cultivate critical thinkers, eloquent communicators, and culturally empathetic individuals through the study of language and human storytelling.</p>
            
            <h4>Programs of Study</h4>
            <ul>
                <li><strong>Literary Studies:</strong> From Shakespearean drama to contemporary post-colonial literature.</li>
                <li><strong>Applied Linguistics:</strong> Understanding how language works and its impact on society.</li>
                <li><strong>English Language Teaching (ELT):</strong> Training the next generation of global educators.</li>
                <li><strong>Creative Writing:</strong> Nurturing original voices in poetry, fiction, and non-fiction.</li>
            </ul>
            
            <h4>Creative Space</h4>
            <p>Students participate in the <em>Literary Circle</em>, attend international seminars, and contribute to our annual literary journal, <em>"The Northern Echo"</em>.</p>
            
            <h4>Career Horizon</h4>
            <p>Graduates pursue successful careers in education, media, content strategy, diplomacy, and the creative arts.</p>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '15,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '3,800 BDT', 'type' => 'Recurring'],
                ['label' => 'Language Lab Maintenance', 'amount' => '2,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Library Resource Access', 'amount' => '1,500 BDT', 'type' => 'Per Semester'],
                ['label' => 'Literary Journal Fee', 'amount' => '500 BDT', 'type' => 'Per Semester'],
            ]
        ]);

        $law = Department::updateOrCreate(['code' => 'LAW'], [
            'name' => 'Law & Justice',
            'description' => '<h3>Advancing Justice and Legal Excellence</h3>
            <p>The Faculty of Law at Northern University provides a rigorous and intellectually stimulating environment for aspiring legal professionals and advocates of justice.</p>
            
            <h4>Our Approach</h4>
            <p>We blend traditional legal theory with practical advocacy skills, ensuring our students are prepared for the courtroom as well as the boardroom.</p>
            
            <h4>Specialized Modules</h4>
            <ul>
                <li><strong>Human Rights & Constitutional Law:</strong> Protecting fundamental freedoms and democratic values.</li>
                <li><strong>Corporate & Commercial Law:</strong> Navigating the legal complexities of the business world.</li>
                <li><strong>Criminal Jurisprudence:</strong> Understanding the mechanics of the justice system.</li>
                <li><strong>International Law:</strong> Engaging with the legal frameworks governing global interaction.</li>
            </ul>
            
            <h4>Practical Training</h4>
            <p>Our <em>Moot Court Room</em> allows students to practical legal arguments in a simulated courtroom environment under the guidance of retired judges and practicing attorneys.</p>
            
            <h4>The Legal Professional</h4>
            <p>Our alumni are prominent in the judiciary, top-tier law firms, legal advocacy groups, and international organizations like the United Nations.</p>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '28,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,000 BDT', 'type' => 'Recurring'],
                ['label' => 'Moot Court Training Fee', 'amount' => '3,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Legal Database Subscription', 'amount' => '4,000 BDT', 'type' => 'Per Year'],
                ['label' => 'Bar Exam Preparation Module', 'amount' => '5,000 BDT', 'type' => 'Final Year'],
            ]
        ]);

        $textile = Department::updateOrCreate(['code' => 'TEX'], [
            'name' => 'Textile Engineering',
            'description' => '<h3>Innovating the Fabric of the Future</h3>
            <p>The Department of Textile Engineering is dedicated to technological innovation and sustainable practices in one of the world\'s most dynamic industries.</p>
            
            <h4>The Industry context</h4>
            <p>With Bangladesh being a global hub for garments, our program is designed to create technical experts who can lead the industry into a sustainable and high-tech future.</p>
            
            <h4>Technical Expertise</h4>
            <ul>
                <li><strong>Advanced Fabric Manufacturing:</strong> High-performance and technical textiles.</li>
                <li><strong>Sustainable Wet Processing:</strong> Reducing the environmental footprint of textile production.</li>
                <li><strong>Nanotechnology in Textiles:</strong> Creating smart fabrics with antibacterial and UV-resistant properties.</li>
                <li><strong>Industrial Compliance & CSR:</strong> Ethical management of the global supply chain.</li>
            </ul>
            
            <h4>Industrial Links</h4>
            <p>Students undergo intensive <em>Industrial Training</em> at top-tier manufacturing units and have access to our integrated Spinning and Dyeing labs.</p>
            
            <h4>Career Profile</h4>
            <p>Graduates find leadership roles in R&D, production management, supply chain optimization, and retail buying houses globally.</p>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '20,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '4,200 BDT', 'type' => 'Recurring'],
                ['label' => 'Textile Lab Consumables', 'amount' => '6,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Industrial Tour & Placement', 'amount' => '5,000 BDT', 'type' => 'Per Year'],
                ['label' => 'Dyeing & Printing License', 'amount' => '2,000 BDT', 'type' => 'One-time'],
            ]
        ]);

        $pharm = Department::updateOrCreate(['code' => 'PHARM'], [
            'name' => 'Pharmacy',
            'description' => '<h3>Innovating Life-Saving Solutions</h3>
            <p>The Department of Pharmacy at Northern University is at the forefront of pharmaceutical research and professional clinical training.</p>
            
            <h4>Clinical Excellence</h4>
            <p>Our program is designed to bridge the gap between drug discovery and patient-centered clinical care, adhering to the highest global pharmaceutical standards.</p>
            
            <h4>Research & Development</h4>
            <ul>
                <li><strong>Drug Discovery:</strong> Identifying novel compounds for managing chronic diseases.</li>
                <li><strong>Pharmaceutics:</strong> Advanced drug delivery systems and formulation technology.</li>
                <li><strong>Clinical Pharmacy & Therapeutics:</strong> Optimizing patient outcomes through expert medication management.</li>
                <li><strong>Regulatory Affairs:</strong> Ensuring drug safety and compliance with international laws.</li>
            </ul>
            
            <h4>Advanced Laboratories</h4>
            <p>Our facilities include an <em>Instrumental Analysis Lab</em> with HPLC/GC capabilities and a <em>Microbiology Suite</em> for drug testing.</p>
            
            <h4>Career Prospects</h4>
            <p>Graduates serve as pharmacists, drug researchers, manufacturing experts, and regulatory officers in both public and private sectors.</p>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '30,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,800 BDT', 'type' => 'Recurring'],
                ['label' => 'Analytical Chemistry Lab Fee', 'amount' => '8,500 BDT', 'type' => 'Per Semester'],
                ['label' => 'Chemical & Glassware Maintenance', 'amount' => '3,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Hospital Internship Fee', 'amount' => '5,000 BDT', 'type' => 'One-time'],
            ]
        ]);

        $ce = Department::updateOrCreate(['code' => 'CE'], [
            'name' => 'Civil Engineering',
            'description' => '<h3>Building Resilient and Sustainable Nations</h3>
            <p>The Department of Civil Engineering (CE) provides the technical foundation for building the infrastructure that supports civil society.</p>
            
            <h4>Structural Integrity</h4>
            <p>We focus on the design, construction, and maintenance of the physical and naturally built environment, including works like roads, bridges, and dams.</p>
            
            <h4>Sustainable Infrastructure</h4>
            <ul>
                <li><strong>Structural Analysis:</strong> Designing for resilience against natural disasters.</li>
                <li><strong>Environmental Engineering:</strong> Sustainable water management and pollution control.</li>
                <li><strong>Geotechnical Engineering:</strong> Master the mechanics of soil and rock structures.</li>
                <li><strong>Transportation Engineering:</strong> Designing the smart cities and transit networks of tomorrow.</li>
            </ul>
            
            <h4>On-Site Training</h4>
            <p>Beyond the classroom, students engaged in field surveys and visits to prestigious mega-projects under the supervision of industry professionals.</p>
            
            <h4>Industry Opportunities</h4>
            <p>Our alumni contribute to national infrastructure development and work with international construction firms and urban planning agencies.</p>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '22,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,000 BDT', 'type' => 'Recurring'],
                ['label' => 'Surveying & Field Work', 'amount' => '4,500 BDT', 'type' => 'Per Year'],
                ['label' => 'Materials Testing Lab', 'amount' => '6,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Software License (Revit/Civil3D)', 'amount' => '3,000 BDT', 'type' => 'Per Year'],
            ]
        ]);

        $arch = Department::updateOrCreate(['code' => 'ARCH'], [
            'name' => 'Architecture',
            'description' => '<h3>Designing Spaces that Inspire Humanity</h3>
            <p>The Department of Architecture at Northern University combines artistic vision with technical precision to create sustainable and impactful built environments.</p>
            
            <h4>The Visionary Architect</h4>
            <p>We believe architecture is more than just buildings; it\'s about creating the context for human experience and environmental harmony.</p>
            
            <h4>Design Excellence</h4>
            <ul>
                <li><strong>Sustainable Urbanism:</strong> Designing green cities and functional public spaces.</li>
                <li><strong>Architectural Heritage:</strong> Preserving historical structures through modern technology.</li>
                <li><strong>Digital Modeling:</strong> Mastering BIM and advanced parametric design tools.</li>
                <li><strong>Landscape Architecture:</strong> Integrating nature into the heart of the built environment.</li>
            </ul>
            
            <h4>The Design Studio</h4>
            <p>Our open-concept <em>Design Studios</em> are the core of our program, where ideas are debated, sketched, and modeled through round-the-clock creative sessions.</p>
            
            <h4>The Professional Journey</h4>
            <p>Our graduates are award-winning designers, urban planners, and visionary architects working in prestigious firms worldwide.</p>',
            'costing' => [
                ['label' => 'Admission Fee', 'amount' => '35,000 BDT', 'type' => 'One-time'],
                ['label' => 'Tuition Fee (per credit)', 'amount' => '5,400 BDT', 'type' => 'Recurring'],
                ['label' => 'Design Studio Resource Fee', 'amount' => '7,000 BDT', 'type' => 'Per Semester'],
                ['label' => 'Model Making Workshop Access', 'amount' => '3,500 BDT', 'type' => 'Per Semester'],
                ['label' => 'Annual Architecture Exhibition', 'amount' => '2,000 BDT', 'type' => 'Per Year'],
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
        Notice::updateOrCreate(['title' => 'Admission Open for Spring 2026'], [
            'content' => 'Applications are now being accepted for the Spring 2026 semester. Apply online by January 30th to secure your spot in our diverse range of programs.',
            'is_active' => true,
            'file' => null,
        ]);

        Notice::updateOrCreate(['title' => 'Convocation 2025 Registration'], [
            'content' => 'Graduates of 2024 and 2025 are invited to register for the 10th Convocation Ceremony. Registration closes on December 15th.',
            'is_active' => true,
            'file' => null,
        ]);

        Notice::updateOrCreate(['title' => 'Research Grant Awards Announced'], [
            'content' => 'Northern University is proud to announce the recipients of this year\'s research grants. Congratulations to our faculty and students for their innovative proposals.',
            'is_active' => true,
            'file' => null,
        ]);
    }
}
