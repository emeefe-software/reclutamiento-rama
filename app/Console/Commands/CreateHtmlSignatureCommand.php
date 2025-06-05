<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Archivos;
use Illuminate\Support\Facades\Storage;

class CreateHtmlSignatureCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:htmlsignature';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crea una firma de correo electrónico de rama';

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
     * @return mixed
     */
    public function handle()
    {
        $nombre = $this->ask('Nombre de la persona');
        $departamento = $this->ask('Nombre del departamento');
        $email = $this->ask('Correo elctronico');
        $tel_oficina = $this->ask('Teléfono de oficina (dejar vacio para poner +52 (222) 2402445)');
        $tel_oficina = $tel_oficina ?: '+52 (222) 2402445';
        $movil = $this->ask('Movil');

        $html = view('templates.signature', compact('nombre', 'departamento', 'email', 'tel_oficina', 'movil'))->render();
        $filename = strtolower(str_replace(' ', '', $nombre));

        Storage::put("signatures/$filename.html", $html);
        
        $this->info("La firma se guardo en storage/app/signatures/$filename.html");
    }
}
