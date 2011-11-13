
<?php
if(isset($_FILES['upload']))
{ 
			if (!getimagesize($_FILES['upload']['tmp_name']))
			{ echo "Invalid Image File...";
			exit();
			}
			
     $dossier = 'upload/images/';
     $fichier = basename($_FILES['upload']['name']);
     if(move_uploaded_file($_FILES['upload']['tmp_name'], $dossier . $fichier))
     {
          echo 'Upload successful !';
     }
     else
     {
          echo 'Upload error !';
     }
}
?>

