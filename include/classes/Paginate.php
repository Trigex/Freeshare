<?php

class Paginate
{
    public static function getLinks($total, $result_per_page, $page_url, $page_id, $current_page)
    {
        $pagination_output = '';
        $numPages = ceil($total / $result_per_page);

        $offset = 4;
        $span = ($offset * 2) + 1;

        if ($numPages > 1) {
            if ($current_page > 1) {
                $prevPage = $current_page - 1;
                $pagination_output .= "<a class='pagination_prev' href='$page_url/$prevPage'>&lt;</a> &nbsp; ";
            }

            if ($current_page > $offset) {
                $pagination_output .= "<a class='pagination' href='$page_url/1'>1</A> ... ";
            }

            if ($numPages > $span) {
                if ($current_page <= $offset) {
                    $start = 1;
                } else if ($current_page >= ($numPages - $offset)) {
                    $start = $numPages - $span;
                } else {
                    $start = $current_page - $offset;
                }
            } else {
                $start = 1;
                $span = $numPages;
            }

            $limit = $span + (($start != 1) ? $start : 0);

            for ($i = $start; $i <= $limit; $i ++) {
                if ($i != $current_page) {
                    $pagination_output .= "<a class='pagination' href='$page_url/$i'>";
                } else {
                    $pagination_output .= "<span class='pagination_active'>";
                }

                $pagination_output .= $i;

                if ($i != $current_page) {
                    $pagination_output .= "</a>";
                } else {
                    $pagination_output .= "</span>";
                }
            }

            if ($current_page < ($numPages - $offset)) {
                $pagination_output .= " ... <a class='pagination' href='$page_url/$numPages'>$numPages</a>";
            }

            if ($current_page != $numPages) {
                $nextPage = $current_page + 1;
                $pagination_output .= " &nbsp; <a class='pagination_next' href='$page_url/$nextPage'>&gt;</a>";
            }
        }
        return $pagination_output;
    }

    public static function getLinks2($total, $result_per_page, $page_url, $current_page)
    {
        $total_pages = ceil($total / $result_per_page);

        if ($total_pages < 2) {
            return '';
        }

        if ($page_url == '') {
            $page_url = self::getParams();
        }

        $offset = 3;
        $total_pages_show = ($total_pages > 7) ? 7 : $total_pages;

        $pagination_output = '';
        $pagination_output .= '<ul class="pagination pagination-lg">';

        $previous_page = ($current_page > 1) ? $current_page - 1 : 1;
        $li_class = ($current_page == 1) ? ' class="disabled"' : '';
        $pagination_output .= '<li' . $li_class . '><a href="' . $page_url . $previous_page . '">&laquo;</a></li>';

        $k = 1;

        if ($total_pages > 7) {
            if ($current_page > 4) {
                if ($current_page > ($total_pages - $offset)) {
                    $k = $total_pages - 6;
                } else {
                    $k = $current_page - $offset;
                }
            }
        }

        for ($i = 1;$i <= $total_pages_show;$i++) {
            $li_class = ($k == $current_page) ? ' class="active"' : '';
            $pagination_output .= '<li' . $li_class . '><a href="' . $page_url . $k . '">' . $k . '</a></li>';
            $k++;
            if ($k > $total_pages) {
                break;
            }
        }

        $next_page = ($current_page >= $total_pages) ? $current_page : $current_page + 1;
        $li_class = ($current_page >= $total_pages) ? ' class="disabled"' : '';
        $pagination_output .= '<li' . $li_class . '><a href="' . $page_url . $next_page . '">&raquo;</a></li>';
        $pagination_output .= '</ul>';

        return $pagination_output;
    }

    public static function getParams()
    {
        $all_get_params = '';

        foreach ($_GET as $item => $value) {
            if ($item == 'page' || $item == 'action' || empty($value)) continue;
            if (empty($all_get_params)) {
                $all_get_params .= '?' . $item . '=' . urlencode($value);
            } else {
                $all_get_params .= '&' . $item . '=' . urlencode($value);
            }
        }

        if (empty($all_get_params)) {
            $all_get_params = $_SERVER['PHP_SELF'] . '?page=';
        } else {
            $all_get_params = $_SERVER['PHP_SELF'] . $all_get_params . '&page=';
        }

        return $all_get_params;
    }

}