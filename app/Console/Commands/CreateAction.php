<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leha:action';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Команда создает Action';

    protected function getFileExample($name, $nameModel): string
    {
        $example =
            "<?php
namespace App\Action\\{$nameModel};
use App\Models\\{$nameModel};
class {$name}Action{
        
    public function execute() : void
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
        $nameModel = $this->ask('Укажите имя Сущности или Модели');
        $name = $this->ask('Введите название Action');
        $path = "app/Action/{$nameModel}";
        if (!file_exists($path)) {
            mkdir($path, 0700, true);
        }
        $fp = fopen($path . "/{$name}Action.php", "w");
        fwrite($fp, $this->getFileExample($name, $nameModel));
        fclose($fp);
        $this->info('Действие создано в ' . $path);
    }
}
