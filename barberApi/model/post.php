<?php
    class post{
    private $maBaiViet; 
    private $chuyenMuc;
    private $tieuDe; 
    private $noiDung;
    private $maAdmin;
    public function __construct($maBaiViet,$chuyenMuc,$tieuDe,$noiDung,$maAdmin)
        {
            $this->maBaiViet = $maBaiViet;
            $this->chuyenMuc = $chuyenMuc;
            $this->tieuDe = $tieuDe;
            $this->noiDung = $noiDung;
            $this->maAdmin = $maAdmin;
        }
    }
?>