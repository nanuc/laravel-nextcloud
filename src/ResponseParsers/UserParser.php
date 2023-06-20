<?php

namespace Nanuc\Nextcloud\ResponseParsers;

use Nanuc\Nextcloud\Results\User;

class UserParser extends ResponseParser
{
    public function parse()
    {
        $userResult = new User();

        $elements = $this->xpath->query('/ocs/data/groups/element');
        $groups = [];
        foreach ($elements as $element) {
            $groups[] = $element->nodeValue;
        }

        $userResult->id = $this->xpath->evaluate('string(/ocs/data/id)');
        $userResult->email = $this->xpath->evaluate('string(/ocs/data/email)');
        $userResult->enabled = $this->xpath->evaluate('string(/ocs/data/enabled)') === '1';
        $userResult->groups = $groups;

        return $this->finalize($userResult);
    }
}
