<?php

class PresensiController
{
    private $presensiModel;

    public function __construct($presensiModel)
    {
        $this->presensiModel = $presensiModel;
    }

    public function index()
    {
        $presences = $this->presensiModel->getAllPresences();

        require __DIR__ . '/../views/presensi/index.php';
    }
}
