<?php

class formatarData
{
    public static function dataFormatada($data, $format) {
        switch ($format) {
            case 'BR':
                return implode('/', array_reverse(explode('-', $data)));
            case 'US':
                return implode('-', array_reverse(explode('/', $data)));
        }
        return '';
    }
}