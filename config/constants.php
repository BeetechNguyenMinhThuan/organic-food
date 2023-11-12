<?php
const FILESYSTEM = 'public';

// Upload directories
const PRODUCT_DIR = 'products';
const SLIDER_DIR = 'sliders';
const USER_DIR = 'users';
const CATEGORY_DIR = 'categories';
const BRAND_DIR = 'brands';
const BAD_REQUEST = 400;
define('NOTFOUND', 404);
define('FORBIDDEN', 403);
define('ORDER_PREFIX', "#OD");
define('TAKE_ORDER_HISTORY', 12);
define('SUB_DAYS', 30);
define('LIMIT_CATE_PRODUCTS', 4);
define('LIMIT_RECENTLY_VIEWED_PRODUCTS', 12);
define('VIEWED_PRODUCT_MAX', 12);
define('TIME_TO_EXIST', 60 * 60 * 24 * 60);
define('TIME_COOKIE_VIEWED_TO_EXIST', 60 * 24 * 60);
define('ADD_PLUS_SERIAL', 1);
define('VAT', 10/100);
define('SHIP_FEE_ZERO', 0);
define('SHIP_FEE', 1000);
define('LIMIT_RECENT_USED_ADDRESS', 5);
define('PAGINATION_NUMBER', 50);
define('DEFAULT_SERIAL', 1);
define('PAGINATION_NUMBER_FAVORITE', 40);
define('ZERO_ID', 0);
define('TABLE_ORDER_SHIPPING_ADDRESS', 1);
define('TABLE_USER_ADDRESS', 2);
define('IMAGE_DEFAULT', 'images/placeholder/placeholder_350.png');
