<?php

class Lampu extends DB
{
    function getLampu()
    {
        $query = "SELECT * FROM lampu";
        
        return $this->execute($query);
    }
}

?>