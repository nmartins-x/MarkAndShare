<?php

function raw($class, $attributes = [], $times = null)
{
    return factory($class, $times)->raw($attributes);
}
