<?php

class Laporan extends DB
{   

    function getLaporan_oneDay_perHour($this_day)
    {
        $next_day = date_create($this_day);
        date_modify($next_day,"+1 day");
        $next_day = date_format($next_day,"Y-m-d");

        $query = "SELECT hour(waktu_entri), round(sum(penggunaan_listrik),2) 
        FROM laporan 
        WHERE waktu_entri >='$this_day 00:00:00' AND waktu_entri <'$next_day 00:00:00'
        GROUP BY hour(waktu_entri)";
        
        return $this->execute($query);
    }
}

?>