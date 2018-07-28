<?php

/***************************************************************************
*
*   Author   : Eric Sizemore ( www.secondversion.com & www.phpsociety.com )
*   Package  : Search Keywords
*   Version  : 1.0.4
*   Copyright: (C) 2006 - 2007 Eric Sizemore
*   Site     : www.secondversion.com & www.phpsociety.com
*   Email    : esizemore05@gmail.com
*
*   This program is free software; you can redistribute it and/or modify
*   it under the terms of the GNU General Public License as published by
*   the Free Software Foundation; either version 2 of the License, or
*   (at your option) any later version.
*
*   This program is distributed in the hope that it will be useful,
*   but WITHOUT ANY WARRANTY; without even the implied warranty of
*   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
*   GNU General Public License for more details.
*
***************************************************************************/

class SearchSniffer {
    /**
    * Holds the referer string
    *
    * @var string
    */
    var $referer;

    /**
    * Holds the name of the search engine
    *
    * @var string
    */
    var $search_engine;

    /**
    * Holds the keywords
    *
    * @var mixed
    */
    var $keys;

    /**
    * Holds the query & keyword seperator
    *
    * @var string
    */
    var $sep;

    /**
    * Constructor. Sets the referer and seperator.
    *
    * @param  void
    * @return void
    */
    function __construct()
    {
        $this->referer = '';
        $this->sep = '';

        if ($_SERVER['HTTP_REFERER'] OR $_ENV['HTTP_REFERER'])
        {
            $this->referer = urldecode(($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : $_ENV['HTTP_REFERER']));
            $this->sep = (preg_match('/(\?q=|\?qt=|\?p=)/i', $this->referer)) ? '\?' : '\&';
        }
    }

    /**
    * Gets the search engine and keywords.
    *
    * @param  void
    * @return array
    */
    function get_keys()
    {
        if (!empty($this->referer))
        {
            if (preg_match('/www\.google/i', $this->referer))
            {
                // Google
                preg_match("#{$this->sep}q=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'Google';
            }
            else if (preg_match('/(yahoo\.com|search\.yahoo)/i', $this->referer))
            {
                // Yahoo
                preg_match("#{$this->sep}p=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'Yahoo';
            }
            else if (preg_match('/search\.msn/i', $this->referer))
            {
                // MSN
                preg_match("#{$this->sep}q=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'MSN';
            }
            else if (preg_match('/www\.alltheweb/i', $this->referer))
            {
                // AllTheWeb
                preg_match("#{$this->sep}q=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'AllTheWeb';
            }
            else if (preg_match('/(looksmart\.com|search\.looksmart)/i', $this->referer))
            {
                // Looksmart
                preg_match("#{$this->sep}qt=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'Looksmart';
            }
            else if (preg_match('/(askjeeves\.com|ask\.com)/i', $this->referer))
            {
                // AskJeeves
                preg_match("#{$this->sep}q=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'AskJeeves';
            }
            else
            {
                $this->keys = false;
                $this->search_engine =false;
            }
            return array(
                $this->referer,
                (!is_array($this->keys) ? $this->keys : $this->keys[1]),
                $this->search_engine
            );
        }
        return array();
    }
}



?>
