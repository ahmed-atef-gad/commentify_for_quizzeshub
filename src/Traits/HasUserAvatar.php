<?php

namespace Usamamuneerchaudhary\Commentify\Traits;

trait HasUserAvatar
{

    /**
     * @return string
     */
    public function avatar()
    {
        // return 'https://gravatar.com/avatar/'.md5($this->email).'?s=80&d=mp';
        if($this->image_path == null) {
            return null;
        }
        return $this->image_path;
    }
}