<?php

namespace App\Observers;

use App\Models\Upload;
use App\Models\User;

class VideoObserver
{
    /**
     * Handle the Video "created" event.
     */
    public function created(Upload $upload)
    {
        $this->updateUserVideoCount($upload->user_id);
    }

    /**
     * Handle the Video "updated" event.
     */
    public function updated(Upload $upload)
    {
        $this->updateUserVideoCount($upload->user_id);
    }

    /**
     * Handle the Video "deleted" event.
     */
    public function deleted(Upload $upload)
    {
        $this->updateUserVideoCount($upload->user_id);
    }

    /**
     * Update the video count for the user.
     */
    protected function updateUserVideoCount($userId)
    {
        $count = Upload::where('user_id', $userId)->count();
        $user = User::find($userId);
        if ($user) {
            $user->videos_count = $count;
            $user->save();
        }
    }
}
