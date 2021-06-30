<?php

namespace Nanuc\Nextcloud\ResponseParsers;

use Nanuc\Nextcloud\Results\Result;

class ResponseParser
{
    protected $domDocument;
    protected $xpath;

    public function __construct($xml)
    {
        $this->domDocument = $this->createDomDocument($xml);
        $this->xpath = new \DOMXPath($this->domDocument);
    }

    public function parse()
    {
        return $this->parseStatusCodeResult(new Result());
    }

    protected function finalize($result)
    {
        return $this->parseStatusCodeResult($result);
    }

    protected function createDomDocument($xml)
    {
        $domDocument = new \DOMDocument();
        if ($domDocument->loadXML($xml) === false) {
            throw new \Exception('Could not parse xml input');
        }

        return $domDocument;
    }

    protected function parseStatusCodeResult(Result $result)
    {
        $xpath = new \DOMXPath($this->domDocument);
        $result->statusCode = $this->getXPathNodeValue($xpath, '/ocs/meta/statuscode');

        return $result;
    }

    private function getXPathNodeValue(\DOMXPath $xpath, $node)
    {
        $nodes = $xpath->query($node);
        if ($nodes->length > 0) {
            return $nodes->item(0)->nodeValue;
        }

        return '';
    }
}
