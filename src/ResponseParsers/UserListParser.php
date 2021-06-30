<?php

namespace Nanuc\Nextcloud\ResponseParsers;

use Nanuc\Nextcloud\Results\UserList;

class UserListParser extends ResponseParser
{
    public function parse()
    {
        $findUsersResult = new UserList();
        $nodes = $this->xpath->query('/ocs/data/users/element');
        if ($nodes->length > 0) {
            foreach ($nodes as $node) {
                $findUsersResult->users[] = $node->nodeValue;
            }
        }

        return $this->finalize($findUsersResult);
    }
}
