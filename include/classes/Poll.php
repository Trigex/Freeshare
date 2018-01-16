<?php

class Poll
{
    public static $id;

    public static function display($poll_id)
    {
        $sql = "SELECT * FROM `poll_question` WHERE
               `poll_id`='" . (int) $poll_id . "'";
        $tmp = DB::fetch1($sql);
        $poll_answer = $tmp['poll_answer'];
        $poll_answers = explode('|', $poll_answer);

        for ($i = 0; $i < count($poll_answers); $i ++)
        {
            $sql = "SELECT count(*) AS `total` FROM `poll_results` WHERE
			       `poll_result_vote_id`='" . (int) $poll_id . "' AND
			       `poll_result_answer`='" . DB::quote($poll_answers[$i]) . "'";
            $total_poll_votes[] = DB::getTotal($sql);
        }

        $poll_votes_percentage = self::votes_percentage($total_poll_votes);

        for ($i = 0; $i < count($poll_answers); $i ++)
        {
            $poll_info[$i]['answer'] = $poll_answers[$i];
            $poll_info[$i]['percentage'] = $poll_votes_percentage[$i];
        }

        return $poll_info;
    }

    public static function votes_percentage($total_poll_votes)
    {
        $total = 0;

        for ($i = 0; $i < count($total_poll_votes); $i ++)
        {
            $total = $total + $total_poll_votes[$i];
        }

        for ($i = 0; $i < count($total_poll_votes); $i ++)
        {
            if ($total == 0)
            {
                $poll_votes_percentage[$i] = 0;
            }
            else
            {
                $poll_votes_percentage[$i] = round(($total_poll_votes[$i] * 100) / $total, 2);
            }

        }
        return $poll_votes_percentage;
    }

    public static function delete()
    {
        $sql = "DELETE FROM `poll_question` WHERE
		       `poll_id`='" . (int) self::$id . "'";
        DB::query($sql);
        $sql = "DELETE FROM `poll_results` WHERE
		       `poll_result_vote_id`='" . (int) self::$id . "'";
        DB::query($sql);
    }
}
