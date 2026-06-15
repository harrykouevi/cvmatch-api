{{-- ============================================================
   Executive Elite US ATS Resume Template
   Fortune 500 Style | DomPDF Friendly | Single Column
============================================================= --}}



<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="UTF-8">

<style>

*{
    box-sizing:border-box;
}

body{
    margin:0;
    padding:0;
    background:#fff;
    color:#0f172a;
    font-family:Arial, Helvetica, sans-serif;
    font-size:11px;
}

.resume{
    width:100%;
    padding:48px 54px;
}

.header{
    border-top:8px solid #c8a96a;
    border-bottom:2px solid #c8a96a;
    padding-bottom:18px;
    margin-bottom:24px;
}

.name{
    font-size:34px;
    font-weight:900;
    letter-spacing:-1px;
    line-height:1;
}

.headline{
    margin-top:8px;
    color:#64748b;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:1px;
}

.contact{
    margin-top:14px;
    color:#64748b;
    font-size:10.5px;
}

.section{
    margin-top:22px;
    page-break-inside:avoid;
}

.section-title{
    font-size:11px;
    font-weight:900;
    letter-spacing:1.8px;
    text-transform:uppercase;
    color:#0f172a;
    border-bottom:1px solid #c8a96a;
    padding-bottom:5px;
    margin-bottom:12px;
}

.summary{
    line-height:1.8;
    color:#334155;
}

.group{
    margin-bottom:12px;
}

.group-title{
    font-size:11px;
    font-weight:800;
    margin-bottom:5px;
}

.inline-list{
    line-height:1.8;
    color:#475569;
}

.item-tag{
    display:inline-block;
    padding:4px 8px;
    margin-right:5px;
    margin-bottom:5px;
    border:1px solid #e2e8f0;
    background:#f8fafc;
    border-radius:4px;
    font-size:10px;
    color:#475569;
}

.entry{
    margin-bottom:18px;
    page-break-inside:avoid;
}

.entry-header{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
}

.entry-title{
    font-size:12px;
    font-weight:900;
}

.entry-subtitle{
    margin-top:3px;
    color:#64748b;
    font-weight:700;
}

.entry-date{
    color:#64748b;
    font-weight:700;
    text-align:right;
}

.entry-meta{
    margin-top:2px;
    color:#94a3b8;
}

ul{
    margin:8px 0 0;
    padding-left:18px;
}

li{
    line-height:1.7;
    margin-bottom:3px;
    color:#334155;
}

.project-impact{
    margin-top:5px;
    font-weight:700;
}

.page-break{
    page-break-before:always;
}

</style>

</head>
<body>

@php

$contacts = array_filter([
$resume['contact']['location'] ?? null,
$resume['contact']['phone'] ?? null,
$resume['contact']['email'] ?? null,
$resume['contact']['linkedin'] ?? null,
$resume['contact']['portfolio'] ?? null,
]);

@endphp

<div class="resume">


{{-- HEADER --}}
<div class="header">

    @if(!empty($resume['full_name']))
        <div class="name">{{ $resume['full_name'] }}</div>
    @endif

    @if(!empty($resume['headline']))
        <div class="headline">{{ $resume['headline'] }}</div>
    @endif

    @if(count($contacts))
        <div class="contact">
            {{ implode(' • ', $contacts) }}
        </div>
    @endif

</div>



{{-- PROFESSIONAL SUMMARY --}}
@if(!empty($resume['professional_summary']))
<div class="section">

    <div class="section-title">
        Professional Summary
    </div>

    <div class="summary">
        {{ $resume['professional_summary'] }}
    </div>

</div>
@endif



{{-- SKILLS --}}
@if(!empty($resume['skills']))
<div class="section">

    <div class="section-title">
        Skills
    </div>

    @foreach($resume['skills'] as $groupName => $items)

        @if(!empty($items))

        <div class="group">

            <div class="group-title">
                {{ ucwords(str_replace('_',' ', $groupName)) }}
            </div>

            <div class="inline-list">

                @foreach($items as $item)

                    {{ $item }}

                    @if(!$loop->last)
                        •
                    @endif

                @endforeach

            </div>

        </div>

        @endif

    @endforeach

</div>
@endif




{{-- EXPERIENCE --}}
@if(!empty($resume['professional_experience']))
<div class="section">

    <div class="section-title">
        Professional Experience
    </div>

    @foreach($resume['professional_experience'] as $experience)

    <div class="entry">

        <div class="entry-header">

            <div>

                @if(!empty($experience['title']))
                    <div class="entry-title">
                        {{ $experience['title'] }}
                    </div>
                @endif

                @if(!empty($experience['company']))
                    <div class="entry-subtitle">
                        {{ $experience['company'] }}
                    </div>
                @endif

                @if(!empty($experience['location']))
                    <div class="entry-meta">
                        {{ $experience['location'] }}
                    </div>
                @endif

            </div>

            @if(!empty($experience['dates']))
            <div class="entry-date">
                {{ $experience['dates'] }}
            </div>
            @endif

        </div>


        @foreach(['description'] as $field)

            @if(!empty($experience[$field]))

                <div class="summary" style="margin-top:8px;">
                    {{ $experience[$field] }}
                </div>

            @endif

        @endforeach


        @foreach(['achievements','bullets'] as $list)

            @if(!empty($experience[$list]))

            <ul>

                @foreach($experience[$list] as $item)

                    <li>
                        {{ $item }}
                    </li>

                @endforeach

            </ul>

            @endif

        @endforeach

    </div>

    @endforeach

</div>
@endif




{{-- PROJECTS --}}
@if(!empty($resume['projects']))
<div class="section">

    <div class="section-title">
        Projects
    </div>

    @foreach($resume['projects'] as $project)

    <div class="entry">

        @if(!empty($project['name']))
        <div class="entry-title">
            {{ $project['name'] }}
        </div>
        @endif

        @if(!empty($project['role']))
        <div class="entry-subtitle">
            {{ $project['role'] }}
        </div>
        @endif

        @foreach(['description'] as $field)

            @if(!empty($project[$field]))

            <div class="summary" style="margin-top:7px;">
                {{ $project[$field] }}
            </div>

            @endif

        @endforeach

        @if(!empty($project['impact']))
        <div class="project-impact">
            {{ $project['impact'] }}
        </div>
        @endif

        @if(!empty($project['technologies']))
        <div style="margin-top:8px;">

            @foreach($project['technologies'] as $technology)

                <span class="item-tag">
                    {{ $technology }}
                </span>

            @endforeach

        </div>
        @endif

    </div>

    @endforeach

</div>
@endif




{{-- EDUCATION --}}
@if(!empty($resume['education']))
<div class="section">

    <div class="section-title">
        Education
    </div>

    @foreach($resume['education'] as $education)

    <div class="entry">

        @if(!empty($education['degree']))
        <div class="entry-title">
            {{ $education['degree'] }}
        </div>
        @endif

        @if(!empty($education['institution']))
        <div class="entry-subtitle">
            {{ $education['institution'] }}
        </div>
        @endif

        @if(!empty($education['location']) || !empty($education['dates']))
        <div class="entry-meta">

            {{ implode(' • ', array_filter([
                $education['location'] ?? null,
                $education['dates'] ?? null
            ])) }}

        </div>
        @endif

        @if(!empty($education['details']))
        <div class="summary" style="margin-top:8px;">
            {{ $education['details'] }}
        </div>
        @endif

    </div>

    @endforeach

</div>
@endif




{{-- CERTIFICATIONS --}}
@if(!empty($resume['certifications']))
<div class="section">

    <div class="section-title">
        Certifications
    </div>

    @foreach($resume['certifications'] as $certification)

    <div class="entry">

        <div class="entry-title">

            {{ implode(' — ', array_filter([
                $certification['name'] ?? null,
                $certification['issuer'] ?? null
            ])) }}

        </div>

        @if(!empty($certification['date']) || !empty($certification['expiration']))
        <div class="entry-meta">

            {{ implode(' • ', array_filter([
                $certification['date'] ?? null,
                $certification['expiration'] ?? null
            ])) }}

        </div>
        @endif

    </div>

    @endforeach

</div>
@endif




{{-- LANGUAGES --}}
@if(!empty($resume['languages']))
<div class="section">

    <div class="section-title">
        Languages
    </div>

    <div class="summary">

        @foreach($resume['languages'] as $language)

            {{ implode(' — ', array_filter([
                $language['language'] ?? null,
                $language['level'] ?? null
            ])) }}

            @if(!$loop->last)
                <br>
            @endif

        @endforeach

    </div>

</div>
@endif




{{-- ADDITIONAL --}}
@if(!empty($resume['additional_sections']))
<div class="section">

    <div class="section-title">
        Additional Information
    </div>

    <div class="summary">
        {{ $resume['additional_sections'] }}
    </div>

</div>
@endif


</div>



</body>
</html>
