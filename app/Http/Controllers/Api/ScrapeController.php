<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\ScrapeSite;
use App\Jobs\ScrapeSite as Scraper;
use Goutte\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScrapeController extends Controller
{
    /**
     * @var array
     */
    private $data = [];

    private $page = 1;

    private $nextPage = '?results=ca&meta_G=Firm&meta_D_trunc=&meta_I_trunc=';

    /**
     * @param ScrapeSite $request
     * @return array
     */
    public function scrape(ScrapeSite $request)
    {

//      Scraper::dispatch($request->get('site'), $request->get('pages'));
        $crawler = $this->scrapeSite($request->get('pages'));

        return response()->json($this->data);
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
