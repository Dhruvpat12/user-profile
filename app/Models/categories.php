<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class categories extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ["id","name","parent_id","slug","category_image","created_at","updated_at"];
 

    public function parent(): BelongsTo
    {
        return $this->belongsTo(categories::class, 'parent_id');
    }

    // Children relationship (Category can have many subcategories)
    public function children(): HasMany
    {
        return $this->hasMany(categories::class, 'parent_id')->with('children'); // Recursive fetching of children
    }


}
