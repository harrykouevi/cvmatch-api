<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class CreditPlan
 *
 * @package namespace App\Entities;
 *
 */
class CreditPlan extends Model implements Transformable
{

    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price' ,
        'currency',
        'credits' ,
        'is_active' ,
        'provider',
        'provider_product_id',
        'provider_price_id',
        'provider_product_snapshot_json' ,
        'synced_at',
    ];


     /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [
        'name' => 'required|string|max:255',
        'price' => 'required|integer|min:1',
        // en centimes → ex: 500 = $5

        'currency' => 'required|string|size:3',
        // ex: usd, eur

        'credits' => 'required|integer|min:1|max:9999999',
        'is_active' => 'required|boolean',

    ];


    protected $appends = ['custom_ui'];

    public function getCustomUiAttribute()
    {
        if($this->provider == "gumroad"){
            $snapshot = json_decode($this->provider_product_snapshot_json, true);
            $description = $snapshot['description'] ?? '';
            $features = $this->extractFeaturesFromDescription($description);

            return [
                'id' =>  $this->id,
                'name' => $snapshot['name'] ?? null,
                'provider' => $this->provider ?? null,
                'price' => isset($snapshot['formatted_price'])
                    ? $snapshot['formatted_price']
                    : ('$' . (($snapshot['price'] ?? 0) / 100)),
                // 'subtitle' => $snapshot['custom_summary'] ?? null,
                'subtitle' => $this->buildSubtitleFromFeatures( $features),
                'badge' => 'Best for testing',
                'features' => $this->buildSymplifyFeatures( $features),
                'cta' => 'Unlock for ' . ($snapshot['formatted_price'] ?? '$5'),
                'url' => $snapshot['short_url'] ?? null,
            ];
        }

        if($this->provider == "paddle"){
            $snapshot = json_decode($this->provider_product_snapshot_json, true);
            $description = $snapshot['description'] ?? '';
            $customData = $snapshot['custom_data'] ?? [];
            Log::info('first one',[$customData]);
            $features = $customData['features'] ?? [];
            if (is_string($features)) {
                $features = json_decode($features, true)?? [];
            }
            $features = $this->buildSymplifyFeatures($this->prepareFeaturesFromPaddle($features));

            return [
                'id' => $this->id,
                'name' => $this->name ?? null,
                'provider' => $this->provider ?? null,
                'price_id' => $this->provider_price_id,
                'price' => $this->price ? ('$' . (($this->price ?? 0) / 100)) : null,
                'subtitle' => $snapshot['description'] ?? null,
                'badge' =>  $customData['badge'] ?? null,
                'features' => $features,
                'description' => $customData['details'] ?? null,
                'cta' => 'Unlock for ' . ('$' .(($this->price ?? 0) / 100) ?? '$5') ,
                'url' => $snapshot['short_url'] ?? null,
            ];
        }
    }

    private function extractFeaturesFromDescription(string $html): array
    {
        $text = html_entity_decode(strip_tags($html));

        if (!str_contains($text, 'This pack includes')) {
            return [];
        }

        $after = explode('This pack includes:', $text)[1] ?? '';

        // dd($after) ;

        $lines = preg_split('/\r\n|\r|\n/', $after);

        $features = [];

        foreach ($lines as $line) {
            $line = trim($line);

            // stop condition
            if ($line === '' || str_starts_with($line, 'Perfect if')) {
                break;
            }

            // split bullets inside same line
            $parts = preg_split('/(•|\-|\+|✓|✔|\x{2022})/u', $line);

            foreach ($parts as $part) {
                $part = trim($part);

                if ($part === '') {
                    continue;
                }

                // extract quantity
                if (preg_match('/^(\d+)\s+(.*)$/', $part, $matches)) {
                    $features[] = [
                        'qty' => (int) $matches[1],
                        'text' => (int) $matches[1] .' '.trim($matches[2]),
                    ];
                } else {
                    $features[] = [
                        'qty' => Null,
                        'text' => $part, // ✅ FIX
                    ];
                }
            }
        }

        return $features;
    }

    private function prepareFeaturesFromPaddle(array $json): array
    {
        // $text = html_entity_decode(strip_tags($json));

        // if (!str_contains($text, 'This pack includes')) {
        //     return [];
        // }

        // $after = explode('This pack includes:', $text)[1] ?? '';

        // dd($after) ;

        // $lines = preg_split('/\r\n|\r|\n/', $after);

        $features = [];
        $lines = $json ;
        foreach ($lines as $line) {
            $line = trim($line);

            // stop condition
            if ($line === '' || str_starts_with($line, 'Perfect if')) {
                break;
            }

            // split bullets inside same line
            $parts = preg_split('/(•|\-|\+|✓|✔|\x{2022})/u', $line);

            foreach ($parts as $part) {
                $part = trim($part);

                if ($part === '') {
                    continue;
                }

                // extract quantity
                if (preg_match('/^(\d+)\s+(.*)$/', $part, $matches)) {
                    $features[] = [
                        'qty' => (int) $matches[1],
                        'text' => (int) $matches[1] .' '.trim($matches[2]),
                    ];
                } else {
                    $features[] = [
                        'qty' => Null,
                        'text' => $part, // ✅ FIX
                    ];
                }
            }
        }

        return $features;
    }

    private function buildSubtitleFromFeatures(array $features): string
    {
        if (empty($features)) {
            return 'AI-powered optimization tool';
        }
        $total = collect($features)->first()['qty'] ?? 0;
        return "{$total} targeted job application";

        // $total = collect($features)->sum('qty');

        // $texts = collect($features)->pluck('text')->map(fn($t) => strtolower($t));
        // $hasResume = $texts->contains(fn($t) => str_contains($t, 'resume'));
        // $hasCover  = $texts->contains(fn($t) => str_contains($t, 'cover'));
        // 🔥 your requested format
        // if ($hasResume && $hasCover) {
        //     return "{$total} targeted job application";
        // }
    }

    private function buildSymplifyFeatures(array $features): array
    {
        if (empty($features)) {
            return [];
        }

        return collect($features)->pluck('text')->map(fn($t) => strtolower($t))->values()->all();

    }

}
