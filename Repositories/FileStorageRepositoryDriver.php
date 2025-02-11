<?php

    require_once "./Interfaces/IFileStorageRepositoryDriver.php";


    class  FileStorageRepositoryDriver implements IFileStorageRepositoryDriver
    {

        private  $cacheDir = __DIR__.'/../_cached';

        public  function Get(string $key, callable $callback) {
            $filePath = $this->getFilePath($key);

            if (file_exists($filePath)) {
                return unserialize(file_get_contents($filePath));
            }

            $data = $callback();
            $this->Save($key, $data);

            return $data;
        }

        public function Save(string $key, $data): void {
            if (!is_dir($this->cacheDir)) {
                mkdir($this->cacheDir, 0777, true);
            }

            $filePath = $this->getFilePath($key);
            file_put_contents($filePath, serialize($data));
        }

        public function getFilePath(string $key): string {
            return $this->cacheDir.'/'.($key).'.cache';
        }


    }
