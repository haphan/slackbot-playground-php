<?php

namespace AppBundle\Bot;

use AppBundle\SDK\CarousellSDK;
use Symfony\Component\VarDumper\VarDumper;

class CarousellBot
{
    /** @var CarousellSDK */
    private $sdk;

    private $queries = [

    ];

    public function __construct(CarousellSDK $sdk)
    {
        $this->sdk = $sdk;
    }

    public function run(array $condition)
    {
        $result =  $this->sdk->products($condition);

        if(!is_array($result) || !isset($result['products']) || empty($result['products']) || $result['no_result'])
        {
            return [];
        }

        return \JmesPath\Env::search('[*].{id: id, title: title,description: description, price: price, photo: primary_photo_url}', $result['products']);

    }
}