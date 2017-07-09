<?php
function groupCssMediaQueries($css1)
{
    $css = $css1;
    preg_match_all('#@media(.*?)\{(.+?}[ \n])\}#si', $css, $match, PREG_SET_ORDER);
    $media = array();
    foreach ($match as $val) {
        if (!isset($media[$val[1]])) $media[$val[1]] = '';
        $media[$val[1]] .= $val[2];
    }
    $mediaOther = array();
    $mediaMinWidth = array();
    $mediaMaxWidth = array();
    $mediaMinMaxWidth = array();
    $emToPxRatio = 16;
    foreach ($media as $id => $val) {
        $minWidth = null;
        $maxWidth = null;
        if ((strpos($id, 'min-width') !== false) && (strpos($id, 'max-width') !== false)) {
            $match = null;
            preg_match('/min-width:\\s*(\\d+)(px|em)?/', $id, $match);
            $minWidth = intval($match[1]);
            if ($match[2] === 'em') {
                $minWidth = $minWidth * $emToPxRatio;
            }
            $match = null;
            preg_match('/max-width:\\s*(\\d+)(px|em)?/', $id, $match);
            $maxWidth = intval($match[1]);
            if ($match[2] === 'em') {
                $maxWidth = $maxWidth * $emToPxRatio;
            }
            $value = array('rule' => $id, 'minWidth' => $minWidth, 'maxWidth' => $maxWidth, 'content' => $val);
            array_push($mediaMinMaxWidth, $value);
        } else if (strpos($id, 'max-width') !== false) {
            $match = null;
            preg_match('/max-width:\\s*(\\d+)(px|em)?/', $id, $match);
            $maxWidth = intval($match[1]);
            if ($match[2] === 'em') {
                $maxWidth = $maxWidth * $emToPxRatio;
            }
            $value = array('rule' => $id, 'minWidth' => $minWidth, 'maxWidth' => $maxWidth, 'content' => $val);
            array_push($mediaMaxWidth, $value);
        } else if (strpos($id, 'min-width') !== false) {
            $match = null;
            preg_match('/min-width:\\s*(\\d+)(px|em)?/', $id, $match);
            $minWidth = intval($match[1]);
            if ($match[2] === 'em') {
                $minWidth = $minWidth * $emToPxRatio;
            }
            $value = array('rule' => $id, 'minWidth' => $minWidth, 'maxWidth' => $maxWidth, 'content' => $val);
            array_push($mediaMinWidth, $value);
        } else {
            $value = array('rule' => $id, 'minWidth' => $minWidth, 'maxWidth' => $maxWidth, 'content' => $val);
            array_push($mediaOther, $value);
        }
    }
    usort($mediaMinWidth, function ($a, $b) {
        return $a['minWidth'] - $b['minWidth'];
    });
    usort($mediaMaxWidth, function ($a, $b) {
        return $b['maxWidth'] - $a['maxWidth'];
    });
    $mediaResult = array();
    $mediaResult = array_merge($mediaResult, $mediaMinWidth, $mediaMaxWidth, $mediaMinMaxWidth, $mediaOther);
    $css = preg_replace('#@media(.*?)\{(.+?}[ \n])\}#si', '', $css);
    $css = $css . "\n";
    for ($i = 0; count($mediaResult) > $i; $i++) {
        $css .= "\n" . '@media' . $mediaResult[$i]['rule'] . '{' . $mediaResult[$i]['content'] . '}' . "\n";
    }
    return $css;
}