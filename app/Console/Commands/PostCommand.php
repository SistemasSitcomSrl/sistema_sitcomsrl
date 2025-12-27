<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class PostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:imagestemp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Limpiar Imagenes Temporales de la carpeta public/storage/livewire-tmp y public/storage/temp-images';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Storage::deleteDirectory('livewire-tmp');
        Storage::deleteDirectory('temp-images');

        Storage::makeDirectory('livewire-tmp');
        Storage::makeDirectory('temp-images');
    }
}