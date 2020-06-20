<?php

function raw($class, $attributes = [], $times = null)
{
    return factory($class, $times)->raw($attributes);
}

function create($class, $attributes = [], $times = null)
{
    return factory($class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}