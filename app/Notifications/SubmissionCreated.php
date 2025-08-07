<?php

namespace App\Notifications;

use App\Models\Submission;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class SubmissionCreated extends Notification
{
    protected $submission;

    public function __construct(Submission $submission)
    {
        $this->submission = $submission;
    }

    public function via(object $notifiable): array
    {
        return ['telegram'];
    }

    public function toTelegram($notifiable = null): TelegramMessage
    {
        $user = $this->submission->user;
        $form = $this->submission->form;
        $chatId = config('services.telegram-bot-api.chat_id');

        return TelegramMessage::create()
            ->to($chatId)
            ->content(
                "📥 *Submission Baru Masuk!*\n\n"
                    . "📝 Form: *{$form->title}*\n"
                    . "👤 User: *{$user->name}*\n"
                    . "📧 Email: {$user->email}\n"
                    . "📅 Tanggal: " . now()->format('d M Y H:i')
            );
    }
}
