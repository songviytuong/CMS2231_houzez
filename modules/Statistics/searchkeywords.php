<?php

/**
* @author        Eric Sizemore <admin@secondversion.com>
* @package        Search Keywords
* @version        1.0.5
* @copyright    2006 - 2011 Eric Sizemore
* @license        GNU GPL
*
*    This program is free software; you can redistribute it and/or modify
*    it under the terms of the GNU General Public License as published by
*    the Free Software Foundation; either version 2 of the License, or
*    (at your option) any later version.
*
*    This program is distributed in the hope that it will be useful,
*    but WITHOUT ANY WARRANTY; without even the implied warranty of
*    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
*    GNU General Public License for more details.
*/
class search_keywords
{
    /**
    * Class instance
    */
    private static $instance;

    /**
    * Holds the referer string
    *
    * @var string
    */
    private $referer = '';

    /**
    * Holds the name of the search engine
    *
    * @var string
    */
    private $search_engine = '';

    /**
    * Holds the keywords
    *
    * @var mixed
    */
    private $keys = array();

    /**
    * Holds the query & keyword seperator
    *
    * @var string
    */
    private $separator = '';

    /**
    * Constructor. Sets the referer and seperator.
    *
    * @param  void
    * @return void
    */
    private function __construct()
    {
        if ($this->getenv('HTTP_REFERER'))
        {
            $this->referer   = urldecode($this->getenv('HTTP_REFERER'));
            $this->separator = (preg_match('#\?(q=|qt=|p=)#i', $this->referer)) ? '\?' : '\&';
        }
    }

    /**
    * Creates an instance of the class.
    *
    * @param  void
    * @return object
    */
    public static function getInstance()
    {
        if (!self::$instance)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
    * Returns an environment variable.
    *
    * @param  string  $varname  Variable name, eg: PHP_SELF
    * @return string            Variable's value.
    */
    public function getenv($varname)
    {
        if (isset($_SERVER[$varname]))
        {
            return $_SERVER[$varname];
        }
        else if (isset($_ENV[$varname]))
        {
            return $_ENV[$varname];
        }
        return '';
    }

    /**
    * Gets the search engine and keywords.
    *
    * @param  void
    * @return array
    */
    public function get_keys()
    {
        if (!empty($this->referer))
        {
            if (preg_match('#www\.google#i', $this->referer))
            {
                // Google
                preg_match("#{$this->separator}q=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'Google';
            }
            else if (preg_match('#(yahoo\.com|search\.yahoo)#i', $this->referer))
            {
                // Yahoo
                preg_match("#{$this->separator}p=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'Yahoo';

                if (preg_match('#fr=alltheweb#i', $this->referer))
                {
                    $this->search_engine .= '/AllTheWeb';
                }
            }
            else if (preg_match('#www\.bing#i', $this->referer))
            {
                // Bing
                preg_match("#{$this->separator}q=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'Bing';
            }
            else if (preg_match('#(askjeeves\.com|ask\.com)#i', $this->referer))
            {
                // AskJeeves
                preg_match("#{$this->separator}q=(.*?)\&#si", $this->referer, $this->keys);
                $this->search_engine = 'Ask/AskJeeves';
            }
            else
            {
                $this->keys = 'Not available';
                $this->search_engine = 'Unknown';
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