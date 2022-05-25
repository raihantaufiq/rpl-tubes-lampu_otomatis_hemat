<?php

class Laporan extends DB
{   
    function getLaporan()
    {
        $query = "SELECT * FROM laporan";
        
        return $this->execute($query);
    }
}

?>