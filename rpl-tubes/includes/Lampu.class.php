<?php

class Lampu extends DB
{   
    // GET/READ LAMPU
    function getLampu()
    {
        $query = "SELECT * FROM lampu";
        
        return $this->execute($query);
    }


    // GET/READ LAMPU BY ID
    function getLampuUpdate($id_lampu)
    {
        $query = "SELECT * FROM lampu WHERE id_lampu = $id_lampu";
        return $this->execute($query);
    }


    // UPDATE DATA LAMPU
    function update($id_lampu, $data){

        $jenis = $data['tjenis'];
        $daya = $data['tdaya'];
        $masa_pakai = $data['tmasa_pakai'];
        $lumen = $data['tlumen'];
        $volt = $data['tvolt'];
        $warna_cahaya = $data['twarna_cahaya'];

        $query = "UPDATE lampu SET
        jenis = '$jenis',
        daya_lampu = '$daya', 
        masa_pakai = '$masa_pakai',
        lumen = '$lumen',
        volt = '$volt',
        warna_cahaya = '$warna_cahaya'
        WHERE id_lampu = $id_lampu;";

        return $this->executeAffected($query);

    }
}

?>