<?php

namespace App\Services\Hquery;

use mysql_xdevapi\DocResult;

class CustomScraper
{
    protected mixed $dom;

    public function __construct(string $html = null)
    {
        if ($html) {
            $this->dom = \hQuery::fromHTML($html);
        }
    }

    public function setHtml(string $html) :void
    {
        $this->dom = \hQuery::fromHTML($html);
    }

    public function getNeedyButtonSelector() :string|null
    {
        $spans = $this->dom->find('span');

        foreach ($spans as $span)
        {
            $text = $span->text();

            if ($text === 'Qo`ng`iroq qilish' | $text === 'Показать телефон') {
                return $span->parent()->attr('class');
            }
        }

        return null;
    }

    public function getNumber() :string|null
    {
        $links = $this->dom->find('a');

        foreach ($links as $link)
        {
            if ($link->attr('data-testid') === 'contact-phone') {
                return $link->text();
            }
        }

        return null;
    }

    public function getTitles() :array
    {
        $res = [];
        $titles = $this->dom->find('h6');

        foreach ($titles as $title)
        {
            $res[] = $title->text();
        }

        return $res;
    }
}
