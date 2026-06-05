<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">

<style>
*{box-sizing:border-box}
body{
    /* font-family: DejaVu Sans, sans-serif; */
    font-family:Arial,Helvetica,sans-serif;
    margin:0;
    padding:0;
    color:#0f172a;
    background:#ffffff;
    /* background:#eef2f7 */
}


.container{
    padding:45px 55px;
}

.header{border-bottom:2px solid #e2e8f0;padding-bottom:22px;margin-bottom:32px;}
.resume{width:8.5in;min-height:11in;margin:0 auto;background:white;box-shadow:0 20px 60px rgba(15,23,42,.18);padding:48px 56px}
.name{font-size:34px;line-height:1.05;font-weight:900;letter-spacing:-1.2px}
/* .name{font-size:32px;font-weight:700;color:#07111F;line-height:1.1;} */
.headline{font-size:13px;font-weight:900;text-transform:uppercase;letter-spacing:1.2px;margin-top:7px}
/* .headline{margin-top:8px;font-size:13px;text-transform:uppercase;letter-spacing:1px;color:#22D3EE;font-weight:700;} */
.contact{font-size:12px;margin-top:10px;color:#64748b}
.section{margin-top:24px}
/* .section{ margin-bottom:30px;} */
.section-content{font-size:12px;line-height:1.8;color:#334155;}
.section-title{font-size:13px;font-weight:900;text-transform:uppercase;letter-spacing:1.3px;margin-bottom:10px}
/* .section-title{font-size:14px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:#07111F;border-left:4px solid #22D3EE;padding-left:10px;margin-bottom:14px;} */
.summary,.body-text{font-size:12px;line-height:1.72;color:#334155}
/* .skills{ margin-top:10px;} */
.skills{display:flex;flex-wrap:wrap;gap:7px}
.skill{font-size:10.5px;font-weight:800; gap:12px ; padding:5px 5px;border-radius:8px ; line-height:2.65 ;  white-space: nowrap;}
.skill-badge{display:inline-block;background:#f8fafc;border:1px solid #e2e8f0;border-radius:8px;padding:6px 10px;margin-right:6px;margin-bottom:8px;font-size:11px;color:#0f172a;}

.job{margin-bottom:17px}
/* .job{ margin-bottom:22px; } */
.job-description{margin-top:6px;font-size:12px;line-height:1.8;color:#334155;}
.job-head{display:flex;justify-content:space-between;gap:12px;align-items:flex-start}
.job-title{font-size:12.5px;font-weight:900;color:#0f172a}
/* .job-title{ font-size:13px; font-weight:700; color:#07111F;} */
.company{font-size:12px;font-weight:800;color:#475569;margin-top:2px}
.date{font-size:11px;font-weight:800;color:#64748b;white-space:nowrap}
ul{margin:7px 0 0;padding-left:18px}
li{font-size:11.5px;line-height:1.65;margin-bottom:4px;color:#334155}
/* PROJECTS */
.project{margin-bottom:14px}
.project-title{font-size:12.5px;font-weight:900 ; color:#0f172a}
.project-meta{font-size:11px;color:#64748b;margin-top:3px}
.project-desc{font-size:11.5px;color:#334155;margin-top:6px;line-height:1.6}
.project-impact{font-size:11.5px;color:#0f172a;font-weight:700;margin-top:5px}
.project-tech{font-size:10.5px;color:#64748b;margin-top:5px}

.footer{
    margin-top:40px;
    text-align:center;
    font-size:10px;
    color:#94a3b8;
}
.modern .headline{color:#06b6d4}.modern .header{border-bottom:3px solid #e2e8f0;padding-bottom:20px}.modern .section-title{border-left:4px solid #22D3EE;padding-left:10px;color:#07111F}.modern .skill{background:#f8fafc;border:1px solid #e2e8f0;color:#0f172a}
.corporate{border-top:10px solid #0f172a}.corporate .name{font-family:Georgia,serif;color:#0f172a}.corporate .headline{color:#334155}.corporate .header{border-bottom:1.5px solid #0f172a;padding-bottom:18px}.corporate .section-title{color:#0f172a;border-bottom:1px solid #cbd5e1;padding-bottom:5px}.corporate .skill{background:#f1f5f9;color:#0f172a;border:1px solid #cbd5e1}
.minimal{box-shadow:0 14px 36px rgba(15,23,42,.12)}.minimal .name{font-size:31px;letter-spacing:-.8px}.minimal .headline{color:#111827;letter-spacing:.8px}.minimal .header{text-align:center;border-bottom:1px solid #e5e7eb;padding-bottom:20px}.minimal .section-title{color:#111827;border-bottom:1px solid #e5e7eb;padding-bottom:5px}.minimal .skill{background:white;border:1px solid #e5e7eb;color:#374151;border-radius:999px}
.tech{background:linear-gradient(90deg,#07111F 0 20px,#fff 20px)}.tech .name{color:#07111F}.tech .headline{color:#2563eb}.tech .header{padding-left:10px;border-bottom:2px solid #dbeafe;padding-bottom:18px}.tech .section-title{color:#2563eb;border-left:5px solid #2563eb;padding-left:10px}.tech .skill{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
.executive{border-top:12px solid #C8A96A}.executive .name{font-family:Georgia,serif;color:#07111F}.executive .headline{color:#C8A96A}.executive .header{border-bottom:2px solid #C8A96A;padding-bottom:19px}.executive .section-title{color:#07111F;border-bottom:1px solid #C8A96A;padding-bottom:5px}.executive .skill{background:#fbf7ee;color:#713f12;border:1px solid #f1dfb8}
@media(max-width:900px){.resume{width:100%;padding:34px 26px}.job-head{display:block}.date{margin-top:3px}.grid2{grid-template-columns:1fr}} */

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

                @foreach($resume['education'] as $education)
                <div class="body-text">
                    <strong>{{$education["degree"]}}</strong><br> {{$education["institution"]}}
                </div>

                @endforeach
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
            <div class="body-text">
                @foreach($resume['certifications'] as $certification)
                <strong>{{$certification["name"]?? null}}</strong><br> {{$certification["issuer"]?? null}} {{$certification["date"]?? null }}  {{$certification["expiration"] ?? null}}
                @endforeach
            </div>
        </div>
        @endif

    @endif


    <!-- PROJECTS -->

    @if(!empty($resume['projects']))
    <div class="section">
        <div class="section-title">Projects </div>

        @foreach($resume['projects'] as $project)
            <li>{{ $project["name"] ?? null }}</li>
            <div class="body-text">
                <div class="project-title">{{ $project["name"] ?? null }}</div>
                <div class="project-desc">
                    {{ $project["description"] ?? null }}
                </div>
            </div>
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
        <div class="section-content">
            @foreach($resume['languages'] as $language)
                <span class="skill-badge"> {{ $language ['language']}}</span> -
            @endforeach
        </div>
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
