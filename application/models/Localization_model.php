<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Localization Model
 *
 * @author		QbD Software
 * @copyright	Copyright (c) 2017, QbD Software N.V.
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.qbdsoftware.eu
 */

/**
 * Class Localization Model
 *
 * This class takes care of database actions performed on patients
 *
 * @package QBD\Models
 */
class Localization_model extends CI_Model
{

    /**
     * @var string the default timezone for new users
     */
    public $default_timezone = 'Europe/Brussels';

    /**
     * @var string date format for humans
     * @access private
     */
    public $_date_format = 'M d, Y';
    /**
     * @var string date format for humans
     * @access private
     */
    public $_time_format = 'H:i:s';

    /**
     * @var string date and time format for humans
     * @access private
     */
    public $_datetime_format = 'M d, Y H:i:s';

    /**
     * @var string date format for external API calls
     * @access private
     */
    public $_date_format_api = 'Y-m-d';

    /**
     * @var string date and time format for external API calls
     * @access private
     */
    public $_datetime_format_api = 'Y-m-d H:i:s';

    /**
     * @var string date and time format for external API calls
     * @access private
     */
    public $_datepicker_format = 'd/m/Y';

    /**
     * @var string date and time picker format for html forms
     * @access private
     */
    public $_datetimepicker_format = 'd/m/Y H:i';

    /**
     * Date to Timestamp
     *
     * Convert timestamp to human-readable date format according to user's timezone.
     *
     * @param string $timestamp
     * @return string
     */
    public function timestamp2date($timestamp, $format=FALSE)
    {
        if (empty($timestamp)) return '';
        
//commented this line as we have employee module now in QMS
//        if (empty($this->users_model->userdata)) return '';

        $timezone = "Asia/Kolkata";
        if (empty($timezone)) $timezone = 'UTC';

        $tz = new DateTimeZone($timezone);

        $dt = new DateTime();
        $dt->setTimestamp($timestamp);
        $dt->setTimezone($tz);

        if ( ! $format)
        {
            $format = $this->_date_format;
            if (defined('ACCESSED_VIA_API') && ACCESSED_VIA_API === TRUE) $format = $this->_date_format_api;
        }

        return $dt->format($format);
    }

    /**
     * Timestamp to Date and Time
     *
     * Convert timestamp to human-readable date and time format according to user's timezone.
     *
     * @param string $timestamp
     * @return string
     */
    public function timestamp2datetime($timestamp, $format=FALSE)
    {
        if (empty($timestamp)) return '';

//commented this line as we have employee module now in QMS
//        if (empty($this->users_model->userdata)) return '';

        $timezone = $this->users_model->userdata['timezone'];
        if (empty($timezone)) $timezone = 'UTC';

        $tz = new DateTimeZone($timezone);

        $dt = new DateTime();
        $dt->setTimestamp($timestamp);
        $dt->setTimezone($tz);

        if ( ! $format)
        {
            $format = $this->_datetime_format;
            if (defined('ACCESSED_VIA_API') && ACCESSED_VIA_API === TRUE) $format = $this->_datetime_format_api;
        }

        return $dt->format($format);
    }

    /**
     * Date to Timestamp
     *
     * Convert a given date string with the given format to a timestamp (using UTC timezone).
     *
     * @param $date
     * @param $format
     * @return string
     */
    public function date2timestamp($date, $format, $timezone='UTC')
    {
        if (empty($date)) return '';

        $tz = new DateTimeZone($timezone);

        $dt = DateTime::createFromFormat($format, $date, $tz);

        if ($dt) return $dt->getTimestamp();

        return '';
    }

    /**
     * Get a person's age from a birthday date in MySQL DATE format
     *
     * @param $dob date of birth
     * @return int|bool
     */
    public function get_age_from_mysqldate($dob)
    {
        if (empty($dob)) return FALSE;
        if (empty($this->users_model->userdata)) return '';

        $tz  = new DateTimeZone($this->users_model->userdata['timezone']);
        $age = DateTime::createFromFormat('Y-m-d', $dob, $tz)
            ->diff(new DateTime('now', $tz))
            ->y;

        return $age;
    }
    
    /**
     * Return formatted date time
     *
     * Convert timestamp to human-readable date format according to user's timezone.
     *
     * @param string $timestamp
     * @param string $return_type
     * @return string
     */
    public function return_formatted_date_time($timestamp, $return_type='date', $format=FALSE)
    {
        if (empty($timestamp)) return '';

        $timezone = $this->users_model->userdata['timezone'];
        if (empty($timezone)) $timezone = 'UTC';

        $tz = new DateTimeZone($timezone);

        $dt = new DateTime();
        $dt->setTimestamp($timestamp);
        $dt->setTimezone($tz);

        if (!$format)
        {
            $date_format = $this->saas_model->get_customer_setting_by_field_name('date_format');
            $time_format = $this->saas_model->get_customer_setting_by_field_name('time_format');
            if(!empty($date_format) && !empty($time_format))
            {
                switch ($return_type)
                {
                    case 'date':
                        $format = $date_format['field_value'];
                    break;
                    case 'time':
                        $format = $time_format['field_value'];
                    break;
                    case 'datetime':
                        $format = $date_format['field_value'].' '.$time_format['field_value'];
                    break;
                    default :
                       $format = $this->_date_format;
                }
//                if(!$format)
//                {
//                    $format = $this->_date_format;
//                    if (defined('ACCESSED_VIA_API') && ACCESSED_VIA_API === TRUE) $format = $this->_date_format;
//                }
            }
            else
            {
                
                switch ($return_type)
                {
                    case 'date':
                        $format = $this->_date_format;
                    break;
                    case 'time':
                        $format = $this->_time_format;
                    break;
                    case 'datetime':
                        $format = $this->_datetime_format;
                    break;
                    default :
                       $format = $this->_date_format;
                }
                
//                if (defined('ACCESSED_VIA_API') && ACCESSED_VIA_API === TRUE) $format = $this->_date_format;
            }
        }
        return $dt->format($format);
    }
    
    /**
     * Return date time format
     *
     * Convert timestamp to human-readable date format according to user's timezone.
     *
     * @param string $return_format
     * @param string $return_type
     * @return string
     */
    public function return_date_time_format($return_format, $return_type = 'date') 
    {
        if(empty($return_format))
        {
            return FALSE;
        }
        
        $this->load->config('admin');
        // get date format
        $possible_date_format = $this->config->item('possible_date_format');
        $possible_time_format = $this->config->item('possible_time_format');
        
        $return_date_format = $this->saas_model->get_customer_setting_by_field_name('date_format');
                    
        $date_format = $this->_date_format;
        if(!empty($return_date_format))
        {
           $date_format = $return_date_format['field_value']; 
        }
        
        $return_time_format = $this->saas_model->get_customer_setting_by_field_name('time_format');
                    
        $time_format = $this->_time_format;
        if(!empty($return_time_format))
        {
           $time_format = $return_time_format['field_value']; 
        }
        $return = '';
        switch ($return_type)
        {
            case 'date':
                if(isset($possible_date_format[$date_format][$return_format]) && !empty($possible_date_format[$date_format][$return_format]))
                {
                    $return = $possible_date_format[$date_format][$return_format];
                }
                break;
                
            case 'time':
                if(isset($possible_time_format[$time_format][$return_format]) && !empty($possible_time_format[$time_format][$return_format]))
                {
                    $return = $possible_time_format[$time_format][$return_format];
                }
                break;
                
            case 'datetime':
                if(isset($possible_date_format[$date_format][$return_format]) && !empty($possible_date_format[$date_format][$return_format]) && isset($possible_time_format[$time_format][$return_format]) && !empty($possible_time_format[$time_format][$return_format]))
                {
                    $return = $possible_date_format[$date_format][$return_format].' '.$possible_time_format[$time_format][$return_format];
                }
                break;  
        }
        
        return $return;
    }
    
    /**
     * Get time since eg 12 minut ego
     * 
     * @param string in second
     * 
     * return time since 
     *       
     */
    public function time_since($since) 
    {
        $chunks = array(
            array(60 * 60 * 24 * 365, lang('since_year')),
            array(60 * 60 * 24 * 30, lang('since_month')),
            array(60 * 60 * 24 * 7, lang('since_week')),
            array(60 * 60 * 24, lang('since_day')),
            array(60 * 60, lang('since_hour')),
            array(60, lang('since_minute')),
            array(1, lang('since_second'))
        );

        for ($i = 0, $j = count($chunks); $i < $j; $i++)
        {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($since / $seconds)) != 0)
            {
                break;
            }
        }

        $print = ($count == 1) ? '1 ' . $name : "$count {$name}s";
        return $print;
    }

}
