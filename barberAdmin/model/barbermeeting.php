<?php
    class barbermeeting{
        private $maLichCatToc;
        private $maThoCatToc; 
        private $maNguoiDung; 
        private $tenThoCatToc; 
        private $ngay; 
        private $gio; 
        private $diaChiCuaHang;
        private $tinhTrangLichHen; 

    public function __construct($maLichCatToc,$maThoCatToc,$maNguoiDung,$tenThoCatToc,$ngay,$gio,$diaChiCuaHang,$tinhTrangLichHen)
        {
            $this->maLichCatToc = $maLichCatToc;
            $this->maThoCatToc = $maThoCatToc;
            $this->maNguoiDung = $maNguoiDung;
            $this->tenThoCatToc = $tenThoCatToc;
            $this->ngay = $ngay;
            $this->gio = $gio;
            $this->diaChiCuaHang = $diaChiCuaHang;
            $this->tinhTrangLichHen = $tinhTrangLichHen;
        }
    }
?>