<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Game
 *
 * @property int $id
 * @property int $user_id
 * @property bool $is_ended
 * @property string $win_combination
 * @property int $count_attempts
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Game newModelQuery()
 * @method static Builder|Game newQuery()
 * @method static Builder|Game query()
 * @method static Builder|Game whereCountAttempts($value)
 * @method static Builder|Game whereCreatedAt($value)
 * @method static Builder|Game whereId($value)
 * @method static Builder|Game whereIsEnded($value)
 * @method static Builder|Game whereUpdatedAt($value)
 * @method static Builder|Game whereUserId($value)
 * @method static Builder|Game whereWinCombination($value)
 * @mixin Eloquent
 */
class Game extends Model
{
    use HasFactory;

    protected $table = 'games';

    protected $fillable = [
        'user_id',
        'count_attempts',
        'is_ended',
        'win_combination'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
