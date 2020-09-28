<?php
namespace App\Helpers;
class Constants
{
    const PLATFORM_ID = 'WEB';
    const VERSION = '1.0';
    const CHANNEL = 1;

    const STATUS_POST_PUBLISHED = 'published';
    const STATUS_POST_DRAFT = 'draft';
    const STATUS_POST_ALONE = 'alone';
    const STATUS_POST_FRIENDS = 'friends';

    CONST STATUS_COMMENT_POST_BLOCK = 0;
    CONST STATUS_COMMENT_POST_UNBLOCK = 1;

    const REFERRAL_COOKIE_KEY = 'referral_code';
    // Account Status
    const ACCOUNT_STATUS_ACTIVE     = 'active';
    const ACCOUNT_STATUS_INACTIVE   = 'inactive';

    public static $ACCOUNT_STATUS = [
        self::ACCOUNT_STATUS_ACTIVE     => 'Active',
        self::ACCOUNT_STATUS_INACTIVE   => 'Inactive',
    ];

    const NUMBER_DECIMALS = 2;
    const MAX_DAY_TO_REPORT = 30;

    const PER_PAGE_DEFAULT = 20;
    const PER_PAGE_DEFAULT_MOBILE = 8;

    // Locked Account Mechanism //
    const APP_FAIL_ATTEMPTS = 5;
    const USER_STATUS_LOCK = 'Lock';
    const USER_STATUS_UNLOCK = 'Unlock';

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    public static $STATUS = [
        self::STATUS_ENABLE => 'Enable',
        self::STATUS_DISABLE => 'Disable',
    ];

    const LANG_SIMPLIFIED_CHINESE = 'zh';
    const LANG_EN = 'en';
    const LANG_CN = 'cn';

    public static $LANGUAGES = [
        self::LANG_CN => 'Chinese',
        self::LANG_EN => 'English',
    ];

    const USER_TYPE_USER = 0;
    const USER_TYPE_ADMIN = 1;
    const USER_TYPE_STAFF = 2;
    const USER_TYPE_VIEWER = 3;
    public static $USER = [
        self::USER_TYPE_USER => 'Guest',
        self::USER_TYPE_ADMIN => 'Admin',
        self::USER_TYPE_STAFF => 'Staff',
    ];

    const MOVIE_STATUS_INACTIVE = 0;
    const MOVIE_STATUS_ACTIVE = 1;
    public static $MOVIES_STATUS = [
        self::MOVIE_STATUS_ACTIVE     => 'Active',
        self::MOVIE_STATUS_INACTIVE   => 'Inactive',
    ];

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 0;
    public static $GENDER = [
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female',
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;
    public static $STATUS2 = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];

    const ADS_TYPE_VIDEO = 1;
    const ADS_TYPE_IMAGE = 2;
    const ADS_TYPE_SCRIPT = 3;
    public static $ADS_TYPE = [
        self::ADS_TYPE_VIDEO => 'Video',
        self::ADS_TYPE_IMAGE => 'Image',
        self::ADS_TYPE_SCRIPT => 'Script',
    ];

    const ADS_POSITION_TOP = 'top';
    const ADS_POSITION_BANNER = 'banner';
    const ADS_POSITION_LEFT = 'left';
    const ADS_POSITION_RIGHT = 'right';
    const ADS_POSITION_CONTAIN = 'contain';
    public static $ADS_POSITION = [
        self::ADS_POSITION_TOP => 'Top',
        self::ADS_POSITION_BANNER => 'Banner',
        self::ADS_POSITION_LEFT => 'Left',
        self::ADS_POSITION_RIGHT => 'Right',
        self::ADS_POSITION_CONTAIN => 'Contain',
    ];

    const SETTING_IMAGE = '1';
    const SETTING_TEXT = '2';
    public static $SETTING = [
        self::SETTING_IMAGE => 'Image',
        self::SETTING_TEXT => 'Text',
    ];

    const MOVIES_STATUS_NO_PROCESS = 1;
    const MOVIES_STATUS_PROCESSED = 0;
    public static $REPORT_MOVIES_STATUS = [
        self::MOVIES_STATUS_NO_PROCESS => 'No Process',
        self::MOVIES_STATUS_PROCESSED => 'Processed',
    ];

    const PARENT_SLIDER = 0;
    const IMAGE_EMPTY = "";

    const SLIDER_HOME = 'Slider Home';
    const MENU_HEADER = 'header';
    const MENU_FOOTER = 'footer';

    const HOME_SETTING_TYPE_CONTENT_WITHOUT_ADS = 0;
    const HOME_SETTING_TYPE_CONTENT_WITH_ADS_LEFT = 1;
    const HOME_SETTING_TYPE_CONTENT_WITH_ADS_RIGHT = 2;
    const HOME_SETTING_TYPE_CONTENT_WITH_ADS_TOP = 3;
    const HOME_SETTING_TYPE_CONTENT_WITH_ADS_BOTTOM = 4;
    const HOME_SETTING_TYPE_SLIDE = 5;
    const HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_TOP = 6;
    const HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_BOTTOM = 7;
    const HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_BOTH_TOP_BOTTOM = 8;
    const HOME_SETTING_TYPE_SIDEBAR_WITHOUT_ADS = 9;
    const NOT_HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_TOP = 10;
    const NOT_HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_BOTTOM = 11;
    const NOT_HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_BOTH_TOP_BOTTOM = 12;
    const NOT_HOME_SETTING_TYPE_SIDEBAR_WITHOUT_ADS = 13;
    public static $HOME_SETTING_TYPE = [
        self::HOME_SETTING_TYPE_CONTENT_WITHOUT_ADS => 'Content without ads',
        self::HOME_SETTING_TYPE_CONTENT_WITH_ADS_LEFT => 'Content with ads on the left',
        self::HOME_SETTING_TYPE_CONTENT_WITH_ADS_RIGHT => 'Content with ads on the right',
        self::HOME_SETTING_TYPE_CONTENT_WITH_ADS_TOP => 'Content with ads on the top',
        self::HOME_SETTING_TYPE_CONTENT_WITH_ADS_BOTTOM => 'Content with ads under the bottom',
        self::HOME_SETTING_TYPE_SLIDE => 'Slider',
        self::HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_TOP => 'Sidebar with ads on the top',
        self::HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_BOTTOM => 'Sidebar with ads on the bottom',
        self::HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_BOTH_TOP_BOTTOM => 'Sidebar with ads both top and bottom',
        self::HOME_SETTING_TYPE_SIDEBAR_WITHOUT_ADS => 'Sidebar without ads',
        self::NOT_HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_TOP => 'Sidebar not home with ads on the top',
        self::NOT_HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_BOTTOM => 'Sidebar not home with ads on the bottom',
        self::NOT_HOME_SETTING_TYPE_SIDEBAR_WITH_ADS_BOTH_TOP_BOTTOM => 'Sidebar not home with ads both top and bottom',
        self::NOT_HOME_SETTING_TYPE_SIDEBAR_WITHOUT_ADS => 'Sidebar not home without ads',
    ];

    const STATUS_FINSHED = 1;
    const STATUS_NOT_RELEASE = 0;
    public static $STATUS_RELEASE_MOVIE = [
        self::STATUS_FINSHED => 'Finished',
        self::STATUS_NOT_RELEASE => 'Not release',
    ];

    const KEY_SHARE_DATA_SIDEBAR_NOT_HOME = 'content_sidebar_not_home';    

    public static $KEY_SHOW_HOME_CONTENT_OPEN_TAG = [1,3];
    public static $KEY_SHOW_HOME_CONTENT_CLOSE_TAG = [1,4];
    public static $KEY_SHOW_HOME_SIDEBAR_OPEN_TAG = [2,5];
    public static $KEY_SHOW_HOME_SIDEBAR_CLOSE_TAG = [2,5];
    public static $KEY_SHOW_HOME_WITH_FULLWIDTH_ADS = [2];
    
    const LIMIT_WORDS_GET = 2;
    const LIMIT_CHARACTER_GET = 20;
    const LIMIT_CHARACTER = '';

    const MOVIE_NOT_EPISODE = 0;
    const MOVIE_IS_EPISODE = 1;
    public static $MOVIES_STATUS_EPISODE = [
        self::MOVIE_IS_EPISODE     => 'Yes',
        self::MOVIE_NOT_EPISODE   => 'No',
    ];

    const IS_SERIES_MOVIES = 1;
    const NUMBER_MOVIE_YOU_WANT_TO_SEE = 8;
    const NUMBER_TO_USE_MEGAMENU_GREATE_THAN = 8;

    const ITEMS_PER_ROW = 4;

    const TYPE_ADD_TO_HISTORY_WATCH_MOVIE = 1;
    const TYPE_ADD_TO_COLLECTION_MOVIE = 2;
    public static $TYPE_ADD_TO_USER_MOVIE = [
        self::TYPE_ADD_TO_HISTORY_WATCH_MOVIE => 'History watch movie',
        self::TYPE_ADD_TO_COLLECTION_MOVIE => 'Collection movie',
    ];

    const STATUS_MOVIE_WATCH_LATER = 0;
    const STATUS_MOVIE_WATCHED = 1;
    public static $MOVIE_WATCH = [
        self::STATUS_MOVIE_WATCH_LATER => 'Watch later',
        self::STATUS_MOVIE_WATCHED => 'Watched',
    ];

    const NUMBER_ID_YOUTUBE = 11;
}
