<?php

namespace App\Services;

use App\Services\Hquery\CustomScraper;
use Symfony\Component\Panther\Client;

class WebDriver
{
    protected CustomScraper $scraper;
    protected string $url;

    public function __construct(CustomScraper $scraper, string $url)
    {
        $this->scraper = $scraper;
        $this->url = $url;
    }

    protected function buildJsScript(string $selector) :string
    {
        return "document.querySelector('.{$selector}').click()";
    }

    public function getPhoneNumber() :string
    {
        try {
            $client = Client::createChromeClient();
            $client->request('GET', $this->url);

            $html = $client->waitFor('.css-18icqaw')->html();

            $this->scraper->setHtml($html);

            $sel = $this->scraper->getNeedyButtonSelector();

            $script = $this->buildJsScript($sel);

            $client->executeScript($script);

            $updatedHtml = $client->waitFor('.css-v1ndtc')->html();
            $this->scraper->setHtml($updatedHtml);

            return $this->scraper->getNumber();
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
        }
    }

    public function getTitles() :array
    {
        try {
            $client = Client::createChromeClient();
            $client->request('GET', $this->url);

            $html = $client->waitFor('.css-1sw7q4x')->html();
            $this->scraper->setHtml($html);

            return $this->scraper->getTitles();
        } catch (\Exception $exception) {
            var_dump($exception->getMessage());
        }
    }
}
