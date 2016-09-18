<?php
	class ThumbAndCrop
	{
	
		private $handleimg;
		private $original = "";
		private $handlethumb;
		private $oldoriginal;
	
		/*
			Apre l'immagine da manipolare
		*/
		public function openImg($file)
		{
			$this->original = $file;
			
			if($this->extension($file) == 'jpg' || $this->extension($file) == 'jpeg')
			{
				$this->handleimg = imagecreatefromjpeg($file);
			}
			elseif($this->extension($file) == 'png')
			{
				$this->handleimg = imagecreatefrompng($file);
			}
			elseif($this->extension($file) == 'gif')
			{
				$this->handleimg = imagecreatefromgif($file);
			}
			elseif($this->extension($file) == 'bmp')
			{
				$this->handleimg = imagecreatefromwbmp($file);
			}
		}
		
		/*
			Ottiene la larghezza dell'immagine
		*/
		public function getWidth()
		{
			return imageSX($this->handleimg);
		}
		
		/*
			Ottiene la larghezza proporzionata all'immagine partendo da un'altezza
		*/
		public function getRightWidth($newheight)
		{
			$oldw = $this->getWidth();
			$oldh = $this->getHeight();
			
			$neww = ($oldw * $newheight) / $oldh;
			
			return $neww;
		}
		
		/*
			Ottiene l'altezza dell'immagine
		*/
		public function getHeight()
		{
			return imageSY($this->handleimg);
		}
		
		/*
			Ottiene l'altezza proporzionata all'immagine partendo da una larghezza
		*/
		public function getRightHeight($newwidth)
		{
			$oldw = $this->getWidth();
			$oldh = $this->getHeight();
			
			$newh = ($oldh * $newwidth) / $oldw;
			
			return $newh;
		}
		
		public function getFitCropSize($w, $h) {
			$W = $this->getWidth();
			$H = $this->getHeight();
			if ($W * $h < $H * $w) {
				$Hp = $W * $h / $w;
				$Wp = $W;
			} else {
				$Wp = $H * $w / $h;
				$Hp = $H;
			}
			return array('width' => $Wp, 'height' => $Hp);
		}
		
		/*
			Crea una miniatura dell'immagine
		*/
		public function creaThumb($newWidth, $newHeight)
		{
			$oldw = $this->getWidth();
			$oldh = $this->getHeight();
			
			$this->handlethumb = imagecreatetruecolor($newWidth, $newHeight);
			
			return imagecopyresampled($this->handlethumb, $this->handleimg, 0, 0, 0, 0, $newWidth, $newHeight, $oldw, $oldh);
		}
		
		/*
			Ritaglia un pezzo dell'immagine
		*/
		public function cropThumb($width, $height, $x, $y)
		{
			$oldw = $this->getWidth();
			$oldh = $this->getHeight();
			
			$this->handlethumb = imagecreatetruecolor($width, $height);
			
			return imagecopy($this->handlethumb, $this->handleimg, 0, 0, $x, $y, $width, $height);
		}
		
		/*
			Salva su file la Thumbnail
		*/
		public function saveThumb($path, $qualityJpg = 70)
		{
			ob_start();
			if($this->extension($this->original) == 'jpg' || $this->extension($this->original) == 'jpeg')
			{
				imagejpeg($this->handlethumb, NULL, $qualityJpg);
			}
			elseif($this->extension($this->original) == 'png')
			{
				imagepng($this->handlethumb, NULL);
			}
			elseif($this->extension($this->original) == 'gif')
			{
				imagegif($this->handlethumb, NULL);
			}
			elseif($this->extension($this->original) == 'bmp')
			{
				imagewbmp($this->handlethumb, NULL);
			}
			$contents = ob_get_contents();
			ob_end_clean();
			$fh = fopen($path, "a+" );
			fwrite( $fh, $contents );
			fclose($fh);
		}
		
		/*
			Stampa a video la Thumbnail
		*/
		public function printThumb()
		{
			if($this->extension($this->original) == 'jpg' || $this->extension($this->original) == 'jpeg')
			{
				header("Content-Type: image/jpeg");
				imagejpeg($this->handlethumb);
			}
			elseif($this->extension($this->original) == 'png')
			{
				header("Content-Type: image/png");
				imagepng($this->handlethumb);
			}
			elseif($this->extension($this->original) == 'gif')
			{
				header("Content-Type: image/gif");
				imagegif($this->handlethumb);
			}
			elseif($this->extension($this->original) == 'bmp')
			{
				header("Content-Type: image/bmp");
				imagewbmp($this->handlethumb);
			}
		}
		
		/*
			Distrugge le immagine per liberare le risorse
		*/
		public function closeImg()
		{
			imagedestroy($this->handleimg);
			imagedestroy($this->handlethumb);
		}
		
		/*
			Imposta la thumbnail come immagine sorgente,
			in questo modo potremo combinare la funzione crea con la funzione crop
		*/
		public function setThumbAsOriginal()
		{
			$this->oldoriginal = $this->handleimg;
			$this->handleimg = $this->handlethumb;
		}
		
		/*
			Resetta l'immagine originale
		*/
		public function resetOriginal()
		{
			$this->handleimg = $this->oldoriginal;
		}
		
		/*
			Estrae l'estensione da un file o un percorso
		*/
		private function extension($percorso)
		{
			if(eregi("[\|\\]", $percorso))
			{
				// da percorso
				$nome = $this->nomefile($percorso);
				
				$spezzo = explode(".", $nome);
				
				return strtolower(trim(array_pop($spezzo)));
			}
			else
			{
				//da file
				$spezzo = explode(".", $percorso);
				
				return strtolower(trim(array_pop($spezzo)));
			}
		}
		
		/*
			Estrae il nome del file da un percorso
		*/
		private function nomefile($path, $ext = true)
		{
			$diviso = spliti("[/|\\]", $path);
			
			if($ext)
			{
				return trim(array_pop($diviso));
			}
			else
			{
				$nome = explode(".", trim(array_pop($diviso)));
				
				array_pop($nome);
				
				return trim(implode(".", $nome));
			}
		}
		
		public function addWatermark($logo)
		{
			include_once('watermark.php');
			$watermark = new Watermark();
			$watermark_image = imagecreatefrompng($logo);
			
			
			$this->handlethumb = $watermark->create_watermark( $this->handleimg, $watermark_image, 20 );
			imagedestroy($watermark_image);
		}
	}
?>