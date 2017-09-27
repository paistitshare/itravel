<?php

namespace Itravel\Exception;

interface IOExceptionInterface
{
    /**
     * Returns the associated path for the exception.
     *
     * @return string The path
     */
    public function getPath();
}