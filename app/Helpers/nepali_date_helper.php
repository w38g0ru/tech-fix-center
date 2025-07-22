<?php

use Dipesh\NepaliDate\NepaliDate;
use Dipesh\NepaliDate\lang\Nepali;

if (!function_exists('toNepaliDate')) {
    /**
     * Convert English date to Nepali date
     *
     * @param string $englishDate English date in Y-m-d or Y-m-d H:i:s format
     * @param string $format Output format (default: 'Y-m-d')
     * @return string Nepali date
     */
    function toNepaliDate($englishDate, $format = 'Y-m-d')
    {
        if (empty($englishDate)) {
            return '';
        }

        try {
            // Create NepaliDate instance from English date with Nepali language
            $nepaliDate = NepaliDate::fromADDate($englishDate);

            // Create new instance with Nepali language for Devanagari output
            $nepaliDateWithLang = new NepaliDate($nepaliDate->format('Y-m-d'), new Nepali());

            // Return formatted Nepali date
            return $nepaliDateWithLang->format($format);
        } catch (Exception $e) {
            // Return original date if conversion fails
            return $englishDate;
        }
    }
}

if (!function_exists('toNepaliDateTime')) {
    /**
     * Convert English datetime to Nepali datetime with time
     *
     * @param string $englishDateTime English datetime
     * @param string $format Output format (default: 'Y-m-d H:i:s')
     * @return string Nepali datetime
     */
    function toNepaliDateTime($englishDateTime, $format = 'Y-m-d H:i:s')
    {
        if (empty($englishDateTime)) {
            return '';
        }

        try {
            // Parse the English datetime
            $dateTime = new DateTime($englishDateTime);
            $englishDate = $dateTime->format('Y-m-d');
            $time = $dateTime->format('H:i:s');
            
            // Convert date part to Nepali
            $nepaliDate = NepaliDate::fromADDate($englishDate);
            $nepaliDateWithLang = new NepaliDate($nepaliDate->format('Y-m-d'), new Nepali());

            // Combine Nepali date with time
            if (strpos($format, 'H') !== false || strpos($format, 'i') !== false || strpos($format, 's') !== false) {
                return $nepaliDateWithLang->format('Y-m-d') . ' ' . $time;
            } else {
                return $nepaliDateWithLang->format($format);
            }
        } catch (Exception $e) {
            // Return original datetime if conversion fails
            return $englishDateTime;
        }
    }
}

if (!function_exists('formatNepaliDate')) {
    /**
     * Format Nepali date in a readable format
     *
     * @param string $englishDate English date
     * @param string $style 'short', 'medium', 'long', 'full'
     * @return string Formatted Nepali date
     */
    function formatNepaliDate($englishDate, $style = 'medium')
    {
        if (empty($englishDate)) {
            return '';
        }

        try {
            $nepaliDate = NepaliDate::fromADDate($englishDate);
            $nepaliDateWithLang = new NepaliDate($nepaliDate->format('Y-m-d'), new Nepali());

            switch ($style) {
                case 'short':
                    return $nepaliDateWithLang->format('Y/m/d');
                case 'medium':
                    return $nepaliDateWithLang->format('Y F d g');
                case 'long':
                    return $nepaliDateWithLang->format('Y F d g, l');
                case 'full':
                    return $nepaliDateWithLang->format('l, Y F d g');
                default:
                    return $nepaliDateWithLang->format('Y-m-d');
            }
        } catch (Exception $e) {
            return $englishDate;
        }
    }
}

if (!function_exists('formatNepaliDateTime')) {
    /**
     * Format Nepali datetime in a readable format with time
     *
     * @param string $englishDateTime English datetime
     * @param string $style 'short', 'medium', 'long', 'full'
     * @return string Formatted Nepali datetime
     */
    function formatNepaliDateTime($englishDateTime, $style = 'medium')
    {
        if (empty($englishDateTime)) {
            return '';
        }

        try {
            $dateTime = new DateTime($englishDateTime);
            $englishDate = $dateTime->format('Y-m-d');
            $time = $dateTime->format('g:i A'); // 12-hour format with AM/PM
            
            $nepaliDate = NepaliDate::fromADDate($englishDate);
            $nepaliDateWithLang = new NepaliDate($nepaliDate->format('Y-m-d'), new Nepali());

            switch ($style) {
                case 'short':
                    return $nepaliDateWithLang->format('Y/m/d') . ' ' . $time;
                case 'medium':
                    return $nepaliDateWithLang->format('Y F d g') . ', ' . $time;
                case 'long':
                    return $nepaliDateWithLang->format('Y F d g, l') . ' ' . $time;
                case 'full':
                    return $nepaliDateWithLang->format('l, Y F d g') . ' ' . $time;
                default:
                    return $nepaliDateWithLang->format('Y-m-d') . ' ' . $time;
            }
        } catch (Exception $e) {
            return $englishDateTime;
        }
    }
}

if (!function_exists('nepaliMonthName')) {
    /**
     * Get Nepali month names
     *
     * @param int $month Month number (1-12)
     * @return string Nepali month name
     */
    function nepaliMonthName($month)
    {
        $months = [
            1 => 'बैशाख',
            2 => 'जेठ',
            3 => 'आषाढ',
            4 => 'श्रावण',
            5 => 'भाद्र',
            6 => 'आश्विन',
            7 => 'कार्तिक',
            8 => 'मंसिर',
            9 => 'पौष',
            10 => 'माघ',
            11 => 'फाल्गुन',
            12 => 'चैत्र'
        ];
        
        return $months[$month] ?? '';
    }
}

if (!function_exists('nepaliDayName')) {
    /**
     * Get Nepali day names
     *
     * @param string $englishDay English day name or date
     * @return string Nepali day name
     */
    function nepaliDayName($englishDay)
    {
        $days = [
            'Sunday' => 'आइतबार',
            'Monday' => 'सोमबार',
            'Tuesday' => 'मंगलबार',
            'Wednesday' => 'बुधबार',
            'Thursday' => 'बिहिबार',
            'Friday' => 'शुक्रबार',
            'Saturday' => 'शनिबार'
        ];
        
        // If it's a date, get the day name first
        if (strtotime($englishDay)) {
            $englishDay = date('l', strtotime($englishDay));
        }
        
        return $days[$englishDay] ?? $englishDay;
    }
}
