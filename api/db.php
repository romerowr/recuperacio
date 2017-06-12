<?php


    function getDB($dsn,$usr,$pwd)
    {
        try
        {
            $dbh=new PDO($dsn,$usr,$pwd);
        } catch (PDOException $ex) {
            return null;
        }
        return $dbh;
    }

