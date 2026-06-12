<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>{{ $resume['full_name'] ?? 'Resume' }}</title>
<style>
*  { box-sizing: border-box; margin: 0; padding: 0; }


body {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 12px;
    line-height: 1.6;
    color: #334155;
    background: #fff;
    margin-top: 0.5in ;


}

.content {
    margin-top: -0.5in;
}


.resume {
    width: 8.5in;
    min-height: 11in;
    margin: 0 auto;
    background: #fff;
    box-shadow: 0 20px 60px rgba(15,23,42,.18);
    padding-bottom: 0.5in ;
}

/* ── HEADER ── */
.header { position: relative; padding: 30px 52px 22px; }
.header-accent-bar { position: absolute; left: 0; top:-10px; bottom: 0; width: 5px; }
.name { font-size: 32px; font-weight: 900; letter-spacing: -1px; line-height: 1.1; }
.headline { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; margin-top: 5px; }

/* ── CONTACT BAR ── */
.contact-bar { padding: 8px 52px; font-size: 10.5px; line-height: 1.4; }
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
.section-subtitle {
    font-size: 9px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin: 1px 0 10px;
    color: #64748b;
}

/* ── SUMMARY ── */
.summary-text { font-size: 11.5px; line-height: 1.75; padding: 10px 14px; }

/* ── SKILLS ── */
.skills { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 0px; }
.skill {
    display: inline-flex;
    align-items: center;
    font-size: 10px;
    font-weight: 700;
    padding: 4px 10px;
    line-height: 1.3;
    margin: 2px 0 2px;
    white-space: nowrap;
}

/* ── EXPERIENCE ── */
.job { margin-bottom: 28px; padding-bottom: 16px; border-bottom: 0.5px solid #e5e7eb; }
.job:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
.job-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; }
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
    content: "-";
    position: absolute;
    left: 0;
    top: 1px;
    font-size: 8px;
}

.achievement-item { font-size: 10.5px; font-weight: 700; color: #059669; }

.tech-tags { margin-top: 6px; font-size: 10px; color: #94a3b8; }
.tech-tag   { display: inline; }
.tech-tag:not(:last-child)::after { content: " · "; color: #d1d5db; }

/* ── EDUCATION ── */
.edu-entry   { margin-bottom: 10px; }
.edu-degree  { font-size: 11.5px; font-weight: 900; }
.edu-inst    { font-size: 11px; margin-top: 1px; color: #475569; }
.edu-meta    { font-size: 10px; color: #9ca3af; margin-top: 1px; }
.edu-details { font-size: 10.5px; color: #64748b; margin-top: 2px; }

/* ── CERTIFICATIONS / LICENSES / BAR ── */
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
.project-tech-tag { font-size: 9.5px; font-weight: 600; padding: 2px 7px; border-radius: 5px; }

/* ── GENERIC ENTRIES (publications, awards, affiliations, etc.) ── */
.generic-entry { margin-bottom: 10px; padding-left: 8px; }
.generic-title { font-size: 11.5px; font-weight: 900; }
.generic-sub { font-size: 10.5px; color: #64748b; margin-top: 1px; }
.generic-desc { font-size: 11px; color: #475569; line-height: 1.6; margin-top: 3px; }

/* ── LANGUAGES ── */
.lang-entry { display: flex; justify-content: space-between; font-size: 11.5px; margin-bottom: 4px; }
.lang-name  { font-weight: 600; }
.lang-level { font-weight: 700; }

/* ── METRICS ── */
.metrics-grid { display: table; width: 100%; margin-bottom: 4px; table-layout: fixed; }
.metric-item { display: table-cell; text-align: center; padding: 8px 6px; border-right: 0.5px solid #e5e7eb; }
.metric-item:last-child { border-right: none; }
.metric-value { font-size: 14px; font-weight: 900; color: #111827; display: block; }
.metric-label { font-size: 9px; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-top: 2px; }
.metric-context { font-size: 9px; color: #94a3b8; margin-top: 2px; display: block; }

/* ── FOOTER ── */
.footer { padding: 10px 52px; text-align: center; font-size: 9px; color: #9ca3af; letter-spacing: 0.4px; position: fixed;
 bottom: 0px;
    left: 0;
    right: 0;
    height: 20px;

}

/* ============================================================
   THEMES (les 6 thèmes valides)
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
.modern .cert-entry, .modern .generic-entry, .modern .project { border-left: 2px solid #22d3ee; padding-left: 10px; }
.modern .cert-name, .modern .generic-title, .modern .project-name { color: #0f172a; }
.modern .project-tech-tag { background: #f0f9ff; border: 1px solid #bae6fd; color: #0369a1; }
.modern .lang-level       { color: #0ea5e9; }
.modern .footer           { background: #f0f9ff; border-top: 1px solid #bae6fd; }
.modern .metric-value     { color: #0f172a; }

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
.corporate .cert-entry, .corporate .generic-entry, .corporate .project { border-left: 2px solid #cbd5e1; padding-left: 10px; }
.corporate .cert-name, .corporate .generic-title, .corporate .project-name { color: #0f172a; }
.corporate .project-tech-tag { background: #f1f5f9; border: 1px solid #cbd5e1; color: #0f172a; }
.corporate .lang-level    { color: #334155; }
.corporate .footer        { background: #f1f5f9; border-top: 1px solid #cbd5e1; }
.corporate .metric-value  { color: #0f172a; }

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
.minimal .cert-entry, .minimal .generic-entry, .minimal .project { border-left: 2px solid #e5e7eb; padding-left: 10px; }
.minimal .cert-name, .minimal .generic-title, .minimal .project-name { color: #111827; }
.minimal .project-tech-tag{ background: #fff; border: 1px solid #e5e7eb; color: #374151; }
.minimal .lang-level      { color: #374151; }
.minimal .footer          { background: #f9fafb; border-top: 1px solid #e5e7eb; }
.minimal .metric-value    { color: #111827; }

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
.tech .cert-entry, .tech .generic-entry, .tech .project { border-left: 2px solid #3b82f6; padding-left: 10px; }
.tech .cert-name, .tech .generic-title, .tech .project-name { color: #1e3a5f; }
.tech .project-tech-tag   { background: #eff6ff; border: 1px solid #bfdbfe; color: #1d4ed8; }
.tech .lang-level         { color: #2563eb; }
.tech .footer             { background: #eff6ff; border-top: 1px solid #bfdbfe; }
.tech .metric-value       { color: #1e3a5f; }

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
.executive .cert-entry, .executive .generic-entry, .executive .project { border-left: 2px solid #c9a84c; padding-left: 10px; }
.executive .cert-name, .executive .generic-title, .executive .project-name { color: #0a0a0a; font-family: Georgia, serif; }
.executive .project-tech-tag { background: #fbf7ee; border: 1px solid #e7d9b0; color: #713f12; }
.executive .lang-level    { color: #92400e; }
.executive .footer        { background: #fdf8ee; border-top: 1px solid #e7d9b0; }
.executive .metric-value  { color: #0a0a0a; }

/* ── ACADEMIC ── */
.academic                { border-top: 10px solid #818cf8; }
.academic .header        { background: #ffffff; border-bottom: 2px solid #4338ca; }
.academic .name          { color: #1e1b4b; font-family: Georgia, serif; }
.academic .headline      { color: #4338ca; }
.academic .contact-bar   { background: #fafaf7; color: #78716c; border-bottom: 1px solid #e7d9b0; }
.academic .contact-sep   { color: #818cf8; }
.academic .section-title { color: #4338ca; border-bottom: 1.5px solid #818cf8; }
.academic .summary-text  { background: #eef2ff; border-left: 3px solid #4338ca; color: #1e1b4b; }
.academic .skill         { background: #eef2ff; border: 1px solid #c7d2fe; color: #4338ca; border-radius: 7px; }
.academic .job-title     { color: #1e1b4b; font-family: Georgia, serif; }
.academic .company       { color: #4338ca; }
.academic .date          { color: #78716c; font-weight: 400; }
.academic .bullet-list li::before { color: #818cf8; }
.academic .cert-entry, .academic .generic-entry, .academic .project { border-left: 2px solid #818cf8; padding-left: 10px; }
.academic .cert-name, .academic .generic-title, .academic .project-name { color: #1e1b4b; font-family: Georgia, serif; }
.academic .project-tech-tag { background: #eef2ff; border: 1px solid #c7d2fe; color: #4338ca; }
.academic .lang-level    { color: #4338ca; }
.academic .footer        { background: #ffffff; border-top: 1px solid #e7d9b0; }
.academic .metric-value  { color: #1e1b4b; }

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
<div class="content">
@php

/* ============================================================
   HELPERS
   ============================================================ */

function findSection(array $sections, string $key): ?array {
    foreach ($sections as $section) {
        if (($section['section_key'] ?? null) === $key) {
            return $section;
        }
    }
    return null;
}

/**
 * Formate date_start / date_end (flat fields, conforme au prompt)
 */
function formatFlatDates(?string $start, ?string $end): string {
    $end = $end ?: 'Present';
    if (!empty($start)) {
        return "{$start} – {$end}";
    }
    return $end ?: '';
}

/**
 * Explose une chaine pipe-séparée et filtre les vides
 */
function parsePipeList(?string $raw): array {
    if (empty($raw)) return [];
    return array_values(array_filter(array_map('trim', explode('|', $raw))));
}

/**
 * Explose une chaine virgule-séparée et filtre les vides
 */
function parseCommaList(?string $raw): array {
    if (empty($raw)) return [];
    return array_values(array_filter(array_map('trim', explode(',', $raw))));
}

/**
 * Liste ordonnée des labels de sections pour affichage par défaut
 */
function defaultLabel(string $key): string {
    return ucwords(str_replace('_', ' ', $key));
}

$validThemes = ['modern', 'corporate', 'minimal', 'tech', 'executive', 'academic'];

/* ============================================================
   THÈME — priorité : $theme injecté > schema_type > détection > 'modern'
   ============================================================ */
$schemaType = $resume['schema_type'] ?? 'other';
$profileKey = strtolower($theme ?? $schemaType);

// mapping schema_type -> profileKey pour le skillLabelMap
$schemaToProfile = [
    'software_engineering'      => 'tech',
    'product_management'        => 'tech',
    'design_ux'                 => 'tech',
    'data_analytics'            => 'tech',
    'finance_accounting'         => 'finance',
    'sales_business_dev'        => 'executive',
    'marketing_growth'          => 'executive',
    'operations_supply_chain'   => 'executive',
    'human_resources'           => 'executive',
    'healthcare_clinical'       => 'healthcare',
    'engineering_infrastructure'=> 'tech',
    'legal_compliance'          => 'legal',
    'education_research'        => 'academic',
    'executive_leadership'      => 'executive',
    'consulting_strategy'       => 'executive',
    'creative_media'            => 'executive',
    'other'                      => 'tech',
];

if (!in_array($profileKey, $validThemes)) {
    $profileKey = $schemaToProfile[$schemaType] ?? 'tech';

    $headline = strtolower($resume['headline'] ?? '');
    if (preg_match('/research|phd|professor|postdoc|faculty|academic|scientist/i', $headline)) {
        $profileKey = 'academic';
    } elseif (preg_match('/cfo|ceo|vp |chief|managing director|partner|principal|c-suite|svp|evp/i', $headline)) {
        $profileKey = 'executive';
    } elseif (preg_match('/attorney|counsel|associate|law|legal|compliance|regulatory/i', $headline)) {
        $profileKey = 'legal';
    } elseif (preg_match('/physician|md |doctor|nurse|clinical|healthcare|pharma|rn |pa |np /i', $headline)) {
        $profileKey = 'healthcare';
    } elseif (preg_match('/finance|banking|equity|analyst|portfolio|investment|fund|quant|trader/i', $headline)) {
        $profileKey = 'finance';
    }
}

/* ============================================================
   THEME KEY — choix du thème visuel (parmi les 6 valides)
   ============================================================ */
$profileToTheme = [
    'tech'       => 'tech',
    'finance'    => 'corporate',
    'executive'  => 'executive',
    'healthcare' => 'minimal',
    'legal'      => 'corporate',
    'academic'   => 'academic',
];

$themeKey = $theme ?? null;
if (empty($themeKey) || !in_array($themeKey, $validThemes)) {
    $themeKey = $profileToTheme[$profileKey] ?? 'modern';
}
if (!in_array($themeKey, $validThemes)) {
    $themeKey = 'modern';
}

/* ============================================================
   ADAPTIVE SKILL LABELS — inchangé, piloté par $profileKey
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

// Mapping global pour les sous-groupes du schema skills (universel)
$skillsKeyLabelMap = [
    'technical'             => $activeSkillLabels['languages'] ?? 'Technical Skills',
    'soft'                  => 'Soft Skills',
    'tools'                 => $activeSkillLabels['tools'] ?? 'Tools',
    'platforms'             => $activeSkillLabels['cloud_infra'] ?? 'Platforms',
    'methodologies'         => $activeSkillLabels['practices'] ?? 'Methodologies',
    'domain_expertise'      => 'Domain Expertise',
    'languages_programming' => 'Programming Languages',
    'frameworks'            => 'Frameworks',
    'databases'             => 'Databases',
    'cloud_devops'          => 'Cloud & DevOps',
    'clinical_skills'       => $activeSkillLabels['languages'] ?? 'Clinical Skills',
    'financial_skills'      => $activeSkillLabels['languages'] ?? 'Financial Skills',
    'legal_skills'          => $activeSkillLabels['languages'] ?? 'Legal Skills',
    'design_skills'         => 'Design Skills',
    'marketing_skills'      => 'Marketing Skills',
];

$technicalCompetenciesKeyLabelMap = [
    'specializations' => $activeSkillLabels['languages'] ?? 'Specializations',
    'standards'       => $activeSkillLabels['practices'] ?? 'Standards',
    'software'        => $activeSkillLabels['tools'] ?? 'Software',
    'methodologies'   => $activeSkillLabels['practices'] ?? 'Methodologies',
];

/* ============================================================
   EXTRACTION DES SECTIONS
   ============================================================ */
$sections = $resume['sections'] ?? [];

$contactData = findSection($sections, 'contact')['data'] ?? [];

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

$metricsSection = findSection($sections, 'metrics_highlights')['data'] ?? [];
$languages   = findSection($sections, 'languages')['data'] ?? [];
$summaryData = findSection($sections, 'professional_summary')['data'] ?? [];


/* sections à ignorer dans le rendu générique (contact/summary/metrics/languages traités à part) */
$handledSeparately = ['contact', 'professional_summary', 'metrics_highlights', 'languages'];

@endphp

{{-- <div class="resume {{ $themeKey }}"> --}}
<div class="resume executive">


    {{-- ══════════════════════════
         HEADER
    ══════════════════════════ --}}
    <div class="header">

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
         CORPS DU CV — MONOBLOC, ordre = $sections
    ══════════════════════════ --}}
    <div class="body">
        @foreach($sections as $section)
            @php
                $key  = $section['section_key'] ?? '';
                $data = $section['data'] ?? [];
                $label = $section['section_label'] ?? defaultLabel($key);
            @endphp

            @if(in_array($key, $handledSeparately))
                {{-- ── PROFESSIONAL SUMMARY ── --}}
                @if($key == 'professional_summary')

                    @if(is_array($data) && count($data) )
                    <div class="section">
                        <div class="section-title">
                            @if($themeKey === 'academic') Research Statement
                            @elseif($themeKey === 'executive') Executive Profile
                            @else Professional Summary
                            @endif
                        </div>
                        <div class="summary-text">{{ $data['text'] }}</div>
                    </div>
                    @endif
                @elseif($key === 'metrics_highlights')
                    @if(is_array($data) && count($data))
                    <div class="section">
                        <div class="section-title">{{ $label }}</div>
                        <div class="metrics-grid">
                            @foreach($data as $metric)
                            <div class="metric-item">
                                <span class="metric-value">{{ $metric['value'] ?? '' }}</span>
                                <span class="metric-label">{{ $metric['label'] ?? '' }}</span>
                                @if(!empty($metric['context']))
                                    <span class="metric-context">{{ $metric['context'] }}</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                @endif
            @endif
        @endforeach


        @foreach($sections as $section)
            @php
                $key  = $section['section_key'] ?? '';
                $data = $section['data'] ?? [];
                $label = $section['section_label'] ?? defaultLabel($key);
            @endphp

            @if(in_array($key, $handledSeparately))
                @continue
            @endif

            {{-- ── SKILLS (object: technical, soft, tools, ...) ── --}}
            @if($key === 'skills')
                @if(is_array($data) && count(array_filter($data)))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $groupKey => $items)
                        @if(is_array($items) && count($items))
                            <div class="section-subtitle">{{ $skillsKeyLabelMap[$groupKey] ?? defaultLabel($groupKey) }}</div>
                            <div class="skills">
                                @foreach($items as $skill)
                                    <span class="skill">{{ $skill }}</span>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
                @endif

            {{-- ── TECHNICAL COMPETENCIES (object grouped) ── --}}
            @elseif($key === 'technical_competencies')
                @if(is_array($data) && count(array_filter($data)))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $groupKey => $items)
                        @if(is_array($items) && count($items))
                            <div class="section-subtitle">{{ $technicalCompetenciesKeyLabelMap[$groupKey] ?? defaultLabel($groupKey) }}</div>
                            <div class="skills">
                                @foreach($items as $item)
                                    <span class="skill">{{ $item }}</span>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
                @endif

            {{-- ── TOOLS EXPERTISE (array of {category, tools(csv)}) ── --}}
            @elseif($key === 'tools_expertise')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $group)
                        @if(!empty($group['category']))
                            <div class="section-subtitle">{{ $group['category'] }}</div>
                        @endif
                        @php $toolList = parseCommaList($group['tools'] ?? null); @endphp
                        @if(count($toolList))
                            <div class="skills">
                                @foreach($toolList as $tool)
                                    <span class="skill">{{ $tool }}</span>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
                @endif

            {{-- ── CLINICAL SKILLS (array of {category, skills(csv)}) ── --}}
            @elseif($key === 'clinical_skills')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $group)
                        @if(!empty($group['category']))
                            <div class="section-subtitle">{{ $group['category'] }}</div>
                        @endif
                        @php $skillList = parseCommaList($group['skills'] ?? null); @endphp
                        @if(count($skillList))
                            <div class="skills">
                                @foreach($skillList as $sk)
                                    <span class="skill">{{ $sk }}</span>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                </div>
                @endif

            {{-- ── PROFESSIONAL EXPERIENCE / RESEARCH EXPERIENCE ── --}}
            @elseif(in_array($key, ['professional_experience','research_experience']))
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $exp)
                        @php
                            $bullets  = parsePipeList($exp['bullets'] ?? null);
                            $achievs  = parsePipeList($exp['achievements'] ?? null);
                            $techTags = parseCommaList($exp['technologies'] ?? null);
                            $dateStr  = formatFlatDates($exp['date_start'] ?? null, $exp['date_end'] ?? null);
                        @endphp
                        <div class="job">
                            <div class="job-head">
                                <div>
                                    @if(!empty($exp['title']))
                                        <div class="job-title">{{ $exp['title'] }}</div>
                                    @endif
                                    @if(!empty($exp['company']) || !empty($exp['institution']))
                                        <div class="company">
                                            {{ $exp['company'] ?? $exp['institution'] ?? '' }}
                                            @if(!empty($exp['location']))
                                                <span class="exp-location">— {{ $exp['location'] }}</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                @if(!empty($dateStr))
                                    <div class="date">{{ $dateStr }}</div>
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

                            @if(count($achievs))
                            <div style="margin-top:5px;">
                                @foreach($achievs as $ach)
                                    <span class="achievement-item"> {{ $ach }}@if(!$loop->last) | @endif</span>
                                @endforeach
                            </div>
                            @endif

                            @if(count($techTags))
                            <div class="tech-tags">
                                @foreach($techTags as $tech)
                                    <span class="tech-tag">{{ $tech }}@if(!$loop->last) . @endif</span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── EDUCATION ── --}}
            @elseif($key === 'education')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $edu)
                        @php
                            $eduMeta = [];
                            $dateStr = formatFlatDates($edu['date_start'] ?? null, $edu['date_end'] ?? null);
                            if (!empty($dateStr)) $eduMeta[] = $dateStr;
                            if (!empty($edu['honors'])) $eduMeta[] = $edu['honors'];
                            if (!empty($edu['gpa']))    $eduMeta[] = 'GPA: ' . $edu['gpa'];
                        @endphp
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
            @elseif($key === 'certifications')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $cert)
                        <div class="cert-entry">
                            <div class="cert-name">{{ $cert['name'] ?? '' }}</div>
                            @if(!empty($cert['issuer']))
                                <div class="cert-issuer">{{ $cert['issuer'] }}</div>
                            @endif
                            @if(!empty($cert['date']) || !empty($cert['expiration']))
                                <div class="cert-date">
                                    {{ $cert['date'] ?? '' }}
                                    @if(!empty($cert['expiration'])) — Exp. {{ $cert['expiration'] }}@endif
                                </div>
                            @endif
                            @if(!empty($cert['credential_id']))
                                <div class="cert-date">ID: {{ $cert['credential_id'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── LICENSES ── --}}
            @elseif($key === 'licenses')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $lic)
                        <div class="cert-entry">
                            <div class="cert-name">{{ $lic['name'] ?? '' }}</div>
                            <div class="cert-issuer">
                                {{ $lic['issuer'] ?? '' }}
                                @if(!empty($lic['state_or_region'])) — {{ $lic['state_or_region'] }}@endif
                            </div>
                            <div class="cert-date">
                                @if(!empty($lic['number'])) #{{ $lic['number'] }} · @endif
                                {{ $lic['date'] ?? '' }}
                                @if(!empty($lic['expiration'])) — Exp. {{ $lic['expiration'] }}@endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── BAR ADMISSIONS ── --}}
            @elseif($key === 'bar_admissions')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $bar)
                        <div class="cert-entry">
                            <div class="cert-name">{{ $bar['jurisdiction'] ?? '' }}</div>
                            <div class="cert-issuer">{{ $bar['status'] ?? '' }}</div>
                            @if(!empty($bar['date']))
                                <div class="cert-date">{{ $bar['date'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── PROJECTS ── --}}
            @elseif($key === 'projects')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $proj)
                        @php
                            $techList = parseCommaList($proj['technologies'] ?? null);
                            $dateStr  = formatFlatDates($proj['date_start'] ?? null, $proj['date_end'] ?? null);
                        @endphp
                        <div class="project">
                            <div class="job-head">
                                <div class="project-name">{{ $proj['name'] ?? '' }}</div>
                                @if(!empty($dateStr))
                                    <div class="date">{{ $dateStr }}</div>
                                @endif
                            </div>
                            @if(!empty($proj['role']))
                                <div class="project-role">{{ $proj['role'] }}</div>
                            @endif
                            @if(!empty($proj['description']))
                                <div class="project-desc">{{ $proj['description'] }}</div>
                            @endif
                            @if(!empty($proj['impact']))
                                <div class="project-impact">↑ {{ $proj['impact'] }}</div>
                            @endif
                            @if(count($techList))
                            <div class="project-tech">
                                @foreach($techList as $tech)
                                    <span class="project-tech-tag">{{ $tech }}</span>
                                @endforeach
                            </div>
                            @endif
                            @if(!empty($proj['url']))
                                <div class="generic-sub">{{ $proj['url'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── PUBLICATIONS ── --}}
            @elseif($key === 'publications')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $pub)
                        <div class="generic-entry">
                            <div class="generic-title">{{ $pub['title'] ?? '' }}</div>
                            <div class="generic-sub">
                                {{ $pub['journal_or_venue'] ?? '' }}
                                @if(!empty($pub['authors'])) · {{ $pub['authors'] }}@endif
                                @if(!empty($pub['date'])) · {{ $pub['date'] }}@endif
                            </div>
                            @if(!empty($pub['description']))
                                <div class="generic-desc">{{ $pub['description'] }}</div>
                            @endif
                            @if(!empty($pub['url']))
                                <div class="generic-sub">{{ $pub['url'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── OPEN SOURCE CONTRIBUTIONS ── --}}
            @elseif($key === 'open_source_contributions')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $oss)
                        <div class="project">
                            <div class="project-name">{{ $oss['project'] ?? '' }}</div>
                            @if(!empty($oss['description']))
                                <div class="project-desc">{{ $oss['description'] }}</div>
                            @endif
                            @if(!empty($oss['impact']))
                                <div class="project-impact">↑ {{ $oss['impact'] }}</div>
                            @endif
                            @if(!empty($oss['url']))
                                <div class="generic-sub">{{ $oss['url'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── TEACHING EXPERIENCE ── --}}
            @elseif($key === 'teaching_experience')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $teach)
                        @php $dateStr = formatFlatDates($teach['date_start'] ?? null, $teach['date_end'] ?? null); @endphp
                        <div class="generic-entry">
                            <div class="generic-title">{{ $teach['course'] ?? '' }}</div>
                            <div class="generic-sub">
                                {{ $teach['institution'] ?? '' }}
                                @if(!empty($dateStr)) · {{ $dateStr }}@endif
                            </div>
                            @if(!empty($teach['description']))
                                <div class="generic-desc">{{ $teach['description'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── GRANTS & FUNDING ── --}}
            @elseif($key === 'grants_funding')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $grant)
                        <div class="generic-entry">
                            <div class="generic-title">{{ $grant['title'] ?? '' }}</div>
                            <div class="generic-sub">
                                {{ $grant['funder'] ?? '' }}
                                @if(!empty($grant['amount'])) · {{ $grant['amount'] }}@endif
                                @if(!empty($grant['date'])) · {{ $grant['date'] }}@endif
                            </div>
                            @if(!empty($grant['description']))
                                <div class="generic-desc">{{ $grant['description'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── CONFERENCE PRESENTATIONS ── --}}
            @elseif($key === 'conference_presentations')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $conf)
                        <div class="generic-entry">
                            <div class="generic-title">{{ $conf['title'] ?? '' }}</div>
                            <div class="generic-sub">
                                {{ $conf['event'] ?? '' }}
                                @if(!empty($conf['date'])) · {{ $conf['date'] }}@endif
                                @if(!empty($conf['location'])) · {{ $conf['location'] }}@endif
                            </div>
                            @if(!empty($conf['url']))
                                <div class="generic-sub">{{ $conf['url'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── BOARD MEMBERSHIPS / AFFILIATIONS ── --}}
            @elseif(in_array($key, ['board_memberships','affiliations']))
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $aff)
                        @php $dateStr = formatFlatDates($aff['date_start'] ?? null, $aff['date_end'] ?? null); @endphp
                        <div class="generic-entry">
                            <div class="generic-title">{{ $aff['organization'] ?? '' }}</div>
                            <div class="generic-sub">
                                {{ $aff['role'] ?? '' }}
                                @if(!empty($dateStr)) · {{ $dateStr }}@endif
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── AWARDS ── --}}
            @elseif($key === 'awards')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $award)
                        <div class="generic-entry">
                            <div class="generic-title">{{ $award['name'] ?? '' }}</div>
                            <div class="generic-sub">
                                {{ $award['issuer'] ?? '' }}
                                @if(!empty($award['date'])) · {{ $award['date'] }}@endif
                            </div>
                            @if(!empty($award['description']))
                                <div class="generic-desc">{{ $award['description'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── PORTFOLIO HIGHLIGHTS ── --}}
            @elseif($key === 'portfolio_highlights')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $item)
                        <div class="project">
                            <div class="project-name">{{ $item['title'] ?? '' }}</div>
                            @if(!empty($item['description']))
                                <div class="project-desc">{{ $item['description'] }}</div>
                            @endif
                            @if(!empty($item['url']))
                                <div class="generic-sub">{{ $item['url'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── CAMPAIGNS HIGHLIGHTS ── --}}
            @elseif($key === 'campaigns_highlights')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $camp)
                        @php $dateStr = formatFlatDates($camp['date_start'] ?? null, $camp['date_end'] ?? null); @endphp
                        <div class="project">
                            <div class="job-head">
                                <div class="project-name">{{ $camp['name'] ?? '' }}</div>
                                @if(!empty($dateStr))
                                    <div class="date">{{ $dateStr }}</div>
                                @endif
                            </div>
                            @if(!empty($camp['description']))
                                <div class="project-desc">{{ $camp['description'] }}</div>
                            @endif
                            @if(!empty($camp['results']))
                                <div class="project-impact">{{ $camp['results'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── THOUGHT LEADERSHIP ── --}}
            @elseif($key === 'thought_leadership')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $tl)
                        <div class="generic-entry">
                            <div class="generic-title">{{ $tl['title'] ?? '' }}</div>
                            <div class="generic-sub">
                                {{ $tl['type'] ?? '' }}
                                @if(!empty($tl['venue'])) · {{ $tl['venue'] }}@endif
                                @if(!empty($tl['date'])) · {{ $tl['date'] }}@endif
                            </div>
                            @if(!empty($tl['url']))
                                <div class="generic-sub">{{ $tl['url'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            {{-- ── PRO BONO ── --}}
            @elseif($key === 'pro_bono')
                @if(is_array($data) && count($data))
                <div class="section">
                    <div class="section-title">{{ $label }}</div>
                    @foreach($data as $pb)
                        @php $dateStr = formatFlatDates($pb['date_start'] ?? null, $pb['date_end'] ?? null); @endphp
                        <div class="generic-entry">
                            <div class="generic-title">{{ $pb['organization'] ?? '' }}</div>
                            @if(!empty($dateStr))
                                <div class="generic-sub">{{ $dateStr }}</div>
                            @endif
                            @if(!empty($pb['description']))
                                <div class="generic-desc">{{ $pb['description'] }}</div>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

            @endif
        @endforeach

        {{-- ── LANGUAGES (toujours en fin) ── --}}
        @if(is_array($languages) && count($languages))
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

    </div>{{-- end .body --}}

    {{-- ══════════════════════════
         FOOTER
    ══════════════════════════ --}}
    <div class="footer">
        {{ $resume['full_name'] ?? '' }} &nbsp;·&nbsp;
    </div>

</div>{{-- end .resume --}}
</div>
</body>
</html>
