<?php

namespace Database\Seeders;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\AttendanceRecord;
use App\Models\CareerPath;
use App\Models\Certification;
use App\Models\CounselingSession;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Expert;
use App\Models\StudentCareerPath;
use App\Models\User;
use App\Notifications\GradeDropNotification;
use App\Notifications\GoodPerformanceNotification;
use App\Notifications\PoorPerformanceNotification;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ──────────────────────────────────────────────────
        User::firstOrCreate(
            ['email' => 'admin@kanaf.sa'],
            ['name' => 'مدير النظام', 'password' => Hash::make('password'), 'role' => 'admin']
        );

        // ── Advisor ────────────────────────────────────────────────
        $advisor = User::firstOrCreate(
            ['email' => 'advisor@kanaf.sa'],
            [
                'name'       => 'د. سلمى المطيري',
                'password'   => Hash::make('password'),
                'role'       => 'advisor',
                'job_number' => 'ADV-0012',
                'college'    => 'كلية الحاسب والمعلومات',
                'department' => 'علوم الحاسب',
            ]
        );

        // ── Students ───────────────────────────────────────────────
        $studentsData = [
            [
                'email' => 'khalid@kanaf.sa',
                'name'  => 'خالد محمد',
                'student_id'     => '4410023456',
                'college'        => 'كلية الحاسب والمعلومات',
                'major'          => 'علوم الحاسب',
                'academic_level' => 8,
                'gpa'            => 2.15,
            ],
            [
                'email' => 'sara@kanaf.sa',
                'name'  => 'سارة عبدالله',
                'student_id'     => '4410023401',
                'college'        => 'كلية الحاسب والمعلومات',
                'major'          => 'هندسة البرمجيات',
                'academic_level' => 7,
                'gpa'            => 4.50,
            ],
            [
                'email' => 'faisal@kanaf.sa',
                'name'  => 'فيصل العمري',
                'student_id'     => '4410023412',
                'college'        => 'كلية الحاسب والمعلومات',
                'major'          => 'نظم المعلومات',
                'academic_level' => 7,
                'gpa'            => 3.20,
            ],
            [
                'email' => 'nora@kanaf.sa',
                'name'  => 'نورة الشمري',
                'student_id'     => '4410023422',
                'college'        => 'كلية الحاسب والمعلومات',
                'major'          => 'الذكاء الاصطناعي',
                'academic_level' => 6,
                'gpa'            => 4.75,
            ],
            [
                'email' => 'abdulrahman@kanaf.sa',
                'name'  => 'عبدالرحمن الغامدي',
                'student_id'     => '4410023431',
                'college'        => 'كلية الحاسب والمعلومات',
                'major'          => 'الأمن السيبراني',
                'academic_level' => 6,
                'gpa'            => 1.90,
            ],
            [
                'email' => 'reem@kanaf.sa',
                'name'  => 'ريم الحربي',
                'student_id'     => '4410023440',
                'college'        => 'كلية الحاسب والمعلومات',
                'major'          => 'علوم الحاسب',
                'academic_level' => 5,
                'gpa'            => 3.85,
            ],
        ];

        $students = [];
        foreach ($studentsData as $data) {
            $students[$data['email']] = User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, ['password' => Hash::make('password'), 'role' => 'student'])
            );
            // Update profile fields on existing records
            $students[$data['email']]->update(array_diff_key($data, ['email' => '']));
        }

        $student = $students['khalid@kanaf.sa'];

        // ── Career Paths ───────────────────────────────────────────
        $dataPath = CareerPath::firstOrCreate(['name' => 'مسار تحليل بيانات'], [
            'description'    => 'مختص بتحليل البيانات واستخراج الأنماط لدعم اتخاذ القرار وتحسين الأعمال.',
            'core_skills'    => ['تحليل البيانات', 'التفكير التحليلي', 'Excel', 'SQL', 'Power BI', 'Data Visualization'],
            'work_fields'    => ['الشركات التقنية', 'البنوك', 'القطاع الصحي', 'التجارة الإلكترونية', 'الجهات الحكومية'],
            'suggested_plan' => [
                'تطوير مهارات Excel SQL',
                'تعلم أدوات تحليل البيانات',
                'بناء مشاريع بسيطة',
                'إنشاء ملف أعمال (Portfolio)',
                'التقديم على فرص تدريب',
            ],
        ]);

        // ── Additional Career Paths ────────────────────────────────
        $aiPath = CareerPath::firstOrCreate(['name' => 'الذكاء الاصطناعي'], [
            'description'    => 'بناء نماذج تعلم آلي وأنظمة ذكاء اصطناعي لحل مشكلات معقدة في شتى القطاعات.',
            'core_skills'    => ['Python', 'Machine Learning', 'Deep Learning', 'TensorFlow', 'الإحصاء', 'معالجة اللغات الطبيعية'],
            'work_fields'    => ['التقنية', 'الرعاية الصحية', 'المالية', 'اللوجستيات', 'الحكومة الذكية'],
            'suggested_plan' => ['تعلم Python والإحصاء', 'إتقان مكتبات ML', 'بناء مشاريع تطبيقية', 'نشر النماذج على السحابة', 'التخصص في مجال محدد'],
        ]);

        $cloudPath = CareerPath::firstOrCreate(['name' => 'الحوسبة السحابية'], [
            'description'    => 'تصميم وإدارة البنية التحتية السحابية لتحقيق المرونة والكفاءة للمؤسسات.',
            'core_skills'    => ['AWS', 'Azure', 'Linux', 'Docker', 'Kubernetes', 'DevOps', 'IaC'],
            'work_fields'    => ['الشركات التقنية', 'الخدمات المالية', 'التجارة الإلكترونية', 'الجهات الحكومية'],
            'suggested_plan' => ['الحصول على شهادة AWS/Azure', 'تعلم DevOps', 'إتقان الحاويات', 'بناء مشاريع سحابية', 'التخصص في Security أو FinOps'],
        ]);

        $pmPath = CareerPath::firstOrCreate(['name' => 'إدارة المشاريع التقنية'], [
            'description'    => 'قيادة مشاريع التحول الرقمي وإدارة فرق التطوير لتسليم المنتجات في الوقت المحدد.',
            'core_skills'    => ['Agile', 'Scrum', 'PMP', 'إدارة المخاطر', 'التواصل', 'تحليل البيانات'],
            'work_fields'    => ['الشركات التقنية', 'الاستشارات', 'البنوك', 'الشركات الحكومية'],
            'suggested_plan' => ['الحصول على PMP أو CAPM', 'إتقان Agile وScrum', 'قيادة مشروع صغير', 'بناء مهارات القيادة', 'التقديم على مناصب PM جونيور'],
        ]);

        $productPath = CareerPath::firstOrCreate(['name' => 'إدارة المنتجات التقنية'], [
            'description'    => 'تحديد رؤية المنتج الرقمي والعمل بين الفرق التقنية والتجارية لبناء منتجات مؤثرة.',
            'core_skills'    => ['Product Strategy', 'User Research', 'A/B Testing', 'تحليل البيانات', 'Roadmapping', 'SQL'],
            'work_fields'    => ['شركات SaaS', 'التجارة الإلكترونية', 'التقنية المالية', 'التعليم التقني'],
            'suggested_plan' => ['فهم User Research', 'تعلم أساسيات البرمجة', 'بناء Portfolio منتج', 'الحصول على PSPO', 'التقديم على دور APM'],
        ]);

        $softwarePath = CareerPath::firstOrCreate(['name' => 'تطوير البرمجيات'], [
            'description'    => 'تصميم وبناء تطبيقات الويب والجوال والأنظمة البرمجية باستخدام أحدث التقنيات.',
            'core_skills'    => ['JavaScript', 'React', 'Node.js', 'Python', 'Git', 'REST APIs', 'قواعد البيانات'],
            'work_fields'    => ['الشركات التقنية', 'الناشئة', 'الاستشارات', 'البنوك', 'العمل الحر'],
            'suggested_plan' => ['إتقان لغة برمجة واحدة', 'بناء مشاريع GitHub', 'تعلم أطر العمل الحديثة', 'المساهمة في Open Source', 'التقديم على وظائف جونيور'],
        ]);

        $sysPath = CareerPath::firstOrCreate(['name' => 'تحليل النظم'], [
            'description'    => 'تحليل متطلبات الأعمال وترجمتها لحلول تقنية متكاملة تخدم أهداف المؤسسة.',
            'core_skills'    => ['UML', 'BPMN', 'SQL', 'متطلبات الأعمال', 'التوثيق', 'نمذجة العمليات'],
            'work_fields'    => ['البنوك', 'الحكومة', 'الاستشارات التقنية', 'شركات ERP'],
            'suggested_plan' => ['تعلم UML وBPMN', 'إتقان أدوات التوثيق', 'فهم عمليات الأعمال', 'الحصول على CBAP', 'التقديم على وظائف BA'],
        ]);

        // Experts & certs for AI path
        foreach ([
            ['name' => 'د. عمر الشريف', 'title' => 'AI Research Lead', 'company' => 'SDAIA'],
            ['name' => 'منى الزهراني',   'title' => 'ML Engineer',      'company' => 'Saudi Aramco'],
            ['name' => 'فهد التميمي',    'title' => 'NLP Scientist',    'company' => 'Elm'],
        ] as $e) {
            Expert::firstOrCreate(['name' => $e['name'], 'career_path_id' => $aiPath->id],
                array_merge($e, ['career_path_id' => $aiPath->id, 'linkedin_url' => 'https://linkedin.com']));
        }
        foreach (['AWS Machine Learning Specialty', 'Google Professional ML Engineer', 'Deep Learning Specialization'] as $c) {
            Certification::firstOrCreate(['name' => $c, 'career_path_id' => $aiPath->id]);
        }

        // Experts & certs for Cloud path
        foreach ([
            ['name' => 'أسامة القرشي',  'title' => 'Cloud Architect', 'company' => 'STC'],
            ['name' => 'لينا العسيري',  'title' => 'DevOps Engineer',  'company' => 'Taqnia'],
            ['name' => 'ياسر الحربي',   'title' => 'Solutions Architect', 'company' => 'AWS Arabia'],
        ] as $e) {
            Expert::firstOrCreate(['name' => $e['name'], 'career_path_id' => $cloudPath->id],
                array_merge($e, ['career_path_id' => $cloudPath->id, 'linkedin_url' => 'https://linkedin.com']));
        }
        foreach (['AWS Solutions Architect', 'Microsoft Azure Administrator', 'Google Cloud Professional'] as $c) {
            Certification::firstOrCreate(['name' => $c, 'career_path_id' => $cloudPath->id]);
        }

        // Experts & certs for PM path
        foreach ([
            ['name' => 'خالد الدوسري',  'title' => 'Senior PM', 'company' => 'Noon'],
            ['name' => 'ريم الرشيدي',  'title' => 'Delivery Manager', 'company' => 'McKinsey KSA'],
        ] as $e) {
            Expert::firstOrCreate(['name' => $e['name'], 'career_path_id' => $pmPath->id],
                array_merge($e, ['career_path_id' => $pmPath->id, 'linkedin_url' => 'https://linkedin.com']));
        }
        foreach (['PMP', 'PMI-ACP', 'Certified Scrum Master'] as $c) {
            Certification::firstOrCreate(['name' => $c, 'career_path_id' => $pmPath->id]);
        }

        // Experts & certs for Software path
        foreach ([
            ['name' => 'سلطان القحطاني', 'title' => 'Senior Software Engineer', 'company' => 'Jahez'],
            ['name' => 'وفاء البكري',    'title' => 'Full-Stack Developer',     'company' => 'Salla'],
            ['name' => 'ماجد العمري',    'title' => 'Backend Lead',             'company' => 'Foodics'],
        ] as $e) {
            Expert::firstOrCreate(['name' => $e['name'], 'career_path_id' => $softwarePath->id],
                array_merge($e, ['career_path_id' => $softwarePath->id, 'linkedin_url' => 'https://linkedin.com']));
        }
        foreach (['Meta Front-End Developer', 'AWS Developer Associate', 'MongoDB Developer'] as $c) {
            Certification::firstOrCreate(['name' => $c, 'career_path_id' => $softwarePath->id]);
        }

        // Experts & certs for Product path
        foreach ([
            ['name' => 'نوف السعيد',    'title' => 'Product Manager', 'company' => 'Tamara'],
            ['name' => 'عبدالله الأحمد', 'title' => 'Head of Product', 'company' => 'Unifonic'],
        ] as $e) {
            Expert::firstOrCreate(['name' => $e['name'], 'career_path_id' => $productPath->id],
                array_merge($e, ['career_path_id' => $productPath->id, 'linkedin_url' => 'https://linkedin.com']));
        }
        foreach (['Professional Scrum Product Owner', 'Google UX Design', 'Product Analytics Certification'] as $c) {
            Certification::firstOrCreate(['name' => $c, 'career_path_id' => $productPath->id]);
        }

        // Experts & certs for Systems Analysis path
        foreach ([
            ['name' => 'غازي الزبيدي',  'title' => 'Systems Analyst', 'company' => 'KPMG'],
            ['name' => 'حنان الشهري',   'title' => 'Business Analyst', 'company' => 'SAP Arabia'],
        ] as $e) {
            Expert::firstOrCreate(['name' => $e['name'], 'career_path_id' => $sysPath->id],
                array_merge($e, ['career_path_id' => $sysPath->id, 'linkedin_url' => 'https://linkedin.com']));
        }
        foreach (['CBAP', 'PMI-PBA', 'TOGAF'] as $c) {
            Certification::firstOrCreate(['name' => $c, 'career_path_id' => $sysPath->id]);
        }

        // ── Experts ────────────────────────────────────────────────
        $expertData = [
            ['name' => 'أحمد علي العتيبي',     'title' => 'Senior Data Analyst', 'company' => 'STC',    'linkedin_url' => 'https://linkedin.com'],
            ['name' => 'سارة عبدالله القحطاني', 'title' => 'Data Science Lead',   'company' => 'Aramco', 'linkedin_url' => 'https://linkedin.com'],
            ['name' => 'محمد سعود الدوسري',    'title' => 'BI Manager',           'company' => 'Mobily', 'linkedin_url' => 'https://linkedin.com'],
        ];

        foreach ($expertData as $e) {
            Expert::firstOrCreate(
                ['name' => $e['name'], 'career_path_id' => $dataPath->id],
                array_merge($e, ['career_path_id' => $dataPath->id])
            );
        }

        // ── Certifications ─────────────────────────────────────────
        foreach (['Google Data Analytics', 'Microsoft Power BI', 'IBM Data Analyst'] as $cert) {
            Certification::firstOrCreate(['name' => $cert, 'career_path_id' => $dataPath->id]);
        }

        // ── Assign recommended path to student ────────────────────
        StudentCareerPath::firstOrCreate(
            ['user_id' => $student->id, 'career_path_id' => $dataPath->id],
            ['is_recommended' => true, 'is_saved' => false]
        );

        // ── Courses ────────────────────────────────────────────────
        $algorithms = Course::firstOrCreate(['code' => 'CS301'], [
            'name'        => 'خوارزميات',
            'description' => 'مقدمة في تحليل وتصميم الخوارزميات.',
            'credits'     => 3,
        ]);

        Course::firstOrCreate(['code' => 'CS302'], [
            'name'        => 'قواعد البيانات',
            'description' => 'مبادئ تصميم وإدارة قواعد البيانات العلائقية.',
            'credits'     => 3,
        ]);

        // ── More Courses ───────────────────────────────────────────
        $dataStructures = Course::firstOrCreate(['code' => 'CS201'], [
            'name' => 'هياكل البيانات', 'credits' => 3,
            'description' => 'دراسة هياكل البيانات الأساسية مثل القوائم والأشجار والرسوم البيانية.',
        ]);
        $webDev = Course::firstOrCreate(['code' => 'CS303'], [
            'name' => 'تطوير الويب', 'credits' => 3,
            'description' => 'بناء تطبيقات الويب باستخدام HTML وCSS وJavaScript وأطر العمل الحديثة.',
        ]);
        $machineLearning = Course::firstOrCreate(['code' => 'CS401'], [
            'name' => 'تعلم الآلة', 'credits' => 3,
            'description' => 'مقدمة في خوارزميات التعلم الآلي والشبكات العصبية.',
        ]);
        $security = Course::firstOrCreate(['code' => 'CS305'], [
            'name' => 'أمن المعلومات', 'credits' => 3,
            'description' => 'مبادئ أمن الشبكات والتشفير والحماية من الهجمات الإلكترونية.',
        ]);
        $statistics = Course::firstOrCreate(['code' => 'MATH201'], [
            'name' => 'إحصاء وأساليب كمية', 'credits' => 3,
            'description' => 'التحليل الإحصائي وأساليب البحث الكمي لاتخاذ القرارات.',
        ]);
        $os = Course::firstOrCreate(['code' => 'CS402'], [
            'name' => 'أنظمة التشغيل', 'credits' => 3,
            'description' => 'مبادئ تصميم وإدارة أنظمة التشغيل والعمليات والذاكرة.',
        ]);

        // ── More Enrollments (diverse grades across students) ──────
        $enrollmentMatrix = [
            // [student_email, course, semester, grades...]
            ['sara@kanaf.sa', $dataStructures, '2025-1', 4,4,3, 18,19, 3,4,4, 15,0],
            ['sara@kanaf.sa', $webDev,         '2025-2', 4,3,4, 17,18, 4,3,4, 16,0],
            ['faisal@kanaf.sa',$algorithms,    '2025-1', 3,2,3, 14,12, 2,3,2, 10,0],
            ['faisal@kanaf.sa',$dataStructures,'2025-1', 2,3,2, 12,10, 2,2,3, 8, 0],
            ['faisal@kanaf.sa',$statistics,    '2025-2', 3,3,2, 13,11, 3,2,2, 9, 0],
            ['nora@kanaf.sa',  $machineLearning,'2025-2', 4,4,4, 19,20, 4,4,4, 17,0],
            ['nora@kanaf.sa',  $statistics,    '2025-1', 4,4,3, 18,17, 4,3,4, 15,0],
            ['nora@kanaf.sa',  $algorithms,    '2025-1', 4,3,4, 17,18, 4,4,3, 16,0],
            ['abdulrahman@kanaf.sa', $security,'2025-2', 1,2,1, 8, 6,  1,2,1, 5, 0],
            ['abdulrahman@kanaf.sa', $algorithms,'2025-1', 2,1,2, 9,7,  1,1,2, 6, 0],
            ['reem@kanaf.sa',  $webDev,        '2025-1', 4,3,3, 16,15, 3,4,3, 13,0],
            ['reem@kanaf.sa',  $dataStructures,'2025-1', 3,3,4, 15,14, 3,3,4, 12,0],
            ['reem@kanaf.sa',  $machineLearning,'2025-2', 3,4,3, 15,16, 3,3,3, 12,0],
            ['khalid@kanaf.sa',$dataStructures,'2025-1', 2,1,2, 10,8,  2,1,2, 7, 0],
            ['khalid@kanaf.sa',$security,      '2025-2', 1,0,2, 7, 5,  1,1,0, 4, 0],
        ];

        foreach ($enrollmentMatrix as [$email, $course, $sem, $q1t,$q2t,$q3t,$mt,$ft,$q1p,$q2p,$q3p,$mp,$fp]) {
            $st = $students[$email];
            Enrollment::firstOrCreate(
                ['user_id' => $st->id, 'course_id' => $course->id, 'semester' => $sem],
                ['quiz1_theory'=>$q1t,'quiz2_theory'=>$q2t,'quiz3_theory'=>$q3t,'mid_theory'=>$mt,'final_theory'=>$ft,
                 'quiz1_practical'=>$q1p,'quiz2_practical'=>$q2p,'quiz3_practical'=>$q3p,'mid_practical'=>$mp,'final_practical'=>$fp]
            );
        }

        // ── Enrollment: Algorithms (mirrors screenshot data) ───────
        Enrollment::firstOrCreate(
            ['user_id' => $student->id, 'course_id' => $algorithms->id, 'semester' => '2025-2'],
            [
                'quiz1_theory' => 2, 'quiz2_theory' => 0, 'quiz3_theory' => 3,
                'mid_theory'   => 15, 'final_theory' => 8,
                'quiz1_practical' => 2, 'quiz2_practical' => 3, 'quiz3_practical' => 3,
                'mid_practical'   => 0, 'final_practical'  => 0,
            ]
        );

        // ── Assignments (7 total, 4 submitted) ─────────────────────
        $titles = [
            'واجب تحليل التعقيد',
            'واجب الخوارزميات الجشعة',
            'واجب البرمجة الديناميكية',
            'واجب الأشجار والرسوم البيانية',
            'واجب الفرز والبحث',
            'واجب النماذج الرياضية',
            'واجب المراجعة الشاملة',
        ];

        $assignments = [];
        foreach ($titles as $i => $title) {
            $assignments[] = Assignment::firstOrCreate(
                ['course_id' => $algorithms->id, 'title' => $title],
                ['due_date' => Carbon::now()->subDays(($i + 1) * 7)->toDateString()]
            );
        }

        foreach (array_slice($assignments, 0, 4) as $assignment) {
            AssignmentSubmission::firstOrCreate(
                ['assignment_id' => $assignment->id, 'user_id' => $student->id],
                ['submitted_at' => Carbon::now()->subDays(rand(1, 5))]
            );
        }

        // ── Attendance (25 sessions, 1 absent = 4% absence) ───────
        if (AttendanceRecord::where('user_id', $student->id)->where('course_id', $algorithms->id)->count() === 0) {
            $start = Carbon::now()->subWeeks(12)->startOfWeek();
            for ($i = 0; $i < 25; $i++) {
                $date = $start->copy()->addDays($i * 3)->toDateString();
                AttendanceRecord::create([
                    'user_id'   => $student->id,
                    'course_id' => $algorithms->id,
                    'date'      => $date,
                    'status'    => ($i === 5) ? 'absent' : 'present',
                ]);
            }
        }

        // ── Demo Counseling Sessions ───────────────────────────────
        $sessionTypes = ['academic', 'career', 'follow_up', 'personal'];
        $sessionDemos = [
            ['student' => $students['khalid@kanaf.sa'],       'type' => 'academic',  'offset' => -2, 'status' => 'confirmed',   'reason' => 'مراجعة خطة الدراسة وتحسين الأداء'],
            ['student' => $students['sara@kanaf.sa'],         'type' => 'career',    'offset' => -1, 'status' => 'confirmed',   'reason' => 'استكشاف فرص التدريب التعاوني'],
            ['student' => $students['faisal@kanaf.sa'],       'type' => 'follow_up', 'offset' =>  0, 'status' => 'unconfirmed', 'reason' => 'متابعة تقدم الطالب في المقررات'],
            ['student' => $students['abdulrahman@kanaf.sa'],  'type' => 'academic',  'offset' =>  1, 'status' => 'unconfirmed', 'reason' => 'التدخل العاجل لإنقاذ الفصل الدراسي'],
            ['student' => $students['reem@kanaf.sa'],         'type' => 'career',    'offset' =>  2, 'status' => 'postponed',   'reason' => 'التخطيط للتخرج والمسار المهني'],
        ];

        foreach ($sessionDemos as $demo) {
            CounselingSession::firstOrCreate(
                ['student_id' => $demo['student']->id, 'advisor_id' => $advisor->id, 'session_at' => Carbon::today()->addDays($demo['offset'])->setTime(10, 0)],
                [
                    'session_type' => $demo['type'],
                    'reason'       => $demo['reason'],
                    'status'       => $demo['status'],
                    'attended'     => $demo['offset'] < 0,
                ]
            );
        }

        // ── Demo Notifications for student (khalid) ───────────────
        $student->notifications()->delete();

        $student->notify(
            (new GradeDropNotification('خوارزميات', 15, 8))
                ->delay(Carbon::now()->subHours(2))
        );

        $student->notify(
            (new PoorPerformanceNotification('خوارزميات', 30))
                ->delay(Carbon::now()->subHours(1))
        );

        $student->notify(
            (new GoodPerformanceNotification('قواعد البيانات', 85))
                ->delay(Carbon::now()->subMinutes(30))
        );
    }
}
