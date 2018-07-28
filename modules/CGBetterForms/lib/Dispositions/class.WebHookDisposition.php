<?php
namespace CGBetterForms\Dispositions;
use \CGBetterForms\utils;

class WebHookDisposition extends Disposition
{
    private $_url;
    private $_extrapostvars;

    public function __get($key)
    {
        switch( $key ) {
        case 'url':
            return $this->_url;
        case 'extrapostvars':
            return trim($this->_extrapostvars);
        }
    }

    public function set_url( $url )
    {
        $this->_url = trim($url);
    }

    protected function from_text($map_text)
    {
        if( !$map_text ) return;
        $out = [];
        $lines = explode("\n",$map_text);
        foreach( $lines as $line ) {
            $line = trim($line);
            if( !$line ) continue;
            $parts = explode("=",$line,2);
            if( count($parts) != 2 ) continue;
            $key = trim($parts[0]);
            $val = $parts[1];
            $out[$key] = $val;
        }
        return $out;
    }

    public function get_extravars()
    {
        return $this->from_text($this->_extrapostvars);
    }

    public function set_extrapostvars( $data )
    {
        $this->_extrapostvars = trim($data);
    }

    public function dispose( \CGBetterForms\Form $form, \CGBetterForms\FormResponse& $response)
    {
        if( !$this->url ) return;
        $data = $this->get_extravars();
        if( !is_array($data) ) $data = [];
        $data = array_merge($data,$response->as_array());

        $request = new \cms_http_request();
        $request->setMethod('POST');
        $request->setParams($data);
        $request->execute($this->url);
        $status = $request->getStatus();
        $error = $request->getError();
        if( $status != 200 ) {
            audit($status,'CGBetterForms','WebHook Post to '.$this->url.' failed');
            @trigger_error("WebHook error $status posting to ".$this->url);
            debug_to_log('WebHook post to '.$this->url.' failed with status '.$status);
            debug_to_log($error);
        }
    }
} // end of class
