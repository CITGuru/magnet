<?php
class Main
{
    function __construct($dbhost,$dbname,$dbuser,$dbpass)
    {
        global $con, $pic;
    $con = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8",$dbuser,$dbpass);
    }
    static function randomString($len=22)
    {
        return str_shuffle(substr('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',0,$len));
    }
    public static function setUser($name,$id,$type,$logged='True')
    {
        if($logged=='False')
        {
            $_SESSION['user']=$id;
            $_SESSION['type']=$type;
            return true;
        }
        else
        {
            if(setcookie('user',$id,time()+60*60*24*7,'/',$_SERVER['HTTP_HOST'],NULL,TRUE))
            {
                return true;
            }
        }
    }
    public static function login($main_table, array $credents, array $values)
    {
        if(!in_array('',$credents)&&!in_array('',$values))
        {
            global $con;
            $columns = implode(",",$credents);
            $login_col = $credents[0];
            $password_col = $credents[1];
            $loggedin = $credents[3];
            $login = $values[0];
            $password = $values[1];
            $log=$con->prepare("select $columns from $main_table where $login_col=:login limit 1");
            $log->execute(array(':login'=>$login));
            if($logRes=$log->fetch())
            {
                $email=$logRes[$login_col];
                $pass=$logRes[$password_col];
                $aid=$logRes['id'];
                if($pass==crypt($password,$pass))
                {
                    if(Main::setUser('user',$aid,$main_table,$loggedin))
                    {
                    return "true";
                }
                }
            }
            else
            {
                return 'login-error';
            }
        }
        
    }
}
class CRUD
{
	public $conn = null;
	public function __construct()
	{
		global $con;
		$this->conn = $con;
	}
	public function insert($table,array $fields,array $value)
	{
		for($i=0;$i<count($value);$i++)
		{
			$val[]="?";
		}
		$insert = $this->conn->prepare("insert into $table(".implode(",",$fields).") values (".implode(",",$val).")");
		return $insert->execute($value);
	}
}
class PicUpload
{
    public function __construct($file_name,$thumb_square_size,$file_size=1024,$max_image_size,$thumb_prefix,$destination_folder,$jpeg_quality,$min_width=200,$min_height=200)
    {
        global $msg,$picx,$c_pix;
        $this->thumb_square_size = $thumb_square_size;
        $this->max_image_size = $max_image_size;
        $this->thumb_prefix = $thumb_prefix;
        $this->destination_folder = $destination_folder;
        $this->jpeg_quality = $jpeg_quality;
        $this->min_width = $min_width;
        $this->min_height = $min_height;
        $this->filesize = $file_size;
    /*
        //File Upload
        ############ Configuration ##############
        $this->$thumb_square_size      = 200; //Thumbnails will be cropped to 200x200 pixels
        $this->$max_image_size         = 600; //Maximum image size (height and width)
        $this->$thumb_prefix           = "thumb_"; //Normal thumb Prefix
        $this->$destination_folder     = 'prof_images/'; //upload directory ends with / (slash)
        $this->$jpeg_quality           = 90; //jpeg quality
        ##########################################
        */

        if(isset($_FILES[$file_name]) && is_uploaded_file($_FILES[$file_name]['tmp_name'])){
    $image_name = $_FILES[$file_name]['name']; //file name
    $image_size = $_FILES[$file_name]['size']; //file size
    $image_temp = $_FILES[$file_name]['tmp_name']; //file temp
    $image_size_info    = getimagesize($image_temp); //get image size
    if($image_size>$file_size)
    {
        $cmg[]='File too large. The maximum file size is:'.($file_size/(1024*1024)).' MB';
    }
    
    if($image_size_info){
        $image_width        = $image_size_info[0]; //image width
        $image_height       = $image_size_info[1]; //image height
        if($image_width<$min_width||$image_height<$min_height)
        {
            $cmg[] = "Please provide a valid image. Mininum image size is $min_width X $min_height px";
        }
        $image_type         = $image_size_info['mime']; //image type

    }else{
        $cmg[]="Make sure image file is valid!";
    }

    //switch statement below checks allowed image type 
    //as well as creates new image from given file 
    switch($image_type){
        case 'image/png':
            $image_res =  imagecreatefrompng($image_temp); break;
        case 'image/gif':
            $image_res =  imagecreatefromgif($image_temp); break;           
        case 'image/jpeg': case 'image/jpg':
            $image_res = imagecreatefromjpeg($image_temp); break;
        default:
            $image_res = false;
    }

    if($image_res){
        //Get file extension and name to construct new file name 
        $image_info = pathinfo($image_name);
        $image_extension = in_array(strtolower($image_info["extension"]),['png','jpg','jpeg','gif'])?strtolower($image_info["extension"]):'png'; //image extension
        $image_name_only = strtolower($image_info["filename"]);//file name only, no extension
        
        //create a random name for new image (Eg: fileName_293749.jpg) ;
        $new_file_name = $image_name_only. '_' .  preg_replace("/[\W.]+/is", '', microtime(true)) . '.' . $image_extension;
        
        //folder path to save resized images and thumbnails
        $thumb_save_folder  = $destination_folder .'thumb_' . $new_file_name;
        $image_save_folder  = $destination_folder . $new_file_name;
        
        //call normal_resize_image() function to proportionally resize image
        if($this->normal_resize_image($image_res, $image_save_folder, $image_type, $max_image_size, $image_width, $image_height, $jpeg_quality))
        {
            //call crop_image_square() function to create square thumbnails
            if(!$this->crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality))
            {
                $cmg[]='Sorry, Error occured processing your file upload, please try another file!';
            }
            
            /* We have succesfully resized and created thumbnail image
            We can now output image to user's browser or store information in the database*/
            $picx = $new_file_name;
        }
        else
        {
            $cmg[]='Error, uploading an idea picture';
        }
        
        imagedestroy($image_res); //freeup memory
    }
}
else
    {
        $cmg[]='Image file is Missing!'; // output error when above checks fail.
    }
        //File Upload
    if(!$c_pix) $msg = array_merge($msg,$cmg);
}
 ##### Saves image resource to file ##### 
private function save_image($source, $destination, $image_type, $quality){
  switch(strtolower($image_type)){//determine mime type
    case 'image/png': 
      imagepng($source, $destination); return true; //save png file
      break;
    case 'image/gif': 
      imagegif($source, $destination); return true; //save gif file
      break;          
    case 'image/jpeg': case 'image/pjpeg': 
      imagejpeg($source, $destination, $quality); return true; //save jpeg file
      break;
    default: return false;
  }
}

#####  This function will proportionally resize image ##### 
private function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality){
  
  if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
  
  //do not resize if image is smaller than max size
  if($image_width <= $max_size && $image_height <= $max_size){
    if($this->save_image($source, $destination, $image_type, $quality)){
      return true;
    }
  }

  //Construct a proportional size of new image
  $image_scale  = min($max_size/$image_width, $max_size/$image_height);
  $new_width    = ceil($image_scale * $image_width);
  $new_height   = ceil($image_scale * $image_height);
  
  $new_canvas   = imagecreatetruecolor( $new_width, $new_height ); //Create a new true color image
  
  //Copy and resize part of an image with resampling
  if(imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)){
    $this->save_image($new_canvas, $destination, $image_type, $quality); //save resized image
  }

  return true;
}

##### This function corps image to create exact square, no matter what its original size! ######
private function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
  if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
  
  if( $image_width > $image_height )
  {
    $y_offset = 0;
    $x_offset = ($image_width - $image_height) / 2;
    $s_size   = $image_width - ($x_offset * 2);
  }else{
    $x_offset = 0;
    $y_offset = ($image_height - $image_width) / 2;
    $s_size = $image_height - ($y_offset * 2);
  }
  $new_canvas = imagecreatetruecolor( $square_size, $square_size); //Create a new true color image
  
  //Copy and resize part of an image with resampling
  if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
    $this->save_image($new_canvas, $destination, $image_type, $quality);
  }

  return true;
}
}
// public function __construct($file_name,$thumb_square_size,$max_image_size,$thumb_prefix,$destination_folder,$jpeg_quality,$min_width=200,$min_height=200)
class vidUpload
{
    public function __construct($file_name,$file_size=1024,$destination_folder)
    {
        global $msg,$vidx,$c_vid;
        $this->file_name = $file_name;
        $this->file_size = $file_size;
        $this->destination_folder = $destination_folder;
        $this->process();
        // die($this->file_name." ".$this->file_size." ".$this->destination_folder);
    }

    //handle files
    public function process()
    {
        global $msg,$vidx,$c_vid;
        if(isset($_FILES[$this->file_name])&&is_uploaded_file($_FILES[$this->file_name]['tmp_name']))
        {
            $file_size = $_FILES[$this->file_name]['size'];
            $file_info = pathinfo($_FILES[$this->file_name]['name']);
            $file_name = strtolower($file_info['filename']);
            $extension = strtolower($file_info['extension']);
            $allowed_ext = ['mp4','ogg','wmv'];
            $tmp_name = $_FILES[$this->file_name]['tmp_name'];

            // die("$file_size ".$file_info['filename']." ".$file_info['extension']." $extension $tmp_name");
            //Check if file extension is supported
            if(!in_array($extension, $allowed_ext))
            {
                $cmg[]='Video format not supported!';
            }
            //Check if file is a valid video using getId3
            $mimeType = $this->GetMIMEtype($tmp_name);
            if(!preg_match("/^video\/.+$/", $mimeType))
            {
                $cmg[]='Sorry, this is not a valid video file';
            }
            //Get video length using getId3
            $duration = $this->get_duration($tmp_name);
            list($d_min,$d_secs) = explode(":",$duration);
            $duration_time = ($d_min*60) + $d_secs;
            if($duration_time<60 || $duration_time>120)
            {
                $cmg[]='Please upload a pitch video between 1-2 minutes length';
            }
            //Get filename randomly to avoid filename conflict
            $new_file_name = $file_name . '_' .  preg_replace("/[\W.]+/is", '', microtime(true)) . '.' . $extension;
            // print_r($cmg);
            if(count($cmg)==0)
            {
                if(move_uploaded_file($tmp_name, $this->destination_folder.$new_file_name))
                {
                    $vidx = $new_file_name;
                }
                else
                {
                    $cmg[]='Sorry, error occured video not uploaded!';
                }
            }


        }
        else
        {
            $cmg[]='Sorry error occured, video not uploaded!';
            return false;
        }
    if(!$c_vid) $msg = array_merge($msg,$cmg);
    }
    public function get_duration($filename){
    $getID3 = new getID3;

    $file = $getID3->analyze($filename);

    $duration_string = $file['playtime_string'];

    // Format string to be 00:00:00
    return $duration_string;
}
public function GetMIMEtype($filename) {
    $filename = realpath($filename);
    if (!file_exists($filename)) {
        echo 'File does not exist: "'.htmlentities($filename).'"<br>';
        return '';
    } elseif (!is_readable($filename)) {
        echo 'File is not readable: "'.htmlentities($filename).'"<br>';
        return '';
    }

    // include getID3() library (can be in a different directory if full path is specified)
    // Initialize getID3 engine
    $getID3 = new getID3;

    $DeterminedMIMEtype = '';
    if ($fp = fopen($filename, 'rb')) {
        $getID3->openfile($filename);
        if (empty($getID3->info['error'])) {

            // ID3v2 is the only tag format that might be prepended in front of files, and it's non-trivial to skip, easier just to parse it and know where to skip to
            getid3_lib::IncludeDependency(GETID3_INCLUDEPATH.'module.tag.id3v2.php', __FILE__, true);
            $getid3_id3v2 = new getid3_id3v2($getID3);
            $getid3_id3v2->Analyze();

            fseek($fp, $getID3->info['avdataoffset'], SEEK_SET);
            $formattest = fread($fp, 16);  // 16 bytes is sufficient for any format except ISO CD-image
            fclose($fp);

            $DeterminedFormatInfo = $getID3->GetFileFormat($formattest);
            $DeterminedMIMEtype = $DeterminedFormatInfo['mime_type'];

        } else {
            echo 'Failed to getID3->openfile "'.htmlentities($filename).'"<br>';
        }
    } else {
        echo 'Failed to fopen "'.htmlentities($filename).'"<br>';
    }
    return $DeterminedMIMEtype;
}
}
?>