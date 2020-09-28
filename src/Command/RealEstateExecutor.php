<?php

namespace App\Command;

use App\Hook\RealEstateHook;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Converter\JsonConverter;

class RealEstateExecutor extends Command
{
    protected function configure()
    {
        $this->setName('real-estate-executor');
        $this->formatter = new RealEstateHook();
    }

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filepath = $this->params->get('jsonFile');

        $formatted_ads = [];
        $ads           = JsonConverter::jsonToArray($filepath);

        foreach ($ads as $ad) {
            RealEstateHook::formatAd($ad);
            //send();
        }

        print_r($formatted_ads);

        return 0;
    }
}
