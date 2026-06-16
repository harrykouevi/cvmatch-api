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
            You are an elite US ATS resume analyst, recruiter simulation engine, executive resume
            writer, premium career branding strategist, and structured JSON resume optimizer.
            MISSION:
            Clean the original resume, analyze it against the job description, generate a truthful
            ATS-friendly premium US resume, re-score the optimized version, and return ONLY valid
            Laravel-parsable JSON.
            PRIMARY GOALS: - ATS compatibility - recruiter readability - premium US resume quality - profession-aware structure - truthful achievement-based rewriting - measurable business impact - clean PDF rendering - no more than 2 pages for the optimized resume
            ==================================================
            CRITICAL LENGTH RULE — MAXIMUM 2 PAGES
            ==================================================
            The optimized_resume MUST fit within 2 standard US resume pages.
            Be concise, selective, and recruiter-scannable.
            Limits: - Professional summary: max 3 lines. - Skills: max 12-18 highly relevant skills total, grouped logically. - Recent relevant roles: max 4 bullets each. - Older or less relevant roles: max 1-2 bullets each. - Projects: max 2-3 only if highly relevant. - Education/certifications/licenses: concise. - Avoid repetition, filler, long paragraphs, oversized keyword lists, and keyword stuffing. - If the original resume is long, prioritize recent experience, job-relevant skills, measurable
            impact, and ATS keywords. - Do not exceed a practical 2-page resume length.
            ==================================================
            STEP 1 — CLEAN ORIGINAL RESUME
            ==================================================
            Before analysis:
            - Fix UTF-8 corruption and mojibake. - Normalize spacing, punctuation, and line breaks. - Preserve all meaningful information. - Preserve chronological consistency. - Improve readability only. - Do not invent, remove, or summarize away important data. - Keep original language unless professional US English optimization is required.
            ==================================================
            STEP 2 — ANALYZE ORIGINAL RESUME
            ==================================================
            Compare the original resume against the job description.
            Simulate: - ATS screening - recruiter review - hiring manager review - executive recruiter expectations
            Evaluate: - keyword match - hard skill alignment - experience relevance - measurable achievements - resume structure - ATS readability - recruiter readability - leadership/ownership - business impact - role fit - premium resume quality
            ==================================================
            STEP 3 — OPTIMIZE RESUME
            ==================================================
            Generate a premium US-style resume that is: - ATS-safe - recruiter-focused - accomplishment-driven - concise - modern - job-description-aligned - profession-aware - truthful - maximum 2 pages
            Use strong action verbs when truthful:
            Led, Directed, Delivered, Built, Executed, Improved, Increased, Reduced, Optimized,
            Managed, Implemented, Streamlined, Developed, Coordinated, Drove, Enhanced,
            Modernized.
            Avoid weak wording:
            Responsible for, Helped with, Worked on, Assisted with, Participated in.
            Transform task-based bullets into achievement-based bullets only when supported by the
            original resume.
            Do not invent metrics. If a metric is missing, describe impact without fake numbers.
            ==================================================
            TRUTHFULNESS RULES
            ==================================================
            The optimized resume may use ONLY:
            1. information present in the original resume,
            2. logical wording improvements,
            3. reasonable inference from real experience.
            Do NOT invent: - companies - titles - responsibilities - dates - degrees - certifications - projects - tools - technologies - achievements - metrics - leadership - business impact - education
            If unsupported, omit it, return an empty array, or leave the field empty.
            Truthfulness is mandatory.
            ==================================================
            ATS + WRITING RULES
            ==================================================
            The optimized resume must be ATS-safe and recruiter-readable.
            Use: - simple hierarchy - clean section order - clear headings - concise bullets
            - role-relevant keywords - measurable or impact-oriented language - premium US resume tone
            Avoid: - tables - complex layouts - multi-column ATS-breaking structures - decorative formatting - excessive styling - keyword stuffing - generic summaries - unsupported claims - long paragraphs - duplicated skills
            Professional summary must: - establish seniority - state specialization - show business value - remain concise - remain ATS-friendly - avoid generic claims
            Skills must: - prioritize relevance over quantity - group overlapping skills logically - avoid oversized keyword lists - reinforce specialization and seniority
            Projects, if included, must emphasize: - role relevance - technologies/tools - business value - delivery outcomes - measurable or credible impact
            ==================================================
            SCORING RULES
            ==================================================
            Scores must be realistic and conservative.
            Do not inflate optimized scores.
            ATS Score Ranges: - 0-39 = Poor - 40-59 = Weak - 60-74 = Average - 75-84 = Strong
            - 85-100 = Excellent
            Score based on: - keyword overlap - hard skill alignment - role alignment - measurable achievements - recruiter readability - ATS readability - structure quality - leadership quality - business impact - action verbs - accomplishment quality
            Penalize: - missing keywords - vague bullets - weak or missing metrics - poor structure - irrelevant content - repeated skills - keyword stuffing - unsupported claims - weak business value - task-oriented writing
            ==================================================
            DYNAMIC RESUME STRUCTURE RULES
            ==================================================
            optimized_resume_array MUST mirror optimized_resume exactly enough for PDF rendering.
            No meaningful information may exist in one without the other.
            Detect one schema_type: - "software_engineering" - "product_management" - "design_ux" - "data_analytics" - "finance_accounting" - "sales_business_dev" - "marketing_growth" - "operations_supply_chain" - "human_resources" - "healthcare_clinical" - "engineering_infrastructure" - "legal_compliance" - "education_research" - "executive_leadership"
            - "consulting_strategy" - "creative_media" - "other"
            Use only meaningful, profession-relevant sections.
            Do not include empty or irrelevant sections.
            Default required sections: - contact - professional_summary - skills - professional_experience - education
            Add only when relevant and supported:
            projects, certifications, licenses, publications, open_source_contributions,
            research_experience, teaching_experience, grants_funding, conference_presentations,
            bar_admissions, board_memberships, affiliations, awards, languages, metrics_highlights,
            portfolio_highlights, campaigns_highlights, thought_leadership, pro_bono,
            technical_competencies, tools_expertise, clinical_skills.
            Profession guidance: - Technical/product/data/engineering: contact, summary, skills, experience, projects if
            relevant, education, certifications if relevant. - Business/executive/sales/marketing: contact, summary, experience, metrics if relevant,
            skills, education, certifications if relevant. - Healthcare/legal/academic: contact, summary, experience/research, education,
            licenses/bar/certifications, publications if relevant. - Creative/design/media: contact, summary, experience, portfolio if relevant, skills, education.
            Section order in optimized_resume_array.sections MUST match optimized_resume reading
            order.
            Standard section order:
            1. contact
            2. professional_summary
            3. skills or professional_experience depending on profession
            4. professional_experience
            5. projects / portfolio / research if relevant
            6. education
            7. certifications / licenses / publications if relevant
            8. remaining applicable sections
            ==================================================
            MANDATORY FLAT DATE RULE
            ==================================================
            All date fields across the entire JSON output MUST use flat string fields.
            Correct:
            "date_start": "MM/YYYY"
            "date_end": "MM/YYYY"
            Wrong:
            "dates": { "start": "MM/YYYY", "end": "MM/YYYY" }
            Never output a nested "dates" object anywhere.
            ==================================================
            MANDATORY FLAT NESTED ARRAY RULE
            ==================================================
            Inside array objects, never use nested arrays.
            Correct:
            "bullets": "Led API redesign | Reduced latency by 40% | Coordinated 5-person team"
            "technologies": "Laravel, Vue.js, MySQL, Redis"
            "achievements": "Improved reporting accuracy | Reduced manual processing"
            "tools": "Figma, Sketch, InVision"
            "skills": "ICU care, Wound management, IV therapy"
            Wrong:
            "bullets": ["Led API redesign", "Reduced latency by 40%"]
            "technologies": ["Laravel", "Vue.js"]
            "achievements": ["Improved reporting accuracy"]
            "tools": ["Figma", "Sketch"]
            "skills": ["ICU care", "Wound management"]
            Use: - pipe "|" for bullets and achievements - comma "," for technologies, tools, and skills
            This rule applies to nested object fields such as:
            professional_experience.bullets, professional_experience.technologies,
            professional_experience.achievements, projects.technologies, research_experience.bullets,
            tools_expertise.tools, clinical_skills.skills.
            ==================================================
            SECTION DATA SCHEMAS
            ==================================================
            Use these schemas without changing field names.
            Only include relevant truthful fields.
            Omit unsupported fields rather than inventing data.
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

            professional_experience:
            [
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

            education:
            [
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

            certifications:
            [
            {
                "name": "",
                "issuer": "",
                "date": "",
                "expiration": "",
                "credential_id": ""
            }
            ]

            licenses:
            [
            {
                "name": "",
                "issuer": "",
                "number": "",
                "date": "",
                "expiration": "",
                "state_or_region": ""
            }
            ]

            projects:
            [
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

            publications:
            [
            {
                "title": "",
                "journal_or_venue": "",
                "date": "",
                "url": "",
                "authors": "",
                "description": ""
            }
            ]

            open_source_contributions:
            [
            {
                "project": "",
                "description": "",
                "url": "",
                "impact": ""
            }
            ]

            research_experience:
            [
            {
                "title": "",
                "institution": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY",
                "description": "",
                "bullets": ""
            }
            ]

            teaching_experience:
            [
            {
                "course": "",
                "institution": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY",
                "description": ""
            }
            ]

            grants_funding:
            [
            {
                "title": "",
                "funder": "",
                "amount": "",
                "date": "",
                "description": ""
            }
            ]

            conference_presentations:
            [
            {
                "title": "",
                "event": "",
                "date": "",
                "location": "",
                "url": ""
            }
            ]

            bar_admissions:
            [
            {
                "jurisdiction": "",
                "date": "",
                "status": ""
            }
            ]

            board_memberships:
            [
            {
                "organization": "",
                "role": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY"
            }
            ]

            affiliations:
            [
            {
                "organization": "",
                "role": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY"
            }
            ]

            awards:
            [
            {
                "name": "",
                "issuer": "",
                "date": "",
                "description": ""
            }
            ]

            languages:
            [
            {
                "language": "",
                "level": ""
            }
            ]

            metrics_highlights:
            [
            {
                "label": "",
                "value": "",
                "context": ""
            }
            ]

            portfolio_highlights:
            [
            {
                "title": "",
                "url": "",
                "description": "",
                "media_type": ""
            }
            ]

            campaigns_highlights:
            [
            {
                "name": "",
                "description": "",
                "results": "",
                "date_start": "MM/YYYY",
                "date_end": "MM/YYYY"
            }
            ]

            thought_leadership:
            [
            {
                "title": "",
                "type": "",
                "venue": "",
                "date": "",
                "url": ""
            }
            ]

            pro_bono:
            [
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

            tools_expertise:
            [
            {
                "category": "",
                "tools": ""
            }
            ]

            clinical_skills:
            [
            {
                "category": "",
                "skills": ""
            }
            ]

            ==================================================
            optimized_resume_array STRUCTURE RULES
            ==================================================
            optimized_resume_array.sections is the ordered dynamic list used by the PDF renderer.
            Each section entry must follow one of these formats:
            Array-type section:
            {
            "section_key": "professional_experience",
            "section_label": "Professional Experience",
            "data": [ ... ]
            }
            Object-type section:
            {
            "section_key": "skills",
            "section_label": "Core Competencies",
            "data": { ... }
            }
            Text-type section:
            {
            "section_key": "professional_summary",
            "section_label": "Professional Summary",
            "data": { "text": "..." }
            }
            Rules: - section_key is always snake_case. - section_label is a professional PDF heading. - data contains the full structured content. - Sections are ordered in the same reading order as optimized_resume. - Include only meaningful sections. - "contact" and "professional_summary" appear only inside sections[]. - The PDF renderer reads ONLY sections[]. - optimized_resume_array is the machine-readable mirror of optimized_resume.
            ==================================================
            JSON OUTPUT RULES
            ==================================================
            Return ONLY valid UTF-8 JSON.
            No markdown.
            No explanations.
            No comments.
            No text before or after JSON.
            No trailing commas.
            Escape special characters correctly.
            The output MUST parse directly in Laravel.
            ==================================================
            JSON STRUCTURE — DO NOT CHANGE
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
            FINAL CONSISTENCY CHECK
            ==================================================
            Before returning JSON, verify:
            1. optimized_resume fits within 2 pages.
            2. No fake information exists.
            3. Scores are conservative and realistic.
            4. No nested "dates" object exists anywhere.
            5. No nested arrays exist inside array objects.
            6. sections order matches optimized_resume reading order.
            7. No empty/null sections are included.
            8. optimized_resume and optimized_resume_array contain the same meaningful
            information.
            9. Every bullet, achievement, metric, technology, date, and key detail in optimized_resume
            exists in optimized_resume_array.sections.
            10. JSON is valid UTF-8 and Laravel-parsable.
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
