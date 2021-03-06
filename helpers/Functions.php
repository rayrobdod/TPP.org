<?php

/**
 * Function Helper
 */
class FuncHelp
{

    public static function getDateTime($time, $secs = false) {
        $startTime = TPP_START_TIME;
        if (is_numeric($time)) {
            $getTime = $time - $startTime;
            if ($getTime > 0) {
                $return = '';
                foreach (self::secondsToTime($getTime, $secs) as $key => $value) {
                    $return .= $value . $key . ' ';
                }
                return substr($return, 0, -1);
            } else {
                return 'Waiting&hellip;';
            }
        } else {
            return $time;
        }
    }

    private static function secondsToTime($inputSeconds, $secs = false) {

        $secondsInAMinute = 60;
        $secondsInAnHour = 60 * $secondsInAMinute;
        $secondsInADay = 24 * $secondsInAnHour;

        $days = floor($inputSeconds / $secondsInADay);

        $hourSeconds = $inputSeconds % $secondsInADay;
        $hours = floor($hourSeconds / $secondsInAnHour);

        $minuteSeconds = $hourSeconds % $secondsInAnHour;
        $minutes = floor($minuteSeconds / $secondsInAMinute);

        $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        $seconds = ceil($remainingSeconds);

        $obj['d'] = (int)$days;
        $obj['h'] = (int)$hours;
        $obj['m'] = (int)$minutes;
        if ($secs) {
            $obj['s'] = (int)$seconds;
        }
        return $obj;
    }

    public static function safeName($name) {
        return strtolower(str_replace(
                [
                    ' ',
                    '.',
                    'é',
                    '-',
                    '\'',
                    '&eacute;',
                ], [
                '_',
                '',
                'e',
                '_',
                '',
                'e',
            ], $name)
        );
    }

    public static function getHmMoves() {
        return [
            'Cut',
            'Fly',
            'Surf',
            'Strength',
            'Flash',
            'Whirlpool',
            'Waterfall'
        ];
    }

    public static function utf8ify($s) {
        return iconv(mb_detect_encoding($s, mb_detect_order(), true), "UTF-8", $s);
    }

}

if(!function_exists('array_split')) {
    function array_split($array, $pieces = 2) {
        if ($pieces < 2) {
            return [$array];
        }
        $newCount = ceil(count($array) / $pieces);
        $a = array_slice($array, 0, $newCount);
        $b = array_split(array_slice($array, $newCount), $pieces - 1);
        return array_merge([$a], $b);
    }
}