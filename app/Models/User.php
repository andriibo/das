<?php

namespace App\Models;

use App\Enums\Users\StatusEnum;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\User.
 *
 * @property int         $id
 * @property string      $email
 * @property null|string $email_verified_at
 * @property null|string $password
 * @property string      $access_token
 * @property string      $auth_key
 * @property null|string $remember_token
 * @property null|string $username
 * @property string      $fullname
 * @property int         $status                0 - DELETED; 1 - NO_ACTIVE; 10 - ACTIVE;
 * @property null|int    $parent_affiliate_id   Refers to affiliate.id
 * @property Carbon      $updated_at
 * @property Carbon      $created_at
 * @property int         $is_deleted
 * @property string      $balance
 * @property null|string $dob
 * @property null|int    $country_id
 * @property null|int    $fav_team_id
 * @property null|int    $fav_player_id
 * @property null|int    $language_id
 * @property int         $receive_newsletters
 * @property int         $receive_notifications
 * @property null|string $avatar
 * @property int         $is_email_confirmed
 * @property null|int    $invited_by_user
 * @property int         $is_sham
 *
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereAccessToken($value)
 * @method static Builder|User whereAvatar($value)
 * @method static Builder|User whereAuthKey($value)
 * @method static Builder|User whereBalance($value)
 * @method static Builder|User whereCountryId($value)
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereDob($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereFavPlayerId($value)
 * @method static Builder|User whereFavTeamId($value)
 * @method static Builder|User whereFullname($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereInvitedByUser($value)
 * @method static Builder|User whereIsDeleted($value)
 * @method static Builder|User whereIsEmailConfirmed($value)
 * @method static Builder|User whereIsSham($value)
 * @method static Builder|User whereLanguageId($value)
 * @method static Builder|User whereParentAffiliateId($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereReceiveNewsletters($value)
 * @method static Builder|User whereReceiveNotifications($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereStatus($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @method static Builder|User whereUsername($value)
 * @mixin Eloquent
 */
class User extends Model
{
    protected $table = 'user';

    protected $fillable = [
        'email',
        'username',
        'fullname',
        'password',
        'access_token',
        'auth_key',
        'status',
        'parent_affiliate_id',
        'is_deleted',
        'balance',
        'dob',
        'country_id',
        'fav_team_id',
        'fav_player_id',
        'language_id',
        'receive_newsletters',
        'receive_notifications',
        'avatar',
        'is_email_confirmed',
        'invited_by_user',
        'is_sham',
    ];

    protected $hidden = [
        'password',
        'access_token',
        'auth_key',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function isActive(): bool
    {
        return $this->status == StatusEnum::active->value;
    }
}
