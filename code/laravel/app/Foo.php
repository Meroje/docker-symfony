<?php

namespace App;

use Faker\Factory as Faker;
use Ramsey\Uuid\Uuid;

class Foo
{
    /**
     * @var Uuid
     */
    protected $uuid;


    /**
     * @var string
     */
    protected $text;

    public function __construct()
    {
        $faker = Faker::create();
        $this->uuid = Uuid::uuid4();
        $this->text = $faker->text;
    }

    /**
     * @return mixed
     */
    public function getUuid()
    {
        return $this->uuid->toString();
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }
}
