<?php

namespace Nanuc\Nextcloud\Endpoints;

use Illuminate\Support\Str;
use Nanuc\Nextcloud\ResponseParsers\GroupListParser;
use Nanuc\Nextcloud\ResponseParsers\UserListParser;
use Nanuc\Nextcloud\ResponseParsers\UserParser;

class User extends Endpoint
{
    public function exists($userId)
    {
        return $this->user($userId)->statusCode == 100;
    }

    public function user($userId)
    {
        return $this->get('users/'.$userId, UserParser::class);
    }

    public function users()
    {
        return $this->get('users', UserListParser::class);
    }

    public function create($userId, $password = null, $options = [])
    {
        $this->post('users', array_merge(['userid' => $userId, 'password' => $password], $options));
    }

    public function enable($userId)
    {
        $this->put('users/'.$userId.'/enable');
    }

    public function disable($userId)
    {
        $this->put('users/'.$userId.'/disable');
    }

    public function groups($userId)
    {
        return $this->get('users/'.$userId.'/groups', GroupListParser::class);
    }

    public function addToGroup($userId, $groupId)
    {
        return $this->post('users/'.$userId.'/groups', ['groupid' => $groupId]);
    }

    public function removeFromGroup($userId, $groupId)
    {
        return $this->delete('users/'.$userId.'/groups', ['groupid' => $groupId]);
    }
}
