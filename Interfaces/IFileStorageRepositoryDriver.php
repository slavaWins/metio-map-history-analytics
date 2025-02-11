<?php


    interface IFileStorageRepositoryDriver
    {
        public function Get(string $key, callable $callback);

        public function Save(string $key, $data): void;

        public function getFilePath(string $key): string;
    }
