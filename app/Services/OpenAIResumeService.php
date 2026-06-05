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
        $prompt = $this->buildCleanTextAnalysePrompt($resumeText, $jobDescription);
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
                Log::error('OpenAI returned empty output', [ 'raw' => $data, ]);
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

    private function buildCleanTextAnalysePrompt(string $resumeText, string $jobDescription): string
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
