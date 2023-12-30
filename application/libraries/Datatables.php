<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Datatables
{

    /**
     * @var SQL string with the desired SELECT statement without filtering, ordering or limit
     */
    public $sql;

    /**
     * @var array of columns that need to be displayed (required for ordering)
     */
    public $columns;

    /**
     * @var set where to get the client-side datatables parameters from ($_GET, $_POST, $_REQUEST or other)
     */
    public $input;

    /**
     * @var the Code Igniter instance
     */
    protected $CI;

    /**
     * @var will contain the total of records without filtering
     */
    protected $total;

    /**
     * @var will contain the total records after filtering
     */
    protected $filtered_total;

    /**
     *
     * Constructor
     *
     * Load required resources
     */
    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * Create SQL
     *
     * Creates the finished SQL statement including filtering, ordering and paging
     * and saves some required values (total records, etc.) along the way.
     *
     * @param $sql
     * @param $columns
     * @param $input
     */
    public function create_sql()
    {
        // set total without filtering
        $query = $this->CI->db->query($this->sql);
        $this->total = $query->num_rows();

        // set total with filtering
        $this->sql .= $this->filter();
        $query = $this->CI->db->query($this->sql);
        $this->filtered_total = $query->num_rows();

        $this->sql .= $this->order();
        $this->sql .= $this->paging();
       
        return $this->sql;
    }

    /**
     * Order
     * 
     * Returns the SQL part that takes care of ordering.
     * 
     * @return string
     */
    private function order()
    {
        $aOrderingRules = array();
        
        if (isset($this->input['order']))
        {
            foreach ($this->input['order'] as $order)
            {
                $aOrderingRules[] =
                    "`".$this->columns[$order['column']]."` "
                    .($order['dir'] == 'asc' ? 'asc' : 'desc');
            }
        }

        if ( ! empty($aOrderingRules))
        {
            $sOrder = " ORDER BY ".implode(", ", $aOrderingRules);
        }
        else
        {
            $sOrder = "";
        }

        return $sOrder;
    }

    private function paging()
    {
        $sLimit = '';
        if (isset($this->input['start']) && $this->input['length'] != '-1')
        {
            $sLimit = " LIMIT ".intval($this->input['start']).", ".intval($this->input['length']);
        }
        else
        {
            $sLimit = " LIMIT 0, 10";
        }

        return $sLimit;
    }

    private function filter()
    {
        $iColumnCount = count($this->columns);
        $aFilteringRules = array();

        if (isset($this->input['search']['value']) && $this->input['search']['value'] != "")
        {
            for ($i=0 ; $i<$iColumnCount ; $i++)
            {
                if (isset($this->input['columns'][$i]['searchable']) && $this->input['columns'][$i]['searchable'] == 'true')
                {
                    $aFilteringRules[] = "`".$this->columns[$i]."` LIKE '%". $this->input['search']['value'] . "%'";
                }
            }
            if (!empty($aFilteringRules))
            {
                $aFilteringRules = array('('.implode(" OR ", $aFilteringRules).')');
            }
        }

        // Individual column filtering
        for ($i=0 ; $i<$iColumnCount ; $i++)
        {
            if (isset($this->input['columns'][$i]['searchable']) && $this->input['columns'][$i]['searchable'] == 'true' && $this->input['columns'][$i]['search']['value'] != '')
            {
                $aFilteringRules[] = "`".$this->columns[$i]."` LIKE '%" . $this->input['columns'][$i]['search']['value'] . "%'";
            }
        }

        if ( ! empty($aFilteringRules))
        {
            if (strstr(strtoupper($this->sql), ' HAVING ')) $sWhere = " AND ";
            else $sWhere = ' HAVING ';
            $sWhere .= implode(" AND ", $aFilteringRules);
        }
        else
        {
            $sWhere = "";
        }

        return $sWhere;
    }

    public function create_output($data)
    {
        $output = array(
            "recordsTotal" => $this->total,
            "recordsFiltered" => $this->filtered_total,
            "aaData" => $data
       );

        return $output;
    }
    
    /**
     * Create SQL
     *
     * Creates the finished SQL statement including filtering, ordering and paging
     * and saves some required values (total records, etc.) along the way.
     * @param $total total number of record
     * @param $sql
     * @param $columns
     * @param $input
     */
    public function create_filtering_sql($total)
    {
        // set total without filtering
        $this->total = $total;

        // set total with filtering
        if (!empty($this->filter()))
        {
            $this->sql .= $this->filter();
            $query = $this->CI->db->query($this->sql);

            $this->filtered_total = $query->num_rows();
        }
        else
        {
            $this->filtered_total = $this->total;
        }


        $this->sql .= $this->order();
        $this->sql .= $this->paging();

        return $this->sql;
    }

}

