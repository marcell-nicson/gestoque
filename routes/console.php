<?php

use App\Console\Commands\EnviarProdutoPendente;
use App\Console\Commands\teste;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote');

Schedule::command('enviar:enviar-produto-pendente')->everyMinute();