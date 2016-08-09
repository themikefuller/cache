<?php
namespace cache\src;

class Cache {

    private $dir;
    private $seconds;

    public function __construct($dir='cache/',$seconds=3) {
        rtrim($dir,'/');
        $dir = $dir . '/';
        $this->dir = $dir;
        $this->seconds = $seconds;
    }

    public function ReadCache($key=null) {
        if (empty($key) or is_null($key)) {
            $key = 'cached';
        }
        $cached = false;
        $hash = base64_encode($key);
        if (file_exists($this->dir . $hash)) {
            if (filemtime($this->dir . $hash) > (time() - $this->seconds)) {
                $cached = file_get_contents($this->dir . $hash);
            } else {
                $this->TrashCache($this->dir . $hash);
            }
        }
        return $cached;
    }

    public function WriteCache($key='cached',$content='') {
        if (!file_exists($this->dir)) {
            mkdir($this->dir);
        }
        $hash = base64_encode($key);
        file_put_contents($this->dir . $hash, $content);
    }

    private function TrashCache($file) {
       $response = false;
       if (file_exists($file)) {
           unlink($file);
           $response = true;
       }
       return $response;
    }

}
