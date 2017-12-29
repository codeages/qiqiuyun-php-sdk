<?php

namespace QiQiuYun\SDK;

class SignUtil
{
    public function serialize($data)
    {
        if (!is_array($data)) {
            throw new \InvalidArgumentException("In json hmac specification serialize data must be array.");
        }

        ksort($data);

        $json = json_encode($data);
        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new \InvalidArgumentException(
                'json_encode error: '.json_last_error_msg());
        }

        return $json;
    }

   
}
