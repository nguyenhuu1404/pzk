<?php
class SourceAdapter {
	public function getLinks() {
		
	}
}

class DetectorAdapter {
	public $sourceAdapter;
	public function detect() {
		$links = $this->sourceAdapter->getLinks();
		foreach($links as $link) {
			$this->parse($link);
		}
		$this->process();
		$this->result();
	}
}