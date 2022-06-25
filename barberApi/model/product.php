<?php
    class product{
    private $maSanPham;
    private $tenSanPham; 
    private $giaTien;
    private $loai ;
    private $moTa ;

    public function __construct($maSanPham,$tenSanPham,$giaTien,$loai,$moTa)
        {
            $this->maSanPham = $maSanPham;
            $this->tenSanPham = $tenSanPham;
            $this->giaTien = $giaTien;
            $this->loai = $loai;
            $this->moTa = $moTa;
        }
    }
?>