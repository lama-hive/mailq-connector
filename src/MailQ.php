<?php

declare(strict_types=1);

namespace LamaHive\MailqConnector;

class MailQ
{
    public function __construct(
        readonly string $apiKey,
        readonly int $companyId,
        readonly string $apiUrl = 'https://q.quanti.cz/api/v2'
    ) {}

    /**
     * @throws MailQException
     */
    public function sendNotification(
        int $id,
        string $recipientEmail,
        array $data = [],
        array $cc = [],
        array $bcc = []
    ): MailQResponse
    {
        $companyId ??= $this->companyId;

        $fullApiUrl = "$this->apiUrl/companies/$companyId/notifications/$id/data";
        $body = json_encode([
            'recipientEmail' => $recipientEmail,
            'data' => $data,
            'cc' => $cc,
            'bcc' => $bcc
        ]);

        try {
            $response = $this->curlMailQ($fullApiUrl, $body);
            $mailQResponse = new MailQResponse();
            $mailQResponse->load($response);
            return $mailQResponse;
        } catch (MailQException $e) {
            throw new MailQException('Invalid API response', 0, $e);
        }
    }

    /**
     * @throws MailQException
     */
    private function curlMailQ(string $url, string $body): string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Api-Key: ' . $this->apiKey
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        $response = curl_exec($ch);
        curl_close($ch);

        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($response === false || $httpcode != 201) {
            throw new MailQException('Curl error: ' . curl_error($ch) . ' ' . $httpcode);
        }
        return $response;
    }
}
