<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class OpenAIResumeService
{
    private Client $client;
    private string $apiKey;
    private string $model;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.openai.com/v1/',
            'timeout' => 90,
        ]);

        $this->apiKey = config('services.openai.key');
        $this->model = config('services.openai.model', 'gpt-5.5');
    }

    public function analyze(string $resumeText, string $jobDescription): array
    {
        $prompt = $this->buildCleanTextAnalysePrompt_2($resumeText, $jobDescription);
        try {
            Log::info(["nnnnnnnnn", env('SIMULATE_AI',false)]);
            // =====================================================
            // SIMULATION MODE (DEV ONLY)
            // =====================================================
            if (env('SIMULATE_AI', false) === true) {

                $data = ["original_resume"=>["overall_ats_score"=>43,"match_level"=>"Weak","job_fit_summary"=>"The resume shows strong backend, Linux administration, REST API, Docker, MySQL, Agile/Scrum, and IT project coordination experience. However, the provided job description does not contain meaningful role requirements, technologies, responsibilities, or qualifications, so a reliable job-specific ATS match cannot be established. The original resume is also written in French, includes some non-ATS-friendly symbols, has a long summary, duplicate bullets, limited metrics, and overlapping employment dates that may require clarification for a US recruiter.","scoring_breakdown"=>["keyword_match"=>0,"skills_alignment"=>50,"experience_relevance"=>52,"resume_structure"=>54,"ats_readability"=>47,"achievement_quality"=>38],"missing_keywords"=>["No meaningful job-specific keywords could be extracted from the provided job description","Job title not identifiable","Required technologies not identifiable","Required responsibilities not identifiable","Required qualifications not identifiable"],"missing_hard_skills"=>["Unable to determine missing hard skills because the job description is not usable","No clear required programming languages listed","No clear infrastructure or DevOps requirements listed","No clear database requirements listed","No clear cloud or security requirements listed"],"weak_sections"=>["Professional summary is long and paragraph-heavy","Experience bullets are mostly responsibility-based rather than achievement-based","Several accomplishments lack measurable impact","Duplicate bullets appear in the current role","Resume is in French, which may reduce parsing and recruiter readability for US-based roles","Qualities section is generic and less valuable than technical achievements"],"strong_points"=>["More than 10 years of IT, backend development, and systems experience","Relevant backend stack including PHP, Laravel, JavaScript, Node.js, REST APIs, and MySQL","Linux administration, Docker deployment, server monitoring, and production support experience","Agile/Scrum project coordination and technical team leadership experience","Experience supporting production systems and critical data operations"],"detected_problems"=>["Provided job description appears invalid or nonsensical, preventing true ATS keyword matching","Use of icons and special characters in contact section may reduce ATS readability","Long professional profile may be skimmed by recruiters","Repeated deployment and incident-resolution bullets in the Business Help Consulting role","Concurrent roles from 2020 to 2024 and 2019 to 2024 may raise questions if not explained","Education naming and degree equivalency may need US-style clarification"],"recruiter_risk_flags"=>["Job fit cannot be validated because the job description is not meaningful","Overlapping employment dates between LIKSOFT and the Commission Electorale Nationale Independente may require clarification","Limited quantified results make impact harder to assess","Resume language may not match US recruiter expectations if applying to English-language roles"]],"optimized_resume_analysis"=>["overall_ats_score"=>58,"score_improvement"=>15,"scoring_breakdown"=>["keyword_match"=>0,"skills_alignment"=>60,"experience_relevance"=>60,"resume_structure"=>82,"ats_readability"=>86,"achievement_quality"=>58],"improvements_made"=>["Converted the resume into a US-style English format with clear section headings","Removed icons, duplicate bullets, and generic soft-skill lists","Condensed the professional summary into a recruiter-friendly profile","Reorganized technical skills into ATS-readable categories","Rewrote experience bullets with stronger action verbs and clearer technical context","Improved emphasis on backend engineering, REST APIs, Linux administration, Docker, MySQL, production support, monitoring, and Agile/Scrum","Preserved all real companies, dates, education, and technologies without inventing certifications or fake metrics"],"keywords_added"=>["Backend Engineer","Systems Engineer","Linux Administration","REST APIs","API Integration","Laravel","PHP","Node.js","JavaScript","Docker","MySQL","Database Administration","Production Deployment","Monitoring","Incident Resolution","Agile","Scrum","Technical Team Coordination","Performance Optimization","High Availability"],"recruiter_impression"=>"The optimized resume is significantly easier for a US recruiter and ATS to parse. It presents the candidate as a senior backend and systems professional with practical production, Linux, database, API, and project leadership experience. However, because the job description is invalid and contains no usable requirements, the resume cannot score as a strong or excellent match for this specific posting.","remaining_weaknesses"=>["True job-specific keyword alignment cannot be improved without a valid job description","Most achievements still lack measurable outcomes such as uptime improvement, latency reduction, number of users, team size, or deployment frequency","Overlapping employment dates should be explained as consulting, contract, part-time, or concurrent engagements if applicable","No certifications are listed","Cloud platform experience such as AWS, Azure, or GCP is not clearly demonstrated"]],"optimized_resume"=>"HARRY AYIGAN KOUEVI","optimized_resume_array"=>["full_name"=>"Harry Ayigan Kouevi","headline"=>"Backend & Systems Engineer | Linux Administrator | IT Project Lead","professional_summary"=>"Backend and Systems Engineer with 10+ years of experience designing, developing, deploying, monitoring, and maintaining web applications and IT systems. Strong background in PHP, Laravel, JavaScript, Node.js, REST API development, MySQL, Linux administration, Docker deployments, and production support. Experienced in Agile/Scrum project coordination, technical team leadership, database administration, system monitoring, incident resolution, and performance optimization for business-critical applications.","skills"=>["PHP","Laravel","JavaScript","Node.js","REST API development","API integration","Scalable backend architecture","AngularJS","Vue.js","HTML5","Bootstrap","Linux administration","Ubuntu","CentOS","Docker","Bash scripting","VPS deployment","Dedicated server deployment","System monitoring","Production support","Incident resolution","MySQL","Database modeling","Database performance optimization","Database administration","PostgreSQL fundamentals","DNS","DHCP","Routing","Firewall fundamentals","VPN fundamentals","Network security fundamentals","Cybersecurity fundamentals","Agile","Scrum","Technical team coordination","Git","VMware fundamentals","VirtualBox","Windows Server fundamentals"],"professional_experience"=>[["company"=>"Business Help Consulting","location"=>"Lome, Togo","title"=>"Developer / Project Lead","dates"=>"December 2024 - Present","bullets"=>["Lead digital projects using Agile/Scrum practices, coordinating technical delivery and team execution.","Design and develop a web-based appointment scheduling platform to support business workflows.","Build and integrate REST APIs with a Flutter mobile application.","Deploy, maintain, and support applications on Linux servers in production environments.","Manage production releases, deployment follow-up, and post-deployment support.","Monitor servers, troubleshoot technical incidents, and support service availability.","Improve application performance and system reliability through backend and infrastructure optimization."]],["company"=>"LIKSOFT","location"=>"Lome, Togo","title"=>"Backend Developer Consultant","dates"=>"October 2020 - October 2024","bullets"=>["Designed robust and scalable backend architectures for business applications.","Developed applications for HR management, billing, and loan management use cases.","Built secure and performance-focused REST APIs for internal and client-facing systems.","Deployed applications with Docker on Linux environments.","Supported high availability for production systems and services.","Integrated backend services with AngularJS user interfaces.","Optimized MySQL database performance and supported ongoing database maintenance.","Delivered corrective and evolutionary maintenance for production applications."]],["company"=>"Commission Electorale Nationale Independente","location"=>"Togo","title"=>"Database Administrator","dates"=>"2019 - 2024","bullets"=>["Administered databases supporting critical electoral operations.","Helped ensure data integrity, security, and availability across operational systems.","Optimized system and database performance to support time-sensitive election workflows.","Provided technical support for critical data operations and production issues."]],["company"=>"Force One","location"=>"Lome, Togo","title"=>"Freelance Web Developer, FOCUSAFRIK.COM","dates"=>"September 2017 - May 2019","bullets"=>["Designed and implemented a structured data model to support content, users, forums, advertisers, and advertisements.","Managed menus, content categories, user accounts, administrator accounts, and platform content workflows.","Improved backend processes to support application performance, scalability, and user experience.","Supported site administration features and content management capabilities for the web platform."]],["company"=>"KEOGRAPHIX","location"=>"Lome, Togo","title"=>"Full Stack Developer","dates"=>"September 2016 - September 2017","bullets"=>["Developed a portfolio management application to support inventory and operational tracking.","Built backend functionality using Laravel and JavaScript.","Participated in analysis, design, development, deployment, and maintenance phases of the software development life cycle.","Maintained and updated web applications based on user needs and new feature requirements."]],["company"=>"SUNU Assurances IARD-Togo","location"=>"Lome, Togo","title"=>"Full Stack Developer Intern","dates"=>"2015 - 2016","bullets"=>["Developed internal applications for insurance and infirmary-related workflows.","Used Laravel and MySQL to build and maintain application features.","Participated in the full software development cycle, including analysis, development, testing, and deployment support."]]],"education"=>[["degree"=>"Bachelor-level Degree in Computer Science, Bac+3 Level","institution"=>"IAEC","location"=>"Lome, Togo","date"=>"Academic Year: 2023 - 2024"],["degree"=>"Higher Technician Certificate in Computer Science","institution"=>"IAEC","location"=>"Lome, Togo","date"=>"2013"],["degree"=>"Baccalaureate, Series D","institution"=>"Lycee General d'Adidogome","location"=>"Lome, Togo","date"=>"2010"]],"certifications"=>[],"projects"=>[["name"=>"Appointment Scheduling Platform","organization"=>"Business Help Consulting","description"=>"Designed and developed a web platform with REST API integration for a Flutter mobile application and Linux server deployment."],["name"=>"Business Applications for HR, Billing, and Loan Management","organization"=>"LIKSOFT","description"=>"Developed backend services, REST APIs, MySQL database functionality, and production support for business applications."],["name"=>"FOCUSAFRIK.COM","organization"=>"Force One","description"=>"Supported data structure, user management, content workflows, forums, advertisers, advertisements, and backend performance improvements."]],"languages"=>["French: Fluent","English: Technical and professional working proficiency"]],"cover_letter"=>"Dear Hiring Team,I am writing to express my interest in a backend engineering, systems engineering, or IT project role aligned with my experience in software development, Linux administration, database administration, and production support. I bring more than 10 years of experience designing, developing, deploying, monitoring, and maintaining web applications and business-critical IT systems.My background includes PHP, Laravel, JavaScript, Node.js, REST API development, MySQL, Docker, Linux server administration, system monitoring, incident resolution, and Agile/Scrum project coordination. In recent roles, I have led digital projects, coordinated technical teams, developed backend platforms, integrated APIs with mobile applications, deployed applications on Linux environments, and supported production availability and performance.I would welcome the opportunity to contribute my backend development, systems administration, and project coordination experience to your technical team. Thank you for your time and consideration.Sincerely,Harry Ayigan Kouevi","recommendations"=>["Provide a valid job description before final tailoring; the current job description is not usable for accurate ATS matching.","Add measurable results where accurate, such as number of applications supported, team size, uptime, number of APIs, users served, deployment frequency, database size, or performance improvements.","Clarify whether the Commission Electorale Nationale Independente role was part-time, contract, consulting, or concurrent with LIKSOFT.","If applying to US or English-language roles, use the English optimized version and avoid icons, photos, tables, and heavy formatting.","Add a LinkedIn URL or GitHub/portfolio link if available and professionally maintained.","Consider adding relevant certifications only if actually earned, such as Linux, Docker, Scrum, cloud, or database certifications."],"warnings"=>["The job description appears to be invalid text, so the ATS score cannot represent a true role-specific match.","No fake skills, certifications, companies, degrees, or quantified metrics were added.","The optimized score remains conservative because job-specific requirements are unavailable.","Overlapping employment dates may trigger recruiter questions unless explained clearly."]];
                $output = json_encode($data);
                return [
                    'success' => true,
                    'data' => json_decode($output, true),
                ];
            }


            // =====================================================
            // REAL OPENAI CALL
            // =====================================================
            $response = $this->client->post('responses', [
                'timeout' => 180, // important
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => $this->model,
                    'input' => $prompt,
                    'text' => [
                        'format' => [
                            'type' => 'json_object'
                        ]
                    ]
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);
            $output = $data['output'][1]['content'][0]['text'] ?? null;

            if (!$output) {
                Log::error('OpenAI returned empty output');
                return [
                    'success' => false,
                    'message' => 'No response from OpenAI',
                ];
            }


            return [
                'success' => true,
                'data' => json_decode($output, true),
            ];

        }catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::warning('OpenAI connect error (retryable)', [ 'message' => $e->getMessage(), ]);
            return [
                'success' => false,
                'error_type' => 'connect_exception',
                'retryable' => true,
                'message' => 'OpenAI connection failed',
            ];
        }catch (\GuzzleHttp\Exception\RequestException $e) {

            // =====================================================
            // TIMEOUT ERROR (RETRYABLE ALSO)
            // =====================================================
            Log::warning('OpenAI request exception', [ 'message' => $e->getMessage(),]);
            return [
                'success' => false,
                'error_type' => 'request_exception',
                'retryable' => true,
                'message' => 'OpenAI request failed',
            ];
        }  catch (\Throwable $e) {
            Log::error('OpenAI analysis failed', [ 'message' => $e->getMessage(),]);
            return [
                'success' => false,
                'error_type' => 'fatal',
                'retryable' => false,
                'message' => 'AI analysis failed',
            ];
        }
    }


    public function cleanText(string $resumeText): array
    {
        $prompt = $this->buildCleanTextPrompt($resumeText);
        try {
            Log::info(["cleann nnnnnnnnn", env('SIMULATE_AI',false)]);
            if(env('SIMULATE_AI',false) == false){
                $response = $this->client->post('responses', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'Content-Type' => 'application/json',
                    ],
                    'json' => [
                        'model' => $this->model,
                        'input' => $prompt,
                        'text' => [
                            'format' => [
                                'type' => 'json_object'
                            ]
                        ]
                    ],
                ]);

                $data = json_decode($response->getBody()->getContents(), true);
                $output = $data['output'][1]['content'][0]['text'] ?? null;

                if (!$output) {
                    return [
                        'success' => false,
                        'message' => 'No response from OpenAI',
                    ];
                }
            }else{

                $data = ["text_clean" => "" ];
                $output = json_encode($data);
            }

            return [
                'success' => true,
                'data' => json_decode($output, true),
            ];
        } catch (\Throwable $e) {
            Log::error('OpenAI cleaning text failed', [
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'message' => 'AI cleaning text failed',
            ];
        }
    }


    private function buildPrompt(string $resumeText, string $jobDescription): string
    {
        return <<<PROMPT
            You are an elite US ATS resume analyst, recruiter simulation engine, and resume optimization specialist.

            Your task is to:
                1. Analyze the ORIGINAL resume against the job description
                2. Simulate a realistic ATS evaluation
                3. Generate an ATS-optimized US-style resume
                4. Re-evaluate the OPTIMIZED resume against the same job description
                5. Return realistic BEFORE and AFTER scoring based on actual improvements

            IMPORTANT:
                * Scores MUST reflect real differences between the original and optimized resume
                * Do NOT invent random score increases
                * The optimized score must be justified by actual keyword alignment, structure improvements, readability, and relevance
                * Simulate a modern ATS + recruiter evaluation used in US hiring systems

            Return ONLY valid JSON. No markdown. No explanations.

            Use this exact structure:

            {

            "original_resume": {
                "overall_ats_score": 0,
                "match_level": "",
                "job_fit_summary": "",
                "scoring_breakdown": {
                    "keyword_match": 0,
                    "skills_alignment": 0,
                    "experience_relevance": 0,
                    "resume_structure": 0,
                    "ats_readability": 0,
                    "achievement_quality": 0
                },
                "missing_keywords": [],
                "missing_hard_skills": [],
                "weak_sections": [],
                "strong_points": [],
                "detected_problems": [],
                "recruiter_risk_flags": []
            },

            "optimized_resume_analysis": {
                "overall_ats_score": 0,
                "score_improvement": 0,
                "scoring_breakdown": {
                    "keyword_match": 0,
                    "skills_alignment": 0,
                    "experience_relevance": 0,
                    "resume_structure": 0,
                    "ats_readability": 0,
                    "achievement_quality": 0
                },
                "improvements_made": [],
                "keywords_added": [],
                "recruiter_impression": "",
                "remaining_weaknesses": []
            }

            "optimized_resume": "",
            "optimized_resume_array": {
                "full_name": "",
                "headline": "",
                "professional_summary": "",
                "skills": [],
                "professional_experience": [],
                "education": [],
                "certifications": [],
                "projects": [],
                "languages": []
            },
            "cover_letter": "",
            "recommendations": [],
            "warnings": []
            }


            Scoring Rules:
            - Scores must be realistic and conservative

            - ATS score ranges:
                0-39 = Poor
                40-59 = Weak
                60-74 = Average
                75-84 = Strong
                85-100 = Excellent

            - Base scoring on:
                * keyword overlap with job description
                * relevance of experience
                * measurable achievements
                * ATS readability
                * formatting clarity
                * role alignment
                * skill matching
                * action verbs
                * recruiter readability

            - Penalize:
                * missing keywords
                * keyword stuffing
                * vague summaries
                * generic bullet points
                * weak metrics
                * irrelevant experience
                * poor structure
                * repeated skills
                * long paragraphs

            Rules:
            - Do NOT invent fake experience, fake companies, fake degrees or fake certifications
            - Improve wording using realistic US recruiter standards
            - Use ATS-friendly formatting
            - Add missing keywords ONLY when logically supported by the candidate’s real experience
            - Preserve chronological consistency
            - Rewrite bullet points to sound achievement-oriented
            - Use concise bullet points focused on achievements and responsibilities
            - Keep resume concise and recruiter-friendly
            - Use strong action verbs
            - Avoid duplicated skills
            - Prioritize measurable impact where possible
            - Ensure the output can be directly used in Laravel without additional cleanup

            JSON Rules:
            - Keep all arrays valid JSON arrays
            - Return ONLY valid UTF-8 JSON
            - Escape all special JSON characters correctly
            - Keep arrays as valid JSON arrays
            - No markdown
            - No extra text before or after JSON
            - Output must be directly parsable in Laravel

            Resume:
            $resumeText

            Job description:
            $jobDescription
            PROMPT;
    }

    private function buildCleanTextAnalysePrompt_1(string $resumeText, string $jobDescription): string
    {
        return <<<PROMPT
            You are an elite US ATS resume analyst, recruiter simulation engine, and resume optimization specialist, and text normalization engine.

            Your task is to:
                1. Clean and normalize the ORIGINAL resume text BEFORE any analysis:
                    - Fix UTF-8 corruption and mojibake
                    - Normalize spacing
                    - Normalize punctuation
                    - Normalize line breaks
                    - Preserve ALL information
                    - Do NOT summarize
                    - Do NOT remove content
                    - Keep original language
                    - Improve readability only
                2. Extract structured information from the ORIGINAL resume.
                3. Analyze the ORIGINAL resume against the job description
                4. Simulate a realistic ATS evaluation
                5. Generate an ATS-optimized US-style resume
                6. Re-evaluate the OPTIMIZED resume against the same job description
                7. Return realistic BEFORE and AFTER scoring based on actual improvements

            IMPORTANT:
                * Scores MUST reflect real differences between the original and optimized resume
                * Do NOT invent random score increases
                * The optimized score must be justified by actual keyword alignment, structure improvements, readability, and relevance
                * The optimized resume must be truthful, recruiter-realistic, ATS-friendly, and suitable for professional US applications.


            Return ONLY valid JSON. No markdown. No explanations. No text before or after the JSON.

            Use this exact structure:

            {

            "original_resume": {
                "text_clean":"",
                "resume_data":{
                    "full_name":"",
                    "headline":"",
                    "contact": {
                        "email": "",
                        "phone": "",
                        "location": "",
                        "linkedin": "",
                        "portfolio": ""
                    },
                    "professional_summary":"",
                    "skills":{
                        "technical": [],
                        "soft": [],
                        "tools": [],
                        "platforms": []
                    },
                    "professional_experience": [ { "company": "", "title": "", "location": "", "dates": "", "description": "", "bullets": [], "technologies": [], "achievements": [] } ],
                    "education": [ { "degree": "", "institution": "", "location": "", "dates": "", "details": "" } ],
                    "certifications":[ { "name": "", "issuer": "", "date": "", "expiration": "" } ],
                    "projects":[ { "name": "", "description": "", "technologies": [], "role": "", "impact": "" } ],
                    "languages": [ { "language": "", "level": "" } ],
                    "additional_sections": ""
                },
                "overall_ats_score": 0,
                "match_level": "",
                "job_fit_summary": "",
                "scoring_breakdown": {
                    "keyword_match": 0,
                    "skills_alignment": 0,
                    "experience_relevance": 0,
                    "resume_structure": 0,
                    "ats_readability": 0,
                    "achievement_quality": 0
                },
                "missing_keywords": [],
                "missing_hard_skills": [],
                "weak_sections": [],
                "strong_points": [],
                "detected_problems": [],
                "recruiter_risk_flags": []
            },

            "optimized_resume_analysis": {
                "overall_ats_score": 0,
                "score_improvement": 0,
                "scoring_breakdown": {
                    "keyword_match": 0,
                    "skills_alignment": 0,
                    "experience_relevance": 0,
                    "resume_structure": 0,
                    "ats_readability": 0,
                    "achievement_quality": 0
                },
                "improvements_made": [],
                "keywords_added": [],
                "recruiter_impression": "",
                "remaining_weaknesses": []
            }

            "optimized_resume": "",
            "optimized_resume_array": {
                "full_name": "",
                "headline": "",
                "contact": { "email": "", "phone": "", "location": "", "linkedin": "", "portfolio": "" },
                "professional_summary": "",
                "skills": { "technical": [], "soft": [], "tools": [], "platforms": [] },
                "professional_experience": [ { "company": "", "title": "", "location": "", "dates": "", "description": "", "bullets": [], "technologies": [], "achievements": [] } ],
                "education": [ { "degree": "", "institution": "", "location": "", "dates": "", "details": "" } ],
                "certifications": [ { "name": "", "issuer": "", "date": "", "expiration": "" } ],
                "projects": [ { "name": "", "description": "", "technologies": [], "role": "", "impact": "" } ],
                "languages": [ { "language": "", "level": "" } ],
                "additional_sections": ""
            },
            "cover_letter": "",
            "recommendations": [],
            "warnings": []
            }


            Scoring Rules:
            - Scores must be realistic and conservative

            - ATS score ranges:
                0-39 = Poor
                40-59 = Weak
                60-74 = Average
                75-84 = Strong
                85-100 = Excellent

            - Base scoring on:
                * keyword overlap with job description
                * hard skill alignment
                * relevance of experience
                * measurable achievements
                * ATS readability
                * formatting clarity
                * role alignment
                * action verbs
                * recruiter readability
                * clarity of responsibilities

            - Penalize:
                * missing keywords
                * keyword stuffing
                * vague summaries
                * generic bullet points
                * weak or absent metrics
                * irrelevant experience
                * poor structure
                * repeated skills
                * long paragraphs
                * unsupported claims

            Truthfulness Rules:
            - The optimized resume MUST contain ONLY information that:
            1. exists in the original resume,
            2. can be logically inferred from the candidate's real experience,
            3. or represents wording improvements of existing information.
            - Do NOT invent fake experience.
            - Do NOT invent fake companies.
            - Do NOT invent fake job titles.
            - Do NOT invent fake dates.
            - Do NOT invent fake degrees.
            - Do NOT invent fake certifications.
            - Do NOT invent fake projects.
            - Do NOT invent fake technologies.
            - Do NOT invent fake achievements.
            - Do NOT invent fake metrics.
            - If information is missing, leave the field empty instead of fabricating content.

            Resume Optimization Rules:
            - Use professional US resume standards.
            - Use ATS-friendly wording and structure.
            - Add missing keywords ONLY when logically supported by the candidate's real experience.
            - Preserve chronological consistency.
            - Rewrite bullet points to sound achievement-oriented.
            - Use concise bullet points focused on responsibilities and impact.
            - Keep content recruiter-friendly and realistic.
            - Use strong action verbs.
            - Avoid duplicated skills.
            - Prioritize measurable impact only when supported by the original resume.
            - Keep the final resume focused on the target job description.

            Structured Resume Rules:
            - Structure all resume sections for professional PDF rendering.
            - professional_experience must always be an array of objects.
            - Each professional_experience object should include, whenever possible: company, title, location, dates, description, bullets, technologies, achievements.
            - projects must always be an array of objects.
            - Each project object should include, whenever possible: name, description, technologies, role, impact.
            - education must always be an array of objects.
            - certifications must always be an array of objects.
            - languages must always be an array of objects.
            - skills must be grouped into: technical, soft, tools, platforms.
            - additional_sections may include awards, volunteer experience, publications, professional memberships, or other truthful relevant sections.
            - If a section has no supported information, return an empty array or empty string.
            - The JSON must be optimized for:
                ATS parsing,
                recruiter readability,
                premium PDF generation,
                Laravel rendering,
                structured frontend rendering.


            JSON Rules:
            - Keep all arrays valid JSON arrays
            - Return ONLY valid UTF-8 JSON
            - Escape all special JSON characters correctly
            - Keep arrays as valid JSON arrays
            - No trailing commas.
            - No markdown
            - No extra text before or after JSON
            - Output must be directly parsable in Laravel

            Resume:
            $resumeText

            Job description:
            $jobDescription
            PROMPT;
    }

    private function buildCleanTextAnalysePrompt_2(string $resumeText, string $jobDescription): string
    {
        return <<<PROMPT
            You are an elite US ATS resume analyst, recruiter simulation engine, executive resume writer, recruiter psychology specialist, premium career branding strategist, and text normalization engine.
            Your mission is to transform resumes into recruiter-grade, ATS-optimized, premium US resumes that compete with top-tier candidates applying to Fortune 500 companies, FAANG companies, executive roles, consulting firms, and high-performance US organizations.
            Your optimization must balance:
            - ATS compatibility,
            - recruiter psychology,
            - executive branding,
            - hiring manager readability,
            - business impact,
            - leadership positioning,
            - strategic storytelling,
            - measurable achievements,
            - and premium US resume writing standards.

            ==================================================
            STEP 1 — CLEAN & NORMALIZE ORIGINAL RESUME
            ==================================================
            Before any analysis:
            - Fix UTF-8 corruption and mojibake
            - Normalize spacing
            - Normalize punctuation
            - Normalize line breaks
            - Preserve ALL information
            - Do NOT summarize
            - Do NOT remove information
            - Keep original language
            - Improve readability only
            - Preserve chronological consistency

            ==================================================
            STEP 2 — EXTRACT STRUCTURED RESUME DATA
            ==================================================
            Extract structured information from the original resume.
            The extracted data must be truthful, structured, recruiter-readable, ATS-friendly, and optimized for:
            - Laravel rendering,
            - premium PDF generation,
            - frontend rendering,
            - scalable resume templates,
            - ATS parsing,
            - future DOCX export.

            ==================================================
            STEP 3 — ATS + RECRUITER ANALYSIS
            ==================================================
            Analyze the ORIGINAL resume against the job description.
            Simulate:
            - a realistic ATS evaluation,
            - a recruiter screening process,
            - a hiring manager review,
            - and executive recruiter expectations.
            Evaluate:
            - keyword alignment,
            - hard skill relevance,
            - measurable achievements,
            - recruiter readability,
            - business impact,
            - leadership positioning,
            - role alignment,
            - structure quality,
            - executive branding,
            - premium resume quality.

            ==================================================
            STEP 4 — ELITE US RESUME OPTIMIZATION
            ==================================================
            Generate an ATS-optimized AND recruiter-optimized US-style resume.
            The optimized resume must feel:
            - premium,
            - executive,
            - accomplishment-driven,
            - strategic,
            - recruiter-focused,
            - highly competitive,
            - modern,
            - polished,
            - and professionally written.
            The resume should resemble the quality level expected from:
            - Fortune 500 applicants,
            - FAANG-level applicants,
            - top consulting firms,
            - executive recruiters,
            - premium US resume writing agencies.

            ==================================================
            STEP 5 — RE-EVALUATE OPTIMIZED RESUME
            ==================================================
            Re-evaluate the optimized resume against the same job description.
            Scores MUST:
            - be realistic,
            - be conservative,
            - reflect actual improvements only,
            - and be justified by measurable optimization quality.
            Do NOT inflate scores artificially.

            ==================================================
            TRUTHFULNESS RULES
            ==================================================
            The optimized resume MUST contain ONLY information that:
            1. exists in the original resume,
            2. can be logically inferred from the candidate's real experience,
            3. or represents wording improvements of existing information.
            Do NOT invent:
            - fake companies,
            - fake job titles,
            - fake responsibilities,
            - fake dates,
            - fake degrees,
            - fake certifications,
            - fake projects,
            - fake technologies,
            - fake achievements,
            - fake metrics,
            - fake leadership,
            - fake business impact.
            If information is missing:
            - leave the field empty,
            - return an empty array,
            - or omit unsupported details logically.
            Truthfulness is mandatory.


            ==================================================
            ELITE US WRITING RULES
            ==================================================
            Write the optimized resume as if it were prepared by a top-tier US executive resume writer.
            The writing style must prioritize:
            - recruiter psychology,
            - executive readability,
            - business value,
            - leadership,
            - measurable outcomes,
            - operational improvements,
            - strategic impact,
            - ownership,
            - delivery performance,
            - scale,
            - optimization,
            - cross-functional collaboration.
            The resume should sound:
            - premium,
            - strategic,
            - concise,
            - credible,
            - executive,
            - and highly employable.


            ==================================================
            ACTION VERB RULES
            ==================================================
            Prefer strong executive action verbs such as:
            - Led
            - Directed
            - Delivered
            - Executed
            - Accelerated
            - Optimized
            - Reduced
            - Improved
            - Increased
            - Generated
            - Coordinated
            - Managed
            - Spearheaded
            - Implemented
            - Streamlined
            - Oversaw
            - Drove
            - Developed
            - Enhanced
            - Modernized
            Avoid weak wording such as:
            - Responsible for
            - Helped with
            - Worked on
            - Assisted with
            - Participated in
            unless no stronger truthful wording is logically supported.


            ==================================================
            PROFESSIONAL SUMMARY RULES
            ==================================================
            The professional summary must:
            - establish seniority,
            - communicate specialization,
            - position the candidate strategically,
            - communicate business value,
            - emphasize measurable impact,
            - highlight leadership,
            - communicate operational scale,
            - remain concise,
            - remain ATS-friendly,
            - remain recruiter-readable.
            Avoid generic summaries.
            Weak example:
            "Experienced engineer with strong technical skills."
            Preferred example:
            "Senior Civil Engineer with 12+ years of experience delivering large-scale infrastructure and commercial projects valued at $50M+ while improving operational efficiency, procurement strategy, and multidisciplinary project coordination."


            ==================================================
            BULLET POINT TRANSFORMATION RULES
            ==================================================
            Rewrite bullets to emphasize:
            - measurable outcomes,
            - achievements,
            - optimization,
            - efficiency improvements,
            - business value,
            - leadership,
            - project scale,
            - operational improvements,
            - delivery performance,
            - strategic contributions.
            Transform task-oriented bullets into achievement-oriented bullets whenever logically supported.
            Weak example:
            "Responsible for project planning and construction supervision."
            Preferred example:
            "Led project planning and construction supervision activities across multi-site infrastructure developments, improving delivery timelines and operational coordination."
            Weak example:
            "Prepared engineering reports."
            Preferred example:
            "Produced engineering and compliance reports supporting executive decision-making and regulatory approvals."
            Bullets must:
            - be concise,
            - be premium,
            - be recruiter-readable,
            - avoid fluff,
            - avoid generic phrasing.

            ==================================================
            SKILLS OPTIMIZATION RULES
            ==================================================
            Skills must:
            - remain strategic,
            - remain recruiter-friendly,
            - avoid oversized keyword lists,
            - avoid keyword stuffing,
            - reinforce specialization,
            - reinforce seniority,
            - prioritize relevance over quantity.
            Group overlapping skills logically.
            Prioritize:
            - high-value technical skills,
            - role-critical tools,
            - strategic competencies,
            - recruiter-relevant technologies.
            Avoid low-value generic tools unless directly relevant.

            ==================================================
            PROJECT WRITING RULES
            ==================================================
            Projects should emphasize:
            - project scale,
            - business value,
            - delivery outcomes,
            - measurable impact,
            - technologies used,
            - leadership contribution,
            - optimization,
            - operational improvements.
            Project descriptions should sound accomplishment-driven and executive-level whenever logically supported.

            ==================================================
            RECRUITER PSYCHOLOGY RULES
            ==================================================
            The optimized resume must feel written for:
            - ATS systems,
            - recruiters,
            - hiring managers,
            - executive reviewers.
            The resume should communicate:
            - professionalism,
            - credibility,
            - confidence,
            - leadership,
            - business value,
            - specialization,
            - operational scale,
            - executive maturity.
            Optimize for:
            - recruiter scanning speed,
            - executive readability,
            - hiring manager engagement,
            - premium resume perception.


            ==================================================
            ATS OPTIMIZATION RULES
            ==================================================
            Maintain:
            - ATS-friendly formatting,
            - ATS-readable structure,
            - simple hierarchy,
            - clean formatting,
            - recruiter-readable spacing,
            - ATS-safe organization.
            Avoid:
            - tables,
            - complex layouts,
            - multi-column ATS-breaking structures,
            - decorative formatting,
            - excessive styling,
            - keyword stuffing.
            ==================================================
            SCORING RULES
            ==================================================
            Scores must be realistic and conservative.
            ATS Score Ranges:
            - 0-39 = Poor
            - 40-59 = Weak
            - 60-74 = Average
            - 75-84 = Strong
            - 85-100 = Excellent
            Score based on:
            - keyword overlap,
            - hard skill alignment,
            - role alignment,
            - measurable achievements,
            - recruiter readability,
            - ATS readability,
            - executive branding,
            - business impact,
            - leadership quality,
            - structure quality,
            - action verbs,
            - accomplishment quality.
            Penalize:
            - missing keywords,
            - generic bullet points,
            - weak metrics,
            - vague summaries,
            - poor structure,
            - irrelevant experience,
            - repeated skills,
            - keyword stuffing,
            - unsupported claims,
            - weak leadership positioning,
            - weak business value,
            - task-oriented writing.


            ==================================================
            DYNAMIC RESUME STRUCTURE RULES (CRITICAL)
            ==================================================
            Every profession requires a different resume structure.
            The optimized_resume_array MUST reflect the exact structure
            needed to render the optimized_resume text as a PDF,
            with no information loss or mismatch.

            STEP A — DETECT PROFESSION CATEGORY
            Analyze the candidate's profession and map it to one
            of the following schema_type values:

            - "software_engineering" (Developers, Engineers, DevOps, Data, AI/ML, Security)
            - "product_management" (PM, Product Owner, Product Strategy)
            - "design_ux" (UX/UI Designer, Product Designer, Creative Director)
            - "data_analytics" (Data Analyst, Business Analyst, BI, Reporting)
            - "finance_accounting" (CFO, Controller, Accountant, Financial Analyst, Auditor)
            - "sales_business_dev" (AE, SDR, VP Sales, BD, Revenue, Partnerships)
            - "marketing_growth" (CMO, Growth, Brand, Digital Marketing, SEO, Content)
            - "operations_supply_chain" (COO, Operations Manager, Supply Chain, Logistics)
            - "human_resources" (CHRO, HR Manager, Talent, L&D, Recruitment)
            - "healthcare_clinical" (Physician, Nurse, Pharmacist, Clinical, Medical)
            - "engineering_infrastructure" (Civil, Mechanical, Electrical, Structural, Infrastructure)
            - "legal_compliance" (Attorney, Lawyer, Compliance, Risk, Paralegal)
            - "education_research" (Professor, Researcher, Academic, Scientist, R&D)
            - "executive_leadership" (C-Suite, VP, Director, General Manager, Principal)
            - "consulting_strategy" (Consultant, Strategy, Advisory, Management Consulting)
            - "creative_media" (Journalist, Writer, Editor, Video, Film, Audio)
            - "other" (Anything not covered above)

            STEP B — SELECT PROFESSION-SPECIFIC SECTIONS
            Based on the detected schema_type, include ONLY the sections
            that are standard, expected, and recruiter-relevant for that
            specific profession.
            Do NOT include sections that are irrelevant to the profession.
            Do NOT include empty sections that add no value.
            Do INCLUDE sections that are critical for the profession even
            if the original resume does not contain them, but ONLY if
            you have enough truthful information to populate them meaningfully.

            SECTION DEFINITIONS BY PROFESSION:
            software_engineering:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: projects, certifications, open_source_contributions, publications,
            languages, awards
            product_management:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: projects, certifications, metrics_highlights, languages, awards
            design_ux:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: portfolio_highlights, projects, certifications, tools_expertise, awards,
            languages
            data_analytics:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: projects, certifications, publications, tools_expertise, languages
            finance_accounting:
            Always include: contact, professional_summary, skills, professional_experience, education,
            certifications
            Include if applicable: licenses, board_memberships, publications, languages, awards
            sales_business_dev:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: metrics_highlights, certifications, languages, awards
            marketing_growth:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: campaigns_highlights, certifications, publications, languages, awards,
            portfolio_highlights
            operations_supply_chain:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: certifications, licenses, metrics_highlights, languages, awards
            human_resources:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: certifications, licenses, publications, languages, awards
            healthcare_clinical:
            Always include: contact, professional_summary, professional_experience, education,
            certifications, licenses
            Include if applicable: clinical_skills, publications, research_experience, languages, awards,
            affiliations
            engineering_infrastructure:
            Always include: contact, professional_summary, skills, professional_experience, education,
            certifications
            Include if applicable: licenses, projects, publications, technical_competencies, languages,
            awards, affiliations
            legal_compliance:
            Always include: contact, professional_summary, professional_experience, education,
            bar_admissions
            Include if applicable: certifications, publications, affiliations, languages, awards, pro_bono
            education_research:
            Always include: contact, professional_summary, education, research_experience,
            publications
            Include if applicable: professional_experience, grants_funding, conference_presentations,
            teaching_experience, certifications, languages, awards, affiliations
            executive_leadership:
            Always include: contact, professional_summary, professional_experience, education
            Include if applicable: board_memberships, certifications, publications, languages, awards,
            affiliations, metrics_highlights
            consulting_strategy:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: certifications, publications, languages, awards, thought_leadership,
            affiliations
            creative_media:
            Always include: contact, professional_summary, professional_experience, education
            Include if applicable: portfolio_highlights, publications, awards, languages, skills
            other:
            Always include: contact, professional_summary, skills, professional_experience, education
            Include if applicable: certifications, projects, languages, awards

            STEP C — SECTION DATA SCHEMAS
            ==================================================
            CRITICAL — FLAT DATE FORMAT RULE (MANDATORY)
            ==================================================
            ALL date fields across the ENTIRE JSON output MUST use
            a flat string format. NEVER use nested objects for dates.

            CORRECT (use this everywhere):
            "date_start": "MM/YYYY"
            "date_end": "MM/YYYY"

            WRONG (never use this):
            "dates": { "start": "MM/YYYY", "end": "MM/YYYY" }

            This rule applies to ALL sections:
            professional_experience, education, certifications,
            licenses, projects, research_experience, board_memberships,
            affiliations, campaigns_highlights, pro_bono, teaching_experience,
            grants_funding, conference_presentations, and any other section.

            Reason: nested date objects cause serialization depth errors.
            Always use flat string fields date_start and date_end.
            ==================================================

            Each section included in the resume MUST use the following data schema.
            Only include the fields that are relevant and truthful.
            Omit fields that have no data rather than returning empty strings.

            ==================================================
            CRITICAL — FLAT ARRAY RULE (MANDATORY)
            ==================================================
            ALL array fields nested inside array objects MUST use
            a flat pipe-separated string format. NEVER use nested
            arrays inside array objects.

            CORRECT (use this everywhere):
            "bullets": "Led API redesign | Reduced latency by 40% | Coordinated 5-person team"
            "technologies": "Laravel, Vue.js, MySQL, Redis"
            "achievements": "Increased revenue by 30% | Delivered project 2 weeks early"
            "tools": "Figma, Sketch, InVision"
            "skills": "ICU care, Wound management, IV therapy"

            WRONG (never use this):
            "bullets": ["Led API redesign", "Reduced latency by 40%"]
            "technologies": ["Laravel", "Vue.js"]
            "achievements": ["Increased revenue by 30%"]
            "tools": ["Figma", "Sketch"]
            "skills": ["ICU care", "Wound management"]

            This rule applies to ALL nested array fields:
            professional_experience.bullets
            professional_experience.technologies
            professional_experience.achievements
            projects.technologies
            research_experience.bullets
            tools_expertise.tools
            clinical_skills.skills

            Use pipe "|" as separator for bullets and achievements.
            Use comma "," as separator for technologies, tools, and skills.

            Reason: nested arrays inside array objects cause
            serialization depth errors in Laravel JSON parsing.
            Zero tolerance for nested arrays inside objects.

            --- UNIVERSAL SECTIONS (all professions) ---

            contact:
            {
            "email": "",
            "phone": "",
            "location": "",
            "linkedin": "",
            "portfolio": "",
            "github": "",
            "website": ""
            }

            professional_summary:
            {
            "text": ""
            }

            professional_experience: [
            {
                "company": "",
                "title": "",
                "location": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY",
                "description": "",
                "bullets": "",
                "technologies": "",
                "achievements": ""
            }
            ]

            education: [
            {
                "degree": "",
                "field": "",
                "institution": "",
                "location": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY",
                "gpa": "",
                "honors": "",
                "details": ""
            }
            ]

            --- SKILLS SECTIONS (profession-specific groupings) ---

            skills:
            {
            "technical": [],
            "soft": [],
            "tools": [],
            "platforms": [],
            "methodologies": [],
            "domain_expertise": [],
            "languages_programming": [],
            "frameworks": [],
            "databases": [],
            "cloud_devops": [],
            "clinical_skills": [],
            "financial_skills": [],
            "legal_skills": [],
            "design_skills": [],
            "marketing_skills": []
            }

            NOTE: Only include the skill sub-groups that are relevant
            to the detected profession. Omit irrelevant sub-groups entirely.

            --- PROFESSION-SPECIFIC SECTIONS ---

            certifications: [
            {
                "name": "",
                "issuer": "",
                "date": "",
                "expiration": "",
                "credential_id": ""
            }
            ]

            licenses: [
            {
                "name": "",
                "issuer": "",
                "number": "",
                "date": "",
                "expiration": "",
                "state_or_region": ""
            }
            ]

            projects: [
            {
                "name": "",
                "description": "",
                "technologies": "",
                "role": "",
                "impact": "",
                "url": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY"
            }
            ]

            publications: [
            {
                "title": "",
                "journal_or_venue": "",
                "date": "",
                "url": "",
                "authors": "",
                "description": ""
            }
            ]

            open_source_contributions: [
            {
                "project": "",
                "description": "",
                "url": "",
                "impact": ""
            }
            ]

            research_experience: [
            {
                "title": "",
                "institution": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY",
                "description": "",
                "bullets": ""
            }
            ]

            teaching_experience: [
            {
                "course": "",
                "institution": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY",
                "description": ""
            }
            ]

            grants_funding: [
            {
                "title": "",
                "funder": "",
                "amount": "",
                "date": "",
                "description": ""
            }
            ]

            conference_presentations: [
            {
                "title": "",
                "event": "",
                "date": "",
                "location": "",
                "url": ""
            }
            ]

            bar_admissions: [
            {
                "jurisdiction": "",
                "date": "",
                "status": ""
            }
            ]

            board_memberships: [
            {
                "organization": "",
                "role": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY"
            }
            ]

            affiliations: [
            {
                "organization": "",
                "role": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY"
            }
            ]

            awards: [
            {
                "name": "",
                "issuer": "",
                "date": "",
                "description": ""
            }
            ]

            languages: [
            {
                "language": "",
                "level": ""
            }
            ]

            metrics_highlights: [
            {
                "label": "",
                "value": "",
                "context": ""
            }
            ]

            portfolio_highlights: [
            {
                "title": "",
                "url": "",
                "description": "",
                "media_type": ""
            }
            ]

            campaigns_highlights: [
            {
                "name": "",
                "description": "",
                "results": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY"
            }
            ]

            thought_leadership: [
            {
                "title": "",
                "type": "",
                "venue": "",
                "date": "",
                "url": ""
            }
            ]

            pro_bono: [
            {
                "organization": "",
                "description": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY"
            }
            ]

            technical_competencies:
            {
            "specializations": [],
            "standards": [],
            "software": [],
            "methodologies": []
            }

            tools_expertise: [
            {
                "category": "",
                "tools": ""
            }
            ]

            clinical_skills: [
            {
                "category": "",
                "skills": ""
            }
            ]

            STEP D — SECTION ORDERING RULES
            The order of sections in optimized_resume_array.sections
            MUST match the reading order of the optimized_resume text.
            Standard ordering by profession type:
            For technical / engineering / product professions:
            1. contact
            2. professional_summary
            3. skills
            4. professional_experience
            5. projects (if present)
            6. education
            7. certifications (if present)
            8. then remaining applicable sections
            For business / executive / sales / marketing:
            1. contact
            2. professional_summary
            3. professional_experience
            4. skills
            5. education
            6. certifications (if present)
            7. then remaining applicable sections
            For academic / research / healthcare / legal:
            1. contact
            2. professional_summary
            3. professional_experience (or research_experience)
            4. education
            5. licenses / bar_admissions / certifications
            6. publications / conference_presentations
            7. then remaining applicable sections
            For creative / design / media:
            1. contact
            2. professional_summary
            3. professional_experience
            4. portfolio_highlights (if present)
            5. skills
            6. education
            7. then remaining applicable sections

            STEP E — STRICT PDF RENDERING GUARANTEE
            The optimized_resume_array MUST be structurally complete
            and content-complete enough that a PDF renderer can
            reconstruct the optimized_resume text with no meaningful
            information loss.
            Every bullet point, achievement, technology, metric, date,
            and detail present in the optimized_resume text MUST exist
            somewhere in the optimized_resume_array structure.
            Do NOT produce a summary-level array when the text is detailed.
            Do NOT produce an oversized array when the text is concise.
            The array is the machine-readable mirror of the text.

            ==================================================
            JSON OUTPUT RULES
            ==================================================
            Return ONLY valid UTF-8 JSON.
            No markdown.
            No explanations.
            No comments.
            No extra text before or after JSON.
            The output MUST be directly parsable in Laravel.
            Keep all arrays valid JSON arrays.
            Escape all special characters correctly.
            No trailing commas.

            ==================================================
            JSON STRUCTURE
            ==================================================
            {
            "original_resume": {
                "text_clean": "",
                "overall_ats_score": 0,
                "match_level": "",
                "job_fit_summary": "",
                "scoring_breakdown": {
                "keyword_match": 0,
                "skills_alignment": 0,
                "experience_relevance": 0,
                "resume_structure": 0,
                "ats_readability": 0,
                "achievement_quality": 0
                },
                "missing_keywords": [],
                "missing_hard_skills": [],
                "weak_sections": [],
                "strong_points": [],
                "detected_problems": [],
                "recruiter_risk_flags": []
            },
            "optimized_resume_analysis": {
                "overall_ats_score": 0,
                "score_improvement": 0,
                "executive_branding_score": 0,
                "recruiter_appeal_score": 0,
                "business_impact_score": 0,
                "scoring_breakdown": {
                "keyword_match": 0,
                "skills_alignment": 0,
                "experience_relevance": 0,
                "resume_structure": 0,
                "ats_readability": 0,
                "achievement_quality": 0
                },
                "improvements_made": [],
                "keywords_added": [],
                "recruiter_impression": "",
                "remaining_weaknesses": []
            },
            "optimized_resume": "",
            "optimized_resume_array": {
                "schema_version": "2.0",
                "schema_type": "",
                "full_name": "",
                "headline": "",
                "sections": []
            },
            "cover_letter": "",
            "recommendations": [],
            "warnings": []
            }
            ==================================================
            optimized_resume_array STRUCTURE RULES
            ==================================================
            The "sections" array in optimized_resume_array is the
            dynamic, ordered list of all resume sections.
            Each section entry in "sections" follows this structure:
            {
            "section_key": "professional_experience",
            "section_label": "Professional Experience",
            "data": [ ... ]
            }
            OR for object-type sections:
            {
            "section_key": "skills",
            "section_label": "Core Competencies",
            "data": { ... }
            }
            OR for text-type sections:
            {
            "section_key": "professional_summary",
            "section_label": "Professional Summary",
            "data": { "text": "..." }
            }
            Rules:
            - section_key is always a snake_case identifier.
            - section_label is the human-readable heading for the PDF.
            - data contains the full structured content for that section.
            - Sections are ordered per profession-specific ordering rules.
            - Only include sections that have meaningful content.
            - "contact" and "professional_summary" appear exclusively
            inside sections[], never as top-level fields.
            - The PDF renderer reads ONLY sections[].

            ==================================================
            CRITICAL — FLAT DATE FORMAT REMINDER
            ==================================================
            Before generating the JSON, verify that NO "dates" nested
            object exists anywhere in your output.
            Search for the pattern "dates": { and replace ALL instances
            with flat fields date_start and date_end at the same level
            as the other fields in that object.
            This is the single most common cause of serialization
            depth errors. Zero tolerance for nested date objects.



            ==================================================
            FINAL CONSISTENCY CHECK (MANDATORY)
            ==================================================
            Before returning the JSON output, verify:
            1. optimized_resume (text) contains all information
            present in optimized_resume_array.sections.
            2. optimized_resume_array.sections contains all information
            present in optimized_resume (text).
            3. No bullet point, achievement, metric, or technology
            exists in one but not the other.
            4. Section order in sections array matches the reading
            order of optimized_resume text.
            5. schema_type correctly reflects the candidate's profession.
            6. All section_labels are professional and recruiter-appropriate.
            7. No section is included with empty or null data.
            8. Zero nested date objects exist anywhere in the output.
            All dates use flat date_start and date_end string fields.

            Resume:
            $resumeText

            Job description:
            $jobDescription
            PROMPT;
    }

    private function buildCleanTextPrompt(string $text): string
    {
        return <<<PROMPT
            You are a strict text cleaning system.

            Task:
            - Fix encoding issues (UTF-8 corruption, mojibake)
            - Normalize spacing, punctuation, line breaks
            - Preserve ALL information (do NOT summarize, do NOT remove content)
            - Keep original language
            - Improve readability only

            Rules:
            - Output ONLY valid JSON
            - NO markdown
            - NO explanations
            - NO extra text

            Output format:
            {
            "text_clean": "..."
            }

            Input text:
            """
            $text
            """
            PROMPT;
    }

    private function buildPrompt_(string $resumeText, string $jobDescription): string
    {

        return "
            You are an expert US resume strategist and ATS optimization specialist.

            Analyze the candidate resume against the job description.

            Return ONLY valid JSON. No markdown. No explanations outside JSON.

            Use this exact structure:

            {
            \"ats_score\": 0,
            \"match_level\": \"\",
            \"job_fit_summary\": \"\",
            \"missing_keywords\": [],
            \"weak_sections\": [],
            \"strong_points\": [],
            \"optimized_resume\": {
                \"full_name\": \"\",
                \"headline\": \"\",
                \"professional_summary\": \"\",
                \"skills\": [],
                \"professional_experience\": [],
                \"education\": [],
                \"languages\": []
            },
            \"cover_letter\": \"\",
            \"before_after_summary\": [],
            \"recommendations\": [],
            \"warnings\": []
            }

            Rules:
            - Use US resume standards.
            - Do not invent fake experience.
            - Do not add fake employers, fake degrees, fake certifications, or fake dates.
            - Improve wording, structure, relevance, and keyword alignment.
            - Translate and adapt the resume into professional English.
            - Keep the candidate's real experience.
            - Make the resume relevant to the Marketing Engagement Associate Manager role.
            - If the candidate lacks required experience, explain it in warnings.

            Resume:
            {$resumeText}

            Job description:
            {$jobDescription}
        ";
    }
}
