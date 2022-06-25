<?php
    class productincart{
    private $maGioHang;
    private $maSanPham;
    private $soLuong;
    private $giaTien;  
    private $trangThaiMua;
    private $maDonHang;

    public function __construct($maGioHang,$maSanPham,$soLuong,$giaTien,$trangThaiMua,$maDonHang)
        {
            $this->maGioHang = $maGioHang;
            $this->maSanPham = $maSanPham;
            $this->soLuong = $soLuong;
            $this->giaTien = $giaTien;
            $this->trangThaiMua = $trangThaiMua;
            $this->maDonHang = $maDonHang;
        }
    }
?>