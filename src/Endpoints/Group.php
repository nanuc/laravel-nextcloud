<?php

namespace Nanuc\Nextcloud\Endpoints;

use Illuminate\Support\Str;
use Nanuc\Nextcloud\ResponseParsers\GroupListParser;
use Nanuc\Nextcloud\ResponseParsers\UserListParser;

class Group extends Endpoint
{
    public function exists($groupId)
    {
        return $this->group($groupId)->statusCode == 100;
    }

    public function group($groupId)
    {
        return $this->get('groups/'.$groupId);
    }

    public function groups()
    {
        return $this->get('groups', GroupListParser::class);
    }

    public function create($groupId)
    {
        $this->post('groups', ['groupid' => $groupId]);
    }

    public function deleteGroup($groupId)
    {
        $this->delete('groups/'.$groupId);
    }
}
