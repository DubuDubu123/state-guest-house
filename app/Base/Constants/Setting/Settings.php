<?php

namespace App\Base\Constants\Setting;

class Settings
{
    const EMAIL = 'email';
    const SMS = 'sms';
    const LOGO = 'logo';
    const FAVICON = 'favicon';
    const GOOGLE_BROWSER_KEY ='google_browser_key';
    const APP_NAME ='app_name';
    const SERVICE_TAX ='service_tax';
    const ADMIN_COMMISSION_TYPE ='admin_commission_type';
    const ADMIN_COMMISSION ='admin_commission';
    const WALLET_MIN_AMOUNT_FOR_TRIP ='wallet_min_amount_for_trip';
    const WALLET_MIN_AMOUNT_TO_ADD ='wallet_min_amount_to_add';
    const WALLET_MAX_AMOUNT_TO_ADD ='wallet_max_amount_to_add';
    const WALLET_MAX_AMOUNT_TO_BALANCE ='wallet_max_amount_to_balance';
    const TWILLO_ACCOUNT_SID ='twillo_account_sid';
    const TWILLO_AUTH_TOKEN ='twillo_auth_token';
    const TWILLO_NUMBER ='twillo_number';
    const HEAD_OFFICE_NUMBER ='head_office_number';
    const HELP_EMAIL_ADDRESS ='help_email_address';
    const BRAINTREE_ENVIRONMENT ='braintree_environment';
    const BRAINTREE_MERCHANT_ID ='braintree_merchant_id';
    const BRAINTREE_PUBLIC_KEY ='braintree_public_key';
    const BRAINTREE_PRIVATE_KEY ='braintree_private_key';
    const BRAINTREE_MASTER_MERCHANT ='braintree_master_merchant';
    const BRAINTREE_DEFAULT_MERCHANT ='braintree_default_merchant';
    const DRIVER_SEARCH_RADIUS='driver_search_radius';
    const MINIMUM_TIME_FOR_SEARCH_DRIVERS_FOR_SCHEDULE_RIDE='minimum_time_for_search_drivers_for_schedule_ride';

    const MINIMUM_WALLET_AMOUNT_FOR_WITHDRAWAL ='minimum_wallet_amount_for_withdrawal';


    const REFERRAL_COMMISION_FOR_USER='referral_commision_for_user';
    const REFERRAL_COMMISION_FOR_DRIVER='referral_commision_for_driver';
    const MINIMUM_TRIPS_SHOULD_COMPLETE_TO_REFER_DRIVERS='minimum_trips_should_complete_to_refer_drivers';
    const GOOGLE_MAP_KEY='google_map_key';
    const MAPBOX_KEY='map_box_key';
    const ENABLE_BRAIN_TREE='enable_brain_tree';
    const DRIVER_WALLET_MINIMUM_AMOUNT_TO_GET_ORDER='driver-wallet-minimum-amount-to-get-order';
    const OWNER_WALLET_MINIMUM_AMOUNT_TO_GET_ORDER='owner-wallet-minimum-amount-to-get-order';
    const FIREBASE_DB_URL='firebase-db-url';
    const FIREBASE_API_KEY='firebase-api-key';
    const FIREBASE_AUTH_DOMAIN='firebase-auth-domain';
    const FIREBASE_PROJECT_ID='firebase-project-id';
    const FIREBASE_STORAGE_BUCKET='firebase-storage-bucket';
    const FIREBASE_MESSAGIN_SENDER_ID='firebase-messaging-sender-id';
    const FIREBASE_APP_ID='firebase-app-id';
    const FIREBASE_MEASUREMENT_ID='firebase-measurement-id';
    const ENABLE_COUNTRY_RESTRICT_ON_MAP='enable_country_restrict_on_map';

    const ENABLE_PAYSTACK='enable-paystack';
    const PAYSTACK_ENVIRONMENT='paystack-environment';
    const PAYSTACK_TEST_SECRET_KEY='paystack-test-secret-key';
    const PAYSTACK_PRODUCTION_SECRET_KEY='paystack-production-secret-key';

    const ENABLE_FLUTTER_WAVE='enable-flutter-wave';
    const FLUTTER_WAVE_ENVIRONMENT='flutter-wave-environment';
    const FLUTTER_WAVE_TEST_SECRET_KEY='flutter-wave-test-secret-key';
    const FLUTTER_WAVE_PRODUCTION_SECRET_KEY='flutter-wave-production-secret-key';

    const ENABLE_STRIPE='enable-stripe';
    const STRIPE_ENVIRONMENT='stripe-environment';

    const STRIPE_TEST_SECRET_KEY='stripe_test_secret_key';
    const STRIPE_LIVE_SECRET_KEY='stripe_live_secret_key';

    const ENABLE_CASH_FREE='enable-cashfree';
    const CASH_FREE_ENVIRONMENT ='cash_free_environment';
    const CASH_FREE_TEST_APP_ID = 'cash_free_app_id';
    const CASH_FREE_PRODUCTION_APP_ID = 'cash_free_production_app_id';
    const CASH_FREE_SECRET_KEY='cash_free_secret_key';
    const CASH_FREE_PRODUCTION_SECRET_KEY='cash_free_production_secret_key';
    const CASH_FREE_TEST_CLIENT_ID_FOR_PAYOUT = 'cash_free_test_app_id_for_payout';
    const CASH_FREE_PRODUCTION_CLIENT_ID_FOR_PAYOUT = 'cash_free_production_app_id_for_payout';
    const CASH_FREE_TEST_CLIENT_SECRET_FOR_PAYOUT = 'cash_free_test_secret_for_payout';
    const CASH_FREE_PRODUCTION_CLIENT_SECRET_FOR_PAYOUT = 'cash_free_production_secret_for_payout';
    const ENABLE_RAZOR_PAY='enable-razor-pay';
    const RAZOR_PAY_ENVIRONMENT='razor_pay_environment';
    const ENABLE_PAYMOB='enable-paymob';
    const ENABLE_RENTAL_RIDE ='enable_rental_ride';
    const ENABLE_OTP_TRIPSTART ='enable_otp_tripstart';
    const ENABLE_DELIVERY_START_AND_END_OF_RIDE = 'enable_delivery_start_and_end_of_ride';
    const STRIPE_TEST_PUBLISHABLE_KEY='stripe_test_publishable_key';
    const STRIPE_LIVE_PUBLISHABLE_KEY='stripe_live_publishable_key';
    const RAZOR_PAY_TEST_API_KEY='razor_pay_test_api_key';
    const RAZOR_PAY_LIVE_API_KEY='razor_pay_live_api_key';
    const PAYSTACK_TEST_PUBLISHABLE_KEY='paystack_test_publishable_key';
    const PAYSTACK_PRODUCTION_PUBLISHABLE_KEY='paystack_production_publishable_key';
    const ENABLE_DIGITAL_SIGNATURE_AT_THE_END_OF_RIDE = 'enable_digital_signatur_at_the_end_of_ride';
    const CURRENCY = 'currency_code';
    const CURRENCY_SYMBOL='currency_symbol';

    const SHOW_RENTAL_RIDE_FEATURE='show_rental_ride_feature';
    const SHOW_RIDE_OTP_FEATURE='show_ride_otp_feature';
    const SHOW_RIDE_LATER_FEATURE='show_ride_later_feature';
    const DEFAULT_COUNTRY_CODE_FOR_MOBILE_APP='default_country_code_for_mobile_app';
    const DEFAULT__LANGUAGE_CODE_FOR_MOBILE_APP='default_Language_code_for_mobile_app';
    const USER_CAN_MAKE_A_RIDE_AFTER_X_MINIUTES='user_can_make_a_ride_after_x_miniutes';
    const USER_CONFIRM_BOOKING_TIMEOUT='user_confirm_booking_timeout';
    const USER_CAN_MAKE_A_RIDE_FOR_X_DAYS='user_can_make_a_ride_for_x_days';

    const TRIP_ACCEPT_REJECT_DURATION_FOR_DRIVER='trip_accept_reject_duration_for_driver';
    const GOOGLE_MAP_KEY_FOR_DISTANCE_MATRIX='google_map_key_for_distance_matrix';
    const MAXIMUM_TIME_FOR_FIND_DRIVERS_FOR_REGULAR_RIDE='maximum_time_for_find_drivers_for_regular_ride';
    const DEFAULT_LAT='default_latitude';
    const DEFAULT_LONG='default_longitude';
    const GOOGLE_SHEET_ID='google_sheet_id';
    const MINIMUM_WALLET_AMOUNT_FOR_TRANSFER='minimum_wallet_amount_for_transfer';
    const CONTACT_US_MOBILE1='contact_us_mobile1';
    const CONTACT_US_MOBILE2='contact_us_mobile2';
    const CONTACT_US_LINK='contact_us_link';

    const ENABLE_KASHIER='enable-kashier';
    const KASHIER_ENVIRONMENT='kashier-environment';
    const KASHIER_TEST_SECRET_KEY='kashier-test-secret-key';
    const KASHIER_PRODUCTION_SECRET_KEY='kashier-production-secret-key';

    const ENABLE_KHALTI_PAY='enable-khalti-pay';
    const KHALTI_PAY_ENVIRONMENT='khalti_pay_environment';
    const KHALTI_PAY_TEST_API_KEY='khalti_pay_test_api_key';
    const KHALTI_PAY_LIVE_API_KEY='khalti_pay_live_api_key';
    const SHOW_RIDE_WITHOUT_DESTINATION='show_ride_without_destination';
    const HOW_MANY_TIMES_A_DRIVER_TIMES_A_DRIVER_CAN_ENABLE_THE_MY_ROUTE_BOOKING_PER_DAY='how_many_times_a_driver_can_enable_the_my_route_booking_per_day';
    const ENABLE_MY_ROUTE_BOOKING_FEATURE='enable_my_route_booking_feature';
    const SHOW_WALLET_FEATURE_ON_MOBILE_APP='show_wallet_feature_on_mobile_app';
    const SHOW_BANK_INFO_FEATURE_ON_MOBILE_APP='show_bank_info_feature_on_mobile_app';
    const TRIP_DISPTACH_TYPE='trip_dispatch_type';
    const DRIVERS_AND_USERS='drivers_and_users';
    const WHATS_APP_NUMBER='whatsapp_number';
    const WHATS_APP_NUMBER_DRIVER='whatsapp_number_driver';
    const WHATS_APP_NUMBER_DRIVER_DOCUMENT_PAGE='whatsapp_number_driver_document_page';
    const WHATSAPP_NUMBER_FROM_GALLABOX='whatsapp_number_from_gallabox';
    const API_KEY='api_key';
    const API_SECRET_KEY='api_secret_key';
    const CHANNEL_ID='channel_id';
    const ACCOUNT_ID='account_id';
    const GST_FOR_RENTAL_VEHICLES='gst_for_rental_vehicles';

    const SMSINDIAHUB_API_KEY='sms_india_hub_api_key';
    const SMSINDIAHUB_SENDER_ID='sms_india_hub_sender_id';
/*ccavenue*/
    const ENABLE_CCAVENUE='enable-ccavenue';
    const WORKING_KEY='working-key';
    const ACCESS_CODE='access-code';
    const MERCHANT_ID='merchant-id';
    const RESPONSE_URL='response-url';

    // subscription params

    const DRIVER_COMMISSION_TYPE='driver_commision_type';
    const DRIVER_MONTHLY_SUBSCRIPTION_AMOUNT='driver_monthly_subscription_amount';
    const DRIVER_YEARLY_SUBSCRIPTION_AMOUNT='driver_yearly_subscription_amount';
    const DRIVER_WEEKLY_SUBSCRIPTION_AMOUNT='driver_weekly_subscription_amount';
    const DRIVER_DAILY_SUBSCRIPTION_AMOUNT='driver_daily_subscription_amount';

    const SUBSCRIPTION_GST='subscription_gst';

    const EXOTEL_ACCOUNT_SID='exotel_account_sid';
    const EXOTEL_API_KEY='exotel_api_key';
    const EXOTEL_API_TOKEN='exotel_api_token';
    const EXOTEL_SUBDOMAIN='exotel_sub_domain';
    const EXOTEL_CALLER_ID='exotel_caller_id';
    const EXOTEL_VIRTUAL_NUMBER='exotel_virtual_number';

    const DRIVER_CANCELLATION_AMOUNT_TO_BLOCK_SCREEN='driver_cancellation_amount_to_block_screen';
    const USER_CANCELLATION_AMOUNT_TO_BLOCK_SCREEN='user_cancellation_amount_to_block_screen';
// DISPATCHER_REQUEST_LIST_ACCESS

    const DISPATCHER_REQUEST_LIST_ACCESS='dispatcher_request_list_acess';
    const DISPATCHER_BOOK_LATER_ACCESS='dispatcher_book_later_acess';
    const DISPATCHER_DRIVER_LIST_ACCESS='dispatcher_driver_list_acess';
    const DISPATCHER_MANUAL_ASSIGN_ACCESS='dispatcher_manual_assign_acess';
//DISPATCHER_ZONE_ACCESS
    const DISPATCHER_ZONE_ACCESS='dispatcher_zone_acess';

}
