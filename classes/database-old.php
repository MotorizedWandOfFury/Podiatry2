<?php

class Database
{

    /**
     *
     * <p>mysql_query();</p>
     * 
     * @param type $query <p>The MySQL query.</p>
     * @return ? 
     */
    public function doQuery($query)
    {
        return @mysql_query($query);
    }

    /**
     *
     * <p>mysql_num_rows(mysql_query());</p>
     * 
     * @param type $query <p>The MySQL query.</p>
     * @return ?
     */
    public function doRowsQuery($query)
    {
        return @mysql_num_rows(mysql_query($query));
    }

    /**
     *
     * <p>mysql_fetch_assoc();</p>
     * 
     * @param type $query <p>The MySQL query.</p>
     * @return ?
     */
    public function doArray($query)
    {
        return @mysql_fetch_assoc($query);
    }

    /**
     *
     * <p>mysql_fetch_assoc(mysql_query());</p>
     * 
     * @param type $query <p>The MySQL query.</p>
     * @return ? 
     */
    public function doQueryArray($query)
    {
        return @mysql_fetch_assoc(mysql_query($query));
    }

    /**
     *
     * <p>mysql_num_rows();</p>
     * 
     * @param type $query <p>The MySQL query.</p>
     * @return ?
     */
    public function doRows($query)
    {
        return @mysql_num_rows($query);
    }

}

?>