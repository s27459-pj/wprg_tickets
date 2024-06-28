<?php
require_once __DIR__ . "/../../bootstrap.php";

function getEnumDisplayName(BackedEnum $variant): string
{
    return ucwords(str_replace("_", " ", $variant->value));
}
