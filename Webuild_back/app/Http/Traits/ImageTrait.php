<?php

namespace App\Http\Traits;

trait ImageTrait{

    public function AddImage($FolderName = "Images", $SupFolderName = "Img" , $img)
    {
        $imagePath = time() . rand() . $SupFolderName . '.'. $img->extension();
        $img->move(public_path( $FolderName.'/'.$SupFolderName), $imagePath);
        return $FolderName.'/'.$SupFolderName.'/'.$imagePath;
    }

    public function UpdateImage($FolderName = "Images", $SupFolderName = "Img" , $img , $oldimg)
    {
        unlink(public_path($oldimg));
        $imagePath = time() . rand() . $SupFolderName .  '.'.  $img->extension();
        $img->move(public_path( $FolderName.'/'.$SupFolderName), $imagePath);
        return $FolderName.'/'.$SupFolderName.'/'.$imagePath;
    }


}
