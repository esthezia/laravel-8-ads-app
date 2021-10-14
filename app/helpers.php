<?php

/**
 * @param (int) $max - optionally provide a value that should not be exceeded.
 *                     the format is as the php.ini, e.g. 2M.
 */
function getMaxFileUploadSizeInBytes($max = null) {
    $result = min(convertFileSizeToBytes(ini_get('post_max_size')), convertFileSizeToBytes(ini_get('upload_max_filesize')));

    if (!empty($max)) {
        $result = min($result, convertFileSizeToBytes($max));
    }

    return $result;
}

/**
 * Transform the php.ini notation for numbers (like '2M')
 * to an integer (2 * 1024 * 1024 in this case)
 *
 * @param (string) $fileSize
 * @return (int) the number of bytes
 */
function convertFileSizeToBytes($fileSize) {
    if (empty($fileSize)) {
        return (int) $fileSize;
    }

    $suffix = strtoupper(substr($fileSize, -1));

    $validSuffixes = ['P','T','G','M','K'];

    if (!in_array($suffix, $validSuffixes)) {
        return (int) $fileSize;
    }

    $value = substr($fileSize, 0, -1);

    switch ($suffix) {
        case 'P':
            $value *= 1024;
            // no break. fallthrough intended.
        case 'T':
            $value *= 1024;
            // no break. fallthrough intended.
        case 'G':
            $value *= 1024;
            // no break. fallthrough intended.
        case 'M':
            $value *= 1024;
            // no break. fallthrough intended.
        case 'K':
            $value *= 1024;
            break;
    }

    return (int) $value;
}

/**
 * @param (string) $name
 * @param (string) $delimiter - one of: -, _, (empty string)
 */
function getSlugFromName ($name, $delimiter = '-') {
    if (empty($name)) {
        return '';
    }

    if (($delimiter !== '-') && ($delimiter !== '_') && ($delimiter !== '')) {
        $delimiter = '-';
    }

    $result = $name;

    $replacements = [
        'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'a',
        'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'A',
        'þ' => 'b',
        'Þ' => 'B',
        'ç' => 'c', 'ć' => 'c', 'č' => 'c',
        'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C',
        'đ' => 'dj',
        'Đ' => 'Dj',
        'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
        'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E',
        'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
        'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
        'ñ' => 'n',
        'Ñ' => 'N',
        'ð' => 'o', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ø' => 'o',
        'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ø' => 'O',
        'ŕ' => 'r',
        'Ŕ' => 'R',
        'š' => 's',
        'Š' => 'S',
        'ß' => 'Ss',
        'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
        'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U',
        'ý' => 'y', 'ÿ' => 'y',
        'Ý' => 'Y', 'Ÿ' => 'Y',
        'ž' => 'z',
        'Ž' => 'Z',
        '/' => $delimiter,
        ' ' => $delimiter
    ];

    $result = preg_replace(array('/\s{2,}/', '/[\t\n]/'), ' ', trim($result)); // first, remove duplicate spaces
    $result = strtr($name, $replacements);
    $result = strtolower($result);
    $result = preg_replace('/[^a-z0-9]+/', '', $result);

    return $result;
}
