<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>{{ $resume['full_name'] ?? 'Resume' }}</title>
<style>
/* ============================================================
   RESET & BASE
   ============================================================ */
*  { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    line-height: 1.6;
    color: #334155;
    background: #fff;
}

.resume {
    width: 8.5in;
    min-height: 11in;
    margin: 0 auto;
    background: #fff;
    box-shadow: 0 20px 60px rgba(15,23,42,.18);
}

/* ── HEADER ── */
.header {
    position: relative;
    padding: 30px 52px 22px;
}

.header-accent-bar {
    position: absolute;
    left: 0; top: 0; bottom: 0;
    width: 5px;
}

.name {
    font-size: 32px;
    font-weight: 900;
    letter-spacing: -1px;
    line-height: 1.1;
}

.headline {
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    margin-top: 5px;
}

/* ── CONTACT BAR ── */
.contact-bar {
    padding: 8px 52px;
    font-size: 10.5px;
    line-height: 1.4;
}

.contact-sep { margin: 0 7px; }

/* ── BODY ── */
.body { padding: 0 52px 36px; }

/* ── SECTION ── */
.section { margin-top: 22px; }

.section-title {
    font-size: 10px;
    font-weight: 900;
    text-transform: uppercase;
    letter-spacing: 1.4px;
    padding-bottom: 4px;
    margin-bottom: 10px;
}

/* ── SUMMARY ── */
.summary-text {
    font-size: 11.5px;
    line-height: 1.75;
    padding: 10px 14px;
}

/* ── SKILLS ── */
.skills { display: flex; flex-wrap: wrap; gap: 6px; }

.skill {
    display: inline-flex;
    align-items: center;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 10px;
    line-height: 1.3;
    white-space: nowrap;
}

/* ── EXPERIENCE ── */
.job { margin-bottom: 18px; padding-bottom: 16px; border-bottom: 0.5px solid #e5e7eb; }
.job:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }

.job-head {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
}

.job-title   { font-size: 12.5px; font-weight: 900; line-height: 1.3; }
.company     { font-size: 11.5px; font-weight: 700; margin-top: 1px; }
.exp-location{ font-size: 10.5px; color: #94a3b8; font-style: italic; margin-top: 1px; }
.date        { font-size: 10.5px; font-weight: 700; white-space: nowrap; }

.job-description { font-size: 11px; color: #475569; line-height: 1.65; margin-top: 5px; }

.bullet-list { margin: 6px 0 0; padding-left: 0; list-style: none; }

.bullet-list li {
    font-size: 11px;
    line-height: 1.6;
    margin-bottom: 3px;
    color: #334155;
    padding-left: 16px;
    position: relative;
}

.bullet-list li::before {
    content: "▸";
    position: absolute;
    left: 0;
    top: 1px;
    font-size: 8px;
}

.tech-tags { margin-top: 6px; font-size: 10px; color: #94a3b8; }
.tech-tag   { display: inline; }
.tech-tag:not(:last-child)::after { content: " · "; color: #d1d5db; }

/* ── EDUCATION ── */
.edu-entry   { margin-bottom: 10px; }
.edu-degree  { font-size: 11.5px; font-weight: 900; }
.edu-inst    { font-size: 11px; margin-top: 1px; color: #475569; }
.edu-meta    { font-size: 10px; color: #9ca3af; margin-top: 1px; }
.edu-details { font-size: 10.5px; color: #64748b; margin-top: 2px; }

/* ── CERTIFICATIONS ── */
.cert-entry  { margin-bottom: 8px; padding-left: 8px; }
.cert-name   { font-size: 11.5px; font-weight: 900; }
.cert-issuer { font-size: 10.5px; color: #64748b; }
.cert-date   { font-size: 10px; color: #9ca3af; }

/* ── PROJECTS ── */
.project        { margin-bottom: 12px; padding-left: 10px; }
.project-name   { font-size: 12px; font-weight: 900; }
.project-role   { font-size: 10.5px; font-weight: 600; color: #64748b; margin-top: 1px; }
.project-desc   { font-size: 11px; color: #475569; line-height: 1.65; margin-top: 3px; }
.project-impact { font-size: 10.5px; font-weight: 700; color: #059669; margin-top: 3px; }
.project-tech   { margin-top: 5px; display: flex; flex-wrap: wrap; gap: 4px; }
.project-tech-tag {
    font-size: 9.5px;
    font-weight: 600;
    padding: 2px 7px;
    border-radius: 5px;
}

/* ── LANGUAGES ── */
.lang-entry {
    display: flex;
    justify-content: space-between;
    font-size: 11.5px;
    margin-bottom: 4px;
}
.lang-name  { font-weight: 600; }
.lang-level { font-weight: 700; }

/* ── FOOTER ── */
.footer {
    padding: 10px 52px;
    text-align: center;
    font-size: 9px;
    color: #9ca3af;
    letter-spacing: 0.4px;
}

/* ============================================================
   THEMES
   ============================================================ */

/* ── MODERN ── */
.modern .header           { background: #0f172a; }
.modern .header-accent-bar{ background: #22d3ee; }
.modern .name             { color: #ffffff; }
.modern .headline         { color: #22d3ee; }
.modern .contact-bar      { background: #1e3a5f; color: #bfdbfe; }
.modern .contact-sep      { color: #22d3ee; }
.modern .section-title    { color: #22d3ee; border-left: 4px solid #22d3ee; padding-left: 10px; }
.modern .summary-text     { background: #f0f9ff; border-left: 3px solid #22d3ee; color: #334155; }
.modern .skill            { background: #f0f9ff; border: 1px solid #bae6fd; color: #0369a1; border-radius: 7px; }
.modern .job-title        { color: #0f172a; }
.modern .company          { color: #0ea5e9; }
.modern .date             { color: #64748b; }
.modern .bullet-list li::before { color: #22d3ee; }
.modern .cert-entry       { border-left: 2px solid #22d3ee; }
.modern .cert-name        { color: #0f172a; }
.modern .project          { border-left: 2px solid #22d3ee; }
.modern .project-name     { color: #0f172a; }
.modern .project-tech-tag { background: #f0f9ff; border: 1px solid #bae6fd; color: #0369a1; }
.modern .lang-level       { color: #0ea5e9; }
.modern .footer           { background: #f0f9ff; border-top: 1px solid #bae6fd; }

/* ── CORPORATE ── */
.corporate                { border-top: 10px solid #0f172a; }
.corporate .header        { background: #0f172a; }
.corporate .name          { color: #ffffff; font-family: Georgia, serif; }
.corporate .headline      { color: #94a3b8; }
.corporate .contact-bar   { background: #1e293b; color: #94a3b8; }
.corporate .contact-sep   { color: #475569; }
.corporate .section-title { color: #0f172a; border-bottom: 1.5px solid #0f172a; }
.corporate .summary-text  { background: #f8fafc; border-left: 3px solid #94a3b8; color: #1e293b; }
.corporate .skill         { background: #f1f5f9; border: 1px solid #cbd5e1; color: #0f172a; border-radius: 7px; }
.corporate .job-title     { color: #0f172a; }
.corporate .company       { color: #475569; }
.corporate .date          { color: #64748b; }
.corporate .bullet-list li::before { color: #475569; }
.corporate .cert-entry    { border-left: 2px solid #0f172a; }
.corporate .cert-name     { color: #0f172a; }
.corporate .project       { border-left: 2px solid #cbd5e1; }
.corporate .project-name  { color: #0f172a; }
.corporate .project-tech-tag { background: #f1f5f9; border: 1px solid #cbd5e1; color: #0f172a; }
.corporate .lang-level    { color: #334155; }
.corporate .footer        { background: #f1f5f9; border-top: 1px solid #cbd5e1; }

/* ── MINIMAL ── */
.minimal .header          { background: #fff; border-bottom: 2px solid #111827; text-align: center; padding-top: 32px; }
.minimal .name            { color: #111827; font-size: 29px; letter-spacing: -0.5px; }
.minimal .headline        { color: #6b7280; }
.minimal .contact-bar     { background: #f9fafb; color: #6b7280; border-bottom: 1px solid #e5e7eb; text-align: center; }
.minimal .contact-sep     { color: #d1d5db; }
.minimal .section-title   { color: #111827; border-bottom: 1px solid #e5e7eb; }
.minimal .summary-text    { background: transparent; color: #374151; font-style: italic; padding: 0; }
.minimal .skill           { background: #fff; border: 1px solid #e5e7eb; color: #374151; border-radius: 999px; }
.minimal .job-title       { color: #111827; }
.minimal .company         { color: #374151; }
.minimal .date            { color: #9ca3af; font-weight: 400; }
.minimal .bullet-list li::before { color: #9ca3af; }
.minimal .cert-entry      { border-left: 2px solid #e5e7eb; }
.minimal .cert-name       { color: #111827; }
.minimal .project         { border-left: 2px solid #e5e7eb; }
.minimal .project-name    { color: #111827; }
.minimal .project-tech-tag{ background: #fff; border: 1px solid #e5e7eb; color: #374151; }
.minimal .lang-level      { color: #374151; }
.minimal .footer          { background: #f9fafb; border-top: 1px solid #e5e7eb; }

/* ── TECH ── */
.tech .header             { background: #1e40af; }
.tech .header-accent-bar  { background: #60a5fa; }
.tech .name               { color: #ffffff; }
.tech .headline           { color: #93c5fd; }
.tech .contact-bar        { background: #1d4ed8; color: #bfdbfe; }
.tech .contact-sep        { color: #60a5fa; }
.tech .section-title      { color: #1d4ed8; border-left: 5px solid #2563eb; padding-left: 10px; }
.tech .summary-text       { background: #eff6ff; border-left: 3px solid #3b82f6; color: #1e3a5f; }
.tech .skill              { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; border-radius: 7px; }
.tech .job-title          { color: #1e3a5f; }
.tech .company            { color: #2563eb; }
.tech .date               { color: #64748b; }
.tech .bullet-list li::before { color: #3b82f6; }
.tech .cert-entry         { border-left: 2px solid #3b82f6; }
.tech .cert-name          { color: #1e3a5f; }
.tech .project            { border-left: 2px solid #3b82f6; }
.tech .project-name       { color: #1e3a5f; }
.tech .project-tech-tag   { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; }
.tech .lang-level         { color: #2563eb; }
.tech .footer             { background: #eff6ff; border-top: 1px solid #bfdbfe; }

/* ── EXECUTIVE ── */
.executive                { border-top: 10px solid #c9a84c; }
.executive .header        { background: #fff; border-bottom: 2px solid #c9a84c; }
.executive .name          { color: #0a0a0a; font-family: Georgia, serif; }
.executive .headline      { color: #c9a84c; }
.executive .contact-bar   { background: #fafaf7; color: #78716c; border-bottom: 1px solid #e7d9b0; }
.executive .contact-sep   { color: #c9a84c; }
.executive .section-title { color: #0a0a0a; border-bottom: 1.5px solid #c9a84c; }
.executive .summary-text  { background: #fafaf7; border-left: 3px solid #c9a84c; color: #1c1917; }
.executive .skill         { background: #fbf7ee; border: 1px solid #e7d9b0; color: #713f12; border-radius: 7px; }
.executive .job-title     { color: #0a0a0a; font-family: Georgia, serif; }
.executive .company       { color: #92400e; }
.executive .date          { color: #78716c; font-weight: 400; }
.executive .bullet-list li::before { color: #c9a84c; }
.executive .cert-entry    { border-left: 2px solid #c9a84c; }
.executive .cert-name     { color: #0a0a0a; }
.executive .project       { border-left: 2px solid #c9a84c; }
.executive .project-name  { color: #0a0a0a; font-family: Georgia, serif; }
.executive .project-tech-tag { background: #fbf7ee; border: 1px solid #e7d9b0; color: #713f12; }
.executive .lang-level    { color: #92400e; }
.executive .footer        { background: #fdf8ee; border-top: 1px solid #e7d9b0; }


/* ── ACADEMIC ── */
.academic                { border-top: 10px solid #c9a84c; }
.academic .header        { background: #ffffff; border-bottom: 2px solid #4338ca; }
.academic .name          { color: #1e1b4b; font-family: Georgia, serif; }
.academic .headline      { color: #4338ca; }
.academic .contact-bar   { background: #fafaf7; color: #78716c; border-bottom: 1px solid #e7d9b0; }
.academic .contact-sep   { color: #818cf8; }
.academic .section-title { color: #4338ca; border-bottom: 1.5px solid #818cf8; }
.academic .summary-text  { background: #eef2ff; border-left: 3px solid #4338ca; color: #1e1b4b; }
.academic .skill         { background: #fbf7ee; border: 1px solid #e7d9b0; color: #713f12; border-radius: 7px; }
.academic .job-title     { color: #0a0a0a; font-family: Georgia, serif; }
.academic .company       { color: #92400e; }
.academic .date          { color: #78716c; font-weight: 400; }
.academic .bullet-list li::before { color: #c9a84c; }
.academic .cert-entry    { border-left: 2px solid #818cf8; }
.academic .cert-name     { color: #0a0a0a; }
.academic .project       { border-left: 2px solid #c9a84c; }
.academic .project-name  { color: #0a0a0a; font-family: Georgia, serif; }
.academic .project-tech-tag { background: #fbf7ee; border: 1px solid #e7d9b0; color: #713f12; }
.academic .lang-level    { color: #92400e; }

.metrics-grid { display: table; width: 100%; margin-bottom: 10pt; }
.metric-item {display: table-cell; text-align: center; padding: 5pt 4pt; border-right: 0.5pt solid #e5e7eb;}
.metric-item:last-child { border-right: none; }
.metric-value { font-size: 11pt; font-weight: 700; color: #111827; display: block; }
.metric-label { font-size: 7pt; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5pt;display: block; }


.academic .footer        { background: #ffffff; border-top: 1px solid #e7d9b0; }

@media print {
    .resume { box-shadow: none; width: 100%; }
}

@media (max-width: 900px) {
    .resume { width: 100%; }
    .header, .contact-bar, .body, .footer { padding-left: 24px; padding-right: 24px; }
    .job-head { flex-direction: column; }
    .date { margin-top: 3px; }
}
</style>
</head>
<body>
@php

/* ============================================================
   HELPERS
   ============================================================ */

/**
 * Trouve une section par sa clé dans $resume['sections']
 */
function findSection(array $sections, string $key): ?array {
    foreach ($sections as $section) {
        if (($section['section_key'] ?? null) === $key) {
            return $section;
        }
    }
    return null;
}

/**
 * Formate un objet dates {start, end} en string lisible
 */
function formatDates(?array $dates): string {
    if (empty($dates)) return '';
    $start = $dates['start'] ?? '';
    $end   = $dates['end']   ?? 'Present';
    return $start ? "{$start} – {$end}" : $end;
}

/**
 * Explose les bullets pipe-séparés et filtre les vides
 */
function parseBullets(?string $raw): array {
    if (empty($raw)) return [];
    return array_filter(array_map('trim', explode('|', $raw)));
}

$validThemes = ['modern', 'corporate', 'minimal', 'tech', 'executive','academic'];

/* ============================================================
   THÈME — priorité : $theme injecté > schema_type > 'modern'
   ============================================================ */
$themeKey =  strtolower( $theme ?? $resume['schema_type'] ?? 'modern');
if (!in_array($themeKey, $validThemes)) {
//     // Auto-detect from headline
//     $headline = strtolower($resume['headline'] ?? '');
//     if (preg_match('/cfo|ceo|vp |chief|managing director|partner|principal|c-suite|svp|evp/i', $headline)) {
//     $themeKey = 'executive';
//     } elseif (preg_match('/attorney|counsel|associate|law|legal|compliance|regulatory/i', $headline)) {
//     $themeKey = 'legal';
//     } elseif (preg_match('/physician|md |doctor|nurse|clinical|healthcare|pharma|rn |pa |np /i', $headline)) {
//     $themeKey = 'healthcare';
    // } else
    if (preg_match('/research|phd|professor|postdoc|faculty|academic|scientist/i', $headline)) {
    $themeKey = 'academic';
    }
//      elseif
//     (preg_match('/finance|banking|equity|analyst|portfolio|investment|fund|quant|trader/i', $headline)) {
//     $themeKey = 'finance';
//     } else {
//     $themeKey = 'tech';
//     }
}

if (!in_array($themeKey, $validThemes)) {
    $themeKey = 'modern';
}

/* ============================================================
ADAPTIVE SKILL LABELS
Maps generic keys → profession-appropriate display labels
============================================================ */
$skillLabelMap = [
    'tech' => [
        'languages' => 'Core Technologies',
        'cloud_infra' => 'Infrastructure',
        'data' => 'Backend Systems',
        'practices' => 'Engineering Practices',
        'frontend' => 'Frontend',
        'tools' => 'Tooling',
    ],
    'finance' => [
        'languages' => 'Financial Modeling',
        'cloud_infra' => 'Systems & Platforms',
        'data' => 'Analytics & Data',
        'practices' => 'Methodologies',
        'tools' => 'Tools & Software',
    ],
    'executive' => [
        'languages' => 'Core Competencies',
        'cloud_infra' => 'Platforms & Tools',
        'data' => 'Analytics',
        'practices' => 'Leadership Approach',
        'tools' => 'Tools',
    ],
    'healthcare' => [
        'languages' => 'Clinical Specialties',
        'cloud_infra' => 'Systems & Platforms',
        'data' => 'Procedures & Protocols',
        'practices' => 'Care Competencies',
        'tools' => 'Certifications in Use',
    ],
    'legal' => [
        'languages' => 'Practice Areas',
        'cloud_infra' => 'Jurisdictions',
        'data' => 'Legal Research',
        'practices' => 'Methodologies',
        'tools' => 'Legal Tech',
    ],
    'academic' => [
        'languages' => 'Research Areas',
        'cloud_infra' => 'Methodologies',
        'data' => 'Technical Skills',
        'practices' => 'Teaching & Service',
        'tools' => 'Software & Tools',
    ],
];
$activeSkillLabels = $skillLabelMap[$profileKey] ?? $skillLabelMap['tech'];

/* ============================================================
   EXTRACTION DES SECTIONS (structure template 2)
   ============================================================ */
$sections = $resume['sections'] ?? [];

$contactData = findSection($sections, 'contact')['data'] ?? [];
$summaryData = findSection($sections, 'professional_summary')['data'] ?? [];
$skillsData  = findSection($sections, 'skills')['data'] ?? [];
$experience  = findSection($sections, 'professional_experience')['data'] ?? [];
$education   = findSection($sections, 'education')['data'] ?? [];
$certifs     = findSection($sections, 'certifications')['data'] ?? [];
$projects    = findSection($sections, 'projects')['data'] ?? [];
$languages   = findSection($sections, 'languages')['data'] ?? [];
$technical_competencies = findSection($sections, 'technical_competencies')['data'] ?? [];
$bar_admissions = findSection($sections, 'bar_admissions')['data'] ?? [];
$publications = findSection($sections, 'publications')['data'] ?? [];
$awards = findSection($sections, 'awards')['data'] ?? [];
$affiliations = findSection($sections, 'affiliations')['data'] ?? [];
$clinical_skills = findSection($sections, 'clinical_skills')['data'] ?? [];
$thought_leadership = findSection($sections, 'thought_leadership')['data'] ?? [];
$portfolio_highlights = findSection($sections, 'portfolio_highlights')['data'] ?? [];
$open_source_contributions = findSection($sections, 'open_source_contributions')['data'] ?? [];
$tools_expertise = findSection($sections, 'tools_expertise')['data'] ?? [];
$conference_presentations = findSection($sections, 'conference_presentations')['data'] ?? [];
$teaching_experience = findSection($sections, 'teaching_experience')['data'] ?? [];
$campaigns_highlights = findSection($sections, 'campaigns_highlights')['data'] ?? [];
$pro_bono = findSection($sections, 'pro_bono')['data'] ?? [];
$grants_funding = findSection($sections, 'grants_funding')['data'] ?? [];
$metricsSection = findSection($sections, 'metrics_highlights')['data'] ?? [];


/* contact — items à afficher dans la barre */
$contactItems = array_filter([
    $contactData['location'] ?? null,
    $contactData['phone']    ?? null,
    $contactData['email']    ?? null,
    $contactData['linkedin'] ?? null,
    $contactData['github']   ?? null,
    $contactData['portfolio']?? null,
    $contactData['website']  ?? null,
]);

$activeSkillLabels = $skillLabelMap[$profileKey] ?? $skillLabelMap['tech'];

@endphp

<div class="resume {{ $themeKey }}">

    {{-- ══════════════════════════
         HEADER
    ══════════════════════════ --}}
    <div class="header">

        {{-- barre accent latérale (modern + tech) --}}
        @if(in_array($themeKey, ['modern','tech']))
            <div class="header-accent-bar"></div>
        @endif

        <div class="name">{{ $resume['full_name'] ?? '' }}</div>

        @if(!empty($resume['headline']))
            <div class="headline">{{ $resume['headline'] }}</div>
        @endif

    </div>

    {{-- ══════════════════════════
         BARRE CONTACT
    ══════════════════════════ --}}
    @if(count($contactItems))
    <div class="contact-bar">
        @foreach($contactItems as $i => $item)
            @if($i > 0)<span class="contact-sep">•</span>@endif
            {{ $item }}
        @endforeach
    </div>
    @endif

    {{-- ══════════════════════════
         CORPS DU CV
    ══════════════════════════ --}}
    <div class="body">

        {{-- ── SUMMARY ── --}}
        @if(!empty($summaryData['text']))
        <div class="section">
            <div class="section-title">
                @if($themeKey === 'academic') Research Statement
                @elseif($themeKey === 'executive') Executive Profile
                @elseif($themeKey === 'legal') Professional Overview
                @else Professional Summary
                @endif
            </div>
            <div class="summary-text">{{ $summaryData['text'] }}</div>
        </div>
        @endif

        {{-- ============================================================
        METRICS — subtle strip when present
        ============================================================ --}}

        @if(count($metricsSection))
        <div style="padding: 8pt 36pt 0 36pt;">
            <div class="metrics-grid">
                @foreach($metricsSection as $metric)
                <div class="metric-item">
                <span class="metric-value">{{ $metric['value'] ?? '' }}</span>
                <span class="metric-label">{{ $metric['label'] ?? '' }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        {{-- ============================================================
        TWO-COLUMN BODY
        ============================================================ --}}

        {{-- ── SKILLS ── --}}
        @if(count($skillsData))
        <div class="section">
            <div class="section-title">Core Skills</div>
            <div class="skills">
                @foreach($skillsData as  $key => $skill)
                    <span class="">{{ $activeSkillLabels[$key] ?? ucwords(str_replace('_',' ',$key)) }}</span>
                    <span class="skill">{{ $skill }}</span>
                @endforeach
            </div>
        </div>
        @elseif(count($technical_competencies))
        <div class="section">
            @foreach($data as $groupKey => $items)
            <div class="section-title">{{$activeSkillLabels[$groupKey] ?? ucwords(str_replace('_',' ',$groupKey))}}</div>
            <div class="skills">
                @foreach($skillsData as  $key => $skill)
                    <span class="">{{ $activeSkillLabels[$key] ?? ucwords(str_replace('_',' ',$key)) }}</span>
                    <span class="skill">{{ $skill }}</span>
                @endforeach
            </div>
            @endforeach
        </div>
        @endif



        {{-- ── EXPERIENCE ── --}}
        @if(count($experience))
        <div class="section">
            <div class="section-title">Professional Experience</div>

            @foreach($experience as $exp)
            @php
                $bullets = parseBullets($exp['bullets'] ?? null);
                $techTags = !empty($exp['technologies'])
                    ? array_map('trim', explode(',', $exp['technologies']))
                    : [];
            @endphp
            <div class="job">
                <div class="job-head">
                    <div>
                        @if(!empty($exp['title']))
                            <div class="job-title">{{ $exp['title'] }}</div>
                        @endif
                        @if(!empty($exp['company']))
                            <div class="company">
                                {{ $exp['company'] }}
                                @if(!empty($exp['location']))
                                    <span class="exp-location">— {{ $exp['location'] }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                    @if(!empty($exp['dates']))
                        <div class="date">{{ formatDates($exp['dates']) }}</div>
                    @elseif(!empty($exp['date_range']))
                        <div class="date">{{ $exp['date_range'] }}</div>
                    @endif
                </div>

                @if(!empty($exp['description']))
                    <div class="job-description">{{ $exp['description'] }}</div>
                @endif

                @if(count($bullets))
                <ul class="bullet-list">
                    @foreach($bullets as $bullet)
                        <li>{{ $bullet }}</li>
                    @endforeach
                </ul>
                @endif

                @if(count($techTags))
                <div class="tech-tags">
                    @foreach($techTags as $tech)
                        <span class="tech-tag">{{ $tech }}</span>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach

        </div>
        @endif

        {{-- ── EDUCATION ── --}}
        @if(count($education))
        <div class="section">
            <div class="section-title">Education</div>

            @foreach($education as $edu)
            <div class="edu-entry">
                <div class="edu-degree">
                    {{ $edu['degree'] ?? '' }}
                    @if(!empty($edu['field'])), {{ $edu['field'] }}@endif
                </div>
                <div class="edu-inst">
                    {{ $edu['institution'] ?? '' }}
                    @if(!empty($edu['location']))
                        <span style="color:#94a3b8"> — {{ $edu['location'] }}</span>
                    @endif
                </div>
                @php
                    $eduMeta = [];
                    if (!empty($edu['dates'])) $eduMeta[] = formatDates($edu['dates']);
                    if (!empty($edu['honors'])) $eduMeta[] = $edu['honors'];
                    if (!empty($edu['gpa']))    $eduMeta[] = 'GPA: ' . $edu['gpa'];
                @endphp
                @if(count($eduMeta))
                    <div class="edu-meta">{{ implode(' · ', $eduMeta) }}</div>
                @endif
                @if(!empty($edu['details']))
                    <div class="edu-details">{{ $edu['details'] }}</div>
                @endif
            </div>
            @endforeach

        </div>
        @endif

        {{-- ── CERTIFICATIONS ── --}}
        @if(count($certifs))
        <div class="section">
            <div class="section-title">Certifications</div>

            @foreach($certifs as $cert)
            <div class="cert-entry">
                <div class="cert-name">
                    {{ $cert['name'] ?? $cert['license_name'] ?? '' }}
                </div>
                <div class="cert-issuer">
                    {{ $cert['issuer'] ?? $cert['state_or_region'] ?? '' }}
                </div>
                <div class="cert-date">
                    {{ $cert['date'] ?? '' }}
                    @if(!empty($cert['expiration'])) — Exp. {{ $cert['expiration'] }}@endif
                </div>
            </div>
            @endforeach

        </div>
        @endif

        {{-- ── PROJECTS ── --}}
        @if(count($projects))
        <div class="section">
            <div class="section-title">Projects</div>

            @foreach($projects as $proj)
            <div class="project">
                <div class="project-name">{{ $proj['name'] ?? '' }}</div>

                @if(!empty($proj['role']))
                    <div class="project-role">{{ $proj['role'] }}</div>
                @endif

                @if(!empty($proj['description']))
                    <div class="project-desc">{{ $proj['description'] }}</div>
                @endif

                @if(!empty($proj['impact']))
                    <div class="project-impact">↑ {{ $proj['impact'] }}</div>
                @endif

                @if(!empty($proj['technologies']) && is_array($proj['technologies']))
                <div class="project-tech">
                    @foreach($proj['technologies'] as $tech)
                        <span class="project-tech-tag">{{ $tech }}</span>
                    @endforeach
                </div>
                @endif
            </div>
            @endforeach

        </div>
        @endif

        {{-- ── LANGUAGES ── --}}
        @if(count($languages))
        <div class="section">
            <div class="section-title">Languages</div>

            @foreach($languages as $lang)
            <div class="lang-entry">
                <span class="lang-name">{{ $lang['language'] ?? '' }}</span>
                <span class="lang-level">{{ $lang['level'] ?? '' }}</span>
            </div>
            @endforeach

        </div>
        @endif

        {{-- ── ADDITIONAL ── --}}
        @if($additional)
        <div class="section">
            <div class="section-title">Additional Information</div>
            <div style="font-size:11.5px; line-height:1.75; color:#475569;">
                {!! nl2br(e($additional)) !!}
            </div>
        </div>
        @endif

    </div>{{-- end .body --}}

    {{-- ══════════════════════════
         FOOTER
    ══════════════════════════ --}}
    <div class="footer">
        {{ $resume['full_name'] ?? '' }} &nbsp;·&nbsp; Generated by CVMatch AI &nbsp;·&nbsp; Confidential
    </div>

</div>{{-- end .resume --}}

</body>
</html>
