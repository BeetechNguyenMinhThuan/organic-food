<?php

namespace App\Helpers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use Barryvdh\DomPDF\Facade as PDF;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Nette\FileNotFoundException;

class Common
{

    const PRODUCT_DETAIL_DATA_CODE_TEXT = "data_code";
    const RANDOM_STRING_CHARSET = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9", "A", "B", "C", "D", "E", "F", "G",
        "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z"];
    const FORMAT_HALF_SIZE_CHAR = "/^[a-zA-Z0-9-]+$/";

    /**
     * Check Product New
     *
     * @param $created_at
     * @return bool
     */
    public static function checkOrderStatus($status){
        $html = "";
        if($status == Order::PENDING){
            $html = '<span class="badge rounded-pill alert-dark badge-dark-lighten">Pending</span>';
        }elseif($status == Order::CANCELLED){
            $html = '<span class="badge rounded-pill alert-danger badge-danger-lighten">Cancelled</span>';
        }elseif($status == Order::COMPLETED){
            $html = '<span class="badge rounded-pill alert-success badge-success-lighten">Completed</span>';
        }elseif($status == Order::DELIVERED){
            $html = '<span class="badge rounded-pill alert-info badge-info-lighten">Delivered</span>';
        }elseif($status == Order::SHIPPED){
            $html = '<span class="badge rounded-pill alert-warning badge-warning-lighten">Shipped</span>';
        }
        return $html;
    }
    public static function checkProductNew($created_at)
    {
        $subDays = Carbon::now()->subDays(SUB_DAYS);
        if ($created_at >= $subDays) {
            return true;
        }
        return false;
    }

    public static function getImage($img)
    {
        try {
            if (empty($img)) {
                $image = asset('/images/img-default.jpg');
            } else {
                $image = Storage::disk(FILESYSTEM)->url($img);
            }
            return $image;
        } catch (FileNotFoundException $e) {
            return null;
        }
    }

    /**
     * @param $string
     * @return string
     */
    public static function escapeLike($string)
    {
        $search = array('\\', '%', '_');
        $replace = array('\\\\', '\%', '\_');
        return str_replace($search, $replace, $string);
    }

    /**
     * Change Date
     *
     * @param $date
     * @return string
     */
    public static function changeDate($date)
    {
        return date('Y' . trans('messages.year') . 'm' . trans('messages.month') . 'd' . trans('messages.day'), strtotime($date));
    }

    /**
     * Change Date Time
     *
     * @param $date
     * @return string
     */
    public static function changeDateTime($date)
    {
        return date('Y' . trans('messages.year') . 'm' . trans('messages.month') . 'd' . trans('messages.day') . ' H:i:s', strtotime($date));
    }

    /**
     * Change Date Time Part
     *
     * @param $date
     * @return string
     */
    public static function changeDateTimePart($date)
    {
        return date('Y' . trans('messages.year') . 'm' . trans('messages.month') . 'd' . trans('messages.day') . ' H' . trans('messages.hour') . 'i' . trans('messages.minutes'), strtotime($date));
    }

    /**
     * Get date now
     *
     * @param string $format
     * @return string
     */
    public static function getDateStringNow($format = 'ymdHis.sss')
    {
        return Carbon::now()->format($format);
    }

    /**
     * Get cart hash id
     *
     * @param $cartID
     * @return string
     */
    public static function getCartHashId($cartID)
    {
        return Hash::make(self::getDateStringNow() . '-' . $cartID);
    }

    /**
     * @param $totalPrice
     * @return float|int
     */
    public static function getTax($totalPrice)
    {
        return $totalPrice * VAT;
    }

    /**
     * Get ship
     * @param float $totalWeight SUM(weight)
     * @param float $maxRollerLength ローラ幅 (max)
     * @param float $subTotalPrice 合計(税別)
     * @return float ShipFee
     */


    /**
     * Format Number Price
     *
     * @param $price
     * @param int $length
     * @return string
     */
    public static function getFormatNumberPrice($price, int $length = 0)
    {
        $priceFormat = 0;

        if ($price) {
            $priceFormat = number_format($price, $length, '.', ',') . "<sup>đ</sup>";
        }

        return $priceFormat;
    }

    /**
     * @param $product
     * @param bool $format
     * @return string|null
     */


    /**
     * replace string
     *
     * @param $string
     * @param int $length
     * @param string $char
     * @return string
     */
    public static function truncate($string, $length = 40, $char = '...')
    {
        return Str::limit($string, $length, $char);
    }

    /**
     * return index number from, index number to
     *
     * @param object $items
     * @return array $fromItem
     */
    public static function dataPageInfo($items)
    {
        $infoPageReturn = [];
        $itemFrom = ($items->currentPage() - 1) * $items->perPage() + 1;
        $itemTo = $items->currentPage() * $items->perPage();
        if (($items->currentPage()) == $items->lastPage()) {
            $itemTo = $items->total();
        }
        $infoPageReturn['from'] = $itemFrom;
        $infoPageReturn['to'] = $itemTo;
        return $infoPageReturn;
    }

    /**
     * return index number from, index number to
     *
     * @param $currentPage
     * @param $perPage
     * @param $total
     * @return array $fromItem
     */
    public static function dataPageInfoByHand($currentPage, $perPage, $total)
    {
        $infoPageReturn = [];
        $itemFrom = ($currentPage - 1) * $perPage + 1;
        $itemTo = $currentPage * $perPage;
        $lastPage = (int)($total / $perPage);
        if ($total % $perPage > 0) {
            $lastPage += 1;
        }
        if ($currentPage == $lastPage) {
            $itemTo = $total;
        }
        $infoPageReturn['from'] = $itemFrom;
        $infoPageReturn['to'] = $itemTo;
        return $infoPageReturn;
    }

    /**
     * Return value input if has session
     *
     * @param int $name
     * @param array $step
     * @return string value input
     */
    public static function getEmptySession($name, $step)
    {
        $result = null;
        if (!empty($step[$name])) {
            $result = $step[$name];
        }
        return $result;
    }

    /**
     * Add Symbol PostCode
     *
     * @param $postCode
     * @return string
     */
    public static function addSymbolPostCode($postCode)
    {
        return substr_replace($postCode, '-', 3, 0);
    }

    /**
     * Download File PDF
     *
     * @param $data
     * @param $name
     * @param $view
     * @return string
     */
    public static function downloadFilePDF(array $data, $name, $view)
    {
        $pdf = PDF::loadView($view, compact('data'));

        return $pdf->download($name . '.pdf');
    }

    /**
     * Name file export
     *
     * @param string $name
     * @return string
     */
    public static function nameFileExport($name)
    {
        return $name . '[' . Carbon::now()->format('Ymd') . '].xlsx';
    }

    /**
     * Get rating start
     *
     * @param float $rating
     * @return string
     */

    public static function starRating($rating)
    {
        $ratingRound = round($rating * 2) / 2;
        $html = '';

        if ($ratingRound <= 0.5 && $ratingRound > 0) {
            $html = '<i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
        }
        if ($ratingRound <= 1 && $ratingRound > 0.5) {
            $html = '<i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
        }
        if ($ratingRound <= 1.5 && $ratingRound > 1) {
            $html = '<i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
        }
        if ($ratingRound <= 2 && $ratingRound > 1.5) {
            $html = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
        }
        if ($ratingRound <= 2.5 && $ratingRound > 2) {
            $html = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
        }
        if ($ratingRound <= 3 && $ratingRound > 2.5) {
            $html = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i><i class="fa fa-star-o"></i>';
        }
        if ($ratingRound <= 3.5 && $ratingRound > 3) {
            $html = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i><i class="fa fa-star-o"></i>';
        }
        if ($ratingRound <= 4 && $ratingRound > 3.5) {
            $html = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-o"></i>';
        }
        if ($ratingRound <= 4.5 && $ratingRound > 4) {
            $html = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star-half-o"></i>';
        }
        if ($ratingRound <= 5 && $ratingRound > 4.5) {
            $html = '<i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i>';
        }

        return $html;
    }

    /**
     * Check all category or detail category
     *
     * @param object $category
     * @return boolean $flagCategoryDetail
     */


    /**
     * @param $baseMess
     * @param array $params
     * @return mixed|string|string[]
     */
    public static function getMessage($baseMess, array $params)
    {
        if (empty($params)) {
            return $baseMess;
        }
        $i = 0;
        foreach ($params as $param) {
            $baseMess = str_replace("{" . $i . "}", $param, $baseMess);
            $i++;
        }
        return $baseMess;
    }

    /**
     * Check menu item active
     * @param array $path
     * @param string $active
     * @return string
     */
    public static function setActive(array $path, $active = 'active')
    {
        $name = Route::currentRouteName();
        return in_array($name, $path, true) ? $active : '';
    }

    /**
     * Check menu tree view open
     * @param array $subMenu
     * @param string $menuOpen
     * @return string
     */
    public static function setTreeViewOpen(array $subMenu, $menuOpen = 'menu-open')
    {
        $name = Route::currentRouteName();
        return in_array($name, $subMenu, true) ? $menuOpen : '';
    }

    /**
     * Get Text Purpose Review
     *
     * @param integer $purpose
     * @return string
     */
//    public static function getTextPurposeReview( $purpose )
//    {
//        if ( $purpose == ProductReview::PURPOSE_ROLLER_TRANSPORT_LINES ) {
//            $textPurpose = trans('messages.purpose_roller_transport_lines');
//        } elseif ( $purpose == ProductReview::PURPOSE_REPLACEMENT_ROLLER_TRANSPORT_LINES ) {
//            $textPurpose = trans('messages.purpose_replacement_roller_transport_lines');
//        } elseif ( $purpose == ProductReview::PURPOSE_OTHER_CONVEYOR ) {
//            $textPurpose = trans('messages.purpose_other_conveyors');
//        } elseif ( $purpose == ProductReview::PURPOSE_TEST_SAMPLE ) {
//            $textPurpose = trans('messages.purpose_test_sample');
//        } else {
//            $textPurpose = trans('messages.purpose_other');
//        }
//
//        return $textPurpose;
//    }

    /**
     * @param Exception $e
     * @param int $maxLine
     * @return string string to log
     */
    public static function getExceptionTrace(Exception $e, $maxLine = 20)
    {
        if (!$e) {
            return '';
        }
        $traceArray = $e->getTrace();
        $traceString = $e->getMessage() . PHP_EOL;
        foreach ($traceArray as $key => $trace) {
            if ($key > $maxLine) {
                break;
            }
            if (array_key_exists('class', $trace)) {
                $traceString .= $trace['class'];
            }
            if (array_key_exists('function', $trace)) {
                $traceString .= '.' . $trace['function'];
            }
            if (array_key_exists('line', $trace)) {
                $traceString .= ' line: ' . $trace['line'];
            }
            $traceString .= PHP_EOL;
        }
        return PHP_EOL . ": " . $traceString;
    }

    /**
     * @param string $mailAddress
     * @return string $mail_address
     */
    public static function replaceDotToUnderScoreOfMaillAddress(string $mailAddress)
    {
        return str_replace('.', '_', $mailAddress);
    }

    /**
     * @param $request
     * @return string|string[]
     */


    /**
     * @param $arrays
     * @return array
     */
    public static function removeArrayBlankvalue(array $arrays)
    {
        foreach ($arrays as $key => $value) {
            if (trim($value) == "") {
                unset($arrays[$key]);
            }
        }
        return $arrays;
    }

    /**
     * @param string $data
     * @return string
     */
    public static function trimAllSpaceType($data)
    {
        if (isset($data)) {
            return trim(str_replace("　", " ", $data));
        }
        return "";
    }

    /**
     * @param int $strLength
     * @return string
     */
    public static function getRandomUppercaseString($strLength = 8)
    {
        $maxIndex = count(self::RANDOM_STRING_CHARSET) - 1;
        $result = "";
        for ($i = 0; $i < $strLength; $i++) {
            $result .= self::RANDOM_STRING_CHARSET[mt_rand(0, $maxIndex)];
        }
        return $result;
    }

    /**
     * echo round_up(12345.23, 1); // 12345.3
     * echo round_up(12345.23, 0); // 12346
     * echo round_up(12340, -1); // 12340
     * echo round_up(12345.23, -1); // 12350
     * echo round_up(12345.23, -2); // 12400
     * echo round_up(12345.23, -3); // 13000
     * echo round_up(12345.23, -4); // 20000
     * @param $value
     * @param $places
     * @return float|int
     */
    public static function roundUp($value, $places)
    {
        // fix case $value 0.x = 0
        if ($places < 0 && $value > 0 && $value < 1) {
            $value += 1;
        }

        $absPlaces = abs($places);
        $mult = pow(10, $absPlaces);

        return $places < 0 ?
            ceil(bcdiv($value, $mult, $absPlaces)) * $mult :
            bcdiv(ceil(bcmul($value, $mult, 14)), $mult, $absPlaces);
    }

    /**
     * @param $value
     * @param $precision
     * @return float
     */
    public static function roundDown($value, $precision)
    {
        return round($value, $precision, PHP_ROUND_HALF_DOWN);
    }

    /**
     * Get code name by code
     *
     * @param array $codeNameMap
     * @param string $code
     * @return string
     */
    public static function getCodeName($code, array $codeNameMap = [])
    {
        if (array_key_exists($code, $codeNameMap)) {
            return $codeNameMap[$code];
        } else {
            return '';
        }
    }


    /**
     * Delete folder and all child
     *
     * @param string $dir Path of directory to be deleted.
     * @return bool
     */
    public static function delAllFolder($dir)
    {
        $files = array_diff(scandir($dir), array('.', '..'));
        foreach ($files as $file) {
            (is_dir("$dir/$file")) ? self::delAllFolder("$dir/$file") : unlink("$dir/$file");
        }
        return rmdir($dir);
    }


}


