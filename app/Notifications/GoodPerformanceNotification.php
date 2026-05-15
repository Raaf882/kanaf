<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GoodPerformanceNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $courseName,
        public readonly int    $score,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'good_performance',
            'title'   => 'أداء رائع! 🌟',
            'message' => "أحسنت! حققت {$this->score}% في مادة {$this->courseName}. استمر في هذا المستوى المتميز.",
            'course'  => $this->courseName,
            'color'   => 'green',
            'icon'    => 'star',
        ];
    }
}
