<?php

namespace Nanuc\Nextcloud\ResponseParsers;

use Illuminate\Support\Arr;
use Nanuc\Nextcloud\Results\User;

class UserParser extends ResponseParser
{
    public function parse()
    {
        $userResult = new User();
        
        $xpath = $this->xpath;
        $data = [];

        $dataNodes = $this->xpath->query("/ocs/data/*");
        foreach($dataNodes as $node) {
            $nodeName = $node->nodeName;
            $nodeValue = $node->nodeValue;

            // If the node has children, loop over its children and add them to a subarray
            if($node->hasChildNodes() && $node->childNodes->length > 1) {
                $subarray = [];
                foreach($node->childNodes as $childNode) {
                    if ($childNode->nodeType === XML_ELEMENT_NODE) {
                        $subarray[$childNode->nodeName] = $childNode->nodeValue;
                    }
                }
                $data[$nodeName] = $subarray;
            }
            else {
                $data[$nodeName] = $nodeValue;
            }
        }

        $userResult->id = Arr::get($data, 'id');
        $userResult->email = Arr::get($data, 'email');
        $userResult->enabled = Arr::get($data, 'enabled') == 1;
        $userResult->groups = is_array(Arr::get($data, 'groups')) ? array_values(Arr::get($data, 'groups')) : [];

        return $this->finalize($userResult);
    }
}
