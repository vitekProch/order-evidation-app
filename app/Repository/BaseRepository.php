<?php

namespace App\Repository;
use Nette;

class BaseRepository
{
    use Nette\SmartObject;

    /** @var Nette\Database\Context */
    protected Nette\Database\Context $database;

    public function __construct(Nette\Database\Context $database)
    {
        $this->database = $database;
    }
}