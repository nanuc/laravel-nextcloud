<?php

namespace Nanuc\Nextcloud;

use Nanuc\Nextcloud\Endpoints\Group;
use Nanuc\Nextcloud\Endpoints\User;

class NextcloudFactory
{
    public function user()
    {
        return new User();
    }

    public function group()
    {
        return new Group();
    }
}
