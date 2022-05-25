<?php

class Laporan extends DB
{   

    function getLaporan_day_perHour($this_day)
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

    function getLaporan_week_perDay($this_day)
    {
        // $monday = date_create($this_day);
        // $monday_str = date_format($monday,"Y-m-d");
        // //jika bukan hari senin, mundurkan hari sampai hari senin
        // while (date('l', strtotime($monday_str)) != "Monday") {
        //     date_modify($monday,"-1 day");
        //     $monday_str = date_format($monday,"Y-m-d");
        // }
        // //tentukan hari minggu
        // $next_monday = $monday;
        // date_modify($next_monday,"+7 days");
        // //ubah ke string
        // $monday = date_format($monday,"Y-m-d");
        // $next_monday = date_format($next_monday,"Y-m-d");

        $query = "SELECT dayname(waktu_entri), round(sum(penggunaan_listrik),2) 
        FROM laporan 
        WHERE waktu_entri >='2022-5-9 00:00:00' AND waktu_entri <'2022-5-16 00:00:00'
        GROUP BY day(waktu_entri)";
        
        return $this->execute($query);
    }
}

?>