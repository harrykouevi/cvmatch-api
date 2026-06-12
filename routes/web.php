<?php

use Illuminate\Support\Facades\Route;



Route::get('///////////////////////', function () {


$resume = [
    'schema_version' => '2.0',
    // 'schema_type'    => '',  // software_engineering | product_management | design_ux | data_analytics
                             // finance_accounting | sales_business_dev | marketing_growth
                             // operations_supply_chain | human_resources | healthcare_clinical
                             // engineering_infrastructure | legal_compliance | education_research
                             // executive_leadership | consulting_strategy | creative_media | other
    "schema_type"=> "other",
    "full_name"=> "Amevi Senade Koudoh",
    "headline"=> "Computer & Network Maintenance Technician",

    'sections' => [

        // ─────────────────────────────────────────────────
        // SECTION 1 — contact
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'contact',
            'section_label' => 'Contact',
            'data' => [
                'email'     => "henrykoudoh@gmail.com",
                'phone'     => "(209) 769-4232",
                'location'  => "CA 95348",
                'linkedin'  => null,
                'portfolio' => null,
                'github'    => null,
                'website'   => null,
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 2 — professional_summary
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'professional_summary',
            'section_label' => 'Professional Summary',
            'data' => [
                'text' => "Computer and Network Maintenance Technician with 4+ years of hands-on experience installing operating systems and software applications, configuring routers and network wiring, supporting printers, scanners, and copy machines, and troubleshooting computer and electronic hardware. Brings 10+ years of combined experience across electronics, network maintenance, sales, customer-facing after-sales support, administrative operations, safety-focused maintenance, and continuous improvement environments. Recognized for strong planning, multitasking, cybersecurity awareness, safety discipline, and patient support for users and customers in fast-paced settings.",
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 3 — skills
        // (inclure uniquement les sous-groupes pertinents)
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'skills',
            'section_label' => 'Core Competencies',
            'data' => [
                'technical'             => [
                                            "Computer maintenance",
                                            "PC and electronic hardware troubleshooting",
                                            "Operating system installation",
                                            "Software application installation",
                                            "Basic equipment repairs",
                                            "Basic electrical knowledge",
                                            "Inspection"
                                                    ],  // string[]
                'soft'                  => ["Planning","Multitasking","Customer orientation","Attention to accuracy","User and customer support","Operational discipline"],
                'tools'                 => ["Printers","Scanners","Copiers","Routers","Network wiring","Forklift","Fire extinguisher"],
                'platforms'             => [],
                'methodologies'         => ["Safety standards","Inspection","Cybersecurity awareness","Continuous improvement","Document control","Data entry"],
                'domain_expertise'      => [ "Network device configuration",
                                            "External device installation and configuration",
                                            "Store operations",
                                            "Sales",
                                            "Returns management",
                                            "After-sales service",
                                            "E-commerce",
                                            "Safety standards",
                                            "Cybersecurity awareness",
                                            "Filing and archiving",
                                            "Courier and phone call management",
                                            "Data entry and survey processing",
                                            "Training organization",
                                            "Report typing and printing"
                                            ],
                'languages_programming' => [],
                'frameworks'            => [],
                'databases'             => [],
                'cloud_devops'          => [],
                'clinical_skills'       => [],
                'financial_skills'      => [],
                'legal_skills'          => [],
                'design_skills'         => [],
                'marketing_skills'      => [],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 4 — professional_experience
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'professional_experience',
            'section_label' => 'Professional Experience',
            'data' => [
                [
                    'company'      => "Sotral",
                    'title'        =>  "Bus Cleaning Maintenance",
                    'location'     => "Lome, Togo",
                    'date_start'   => "09/2016",
                    'date_end'     => "05/2025",  // ou 'Present'
                    'description'  => 'Supported passenger safety and daily service readiness through',

                    'bullets'      => "Maintained clean, safe, and hygienic bus interiors and exteriors to support passenger safety and daily service readiness. | Executed routine cleaning activities including sweeping, mopping, vacuuming, and sanitizing floors and seats. | Supported safety standards and inspection readiness within a fast-paced transportation environment.",
                    'technologies' =>
                                        "Cleaning equipment,
                                        Sanitizing supplies,
                                        Safety standards"
                                    ,  // virgule-séparé : "Laravel, Vue.js, MySQL"
                    'achievements' => "Supported passenger safety and daily service readiness through cleaning | sanitation, and safety-focused maintenance.",  // pipe-séparé : "Bullet 1 | Bullet 2 | Bullet 3",  // pipe-séparé : "Achievement 1 | Achievement 2"
                ],
                [
                    'company'      => "Sotral",
                    'title'        =>  "Bus Cleaning Maintenance",
                    'location'     => "Lome, Togo",
                    'date_start'   => "09/2016",
                    'date_end'     => "05/2025",  // ou 'Present'
                    'description'  => '',
                    'bullets'      =>
                                        "Maintained clean, safe, and hygienic buses to support passenger safety and service readiness.|
                                        Executed interior and exterior cleaning activities, including sweeping, mopping, vacuuming, and sanitizing floors and seats.|
                                        Followed safety and hygiene standards while supporting a dependable transportation environment for passengers."
                                    ,  // pipe-séparé : "Bullet 1 | Bullet 2 | Bullet 3"
                    'technologies' =>
                                        "Cleaning equipment ,
                                        Sanitizing supplies,
                                        Safety standards"
                                    ,  // virgule-séparé : "Laravel, Vue.js, MySQL"
                    'achievements' => "Supported passenger safety and daily service readiness through cleaning | sanitation, and safety-focused maintenance.",  // pipe-séparé : "Bullet 1 | Bullet 2 | Bullet 3",  // pipe-séparé : "Achievement 1 | Achievement 2"

                ],
                [
                    'company'      => "Peace Corps",
                    'title'        =>  "Administrative Assistant Internship",
                    'location'     => "Lome, Togo",
                    'date_start'   => "04/2019",
                    'date_end'     => "10/2019",  // ou 'Present'
                    'description'  => 'Supported passenger safety and daily service readiness through',
                    'bullets'      =>
                                        "Organized filing and archiving processes to support administrative recordkeeping and document retrieval.  |
                                        Managed courier activity and phone calls while supporting front-office communication. |
                                        Supported organization of trainings and formation activities. |
                                        Entered and processed investigation and survey data with attention to accuracy and confidentiality. |
                                        Welcomed, received, and oriented customers and visitors in a professional manner.",
                                         // pipe-séparé : "Bullet 1 | Bullet 2 | Bullet 3"
                    'technologies' => "Laravel, Vue.js, MySQL",  // virgule-séparé : "Laravel, Vue.js, MySQL"
                    'achievements' => "Bullet 1 | Bullet 2 | Bullet 3",  // pipe-séparé : "Achievement 1 | Achievement 2"
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 5 — projects
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'projects',
            'section_label' => 'Projects',
            'data' => [
                [
                    'name'         => "ly for the IT Systems and Network Support Technician position",
                    'description'  => "ly for the IT Systems and Network Support Technician position",
                    'technologies' => "Cleaning equipment ,
                                        Sanitizing supplies,
                                        Safety standards",  // virgule-séparé
                    'role'         => 'Sanitiz',
                    'impact'       => 'Managed courier activity and phone calls while',
                    'url'          => 'http://127.0.0.1:8000/',
                    'date_start'   => "07/2017",
                    'date_end'     => "07/2017",
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 6 — education
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'education',
            'section_label' => 'Education',
            'data' => [
                [
                    'degree'      => "Bachelor's Degree",
                    'field'       => "General Administrative Law",
                    'institution' => "Universite De Lome",
                    'location'    => "Lome, Togo",
                    'date_start'  => "11/2011",
                    'date_end'    => "07/2017",
                    'gpa'         => '',
                    'honors'      => '',
                    'details'     => '',
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 7 — certifications
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'certifications',
            'section_label' => 'Certifications',
            'data' => [
                [
                    'name'          => "Certif - Bachelor's Degree",
                    'issuer'        => 'cvzvzvvzv vrz vrvbrev',
                    'date'          => "11/2011",
                    'expiration'    => "11/2011",
                    'credential_id' => '732BBED7',
                ],
                [
                    'name'          => "Certif - Bachelor's Degree",
                    'issuer'        => 'cvzvzvvzv vrz vrvbrev',
                    'date'          => "11/2011",
                    'expiration'    => "11/2011",
                    'credential_id' => '732BBED7',
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 8 — licenses
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'licenses',
            'section_label' => 'Licenses',
            'data' => [
                [
                    'name'            => "licence - Bachelor's Degree",
                    'issuer'          => '',
                    'number'          => '88378299388',
                    'date'            => "11/2011",
                    'expiration'      => "11/2011",
                    'state_or_region' => "Lome, Togo",
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 9 — publications
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'publications',
            'section_label' => 'Publications',
            'data' => [
                [
                    'title'            =>  "Publication - Bachelor's Degree",
                    'journal_or_venue' => 'Publication - journal',
                    'date'             => "11/2011",
                    'url'              => '',
                    'authors'          => 'Harry',
                    'description'      => 'ckground also includes strong operational discipline, safety awareness, planning, mu',
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 10 — open_source_contributions
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'open_source_contributions',
            'section_label' => 'Open Source Contributions',
            'data' => [
                [
                    'project'     => "Project- Bachelor's Degree",
                    'description' => 'ckground also includes strong operational discipline, safety awareness, planning, mu',
                    'url'         => 'harry@github.com',
                    'impact'      => '',
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 11 — research_experience
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'research_experience',
            'section_label' => 'Research Experience',
            'data' => [
                [
                    'title'       => "Search- Bachelor's Degree",
                    'institution' => 'Lycee Ste Catherine',
                    'date_start'  => "07/2017",
                    'date_end'    => "07/2017",
                    'description' => '',
                    'bullets'     => "Maintained clean, safe, and hygienic bus interiors and exteriors to support passenger safety and daily service readiness. | Executed routine cleaning activities including sweeping, mopping, vacuuming, and sanitizing floors and seats. | Supported safety standards and inspection readiness within a fast-paced transportation environment.",  // pipe-séparé
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 12 — teaching_experience
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'teaching_experience',
            'section_label' => 'Teaching Experience',
            'data' => [
                [
                    'course'      => "teaching_experience - Bachelor's Degree",
                    'institution' => 'Lycee Ste Catherine',
                    'date_start'  => "07/2017",
                    'date_end'    => "07/2017",
                    'description' => 'Maintained clean, safe, and hygienic bus interiors and exteriors to support passenger safety and daily servi',
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 13 — grants_funding
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'grants_funding',
            'section_label' => 'Grants & Funding',
            'data' => [
                [
                    'title'       => "Grants & Funding - Bachelor's Degree",
                    'funder'      => 'Moi',
                    'amount'      => '120.000',
                    'date'        => '',
                    'description' => "07/2017",
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 14 — conference_presentations
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'conference_presentations',
            'section_label' => 'Conference Presentations',
            'data' => [
                [
                    'title'    => "Conference Presentations - Bachelor's Degree",
                    'event'    => 'AMEPT',
                    'date'     => '07/2017',
                    'location' => 'Lome, Togo',
                    'url'      => "",
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 15 — bar_admissions  (legal uniquement)
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'bar_admissions',
            'section_label' => 'Bar Admissions',
            'data' => [
                [
                    'jurisdiction' => 'Bar Admissions - Bachelors Degree',
                    'date'         => '07/2017',
                    'status'       => 'eligible',
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 16 — board_memberships
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'board_memberships',
            'section_label' => 'Board Memberships',
            'data' => [
                [
                    'organization' => 'Universite De Lome',
                    'role'         => 'Memberships - Bachelors Degree',
                    'date_start'   => "07/2017",
                    'date_end'     => "07/2017",
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 17 — affiliations
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'affiliations',
            'section_label' => 'Professional Affiliations',
            'data' => [
                [
                    'organization' => 'Universite De Lome',
                    'role'         => 'Affil - Bachelors Degree',
                    'date_start'   => "07/2017",
                    'date_end'     => "07/2017",
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 18 — awards
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'awards',
            'section_label' => 'Awards & Honors',
            'data' => [
                [
                    'name'        => 'Award - Bachelors Degree',
                    'issuer'      => '',
                    'date'        =>  "07/2017",
                    'description' => 'ux, TCP/IP, DNS, VPNs, firewalls, switches, Wi-Fi, backups, VMware, Hyper-V, Office 365, or cloud tools if applicable.","Consider earning entry-level IT certifications such as CompTIA A+, CompTIA Network+, Microsoft Fundamentals, Cisco CCST, or Google IT Support to strengthen credibility for US IT support roles.","Clarify the Ministere de La Communication internship dates because the listed range appears reversed.","If available, add measurable details such as number of users supported, number of computers repaired, number of devices configured, ticket volume, or repair turnaround time.","Prepare to explain the transition from bus cleaning maintenance back into IT support and emphasi lacks several enter local.INFO: AI analys',
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 19 — languages
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'languages',
            'section_label' => 'Languages',
            'data' => [
                [
                    'language' => 'Francais',
                    'level'    => 'Native',  // Native | Fluent | Professional | Conversational | Basic
                ],
                 [
                    'language' => 'Espagnol',
                    'level'    => 'Native',  // Native | Fluent | Professional | Conversational | Basic
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 20 — metrics_highlights
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'metrics_highlights',
            'section_label' => 'Key Metrics',
            'data' => [
                [
                    'label'   => ' Metrics aintenance',
                    'value'   => 'uter maintenance, PC diagnostics, operating syst',
                    'context' => 'leaning activities including sweeping, mopping, vacuuming, and sanitizing floors and seats. Supported safety standards and inspection readiness within ',
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 21 — portfolio_highlights
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'portfolio_highlights',
            'section_label' => 'Portfolio',
            'data' => [
                [
                    'title'       => 'Portfolio - support ',
                    'url'         => '',
                    'description' => 'nce: Computer maintenance, PC diagnostics, operating system installation, software installation, hardware troubleshooting, electronics repair, basic equipment repairsNetworking & Devices: Router configurat',
                    'media_type'  => 'image',  // image | video | pdf | link | case_study
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 22 — campaigns_highlights  (marketing)
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'campaigns_highlights',
            'section_label' => 'Campaign Highlights',
            'data' => [
                [
                    'name'        => 'Campaign - support ',
                    'description' => 'focused professional with over a decade of experience in electronics and network maintenance and sales, seeking to obtain a position',
                    'results'     => 'rganization of trainings and formatio',
                    'date_start'  => "07/2017",
                    'date_end'    => "07/2017",
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 23 — thought_leadership  (consulting)
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'thought_leadership',
            'section_label' => 'Thought Leadership',
            'data' => [
                [
                    'title' => 'Thought Leadership - tomer Support: Store management, sales, retu ',
                    'type'  => 'article',  // article | podcast | keynote | webinar | whitepaper
                    'venue' => '',
                    'date'  => "07/2017",
                    'url'   => 'http://localhost:5173/',
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 24 — pro_bono  (legal)
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'pro_bono',
            'section_label' => 'Pro Bono Work',
            'data' => [
                [
                    'organization' => 'Suzanne Dr',
                    'description'  => 'Customer Support: Store management, sales, returns, after-sales service',
                    'date_start'   => "07/2017",
                    'date_end'     => "07/2017",
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 25 — technical_competencies  (engineering)
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'technical_competencies',
            'section_label' => 'Technical Competencies',
            'data' => [
                'specializations' => [ "Network device configuration",

                                            "Training organization",
                                            "Report typing and printing"
                                            ],  // string[]
                'standards'       => [ "Network device configuration",
                                           "ersecurity awareness",
                                            "Filing and archiving",
                                            "Courier and phone call management",
                                            "Data entry and survey processing",
                                            "Training organization",
                                            "Report typing and printing"
                                            ],
                'software'        => [ "Network device configuration",
                                            "External device installation and configuration",
                                            "Store operations",
                                            "Sales",
                                            "Returns management",
                                            "After-sales service",
                                            "E-commerce",
                                            "Safety standards",

                                            "Report typing and printing"
                                            ],
                'methodologies'   => [ "Network device configuration",
                                            "External device installation and configuration",
                                            "Store operations",
                                           "anagement",
                                            "Data entry and survey processing",
                                            "Training organization",
                                            "Report typing and printing"
                                            ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 26 — tools_expertise  (design / data)
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'tools_expertise',
            'section_label' => 'Tools Expertise',
            'data' => [
                [
                    'category' => 'Editeur',
                    'tools'    => "Figma, Sketch, InVision",  // virgule-séparé : "Figma, Sketch, InVision"
                ],
            ],
        ],

        // ─────────────────────────────────────────────────
        // SECTION 27 — clinical_skills  (healthcare)
        // ─────────────────────────────────────────────────
        [
            'section_key'   => 'clinical_skills',
            'section_label' => 'Clinical Skills',
            'data' => [
                [
                    'category' => 'clinical_skills',
                    'skills'   => "ICU care, Wound management",  // virgule-séparé : "ICU care, Wound management"
                ],
            ],
        ],

    ],  // fin sections[]
];
    // return view('resume-2', ['resume' => $resume ]);
    return view('_pdf_copy', ['resume' => $resume ]);
});

