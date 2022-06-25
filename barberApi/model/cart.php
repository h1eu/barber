<?php
    class cart{
    private $maGioHang;
    private $maNguoiDung;
    private $tongTien;
    
    public function __construct($maGioHang,$maNguoiDung,$tongTien)
    {
        $this->maGioHang = $maGioHang;
        $this->maNguoiDung = $maNguoiDung;
        $this->tongTien = $tongTien;
    }
    }
?>