<?php

declare(strict_types=1);

namespace LamaHive\MailqConnector;

class MailQResponse
{
    public readonly ?string $id;
    public readonly ?string $recipientEmail;
    public readonly ?string $created;
    public readonly ?string $replyToEmail;
    public readonly array $cc;
    public readonly array $bcc;
    public readonly ?string $uuid;
    public readonly ?string $email;
    public readonly ?string $externalLink;
    public readonly ?string $externalAmpLink;
    public readonly ?string $openRateLink;
    public readonly ?string $emailHash;
    public readonly array $attachments;
    public readonly ?string $emailStatus;
    public readonly ?string $postfixMessage;
    public readonly ?string $openedTimestamp;
    public readonly ?string $undeliveredTimestamp;


    /**
     * @throws MailQException
     */
    public function load(string $json): void
    {
        $data = json_decode($json, true);
        if (!$data) {
            throw new MailQException('Invalid JSON');
        }

        $this->id = $data['id'];
        $this->recipientEmail = $data['recipientEmail'];
        $this->created = $data['created'];
        $this->replyToEmail = $data['replyToEmail'];
        $this->cc = $data['cc'] ?? [];
        $this->bcc = $data['bcc'] ?? [];
        $this->uuid = $data['data']['uuid'];
        $this->email = $data['data']['email'];
        $this->externalLink = $data['data']['externalLink'];
        $this->externalAmpLink = $data['data']['externalAmpLink'];
        $this->openRateLink = $data['data']['openRateLink'];
        $this->emailHash = $data['data']['emailHash'];
        $this->attachments = $data['attachments'] ?? [];
        $this->emailStatus = $data['emailStatus'];
        $this->postfixMessage = $data['postfixMessage'];
        $this->openedTimestamp = $data['openedTimestamp'];
        $this->undeliveredTimestamp = $data['undeliveredTimestamp'];
    }
}
