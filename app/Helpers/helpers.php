<?php

/**
 * @param $msg
 * @param bool $asArray
 * @return array
 */
function generate_error($msg, $asArray = true) {
    if ($asArray) {
        return [
            'status' => 'error',
            'msg' => $msg
        ];
    }
    return encode_json([
        'status' => 'error',
        'msg' => $msg
    ]);
}
