<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $created_at
 * @property string $updated_at
 * @property QuestToCategory[] $questToCategories
 * @property TestToCategory[] $testToCategories
 */
class Categories extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'slug', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function quests()
    {
        return $this->belongsToMany('App\Quests', 'quest_to_category','id_category','id_quest')
            ->with("category");
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tests()
    {
        return $this->hasMany('App\TestToCategory', 'id_category');
    }
}
