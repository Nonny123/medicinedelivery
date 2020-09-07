<?php

class MedicalProfessional extends Eloquent
{
	protected $table = 'ed_professional';
	public $timestamps = false;

/**
* Professional Related User
* @return mixed
*/
    public function user()
    {
        return $this->hasOne('User', 'user_id', 'id')->where('user_type_id', '=', UserType::MEDICAL_PROFESSIONAL())->first();
    }
}
