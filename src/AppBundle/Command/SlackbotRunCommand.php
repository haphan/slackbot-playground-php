<?php

namespace AppBundle\Command;

use AppBundle\Bot\CarousellBot;
use AppBundle\SDK\CarousellSDK;
use CL\Slack\Payload\ChatPostMessagePayload;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\VarDumper\VarDumper;

class SlackbotRunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('slackbot:run')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $bot = $this->getCarousellBot();

        $result = $bot->run([
            'query' => 'nexus 5x',
            'price_start' => 200,
            'price_end' => 300,
            'sort' => 'recent'
        ]);


        $product = current($result);

        $message = new ChatPostMessagePayload();
        $message->setChannel('hotdeals');
        $message->setUnfurlLinks(true);
        $message->setUnfurlMedia(true);
        //$message->setParse()
        //$message->setAsUser(true);
        //$message->setUsername('carousell');
        //$message->setText(sprintf('*$%s* %s. See https://carousell.com/p/%d', $product['price'], $product['title'], $product['id']));
        $message->setText(sprintf('https://carousell.com/p/%d', $product['id']));
        //$message->setIconUrl($product['photo']);

        $response = $this->getSlackClient()->send($message);

        $output->writeln($message->getText());
    }

    /**
     * @return CarousellSDK
     */
    private function getCarousellSDK()
    {
        return $this->getContainer()->get('app.sdk.carousell');
    }

    /**
     * @return CarousellBot
     */
    private function getCarousellBot()
    {
        return $this->getContainer()->get('app.bot.carousell');
    }

    private function getSlackClient()
    {
        return $this->getContainer()->get('cl_slack.api_client');
    }
}