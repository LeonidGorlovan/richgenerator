<?php

namespace App\Modules\RichGenerator\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\RichGenerator\Database\Factories\RichDocumentFactory;
use Illuminate\Support\Str;
use Spatie\LaravelData\WithData;
use CfDigital\Delta\Core\Services\Traits\HasPublishStatus;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class RichDocument extends Model
{
    use HasPublishStatus;
    use HasFactory;
    use WithData;
    use HasSlug;

    protected $table = 'rich_documents';
    public $fillable = ['title', 'item', 'html', 'tmpl_id', 'brand_id', 'lang_id', 'status'];
    public array $translatable = [''];

    protected static function newFactory(): RichDocumentFactory
    {
        return new RichDocumentFactory();
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug')
            ->slugsShouldBeNoLongerThan(50)
            ->doNotGenerateSlugsOnUpdate()
            ->preventOverwrite();
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function scopeCreatedAtFrom($query, $date)
    {
        return $query->where('created_at', '>=', Carbon::parse($date));
    }

    public function scopeCreatedAtTo($query, $date)
    {
        return $query->where('created_at', '<=', Carbon::parse($date));
    }
}
