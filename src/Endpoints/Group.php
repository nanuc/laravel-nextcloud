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
        return $this->get('groups/'.$groupId, UserListParser::class);
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

    public function update($groupId, $key, $value)
    {
        $this->put('groups/'.$groupId, compact('key', 'value'));
    }
}
