<?php

namespace Itravel\Exception;

interface Exception
{
    /**
     * This is the only thing, really...
     *
     * Return a raw (unformatted) version of the message.
     *
     * @return string
     */
    public function getRawMessage();
}

