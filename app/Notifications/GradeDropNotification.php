<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class GradeDropNotification extends Notification
{
    use Queueable;

    public function __construct(
        public readonly string $courseName,
        public readonly int    $midScore,
        public readonly int    $finalScore,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'    => 'grade_drop',
            'title'   => 'انخفاض في الدرجات 📉',
            'message' => "درجتك في اختبار الفترة الثاني لمادة {$this->courseName} ({$this->finalScore}) أقل من اختبار الفترة الأولى ({$this->midScore}). راجع المادة مع كَـنَـف.",
            'course'  => $this->courseName,
            'color'   => 'red',
            'icon'    => 'drop',
        ];
    }
}
