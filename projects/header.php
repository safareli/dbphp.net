<?php

    //This is file is common between any project
    //And is loaded before project specific header

	include module ('user');
    @include module ('layout');
    include module ('text');
    include module ('menu');
    include module ('page');
    include module ('upload');
    include module ('cashier');
?>