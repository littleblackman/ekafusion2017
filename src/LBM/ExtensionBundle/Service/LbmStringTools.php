<?php

namespace LBM\ExtensionBundle\Service;


/**
 * Class StringTools
 * @package LBM\ExtensionBundle\StringTools
 */
trait LbmStringTools
{

    public function convertCamelCaseToArray($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $result = $matches[0];
        foreach ($result as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return $result;
    }

}
