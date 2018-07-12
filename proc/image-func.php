<?php

function ImageCreateFromBMP($filename)
{
    if (! $f1 = fopen($filename,"rb")) return FALSE;

    $FILE = unpack("vfile_type/Vfile_size/Vreserved/Vbitmap_offset", fread($f1,14));
    if ($FILE['file_type'] != 19778) return FALSE;

    $BMP = unpack('Vheader_size/Vwidth/Vheight/vplanes/vbits_per_pixel'.
        '/Vcompression/Vsize_bitmap/Vhoriz_resolution'.
        '/Vvert_resolution/Vcolors_used/Vcolors_important', fread($f1,40));
    $BMP['colors'] = pow(2,$BMP['bits_per_pixel']);
    if ($BMP['size_bitmap'] == 0) $BMP['size_bitmap'] = $FILE['file_size'] - $FILE['bitmap_offset'];
    $BMP['bytes_per_pixel'] = $BMP['bits_per_pixel']/8;
    $BMP['bytes_per_pixel2'] = ceil($BMP['bytes_per_pixel']);
    $BMP['decal'] = ($BMP['width']*$BMP['bytes_per_pixel']/4);
    $BMP['decal'] -= floor($BMP['width']*$BMP['bytes_per_pixel']/4);
    $BMP['decal'] = 4-(4*$BMP['decal']);
    if ($BMP['decal'] == 4) $BMP['decal'] = 0;

    $PALETTE = array();
    if ($BMP['colors'] < 16777216)
    {
        $PALETTE = unpack('V'.$BMP['colors'], fread($f1,$BMP['colors']*4));
    }

    $IMG = fread($f1,$BMP['size_bitmap']);
    $VIDE = chr(0);

    $res = imagecreatetruecolor($BMP['width'],$BMP['height']);
    $P = 0;
    $Y = $BMP['height']-1;
    while ($Y >= 0)
    {
        $X=0;
        while ($X < $BMP['width'])
        {
            if ($BMP['bits_per_pixel'] == 24)
                $COLOR = unpack("V",substr($IMG,$P,3).$VIDE);
            elseif ($BMP['bits_per_pixel'] == 16)
            {
                $COLOR = unpack("n",substr($IMG,$P,2));
                $COLOR[1] = $PALETTE[$COLOR[1]+1];
            }
            elseif ($BMP['bits_per_pixel'] == 8)
            {
                $COLOR = unpack("n",$VIDE.substr($IMG,$P,1));
                $COLOR[1] = $PALETTE[$COLOR[1]+1];
            }
            elseif ($BMP['bits_per_pixel'] == 4)
            {
                $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
                if (($P*2)%2 == 0) $COLOR[1] = ($COLOR[1] >> 4) ; else $COLOR[1] = ($COLOR[1] & 0x0F);
                $COLOR[1] = $PALETTE[$COLOR[1]+1];
            }
            elseif ($BMP['bits_per_pixel'] == 1)
            {
                $COLOR = unpack("n",$VIDE.substr($IMG,floor($P),1));
                if     (($P*8)%8 == 0) $COLOR[1] =  $COLOR[1]        >>7;
                elseif (($P*8)%8 == 1) $COLOR[1] = ($COLOR[1] & 0x40)>>6;
                elseif (($P*8)%8 == 2) $COLOR[1] = ($COLOR[1] & 0x20)>>5;
                elseif (($P*8)%8 == 3) $COLOR[1] = ($COLOR[1] & 0x10)>>4;
                elseif (($P*8)%8 == 4) $COLOR[1] = ($COLOR[1] & 0x8)>>3;
                elseif (($P*8)%8 == 5) $COLOR[1] = ($COLOR[1] & 0x4)>>2;
                elseif (($P*8)%8 == 6) $COLOR[1] = ($COLOR[1] & 0x2)>>1;
                elseif (($P*8)%8 == 7) $COLOR[1] = ($COLOR[1] & 0x1);
                $COLOR[1] = $PALETTE[$COLOR[1]+1];
            }
            else
                return FALSE;
            imagesetpixel($res,$X,$Y,$COLOR[1]);
            $X++;
            $P += $BMP['bytes_per_pixel'];
        }
        $Y--;
        $P+=$BMP['decal'];
    }

    fclose($f1);

    return $res;
}

function resize_image($picture ,$type, $w, $h,$crop = FALSE)
{

    if(filesize($picture)>=500000){
        list($width, $height) = getimagesize($picture);
        $r = $width / $height;
        if ($crop) {
            if ($width > $height) {
                $width = ceil($width - ($width * abs($r - $w / $h)));
            } else {
                $height = ceil($height - ($height * abs($r - $w / $h)));
            }
            $newwidth = $w;
            $newheight = $h;
        } else {
            if ($w / $h > $r) {
                $newwidth = $h * $r;
                $newheight = $h;
            } else {
                $newheight = $w / $r;
                $newwidth = $w;
            }
        }
        if ($type == "image/jpeg") {
            $src = imagecreatefromjpeg($picture);

            $dst = imagecreatetruecolor($newwidth, $newheight);

            $bg_color = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefill($dst, 0, 0, $bg_color);
            imagesavealpha($dst, true);

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imageinterlace($dst, true);
            imagejpeg($dst, $picture, 100);
            imagedestroy($src);
            imagedestroy($dst);

        } elseif ($type == "image/png") {
            $src = imagecreatefrompng($picture);

            $dst = imagecreatetruecolor($newwidth, $newheight);

            $bg_color = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefill($dst, 0, 0, $bg_color);
            imagesavealpha($dst, true);

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imageinterlace($dst, true);
            imagejpeg($dst, $picture, 100);
            imagedestroy($src);
            imagedestroy($dst);

        } elseif ($type == "image/gif") {
            $src = imagecreatefromgif($picture);

            $dst = imagecreatetruecolor($newwidth, $newheight);

            $bg_color = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefill($dst, 0, 0, $bg_color);
            imagesavealpha($dst, true);

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imageinterlace($dst, true);
            imagejpeg($dst, $picture, 100);
            imagedestroy($src);
            imagedestroy($dst);

        } elseif ($type == "image/bmp") {
            $src = ImageCreateFromBMP( $picture);

            $dst = imagecreatetruecolor($newwidth, $newheight);

            $bg_color = imagecolorallocatealpha($dst, 255, 255, 255, 127);
            imagefill($dst, 0, 0, $bg_color);
            imagesavealpha($dst, true);

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
            imageinterlace($dst, true);
            imagejpeg($dst, $picture, 100);
            imagedestroy($src);
            imagedestroy($dst);

        }

    }
}

?>