<?php
namespace cache\src;

class Cache {

    private $dir;
    private $gcs;
    private $odds;

    public function __construct($dir='cache/',$gcs=10,$odds=2) {
        rtrim($dir,'/');
        $dir = $dir . '/';
        $this->dir = $dir;
        $this->gcs = intval($gcs);
        $this->odds = intval($odds);
    }

    public function ReadCache($key) {
        $hash = base64_encode($key . time());
        if (file_exists($this->dir . $hash)) {
            $cached = file_get_contents($this->dir . $hash);
        } else {
            $cached = false;
        }
        return $cached;
    }

    public function WriteCache($key='/',$content='',$seconds=2) {
        if (!file_exists($this->dir)) {
            mkdir($this->dir);
        }
        for ($x = 0; $x < $seconds; $x++) {
            $hash = base64_encode($key . (time() + $x));
            file_put_contents($this->dir . $hash, $content);
        }
        $this->TrashCache($this->gcs,$this->odds);
    }

    private function TrashCache($gcs,$odds) {
        $run = rand(1,$odds);
        if ($run == 1) {
            $files = scandir($this->dir);
            foreach ($files as $file) {
                if ($file != '.' and $file != '..' and filemtime($this->dir . $file) < (time() - $gcs)) {
                    unlink($this->dir . $file);
                }
            }
        }
        return true;
    }

}
