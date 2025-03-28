<?php

namespace App\Models\TmpModels;

use Illuminate\Database\Eloquent\Model;

/**
 * 
 *
 * @property int $id
 * @property string|null $date_add
 * @property string|null $date_modify
 * @property string|null $outgoing_date
 * @property string $ready_date
 * @property string|null $payment_settle_date
 * @property string|null $settle_date
 * @property string|null $check_code
 * @property string|null $invoice_id
 * @property int $sandbox
 * @property string|null $currency
 * @property string|null $subtotal
 * @property string $total
 * @property string|null $payment_gateway
 * @property string $payment_method
 * @property int $payment_gateway_id
 * @property string $payment_status
 * @property string $order_status
 * @property int $lingual_id
 * @property int $send_email
 * @property int $show_return
 * @property string|null $order_info
 * @property string|null $gateway_check
 * @property string|null $response
 * @property string|null $payer_name
 * @property string|null $payer_lastname
 * @property string|null $payer_phone
 * @property string|null $payer_email
 * @property string|null $buyer_salutation
 * @property string|null $buyer_name
 * @property string|null $buyer_lastname
 * @property string $area_code
 * @property string|null $buyer_phone
 * @property string|null $buyer_email
 * @property string $member_input_phone
 * @property string|null $expire_date
 * @property string|null $vip_card_no
 * @property int|null $vip_card_valid
 * @property string|null $remark
 * @property string|null $backend_remark
 * @property string|null $oos_remark
 * @property string|null $date_done
 * @property int|null $coupon_id
 * @property int|null $coupon_valid
 * @property int|null $discount_id
 * @property string|null $discount_type
 * @property string|null $discount
 * @property string|null $shipping_fee
 * @property int|null $user_id
 * @property int|null $offline
 * @property string|null $discount_code
 * @property int|null $discount_type_valid
 * @property int $subscription
 * @property string|null $utm
 * @property string $waybill_id
 * @property string $pre_waybill_id
 * @property string $store_promo_code
 * @property int $delivery_status
 * @property int $point_used
 * @property int $remain_point
 * @property int $is_member
 * @property int $loyalty_club_tnc
 * @property int $personal_privacy
 * @property int $member_b_months
 * @property int $member_b_day
 * @property string|null $platform
 * @property string|null $landing
 * @property string|null $landing_id
 * @property string $control_key
 * @property string $referral_code
 * @property int $profile_cs_verify_need
 * @property string $profile_cs_verify
 * @property int $mars_profile_status
 * @property string $mars_profile_date
 * @property string $mars_data
 * @property int $mars_status
 * @property int $review_required
 * @property string $lucid
 * @property string $matched_criteria
 * @property string $mars_lastname
 * @property string $mars_name_method
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereAreaCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereBackendRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereBuyerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereBuyerLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereBuyerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereBuyerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereBuyerSalutation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereCheckCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereControlKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereCouponValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereDateAdd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereDateDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereDateModify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereDeliveryStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereDiscountCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereDiscountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereDiscountTypeValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereExpireDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereGatewayCheck($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereIsMember($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereLanding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereLandingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereLingualId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereLoyaltyClubTnc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereLucid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMarsData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMarsLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMarsNameMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMarsProfileDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMarsProfileStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMarsStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMatchedCriteria($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMemberBDay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMemberBMonths($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereMemberInputPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereOffline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereOosRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereOrderInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereOutgoingDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePayerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePayerLastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePayerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePayerPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePaymentGateway($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePaymentGatewayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePaymentSettleDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePersonalPrivacy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePointUsed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder wherePreWaybillId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereProfileCsVerify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereProfileCsVerifyNeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereReadyDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereReferralCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereRemainPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereRemark($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereResponse($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereReviewRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereSandbox($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereSendEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereSettleDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereShippingFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereShowReturn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereStorePromoCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereSubscription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereSubtotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereUtm($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereVipCardNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereVipCardValid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|KieOrder whereWaybillId($value)
 * @mixin \Eloquent
 */
class KieOrder extends Model
{
    protected $connection = 'loreal_dev';
    protected $table = 'lo_kie_pd__order';
}
