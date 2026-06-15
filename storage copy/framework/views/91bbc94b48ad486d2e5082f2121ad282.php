<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?php echo e($resume['full_name'] ?? 'Resume'); ?></title>
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
<?php

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

?>


<div class="resume executive">


    
    <div class="header">

        <?php if(in_array($themeKey, ['modern','tech'])): ?>
            <div class="header-accent-bar"></div>
        <?php endif; ?>

        <div class="name"><?php echo e($resume['full_name'] ?? ''); ?></div>

        <?php if(!empty($resume['headline'])): ?>
            <div class="headline"><?php echo e($resume['headline']); ?></div>
        <?php endif; ?>

    </div>

    
    <?php if(count($contactItems)): ?>
    <div class="contact-bar">
        <?php $__currentLoopData = $contactItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($i > 0): ?><span class="contact-sep">•</span><?php endif; ?>
            <?php echo e($item); ?>

        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>

    
    <div class="body">
        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $key  = $section['section_key'] ?? '';
                $data = $section['data'] ?? [];
                $label = $section['section_label'] ?? defaultLabel($key);
            ?>

            <?php if(in_array($key, $handledSeparately)): ?>
                
                <?php if($key == 'professional_summary'): ?>

                    <?php if(is_array($data) && count($data) ): ?>
                    <div class="section">
                        <div class="section-title">
                            <?php if($themeKey === 'academic'): ?> Research Statement
                            <?php elseif($themeKey === 'executive'): ?> Executive Profile
                            <?php else: ?> Professional Summary
                            <?php endif; ?>
                        </div>
                        <div class="summary-text"><?php echo e($data['text']); ?></div>
                    </div>
                    <?php endif; ?>
                <?php elseif($key === 'metrics_highlights'): ?>
                    <?php if(is_array($data) && count($data)): ?>
                    <div class="section">
                        <div class="section-title"><?php echo e($label); ?></div>
                        <div class="metrics-grid">
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metric): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="metric-item">
                                <span class="metric-value"><?php echo e($metric['value'] ?? ''); ?></span>
                                <span class="metric-label"><?php echo e($metric['label'] ?? ''); ?></span>
                                <?php if(!empty($metric['context'])): ?>
                                    <span class="metric-context"><?php echo e($metric['context']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $key  = $section['section_key'] ?? '';
                $data = $section['data'] ?? [];
                $label = $section['section_label'] ?? defaultLabel($key);
            ?>

            <?php if(in_array($key, $handledSeparately)): ?>
                <?php continue; ?>
            <?php endif; ?>

            
            <?php if($key === 'skills'): ?>
                <?php if(is_array($data) && count(array_filter($data))): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_array($items) && count($items)): ?>
                            <div class="section-subtitle"><?php echo e($skillsKeyLabelMap[$groupKey] ?? defaultLabel($groupKey)); ?></div>
                            <div class="skills">
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $skill): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="skill"><?php echo e($skill); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'technical_competencies'): ?>
                <?php if(is_array($data) && count(array_filter($data))): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupKey => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(is_array($items) && count($items)): ?>
                            <div class="section-subtitle"><?php echo e($technicalCompetenciesKeyLabelMap[$groupKey] ?? defaultLabel($groupKey)); ?></div>
                            <div class="skills">
                                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="skill"><?php echo e($item); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'tools_expertise'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($group['category'])): ?>
                            <div class="section-subtitle"><?php echo e($group['category']); ?></div>
                        <?php endif; ?>
                        <?php $toolList = parseCommaList($group['tools'] ?? null); ?>
                        <?php if(count($toolList)): ?>
                            <div class="skills">
                                <?php $__currentLoopData = $toolList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tool): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="skill"><?php echo e($tool); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'clinical_skills'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if(!empty($group['category'])): ?>
                            <div class="section-subtitle"><?php echo e($group['category']); ?></div>
                        <?php endif; ?>
                        <?php $skillList = parseCommaList($group['skills'] ?? null); ?>
                        <?php if(count($skillList)): ?>
                            <div class="skills">
                                <?php $__currentLoopData = $skillList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="skill"><?php echo e($sk); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif(in_array($key, ['professional_experience','research_experience'])): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $bullets  = parsePipeList($exp['bullets'] ?? null);
                            $achievs  = parsePipeList($exp['achievements'] ?? null);
                            $techTags = parseCommaList($exp['technologies'] ?? null);
                            $dateStr  = formatFlatDates($exp['date_start'] ?? null, $exp['date_end'] ?? null);
                        ?>
                        <div class="job">
                            <div class="job-head">
                                <div>
                                    <?php if(!empty($exp['title'])): ?>
                                        <div class="job-title"><?php echo e($exp['title']); ?></div>
                                    <?php endif; ?>
                                    <?php if(!empty($exp['company']) || !empty($exp['institution'])): ?>
                                        <div class="company">
                                            <?php echo e($exp['company'] ?? $exp['institution'] ?? ''); ?>

                                            <?php if(!empty($exp['location'])): ?>
                                                <span class="exp-location">— <?php echo e($exp['location']); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <?php if(!empty($dateStr)): ?>
                                    <div class="date"><?php echo e($dateStr); ?></div>
                                <?php endif; ?>
                            </div>

                            <?php if(!empty($exp['description'])): ?>
                                <div class="job-description"><?php echo e($exp['description']); ?></div>
                            <?php endif; ?>

                            <?php if(count($bullets)): ?>
                            <ul class="bullet-list">
                                <?php $__currentLoopData = $bullets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bullet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><?php echo e($bullet); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                            <?php endif; ?>

                            <?php if(count($achievs)): ?>
                            <div style="margin-top:5px;">
                                <?php $__currentLoopData = $achievs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="achievement-item"> <?php echo e($ach); ?><?php if(!$loop->last): ?> | <?php endif; ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>

                            <?php if(count($techTags)): ?>
                            <div class="tech-tags">
                                <?php $__currentLoopData = $techTags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="tech-tag"><?php echo e($tech); ?><?php if(!$loop->last): ?> . <?php endif; ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'education'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $edu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $eduMeta = [];
                            $dateStr = formatFlatDates($edu['date_start'] ?? null, $edu['date_end'] ?? null);
                            if (!empty($dateStr)) $eduMeta[] = $dateStr;
                            if (!empty($edu['honors'])) $eduMeta[] = $edu['honors'];
                            if (!empty($edu['gpa']))    $eduMeta[] = 'GPA: ' . $edu['gpa'];
                        ?>
                        <div class="edu-entry">
                            <div class="edu-degree">
                                <?php echo e($edu['degree'] ?? ''); ?>

                                <?php if(!empty($edu['field'])): ?>, <?php echo e($edu['field']); ?><?php endif; ?>
                            </div>
                            <div class="edu-inst">
                                <?php echo e($edu['institution'] ?? ''); ?>

                                <?php if(!empty($edu['location'])): ?>
                                    <span style="color:#94a3b8"> — <?php echo e($edu['location']); ?></span>
                                <?php endif; ?>
                            </div>
                            <?php if(count($eduMeta)): ?>
                                <div class="edu-meta"><?php echo e(implode(' · ', $eduMeta)); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($edu['details'])): ?>
                                <div class="edu-details"><?php echo e($edu['details']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'certifications'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cert-entry">
                            <div class="cert-name"><?php echo e($cert['name'] ?? ''); ?></div>
                            <?php if(!empty($cert['issuer'])): ?>
                                <div class="cert-issuer"><?php echo e($cert['issuer']); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($cert['date']) || !empty($cert['expiration'])): ?>
                                <div class="cert-date">
                                    <?php echo e($cert['date'] ?? ''); ?>

                                    <?php if(!empty($cert['expiration'])): ?> — Exp. <?php echo e($cert['expiration']); ?><?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <?php if(!empty($cert['credential_id'])): ?>
                                <div class="cert-date">ID: <?php echo e($cert['credential_id']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'licenses'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cert-entry">
                            <div class="cert-name"><?php echo e($lic['name'] ?? ''); ?></div>
                            <div class="cert-issuer">
                                <?php echo e($lic['issuer'] ?? ''); ?>

                                <?php if(!empty($lic['state_or_region'])): ?> — <?php echo e($lic['state_or_region']); ?><?php endif; ?>
                            </div>
                            <div class="cert-date">
                                <?php if(!empty($lic['number'])): ?> #<?php echo e($lic['number']); ?> · <?php endif; ?>
                                <?php echo e($lic['date'] ?? ''); ?>

                                <?php if(!empty($lic['expiration'])): ?> — Exp. <?php echo e($lic['expiration']); ?><?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'bar_admissions'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="cert-entry">
                            <div class="cert-name"><?php echo e($bar['jurisdiction'] ?? ''); ?></div>
                            <div class="cert-issuer"><?php echo e($bar['status'] ?? ''); ?></div>
                            <?php if(!empty($bar['date'])): ?>
                                <div class="cert-date"><?php echo e($bar['date']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'projects'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $proj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $techList = parseCommaList($proj['technologies'] ?? null);
                            $dateStr  = formatFlatDates($proj['date_start'] ?? null, $proj['date_end'] ?? null);
                        ?>
                        <div class="project">
                            <div class="job-head">
                                <div class="project-name"><?php echo e($proj['name'] ?? ''); ?></div>
                                <?php if(!empty($dateStr)): ?>
                                    <div class="date"><?php echo e($dateStr); ?></div>
                                <?php endif; ?>
                            </div>
                            <?php if(!empty($proj['role'])): ?>
                                <div class="project-role"><?php echo e($proj['role']); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($proj['description'])): ?>
                                <div class="project-desc"><?php echo e($proj['description']); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($proj['impact'])): ?>
                                <div class="project-impact">↑ <?php echo e($proj['impact']); ?></div>
                            <?php endif; ?>
                            <?php if(count($techList)): ?>
                            <div class="project-tech">
                                <?php $__currentLoopData = $techList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tech): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <span class="project-tech-tag"><?php echo e($tech); ?></span>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php endif; ?>
                            <?php if(!empty($proj['url'])): ?>
                                <div class="generic-sub"><?php echo e($proj['url']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'publications'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="generic-entry">
                            <div class="generic-title"><?php echo e($pub['title'] ?? ''); ?></div>
                            <div class="generic-sub">
                                <?php echo e($pub['journal_or_venue'] ?? ''); ?>

                                <?php if(!empty($pub['authors'])): ?> · <?php echo e($pub['authors']); ?><?php endif; ?>
                                <?php if(!empty($pub['date'])): ?> · <?php echo e($pub['date']); ?><?php endif; ?>
                            </div>
                            <?php if(!empty($pub['description'])): ?>
                                <div class="generic-desc"><?php echo e($pub['description']); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($pub['url'])): ?>
                                <div class="generic-sub"><?php echo e($pub['url']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'open_source_contributions'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $oss): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="project">
                            <div class="project-name"><?php echo e($oss['project'] ?? ''); ?></div>
                            <?php if(!empty($oss['description'])): ?>
                                <div class="project-desc"><?php echo e($oss['description']); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($oss['impact'])): ?>
                                <div class="project-impact">↑ <?php echo e($oss['impact']); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($oss['url'])): ?>
                                <div class="generic-sub"><?php echo e($oss['url']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'teaching_experience'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teach): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $dateStr = formatFlatDates($teach['date_start'] ?? null, $teach['date_end'] ?? null); ?>
                        <div class="generic-entry">
                            <div class="generic-title"><?php echo e($teach['course'] ?? ''); ?></div>
                            <div class="generic-sub">
                                <?php echo e($teach['institution'] ?? ''); ?>

                                <?php if(!empty($dateStr)): ?> · <?php echo e($dateStr); ?><?php endif; ?>
                            </div>
                            <?php if(!empty($teach['description'])): ?>
                                <div class="generic-desc"><?php echo e($teach['description']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'grants_funding'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="generic-entry">
                            <div class="generic-title"><?php echo e($grant['title'] ?? ''); ?></div>
                            <div class="generic-sub">
                                <?php echo e($grant['funder'] ?? ''); ?>

                                <?php if(!empty($grant['amount'])): ?> · <?php echo e($grant['amount']); ?><?php endif; ?>
                                <?php if(!empty($grant['date'])): ?> · <?php echo e($grant['date']); ?><?php endif; ?>
                            </div>
                            <?php if(!empty($grant['description'])): ?>
                                <div class="generic-desc"><?php echo e($grant['description']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'conference_presentations'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $conf): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="generic-entry">
                            <div class="generic-title"><?php echo e($conf['title'] ?? ''); ?></div>
                            <div class="generic-sub">
                                <?php echo e($conf['event'] ?? ''); ?>

                                <?php if(!empty($conf['date'])): ?> · <?php echo e($conf['date']); ?><?php endif; ?>
                                <?php if(!empty($conf['location'])): ?> · <?php echo e($conf['location']); ?><?php endif; ?>
                            </div>
                            <?php if(!empty($conf['url'])): ?>
                                <div class="generic-sub"><?php echo e($conf['url']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif(in_array($key, ['board_memberships','affiliations'])): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $aff): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $dateStr = formatFlatDates($aff['date_start'] ?? null, $aff['date_end'] ?? null); ?>
                        <div class="generic-entry">
                            <div class="generic-title"><?php echo e($aff['organization'] ?? ''); ?></div>
                            <div class="generic-sub">
                                <?php echo e($aff['role'] ?? ''); ?>

                                <?php if(!empty($dateStr)): ?> · <?php echo e($dateStr); ?><?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'awards'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="generic-entry">
                            <div class="generic-title"><?php echo e($award['name'] ?? ''); ?></div>
                            <div class="generic-sub">
                                <?php echo e($award['issuer'] ?? ''); ?>

                                <?php if(!empty($award['date'])): ?> · <?php echo e($award['date']); ?><?php endif; ?>
                            </div>
                            <?php if(!empty($award['description'])): ?>
                                <div class="generic-desc"><?php echo e($award['description']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'portfolio_highlights'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="project">
                            <div class="project-name"><?php echo e($item['title'] ?? ''); ?></div>
                            <?php if(!empty($item['description'])): ?>
                                <div class="project-desc"><?php echo e($item['description']); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($item['url'])): ?>
                                <div class="generic-sub"><?php echo e($item['url']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'campaigns_highlights'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $camp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $dateStr = formatFlatDates($camp['date_start'] ?? null, $camp['date_end'] ?? null); ?>
                        <div class="project">
                            <div class="job-head">
                                <div class="project-name"><?php echo e($camp['name'] ?? ''); ?></div>
                                <?php if(!empty($dateStr)): ?>
                                    <div class="date"><?php echo e($dateStr); ?></div>
                                <?php endif; ?>
                            </div>
                            <?php if(!empty($camp['description'])): ?>
                                <div class="project-desc"><?php echo e($camp['description']); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($camp['results'])): ?>
                                <div class="project-impact"><?php echo e($camp['results']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'thought_leadership'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="generic-entry">
                            <div class="generic-title"><?php echo e($tl['title'] ?? ''); ?></div>
                            <div class="generic-sub">
                                <?php echo e($tl['type'] ?? ''); ?>

                                <?php if(!empty($tl['venue'])): ?> · <?php echo e($tl['venue']); ?><?php endif; ?>
                                <?php if(!empty($tl['date'])): ?> · <?php echo e($tl['date']); ?><?php endif; ?>
                            </div>
                            <?php if(!empty($tl['url'])): ?>
                                <div class="generic-sub"><?php echo e($tl['url']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            
            <?php elseif($key === 'pro_bono'): ?>
                <?php if(is_array($data) && count($data)): ?>
                <div class="section">
                    <div class="section-title"><?php echo e($label); ?></div>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $dateStr = formatFlatDates($pb['date_start'] ?? null, $pb['date_end'] ?? null); ?>
                        <div class="generic-entry">
                            <div class="generic-title"><?php echo e($pb['organization'] ?? ''); ?></div>
                            <?php if(!empty($dateStr)): ?>
                                <div class="generic-sub"><?php echo e($dateStr); ?></div>
                            <?php endif; ?>
                            <?php if(!empty($pb['description'])): ?>
                                <div class="generic-desc"><?php echo e($pb['description']); ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if(is_array($languages) && count($languages)): ?>
        <div class="section">
            <div class="section-title">Languages</div>
            <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="lang-entry">
                <span class="lang-name"><?php echo e($lang['language'] ?? ''); ?></span>
                <span class="lang-level"><?php echo e($lang['level'] ?? ''); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>

    </div>

    
    <div class="footer">
        <?php echo e($resume['full_name'] ?? ''); ?> &nbsp;·&nbsp;
    </div>

</div>
</div>
</body>
</html>
<?php /**PATH C:\Users\SEDANA\Downloads\projet fiagan\filescvmatch nouveau projet complet (1)\cvmatch-ai-final-corrected-handoff\backend\resources\views/pdf/_pdf_copy.blade.php ENDPATH**/ ?>