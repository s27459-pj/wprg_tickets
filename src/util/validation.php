<?php

function requireParams(array $params): void
{
    foreach ($params as $param) {
        if (!isset($_POST[$param])) {
            http_response_code(400);
            exit("Missing required parameter: $param");
        }
    }
}
