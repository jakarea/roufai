<?php

namespace App\Console\Commands;

use App\Services\SMSService;
use Illuminate\Console\Command;

class TestSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test {phone}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test SMS sending functionality';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $phone = $this->argument('phone');

        $this->info('Testing SMS Service...');
        $this->info('Phone: ' . $phone);
        $this->newLine();

        // Test basic SMS
        $this->info('Sending test SMS...');

        try {
            $smsService = new SMSService();
            $result = $smsService->send($phone, 'This is a test SMS from Rouf AI Academy. If you receive this, SMS is working correctly!');

            if ($result['success']) {
                $this->info('✅ SMS sent successfully!');
                $this->info('Response: ' . $result['response']);
                return Command::SUCCESS;
            } else {
                $this->error('❌ SMS sending failed!');
                $this->error('Error: ' . $result['message']);
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            $this->error('❌ Exception occurred!');
            $this->error('Error: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
