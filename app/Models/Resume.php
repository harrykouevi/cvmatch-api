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
class Resume extends Model implements Transformable, HasMedia
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

        'tenant_id',
        'user_id',
        // 'original_file_path',
        'original_file_name',
        'file_type',
        'extracted_text'
    ];


     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'name' => 'required|max:127',
        // 'salon_level_id' => 'required|exists:salon_levels,id',
        'user_id' => 'required|exists:users,id',
        'phone_number' => 'required|max:50',
        'mobile_number' => 'required|max:50',
        'availability_range' => 'numeric|max:9999999.99|min:0.01',
        'available' => 'boolean',
        'featured' => 'boolean',
        'accepted' => 'required|boolean',
    ];


    /**
     * to generate media url in case of fallback will
     * return the file type icon
     * @param string $conversion
     * @return string url
     */
    public function getFirstMediaUrl( string $conversion = ''): string
    {
        $collectionName = 'resume' ;
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

}
