<?php

namespace App\Command;

use App\Hook\JobHook;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class JobExecutor extends Command
{
    protected function configure()
    {
        $this->setName('job-executor');
        $this->formatter = new JobHook();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
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
