<?php

/**
 * Return a human readable diff between two times (e.g. 3 years 4 months 8 days 3 hours)
 * This is locale aware and supports automatic translation
 *
 * @category   View Helpers
 * @author     Drew Phillips <drew [at] drew [.] co.il>
 * @copyright  None
 * @license    BSD License http://opensource.org/licenses/bsd-3-clause
 * @version    1.0
 * @link       http://drew.co.il
 */
class My_View_Helper_TimeDiff extends Zend_View_Helper_Abstract
{
  protected static $_locale       = null;
  protected static $_translations = null;

  /**
   * Return the diff between two times in human readable format
   * @param int    $timestamp    The timestamp of the time to diff
   * @param string $format       The format string used to control which date units are output (TODO: improve by incrementing lower values (i.e. add 12 to months if there is 1 year but years are not displayed))
   * @param int    $now          The timestamp used as the current time, if null, the current time is used
   * @return string              The human readable date diff in the language of the locale
   */
  public function timeDiff($timestamp, $format = null, $now = null)
  {
    if (null === $format) $format = '%y %m %d %h %i';
    if (null === $now)    $now    = time();

    if (!$this->isValidTimestamp($timestamp)) {
      throw new InvalidArgumentException('$timestamp parameter to timeDiff is not a valid timestamp');
    } else if (!$this->isValidTimestamp($now)) {
      throw new InvalidArgumentException('$now parameter to timeDiff is not a valid timestamp');
    } else if ($timestamp > $now) {
      throw new InvalidArgumentException('The value given for $timestamp cannot be greater than $now');
    }

    if (self::$_locale == null) {
      $locale = null;
      $list   = array();

      try {
        $locale = Zend_Registry::get('Zend_Locale');
      } catch (Zend_Exception $ex) {
        $default = Zend_Locale::getDefault(); // en if nothing set

        try {
          $locale = new Zend_Locale();
        } catch (Zend_Locale_Exception $ex) {
          $locale = new Zend_Locale($default);
        }
      }

      self::$_locale = $locale;
      self::$_translations = Zend_Locale::getTranslationList('unit', $locale);
    }

    $table    = self::$_translations;
    $past     = new DateTime(date('Y-m-d H:i:s', $timestamp));
    $current  = new DateTime(date('Y-m-d H:i:s', $now));
    $interval = $current->diff($past);

    $parts = $interval->format('%y %m %d %h %i %s %a');

    $weeks = 0;
    list($years, $months, $days, $hours, $minutes, $seconds, $total_days) = explode(' ', $parts);

    /* uncomment to handle weeks
    if ($days >= 7) {
        $weeks = (int)($days / 7);
        $days  %= 7;
    }
    */

    $diff = array();

    if (strpos($format, '%y') !== false && $years > 0) {
      $diff[] = str_replace('{0}', $years, $table['year'][($years != 1 || !isset($table['year']['one']) ? 'other' : 'one')]);
    }

    if (strpos($format, '%m') !== false && $months > 0) {
      $diff[] = str_replace('{0}', $months, $table['month'][($months != 1 || !isset($table['month']['one']) ? 'other' : 'one')]);
    }

    if (strpos($format, '%d') !== false && $days > 0) {
      $diff[] = str_replace('{0}', $days, $table['day'][($days != 1 || !isset($table['day']['one']) ? 'other' : 'one')]);
    }

    if (strpos($format, '%h') !== false && $hours > 0) {
      $diff[] = str_replace('{0}', $hours, $table['hour'][($hours != 1 || !isset($table['hour']['one']) ? 'other' : 'one')]);
    }

    if (strpos($format, '%i') !== false && $minutes > 0) {
      $diff[] = str_replace('{0}', $minutes, $table['minute'][($minutes != 1 || !isset($table['minute']['one']) ? 'other' : 'one')]);
    }

    return implode(' ', $diff);
  }

  protected function isValidTimestamp($timestamp)
  {
    $ts = (int)$timestamp;
    $d  = date('Y-m-d H:i:s', $ts);

    return strtotime($d) === $ts;
  }
}