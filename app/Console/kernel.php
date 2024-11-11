<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('envio:produtos-apimercadolivre')->everyFiveMinutes();
        //A cada uma hora
        $schedule->command('app:enviar-produto-pendente')->everyMinute();

        Log::info("Comando agendado app:enviar-produto-pendente executado pelo schedule.");


    }
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
