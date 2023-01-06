<?php
//DBやdebugの切替
function get_config_name()
{
    //ドメインでConfigを切り替える。
    if (is_included_host(['demo-v5m', 'dev', 'localhost', 'caters', 'test', 'local'])) {
        return 'app_develop';
    }
    return 'app';
}


function is_included_host($targets = array())
{
    foreach ($targets as $target) {
        if (strpos(env('HTTP_HOST'), $target) !== false) {
            return true;
        }
    }
    return false;
}


function is_included_docRoot($targets = array())
{
    foreach ($targets as $target) {
        if (strpos(env('SCRIPT_FILENAME'), $target) !== false) {
            return true;
        }
    }
    return false;
}


function render_text_schedule($start, $end = null)
{
    $days = array('日', '月', '火', '水', '木', '金', '土');
    $txt = $start->format(__('Y年n月j日（{0}）/ G:i　〜　', $days[$start->format('w')]));
    if (!is_null($end)) {
        $txt .= $end->format('Ymd') === $start->format('Ymd') ? $end->format('G:i') : $end->format(__('Y年n月j日（{0}）/ G:i', $days[$end->format('w')]));
    }
    return $txt;
}


class Image
{
    /**
     * 画像（バイナリ）のEXif情報を元に回転する
     */
    public function rotateFromBinary($binary)
    {
        $exif_data = $this->getExifFromBinary($binary);
        if (empty($exif_data['Orientation']) || in_array($exif_data['Orientation'], [1, 2])) {
            return $binary;
        }
        return $this->rotate($binary, $exif_data);
    }

    /**
     * バイナリデータからexif情報を取得
     */
    private function getExifFromBinary($binary)
    {
        $temp = tmpfile();
        fwrite($temp, $binary);
        fseek($temp, 0);

        $meta_data = stream_get_meta_data($temp);
        $exif_data = @exif_read_data($meta_data['uri']);

        fclose($temp);
        return $exif_data;
    }

    /**
     * 画像を回転させる
     */
    private function rotate($binary, $exif_data)
    {
        ini_set('memory_limit', '256M');

        $src_image = imagecreatefromstring($binary);

        $degrees = 0;
        $mode = '';
        switch ($exif_data['Orientation']) {
            case 2: // 水平反転
                $mode = IMG_FLIP_VERTICAL;
                break;
            case 3: // 180度回転
                $degrees = 180;
                break;
            case 4: // 垂直反転
                $mode = IMG_FLIP_HORIZONTAL;
                break;
            case 5: // 水平反転、 反時計回りに270回転
                $degrees = 270;
                $mode = IMG_FLIP_VERTICAL;
                break;
            case 6: // 反時計回りに270回転
                $degrees = 270;
                break;
            case 7: // 反時計回りに90度回転（反時計回りに90度回転） 水平反転
                $degrees = 90;
                $mode = IMG_FLIP_VERTICAL;
                break;
            case 8: // 反時計回りに90度回転（反時計回りに90度回転）
                $degrees = 90;
                break;
        }

        if (!empty($mode)) {
            imageflip($src_image, $mode);
        }

        if ($degrees > 0) {
            $src_image = imagerotate($src_image, $degrees, 0);
        }

        ob_start();
        if (empty($exif_data['MimeType']) || $exif_data['MimeType'] == 'image/jpeg') {
            imagejpeg($src_image);
        } elseif ($exif_data['MimeType'] == 'image/png') {
            imagepng($src_image);
        } elseif ($exif_data['MimeType'] == 'image/gif') {
            imagegif($src_image);
        }
        imagedestroy($src_image);
        return ob_get_clean();
    }
}

function renderBackUrl($param, $default_url = null)
{
    if (!isset($_SERVER['HTTP_REFERER']) || strpos($_SERVER['HTTP_REFERER'], $param) === false) {
        $url = $default_url ? $default_url : __('/{0}', $param);
    } else {
        $url = $_SERVER['HTTP_REFERER'];
    }
    return $url;
}

function icon($str)
{
    if ($str == 'doc' || $str == 'docx') {
        $icon = 'word';
    } elseif ($str == 'xls' || $str == 'xlsx') {
        $icon = 'excel';
    } else {
        $icon = 'pdf';
    }
    return $icon;
}

function html_decode($text)
{
    return html_entity_decode(h($text));
}

function getIDofYTfromURL($url)
{
    preg_match('/^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/', $url, $id, PREG_UNMATCHED_AS_NULL);
    return $id ? $id[1] : null;
}

function is_show($content)
{

    switch (intval($content['block_type'])) {
        case 3:
            $is_show = trim($content['image']) === '';
            break;
        case 11:
            $is_show = trim($content['image']) === '' && trim($content['content']) === '';
            break;
        case 2:
            $is_show = trim($content['content']) === '';
            break;
        case 4:
            $is_show = trim($content['file']) === '';
            break;
        case 10:
            $is_show = empty($content['sub_contents']);
            break;
        case 22:
            $is_show = trim($content['before_text']) === '' && trim($content['after_text']) === '';
            break;
        case 23:
        case 24:
        case 25:
        case 26:
            $is_show = false;
            break;
        default:
            $is_show = trim($content['title']) === '';
    }

    return $is_show;
}

function human_filesize($bytes, $decimals = 2)
{
    $sz = 'BKMGTP';
    $factor = floor((strlen($bytes) - 1) / 3);
    $s = @$sz[$factor];
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ($s != 'B' ? $s . 'B' : $s);
}
