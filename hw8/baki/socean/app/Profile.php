<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Profile extends Model
{
    protected $guarded = [];

    // public function profileImage(){
    //     $imagePath = ($this->image) ? $this->image : 'C:\Users\MuhammedBakiAlmacı\Desktop\baki almacı\PROJECTS\Web\socean\public\storage\profile\3dWNZpHHHA8eN044whypJhD9JODMhac1e4XYgZaq.jpeg';
    //     return 'storage/' . $imagePath;
    // }

    public function user(){
        return $this->belongsTo(User::class);
    }
    
}
