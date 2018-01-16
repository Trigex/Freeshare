<?php

class DailymotionVideo extends Dailymotion
{
    private $apiKey;
    private $apiSecret;
    public $videoResult = array();
    public $videoId;
    public $vshareVideoId;

    private function getKey()
    {
        $this->apiKey = Config::get('dailymotion_api_key');
        $this->apiSecret = Config::get('dailymotion_api_secret');

        if (empty($this->apiKey) || empty($this->apiSecret))
        {
            $this->videoResult['err'] = 'Authentication Failed';
            return 0;
        }

        return 1;
    }

    public function videoInfo()
    {
        if (! $this->getKey())
        {
            return $this->videoResult;
        }
        else
        {
            $this->setGrantType(Dailymotion::GRANT_TYPE_CLIENT_CREDENTIALS, $this->apiKey, $this->apiSecret);
            $this->videoResult = $this->call('video.info', array(
                'id' => $this->videoId,
                'fields' => array(
                    'id',
                    'title',
                    'tags',
                    'description',
                    'duration',
                    'thumbnail_180_url',
                    'thumbnail_360_url',
                )
            ));

            return $this->videoResult;
        }
    }

    public function CreateThumb()
    {
        $sourceThumb = $this->videoResult['thumbnail_180_url'];
        $noThumb = VSHARE_DIR . '/themes/default/images/no_thumbnail.gif';
        $spriteSourceThumb = str_replace('jpeg_preview_medium','jpeg_preview_sprite',$this->videoResult['thumbnail_medium_url']);

        $destinationThumb = VSHARE_DIR . '/thumb/' . $this->vshareVideoId . '.jpg';
        $destinationThumb_1 = VSHARE_DIR . '/thumb/1_' . $this->vshareVideoId . '.jpg';
        $destinationThumb_2 = VSHARE_DIR . '/thumb/2_' . $this->vshareVideoId . '.jpg';
        $destinationThumb_3 = VSHARE_DIR . '/thumb/3_' . $this->vshareVideoId . '.jpg';

        $thumbFileSize = Http::download($this->videoResult['thumbnail_360_url'],$destinationThumb);

        if ($thumbFileSize < 2)
        {
            copy($noThumb,$destinationThumb);
        }

        $spriteDestinationThumb = VSHARE_DIR . '/templates_c/sprite_' . $this->vshareVideoId . '.jpg';
        $thumb_1_FileSize = Http::download($sourceThumb,$destinationThumb_1);

        if ($thumb_1_FileSize < 2)
        {
            copy($noThumb,$destinationThumb_1);
        }

        $spriteDestinationThumbFileSize = Http::download($spriteSourceThumb,$spriteDestinationThumb);

        if ($spriteDestinationThumbFileSize < 2)
        {
            copy($destinationThumb_1,$destinationThumb_2);
            copy($destinationThumb_1,$destinationThumb_3);
        }
        else
        {

            $sourceImage = imagecreatefromjpeg($spriteDestinationThumb);

            $img = imagecreatetruecolor(120,120);
            //create/copy image
            imagecopy($img,$sourceImage, 0, 0, 0, 0, 120, 120);
            $thumb_2 = imagecreatetruecolor(120,90);
            //resize image 120X90
            imagecopyresized($thumb_2, $img, 0, 0, 0, 0, 120, 90, 120, 120);
            imagejpeg($thumb_2,$destinationThumb_2,100);

            $img_1 = imagecreatetruecolor(120,120);
            //create/copy image
            imagecopy($img_1,$sourceImage, 0, 0, 0,120, 120, 120);
            $thumb_3 = imagecreatetruecolor(120,90);
            //resize image 120X90
            imagecopyresized($thumb_3, $img_1, 0, 0, 0, 0, 120, 90, 120, 120);
            imagejpeg($thumb_3,$destinationThumb_3,100);
            unlink($spriteDestinationThumb);
        }
    }

    public function getIdFromUrl($url)
    {
        if (preg_match('/.*dailymotion.com\/video\/([a-zA-Z0-9]+)+_/', $url, $matches)) {
            if (isset($matches[1])) {
                return $matches[1];
            }
        }
        return 0;
    }
}
