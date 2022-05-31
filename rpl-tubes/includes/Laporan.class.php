<?php

include_once("config.php");
include_once("includes/DB.class.php");
include_once("Lampu.class.php");

class Laporan extends DB
{   

    function getLaporan_day_perHour($this_day)
    {
        $lampu = new Lampu($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        $lampu->open();
        $lampu->getLampu();
        $row = $lampu->getResult();
        $daya_lampu = $row['daya_lampu'];

        $next_day = date_create($this_day);
        date_modify($next_day,"+1 day");
        $next_day = date_format($next_day,"Y-m-d");

        $query = "SELECT hour(waktu_nyala), sum(((SECOND(TIMEDIFF(waktu_mati,waktu_nyala)) + (MINUTE(TIMEDIFF(waktu_mati,waktu_nyala)) * 60) + (HOUR(TIMEDIFF(waktu_mati,waktu_nyala)) * 3600))/3600) * $daya_lampu)
        FROM penggunaan_listrik 
        WHERE waktu_nyala >='$this_day 00:00:00' AND waktu_nyala <'$next_day 00:00:00'
        GROUP BY hour(waktu_nyala)";
        
        return $this->execute($query);
    }

    function getLaporan_week_perDay($this_day)
    {
        $lampu = new Lampu($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        $lampu->open();
        $lampu->getLampu();
        $row = $lampu->getResult();
        $daya_lampu = $row['daya_lampu'];

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
        $query = "SELECT dayname(waktu_nyala), sum(((SECOND(TIMEDIFF(waktu_mati,waktu_nyala)) + (MINUTE(TIMEDIFF(waktu_mati,waktu_nyala)) * 60) + (HOUR(TIMEDIFF(waktu_mati,waktu_nyala)) * 3600))/3600) * $daya_lampu)
        FROM penggunaan_listrik 
        WHERE waktu_nyala >='$monday 00:00:00' AND waktu_nyala <'$next_monday 00:00:00'
        GROUP BY day(waktu_nyala)";
        
        return $this->execute($query);
    }

    function getLaporan_month_perDay($this_day)
    {
        $lampu = new Lampu($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        $lampu->open();
        $lampu->getLampu();
        $row = $lampu->getResult();
        $daya_lampu = $row['daya_lampu'];

        $this_month = date_create($this_day);
        $this_month = date_format($this_month,"Y-m-01");
        $next_month = date_create($this_month);
        date_modify($next_month,"+1 month");
        $next_month = date_format($next_month,"Y-m-d");

        $query = "SELECT day(waktu_nyala), sum(((SECOND(TIMEDIFF(waktu_mati,waktu_nyala)) + (MINUTE(TIMEDIFF(waktu_mati,waktu_nyala)) * 60) + (HOUR(TIMEDIFF(waktu_mati,waktu_nyala)) * 3600))/3600) * $daya_lampu)
        FROM penggunaan_listrik 
        WHERE waktu_nyala >='$this_month 00:00:00' AND waktu_nyala <'$next_month 00:00:00'
        GROUP BY day(waktu_nyala)";

        return $this->execute($query);

        // SELECT (WEEKOFYEAR(waktu_nyala)-WEEKOFYEAR('2022-5-01')) AS week, round(sum(penggunaan_listrik),2) 
        // FROM penggunaan_listrik 
        // WHERE waktu_nyala >='2022-5-01 00:00:00' AND waktu_nyala <'2022-6-01 00:00:00'
        // GROUP BY WEEKOFYEAR(waktu_nyala) ORDER BY WEEKOFYEAR(waktu_nyala)
    }

    function getLaporan_year_perMonth($this_day)
    {
        $lampu = new Lampu($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        $lampu->open();
        $lampu->getLampu();
        $row = $lampu->getResult();
        $daya_lampu = $row['daya_lampu'];

        $this_year = date_create($this_day);
        $this_year = date_format($this_year,"Y-01-01");
        $next_year = date_create($this_year);
        date_modify($next_year,"+1 year");
        $next_year = date_format($next_year,"Y-01-01");

        $query = "SELECT month(waktu_nyala), sum(((SECOND(TIMEDIFF(waktu_mati,waktu_nyala)) + (MINUTE(TIMEDIFF(waktu_mati,waktu_nyala)) * 60) + (HOUR(TIMEDIFF(waktu_mati,waktu_nyala)) * 3600))/3600) * $daya_lampu)
        FROM penggunaan_listrik 
        WHERE waktu_nyala >='$this_year 00:00:00' AND waktu_nyala <'$next_year 00:00:00'
        GROUP BY month(waktu_nyala)";

        return $this->execute($query);
    }
}

?>