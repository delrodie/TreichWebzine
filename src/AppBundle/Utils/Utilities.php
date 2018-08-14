<?php

namespace AppBundle\Utils;

class Utilities
{
    public function resume($string, $max_length = 30, $replacement = '', $trunc_at_space = false)
    {
        $max_length -= strlen($replacement);
        $string_length = strlen($string);

        if($string_length <= $max_length)
            return $string;

        if( $trunc_at_space && ($space_position = strrpos($string, ' ', $max_length-$string_length)) )
            $max_length = $space_position;

        return strip_tags(substr_replace($string, $replacement, $max_length));
    }
}