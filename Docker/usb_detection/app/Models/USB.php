<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class USB extends Model
{
    protected $table = 'usbs';

    public function files()
    {
        return $this->hasMany(File::class);
    }
}
