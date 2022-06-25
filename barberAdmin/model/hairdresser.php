<?php
    class haidresser{
        private $maThoCatToc;
        private $tenThoCatToc;
        private $tuoi;
        private $kieuTocChinh;
        private $maCuaHang;

        public function __construct($maThoCatToc,$tenThoCatToc,$tuoi,$kieuTocChinh,$maCuaHang)
        {
            $this->maThoCatToc = $maThoCatToc;
            $this->tenThoCatToc = $tenThoCatToc;
            $this->tuoi = $tuoi;
            $this->kieuTocChinh = $kieuTocChinh;
            $this->maCuaHang = $maCuaHang;
        }
    }
?>