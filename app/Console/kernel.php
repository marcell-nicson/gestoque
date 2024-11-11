<?php

namespace App\Console;

use App\Console\Commands\EnviarProdutoPendente;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */

    protected $commands = [
        EnviarProdutoPendente::class
    ];
    protected function schedule(Schedule $schedule)
    {  
        
        $schedule->command('app:enviar-produto-pendente')->everyMinute();

        Log::info("Comando agendado app:enviar-produto-pendente executado pelo schedule.");
    }
    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
