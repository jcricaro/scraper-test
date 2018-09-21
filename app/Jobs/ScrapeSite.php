<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Goutte\Client;

class ScrapeSite implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $pages;

    /**
     * @var array
     */
    private $data = [];

    private $page = 1;

    private $nextPage = '?results=ca&meta_G=Firm&meta_D_trunc=&meta_I_trunc=';


    /**
     * ScrapeSite constructor.
     * @param $pages
     */
    public function __construct($pages)
    {
        $this->pages = $pages;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $crawler = $this->scrapeSite($this->pages);

        return $this->data;
    }

    /**
     * @param $pages
     */
    private function scrapeSite($pages)
    {
        $client = new Client();

        $rank = $this->page * 10 - 9;

        $crawler = $client->request('GET', 'https://www.icas.com/find-a-ca' . $this->nextPage . '&start_rank=' . $rank);

        $crawler->filter('b.page-item.active')->each(function($node) {
            $this->page = $node->text();
            $this->nextPage = $node->nextAll()->attr('href');
        });

        $crawler->filter('article > h3.title > a')->each(function($node, $index) use($client, $rank) {
            $crawler = $client->request('GET', $node->attr('href'));
            $name = trim($node->text());

            $crawler->filter('dl > dt')->each(function($node) use ($index, $rank, $name) {
                $this->data[$index + $rank]['name'] = $name;
                $this->data[$index + $rank][trim(strtolower($node->text()), ": ")] = $node->nextAll()->text();
            });
        });

        $this->page++;

        if($this->page <= $pages) {
            $this->scrapeSite($pages);
        }
    }
}
