<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class Task extends Model
{
    /** @use HasFactory<\Database\Factories\TaskFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'user_id',
        'department_id',
        'assigned_user_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
    public function primaryDepartment()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function departments()
    {
        return $this->belongsToMany(Department::class);
    }
}
