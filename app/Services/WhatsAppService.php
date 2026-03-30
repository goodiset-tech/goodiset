<?php
// app/Services/WhatsAppService.php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $whatsappUrl;
    protected $accessToken;
    protected $phoneId;

    public function __construct()
    {
        $this->whatsappUrl = "https://graph.facebook.com/v22.0";
        $this->accessToken = env('WHATSAPP_ACCESS_TOKEN');
        $this->phoneId = env('WHATSAPP_PHONE_ID');
    }

    public function sendMessage($to, $message)
    {
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$this->accessToken}",
            'Content-Type'  => 'application/json',
        ])->post("{$this->whatsappUrl}/{$this->phoneId}/messages", [
            'messaging_product' => 'whatsapp',
            'to'                => $to,
            'type'              => 'text',
            'text'              => ['body' => $message],
        ]);

        return $response->json();
    }
}
