<?php

namespace App\Modules\RichGenerator\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\RichGenerator\Database\Factories\RichDocumentBrandFactory;
use Spatie\LaravelData\WithData;
use Kalnoy\Nestedset\NodeTrait;

class RichDocumentBrand extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'rich_document_brands';
    public $fillable = ['title'];
    public $timestamps = false;
    public array $translatable = [''];

    protected static function newFactory(): RichDocumentBrandFactory
    {
        return new RichDocumentBrandFactory();
    }
}
