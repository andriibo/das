<?php

namespace App\Models\Contests;

use App\Enums\CricketGameSchedule\HasFinalBoxEnum;
use App\Enums\CricketGameSchedule\IsDataConfirmedEnum;
use App\Enums\SportIdEnum;
use App\Models\Cricket\CricketGameSchedule;
use App\Models\League;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Contests\Contest.
 *
 * @property int                              $id
 * @property null|int                         $owner_id
 * @property int                              $status
 * @property string                           $type
 * @property string                           $contest_type
 * @property string                           $game_type
 * @property string                           $title
 * @property int                              $league_id
 * @property string                           $start_date
 * @property string                           $end_date
 * @property string                           $form_start_date
 * @property string                           $form_end_date
 * @property string                           $details
 * @property null|string                      $password
 * @property int                              $entry_fee_type
 * @property string                           $entry_fee
 * @property string                           $voucher_fee
 * @property string                           $badge_id
 * @property null|int                         $bonus_drip
 * @property int                              $salary_cap
 * @property int                              $prize_bank_type
 * @property array                            $prize_places
 * @property string                           $prize_bank
 * @property int                              $payout_type
 * @property null|string                      $custom_prize_bank
 * @property null|string                      $expected_payout
 * @property null|string                      $company_take
 * @property int                              $users_limit_type
 * @property int                              $min_users
 * @property int                              $max_users
 * @property int                              $entry_limit
 * @property string                           $updated_time
 * @property string                           $created_date
 * @property int                              $suspended
 * @property int                              $news_feed_count
 * @property int                              $last_news_feed_id
 * @property int                              $is_private
 * @property int                              $is_vip
 * @property int                              $is_guaranteed
 * @property int                              $retain_once_filled
 * @property int                              $retain_once_live
 * @property int                              $is_fake
 * @property int                              $is_salary_available
 * @property int                              $is_prize_in_percents
 * @property int                              $is_sham
 * @property League                           $league
 * @property Collection|ContestUnit[]         $contestUnits
 * @property null|int                         $contest_units_count
 * @property Collection|CricketGameSchedule[] $liveCricketGameSchedules
 * @property null|int                         $live_cricket_game_schedules_count
 * @property Collection|CricketGameSchedule[] $unconfirmedCricketGameSchedules
 * @property null|int                         $unconfirmed_cricket_game_schedules_count
 * @property Collection|ContestUser[]         $contestUsers
 * @property null|int                         $contest_users_count
 * @property Collection|CricketGameSchedule[] $cricketGameSchedules
 * @property null|int                         $cricket_game_schedules_count
 *
 * @method static Builder|Contest newModelQuery()
 * @method static Builder|Contest newQuery()
 * @method static Builder|Contest query()
 * @method static Builder|Contest whereBadgeId($value)
 * @method static Builder|Contest whereBonusDrip($value)
 * @method static Builder|Contest whereCompanyTake($value)
 * @method static Builder|Contest whereContestType($value)
 * @method static Builder|Contest whereCreatedDate($value)
 * @method static Builder|Contest whereCustomPrizeBank($value)
 * @method static Builder|Contest whereDetails($value)
 * @method static Builder|Contest whereEndDate($value)
 * @method static Builder|Contest whereEntryFee($value)
 * @method static Builder|Contest whereEntryFeeType($value)
 * @method static Builder|Contest whereEntryLimit($value)
 * @method static Builder|Contest whereExpectedPayout($value)
 * @method static Builder|Contest whereFormEndDate($value)
 * @method static Builder|Contest whereFormStartDate($value)
 * @method static Builder|Contest whereGameType($value)
 * @method static Builder|Contest whereId($value)
 * @method static Builder|Contest whereIsFake($value)
 * @method static Builder|Contest whereIsGuaranteed($value)
 * @method static Builder|Contest whereIsPrivate($value)
 * @method static Builder|Contest whereIsPrizeInPercents($value)
 * @method static Builder|Contest whereIsSalaryAvailable($value)
 * @method static Builder|Contest whereIsSham($value)
 * @method static Builder|Contest whereIsVip($value)
 * @method static Builder|Contest whereLastNewsFeedId($value)
 * @method static Builder|Contest whereLeagueId($value)
 * @method static Builder|Contest whereMaxUsers($value)
 * @method static Builder|Contest whereMinUsers($value)
 * @method static Builder|Contest whereNewsFeedCount($value)
 * @method static Builder|Contest whereOwnerId($value)
 * @method static Builder|Contest wherePassword($value)
 * @method static Builder|Contest wherePayoutType($value)
 * @method static Builder|Contest wherePrizeBank($value)
 * @method static Builder|Contest wherePrizeBankType($value)
 * @method static Builder|Contest wherePrizePlaces($value)
 * @method static Builder|Contest whereRetainOnceFilled($value)
 * @method static Builder|Contest whereRetainOnceLive($value)
 * @method static Builder|Contest whereSalaryCap($value)
 * @method static Builder|Contest whereStartDate($value)
 * @method static Builder|Contest whereStatus($value)
 * @method static Builder|Contest whereSuspended($value)
 * @method static Builder|Contest whereTitle($value)
 * @method static Builder|Contest whereType($value)
 * @method static Builder|Contest whereUpdatedTime($value)
 * @method static Builder|Contest whereUsersLimitType($value)
 * @method static Builder|Contest whereVoucherFee($value)
 * @mixin Eloquent
 */
class Contest extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'contest';

    protected $fillable = [
        'owner_id',
        'status',
        'type',
        'contest_type',
        'game_type',
        'title',
        'league_id',
        'start_date',
        'end_date',
        'form_start_date',
        'form_end_date',
        'details',
        'password',
        'entry_fee_type',
        'entry_fee',
        'voucher_fee',
        'badge_id',
        'bonus_drip',
        'salary_cap',
        'prize_bank_type',
        'prize_places',
        'prize_bank',
        'payout_type',
        'custom_prize_bank',
        'expected_payout',
        'company_take',
        'users_limit_type',
        'min_users',
        'max_users',
        'entry_limit',
        'updated_time',
        'created_date',
        'suspended',
        'news_feed_count',
        'last_news_feed_id',
        'is_private',
        'is_vip',
        'is_guaranteed',
        'retain_once_filled',
        'retain_once_live',
        'is_fake',
        'is_salary_available',
        'is_prize_in_percents',
        'is_sham',
    ];

    protected $casts = [
        'prize_places' => 'array',
    ];

    public function isSportSoccer(): bool
    {
        return $this->league?->sport_id == SportIdEnum::soccer->value;
    }

    public function isSportCricket(): bool
    {
        return $this->league?->sport_id == SportIdEnum::cricket->value;
    }

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function contestUsers(): HasMany
    {
        return $this->hasMany(ContestUser::class);
    }

    public function contestUnits(): HasMany
    {
        return $this->hasMany(ContestUnit::class);
    }

    public function cricketGameSchedules(): BelongsToMany
    {
        return $this->belongsToMany(
            CricketGameSchedule::class,
            (new ContestGame())->getTable(),
            'contest_id',
            'game_id'
        )
            ->wherePivot('sport_id', SportIdEnum::cricket)
        ;
    }

    public function liveCricketGameSchedules(): BelongsToMany
    {
        return $this->belongsToMany(
            CricketGameSchedule::class,
            (new ContestGame())->getTable(),
            'contest_id',
            'game_id'
        )
            ->where('game_date', '<=', date('Y-m-d H:i:s'))
            ->where('has_final_box', HasFinalBoxEnum::no)
            ->wherePivot('sport_id', SportIdEnum::cricket)
        ;
    }

    public function unconfirmedCricketGameSchedules(): BelongsToMany
    {
        return $this->belongsToMany(
            CricketGameSchedule::class,
            (new ContestGame())->getTable(),
            'contest_id',
            'game_id'
        )
            ->where('is_data_confirmed', IsDataConfirmedEnum::no)
            ->where('has_final_box', HasFinalBoxEnum::yes)
            ->wherePivot('sport_id', SportIdEnum::cricket)
        ;
    }
}
