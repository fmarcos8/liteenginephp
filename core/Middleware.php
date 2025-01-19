<?php

namespace Core;

abstract class Middleware
{
    abstract public function handle(Request $request);
}