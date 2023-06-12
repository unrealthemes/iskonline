<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateQueries extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leha:query';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Создает Query';
    protected function getFileExample($name, $nameModel): string
    {
        $example =
"<?php\r".
"namespace App\Queries\\".$nameModel.";\r".
"use App\Models\\".$nameModel.";
class {$name}Query{
        
    public static function find() : void
    {
        //code
    }    
        
}";
        return $example;
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $nameModel = $this->ask('Укажите име модели');
        $name = $this->ask('Введите название Query');
        $path = "App\Queries\\".$nameModel;
        if (!file_exists($path)) {
            mkdir($path, 0700, true);
        }
        $fp = fopen($path . "/{$name}Query.php", "w");
        fwrite($fp, $this->getFileExample($name, $nameModel));
        fclose($fp);
        $this->info('Запрос создан в ' . $path);
    }
}
