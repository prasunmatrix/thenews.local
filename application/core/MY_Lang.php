<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// CodeIgniter i18n library by Jérôme Jaglale
// http://maestric.com/en/doc/php/codeigniter_i18n
// version 10 - May 10, 2012

class MY_Lang extends CI_Lang {
    /*     * ************************************************
      configuration
     * ************************************************* */

    // languages
    var $languages = array(                
        'bn' => 'bengali',
        'en' => 'english',
        
    );
    // special URIs (not localized)
    var $special = array(
        'src-docs', 'api-docs'
    );
    // where to redirect if no language in URI
    var $default_uri = 'home';

    /*     * *********************************************** */

    /**
     * Refactor: base language provided inside system/language
     *
     * @var string
     */
    public $base_language = 'hindi';

    function __construct() {
        parent::__construct();

        global $CFG;
        global $URI;
        global $RTR;
        $segment = $URI->segment(1);
        
        if (isset($this->languages[$segment])) { // URI with language -> ok
            $language = $this->languages[$segment];
            $CFG->set_item('language', $language);
        } else if ($this->is_special($segment)) { // special URI -> no redirect
            return;
        } else { // URI without language -> redirect to default_uri
            if (php_sapi_name() !== 'cli') {
                // set default language
                $CFG->set_item('language', $this->languages[$this->default_lang()]);

                // redirect
                header("Location: " . $CFG->site_url($this->localized($this->default_uri)), TRUE, 302);
                exit;
            }
        }
    }

    // get current language
    // ex: return 'en' if language in CI config is 'english'
    function lang() {
        global $CFG;
        $language = $CFG->item('language');

        $lang = array_search($language, $this->languages);
        if ($lang) {
            return $lang;
        }

        return NULL; // this should not happen
    }

    function is_special($uri) {
        $exploded = explode('/', $uri);
        if (in_array($exploded[0], $this->special)) {
            return TRUE;
        }
        if (isset($this->languages[$uri])) {
            return TRUE;
        }
        return FALSE;
    }

    function switch_uri($lang) {
        $CI = & get_instance();

        $uri = $CI->uri->uri_string();
        if ($uri != "") {
            $exploded = explode('/', $uri);
            if ($exploded[0] == $this->lang()) {
                $exploded[0] = $lang;
            }
            $uri = implode('/', $exploded);
        }
        return $uri;
    }

    // is there a language segment in this $uri?
    function has_language($uri) {
        $first_segment = NULL;

        $exploded = explode('/', $uri);
        if (isset($exploded[0])) {
            if ($exploded[0] != '') {
                $first_segment = $exploded[0];
            } else if (isset($exploded[1]) && $exploded[1] != '') {
                $first_segment = $exploded[1];
            }
        }

        if ($first_segment != NULL) {
            return isset($this->languages[$first_segment]);
        }

        return FALSE;
    }

    // default language: first element of $this->languages
    function default_lang() {
        foreach ($this->languages as $lang => $language) {
            return $lang;
        }
    }

    // add language segment to $uri (if appropriate)
    function localized($uri) {
        if ($this->has_language($uri) || $this->is_special($uri)) {
        // filip: disabled checking for file to enable file downloads (htaccess already checks for literal files)
        //|| preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri))
            // we don't need a language segment because:
            // - there's already one or
            // - it's a special uri (set in $special) or
            // - that's a link to a file
        } else {
            $uri = $this->lang() . '/' . $uri;
        }

        return $uri;
    }

    /**
     * Fetch a single line of text from the language array, return the key if not present
     *
     * @param	string	$line	the language line
     * @return	string
     */
    public function line($line = '', $return_key = TRUE) {
        $key = $line;
        $line = ($line == '' OR ! isset($this->language[$line])) ? FALSE : $this->language[$line];

        // Handle 'form_validation_' prefix.
        // Last version of CI form_validation library requires to always prefix form validation fields with 'form_validation_';
        if ($line === FALSE && preg_match('/^form_validation_/', $key)) {
            // see if we can find the translation of the key without the 'form_validation_' prefix
            $key = preg_replace('/^form_validation_/', '', $key);
            $line = ($key == '' OR ! isset($this->language[$key])) ? FALSE : $this->language[$key];
        }

        if ($line === FALSE && $return_key === TRUE) {
            return $key;
        }

        return $line;
    }

    /*     * ************************************************************************************ */

    /**
     * Load a language file, with fallback to english.
     *
     * @param	mixed	$langfile	Language file name
     * @param	string	$idiom		Language name (english, etc.)
     * @param	bool	$return		Whether to return the loaded array of translations
     * @param 	bool	$add_suffix	Whether to add suffix to $langfile
     * @param 	string	$alt_path	Alternative path to look for the language file
     *
     * @return	void|string[]	Array containing translations, if $return is set to TRUE
     */
    public function load($langfile, $idiom = '', $return = FALSE, $add_suffix = TRUE, $alt_path = '') {
        if (is_array($langfile)) {
            foreach ($langfile as $value) {
                $this->load($value, $idiom, $return, $add_suffix, $alt_path);
            }
            return;
        }
        $langfile = str_replace('.php', '', $langfile);
        if ($add_suffix === TRUE) {
            $langfile = preg_replace('/_lang$/', '', $langfile) . '_lang';
        }
        $langfile .= '.php';

        // filip: set $idiom depending on uri
        /*
          if (empty($idiom) OR ! preg_match('/^[a-z_-]+$/i', $idiom))
          {
          $config = & get_config();
          $idiom = empty($config['language']) ? $this->base_language : $config['language'];
          }
         */
        if (empty($idiom)) {
            global $CFG;
            $idiom = $CFG->item('language');
        }

        $idiom = empty($idiom) ? $this->base_language : $idiom;


        if ($return === FALSE && isset($this->is_loaded[$langfile]) && $this->is_loaded[$langfile] === $idiom) {
            return;
        }
        // load the default language first, if necessary
        // only do this for the language files under system/
        $basepath = SYSDIR . 'language/' . $this->base_language . '/' . $langfile;
        if (($found = file_exists($basepath)) === TRUE) {
            include($basepath);
        }
        // Load the base file, so any others found can override it
        $basepath = BASEPATH . 'language/' . $idiom . '/' . $langfile;
        if (($found = file_exists($basepath)) === TRUE) {
            include($basepath);
        }
        // Do we have an alternative path to look in?
        if ($alt_path !== '') {
            $alt_path .= 'language/' . $idiom . '/' . $langfile;
            if (file_exists($alt_path)) {
                include($alt_path);
                $found = TRUE;
            }
        } else {
            foreach (get_instance()->load->get_package_paths(TRUE) as $package_path) {
                $package_path .= 'language/' . $idiom . '/' . $langfile;
                if ($basepath !== $package_path && file_exists($package_path)) {
                    include($package_path);
                    $found = TRUE;
                    break;
                }
            }
        }
        if ($found !== TRUE) {
            show_error('Unable to load the requested language file: language/' . $idiom . '/' . $langfile);
        }
        if (!isset($lang) OR ! is_array($lang)) {
            log_message('error', 'Language file contains no data: language/' . $idiom . '/' . $langfile);
            if ($return === TRUE) {
                return array();
            }
            return;
        }
        if ($return === TRUE) {
            return $lang;
        }
        $this->is_loaded[$langfile] = $idiom;
        $this->language = array_merge($this->language, $lang);
        log_message('info', 'Language file loaded: language/' . $idiom . '/' . $langfile);
        return TRUE;
    }

}

// --------------------------------------------------------------------
// The method below was used with phpunit to ensure correctness of the load() function above.
//	public function test_fallback()
//	{
//		// system target language file
//		$this->ci_vfs_create('system/language/martian/number_lang.php', "<?php \$lang['fruit'] = 'Apfel';");
//		$this->assertTrue($this->lang->load('number', 'martian'));
//		$this->assertEquals('Apfel', $this->lang->language['fruit']);
//		$this->assertEquals('Bytes', $this->lang->language['bytes']);
//
//		// application target language file
//		$this->ci_vfs_create('application/language/klingon/number_lang.php', "<?php \$lang['fruit'] = 'Apfel';");
//		$this->assertTrue($this->lang->load('number', 'klingon'));
//		$this->assertEquals('Apfel', $this->lang->language['fruit']);
//		$this->assertEquals('Bytes', $this->lang->language['bytes']);
//
//		// both system & application language files
//		$this->ci_vfs_create('system/language/romulan/number_lang.php', "<?php \$lang['apple'] = 'Core';");
//		$this->ci_vfs_create('application/language/romulan/number_lang.php', "<?php \$lang['fruit'] = 'Cherry';");
//		$this->assertTrue($this->lang->load('number', 'romulan'));
//		$this->assertEquals('Cherry', $this->lang->language['fruit']);
//		$this->assertEquals('Bytes', $this->lang->language['bytes']);
//		$this->assertEquals('Core', $this->lang->language['apple']);
//	}
