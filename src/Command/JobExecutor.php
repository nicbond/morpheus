<?php

namespace App\Command;

use App\Hook\JobHook;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class JobExecutor extends Command
{
    protected function configure()
    {
        $this->setName('job-executor');
        $this->formatter = new JobHook();
    }

    public function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $filepath = $this->params->get('xmlFile');
        var_dump($filepath);die;

        $formatted_ads = [];
        $ads           = XMLConverter::xmlToArray($filepath);

        foreach ($ads as $ad) {
            // format and send ads
            formatAd();
            send();
        }

        print_r($formatted_ads);

        return 0;
    }
}
