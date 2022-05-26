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
        //tentukan hari senin di minggu ini
        $monday = date_create($this_day);
        $monday_str = date_format($monday,"Y-m-d");
        while (date('l', strtotime($monday_str)) != "Monday") {
            date_modify($monday,"-1 day");
            $monday_str = date_format($monday,"Y-m-d");
        }
        
        //tentukan hari senin selanjutnya
        $next_monday = date_create($monday_str);
        date_modify($next_monday,"+7 days");

        //ubah ke string
        $monday = date_format($monday,"Y-m-d");
        $next_monday = date_format($next_monday,"Y-m-d");

        //ambil data dari database
        $query = "SELECT dayname(waktu_entri), round(sum(penggunaan_listrik),2) 
        FROM laporan 
        WHERE waktu_entri >='$monday 00:00:00' AND waktu_entri <'$next_monday 00:00:00'
        GROUP BY day(waktu_entri)";
        
        return $this->execute($query);
    }

    function getLaporan_month_perDay($this_day)
    {
        $this_month = date_create($this_day);
        $this_month = date_format($this_month,"Y-m-01");
        $next_month = date_create($this_month);
        date_modify($next_month,"+1 month");
        $next_month = date_format($next_month,"Y-m-d");

        $query = "SELECT day(waktu_entri), round(sum(penggunaan_listrik),2) 
        FROM laporan 
        WHERE waktu_entri >='$this_month 00:00:00' AND waktu_entri <'$next_month 00:00:00'
        GROUP BY day(waktu_entri)";

        return $this->execute($query);

        // SELECT (WEEKOFYEAR(waktu_entri)-WEEKOFYEAR('2022-5-01')) AS week, round(sum(penggunaan_listrik),2) 
        // FROM laporan 
        // WHERE waktu_entri >='2022-5-01 00:00:00' AND waktu_entri <'2022-6-01 00:00:00'
        // GROUP BY WEEKOFYEAR(waktu_entri) ORDER BY WEEKOFYEAR(waktu_entri)
    }

    function getLaporan_year_perMonth($this_day)
    {
        $this_year = date_create($this_day);
        $this_year = date_format($this_year,"Y-01-01");
        $next_year = date_create($this_year);
        date_modify($next_year,"+1 year");
        $next_year = date_format($next_year,"Y-01-01");

        $query = "SELECT month(waktu_entri), round(sum(penggunaan_listrik),2) 
        FROM laporan 
        WHERE waktu_entri >='$this_year 00:00:00' AND waktu_entri <'$next_year 00:00:00'
        GROUP BY month(waktu_entri)";

        return $this->execute($query);
    }
}

?>