<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * Class Resume.
 *
 * @package namespace App\Entities;
 *
 * @property integer 'tenant_id',
 * @property integer user_id
 * @property string extracted_text
 */
class Analyse extends Model implements Transformable, HasMedia
{
    use InteractsWithMedia {
        getFirstMediaUrl as protected getFirstMediaUrlTrait;
    }
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "resume_id",
        "user_id",
        "job_description",
        "status",
        "is_full_unlocked",


        "score",
        "match_level",
        "job_fit_summary",
        "score_breakdown_json" ,
        "missing_keywords_json",
        "missing_hard_skills_json",
        "weak_sections_json",
        "strong_points_json",
        "detected_problems_json",
        "recruiter_risk_flags_json",
        "recommendations_json",
        "warnings_json",

        "optimized_resume",
        "optimized_resume_text",
        "cover_letter",
        "optimized_resume_analysis_json"

    ];


     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'resume_id' => 'required|exists:resumes,id',
        'job_description' => 'required|max:2250',
    ];

    protected $casts = [
        'score_breakdown_json' => 'array',
        'missing_keywords_json' => 'array',
        'missing_hard_skills_json' => 'array',
        "weak_sections_json" => 'array',
        "strong_points_json" => 'array',
        "detected_problems_json" => 'array',
        "recruiter_risk_flags_json" => 'array',
        "recommendations_json" => 'array',
        "warnings_json" => 'array',
        "optimized_resume_analysis_json" => 'array',
    ];

    public function setScoreBreakdownAttribute($value)    {$this->attributes['score_breakdown_json'] = json_encode($value);}
    public function setMissingKeywordsAttribute($value)    {$this->attributes['missing_keywords_json'] = json_encode($value);}
    public function setMissingHardSkillsAttribute($value)    {$this->attributes['missing_hard_skills_json'] = json_encode($value);}
    public function setWeakSectionsAttribute($value)    {$this->attributes['weak_sections_json'] = json_encode($value);}
    public function setStrongPointsAttribute($value)    {$this->attributes['strong_points_json'] = json_encode($value);}
    public function setDetectedProblemsAttribute($value)    {$this->attributes['detected_problems_json'] = json_encode($value);}
    public function setRecruiterRiskFlagsAttribute($value)    {$this->attributes['recruiter_risk_flags_json'] = json_encode($value);}
    public function setRecommendationsAttribute($value)    {$this->attributes['recommendations_json'] = json_encode($value);}
    public function setWarningsAttribute($value)    {$this->attributes['warnings_json'] = json_encode($value);}
    public function setOptimizedResumeAnalysisAttribute($value)    {$this->attributes['optimized_resume_analysis_json'] = json_encode($value);}

    public function getScoreBreakdownAttribute()    {return $this->score_breakdown_json;}
    public function getMissingKeywordsAttribute()    {return $this->missing_keywords_json;}
    public function getMissingHardSkillsAttribute()    {return $this->missing_hard_skills_json;}
    public function getWeakSectionsAttribute()    {return $this->weak_sections_json;}
    public function getStrongPointsAttribute()    {return $this->strong_points_json;}
    public function getDetectedProblemsAttribute()    {return $this->detected_problems_json;}
    public function getRecruiterRiskFlagsAttribute()    {return $this->recruiter_risk_flags_json;}
    public function getRecommendationsAttribute()    {return $this->recommendations_json;}
    public function getWarningsAttribute()    {return $this->warnings_json;}
    public function getOptimizedResumeAnalysisAttribute()    {return $this->optimized_resume_analysis_json;}



    /**
     * to generate media url in case of fallback will
     * return the file type icon
     * @param string $conversion
     * @return string url
     */
    public function getFirstMediaUrl( string $conversion = ''): string
    {
        $collectionName = 'analyse' ;
        $url = $this->getFirstMediaUrlTrait($collectionName);
        if (!$url) return ''; // Sécurité si pas d'URL
        $array = explode('.', $url);
        $extension = strtolower(end($array));
        if (in_array($extension, config('media-library.extensions_has_thumb'))) {
            return asset($this->getFirstMediaUrlTrait($collectionName, $conversion));
        } else {
            return asset(config('media-library.icons_folder') . '/' . $extension . '.png');
        }
    }

    /**
     * Add Media to api results
     * @return bool
     */
    public function getHasMediaAttribute(): bool
    {
        return $this->hasMedia('resume');
    }

    /**
     * Shortcut: retrieve only the real target models
     * (Service, Event, etc.)
     */
    public function targetModels()
    {
        return $this->targets->map(fn ($target) => $target->model);
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

}
