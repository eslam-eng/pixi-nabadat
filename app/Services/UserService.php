<?php

namespace App\Services;

use App\Models\User;
use App\QueryFilters\UsersFilter;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class UserService extends BaseService
{

    public function getAll(array $where_condition = [])
    {
        $users = $this->queryGet($where_condition);
        return $users->get();
    }

    public function queryGet(array $where_condition = []): Builder
    {
        $users = User::query();
        return $users->filter(new UsersFilter($where_condition));
    }

    public function store($data)
    {

        $data['password'] = bcrypt($data['password']);
        $data['date_of_birth'] = isset($data['date_of_birth'])? Carbon::parse($data['date_of_birth']):null;
        $data['is_active']  = isset($data['is_active'])  ? 1 : 0;
        return User::create($data);

    } //end of create

    public function find($id , $withRelations = []): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|Builder|bool|array
    {
        $user = User::with($withRelations)->find($id);
        if ($user)
            return $user;
        return false;
    }

    public function changeStatus($id)
    {
        $user = $this->find($id);
        $user->is_active = !$user->is_active;
        $user->save();
    }//end of changeStatus

    public function delete($id)
    {
        $user=$this->find($id);
        if ($user)
            return $user->delete();
        return false;
    }//end of delete

    public function update($id , $data)
    {
        $data['password'] = bcrypt($data['password']);
        $data['date_of_birth'] = Carbon::parse($data['date_of_birth']);
        isset($data['is_active'])  ?   $data['is_active']=1 : $data['is_active']= 0;


        $user=User::find($id);
        if ($user)
            $user->update($data);
        return false;
    }//end of update

    public function updateOrCreateNabadatWallet(int $user_id ,$package): bool
    {
        $withRelation = ['nabadatWallet'];
        $user = $this->find($user_id,$withRelation);
        if (!$user)
            return false ;
        $old_pulses = $user->nabadatWallet->total_pulses?? 0 ;
        $total_pulses = $old_pulses+$package->num_nabadat ;
        $user->nabadatWallet()->updateOrCreate(['total_pulses'=>$total_pulses]);
        return true ;
    }
}
