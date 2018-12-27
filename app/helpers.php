<?php

/**
 * Get the file name.
 */
 function getFileName($fileID, $file)
 {
   $destinationPath = public_path() . '/images';

   switch ($fileID) {
    case 'profile_image':
      $destinationPath = $destinationPath . '/user/profile_image';
      break;
    case 'category_image':
      $destinationPath = $destinationPath . '/category';
      break;


    default:
       //code
       break;
   }

   $fileName = time() . '.' . $file->getClientOriginalExtension();
   $file->move($destinationPath, $fileName);

   return $fileName;
 }
