<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MakeAdminCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle() {
        $data['name'] = $this->ask('Full Name');
        $data['email'] = $this->ask('E-mail');
        $data['password'] = bcrypt($this->secret('Password'));

        try {
            $user = User::create($data);
            $user->assignRole('superadmin');
            $this->info("Super Admin has been created");
        } catch (\Throwable $th) {
            $this->error("User could not be created");
        }

    }
}
