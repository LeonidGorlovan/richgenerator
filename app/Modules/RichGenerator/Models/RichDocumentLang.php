<?php

namespace App\Modules\RichGenerator\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\RichGenerator\Database\Factories\RichDocumentLangFactory;
use Spatie\LaravelData\WithData;
use Kalnoy\Nestedset\NodeTrait;

class RichDocumentLang extends Model
{
    use HasFactory;
    use WithData;

    protected $table = 'rich_document_langs';
    public $fillable = ['title'];
    public $timestamps = false;
    public array $translatable = [''];

    protected static function newFactory()
    {
        return new RichDocumentLangFactory();
    }
}
