<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Console\ServeCommand as BaseServeCommand;

/**
 * Custom ServeCommand that fixes "Unsupported operand types: string + int"
 * on PHP 8+ when the --port option (a string) is used in arithmetic operations.
 */
class ServeCommand extends BaseServeCommand
{
    /**
     * Execute the console command.
     *
     * Casts the port option to int before delegating to the parent,
     * preventing the PHP 8+ type error at ServeCommand.php line 205.
     *
     * @return int
     */
    public function handle()
    {
        // Cast the port option to int so arithmetic operations (port + 1)
        // in the parent's handle() / getAvailablePort() do not throw
        // "Unsupported operand types: string + int" on PHP 8+.
        if ($this->input->hasOption('port') && $this->input->getOption('port') !== null) {
            $this->input->setOption('port', (int) $this->input->getOption('port'));
        }

        return parent::handle();
    }
}
