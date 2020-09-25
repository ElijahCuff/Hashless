<?php
if (hasParam('submit'))
{
deleteAll();
mkdir("uploads");

$file = $_FILES["file"];
$uploaded_file = "uploads/".basename($_FILES["file"]["name"]);
$merge_file = "uploads/new_".basename($_FILES["file"]["name"]);

  if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploaded_file)) {
    echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded.";
if (mergeFiles($merge_file,$uploaded_file))
    {
        echo "The file ". basename($_FILES["file"]["name"]). " has been merged.";
        delete($uploaded_file);
        redirect($merge_file);
     }
 else
    {
echo "The file ". basename($_FILES["file"]["name"]). " has failed merging.";
delete($uploaded_file);
    }
    
  } else {
    echo "Sorry, there was an error uploading your file.";
  }



}
else
{
echo '<!DOCTYPE html>
<html>
<body>

<form method="post" enctype="multipart/form-data" action="">
  Select file to send to worker script:
  <input type="file" name="file" id="file">
  <input type="submit" value="File 2 Upload" name="submit">
</form>

</body>
</html>';

}

function mergeFiles($outPutPath, $filePath1) {
$fp = fopen($outPutPath, 'w');
     $filesize1 = filesize($filePath1);
     $fp1 = fopen($filePath1, 'rb');
     $fileBinary1 = fread($fp1, $filesize1);
     fclose($fp1);
     $filesize2 = filesize('test.bin');
     $fp2 = fopen('test.bin', 'rb');
     $fileBinary2 = fread($fp2, $filesize2);
     fclose($fp2);
$write = fwrite($fp, $fileBinary1);
$write2 = fwrite($fp, $fileBinary2);
fclose($fp);
     if ($write === false) {
            return $false;
        }
        else {
             return true;
        }
}


function hasParam($param) 
{
   if (array_key_exists($param, $_REQUEST))
    {
       return array_key_exists($param, $_REQUEST);
    }
}
function redirect($url)
{
   ob_start();
   header("Location: $url");
   exit();
   ob_end_flush();
}

function delete($file)
{
      if (file_exists($file)) {
        unlink($file);
        return true;
    } else {
        return false;
    }
}
function deleteAll()
{
$files = glob('uploads/*');
foreach($files as $file){ 
  if(is_file($file))
    unlink($file);
}
}
?>
