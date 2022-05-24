<?php

class Akun extends DB
{
    function getAkun()
    {
        $query = "SELECT * FROM admin";
        
        return $this->execute($query);
    }
}

?>