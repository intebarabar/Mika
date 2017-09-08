<?php
/**
 * MageWorx
 * MageWorx SeoAll Extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoAll
 * @copyright  Copyright (c) 2016 MageWorx (http://www.mageworx.com/)
 */

class MageWorx_SeoAll_Helper_String extends Mage_Core_Helper_Abstract
{
    /**
     * @param string $string
     * @param array $substringList
     * @return string
     */
    public function cropLastPart($string, array $substringList, $isConsecutive = false)
    {
        $resultString = $string;

        foreach ($substringList as $substring) {
            $pos = $this->mbStrrPosSafety($string, $substring);

            if ($pos !== false && $this->mbStrLenSafety($string) == $pos + $this->mbStrLenSafety($substring)) {
                $resultString = $this->mbSubStrSafety($string, 0, $pos);
                $string = $resultString;

                if (!$isConsecutive) {
                    break;
                }
            }
        }

        return $resultString;
    }

    /**
     * @param string $str
     * @return int
     */
    public function mbStrLenSafety($str)
    {
        if (function_exists('mb_strlen')) {
            return mb_strlen($str);
        }

        return strlen($str);
    }

    /**
     * @param string $str
     * @param int $start
     * @param null|int $length
     * @param null|string $encoding
     * @return string
     */
    public function mbSubStrSafety($str, $start, $length = null)
    {
        if (function_exists('mb_substr')) {
            return mb_substr($str, $start, $length);
        }
        return substr($str, $start, $length);
    }

    /**
     * @param string $haystack
     * @param string $needle
     * @param int $offset
     * @return bool|int
     */
    public function mbStrrPosSafety($haystack, $needle, $offset = 0)
    {
        if (function_exists('mb_strrpos')) {
            return mb_strrpos($haystack, $needle, $offset);
        }
        return strrpos($haystack, $needle, $offset);
    }
}