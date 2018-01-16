<?php

class Image
{
    public static function createThumb($srcname, $destname, $maxwidth, $maxheight)
    {
        $oldimg = $srcname;
        $imagedata = GetImageSize($oldimg);
        $imagewidth = $imagedata[0];
        $imageheight = $imagedata[1];
        $imagetype = $imagedata[2];

        if ($imagetype == 2) {
            $src_img = imagecreatefromjpeg($oldimg);
        } else if ($imagetype == 3) {
            $src_img = imagecreatefrompng($oldimg);
        } else {
            $src_img = imagecreatefromgif($oldimg);
        }

        $dst_img = imagecreatetruecolor($maxwidth, $maxheight);
        imagecopyresized($dst_img, $src_img, 0, 0, 0, 0, $maxwidth, $maxheight, $imagewidth, $imageheight);
        imagejpeg($dst_img, $destname);
        imagedestroy($src_img);
        imagedestroy($dst_img);
    }
}