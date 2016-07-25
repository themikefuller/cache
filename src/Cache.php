<?php
namespace cache\src;

class Cache {

    private $dir;
    private $seconds;

    public function __construct($dir='cache/',$seconds=2) {
        rtrim($dir,'/');
        $dir = $dir . '/';
        $this->dir = $dir;
        $this->seconds = $seconds;
    }

    public function ReadCache($key) {
        $cached = false;
        $hash = base64_encode($key);
        if (file_exists($this->dir . $hash)) {
            if (filemtime($this->dir . $hash) > (time() - $this->seconds)) {
                $cached = file_get_contents($this->dir . $hash);
            } else {
                $this->TrashCache($hash);
            }
        }
        return $cached;
    }

    public function WriteCache($key='/',$content='') {
        if (!file_exists($this->dir)) {
            mkdir($this->dir);
        }
        $hash = base64_encode($key);
        file_put_contents($this->dir . $hash, $content);
    }

    private function TrashCache($hash) {
        if (file_exists($this->dir . $hash)) {
            unlink($this->dir . $hash);
        }
    }

}
