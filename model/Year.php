<?php
class PzkYearModel {
	
	public function menh($yob) {
		return _db()->useCB()->select('*')->from('review_menh')->where(array('yob', $yob))->result_one();
	}
	
	public function sodutrachmenh($yob, $gender) {
		$total = 4;
		for($i = 0; $i < 4; $i++) {
			$n = $yob[$i];
			$total += $n;
		}
		$sodu = $total % 9;
		$gender = $request->get('gender');
		// nam
		if($gender == '1') {
			if($sodu < 6) {
				$sodu = 6 - $sodu;
			} else {
				$sodu = 15 - $sodu;
			}
			if($sodu == 5) {
				$sodu = 2;
			}
		} else {
			if ($sodu == 5) {
				$sodu = 8;
			}
		}
		if($sodu == 0) {
			$sodu = 9;
		}
		return $sodu;
	}
	
	public function kimlau($yob, $yon) {
		$total = 4;
		for($i = 0; $i < 4; $i++) {
			$n = $yob[$i];
			$total += $n;
		}
		$tuoiam = $yon + 1 - $yob;
		$sodu9 = $tuoiam % 9;
		$sodu6 = $tuoiam % 6;
		if(in_array($sodu9, array(1, 3, 6, 8))) {
			return true;
		}
		return false;
	}
	
	public function hoangoc($yob, $yon) {
		$total = 4;
		for($i = 0; $i < 4; $i++) {
			$n = $yob[$i];
			$total += $n;
		}
		$tuoiam = $yon + 1 - $yob;
		$sodu9 = $tuoiam % 9;
		$sodu6 = $tuoiam % 6;
		if(in_array($sodu6, array(3, 5, 0))) {
			return true;
		}
		return false;
	}
	
	public function thiencan() {
		return array('Giáp', 'Ất', 'Bính', 'Đinh', 'Mậu', 'Kỷ', 'Canh', 'Tân', 'Nhâm', 'Quý');
	}
	
	public function diachi() {
		return array('Tí', 'Sửu', 'Dần', 'Mão', 'Thìn', 'Tị', 'Ngọ', 'Mùi', 'Thân', 'Dậu', 'Tuất', 'Hợi');
	}
	
	public function allMang() {
		return array('Kim', 'Mộc', 'Thổ', 'Thủy', 'Hỏa');
	}
	
	public function getThienCan($yob) {
		$sodu = ($yob - 1924) % 10;
		$thiencan = $this->thiencan();
		return $thiencan[$sodu];
	}
	
	public function getDiaChi($yob) {
		$sodu = ($yob - 1924) % 12;
		$diachi = $this->diachi();
		return $diachi[$sodu];
	}
	
	public function allMenh() {
		
	}
	
	public function ketQuaKetHon() {
		return array('Phá', 'Hạp', 'Xung');
	}
	
	public function ketQuaDiaChi() {
		return array('Xung', 'Hợp', 'Hại');
	}
	
	public function ketQuaThangCuoi() {
		return array('Đại Lợi', 'Phòng Mai', 'Phòng Ông Cô', 'Phòng Nữ Phụ Mẫu', 'Phòng Phu Chủ', 'Phòng Nữ Thân');
	}
	
	public function xemthiencan($canchong, $canvo) {
		return _db()->useCB()->select('*')->from('review_thiencanhophon')->where(array('and', array('cantuoichong', $canchong), array('cantuoivo', $canvo) ))->result_one();
	}
	
	public function xemdiachi($diachichong, $diachivo) {
		return _db()->useCB()->select('*')->from('review_diachihophon')
			->where(array('or',
				array('and', array('diachichong', $diachichong), array('diachivo', $diachivo)),
				array('and', array('diachivo', $diachichong), array('diachichong', $diachivo))
			))->result_one();
	}
	
	public function xemthangcuoi($femaleAge, $month) {
		return _db()->useCB()->select('*')->from('review_thangcuoi')->where(array('and', array('tuoivo', $femaleAge), array('thang', $month) ))->result_one();
	}
}