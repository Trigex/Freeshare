<?php

class Sql2Db
{
    private $sql_file_name = '';
    private $debug = '';
    public $debug_filename = 'vshare_upgrade';

    function Sql2Db($sql_file_name, $debug = 0)
    {
        $this->sql_file_name = $sql_file_name;
        $this->debug = $debug;
    }

    function import()
    {

        $comment = array();
        $comment[] = '#';
        $comment[] = '-- ';

        $query = '';
        $queries = 0;
        $querylines = 0;
        $inparents = false;
        $linenumber = 1;
        $totalqueries = 0;

        if (! $file = @fopen($this->sql_file_name, 'rt')) {
            echo ("<p>Can't open file " . $this->sql_file_name . "</p>");
            exit();
        }

        $end_of_file = 1;

        while ($end_of_file) {

            $dumpline = '';

            while (! feof($file) && substr($dumpline, - 1) != "\n") {
                $dumpline .= fgets($file, 16384);
            }

            if ($dumpline === '') {
                break;
            }

            $dumpline = str_replace("\r\n", "\n", $dumpline);
            $dumpline = str_replace("\r", "\n", $dumpline);

            if ($this->debug) {
                echo ("<p>Line $linenumber: $dumpline</p>");
            }

            if (! $inparents) {

                $skipline = false;

                foreach ($comment as $comment_value) {
                    if (! $inparents && (trim($dumpline) == '' || strpos($dumpline, $comment_value) === 0)) {
                        $skipline = true;
                        break;
                    }
                }

                if ($skipline) {
                    $linenumber ++;
                    continue;
                }
            }

            $dumpline_deslashed = str_replace("\\\\", "", $dumpline);

            $parents = substr_count($dumpline_deslashed, "'") - substr_count($dumpline_deslashed, "\\'");

            if ($parents % 2 != 0) {
                $inparents = ! $inparents;
            }

            $query .= $dumpline;

            if (! $inparents) {
                $querylines ++;
            }

            if (preg_match("/;$/", trim($dumpline)) && ! $inparents) {
                $query = trim($query);

                if ($this->debug) {
                    echo '<textarea cols="100">' . $query . '</textarea><br />';
                }
                write_log($query, $this->debug_filename, 0, 'txt');
                DB::query($query);
                $totalqueries ++;
                $queries ++;
                $query = '';
                $querylines = 0;
            }
            $linenumber ++;
        }
    }
}
