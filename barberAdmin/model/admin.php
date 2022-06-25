<?php
    class admin{
        private $maTaiKhoanAdmin;
        private $maAdmin;

        public function __construct($maTaiKhoanAdmin,$maAdmin)
        {
            $this->maTaiKhoanAdmin = $maTaiKhoanAdmin;
            $this->maAdmin = $maAdmin;
        }
    }
?>