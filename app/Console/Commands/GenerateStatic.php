<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Url\Url;
use File;
use Artisan;

class GenerateStatic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:static';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $urls = array();

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $server = $this->ask('Make sure you previously run: php artisan serve and add the address here', '127.0.0.1:8000');

        $this->crawlPage($server);
    }

    public function crawlPage($url)
    {
        static $seen = array();

        $seen[$url] = true;

        $dom = new \DOMDocument();
        @$dom->loadHTMLFile($url);

        $anchors = $dom->getElementsByTagName('a');

        foreach ($anchors as $element) {
            $href = $element->getAttribute('href');
            
            $hrefUrl = Url::fromString($href);

            array_push($this->urls, $href);
            $this->info($href);

            $path2 = "";
            if($hrefUrl->getPath() != '/')
            {
                $path2 = $hrefUrl->getPath();
            }

            
            if(!File::isDirectory("static" . $path2))
            {
                $this->info("static" . $path2);
                File::makeDirectory("static" . $path2, $mode = 0777, true);
            }

            $d = new \DOMDocument();
            @$d->loadHTMLFile($href);


            //Update CSS links
            foreach ($d->getElementsByTagName('link') as $item) {
                $link = $item->getAttribute('href');

                $path3 = "";

                $linkUrl = Url::fromString($link);
                if($linkUrl->getPath() != '/')
                {
                    $path3 = $linkUrl->getPath();

                    $path3 = explode('/', $path3, -1);
                    $path3 = implode('/', $path3);

                }     

                if(!File::isDirectory("static" . $path3))
                {
                    $this->info("static" . $path3);
                    File::makeDirectory("static" . $path3, $mode = 0777, true);
                }

                $fileName = explode('/', $linkUrl->getPath());
                $fileName = $fileName[count($fileName) - 1];
                
                $item->setAttribute('href', substr($path3, 1) . "/" . $fileName);
                
                $d->saveHTML();

                $style = file_get_contents($link);

                File::put("static" . $path3 . "/" . $fileName, $style);
                
            }

            $fileName = explode('/', $hrefUrl->getPath());
            $fileName = $fileName[count($fileName) - 1];

            /*
            $element->setAttribute('href', substr($path2, 1) . "/" . $fileName);
            $dom->saveHTML();
            */
            File::put("static" . $path2 . "/index.html", $d->saveHTML());

            if(!isset($seen[$href]))
                $this->crawlPage($href);
        }
    }
}
