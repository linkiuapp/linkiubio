<?php
namespace App\Console\Commands;
use Illuminate\Console\Command;
use App\Services\EmailService;

class SendEmailTest extends Command
{
    protected $signature = 'email:send-test {email}';
    protected $description = 'Enviar email de prueba (funciona en CLI)';

    public function handle()
    {
        $email = $this->argument('email');
        $result = EmailService::sendTestEmail($email);
        echo json_encode($result);
        return $result['success'] ? 0 : 1;
    }
}
