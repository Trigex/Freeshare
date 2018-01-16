<?php

class Sitemap
{
    public $sitemap_info = array();
    public $sitemap_xml_header = '<?xml version="1.0" encoding="UTF-8"?>';
    public $sitemap_urlset_open = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
        xmlns:video="http://www.google.com/schemas/sitemap-video/1.1">';
    public $sitemap_urlset_close = '</urlset>';
    public $sitemap_index_header = '<?xml version="1.0" encoding="UTF-8"?>
   		<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    public $sitemap_index_close = '</sitemapindex>';
    public $where = '';
    public $sitemap_name = '';
    public $sitemap_xml = '';
    public $sitemap_url_count = 0;
    public $sitemap_size_limit = 10485760;
    public $sitemap_url_limit = 20000;
    public $sitemap_url = '';
    public $sitemap_xml_read = '';

    public function getSitemapInfo()
    {
        $sql = "SELECT * FROM `sitemap` ORDER BY `sitemap_id` DESC";
        $sitemap_all = DB::fetch($sql);

        foreach ($sitemap_all as $info) {
            $info['format_size'] = $this->formatSize($info['sitemap_size']);
            $this->sitemap_info[] = $info;
        }

        return $this->sitemap_info;
    }

    public function generate()
    {
        $this->deleteSitemap();
        $redirect_url = VSHARE_URL . '/admin/sitemap_generate.php';
        Http::redirect($redirect_url);
    }

    public function insert_sitemap($url_count, $sitemap_name)
    {
        $sitemap_size = filesize(VSHARE_DIR . '/sitemap/' . $sitemap_name);

        $sql = "INSERT INTO `sitemap` SET
               `sitemap_size`='$sitemap_size',
               `sitemap_create_date`='" . time() . "',
               `sitemap_url_count`='" . (int) $url_count . "',
               `sitemap_name`='$sitemap_name'";
        DB::query($sql);
    }

    public function createSitemapIndex()
    {
        $sql = "SELECT * FROM `sitemap` ORDER BY `sitemap_id` DESC";
        $sitemap_all = DB::fetch($sql);

        if ($sitemap_all) {
            $sitemap_index_fp = fopen(VSHARE_DIR . '/sitemap/sitemap_index.xml', 'w');
            $sitemap_index = $this->sitemap_index_header;
            fwrite($sitemap_index_fp, $sitemap_index);

            foreach ($sitemap_all as $sitemap_info) {
                $sitemap = '<sitemap>';
                fwrite($sitemap_index_fp, "\n\t\t" . $sitemap . "\n\t\t\t");
                $loc = '<loc>' . VSHARE_URL . '/sitemap/' . $sitemap_info['sitemap_name'] . '.gz</loc>';
                fwrite($sitemap_index_fp, $loc . "\n\t\t\t");
                $lastmod = '<lastmod>' . date('c', $sitemap_info['sitemap_create_date']) . '</lastmod>';
                fwrite($sitemap_index_fp, $lastmod . "\n\t\t");
                $sitemap = '</sitemap>';
                fwrite($sitemap_index_fp, $sitemap . "\n");
            }

            fwrite($sitemap_index_fp, $this->sitemap_index_close);
            fclose($sitemap_index_fp);
            $this->xml_to_gz('sitemap_index.xml');

            return $this->submitToGoogle();
        }
    }

    public function xml_to_gz($sitemap_name)
    {
        $sitemap_xml = VSHARE_DIR . '/sitemap/' . $sitemap_name;
        $gzip_sitemap_xml = VSHARE_DIR . '/sitemap/' . $sitemap_name . '.gz';
        exec("gzip -c $sitemap_xml > $gzip_sitemap_xml");
    }

    public function formatSize($size)
    {
        if ($size >= 1073741824) {
            $format_size = number_format($size / 1073741824, 1) . ' GB';
        } else if ($size >= 1048576) {
            $format_size = number_format($size / 1048576, 1) . ' MB';
        } else {
            $format_size = number_format($size / 1024, 1) . ' KB';
        }

        return $format_size;
    }

    public function createNewSitemapName()
    {
        $i = 0;
        $sitemap_name = 'sitemap';
        $sitemap_extn = 'xml';
        $file_name = $sitemap_name . '.' . $sitemap_extn;
        $desination = VSHARE_DIR . '/sitemap/' . $file_name;

        while (file_exists($desination)) {
            $i ++;
            $file_name = $sitemap_name . '_' . $i . '.' . $sitemap_extn;
            $desination = VSHARE_DIR . '/sitemap/' . $file_name;
        }

        return $file_name;
    }

    public function submitToGoogle()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://www.google.com/webmasters/tools/ping?sitemap=" . VSHARE_URL . "/sitemap/sitemap_index.xml.gz");
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
        return 'Sitemap Generated And Submitted to Google';
    }

    public function deleteSitemap()
    {
        $sitemap_info = $this->getSitemapInfo();

        $sql = "DELETE FROM `sitemap`";
        DB::query($sql);

        foreach ($sitemap_info as $key => $val) {
            if (file_exists(VSHARE_DIR . '/sitemap/' . $val['sitemap_name'])) {
                unlink(VSHARE_DIR . '/sitemap/' . $val['sitemap_name']);
            }
        }

        if (file_exists(VSHARE_DIR . '/sitemap/sitemap_index.xml.gz')) {
            unlink(VSHARE_DIR . '/sitemap/sitemap_index.xml.gz');
        }

        $this->sitemap_info = array();
    }

    public function cleanSitemap($str)
    {
        $bad = array(
        "_",
        "-",
        "^",
        ")",
        ".",
        "(",
        "%",
        "!",
        "@",
        "*",
        "../",
        "./",
        "<!--",
        "-->",
        "<",
        ">",
        "'",
        '"',
        '&',
        '$',
        '#',
        '{',
        '}',
        '[',
        ']',
        '=',
        ';',
        '?',
        '/',
        ':',
        "%20",
        "%22",
        "%3c", // <
        "%253c", // <
        "%3e", // >
        "%0e", // >
        "%28", // (
        "%29", // )
        "%2528", // (
        "%26", // &
        "%24", // $
        "%3f", // ?
        "%3b", // ;
        "%3d",
        "”",
        "“",
        "‘",
        "©",
        "—",
        "_",
        "-"
        );

        $str = str_replace($bad, '', $str);
        $str = strip_tags($str);
        $str = preg_replace('!&[^;\s]+;!', ' ', $str);
        //$str = convert_high_ascii($str);
        $str = trim($str);
        return $str;
    }
}
