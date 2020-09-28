<?php

namespace App\Command;

use App\Hook\JobHook;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Converter\XMLConverter;

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

        $formatted_ads = [];
        $ads           = XMLConverter::xmlToArray($filepath);

        foreach ($ads as $ad) {
            foreach ($ad as $data) {
                JobHook::formatAd($data);
                send();
            }
        }

        print_r($formatted_ads);

        return 0;
    }
}
