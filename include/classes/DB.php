<?php

class DB
{
    public static $link;
    public static $result;

    public static function connect($db_host, $db_user, $db_pass, $db_name)
    {
        self::$link = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if (self::$link->connect_errno) {
            die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        }
    }

    public static function query($sql)
    {
        self::$result = self::$link->query($sql) or self::sqlDie($sql);
        return self::$result;
    }

    public static function fetch($sql)
    {
        $result = self::query($sql);

        $return_array = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $return_array[] = $row;
        }

        return $return_array;
    }

    public static function fetch1($sql)
    {
        $result = self::query($sql);

        if ($result) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }

    }

    public static function getTotal($sql)
    {
        $result = self::query($sql);
        $temp = mysqli_fetch_assoc($result);
        return $temp['total'];
    }

    public static function close()
    {
        mysqli_close(self::$link);
    }

    public static function quote($value)
    {
        if (get_magic_quotes_gpc()) {
            $value = stripslashes($value);
        }

        if (! is_numeric($value)) {
            $value = mysqli_real_escape_string(self::$link, $value);
        }

        return $value;
    }

    public static function insertGetId($sql)
    {
        $result = self::query($sql);
        return mysqli_insert_id(self::$link);
    }

    public static function sqlDie($msg)
    {
        echo "<p class=text-danger><b>ERROR: Unable to execute query</b></p>";
        echo "<pre>$msg</pre>";
        echo "<p class=text-warning><b>";
        echo mysqli_error(self::$link);
        echo "</p>";
        exit(0);
    }

    public static function freeResult()
    {
        mysqli_free_result(self::$result);
    }

    public static function affectedRows()
    {
        return mysqli_affected_rows(self::$link);
    }
}
