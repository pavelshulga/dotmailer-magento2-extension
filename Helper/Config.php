<?php

namespace Dotdigitalgroup\Email\Helper;

class Config extends \Magento\Framework\App\Helper\AbstractHelper
{
    const MODULE_NAME                                                           = 'Dotdigitalgroup_Email';

    /**
     * API SECTION.
     */
    const XML_PATH_CONNECTOR_API_ENABLED                                        = 'connector_api_credentials/api/enabled';
    const XML_PATH_CONNECTOR_API_USERNAME                                       = 'connector_api_credentials/api/username';
    const XML_PATH_CONNECTOR_API_PASSWORD                                       = 'connector_api_credentials/api/password';

    /**
     * SMS SECTION.
     */
    //enabled
    const XML_PATH_CONNECTOR_SMS_ENABLED_1                                      = 'connector_automation/sms/sms_one_enabled';
    const XML_PATH_CONNECTOR_SMS_ENABLED_2                                      = 'connector_automation/sms/sms_two_enabled';
    const XML_PATH_CONNECTOR_SMS_ENABLED_3                                      = 'connector_automation/sms/sms_three_enabled';
    const XML_PATH_CONNECTOR_SMS_ENABLED_4                                      = 'connector_automation/sms/sms_four_enabled';
    //status
    const XML_PATH_CONNECTOR_SMS_STATUS_1                                       = 'connector_automation/sms/sms_one_status';
    const XML_PATH_CONNECTOR_SMS_STATUS_2                                       = 'connector_automation/sms/sms_two_status';
    const XML_PATH_CONNECTOR_SMS_STATUS_3                                       = 'connector_automation/sms/sms_three_status';
    const XML_PATH_CONNECTOR_SMS_STATUS_4                                       = 'connector_automation/sms/sms_four_status';
    //message
    const XML_PATH_CONNECTOR_SMS_MESSAGE_1                                      = 'connector_automation/sms/sms_one_message';
    const XML_PATH_CONNECTOR_SMS_MESSAGE_2                                      = 'connector_automation/sms/sms_two_message';
    const XML_PATH_CONNECTOR_SMS_MESSAGE_3                                      = 'connector_automation/sms/sms_three_message';
    const XML_PATH_CONNECTOR_SMS_MESSAGE_4                                      = 'connector_automation/sms/sms_four_message';

    /**
     * SYNC SECTION.
     */
    const XML_PATH_CONNECTOR_SYNC_CUSTOMER_ENABLED                      = 'sync_settings/sync/customer_enabled';
    const XML_PATH_CONNECTOR_SYNC_GUEST_ENABLED                         = 'sync_settings/sync/guest_enabled';
    const XML_PATH_CONNECTOR_SYNC_SUBSCRIBER_ENABLED                    = 'sync_settings/sync/subscriber_enabled';
    const XML_PATH_CONNECTOR_SYNC_ORDER_ENABLED                         = 'sync_settings/sync/order_enabled';
    const XML_PATH_CONNECTOR_SYNC_WISHLIST_ENABLED                      = 'sync_settings/sync/wishlist_enabled';
    const XML_PATH_CONNECTOR_SYNC_REVIEW_ENABLED                        = 'sync_settings/sync/review_enabled';
    const XML_PATH_CONNECTOR_SYNC_QUOTE_ENABLED                         = 'sync_settings/sync/quote_enabled';
    const XML_PATH_CONNECTOR_SYNC_CATALOG_ENABLED                       = 'sync_settings/sync/catalog_enabled';

    const XML_PATH_CONNECTOR_CUSTOMERS_ADDRESS_BOOK_ID                  = 'sync_settings/addressbook/customers';
    const XML_PATH_CONNECTOR_SUBSCRIBERS_ADDRESS_BOOK_ID                = 'sync_settings/addressbook/subscribers';
    const XML_PATH_CONNECTOR_GUEST_ADDRESS_BOOK_ID                      = 'sync_settings/addressbook/guests';
    // Mapping
    const XML_PATH_CONNECTOR_MAPPING_LAST_ORDER_ID                      = 'connector_data_mapping/customer_data/last_order_id';
    const XML_PATH_CONNECTOR_MAPPING_LAST_QUOTE_ID                      = 'connector_data_mapping/customer_data/last_quote_id';
    const XML_PATH_CONNECTOR_MAPPING_CUSTOMER_ID                        = 'connector_data_mapping/customer_data/customer_id';
    const XML_PATH_CONNECTOR_MAPPING_CUSTOM_DATAFIELDS                  = 'connector_data_mapping/customer_data/custom_attributes';
    const XML_PATH_CONNECTOR_MAPPING_CUSTOMER_STORENAME                 = 'connector_data_mapping/customer_data/store_name';
    const XML_PATH_CONNECTOR_MAPPING_CUSTOMER_TOTALREFUND               = 'connector_data_mapping/customer_data/total_refund';

    /**
     * Abandoned Carts.
     */
    const XML_PATH_CONNECTOR_CUSTOMER_ABANDONED_CARTS_ENABLED_1         = 'connector_lost_baskets/customers/enabled_1';
    const XML_PATH_CONNECTOR_CUSTOMER_ABANDONED_CAMPAIGN_1              = 'connector_lost_baskets/customers/campaign_1';
    const XML_PATH_CONNECTOR_CUSTOMER_ABANDONED_CARTS_ENABLED_2         = 'connector_lost_baskets/customers/enabled_2';
    const XML_PATH_CONNECTOR_CUSTOMER_ABANDONED_CAMPAIGN_2              = 'connector_lost_baskets/customers/campaign_2';
    const XML_PATH_CONNECTOR_CUSTOMER_ABANDONED_CARTS_ENABLED_3         = 'connector_lost_baskets/customers/enabled_3';
    const XML_PATH_CONNECTOR_CUSTOMER_ABANDONED_CAMPAIGN_3              = 'connector_lost_baskets/customers/campaign_3';
    const XML_PATH_CONNECTOR_GUEST_ABANDONED_CARTS_ENABLED_1            = 'connector_lost_baskets/guests/enabled_1';
    const XML_PATH_CONNECTOR_GUEST_ABANDONED_CAMPAIGN_1                 = 'connector_lost_baskets/guests/campaign_1';
    const XML_PATH_CONNECTOR_GUEST_ABANDONED_CARTS_ENABLED_2            = 'connector_lost_baskets/guests/enabled_2';
    const XML_PATH_CONNECTOR_GUEST_ABANDONED_CAMPAIGN_2                 = 'connector_lost_baskets/guests/campaign_2';
    const XML_PATH_CONNECTOR_GUEST_ABANDONED_CARTS_ENABLED_3            = 'connector_lost_baskets/guests/enabled_3';
    const XML_PATH_CONNECTOR_GUEST_ABANDONED_CAMPAIGN_3                 = 'connector_lost_baskets/guests/campaign_3';

    /**
     * Datafields Mapping.
     */
    const XML_PATH_CONNECTOR_CUSTOMER_ID                                = 'connector_data_mapping/customer_data/customer_id';
    const XML_PATH_CONNECTOR_CUSTOMER_FIRSTNAME                         = 'connector_data_mapping/customer_data/firstname';
    const XML_PATH_CONNECTOR_CUSTOMER_LASTNAME                          = 'connector_data_mapping/customer_data/lastname';
    const XML_PATH_CONNECTOR_CUSTOMER_DOB                               = 'connector_data_mapping/customer_data/dob';
    const XML_PATH_CONNECTOR_CUSTOMER_GENDER                            = 'connector_data_mapping/customer_data/gender';
    const XML_PATH_CONNECTOR_CUSTOMER_WEBSITE_NAME                      = 'connector_data_mapping/customer_data/website_name';
    const XML_PATH_CONNECTOR_CUSTOMER_STORE_NAME                        = 'connector_data_mapping/customer_data/store_name';
    const XML_PATH_CONNECTOR_CUSTOMER_CREATED_AT                        = 'connector_data_mapping/customer_data/created_at';
    const XML_PATH_CONNECTOR_CUSTOMER_LAST_LOGGED_DATE                  = 'connector_data_mapping/customer_data/last_logged_date';
    const XML_PATH_CONNECTOR_CUSTOMER_CUSTOMER_GROUP                    = 'connector_data_mapping/customer_data/customer_group';
    const XML_PATH_CONNECTOR_CUSTOMER_REVIEW_COUNT                      = 'connector_data_mapping/customer_data/review_count';
    const XML_PATH_CONNECTOR_CUSTOMER_LAST_REVIEW_DATE                  = 'connector_data_mapping/customer_data/last_review_date';
    const XML_PATH_CONNECTOR_CUSTOMER_BILLING_ADDRESS_1                 = 'connector_data_mapping/customer_data/billing_address_1';
    const XML_PATH_CONNECTOR_CUSTOMER_BILLING_ADDRESS_2                 = 'connector_data_mapping/customer_data/billing_address_2';
    const XML_PATH_CONNECTOR_CUSTOMER_BILLING_CITY                      = 'connector_data_mapping/customer_data/billing_city';
    const XML_PATH_CONNECTOR_CUSTOMER_BILLING_STATE                     = 'connector_data_mapping/customer_data/billing_state';
    const XML_PATH_CONNECTOR_CUSTOMER_BILLING_COUNTRY                   = 'connector_data_mapping/customer_data/billing_country';
    const XML_PATH_CONNECTOR_CUSTOMER_BILLING_POSTCODE                  = 'connector_data_mapping/customer_data/billing_postcode';
    const XML_PATH_CONNECTOR_CUSTOMER_BILLING_TELEPHONE                 = 'connector_data_mapping/customer_data/billing_telephone';
    const XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_ADDRESS_1                = 'connector_data_mapping/customer_data/delivery_address_1';
    const XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_ADDRESS_2                = 'connector_data_mapping/customer_data/delivery_address_2';
    const XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_CITY                     = 'connector_data_mapping/customer_data/delivery_city';
    const XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_STATE                    = 'connector_data_mapping/customer_data/delivery_state';
    const XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_COUNTRY                  = 'connector_data_mapping/customer_data/delivery_country';
    const XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_POSTCODE                 = 'connector_data_mapping/customer_data/delivery_postcode';
    const XML_PATH_CONNECTOR_CUSTOMER_DELIVERY_TELEPHONE                = 'connector_data_mapping/customer_data/delivery_telephone';
    const XML_PATH_CONNECTOR_CUSTOMER_TOTAL_NUMBER_ORDER                = 'connector_data_mapping/customer_data/number_of_orders';
    const XML_PATH_CONNECTOR_CUSTOMER_AOV                               = 'connector_data_mapping/customer_data/average_order_value';
    const XML_PATH_CONNECTOR_CUSTOMER_TOTAL_SPEND                       = 'connector_data_mapping/customer_data/total_spend';
    const XML_PATH_CONNECTOR_CUSTOMER_LAST_ORDER_DATE                   = 'connector_data_mapping/customer_data/last_order_date';
    const XML_PATH_CONNECTOR_CUSTOMER_LAST_ORDER_ID                     = 'connector_data_mapping/customer_data/last_order_id';
    const XML_PATH_CONNECTOR_CUSTOMER_TOTAL_REFUND                      = 'connector_data_mapping/customer_data/total_refund';
    const XML_PATH_CONNECTOR_CUSTOMER_LAST_ORDER_INCREMENT_ID           = 'connector_data_mapping/customer_data/last_increment_id';
    const XML_PATH_CONNECTOR_CUSTOMER_MOST_PURCHASED_CATEGORY           = 'connector_data_mapping/customer_data/most_pur_category';
    const XML_PATH_CONNECTOR_CUSTOMER_MOST_PURCHASED_BRAND              = 'connector_data_mapping/customer_data/most_pur_brand';
    const XML_PATH_CONNECTOR_CUSTOMER_MOST_FREQUENT_PURCHASE_DAY        = 'connector_data_mapping/customer_data/most_freq_pur_day';
    const XML_PATH_CONNECTOR_CUSTOMER_MOST_FREQUENT_PURCHASE_MONTH      = 'connector_data_mapping/customer_data/most_freq_pur_mon';
    const XML_PATH_CONNECTOR_CUSTOMER_FIRST_CATEGORY_PURCHASED          = 'connector_data_mapping/customer_data/first_category_pur';
    const XML_PATH_CONNECTOR_CUSTOMER_LAST_CATEGORY_PURCHASED           = 'connector_data_mapping/customer_data/last_category_pur';
    const XML_PATH_CONNECTOR_CUSTOMER_FIRST_BRAND_PURCHASED             = 'connector_data_mapping/customer_data/first_brand_pur';
    const XML_PATH_CONNECTOR_CUSTOMER_LAST_BRAND_PURCHASED              = 'connector_data_mapping/customer_data/last_brand_pur';
    const XML_PATH_CONNECTOR_CUSTOMER_SUBSCRIBER_STATUS                 = 'connector_data_mapping/customer_data/subscriber_status';
    const XML_PATH_CONNECTOR_ABANDONED_PRODUCT_NAME                     = 'connector_data_mapping/customer_data/abandoned_prod_name';

	const XML_PATH_CONNECTOR_ENTERPRISE_CURRENT_BALANCE                 = 'connector_data_mapping/enterprise_data/reward_points';
	const XML_PATH_CONNECTOR_ENTERPRISE_REWARD_AMOUNT                   = 'connector_data_mapping/enterprise_data/reward_amount';
	const XML_PATH_CONNECTOR_ENTERPRISE_CREATED_DATE                    = 'connector_data_mapping/enterprise_data/created_date';
	const XML_PATH_CONNECTOR_ENTERPRISE_EXPIRATION_DATE                 = 'connector_data_mapping/enterprise_data/expiration_date';
	const XML_PATH_CONNECTOR_ENTERPIRSE_LAST_USED_DATE                  = 'connector_data_mapping/enterprise_data/last_used_date';
	const XML_PATH_CONNECTOR_ENTERPRISE_CUSTOMER_SEGMENTS               = 'connector_data_mapping/enterprise_data/customer_segment';


	/**
     * Dynamic Content
     */
    const XML_PATH_CONNECTOR_DYNAMIC_CONTENT_PASSCODE                   = 'connector_dynamic_content/external_dynamic_content_urls/passcode';
    const XML_PATH_CONNECTOR_DYNAMIC_CONTENT_NOSTO                      = 'connector_dynamic_content/nosto_recommendation/api';
    const XML_PATH_CONNECTOR_DYNAMIC_CONTENT_WIHSLIST_DISPLAY           = 'connector_dynamic_content/products/wishlist_display_type';

    /**
     * CONFIGURATION SECTION.
     */
    //Data Fields
    const XML_PATH_CONNECTOR_SYNC_DATA_FIELDS_STATUS                    = 'connector_configuration/data_fields/order_status';

    //Transactional Data
    const XML_PATH_CONNECTOR_SYNC_ORDER_STATUS                  = 'connector_configuration/transactional_data/order_statuses';
    const XML_PATH_CONNECTOR_CUSTOM_ORDER_ATTRIBUTES            = 'connector_configuration/transactional_data/order_custom_attributes';
    const XML_PATH_CONNECTOR_CUSTOM_QUOTE_ATTRIBUTES            = 'connector_configuration/transactional_data/quote_custom_attributes';
	const XML_PATH_CONNECTOR_SYNC_ORDER_PRODUCT_ATTRIBUTES      = 'connector_configuration/transactional_data/order_product_attributes';
	const XML_PATH_CONNECTOR_SYNC_ORDER_PRODUCT_CUSTOM_OPTIONS  = 'connector_configuration/transactional_data/order_product_custom_options';
    //Admin
    const XML_PATH_CONNECTOR_DISABLE_NEWSLETTER_SUCCESS     = 'connector_configuration/admin/disable_newsletter_success';
    const XML_PATH_CONNECTOR_DISABLE_CUSTOMER_SUCCESS       = 'connector_configuration/admin/disable_customer_success';
    //Dynamic Content Styling
    const XML_PATH_CONNECTOR_DYNAMIC_STYLING                = 'connector_configuration/dynamic_content_style/dynamic_syling';
    const XML_PATH_CONNECTOR_DYNAMIC_NAME_COLOR             = 'connector_configuration/dynamic_content_style/name_color';
    const XML_PATH_CONNECTOR_DYNAMIC_NAME_FONT_SIZE         = 'connector_configuration/dynamic_content_style/font_size';
    const XML_PATH_CONNECTOR_DYNAMIC_NAME_STYLE             = 'connector_configuration/dynamic_content_style/name_style';
    const XML_PATH_CONNECTOR_DYNAMIC_PRICE_COLOR            = 'connector_configuration/dynamic_content_style/price_color';
    const XML_PATH_CONNECTOR_DYNAMIC_PRICE_FONT_SIZE        = 'connector_configuration/dynamic_content_style/price_font_size';
    const XML_PATH_CONNECTOR_DYNAMIC_PRICE_STYLE            = 'connector_configuration/dynamic_content_style/price_style';
    const XML_PATH_CONNECTOR_DYNAMIC_LINK_COLOR             = 'connector_configuration/dynamic_content_style/link_color';
    const XML_PATH_CONNECTOR_DYNAMIC_LINK_FONT_SIZE         = 'connector_configuration/dynamic_content_style/link_font_size';
    const XML_PATH_CONNECTOR_DYNAMIC_LINK_STYLE             = 'connector_configuration/dynamic_content_style/link_style';
    const XML_PATH_CONNECTOR_DYNAMIC_DOC_FONT               = 'connector_configuration/dynamic_content_style/font_picker';
    const XML_PATH_CONNECTOR_DYNAMIC_DOC_BG_COLOR           = 'connector_configuration/dynamic_content_style/doc_color';
    const XML_PATH_CONNECTOR_DYNAMIC_OTHER_COLOR            = 'connector_configuration/dynamic_content_style/other_color';
    const XML_PATH_CONNECTOR_DYNAMIC_OTHER_FONT_SIZE        = 'connector_configuration/dynamic_content_style/other_font_size';
    const XML_PATH_CONNECTOR_DYNAMIC_OTHER_STYLE            = 'connector_configuration/dynamic_content_style/other_style';
    const XML_PATH_CONNECTOR_DYNAMIC_COUPON_COLOR           = 'connector_configuration/dynamic_content_style/coupon_color';
    const XML_PATH_CONNECTOR_DYNAMIC_COUPON_FONT_SIZE       = 'connector_configuration/dynamic_content_style/coupon_font_size';
    const XML_PATH_CONNECTOR_DYNAMIC_COUPON_STYLE           = 'connector_configuration/dynamic_content_style/coupon_styles';
    const XML_PATH_CONNECTOR_DYNAMIC_COUPON_FONT            = 'connector_configuration/dynamic_content_style/coupon_font_picker';
    const XML_PATH_CONNECTOR_DYNAMIC_COUPON_BG_COLOR        = 'connector_configuration/dynamic_content_style/coupon_doc_color';

    //Catalog
    const XML_PATH_CONNECTOR_SYNC_CATALOG_VALUES            = 'connector_configuration/catalog_sync/catalog_values';
    const XML_PATH_CONNECTOR_SYNC_CATALOG_VISIBILITY        = 'connector_configuration/catalog_sync/catalog_visibility';
    const XML_PATH_CONNECTOR_SYNC_CATALOG_TYPE              = 'connector_configuration/catalog_sync/catalog_type';
    //Abandoned Cart
    const XML_PATH_CONNECTOR_EMAIL_CAPTURE                  = 'connector_configuration/abandoned_carts/email_capture';
    const XML_PATH_CONNECTOR_ABANDONED_CART_LIMIT           = 'connector_configuration/abandoned_carts/limits';
	const XML_PATH_CONNECTOR_EMAIL_CAPTURE_NEWSLETTER       = 'connector_configuration/abandoned_carts/email_capture_newsletter';
	const XML_PATH_CONNECTOR_CONTENT_LINK_ENABLED           = 'connector_configuration/abandoned_carts/link_enabled';
    const XML_PATH_CONNECTOR_CONTENT_LINK_TEXT              = 'connector_configuration/abandoned_carts/link_text';
    const XML_PATH_CONNECTOR_CONTENT_CART_URL               = 'connector_configuration/abandoned_carts/cart_url';
    const XML_PATH_CONNECTOR_CONTENT_LOGIN_URL              = 'connector_configuration/abandoned_carts/login_url';
    // Address Book Pref
    const XML_PATH_CONNECTOR_ADDRESSBOOK_PREF_CAN_CHANGE_BOOKS  = 'connector_configuration/address_book_pref/can_change';
    const XML_PATH_CONNECTOR_ADDRESSBOOK_PREF_SHOW_BOOKS        = 'connector_configuration/address_book_pref/show_books';
    const XML_PATH_CONNECTOR_ADDRESSBOOK_PREF_CAN_SHOW_FIELDS   = 'connector_configuration/address_book_pref/can_show_fields';
    const XML_PATH_CONNECTOR_ADDRESSBOOK_PREF_SHOW_FIELDS       = 'connector_configuration/address_book_pref/fields_to_show';
    //Dynamic Content
    const XML_PATH_CONNECTOR_DYNAMIC_CONTENT_LINK_TEXT          = 'connector_configuration/dynamic_content_edit/link_text';

    /**
     * Automation studio.
     */
    const XML_PATH_CONNECTOR_AUTOMATION_STUDIO_CUSTOMER      = 'connector_automation/visitor_automation/customer_automation';
    const XML_PATH_CONNECTOR_AUTOMATION_STUDIO_SUBSCRIBER    = 'connector_automation/visitor_automation/subscriber_automation';
    const XML_PATH_CONNECTOR_AUTOMATION_STUDIO_ORDER         = 'connector_automation/visitor_automation/order_automation';
    const XML_PATH_CONNECTOR_AUTOMATION_STUDIO_GUEST_ORDER   = 'connector_automation/visitor_automation/guest_order_automation';
    const XML_PATH_CONNECTOR_AUTOMATION_STUDIO_REVIEW        = 'connector_automation/visitor_automation/review_automation';
    const XML_PATH_CONNECTOR_AUTOMATION_STUDIO_WISHLIST      = 'connector_automation/visitor_automation/wishlist_automation';
    const XML_PATH_CONNECTOR_AUTOMATION_STUDIO_ORDER_STATUS  = 'connector_automation/order_status_automation/program';


    /**
     * ROI SECTION.
     */
    const XML_PATH_CONNECTOR_ROI_TRACKING_ENABLED           = 'connector_configuration/tracking/roi_enabled';
    const XML_PATH_CONNECTOR_PAGE_TRACKING_ENABLED          = 'connector_roi_tracking/tracking/page_enabled';

    /**
     * OAUTH
     */
    const API_CONNECTOR_OAUTH_URL                           = 'https://my.dotmailer.com/';
    const API_CONNECTOR_OAUTH_URL_AUTHORISE                 = 'OAuth2/authorise.aspx?';
    const API_CONNECTOR_OAUTH_URL_TOKEN                     = 'OAuth2/Tokens.ashx';
    const API_CONNECTOR_OAUTH_URL_LOG_USER                  = '?oauthtoken=';

    const CONNECTOR_FEED_LAST_CHECK_TIME                    = 'connector_feed_last_check_time';

    /**
     * Reviews SECTION
     */
    const XML_PATH_REVIEWS_ENABLED                          = 'connector_automation/review_settings/enabled';
    const XML_PATH_REVIEWS_FEEFO_LOGON                      = 'connector_automation/feefo_feedback_engine/logon';
    const XML_PATH_REVIEWS_FEEFO_REVIEWS                    = 'connector_automation/feefo_feedback_engine/reviews_per_product';
    const XML_PATH_REVIEWS_FEEFO_TEMPLATE                   = 'connector_automation/feefo_feedback_engine/template';


	/**
	 * Developer SECTION.
	 */
	const XML_PATH_CONNECTOR_FEED_URL                       = 'connector_developer_settings/feed_configuration/feed_url';
	const XML_PATH_CONNECTOR_CLIENT_ID                      = 'connector_developer_settings/oauth/client_id';
	const XML_PATH_CONNECTOR_SYNC_LIMIT                     = 'connector_developer_settings/import_settings/batch_size';
	const XML_PATH_CONNECTOR_FEED_ENABLED                   = 'connector_developer_settings/feed_configuration/feed_enabled';
	const XML_PATH_RAYGUN_APPLICATION_CODE                  = 'connector_developer_settings/debug/raygun_code';
	const XML_PATH_CONNECTOR_CUSTOM_DOMAIN                  = 'connector_developer_settings/oauth/custom_domain';
	const XML_PATH_CONNECTOR_FEED_FREQUENCY                 = 'connector_developer_settings/feed_configuration/frequency';
	const XML_PATH_RAYGUN_APPLICATION_ASYNC                 = 'connector_developer_settings/debug/raygun_async';
	const XML_PATH_CONNECTOR_FEED_USE_HTTPS                 = 'connector_developer_settings/feed_configuration/use_https';
	const XML_PATH_CONNECTOR_SETUP_DATAFIELDS               = 'connector_developer_settings/sync_settings/setup_data_fields';
	const XML_PATH_CONNECTOR_CLIENT_SECRET_ID               = 'connector_developer_settings/oauth/client_key';
	const XML_PATH_CONNECTOR_CUSTOM_AUTHORIZATION           = 'connector_developer_settings/oauth/custom_authorization';
	const XML_PATH_CONNECTOR_RESOURCE_ALLOCATION            = 'connector_developer_settings/import_settings/memory_limit';
	const XML_PATH_CONNECTOR_ADVANCED_DEBUG_ENABLED         = 'connector_developer_settings/debug/debug_enabled';
	const XML_PATH_CONNECTOR_DEBUG_API_REQUEST_LIMIT        = 'connector_developer_settings/debug/api_request_time_limit';
	const XML_PATH_CONNECTOR_TRANSACTIONAL_DATA_SYNC_LIMIT  = 'connector_developer_settings/import_settings/transactional_data';

	/**
     * Nosto
     */
    const API_ENDPOINT                                      = 'https://api.nosto.com';
    const API_ENDPOINT_TEST                                 = 'https://test.api.nosto.com';

	protected $_storeManager;

	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Framework\ObjectManagerInterface $objectManager,
		\Magento\Store\Model\StoreManagerInterface $storeManager
	)
	{
		$this->_storeManager = $storeManager;
		$this->_objectManager = $objectManager;

		parent::__construct($context);
	}

    /**
     * @param int $website
     *
     * @return bool
     */
    public function getAuthorizeLinkFlag($website = 0)
    {
	    $website = $this->_storeManager->getWebsite($website);
        $customDomain = $website->getConfig(self::XML_PATH_CONNECTOR_CUSTOM_DOMAIN);

        return (bool)$customDomain;
    }

    /**
     * @param int $website
     *
     * @return string
     */
    public function getAuthorizeLink($website = 0)
    {
        //base url, check for custom oauth domain
        if ($this->getAuthorizeLinkFlag($website)){
	        $website = $this->_storeManager->getWebsite($website);
            $baseUrl = $website->getConfig(self::XML_PATH_CONNECTOR_CUSTOM_DOMAIN) . self::API_CONNECTOR_OAUTH_URL_AUTHORISE;

        } else {
            $baseUrl = self::API_CONNECTOR_OAUTH_URL .  self::API_CONNECTOR_OAUTH_URL_AUTHORISE;
        }

        return $baseUrl;
    }

	/**
	 * Callback authorization url.
	 * @return mixed|string
	 */
	public function getCallbackUrl()
	{
		if ($callback = $this->scopeConfig->getValue(self::XML_PATH_CONNECTOR_CUSTOM_AUTHORIZATION)){
			return $callback;
		}

		return $redirectUri = $this->_storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_WEB);
	}

    /**
     * @param int $website
     *
     * @return string
     */
    public function getTokenUrl($website = 0)
    {
        if ($this->getAuthorizeLinkFlag($website)) {
	        $website = $this->_storeManager->getWebsite($website);

            $tokenUrl = $website->getConfig(self::XML_PATH_CONNECTOR_CUSTOM_DOMAIN) . self::API_CONNECTOR_OAUTH_URL_TOKEN;
        } else {

            $tokenUrl = self::API_CONNECTOR_OAUTH_URL . self::API_CONNECTOR_OAUTH_URL_TOKEN;
        }

        return $tokenUrl;
    }


    /**
     * @param int $website
     *
     * @return string
     */
    public function getLogUserUrl( $website = 0 )
    {
        if ($this->getAuthorizeLinkFlag($website)) {
	        $website = $this->_storeManager->getWebsite($website);

            $logUserUrl = $website->getConfig(self::XML_PATH_CONNECTOR_CUSTOM_DOMAIN) . self::API_CONNECTOR_OAUTH_URL_LOG_USER;
        } else {

            $logUserUrl = self::API_CONNECTOR_OAUTH_URL . self::API_CONNECTOR_OAUTH_URL_LOG_USER;
        }
        return $logUserUrl;
    }

}