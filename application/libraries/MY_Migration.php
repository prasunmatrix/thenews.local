<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Extends the CodeIgniter Migration library
 *
 * @version		Git: $Id$
 * @since		v1.0
 * @link		http://www.qbdsoftware.eu
 */

/**
 * MY_Migration Class
 *
 * Extends the standard CodeIgniter class.
 *
 * @package	QMS\Libraries
 */
class MY_Migration extends CI_Migration
{

    protected $_result_lines = array();

    /**
     * Returns migration data in a more usable associative array.
     *
     * @param string $migration the full path and filename of a migration
     * @return array|false
     */
    public function get_migration_data($migration)
    {
        if (empty($migration)) return FALSE;

        $data = array();
        $data['fullpathfile'] = $migration;
        $data['pathfile'] = str_replace(APPPATH, '', $migration);

        $pieces = explode(DIRECTORY_SEPARATOR, $migration);

        $filename = array_pop($pieces);
        $data['filename'] = $filename;
        $data['fullpath'] = implode(DIRECTORY_SEPARATOR, $pieces);

        // get rid of file extension
        $filename = str_replace('.php', '', $filename);

        $pieces = explode('_', $filename);
        $data['version'] = array_shift($pieces);
        $data['migration_name'] = ucfirst(implode(' ', $pieces));

        return $data;
    }

    public function get_result()
    {
        if (empty($this->_result_lines)) return FALSE;

        $result = array();
        $count = 0;
        foreach ($this->_result_lines as $line)
        {
            $count++;
            $result[] = "$count. $line";
        }
        return implode("<br />\n", $result);
    }

    public function add_result_line($line)
    {
        $this->_result_lines[] = $line;
    }
    
     public function get_current_version()
    {
        $query = $this->db->get('migrations');
        if ($query->num_rows() > 0)
        {
            $data = $query->row_array();
            return $data['version'];
        }

        return FALSE;
    }
}
