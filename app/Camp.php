<?php

namespace App;

use App\Camp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Camp extends Model
{

    protected $dates = ['from', 'to', 'registration_start', 'registration_end'];

    public function users()
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot('status', 'contribution', 'laptop', 'tos', 'consent', 'comment', 'admin_comment');
    }

    public function getFreeSpotsAttribute()
    {
            $registered = $this->CampUser('not_cancelled')->count();
            return $this->max - $registered;
    }

    public function getTotalParticipantsAttribute()
    {
        return $this->CampUser('not_cancelled')->count();
    }

    public function getRegisteredParticipantsAttribute()
    {
        return $this->CampUser('registered')->count();
    }

    public function getConfirmedParticipantsAttribute()
    {
        return $this->CampUser('confirmed')->count();
    }

    public function getStatusAttribute()
    {
        if ($this->free_spots < 1){
            return 'Warteliste';
        }
        else {
            return 'Freie Plätze';
        }
    }

    public function getFemaleParticipantsAttribute()
    {
        return $this->users()->where('gender', '=', 'f')->count();
    }

    public function getFemaleRatioAttribute()
    {
        if ($this->users()->count() == 0){
            return 0;
        }
        else {
            return round($this->female_participants * 100 / $this->users()->count());
        }
        
    }

    public function getOrderedLaptopsAttribute()
    {
        return $this->CampUser('not_cancelled', 'laptop', '<>', 'own')->count();
    }

    private function CampUser($status, $column = null, $comparator = null, $value = null) {
        
        switch ($status) {

            case 'not_cancelled':
                $camp_status = 'cancelled';
                $camp_status_comparator = '<>';
                break;

            case 'registered':
                $camp_status = 'registered';
                $camp_status_comparator = '=';
                break;

            case 'confirmed':
                $camp_status = 'confirmed';
                $camp_status_comparator = '=';
                break;

            case 'cancelled':
                $camp->status = 'cancelled';
                $camp_status_comparator = '=';
                break;
            
            default:
                $camp_status = 'cancelled';
                $camp_status_comparator = '<>';
                break;
        }

        if (!isset($column)){
          $options = [
            ['status', $camp_status_comparator, $camp_status],
            ['camp_id','=', $this->id],
        ];  
        }

        else {
          $options = [
            ['status', $camp_status_comparator, $camp_status],
            ['camp_id','=', $this->id],
            [$column, $comparator, $value],
        ];  
        }
        

        return DB::table('camp_user')->where($options);
    }

    public static function getRunningCamps() {
        return Camp::all()
        ->where('camp_status','open')
        ->where('to', '>=', Carbon::now())
        ->where('from', '<=', Carbon::now())
        ->sortBy('from');
    }

    public static function getRegisterableCamps() {
        return Camp::all()
        ->where('camp_status','open')
        ->where('registration_end', '>=', Carbon::now())
        ->where('registration_start', '<=', Carbon::now())
        ->sortBy('from');
    }

    public static function getFutureCamps() {
        return Camp::all()
        ->where('camp_status', 'open')
        ->where('to', '>=', Carbon::now())
        ->sortBy('from');
    }
}
