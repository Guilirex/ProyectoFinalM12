<?php

    namespace App\Models;

    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;
    use Spatie\Permission\Traits\HasRoles;

    // use Spatie\Permission\Traits\HasRoles;

    class User extends Authenticatable
    {   
        use \Backpack\CRUD\app\Models\Traits\CrudTrait;

        use HasApiTokens, HasFactory, Notifiable, HasRoles;
        use CrudTrait;
        
        public $guard_name = 'web';

        // use HasRoles;
        protected $fillable = [
            'name',
            'email',
            'password',
            'lastname',
            'secound_sourname',
            'file_id',
            'route_id',
            'author_id'
        ];
        protected $hidden = [
            'password',
            'remember_token',
        ];

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }
    public function route()
    {
        return $this->belongsTo(Route::class);
    }
    public function file()
    {
        return $this->belongsTo(File::class);
    }

    // public function routes()
    // {
    //     return $this->belongsToMany(Route::class, 'inscriptions');
    // }
    
}
