<?php
	class ezServer{
		function getProto(){
			if(isset($_SERVER['HTTPS'])) {
				return "https";
			}else{
				return "http";
			}
		}
	}
