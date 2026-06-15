<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style>
*{box-sizing:border-box}

body{font-family:Arial,Helvetica,sans-serif;margin:0;padding:0;color:#0f172a;background:#fff}

.container{padding:45px 55px}

.resume{width:8.5in;min-height:11in;margin:0 auto;background:#fff;box-shadow:0 20px 60px rgba(15,23,42,.18);padding:48px 56px}

.header{border-bottom:2px solid #e2e8f0;padding-bottom:22px;margin-bottom:32px}

.name{font-size:34px;line-height:1.1;font-weight:900;letter-spacing:-1.2px;color:#0f172a}

.headline{font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;margin-top:6px;color:#334155}

.contact{font-size:12px;margin-top:10px;color:#64748b;line-height:1.4}

.section{margin-top:24px}

.section-title{font-size:12.5px;font-weight:900;text-transform:uppercase;letter-spacing:1.2px;margin-bottom:10px;color:#0f172a}

.section-content{font-size:12px;line-height:1.75;color:#334155}

.summary{font-size:12.5px;line-height:1.75;color:#334155}

.skills{display:flex;flex-wrap:wrap;gap:7px}

.skill{font-size:10.5px;font-weight:700;padding:5px 9px;border-radius:8px;line-height:1.2;white-space:nowrap;display:inline-flex;align-items:center}

.skill-badge{display:inline-block;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:5px 9px;font-size:10.5px;color:#0f172a;white-space:nowrap}

.job{margin-bottom:18px}

.job-head{display:flex;justify-content:space-between;gap:12px;align-items:flex-start}

.job-title{font-size:12.8px;font-weight:900;color:#0f172a;line-height:1.3}

.project-title{font-size:12.8px;font-weight:900;color:#0f172a;line-height:1.3}

.company{font-size:12px;font-weight:700;color:#475569;margin-top:2px}

.date{font-size:11px;font-weight:700;color:#64748b;white-space:nowrap}

.job-description{margin-top:6px;font-size:12px;line-height:1.75;color:#334155}

ul{margin:7px 0 0;padding-left:18px}

li{font-size:11.5px;line-height:1.65;margin-bottom:4px;color:#334155}

.project{margin-bottom:14px}

.project-meta{font-size:11px;color:#64748b;margin-top:3px}

.project-desc{font-size:11.8px;color:#334155;margin-top:6px;line-height:1.7}

.project-impact{font-size:11.5px;font-weight:700;color:#0f172a;margin-top:5px}

.project-tech{font-size:10.5px;color:#64748b;margin-top:5px}

.body-text{font-size:12px;line-height:1.75;color:#334155}

.footer{margin-top:40px;text-align:center;font-size:10px;color:#94a3b8}

/* THEMES */

.modern .headline{color:#06b6d4}

.modern .header{border-bottom:3px solid #e2e8f0;padding-bottom:20px}

.modern .section-title{border-left:4px solid #22D3EE;padding-left:10px;color:#07111F}

.modern .skill{background:#f8fafc;border:1px solid #e2e8f0;color:#0f172a}

.corporate{border-top:10px solid #0f172a}

.corporate .name{font-family:Georgia,serif;color:#0f172a}

.corporate .headline{color:#334155}

.corporate .header{border-bottom:1.5px solid #0f172a;padding-bottom:18px}

.corporate .section-title{color:#0f172a;border-bottom:1px solid #cbd5e1;padding-bottom:5px}

.corporate .skill{background:#f1f5f9;color:#0f172a;border:1px solid #cbd5e1}

.minimal{box-shadow:0 14px 36px rgba(15,23,42,.12)}

.minimal .name{font-size:31px;letter-spacing:-.8px}

.minimal .headline{color:#111827;letter-spacing:.8px}

.minimal .header{text-align:center;border-bottom:1px solid #e5e7eb;padding-bottom:20px}

.minimal .section-title{color:#111827;border-bottom:1px solid #e5e7eb;padding-bottom:5px}

.minimal .skill{background:#fff;border:1px solid #e5e7eb;color:#374151;border-radius:999px}

.tech{background:linear-gradient(90deg,#07111F 0 20px,#fff 20px)}

.tech .name{color:#07111F}

.tech .headline{color:#2563eb}

.tech .section-title{color:#2563eb;border-left:5px solid #2563eb;padding-left:10px}

.tech .skill{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}

.executive{border-top:12px solid #C8A96A}

.executive .name{font-family:Georgia,serif;color:#07111F}

.executive .headline{color:#C8A96A}

.executive .header{border-bottom:2px solid #C8A96A;padding-bottom:19px}

.executive .section-title{color:#07111F;border-bottom:1px solid #C8A96A;padding-bottom:5px}

.executive .skill{background:#fbf7ee;color:#713f12;border:1px solid #f1dfb8}

@media(max-width:900px){.resume{width:100%;padding:34px 26px}.job-head{display:block}.date{margin-top:3px}}
</style>
</head>

<body>
@php
$contacts = array_filter([
    $resume['contact']['location'] ?? null,
    $resume['contact']['phone'] ?? null,
    $resume['contact']['email'] ?? null,
    $resume['contact']['linkedin'] ?? null,
]);
@endphp
<div class="container resume modern " id="resume">

    <!-- HEADER -->

    <div class="header">
        <div class="name">  {{ $resume['full_name'] }} </div>
        <div class="headline"> {{ $resume['headline'] }}</div>
        @if(count($contacts))
        <div class="contact">{{ implode(' • ', $contacts) }}</div>
        @endif
    </div>

    <!-- SUMMARY -->

    @if(!empty($resume['professional_summary']))

    <div class="section">
        <div class="section-title"> Professional Summary</div>
        {{-- <div class="section-content"> {{ $resume['professional_summary'] }}</div> --}}
        <div class="summary"> {{ $resume['professional_summary'] }}</div>
    </div>

    @endif

    <!-- SKILLS -->

    @if(!empty($resume['skills']))
    <div class="section">
        <div class="section-title"> Core Skills </div>
        <div class="skills">
            @foreach(($resume['skills']['technical']?? []) as $skill)
                {{-- <span class="skill-badge"> {{ $skill }} </span> --}}
                <span class="skill"> {{ $skill }} </span>
            @endforeach
            @foreach(($resume['skills']['soft']?? []) as $skill)
                {{-- <span class="skill-badge"> {{ $skill }} </span> --}}
                <span class="skill"> {{ $skill }} </span>
            @endforeach
            @foreach(($resume['skills']['tools'] ?? []) as $skill)
                {{-- <span class="skill-badge"> {{ $skill }} </span> --}}
                <span class="skill"> {{ $skill }} </span>
            @endforeach
            @foreach(($resume['skills']['platforms'] ?? [] ) as $skill)
                {{-- <span class="skill-badge"> {{ $skill }} </span> --}}
                <span class="skill"> {{ $skill }} </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- EXPERIENCE -->

    @if(!empty($resume['professional_experience']))
    <div class="section">
        <div class="section-title">  Professional Experience </div>
        @foreach($resume['professional_experience'] as $experience)
        <div class="job">
            <div class="job-head">
                <div>
                    @if(!empty($experience['title']))<div class="job-title">{{ $experience['title'] }}</div>@endif
                    @if(!empty($experience['company'])) <div class="company">{{ $experience['company'] }}</div>@endif
                </div>
                @if(!empty($experience['title']))<div class="date">{{ $experience['dates'] }}</div> @else <div class="date"> Dates: Not specified</div>@endif
            </div>
            @if(count($experience["bullets"]))
            <ul>
            @foreach(($experience["bullets"] ) as $bullet)
                <li>{{ $bullet }}</li>
            @endforeach
            </ul>
            @endif

            @if(!empty($experience['descriptions'])) <div class="job-description"> {!! nl2br(e($experience['descriptions'])) !!} </div>@endif
        </div>
        @endforeach
    </div>
    @endif

    <!-- EDUCATION -->

    @if(!empty($resume['education']) || !empty($resume['certifications']))

        @if(!empty($resume['education']))
        <div class="section">
            <div class="section-title">Education</div>
            <div class="section-content">
                <ul>
                    @foreach($resume['education'] as $education)
                        <li><strong>{{$education["degree"]}}</strong><br> {{$education["institution"]}} </li>
                    @endforeach
                </ul>
            </div>


        </div>
        @endif
        <!-- CERTIFICATIONS -->
        @if(!empty($resume['certifications']))
        <div class="section">
            <div class="section-title">Certifications</div>
            <div class="section-content">
                <ul>
                    @foreach($resume['certifications'] as $certification)
                        <li><strong>{{$certification["name"] ?? null}}</strong><br> {{$certification["issuer"]?? null}} {{$certification["date"]?? null }}  {{$certification["expiration"] ?? null}}</li>
                    @endforeach
                </ul>
            </div>

        </div>
        @endif

    @endif


    <!-- PROJECTS -->

    @if(!empty($resume['projects']))
    <div class="section">
        <div class="section-title">Projects </div>

        @foreach($resume['projects'] as $project)

            <div class="project">
                <div class="project-title">{{ $project["name"] ?? null }}</div>

                @if(!empty($project["role"])) <div class="project-meta"> Role: {{ $project["role"] ?? null }}</div>@endif
                @if(!empty($project["description"]))  <div class="project-desc">{{$project["description"]}}</div> @endif
                @if(!empty($project["impact"]))
                <div class="project-impact">Impact: {{ $project["impact"]}}</div>
                @endif
                @if(!empty($project["technologies"]))
                <div class="project-tech">
                    Technologies: @foreach($project["technologies"] as $tech) <span class="skill"> {{ $tech}} </span>@endforeach
                </div>
                @endif
            </div>

        @endforeach

    </div>
    @endif

    <!-- LANGUAGES -->

    @if(!empty($resume['languages']))

    <div class="section">
        <div class="section-title"> Languages </div>

        <div class="body-text">
            @foreach($resume['languages'] as $language)
                {{ $language ['language']}} — {{ $language ['level']}}<br>
            @endforeach
        </div>
    </div>

    @endif

    @if(!empty($resume["additional_sections"]))
    <!-- ADDITIONAL -->
    <div class="section">
        <div class="section-title">Additional Information</div>
        <div class="body-text">
        {{$resume["additional_sections"]}}
        </div>
    </div>
    @endif
    <!-- FOOTER -->

    <div class="footer">
        Generated by CVMatch AI
    </div>

</div>

</body>
</html>
