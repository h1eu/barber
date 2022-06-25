<?php
    class account{
        private $maTaiKhoan;
        private $tenTaiKhoan;
        private $matKhau;
        private $vaiTro;

        public function __construct($maTaiKhoan,$tenTaiKhoan,$matKhau,$vaiTro)
        {
            $this->maTaiKhoan = $maTaiKhoan;
            $this->tenTaiKhoan = $tenTaiKhoan;
            $this->matKhau = $matKhau;
            $this->vaiTro = $vaiTro;
        }
    }
?>