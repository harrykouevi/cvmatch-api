<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>{{ $resume['full_name'] ?? 'Resume' }}</title>
<style>
    /* ============================================================
    ADAPTIVE TEMPLATE SYSTEM — v3
    Profession profiles:
    tech → Software / Product / Platform Engineering
    finance → Finance / Banking / Investment / Private Equity
    executive → C-Suite / VP / Director / Consulting
    healthcare → Clinical / Medical / Nursing / Pharma
    legal → Law / Compliance / Regulatory
    academic → Research / Academia / PhD / Postdoc
    ============================================================ */
* { margin: 0; padding: 0; box-sizing: border-box; }
/* ============================================================
BASE — shared across all profiles
============================================================ */
body {
font-family: 'DejaVu Sans', Arial, sans-serif;
font-size: 9.5pt;
line-height: 1.5;
color: #111827;
background: #ffffff;
}
.page { width: 100%; background: #ffffff; }
/* ============================================================
PROFILE: TECH (default — two-column, dark header, blue accent)
============================================================ */
.profile-tech .header {
background: #0f172a;
padding: 14pt 36pt 11pt 42pt;
position: relative;
}
.profile-tech .header-accent {
position: absolute; top: 0; left: 0;
width: 4pt; height: 100%;
background: #3b82f6;
}
.profile-tech .candidate-name {
font-size: 19pt; font-weight: 700; color: #ffffff;
letter-spacing: 0.3pt; line-height: 1.1; text-transform: uppercase;
}
.profile-tech .candidate-headline {
font-size: 8pt; color: #93c5fd; margin-top: 2pt;
font-weight: 400; letter-spacing: 0.5pt; text-transform: uppercase;
}
.profile-tech .contact-bar {
background: #1e3a5f; padding: 5pt 42pt;
}
.profile-tech .contact-items { font-size: 7.5pt; color: #bfdbfe; }
.profile-tech .contact-sep { color: #3b82f6; margin: 0 5pt; }
.profile-tech .section-title {
font-size: 7pt; font-weight: 700; color: #3b82f6;
text-transform: uppercase; letter-spacing: 1.5pt;
border-bottom: 1pt solid #3b82f6;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-tech .section-title-dark {
font-size: 7pt; font-weight: 700; color: #0f172a;
text-transform: uppercase; letter-spacing: 1.5pt;
border-bottom: 1pt solid #0f172a;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-tech .summary-text {
font-size: 9pt; color: #334155; line-height: 1.65;
padding: 8pt 13pt; background: #f0f7ff;
border-left: 2.5pt solid #3b82f6;
}
.profile-tech .exp-job-title { font-size: 10pt; font-weight: 700; color: #0f172a; }
.profile-tech .exp-company { font-size: 8.5pt; color: #3b82f6; font-weight: 600; }
.profile-tech .exp-dates { font-size: 7.5pt; color: #64748b; font-weight: 600; }
.profile-tech .cert-entry { border-left: 1.5pt solid #3b82f6; }
.profile-tech .footer { border-top: 0.5pt solid #e2e8f0; background: #ffffff; }
/* ============================================================
PROFILE: FINANCE (single column dominant, serif accent, navy)
============================================================ */
.profile-finance .header {
background: #0a1628;
padding: 14pt 40pt 11pt 40pt;
border-bottom: 2pt solid #c9a84c;
}
.profile-finance .candidate-name {
font-size: 18pt; font-weight: 700; color: #ffffff;
letter-spacing: 0.8pt; line-height: 1.1; text-transform: uppercase;
}
.profile-finance .candidate-headline {
font-size: 8pt; color: #c9a84c; margin-top: 3pt;
font-weight: 400; letter-spacing: 1pt; text-transform: uppercase;
}
.profile-finance .contact-bar {
background: #0d1f3c; padding: 5pt 40pt;
}
.profile-finance .contact-items { font-size: 7.5pt; color: #94a3b8; }
.profile-finance .contact-sep { color: #c9a84c; margin: 0 5pt; }
.profile-finance .section-title {
font-size: 7pt; font-weight: 700; color: #0a1628;
text-transform: uppercase; letter-spacing: 1.8pt;
border-bottom: 1.5pt solid #c9a84c;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-finance .section-title-dark {
font-size: 7pt; font-weight: 700; color: #0a1628;
text-transform: uppercase; letter-spacing: 1.8pt;
border-bottom: 1.5pt solid #0a1628;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-finance .summary-text {
font-size: 9pt; color: #1e293b; line-height: 1.65;
padding: 8pt 13pt; background: #fafaf7;
border-left: 2.5pt solid #c9a84c;
}
.profile-finance .exp-job-title { font-size: 10pt; font-weight: 700; color: #0a1628; }
.profile-finance .exp-company { font-size: 8.5pt; color: #92400e; font-weight: 600; }
.profile-finance .exp-dates { font-size: 7.5pt; color: #64748b; font-weight: 600; }
.profile-finance .cert-entry { border-left: 1.5pt solid #c9a84c; }
.profile-finance .footer { border-top: 1pt solid #c9a84c; background: #ffffff; }
.profile-finance .col-left { background: #f9f8f4; border-right: 1pt solid #e7e3d6; }
/* ============================================================
PROFILE: EXECUTIVE (minimal, single tone, no left-panel color)
============================================================ */
.profile-executive .header {
background: #ffffff;
padding: 18pt 40pt 6pt 40pt;
border-bottom: 2pt solid #111827;
}
.profile-executive .candidate-name {
font-size: 20pt; font-weight: 700; color: #111827;
letter-spacing: 0.2pt; line-height: 1.1; text-transform: uppercase;
}
.profile-executive .candidate-headline {
font-size: 9pt; color: #374151; margin-top: 3pt;
font-weight: 400; letter-spacing: 0.3pt;
}
.profile-executive .contact-bar {
background: #ffffff; padding: 5pt 40pt;
border-bottom: 0.5pt solid #e5e7eb;
}
.profile-executive .contact-items { font-size: 7.5pt; color: #6b7280; }
.profile-executive .contact-sep { color: #9ca3af; margin: 0 5pt; }
.profile-executive .section-title {
font-size: 7pt; font-weight: 700; color: #111827;
text-transform: uppercase; letter-spacing: 2pt;
border-bottom: 0.5pt solid #111827;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-executive .section-title-dark {
font-size: 7pt; font-weight: 700; color: #111827;
text-transform: uppercase; letter-spacing: 2pt;
border-bottom: 0.5pt solid #111827;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-executive .summary-text {
font-size: 9pt; color: #374151; line-height: 1.7;
padding: 0; background: transparent;
border-left: none; font-style: italic;
}
.profile-executive .exp-job-title { font-size: 10pt; font-weight: 700; color: #111827; }
.profile-executive .exp-company { font-size: 8.5pt; color: #374151; font-weight: 600; }
.profile-executive .exp-dates { font-size: 7.5pt; color: #6b7280; font-weight: 400; }
.profile-executive .cert-entry { border-left: 1.5pt solid #111827; }
.profile-executive .footer { border-top: 2pt solid #111827; background: #ffffff; }
.profile-executive .col-left { background: #ffffff; border-right: 0.5pt solid #e5e7eb; }
/* ============================================================
PROFILE: HEALTHCARE (clean, ATS-safe, clinical green accent)
============================================================ */
.profile-healthcare .header {
background: #0f2a1f;
padding: 14pt 36pt 11pt 40pt;
position: relative;
}
.profile-healthcare .header-accent {
position: absolute; top: 0; left: 0;
width: 4pt; height: 100%; background: #10b981;
}
.profile-healthcare .candidate-name {
font-size: 19pt; font-weight: 700; color: #ffffff;
letter-spacing: 0.3pt; line-height: 1.1; text-transform: uppercase;
}
.profile-healthcare .candidate-headline {
font-size: 8pt; color: #6ee7b7; margin-top: 2pt;
font-weight: 400; letter-spacing: 0.5pt; text-transform: uppercase;
}
.profile-healthcare .contact-bar {
background: #1a3d2b; padding: 5pt 40pt;
}
.profile-healthcare .contact-items { font-size: 7.5pt; color: #a7f3d0; }
.profile-healthcare .contact-sep { color: #10b981; margin: 0 5pt; }
.profile-healthcare .section-title {
font-size: 7pt; font-weight: 700; color: #065f46;
text-transform: uppercase; letter-spacing: 1.5pt;
border-bottom: 1pt solid #10b981;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-healthcare .section-title-dark {
font-size: 7pt; font-weight: 700; color: #0f2a1f;
text-transform: uppercase; letter-spacing: 1.5pt;
border-bottom: 1pt solid #0f2a1f;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-healthcare .summary-text {
font-size: 9pt; color: #1f2937; line-height: 1.65;
padding: 8pt 13pt; background: #f0fdf4;
border-left: 2.5pt solid #10b981;
}
.profile-healthcare .exp-job-title { font-size: 10pt; font-weight: 700; color: #0f2a1f; }
.profile-healthcare .exp-company { font-size: 8.5pt; color: #059669; font-weight: 600; }
.profile-healthcare .exp-dates { font-size: 7.5pt; color: #64748b; font-weight: 600; }
.profile-healthcare .cert-entry { border-left: 1.5pt solid #10b981; }
.profile-healthcare .footer { border-top: 0.5pt solid #d1fae5; background: #ffffff; }
.profile-healthcare .col-left { background: #f0fdf4; border-right: 1pt solid #d1fae5; }
/* ============================================================
PROFILE: LEGAL (traditional, single accent line, no color fill)
============================================================ */
.profile-legal .header {
background: #1c1917;
padding: 14pt 40pt 11pt 40pt;
}
.profile-legal .candidate-name {
font-size: 18pt; font-weight: 700; color: #ffffff;
letter-spacing: 0.5pt; line-height: 1.1; text-transform: uppercase;
}
.profile-legal .candidate-headline {
font-size: 8pt; color: #d6d3d1; margin-top: 3pt;
font-weight: 400; letter-spacing: 0.8pt; text-transform: uppercase;
}
.profile-legal .contact-bar {
background: #292524; padding: 5pt 40pt;
}
.profile-legal .contact-items { font-size: 7.5pt; color: #a8a29e; }
.profile-legal .contact-sep { color: #78716c; margin: 0 5pt; }
.profile-legal .section-title {
font-size: 7pt; font-weight: 700; color: #1c1917;
text-transform: uppercase; letter-spacing: 2pt;
border-bottom: 1pt solid #1c1917;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-legal .section-title-dark {
font-size: 7pt; font-weight: 700; color: #1c1917;
text-transform: uppercase; letter-spacing: 2pt;
border-bottom: 1pt solid #1c1917;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-legal .summary-text {
font-size: 9pt; color: #1c1917; line-height: 1.7;
padding: 8pt 13pt; background: #fafaf9;
border-left: 2.5pt solid #78716c;
}
.profile-legal .exp-job-title { font-size: 10pt; font-weight: 700; color: #1c1917; }
.profile-legal .exp-company { font-size: 8.5pt; color: #44403c; font-weight: 600; }
.profile-legal .exp-dates { font-size: 7.5pt; color: #78716c; font-weight: 600; }
.profile-legal .cert-entry { border-left: 1.5pt solid #44403c; }
.profile-legal .footer { border-top: 1pt solid #1c1917; background: #ffffff; }
.profile-legal .col-left { background: #fafaf9; border-right: 1pt solid #e7e5e4; }
/* ============================================================
PROFILE: ACADEMIC (clean, research-forward, structured)
============================================================ */
.profile-academic .header {
background: #ffffff;
padding: 16pt 40pt 10pt 40pt;
border-bottom: 2.5pt solid #4338ca;
}
.profile-academic .candidate-name {
font-size: 19pt; font-weight: 700; color: #1e1b4b;
letter-spacing: 0.2pt; line-height: 1.1;
}
.profile-academic .candidate-headline {
font-size: 8.5pt; color: #4338ca; margin-top: 3pt;
font-weight: 400; letter-spacing: 0.2pt;
}
.profile-academic .contact-bar {
background: #eef2ff; padding: 5pt 40pt;
border-bottom: 0.5pt solid #c7d2fe;
}
.profile-academic .contact-items { font-size: 7.5pt; color: #4338ca; }
.profile-academic .contact-sep { color: #818cf8; margin: 0 5pt; }
.profile-academic .section-title {
font-size: 7pt; font-weight: 700; color: #4338ca;
text-transform: uppercase; letter-spacing: 1.5pt;
border-bottom: 1pt solid #818cf8;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-academic .section-title-dark {
font-size: 7pt; font-weight: 700; color: #1e1b4b;
text-transform: uppercase; letter-spacing: 1.5pt;
border-bottom: 1pt solid #1e1b4b;
padding-bottom: 3pt; margin-bottom: 8pt;
}
.profile-academic .summary-text {
font-size: 9pt; color: #1e1b4b; line-height: 1.7;
padding: 8pt 13pt; background: #eef2ff;
border-left: 2.5pt solid #4338ca;
}
.profile-academic .exp-job-title { font-size: 10pt; font-weight: 700; color: #1e1b4b; }
.profile-academic .exp-company { font-size: 8.5pt; color: #4338ca; font-weight: 600; }
.profile-academic .exp-dates { font-size: 7.5pt; color: #6b7280; font-weight: 600; }
.profile-academic .cert-entry { border-left: 1.5pt solid #818cf8; }
.profile-academic .footer { border-top: 0.5pt solid #c7d2fe; background: #ffffff; }
.profile-academic .col-left { background: #f5f3ff; border-right: 1pt solid #c7d2fe; }
/* ============================================================
SHARED LAYOUT — all profiles
============================================================ */
.body-wrapper {
display: table; width: 100%; table-layout: fixed;
}
.col-left {
display: table-cell; width: 31%;
padding: 16pt 13pt 16pt 36pt;
vertical-align: top;
}
.col-right {
display: table-cell; width: 69%;
padding: 16pt 36pt 16pt 18pt;
vertical-align: top;
}
.section { margin-bottom: 13pt; }
/* ============================================================
EXPERIENCE — shared
============================================================ */
.exp-entry {
margin-bottom: 11pt; padding-bottom: 11pt;
border-bottom: 0.5pt solid #e5e7eb;
}
.exp-entry:last-child {
border-bottom: none; margin-bottom: 0; padding-bottom: 0;
}
.exp-header {
display: table; width: 100%; margin-bottom: 2pt;
}
.exp-title-block { display: table-cell; vertical-align: top; }
.exp-date-block {
display: table-cell; text-align: right;
vertical-align: top; white-space: nowrap; padding-left: 6pt;
}
.exp-location {
font-size: 7.5pt; color: #64748b; font-style: italic;
}
/* Bullets — max 2 lines guideline enforced by tight font */
.bullet-list {
margin: 4pt 0 0 0; padding-left: 12pt; list-style: none;
}
.bullet-list li {
font-size: 8.5pt; color: #334155; margin-bottom: 2.5pt;
padding-left: 10pt; position: relative; line-height: 1.45;
}
.bullet-list li:before {
content: "▸"; color: inherit; opacity: 0.5;
position: absolute; left: 0; font-size: 6.5pt; top: 1.5pt;
}
.profile-tech .bullet-list li:before { color: #3b82f6; opacity: 1; }
.profile-finance .bullet-list li:before { color: #c9a84c; opacity: 1; }
.profile-executive .bullet-list li:before { color: #111827; opacity: 0.4; }
.profile-healthcare .bullet-list li:before { color: #10b981; opacity: 1; }
.profile-legal .bullet-list li:before { color: #44403c; opacity: 0.7; }
.profile-academic .bullet-list li:before { color: #4338ca; opacity: 1; }
/* Tech tags — inline dot-separated, no pills */
.tech-tags { margin-top: 4pt; }
.tech-tag {
font-size: 7.5pt; color: #6b7280; display: inline;
}
.tech-tag:not(:last-child)::after { content: " · "; color: #9ca3af; }
/* ============================================================
EDUCATION — shared
============================================================ */
.edu-entry { margin-bottom: 8pt; }
.edu-degree { font-size: 9.5pt; font-weight: 700; color: #111827; }
.edu-institution { font-size: 8.5pt; color: #475569; }
.edu-meta { font-size: 8pt; color: #9ca3af; }
.exp-description { font-size: 8.5pt; color: #475569; line-height: 1.5; margin: 3pt 0 4pt 0; }
/* ============================================================
SKILLS — left column, plain text groups
============================================================ */
.skill-group { margin-bottom: 7pt; }
.skill-group-label {
font-size: 7pt; font-weight: 700; color: #374151;
text-transform: uppercase; letter-spacing: 0.5pt; margin-bottom: 2pt;
}
.skill-text { font-size: 8pt; color: #374155; line-height: 1.6; }
/* ============================================================
CERTIFICATIONS — shared, compact
============================================================ */
.cert-entry {
margin-bottom: 5pt; padding-left: 6pt;
}
.cert-name { font-size: 8pt; font-weight: 700; color: #111827; }
.cert-issuer { font-size: 7.5pt; color: #64748b; }
.cert-date { font-size: 7pt; color: #9ca3af; }
/* ============================================================
LANGUAGES — shared
============================================================ */
.lang-entry { display: table; width: 100%; margin-bottom: 3.5pt; }
.lang-name { display: table-cell; font-size: 8.5pt; font-weight: 600; color: #111827; }
.lang-level { display: table-cell; text-align: right; font-size: 8pt; font-weight: 600; }
.profile-tech .lang-level { color: #3b82f6; }
.profile-finance .lang-level { color: #c9a84c; }
.profile-executive .lang-level { color: #374151; }
.profile-healthcare .lang-level { color: #059669; }
.profile-legal .lang-level { color: #44403c; }
.profile-academic .lang-level { color: #4338ca; }
/* ============================================================
PROJECT / GENERIC ENTRIES — shared
============================================================ */
.project-entry { margin-bottom: 8pt; padding-left: 6pt; border-left: 1.5pt solid #e5e7eb; }
.project-name { font-size: 9pt; font-weight: 700; color: #111827; }
.project-role { font-size: 8pt; font-weight: 600; color: #64748b; }
.project-desc { font-size: 8.5pt; color: #475569; line-height: 1.5; margin-top: 2pt; }
.project-impact{ font-size: 8pt; font-weight: 600; color: #059669; margin-top: 2pt; }
.generic-entry { margin-bottom: 5.5pt; }
.generic-title { font-size: 9pt; font-weight: 700; color: #111827; }
.generic-sub { font-size: 8pt; color: #64748b; }
/* ============================================================
METRICS STRIP — subtle, shared, no scorecards
============================================================ */
.metrics-grid { display: table; width: 100%; margin-bottom: 10pt; }
.metric-item {
display: table-cell; text-align: center; padding: 5pt 4pt;
border-right: 0.5pt solid #e5e7eb;
}
.metric-item:last-child { border-right: none; }
.metric-value { font-size: 11pt; font-weight: 700; color: #111827; display: block; }
.metric-label { font-size: 7pt; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5pt;
display: block; }
/* ============================================================
FOOTER — shared, minimal
============================================================ */
.footer {
padding: 5pt 36pt; text-align: center;
}
.footer-text { font-size: 7pt; color: #9ca3af; letter-spacing: 0.5pt; }
/* ACHIEVEMENT ITEMS — inline */
.achievement-item { font-size: 8pt; font-weight: 600; color: #1e40af; display: inline; }
.page-break { page-break-after: always; }
</style>
</head>
<body>
@php
/* ============================================================
PROFESSION DETECTION
Reads $resume['schema_type'] if set.
Falls back to keyword detection from headline/sections.
============================================================ */
$profileMap = [
    'tech' => 'profile-tech',
    'finance' => 'profile-finance',
    'executive' => 'profile-executive',
    'healthcare' => 'profile-healthcare',
    'legal' => 'profile-legal',
    'academic' => 'profile-academic',
];
$profileKey = strtolower($resume['schema_type'] ?? 'tech');
if (!array_key_exists($profileKey, $profileMap)) {
    // Auto-detect from headline
    $headline = strtolower($resume['headline'] ?? '');
    if (preg_match('/cfo|ceo|vp |chief|managing director|partner|principal|c-suite|svp|evp/i', $headline)) {
    $profileKey = 'executive';
    } elseif (preg_match('/attorney|counsel|associate|law|legal|compliance|regulatory/i', $headline)) {
    $profileKey = 'legal';
    } elseif (preg_match('/physician|md |doctor|nurse|clinical|healthcare|pharma|rn |pa |np /i', $headline)) {
    $profileKey = 'healthcare';
    } elseif (preg_match('/research|phd|professor|postdoc|faculty|academic|scientist/i', $headline)) {
    $profileKey = 'academic';
    } elseif
    (preg_match('/finance|banking|equity|analyst|portfolio|investment|fund|quant|trader/i', $headline)) {
    $profileKey = 'finance';
    } else {
    $profileKey = 'tech';
    }
}
$profileClass = $profileMap[$profileKey] ?? 'profile-tech';
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
SECTION ROUTING
============================================================ */
$contactSection = collect($resume['sections'] ?? [])->firstWhere('section_key', 'contact');
$contact = $contactSection['data'] ?? [];
$summarySection = collect($resume['sections'] ?? [])->firstWhere('section_key','professional_summary');
$summary = $summarySection['data']['text'] ?? null;
$otherSections = collect($resume['sections'] ?? [])->filter(function($s) { return !in_array($s['section_key'], ['contact', 'professional_summary']);});
$leftKeys = ['skills', 'technical_competencies', 'certifications', 'licenses', 'languages','tools_expertise', 'clinical_skills', 'bar_admissions'];
$leftSections = $otherSections->filter(fn($s) => in_array($s['section_key'], $leftKeys));
$rightSections = $otherSections->filter(fn($s) => !in_array($s['section_key'], $leftKeys));
/* Academic profile: publications come first in right column */
if ($profileKey === 'academic') {
    $rightSections = $rightSections->sortBy(function($s) {
        $order = ['publications' => 0, 'research_experience' => 1, 'professional_experience' => 2,'education' => 3, 'grants_funding' => 4, 'awards' => 5];
        return $order[$s['section_key']] ?? 99;
    });
}
@endphp
<div class="page {{ $profileClass }}">
{{-- ============================================================
HEADER
============================================================ --}}
    <div class="header">
        @if(in_array($profileKey, ['tech','healthcare']))
        <div class="header-accent"></div>
        @endif
        <div class="candidate-name">{{ $resume['full_name'] ?? '' }}</div>
        @if(!empty($resume['headline']))
        <div class="candidate-headline">{{ $resume['headline'] }}</div>
        @endif
    </div>
{{-- ============================================================
CONTACT BAR
============================================================ --}}
    <div class="contact-bar">
        <span class="contact-items">
        @if(!empty($contact['email'])){{ $contact['email'] }}@endif
        @if(!empty($contact['phone']))<span class="contact-sep">|</span>{{ $contact['phone']}}@endif
        @if(!empty($contact['location']))<span class="contact-sep">|</span>{{ $contact['location']}}@endif
        @if(!empty($contact['linkedin']))<span class="contact-sep">|</span>{{ $contact['linkedin']}}@endif
        @if(!empty($contact['github']))<span class="contact-sep">|</span>{{ $contact['github']}}@endif
        @if(!empty($contact['portfolio']))<span class="contact-sep">|</span>{{$contact['portfolio'] }}@endif
        @if(!empty($contact['website']))<span class="contact-sep">|</span>{{ $contact['website']}}@endif
        </span>
    </div>
{{-- ============================================================
PROFESSIONAL SUMMARY — full width
============================================================ --}}
    @if($summary)
    <div style="padding: 13pt 36pt 0 36pt; background:#ffffff;">
        <div class="section">
            <div class="section-title">
            @if($profileKey === 'academic') Research Statement
            @elseif($profileKey === 'executive') Executive Profile
            @elseif($profileKey === 'legal') Professional Overview
            @else Professional Summary
            @endif
            </div>
            <div class="summary-text">{{ $summary }}</div>
        </div>
    </div>
    @endif
{{-- ============================================================
METRICS — subtle strip when present
============================================================ --}}
    @php $metricsSection = $otherSections->firstWhere('section_key', 'metrics_highlights');
    @endphp
    @if($metricsSection && !empty($metricsSection['data']))
    <div style="padding: 8pt 36pt 0 36pt;">
        <div class="metrics-grid">
            @foreach($metricsSection['data'] as $metric)
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
    <div class="body-wrapper">
        {{-- LEFT COLUMN --}}
        <div class="col-left">
            @foreach($leftSections as $section)
            @php $key = $section['section_key']; $data = $section['data'] ?? []; @endphp
            <div class="section">
                <div class="section-title">{{ $section['section_label'] ?? ucwords(str_replace('_','',$key)) }}</div>
                {{-- SKILLS: plain text, profession-aware labels --}}
                @if($key === 'skills' && is_array($data))
                    @foreach($data as $groupKey => $groupItems)
                    @if(!empty($groupItems))
                    <div class="skill-group">
                        <div class="skill-group-label">{{ $activeSkillLabels[$groupKey] ?? ucwords(str_replace('_',' ',$groupKey)) }}</div>
                        <div class="skill-text">{{ is_array($groupItems) ? implode(', ', $groupItems) : $groupItems }}</div>
                    </div>
                    @endif
                    @endforeach
                @elseif($key === 'technical_competencies' && is_array($data))
                    @foreach($data as $groupKey => $items)
                    @if(!empty($items))
                    <div class="skill-group">
                        <div class="skill-group-label">{{ $activeSkillLabels[$groupKey] ?? ucwords(str_replace('_',' ',$groupKey)) }}</div>
                        <div class="skill-text">{{ is_array($items) ? implode(', ', (array)$items) : $items }}</div>
                    </div>
                    @endif
                    @endforeach
                @elseif($key === 'tools_expertise' && is_array($data))
                    @foreach($data as $group)
                    <div class="skill-group">
                        <div class="skill-group-label">{{ $group['category'] ?? '' }}</div>
                        <div class="skill-text">{{ is_array($group['tools'] ?? []) ? implode(', ', $group['tools'] ?? []) : '' }}</div>
                    </div>
                    @endforeach
                @elseif(in_array($key, ['certifications','licenses']) && is_array($data))
                    @foreach($data as $cert)
                    <div class="cert-entry">
                        <div class="cert-name">{{ $cert['name'] ?? $cert['license_name'] ?? '' }}</div>
                        <div class="cert-issuer">{{ $cert['issuer'] ?? $cert['state_or_region'] ?? '' }}</div>
                        <div class="cert-date">{{ $cert['date'] ?? '' }}@if(!empty($cert['expiration'])) — Exp. {{ $cert['expiration'] }}@endif</div>
                    </div>
                    @endforeach
                @elseif($key === 'languages' && is_array($data))
                    @foreach($data as $lang)
                    <div class="lang-entry">
                        <span class="lang-name">{{ $lang['language'] ?? '' }}</span>
                        <span class="lang-level">{{ $lang['level'] ?? '' }}</span>
                    </div>
                    @endforeach
                @elseif($key === 'bar_admissions' && is_array($data))
                    @foreach($data as $bar)
                    <div class="cert-entry">
                        <div class="cert-name">{{ $bar['jurisdiction'] ?? '' }}</div>
                        <div class="cert-issuer">{{ $bar['status'] ?? '' }}</div>
                        <div class="cert-date">{{ $bar['date'] ?? '' }}</div>
                    </div>
                    @endforeach
                @elseif($key === 'clinical_skills' && is_array($data))
                    @foreach($data as $groupKey => $items)
                    <div class="skill-group">
                        <div class="skill-group-label">{{ ucwords(str_replace('_',' ',$groupKey)) }}</div>
                        <div class="skill-text">{{ is_array($items) ? implode(', ', (array)$items) : $items }}</div>
                    </div>
                    @endforeach
                @endif
            </div>
            @endforeach
        </div>
        {{-- RIGHT COLUMN --}}
        <div class="col-right">
            @foreach($rightSections as $section)
            @php $key = $section['section_key']; $data = $section['data'] ?? []; @endphp
            @if($key === 'metrics_highlights') @continue @endif
            <div class="section">
                <div class="section-title-dark">{{ $section['section_label'] ?? ucwords(str_replace('_','',$key)) }}</div>
                {{-- PROFESSIONAL / RESEARCH EXPERIENCE --}}
                @if(in_array($key, ['professional_experience','research_experience']) && is_array($data))
                    @foreach($data as $exp)
                    <div class="exp-entry">
                        <div class="exp-header">
                            <div class="exp-title-block">
                                <div class="exp-job-title">{{ $exp['title'] ?? '' }}</div>
                                <div class="exp-company">{{ $exp['company'] ?? $exp['institution'] ?? '' }}</div>
                                @if(!empty($exp['location']))<div class="exp-location">{{ $exp['location']}}</div>@endif
                            </div>
                            <div class="exp-date-block">
                                @php
                                $start = $exp['dates']['start'] ?? '';
                                $end = $exp['dates']['end'] ?? 'Present';
                                $dateStr = trim($start . ($start ? ' – ' . $end : ''));
                                @endphp
                                @if($dateStr)<span class="exp-dates">{{ $dateStr }}</span>@endif
                            </div>
                        </div>
                        @if(!empty($exp['description']))<div class="exp-description">{{ $exp['description']}}</div>@endif
                        @if(!empty($exp['bullets']))
                        <ul class="bullet-list">
                            @foreach(  array_map('trim', explode('|', $exp['bullets'])) as $bullet)
                            <li>{{ $bullet }}</li>
                            @endforeach
                        </ul>
                        @endif
                        @if(!empty($exp['achievements']))
                        <div style="margin-top:3pt;">
                            @foreach($exp['achievements'] as $i => $ach)
                            <span class="achievement-item">{{ $i > 0 ? ' · ' : '' }}✓ {{ $ach }}</span>
                            @endforeach
                        </div>
                        @endif
                        @if(!empty($exp['technologies']))
                        <div class="tech-tags">
                            @foreach( array_map('trim', explode(',', $exp['technologies'])) as $tech)
                            <span class="tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                    {{-- EDUCATION --}}
                @elseif($key === 'education' && is_array($data))
                    @foreach($data as $edu)
                    <div class="edu-entry">
                        <div class="edu-degree">{{ $edu['degree'] ?? '' }}@if(!empty($edu['field'])), {{$edu['field'] }}@endif</div>
                        <div class="edu-institution">{{ $edu['institution'] ?? '' }}</div>
                        <div class="edu-meta">
                            {{ $edu['location'] ?? '' }}
                            @php
                            $eduStart = $edu['dates']['start'] ?? '';
                            $eduEnd = $edu['dates']['end'] ?? '';
                            $eduDate = trim($eduStart . ($eduStart && $eduEnd ? ' – '.$eduEnd : $eduEnd));
                            @endphp
                            @if($eduDate) · {{ $eduDate }}@endif
                            @if(!empty($edu['gpa'])) · GPA: {{ $edu['gpa'] }}@endif
                            @if(!empty($edu['honors'])) · {{ $edu['honors'] }}@endif
                        </div>
                        @if(!empty($edu['details']))<div class="exp-description">{{ $edu['details']}}</div>@endif
                    </div>
                    @endforeach
                {{-- PROJECTS --}}
                @elseif($key === 'projects' && is_array($data))
                    @foreach($data as $proj)
                    <div class="project-entry">
                        <div class="project-name">{{ $proj['name'] ?? '' }}</div>
                        @if(!empty($proj['role']))<div class="project-role">{{ $proj['role'] }}</div>@endif
                        @if(!empty($proj['description']))<div class="project-desc">{{ $proj['description']}}</div>@endif
                        @if(!empty($proj['impact']))<div class="project-impact">↑ {{ $proj['impact']}}</div>@endif
                        @if(!empty($proj['technologies']))
                        <div class="tech-tags" style="margin-top:3pt;">
                            @foreach($proj['technologies'] as $tech)
                            <span class="tech-tag">{{ $tech }}</span>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach
                {{-- PUBLICATIONS --}}
                @elseif($key === 'publications' && is_array($data))
                    @foreach($data as $pub)
                    <div class="generic-entry">
                        <div class="generic-title">{{ $pub['title'] ?? '' }}</div>
                        <div class="generic-sub">{{ $pub['journal_or_venue'] ?? ''}}@if(!empty($pub['date'])) · {{ $pub['date'] }}@endif</div>
                        @if(!empty($pub['description']))<div class="exp-description">{{ $pub['description']}}</div>@endif
                    </div>
                    @endforeach
                {{-- AWARDS --}}
                @elseif($key === 'awards' && is_array($data))
                    @foreach($data as $award)
                    <div class="generic-entry">
                        <div class="generic-title">{{ $award['name'] ?? '' }}</div>
                        <div class="generic-sub">{{ $award['issuer'] ?? '' }}@if(!empty($award['date'])) · {{$award['date'] }}@endif</div>
                        @if(!empty($award['description']))<div class="exp-description">{{$award['description'] }}</div>@endif
                    </div>
                    @endforeach
                {{-- AFFILIATIONS / BOARD --}}
                @elseif(in_array($key,['affiliations','board_memberships']) && is_array($data))
                    @foreach($data as $aff)
                    <div class="generic-entry">
                        <div class="generic-title">{{ $aff['organization'] ?? '' }}</div>
                        <div class="generic-sub">{{ $aff['role'] ?? '' }}</div>
                    </div>
                    @endforeach
                {{-- THOUGHT LEADERSHIP --}}
                @elseif($key === 'thought_leadership' && is_array($data))
                    @foreach($data as $item)
                    <div class="generic-entry">
                        <div class="generic-title">{{ $item['title'] ?? '' }}</div>
                        <div class="generic-sub">{{ $item['type'] ?? '' }}@if(!empty($item['venue'])) · {{$item['venue'] }}@endif @if(!empty($item['date'])) · {{ $item['date'] }}@endif</div>
                    </div>
                    @endforeach
                {{-- PORTFOLIO / OPEN SOURCE / CAMPAIGNS / PRO BONO / GRANTS /
                CONFERENCE / TEACHING --}}
                @elseif($key === 'portfolio_highlights' && is_array($data))
                    @foreach($data as $item)
                    <div class="project-entry">
                        <div class="project-name">{{ $item['title'] ?? '' }}</div>
                        @if(!empty($item['description']))<div class="project-desc">{{ $item['description']}}</div>@endif
                        @if(!empty($item['url']))<div class="generic-sub">{{ $item['url'] }}</div>@endif
                    </div>
                    @endforeach
                @elseif($key === 'open_source_contributions' && is_array($data))
                    @foreach($data as $oss)
                    <div class="project-entry">
                        <div class="project-name">{{ $oss['project'] ?? '' }}</div>
                        @if(!empty($oss['description']))<div class="project-desc">{{ $oss['description']}}</div>@endif
                        @if(!empty($oss['impact']))<div class="project-impact">↑ {{ $oss['impact']}}</div>@endif
                    </div>
                    @endforeach
                @elseif($key === 'conference_presentations' && is_array($data))
                    @foreach($data as $conf)
                    <div class="generic-entry">
                        <div class="generic-title">{{ $conf['title'] ?? '' }}</div>
                        <div class="generic-sub">{{ $conf['event'] ?? '' }} @if(!empty($conf['date'])) · {{$conf['date'] }} @endif @if(!empty($conf['location'])) · {{ $conf['location'] }}@endif</div>
                    </div>
                    @endforeach
                @elseif($key === 'teaching_experience' && is_array($data))
                    @foreach($data as $teach)
                    <div class="generic-entry">
                        <div class="generic-title">{{ $teach['course'] ?? '' }}</div>
                        <div class="generic-sub">{{ $teach['institution'] ?? '' }}</div>
                        @if(!empty($teach['description']))<div class="exp-description">{{$teach['description'] }}</div>@endif
                    </div>
                    @endforeach
                @elseif($key === 'campaigns_highlights' && is_array($data))
                    @foreach($data as $camp)
                    <div class="project-entry">
                        <div class="project-name">{{ $camp['name'] ?? '' }}</div>
                        @if(!empty($camp['description']))<div class="project-desc">{{ $camp['description']}}</div>@endif
                        @if(!empty($camp['results']))<div class="project-impact">{{ $camp['results']}}</div>@endif
                    </div>
                    @endforeach
                @elseif($key === 'pro_bono' && is_array($data))
                    @foreach($data as $pb)
                    <div class="generic-entry">
                        <div class="generic-title">{{ $pb['organization'] ?? '' }}</div>
                        @if(!empty($pb['description']))<div class="exp-description">{{ $pb['description']}}</div>@endif
                    </div>
                    @endforeach
                @elseif($key === 'grants_funding' && is_array($data))
                    @foreach($data as $grant)
                    <div class="generic-entry">
                        <div class="generic-title">{{ $grant['title'] ?? '' }}</div>
                        <div class="generic-sub">{{ $grant['funder'] ?? '' }}@if(!empty($grant['amount'])) · {{$grant['amount'] }}@endif @if(!empty($grant['date'])) · {{ $grant['date'] }}@endif</div>
                        @if(!empty($grant['description']))<div class="exp-description">{{ $grant['description']}}</div>@endif
                    </div>
                    @endforeach
                @endif
            </div>
            @endforeach
        </div>
    </div>{{-- end body-wrapper --}}
    <div class="footer">
        <span class="footer-text">{{ $resume['full_name'] ?? '' }} &nbsp;·&nbsp; Confidential &nbsp;·&nbsp; {{ date('F Y') }}</span>
    </div>
</div>
{{-- end page --}}
</body>
</html>

