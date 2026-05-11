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
        "job_description",
        "status",
        "score",
        "score_breakdown_json" ,
        "critical_problems_json",
        "missing_keywords_json",
        "is_paid",
        "ats_issues_json",
        "optimized_resume",
        "cover_letter"
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
        'critical_problems_json' => 'array',
        'missing_keywords_json' => 'array',
        'ats_issues_json' => 'array',
    ];

    public function setScoreBreakdownAttribute($value)    {$this->attributes['score_breakdown_json'] = json_encode($value);}
    public function setCriticalProblemsAttribute($value)    {$this->attributes['critical_problems_json'] = json_encode($value);}
    public function setMissingKeywordsAttribute($value)    {$this->attributes['missing_keywords_json'] = json_encode($value);}
    public function setAtsIssuesAttribute($value)    {$this->attributes['ats_issues_json'] = json_encode($value);}
    public function getScoreBreakdownAttribute()    {return $this->score_breakdown_json;}
    public function getCriticalProblemsAttribute()    {return $this->critical_problems_json;}
    public function getMissingKeywordsAttribute()    {return $this->missing_keywords_json;}
    public function getAtsIssuesAttribute()    {return $this->ats_issues_json;}



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
