<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SitePreference.
 *
 * @property int    $id
 * @property string $site_fee
 * @property string $support_email
 * @property string $support_phone
 * @property string $facebook_url
 * @property string $twitter_url
 * @property string $date_updated
 * @property string $bonus_balance_percent
 * @property string $bonus_transaction_percent
 * @property string $user_contest_min_entry_fee
 * @property string $user_contest_site_fee
 * @property string $user_contest_leagues
 * @property int    $bonus_drip
 * @property int    $template_days_ahead
 * @property int    $referral_bonus_percent
 * @property string $affiliate_contest_percent
 * @property string $activation_bonus_deposit
 * @property string $daily_bonus_deposit
 *
 * @method static Builder|SitePreference newModelQuery()
 * @method static Builder|SitePreference newQuery()
 * @method static Builder|SitePreference query()
 * @method static Builder|SitePreference whereActivationBonusDeposit($value)
 * @method static Builder|SitePreference whereAffiliateContestPercent($value)
 * @method static Builder|SitePreference whereBonusBalancePercent($value)
 * @method static Builder|SitePreference whereBonusDrip($value)
 * @method static Builder|SitePreference whereBonusTransactionPercent($value)
 * @method static Builder|SitePreference whereDailyBonusDeposit($value)
 * @method static Builder|SitePreference whereDateUpdated($value)
 * @method static Builder|SitePreference whereFacebookUrl($value)
 * @method static Builder|SitePreference whereId($value)
 * @method static Builder|SitePreference whereReferralBonusPercent($value)
 * @method static Builder|SitePreference whereSiteFee($value)
 * @method static Builder|SitePreference whereSupportEmail($value)
 * @method static Builder|SitePreference whereSupportPhone($value)
 * @method static Builder|SitePreference whereTemplateDaysAhead($value)
 * @method static Builder|SitePreference whereTwitterUrl($value)
 * @method static Builder|SitePreference whereUserContestLeagues($value)
 * @method static Builder|SitePreference whereUserContestMinEntryFee($value)
 * @method static Builder|SitePreference whereUserContestSiteFee($value)
 * @mixin Eloquent
 */
class SitePreference extends Model
{
    public $timestamps = false;

    protected $table = 'site_preferences';

    protected $fillable = [
        'site_fee',
        'support_email',
        'support_phone',
        'facebook_url',
        'twitter_url',
        'date_updated',
        'bonus_balance_percent',
        'bonus_transaction_percent',
        'user_contest_min_entry_fee',
        'user_contest_site_fee',
        'user_contest_leagues',
        'bonus_drip',
        'template_days_ahead',
        'referral_bonus_percent',
        'affiliate_contest_percent',
        'activation_bonus_deposit',
        'daily_bonus_deposit',
    ];
}
