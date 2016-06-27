<?php

namespace App\Models\Core;

use Illuminate\Mail\Message;
use \Mail;

/**
 * Class Emails
 * @package App\Models\Core
 *
 * @property int $id
 * @property int $user_id
 * @property string $user_name
 * @property string $from_email
 * @property string $email
 * @property string $subject
 * @property string $text
 * @property int $type
 * @property $created_at
 * @property $updated_at
 * @property int $file1_id
 * @property int $file2_id
 * @property int $file3_id
 * @property int $file4_id
 * @property int $file5_id
 *
 */
class Emails extends AbsModel
{
    const
        TYPE_SIGNATURE = 1;

    /**
     * @return User
     */
    public function user()
    {
        return $this->belongsTo(User::class)->first();
    }

    /**
     * @return Files
     */
    public function file1()
    {
        return $this->belongsTo(Files::class)->first();
    }

    /**
     * @return Files
     */
    public function file2()
    {
        return $this->belongsTo(Files::class)->first();
    }

    /**
     * @return Files
     */
    public function file3()
    {
        return $this->belongsTo(Files::class)->first();
    }

    /**
     * @return Files
     */
    public function file4()
    {
        return $this->belongsTo(Files::class)->first();
    }

    /**
     * @return Files
     */
    public function file5()
    {
        return $this->belongsTo(Files::class)->first();
    }

    public function send($template, $params = [])
    {
        $mail = new Mail();
        if(!$this->from_email) {
            $this->from_email = 'info@bitulpolisa.co.il';
        }

        $this->email = config('testMode') ? env('TEST_EMAIL') : $this->email;

        if (env('API_MAIL', false) !== false) {
            Mail::send($template, $params, function (Message $message) {
                $message
                    ->from($this->from_email, $this->user_name ?: "ביטול פוליסה")
                    ->to($this->email, $this->user_name)
                    ->subject($this->subject);

                if ($this->file1_id) {
                    $message->attach($this->file1()->getFilePath());
                }

                if ($this->file2_id) {
                    $message->attach($this->file2()->getFilePath());
                }

                if ($this->file3_id) {
                    $message->attach($this->file3()->getFilePath());
                }

                if ($this->file4_id) {
                    $message->attach($this->file4()->getFilePath());
                }

                if ($this->file5_id) {
                    $message->attach($this->file5()->getFilePath());
                }
            });
        }
        $this->text = view($template, $params)->render();

        $this->save();
        return $mail;
    }

    public function addAttachment(Files $file)
    {
        for ($i = 1; $i <= 5; $i++) {
            $column = "file{$i}_id";
            if (!$this->$column) {
                $this->$column = $file->id;
                return true;
            }
        }

        return false;
    }
}