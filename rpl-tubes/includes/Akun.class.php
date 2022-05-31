<?php

class Akun extends DB
{
    function getAkun()
    {
        $query = "SELECT * FROM akun";
        
        return $this->execute($query);
    }
}

?>