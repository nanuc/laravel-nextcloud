<?php

namespace Nanuc\Nextcloud\ResponseParsers;

use Nanuc\Nextcloud\Results\GroupsList;

class GroupListParser extends ResponseParser
{
    public function parse()
    {
        $findUsersResult = new GroupsList();
        $nodes = $this->xpath->query('/ocs/data/groups/element');
        if ($nodes->length > 0) {
            foreach ($nodes as $node) {
                $findUsersResult->groups[] = $node->nodeValue;
            }
        }

        return $this->finalize($findUsersResult);
    }
}
