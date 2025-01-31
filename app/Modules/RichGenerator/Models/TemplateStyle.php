<?php

namespace App\Modules\RichGenerator\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\RichGenerator\Database\Factories\RichDocumentBrandFactory;
use Spatie\LaravelData\WithData;

class TemplateStyle extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'template_styles';
    public $fillable = ['title', 'description', 'style', 'active'];
    public array $translatable = [''];

    protected static function newFactory(): RichDocumentBrandFactory
    {
        return new RichDocumentBrandFactory();
    }
}
