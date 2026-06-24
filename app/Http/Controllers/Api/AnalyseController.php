<?php

namespace App\Http\Controllers\Api;

use App\Criteria\AnalyseOfUserCriteria;
use App\Criteria\LimitOffsetCriteria;
use App\Events\AiPerfomEvent;
use App\Http\Controllers\Api\Controller;
use App\Models\Analyse;
use App\Models\User;
use App\Repositories\Interfaces\AnalyseRepository;
use App\Repositories\Interfaces\CreditRepository;
use App\Repositories\Interfaces\CreditTransactionRepository;
use App\Repositories\Interfaces\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Validation\ValidationException;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Str;


class AnalyseController extends Controller
{

      /** @var AnalyseRepository */
    private AnalyseRepository $analyseRepository;

     /** @var CreditRepository */
    private CreditRepository $creditRepository;

      /** @var CreditTransactionRepository */
    private CreditTransactionRepository $creditTransactionRepository;

    /** @var  UserRepository */
    private UserRepository $userRepository;

    public function __construct(AnalyseRepository $analyseRepo ,
        CreditRepository $creditRepository,
        CreditTransactionRepository $creditTransactionRepository,
        UserRepository $userRepo

    )
    {
        $this->creditRepository = $creditRepository;
        $this->analyseRepository = $analyseRepo;
        $this->creditTransactionRepository = $creditTransactionRepository;
        $this->userRepository = $userRepo;

        parent::__construct();
    }

    public function store(Request $request): JsonResponse
    {

        try {
            $user = Auth::user() ?? $request->attributes->get('current_user');
            if (!$user) {
                throw new Exception("User not authenticated");
            }

            $this->validate($request, Analyse::$rules   );

            $input = $request->all();
            $input['status'] = 'pending';
            $input['user_id'] = $user->id;
            $input['is_full_unlocked'] = false;

            $analyse = $this->analyseRepository->create($input);
            Log::info("about to perform ai :");

            Log::info('EVENT DISPATCH', [
                'analyse_id' => $analyse->id,
                'time' => microtime(true),
            ]);

            event(new AiPerfomEvent($analyse));
            User::where('id', $analyse->user_id)->update(['current_analyse_done'=>  $analyse->id ]);
        } catch (ValidationException $e) {
            return $this->sendError(array_values($e->errors()), 422);
        } catch (Exception $e) {
            Log::error("Error storing analyse: " . $e->getMessage());

            return $this->sendError($e->getMessage(), 500);
        }
        $response = $this->sendResponse($this->partialResponse($analyse), __('lang.saved_successfully', ['operator' => __('lang.resume')]));
        return $response;
    }


    public function unlockFullResult($id, Request $request): JsonResponse
    {
        try {

            $user = Auth::user() ?? $request->attributes->get('current_user');

            if (!$user) {
                return $this->sendError('User not authenticated', 401);
            }

            $analyse = DB::transaction(function () use ($id, $user) {

                $this->analyseRepository->pushCriteria( new AnalyseOfUserCriteria($user->id));

                if (is_numeric($id)) {
                    $analyse = $this->analyseRepository->findWhere([
                        'id' => $id
                    ]) ->first();
                } else {
                    if (Str::isUuid($id)) {
                        $analyse = $this->analyseRepository->findWhere(['uuid'=> $id])->first();
                    } else {
                        return $this->sendError('Analyse not found');
                    }
                }
                if (!$analyse) {
                    throw new Exception('Analyse not found');
                }

                // déjà débloqué
                if ($analyse->is_full_unlocked) {
                    return $analyse;
                }

                $cost = 1;
                $credit = $this->creditRepository ->findByField('user_id', $user->id)->first();

                if (!$credit) {
                    throw new Exception('Not enough credits');
                }

                if ($credit->balance < $cost) {
                    throw new Exception('Not enough credits');
                }

                // consommation crédit
                $this->consumeCredit($user->id, $cost);

                $analyse->update([ 'is_full_unlocked' => true ]);

                return $analyse->fresh();
            });

            return $this->sendResponse(
                $this->fullResponse($analyse),
                'Full result retrieved successfully'
            );

        } catch (Exception $e) {

            Log::error($e->getMessage());
            return $this->sendError($e->getMessage(), 500);
        }
    }


    public function show($id, Request $request): JsonResponse
    {
        $user = Auth::user() ?? $request->attributes->get('current_user');
        if (!$user) {
            throw new Exception("User not authenticated");
        }


        try {
            $this->analyseRepository->pushCriteria(new AnalyseOfUserCriteria($user->id));
            $this->analyseRepository->pushCriteria(new RequestCriteria($request));
            $this->analyseRepository->pushCriteria(new LimitOffsetCriteria($request));

            if (is_numeric($id)) {
                $analyse = $this->analyseRepository->findWhere([
                    'id' => $id
                ]) ->first();
            } else {
                if (Str::isUuid($id)) {
                    $analyse = $this->analyseRepository->findWhere(['uuid'=> $id])->first();
                } else {
                    return $this->sendError('Analyse not found');
                }
            }

            if (empty($analyse)) {
                return $this->sendError('%Analyse not found');
            }

        } catch (RepositoryException $e) {
            return $this->sendError($e->getMessage());
        }

        // $this->authorize('view', $analyse);

        if ($analyse->is_full_unlocked) {
            return $this->sendResponse(
                $this->fullResponse($analyse),
                'Full result  retrieved successfully'
            );
        }

        return $this->sendResponse(
            $this->partialResponse($analyse),
            'Partial result  retrieved successfully'
        );
    }

    private function partialResponse(Analyse $analysis)
    {
        return[
            'id' => $analysis->uuid,
            'resume_id' => $analysis->resume->uuid,
            'user_id' => $analysis->user_id,
            'status' => $analysis->status,
            'score' => $analysis->score,
            'match_level' => $analysis->match_level,
            'critical_issues' => $analysis->critical_problems_json,
            'score_breakdown' => $analysis->score_breakdown_json,
            'missing_keywords' => $analysis->missing_keywords_json,
            'optimized_resume_analysis' => $analysis->optimized_resume_analysis_json,
            'optimized_resume_text' => substr( $analysis->optimized_resume_text, 0, 200),
            'posted_resume' => $analysis->resume->extracted_text,
            'locked' => true
        ];
    }

    private function fullResponse(Analyse $analysis)
    {
        return [
            'id' => $analysis->uuid,
            'resume_id' => $analysis->resume->uuid,
            'user_id' => $analysis->user_id,
            'status' => $analysis->status,
            'score' => $analysis->score,
            'match_level' => $analysis->match_level,
            'critical_issues' => $analysis->critical_problems_json,
            'score_breakdown' => $analysis->score_breakdown_json,
            'missing_keywords' => $analysis->missing_keywords_json,
            'optimized_resume_analysis' => $analysis->optimized_resume_analysis_json,
            'optimized_resume' => $analysis->optimized_resume,
            'optimized_resume_text' => $analysis->optimized_resume_text,
            'posted_resume' => $analysis->resume->extracted_text,
            'cover_letter' => $analysis->cover_letter,
            'preview' => $analysis->optimized_resume_text,
            'locked' => false
        ];
    }

    private function consumeCredit(int $userId, int $credits)
    {
        return DB::transaction(function () use  ($userId, $credits) {
            $wallet = $this->creditRepository->findByField('user_id', $userId)->first();
            $wallet->lockForUpdate();
            if (!$wallet) {
                throw new Exception('Credit wallet not found');
            }
            if ($wallet->balance < $credits) {
                throw new Exception('Insufficient credits');
            }

            $newBalance = $wallet->balance - $credits;

            $this->creditRepository->update([
                'balance' => $newBalance,
                'used' => $wallet->used + $credits,
            ],$wallet->id);

            $this->creditTransactionRepository->create([
                'user_id' => $userId,
                'type' => 'usage',
                'credits' => -$credits,
                'balance_after' => $newBalance,
                'description' => 'Full analysis unlock',
            ]);

            return $wallet->fresh();
        });
    }


    public function downloadResume($id, Request $request){


        $this->analyseRepository->pushCriteria(new AnalyseOfUserCriteria($request->user()->id));
        if (is_numeric($id)) {
            $analyse = $this->analyseRepository->findWhere([
                'id' => $id
            ]) ->first();
        } else {
            if (Str::isUuid($id)) {
                $analyse = $this->analyseRepository->findWhere(['uuid'=> $id])->first();
            } else {
                return $this->sendError('Analyse not found');
            }
        }
        if (empty($analyse)) {
            return $this->sendError('Analyse not found');
        }


        // $resume = [
        //     "full_name" => "Jean-Claude Mensah",

        //     "headline" => "Senior Civil Engineer | Building Construction Manager | Structural Design & Project Management Specialist",

        //     "contact" => [
        //         "email" => "jeanclaude.mensah@gmail.com",
        //         "phone" => "+228 90 12 34 56",
        //         "location" => "Lome, Togo",
        //         "linkedin" => "linkedin.com/in/jeanclaudemensah",
        //         "portfolio" => "www.jeanclaude-mensah-engineering.com"
        //     ],

        //     "professional_summary" => "Experienced Civil and Building Engineer with more than 12 years of experience managing large-scale residential, commercial, industrial, and infrastructure construction projects. Proven expertise in structural analysis, reinforced concrete design, construction supervision, project planning, cost estimation, quality assurance, contract administration, and site management. Strong knowledge of international building standards, safety regulations, procurement processes, and multidisciplinary coordination. Successfully delivered projects exceeding $50 million in cumulative value while maintaining strict compliance with budget, schedule, and quality requirements.",

        //     "skills" => [

        //         "technical" => [
        //             "Structural Engineering",
        //             "Reinforced Concrete Design",
        //             "Steel Structure Design",
        //             "Building Information Modeling (BIM)",
        //             "Construction Project Management",
        //             "Site Supervision",
        //             "Cost Estimation",
        //             "Quantity Surveying",
        //             "Geotechnical Analysis",
        //             "Road and Infrastructure Design",
        //             "Construction Scheduling",
        //             "Contract Management",
        //             "Risk Management",
        //             "Quality Assurance",
        //             "Quality Control",
        //             "Technical Drawing",
        //             "Structural Inspection",
        //             "Material Testing",
        //             "Procurement Management",
        //             "Budget Planning"
        //         ],

        //         "soft" => [
        //             "Leadership",
        //             "Team Management",
        //             "Problem Solving",
        //             "Decision Making",
        //             "Communication",
        //             "Stakeholder Management",
        //             "Conflict Resolution",
        //             "Negotiation",
        //             "Strategic Planning",
        //             "Adaptability",
        //             "Attention to Detail",
        //             "Time Management"
        //         ],

        //         "tools" => [
        //             "AutoCAD",
        //             "Revit",
        //             "Civil 3D",
        //             "SAP2000",
        //             "ETABS",
        //             "STAAD Pro",
        //             "MS Project",
        //             "Primavera P6",
        //             "SketchUp",
        //             "ArcGIS",
        //             "Microsoft Excel",
        //             "Bluebeam"
        //         ],

        //         "platforms" => [
        //             "Windows",
        //             "Linux",
        //             "Autodesk Construction Cloud",
        //             "BIM 360",
        //             "Oracle Primavera",
        //             "Microsoft Project Server"
        //         ]
        //     ],

        //     "professional_experience" => [

        //         [
        //             "company" => "West Africa Construction Group",
        //             "title" => "Senior Civil Engineer / Construction Project Manager",
        //             "location" => "Lome, Togo",
        //             "dates" => "01/2020 - Present",

        //             "description" => "Lead engineering and construction activities for large residential, commercial, and mixed-use development projects. Responsible for planning, budgeting, contractor management, quality control, and regulatory compliance.",

        //             "bullets" => [
        //                 "Managed construction projects with budgets exceeding $20 million from design phase through final delivery.",
        //                 "Supervised multidisciplinary teams including architects, structural engineers, MEP engineers, contractors, and consultants.",
        //                 "Implemented project control systems that reduced schedule delays by 18%.",
        //                 "Coordinated procurement activities and negotiated supplier contracts resulting in significant cost savings.",
        //                 "Reviewed structural calculations and technical drawings to ensure compliance with engineering standards.",
        //                 "Conducted site inspections and quality assurance audits throughout project execution.",
        //                 "Prepared monthly progress reports and executive presentations for stakeholders and investors.",
        //                 "Ensured full compliance with health, safety, environmental, and regulatory requirements."
        //             ],

        //             "technologies" => [
        //                 "AutoCAD",
        //                 "Revit",
        //                 "Primavera P6",
        //                 "SAP2000",
        //                 "ETABS",
        //                 "BIM 360"
        //             ],

        //             "achievements" => [
        //                 "Delivered a 25-story commercial tower 3 months ahead of schedule.",
        //                 "Reduced project costs by 12% through optimized procurement strategies.",
        //                 "Managed over 300 construction personnel across multiple project sites."
        //             ]
        //         ],

        //         [
        //             "company" => "African Infrastructure Development Corporation",
        //             "title" => "Civil Engineer",
        //             "location" => "Accra, Ghana",
        //             "dates" => "06/2015 - 12/2019",

        //             "description" => "Responsible for engineering design, project coordination, construction supervision, and technical review of major public infrastructure projects.",

        //             "bullets" => [
        //                 "Designed reinforced concrete structures for government facilities and transportation infrastructure.",
        //                 "Performed structural calculations and load analysis using advanced engineering software.",
        //                 "Prepared engineering reports, technical specifications, and construction documentation.",
        //                 "Coordinated contractors, consultants, and government agencies throughout project execution.",
        //                 "Conducted risk assessments and developed mitigation plans.",
        //                 "Monitored construction progress and ensured compliance with approved designs.",
        //                 "Participated in contract administration and variation order evaluations."
        //             ],

        //             "technologies" => [
        //                 "AutoCAD",
        //                 "STAAD Pro",
        //                 "Civil 3D",
        //                 "MS Project"
        //             ],

        //             "achievements" => [
        //                 "Successfully delivered 15+ infrastructure projects.",
        //                 "Improved project reporting efficiency by 25%."
        //             ]
        //         ],

        //         [
        //             "company" => "BuildTech Engineering Consultants",
        //             "title" => "Junior Structural Engineer",
        //             "location" => "Lome, Togo",
        //             "dates" => "09/2011 - 05/2015",

        //             "description" => "Supported senior engineers in structural design, drafting, site inspections, and engineering calculations.",

        //             "bullets" => [
        //                 "Prepared structural calculations for residential and commercial buildings.",
        //                 "Created detailed engineering drawings and technical documentation.",
        //                 "Assisted in site inspections and quality control activities.",
        //                 "Supported material testing and construction monitoring.",
        //                 "Collaborated with architects and project managers."
        //             ],

        //             "technologies" => [
        //                 "AutoCAD",
        //                 "SAP2000",
        //                 "Excel"
        //             ],

        //             "achievements" => [
        //                 "Contributed to more than 40 successful building projects."
        //             ]
        //         ]
        //     ],

        //     "education" => [

        //         [
        //             "degree" => "Master of Science in Structural Engineering",
        //             "institution" => "Kwame Nkrumah University of Science and Technology",
        //             "location" => "Kumasi, Ghana",
        //             "dates" => "2013 - 2015",
        //             "details" => "Advanced structural analysis, seismic design, finite element methods, reinforced concrete and steel structures."
        //         ],

        //         [
        //             "degree" => "Bachelor of Science in Civil Engineering",
        //             "institution" => "University of Lome",
        //             "location" => "Lome, Togo",
        //             "dates" => "2008 - 2011",
        //             "details" => "Civil engineering fundamentals, construction management, hydraulics, transportation engineering, geotechnical engineering."
        //         ]
        //     ],

        //     "certifications" => [

        //         [
        //             "name" => "Project Management Professional (PMP)",
        //             "issuer" => "Project Management Institute",
        //             "date" => "2022",
        //             "expiration" => "2025"
        //         ],

        //         [
        //             "name" => "Autodesk Certified Professional - Revit",
        //             "issuer" => "Autodesk",
        //             "date" => "2021",
        //             "expiration" => ""
        //         ],

        //         [
        //             "name" => "NEBOSH Construction Safety Certification",
        //             "issuer" => "NEBOSH",
        //             "date" => "2020",
        //             "expiration" => ""
        //         ]
        //     ],

        //     "projects" => [

        //         [
        //             "name" => "25-Story Commercial Tower Development",
        //             "description" => "Managed the engineering and construction of a high-rise mixed-use commercial tower in downtown Lome.",
        //             "technologies" => [
        //                 "Revit",
        //                 "SAP2000",
        //                 "Primavera P6",
        //                 "BIM 360"
        //             ],
        //             "role" => "Project Manager and Lead Civil Engineer",
        //             "impact" => "Delivered project ahead of schedule with 12% cost savings."
        //         ],

        //         [
        //             "name" => "Regional Highway Expansion Program",
        //             "description" => "Oversaw design review and construction supervision for a 65-kilometer highway expansion project.",
        //             "technologies" => [
        //                 "Civil 3D",
        //                 "AutoCAD",
        //                 "MS Project"
        //             ],
        //             "role" => "Civil Engineer",
        //             "impact" => "Improved transportation capacity and reduced travel time by 30%."
        //         ],

        //         [
        //             "name" => "University Campus Development",
        //             "description" => "Managed structural design and construction coordination for multiple academic buildings.",
        //             "technologies" => [
        //                 "ETABS",
        //                 "Revit",
        //                 "Primavera"
        //             ],
        //             "role" => "Senior Structural Engineer",
        //             "impact" => "Delivered facilities serving more than 10,000 students."
        //         ]
        //     ],

        //     "languages" => [

        //         [
        //             "language" => "French",
        //             "level" => "Native"
        //         ],

        //         [
        //             "language" => "English",
        //             "level" => "Professional Working Proficiency"
        //         ],

        //         [
        //             "language" => "Spanish",
        //             "level" => "Basic"
        //         ]
        //     ],

        //     "additional_sections" => "Member of the National Society of Civil Engineers. Experienced in sustainable construction practices, green building certification processes, environmental impact assessments, and public-private partnership infrastructure projects. Regular participant in international engineering conferences and construction technology workshops."
        // ];

        $using_array = true;
        if($using_array == true && $analyse->created_at->gt(Carbon::create(2026, 6, 12))){

            $resume = json_decode($analyse->optimized_resume, true);
            if (!$resume) {
                return $this->sendError('Resume data invalid', 500);
            }

            $pdf = Pdf::loadView('pdf._pdf_copy', [
                'resume' => $resume
            ]);
        }else{
            $resume = $analyse->optimized_resume_text ;
            $pdf = Pdf::loadHTML("
                <html> <head> <meta charset='UTF-8'> <style>
                    body {
                        font-family: DejaVu Sans, sans-serif;
                        font-size: 12px;
                        line-height: 1.6;
                        color: #222;
                        padding: 30px;
                        text-align: center;
                    }

                    pre {
                        display: inline-block;
                        text-align: left;
                        white-space: pre-wrap; /* important pour retour à la ligne */
                        word-wrap: break-word;
                    }
                </style></head>
                    <body> <pre>{$resume}</pre> </body>
                </html>
            ");
        }
        return $pdf->download("resume_{$analyse->id}.pdf");
    }

    public function downloadCoverLetter($id, Request $request){

        $this->analyseRepository->pushCriteria(new AnalyseOfUserCriteria($request->user()->id));
        if (is_numeric($id)) {
            $analyse = $this->analyseRepository->findWhere([
                'id' => $id
            ]) ->first();
        } else {
            if (Str::isUuid($id)) {
                $analyse = $this->analyseRepository->findWhere(['uuid'=> $id])->first();
            } else {
                return $this->sendError('Analyse not found');
            }
        }
        if (empty($analyse)) {
            return $this->sendError('Analyse not found');
        }

        $using_array = false ;
        if($using_array == true ){

            $pdf = Pdf::loadView('pdf.cover_letter', [
                'content' => $analyse->cover_letter
            ]);
        }else{
            $resume = $analyse->cover_letter ;
            $pdf = Pdf::loadHTML("
                <html> <head> <meta charset='UTF-8'> <style> body { font-family: DejaVu Sans, sans-serif; font-size: 12px; line-height: 1.6; color: #222; padding: 30px; } </style></head>
                    <body> <pre>{$resume}</pre> </body>
                </html>
            ");
        }

        return $pdf->download('cover_letter.pdf');
    }

}
