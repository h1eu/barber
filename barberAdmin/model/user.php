<?php
    class user{
        private $maTaiKhoanUser;
        private $maNguoiDung;
        private $hoVaTen;
        private $soDienThoai;
        private $diaChi;
        private $cauHoiMatKhau;

        public function __construct($maTaiKhoanUser,$maNguoiDung,$hoVaTen,$soDienThoai,$diaChi,$cauHoiMatKhau)
        {
            $this->maTaiKhoanUser = $maTaiKhoanUser;
            $this->maNguoiDung = $maNguoiDung;
            $this->hoVaTen = $hoVaTen;
            $this->soDienThoai = $soDienThoai;
            $this->diaChi = $diaChi;
            $this->cauHoiMatKhau = $cauHoiMatKhau;

        }
    }
?>