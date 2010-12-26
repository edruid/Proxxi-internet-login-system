<?php
class Avatar extends BasicObject {
	protected static function table_name() {
		return 'avatars';
	}

	public function __set($key, $value) {
		switch($key) {
			case 'avatar':
				if($value == null) {
					break;
				}
				if($value['error'] != UPLOAD_ERR_NO_FILE) {
					$value = $this->homogenize_avatar($value);
				} else {
					return;
				}
				break;
		}
		parent::__set($key, $value);
	}

	private static function homogenize_avatar(array $file_upload) {
		if(!Validate::file_upload($file_upload, $error)) {
			throw new Exception($error);
		}
		$avatar=file_get_contents($file_upload['tmp_name']);
		$avatar = imagecreatefromstring($avatar);
		if(!$avatar) {
			throw new Exception('Filen är ingen giltig bild');
		}
		$max_width=80;
		$max_height=80;
		$old_x=imagesx($avatar);
		$old_y=imagesy($avatar);
		$rescale = false;
		if($old_x>$max_width) {
			$rescale=true;
			$new_x=$max_width;
			$scalefactor=$new_x/$old_x;
			$new_y=$old_y*$scalefactor;
		}
		if($old_y>$max_height) {
			$rescale=true;
			$new_y=$max_height;
			$scalefactor=$new_y/$old_y;
			$new_x=$old_x*$scalefactor;
		}
		if($rescale) {
			$new_img=imagecreatetruecolor($new_x,$new_y);
			if(!imagecopyresampled($new_img,$avatar,0,0,0,0,$new_x,$new_y,$old_x,$old_y)) {
				throw new Exception('Misslyckades med att skala om bilden');
			}
			$avatar=$new_img;
		}
		imagejpeg($avatar,$file_upload['tmp_name']);
		return file_get_contents($file_upload['tmp_name']);
	}

}
?>
