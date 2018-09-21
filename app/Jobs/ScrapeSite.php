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
    private $site;
    private $page;

    /**
     * Create a new job instance.
     *
     * @param $site
     * @param $page
     */
    public function __construct($site, $page)
    {
        $this->site = $site;
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = new Client();

        $crawler = $client->request('GET', 'https://www.icas.com/find-a-ca');
        $form = $crawler->selectButton('Search');

        $crawler = $client->submit($form);

        return $crawler;
    }
}
