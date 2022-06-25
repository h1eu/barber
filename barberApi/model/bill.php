<?php
    class bill{
    private $maDonHang;
    private $tongTien;
    private $diaChiGiaoHang;
    private $tinhTrangDonHang;
    private $phuongThucThanhToan;
    private $soDienThoaiNhanHang;
    private $maNguoiDung;

    public function __construct($maDonHang,$tongTien,$diaChiGiaoHang,$tinhTrangDonHang,$phuongThucThanhToan,$soDienThoaiNhanHang,$maNguoiDung)
        {
            $this->maDonHang = $maDonHang;
            $this->tongTien = $tongTien;
            $this->diaChiGiaoHang = $diaChiGiaoHang;
            $this->tinhTrangDonHang = $tinhTrangDonHang;
            $this->phuongThucThanhToan = $phuongThucThanhToan;
            $this->soDienThoaiNhanHang = $soDienThoaiNhanHang;
            $this->maNguoiDung = $maNguoiDung;
        }
    }
?>