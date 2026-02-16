<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Carbon\Carbon;

class DeleteScheduledAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'accounts:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Supprime définitivement les comptes dont le délai de 30 jours est expiré';

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
        $deleted = User::whereNotNull('scheduled_deletion_at')->where('scheduled_deletion_at','<=',now())->forceDelete();
        $this->info("Comptes supprimés définitivement : $deleted");
    }
}
