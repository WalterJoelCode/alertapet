<?php

namespace App\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'slug', 'description'])]
class Role extends Model
{
    /** @use HasFactory<RoleFactory> */
    use HasFactory;

    public const General = 'general';

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public static function general(): self
    {
        return static::query()->firstOrCreate(
            ['slug' => self::General],
            [
                'name' => 'General',
                'description' => 'Miembro general de la comunidad.',
            ],
        );
    }
}
