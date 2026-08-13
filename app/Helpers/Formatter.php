<?php

namespace App\Helpers;
use Collective\Html\HtmlFacade as Html;
use Carbon;

class Formatter {

    /**
     * @return la date convertie en dd/mm/yyyy
    */
    public static function convertDate($date) {
        if ($date == '') {
            return '';
        }
        return date ( 'd/m/Y', strtotime ( $date ) );
    }

    public static function convertDateFromTimestamp($date) {
        if ($date == '') {
            return '';
        }
        return date('d/m/Y', $date);
    }

    /**
     *  @return l''intervalle de de date exploitable
     */
    public static function range($start, $end) {
        return self::convertToTimeWithoutSeconde($start) . ' => ' . self::convertToTimeWithoutSeconde($end);
    }

    /** @return la date convertie en dd/mm/yyyy hh:mm */
    public static function convertToTimeWithoutSeconde($date) {
        if ($date == '') {
            return '';
        }
        return date('d/m/Y H:i', $date);
    }

    /** @return la date convertie en dd/mm/yyyy hh:mm */
    public static function convertToTimeWithoutSecondeBis($date) {
        if ($date == '') {
            return '';
        }
        return date('d F Y à H:i', $date);
    }

    /**
     * @return la date convertie en dd/mm/yyyy hh:mm:ss
    */
    public static function convertDateTime($date) {
        if ($date == '') {
            return '';
        }
        return date ( 'd/m/Y H:i:s', strtotime ( $date ) );
    }

    /**
     * @return la date convertie en dd/mm/yyyy hh:mm:ss
    */
    public static function convertTimestampToDateTime($date) {
        if ($date == '') {
            return '';
        }
        return date ( 'd/m/Y H:i:s',  $date );
    }

public static function remove_accents($string) {
    if ( !preg_match('/[\x80-\xff]/', $string) )
        return $string;

    $chars = array(
    // Decompositions for Latin-1 Supplement
    chr(195).chr(128) => 'A', chr(195).chr(129) => 'A',
    chr(195).chr(130) => 'A', chr(195).chr(131) => 'A',
    chr(195).chr(132) => 'A', chr(195).chr(133) => 'A',
    chr(195).chr(135) => 'C', chr(195).chr(136) => 'E',
    chr(195).chr(137) => 'E', chr(195).chr(138) => 'E',
    chr(195).chr(139) => 'E', chr(195).chr(140) => 'I',
    chr(195).chr(141) => 'I', chr(195).chr(142) => 'I',
    chr(195).chr(143) => 'I', chr(195).chr(145) => 'N',
    chr(195).chr(146) => 'O', chr(195).chr(147) => 'O',
    chr(195).chr(148) => 'O', chr(195).chr(149) => 'O',
    chr(195).chr(150) => 'O', chr(195).chr(153) => 'U',
    chr(195).chr(154) => 'U', chr(195).chr(155) => 'U',
    chr(195).chr(156) => 'U', chr(195).chr(157) => 'Y',
    chr(195).chr(159) => 's', chr(195).chr(160) => 'a',
    chr(195).chr(161) => 'a', chr(195).chr(162) => 'a',
    chr(195).chr(163) => 'a', chr(195).chr(164) => 'a',
    chr(195).chr(165) => 'a', chr(195).chr(167) => 'c',
    chr(195).chr(168) => 'e', chr(195).chr(169) => 'e',
    chr(195).chr(170) => 'e', chr(195).chr(171) => 'e',
    chr(195).chr(172) => 'i', chr(195).chr(173) => 'i',
    chr(195).chr(174) => 'i', chr(195).chr(175) => 'i',
    chr(195).chr(177) => 'n', chr(195).chr(178) => 'o',
    chr(195).chr(179) => 'o', chr(195).chr(180) => 'o',
    chr(195).chr(181) => 'o', chr(195).chr(182) => 'o',
    chr(195).chr(182) => 'o', chr(195).chr(185) => 'u',
    chr(195).chr(186) => 'u', chr(195).chr(187) => 'u',
    chr(195).chr(188) => 'u', chr(195).chr(189) => 'y',
    chr(195).chr(191) => 'y',
    // Decompositions for Latin Extended-A
    chr(196).chr(128) => 'A', chr(196).chr(129) => 'a',
    chr(196).chr(130) => 'A', chr(196).chr(131) => 'a',
    chr(196).chr(132) => 'A', chr(196).chr(133) => 'a',
    chr(196).chr(134) => 'C', chr(196).chr(135) => 'c',
    chr(196).chr(136) => 'C', chr(196).chr(137) => 'c',
    chr(196).chr(138) => 'C', chr(196).chr(139) => 'c',
    chr(196).chr(140) => 'C', chr(196).chr(141) => 'c',
    chr(196).chr(142) => 'D', chr(196).chr(143) => 'd',
    chr(196).chr(144) => 'D', chr(196).chr(145) => 'd',
    chr(196).chr(146) => 'E', chr(196).chr(147) => 'e',
    chr(196).chr(148) => 'E', chr(196).chr(149) => 'e',
    chr(196).chr(150) => 'E', chr(196).chr(151) => 'e',
    chr(196).chr(152) => 'E', chr(196).chr(153) => 'e',
    chr(196).chr(154) => 'E', chr(196).chr(155) => 'e',
    chr(196).chr(156) => 'G', chr(196).chr(157) => 'g',
    chr(196).chr(158) => 'G', chr(196).chr(159) => 'g',
    chr(196).chr(160) => 'G', chr(196).chr(161) => 'g',
    chr(196).chr(162) => 'G', chr(196).chr(163) => 'g',
    chr(196).chr(164) => 'H', chr(196).chr(165) => 'h',
    chr(196).chr(166) => 'H', chr(196).chr(167) => 'h',
    chr(196).chr(168) => 'I', chr(196).chr(169) => 'i',
    chr(196).chr(170) => 'I', chr(196).chr(171) => 'i',
    chr(196).chr(172) => 'I', chr(196).chr(173) => 'i',
    chr(196).chr(174) => 'I', chr(196).chr(175) => 'i',
    chr(196).chr(176) => 'I', chr(196).chr(177) => 'i',
    chr(196).chr(178) => 'IJ',chr(196).chr(179) => 'ij',
    chr(196).chr(180) => 'J', chr(196).chr(181) => 'j',
    chr(196).chr(182) => 'K', chr(196).chr(183) => 'k',
    chr(196).chr(184) => 'k', chr(196).chr(185) => 'L',
    chr(196).chr(186) => 'l', chr(196).chr(187) => 'L',
    chr(196).chr(188) => 'l', chr(196).chr(189) => 'L',
    chr(196).chr(190) => 'l', chr(196).chr(191) => 'L',
    chr(197).chr(128) => 'l', chr(197).chr(129) => 'L',
    chr(197).chr(130) => 'l', chr(197).chr(131) => 'N',
    chr(197).chr(132) => 'n', chr(197).chr(133) => 'N',
    chr(197).chr(134) => 'n', chr(197).chr(135) => 'N',
    chr(197).chr(136) => 'n', chr(197).chr(137) => 'N',
    chr(197).chr(138) => 'n', chr(197).chr(139) => 'N',
    chr(197).chr(140) => 'O', chr(197).chr(141) => 'o',
    chr(197).chr(142) => 'O', chr(197).chr(143) => 'o',
    chr(197).chr(144) => 'O', chr(197).chr(145) => 'o',
    chr(197).chr(146) => 'OE',chr(197).chr(147) => 'oe',
    chr(197).chr(148) => 'R',chr(197).chr(149) => 'r',
    chr(197).chr(150) => 'R',chr(197).chr(151) => 'r',
    chr(197).chr(152) => 'R',chr(197).chr(153) => 'r',
    chr(197).chr(154) => 'S',chr(197).chr(155) => 's',
    chr(197).chr(156) => 'S',chr(197).chr(157) => 's',
    chr(197).chr(158) => 'S',chr(197).chr(159) => 's',
    chr(197).chr(160) => 'S', chr(197).chr(161) => 's',
    chr(197).chr(162) => 'T', chr(197).chr(163) => 't',
    chr(197).chr(164) => 'T', chr(197).chr(165) => 't',
    chr(197).chr(166) => 'T', chr(197).chr(167) => 't',
    chr(197).chr(168) => 'U', chr(197).chr(169) => 'u',
    chr(197).chr(170) => 'U', chr(197).chr(171) => 'u',
    chr(197).chr(172) => 'U', chr(197).chr(173) => 'u',
    chr(197).chr(174) => 'U', chr(197).chr(175) => 'u',
    chr(197).chr(176) => 'U', chr(197).chr(177) => 'u',
    chr(197).chr(178) => 'U', chr(197).chr(179) => 'u',
    chr(197).chr(180) => 'W', chr(197).chr(181) => 'w',
    chr(197).chr(182) => 'Y', chr(197).chr(183) => 'y',
    chr(197).chr(184) => 'Y', chr(197).chr(185) => 'Z',
    chr(197).chr(186) => 'z', chr(197).chr(187) => 'Z',
    chr(197).chr(188) => 'z', chr(197).chr(189) => 'Z',
    chr(197).chr(190) => 'z', chr(197).chr(191) => 's'
    );

    $string = strtr($string, $chars);

    return $string;
}

public static function mapFromSlug($slug) {
    $slug = array_reverse($slug);
    // Génération de la chaîne
    $toString = "";
    for ($i = 0; $i < count_of($slug)-1; $i++) {
        $toString .= $slug[$i]->name.", ";
    }
    if( empty(trim($toString)) ){
      return $slug[0]->name;
    }
    return $toString;
}

/** Affiche un bouton avec une icone*/
public static function button($route, $class, $icon, $text, $args = array()) {
    $result = '<a href="'.$route.'" class="btn btn-'.$class.' btn-sm btn-icon icon-left" ';
    foreach($args as $key => $arg) {
        $result .= $key.'="'.$arg.'" ';
    }
    $result .= '>';
    $result .= '<i class="'.$icon.'"></i>';
    $result .= $text;
    $result .= '</a>';

    return $result;
}

public static function deleteButton($data) {
    return Formatter::button('#', 'danger delete', 'entypo-cancel', 'Supprimer', ['data' => $data]);
}

public static function previewButton($data) {
    return Formatter::button('#', 'info preview', 'fa fa-eye', 'Aperçu', ['data' => $data]);
}

public static function addButton($route) {
    return Formatter::button($route, 'primary', 'entypo-plus', 'Ajouter');
}

public static function editButton($route) {
    return Formatter::button($route, 'default', 'entypo-pencil', 'Editer');
}

public static function seeButton($route) {
    return Formatter::button($route, 'info', 'entypo-eye', 'Voir');
}

/** Affiche un popup pour confirmer la suppression */
public static function preview($id, $message) {
    return  Formatter::popup(array(), 'modal-preview-'.$id, 'Aperçu', $message);
}

/** Affiche un popup pour confirmer la suppression */
public static function delete($route, $id, $title, $message) {
    $button = Formatter::button($route, 'danger', 'entypo-cancel', 'Supprimer');
    return  Formatter::popup([$button], 'modal-delete-'.$id, $title, $message);
}


/** Affiche un popup  */
public static function popup(Array $buttons = array(), $id = null, $title = null, $message) {
    $content = '<div class="modal fade" id="'.$id.'">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title">'.$title.'</h4>
                            </div>

                            <div class="modal-body">'.$message.'</div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>';

    foreach ($buttons as $button) {
        $content .= $button;
    }

    $content .= '           </div>
                        </div>
                    </div>
                </div>';
    return $content;
}

    /** Convertit un slug en chaine (valeur) */
    public static function slugToString($array) {
        $str = '';
        foreach($array as $item) {
            $str .= $item->value .'/';
        }
        $str .= $array[count_of($array) -1]->key;
        return $str;
    }

        /** Convertit un slug en chaine (nom) */
    public static function slugToNames($array) {
        $str = '';
        for($i = 0; $i < count_of($array) - 1; $i++) {
            $str .= $array[$i]->name .' -> ';
        }
        $str .= $array[count_of($array) - 1]->name;
        return $str;
    }

    /** Retourne la chaine sous la forme id/item/item/item*/
    public static function slugWithId($array) {
        $str = $array[count_of($array) -1]->key;
        foreach($array as $item) {
            $str .= '/'.$item->value;
        }
        return $str;
    }

    public static function linkWithIcon($route, $icon, $message = null, $args = []) {
        $str = "<a href='".$route."' ";
        foreach($args as $key => $arg) {
            $str .= $key.'="'.$arg.'" ';
        }
        $str .= "><i class='".$icon."'></i></a>";
        return $str;
    }

    public static function getVideoType($url) {
        if (preg_match('%youtu%i', $url, $match)) {
            return 'youtube';
        } if (preg_match('%vimeo%i', $url, $match)) {
            return 'vimeo';
        } else {
            return '';
        }
    }

    public static function getYoutubeMiniature($url) {
      if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
        $video_id = $match[1];
        return "//img.youtube.com/vi/" . $video_id . "/mqdefault.jpg";
      }
      else return "";
    }

    public static function getYoutubeEmbed($url) {
      if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match)) {
        $video_id = $match[1];
        return "//www.youtube.com/embed/" . $video_id;
      }
      else return "";
    }

    public static function getVimeoMiniature($url, $size = 'small') {
        if (preg_match('%((www\.|player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|video\/|))(\d+)%i', $url, $match)) {
            $jsonThumbnail = '';
            $video_id = $match[count_of($match)-1];
            $jsonString = file_get_contents("https://vimeo.com/api/v2/video/" . $video_id . ".json");
            if (!empty($jsonString)) {
                $jsonVideo = json_decode($jsonString);
                if ($jsonVideo && isset($jsonVideo[0])) {
                    if ($size == 'small') {
                        $jsonThumbnail = $jsonVideo[0]->thumbnail_small;
                    } else if ($size == 'large') {
                        $jsonThumbnail = $jsonVideo[0]->thumbnail_large;
                    }
                }
            }

            return $jsonThumbnail;
        }
        else return "";
    }

    public static function getVimeoEmbed($url) {
        if (preg_match('%((www\.|player\.)?vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|video\/|))(\d+)%i', $url, $match)) {
            $videoEmbed = '';
            $video_id = $match[count_of($match)-1];
            if (!empty($video_id)) {
                $videoEmbed = "//player.vimeo.com/video/" . $video_id;
            }
            return $videoEmbed;
        }
        else return "";
    }

}
