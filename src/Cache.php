<?php
namespace cache\src;

class Cache {

    private $dir;
    private $seconds;
    private $odds;

    public function __construct($dir='cache/',$seconds=2,$odds=4) {
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
                $this->TrashCache();
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

    private function TrashCache() {
        if (rand(1,$this->odds) != 1) {
            $response = false;
        } else {
            $files = scandir($this->dir);
            foreach ($files as $file) {
                if ($file != '.' and $file != '..' and filemtime($this->dir . $file) < (time() - $this->seconds)) {
                    unlink($this->dir . $file);
                }
            }
            $response = true;
        }
       return $response;
    }

}
